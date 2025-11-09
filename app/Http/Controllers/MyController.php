<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seo;
use App\Models\Project;
use App\Models\WordstatPhrase;
use App\Models\ProjectPhrase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
//use Stevebauman\Location\Facades\Location;
use App\Helpers\Telegram;

class MyController extends Controller
{
    public function index()
    {
      $projects = Project::orderBy('id')->get();

      return view('my', compact('projects'));

    }

    public function project(Project $project)
    {
      //dd($project);
      //dd($project->phrases);
      $project = Project::where(['id' => $project->id])->with('phrases.stats')->withCount('phrases')->first();
      $phrases = WordstatPhrase::whereHas('projects', function($q) use ($project) {
        $q->where('projects.id', '=', $project->id);
      })->has('stats')->get();
      //dd($phrases);
      return view('project.single', compact('project', 'phrases'));
    }

    public function projectData(Project $project)
    {
      $phrases = WordstatPhrase::whereHas('projects', function($q) use ($project) {
        $q->where('projects.id', '=', $project->id);
      })->has('stats')->get();
      $stats = [];
      foreach($phrases as $ph) {
        //$stats[] = $ph->stats;
        $innerStats = [];
        foreach($ph->stats as $stat) {
          $date = mb_ucfirst(ruMonth(strtotime($stat->date))) . " " . date('Y', strtotime($stat->date));
          $date2 = mb_ucfirst(ruMonth(strtotime($stat->date))) . " " . date('y', strtotime($stat->date));
          //dd($date2);
          $innerStats[] = ['month' => $date, 'shortMonth' => $date2, 'value' => $stat->value];
        }
        $stats[] = $innerStats;
      }
      return ['stats' => $stats];
    }

    public function addProject(Request $req)
    {
      //dd($req->all());
      $req->validate([
        'name' => 'required|max:255'
      ]);

      Project::create(['name' => $req->name, 'description' => $req->description]);

      return redirect()->route('my');
    }

    public function addToProject(Request $req, Project $project)
    {
      //dd($req->all());
      $phrases = preg_split("/\r\n|\r|\n/", $req->phrases);
      //dd($phrases);
      foreach($phrases as $p) {
        $dbPhrase = WordstatPhrase::where(['phrase' => $p])->first();
        if(!$dbPhrase) {
          // для новых фраз в очередь кидать запрос за данными
          DB::transaction(function () use ($p, $project) {
            $slug = translit($p);
            $phrase = WordstatPhrase::create(['phrase' => $p, 'slug' => $slug]);
            ProjectPhrase::create(['project_id' => $project->id, 'phrase_id' => $phrase->id]);
            \App\Jobs\FetchPhraseData::dispatch($phrase);
          });        
        }
        else {
          ProjectPhrase::create(['project_id' => $project->id, 'phrase_id' => $dbPhrase->id]);
        }
      }
      return redirect()->route('my.project', ['project' => $project->id])
        ->with('msg', 'Фразы добавлены. Новые фразы отобразятся через 1-2 минуты, когда для них добавятся данные. Перезагрузите страницу');
    }
    
}
