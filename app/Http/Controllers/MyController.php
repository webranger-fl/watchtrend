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
      return view('project.single', compact('project'));
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
        }
        else {
          ProjectPhrase::create(['project_id' => $project->id, 'phrase_id' => $dbPhrase->id]);
        }
      }
      return redirect()->route('my.project', ['project' => $project->id]);
    }
    
}
