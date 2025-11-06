<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Blog;
use App\Models\UserBlogFeedback;

class IndexController extends Controller
{
    public function index()
    {
      // with('category.parent.parent')->latest()->filtered()
        $items=Blog::with('category')->latest()->paginate(20);
        $headline = null;
        $headlineMap = [
          'titles_to_fix' => 'Статьи блога с SEO заголовками неоптимальной длины',
          'desc_to_fix' => 'Статьи блога с SEO описаниями неоптимальной длины',
          'no_desc' => 'Статьи блога без SEO описаний',
          'invalid_headings' => 'Статьи блога с нарушенной иерархией заголовков h2-h3',
          'haslike' => 'Статьи блога которые получили хотя бы 1 лайк от пользователей',
          'hasdislike' => 'Статьи блога которые получили хотя бы 1 дизлайк от пользователей',
          'feedback' => 'Статьи блога с фидбэком от пользователей',
          'duplicates' => 'Статьи блога у которых возможно есть дубли (одинаковые заголовки)',
        ];
        if(request()->filter) $headline = $headlineMap[request()->filter];
        //dd(count($items));
        // аналитика
        $stats = [];
        //$stats['likedPosts'] = Blog::where(['grade' => true])->count();
        //$stats['dislikedPosts'] = Blog::where(['grade' => false])->count();
        //$stats['feedbackPosts'] = Blog::whereNotNull('wishes')->count();
        /*$stats['likedPosts'] = Blog::has('feedbackLike')->count();
        $stats['dislikedPosts'] = Blog::has('feedbackDislike')->count();
        $stats['feedbackPosts'] = Blog::has('feedbackText')->count();

        $filters = [ 
          'haslike' => 'поставлен лайк', 
          'hasdislike' => 'поставлен дизлайк', 
          'feedback' => 'написан фидбэк',  
        ];

        //$blogActivePosts = Blog::select(['id', 'seo_title_ru', 'meta_desc_ru'])->where(['active' => true])->get();
        $stats['titles_to_fix'] = 0;
        $stats['desc_to_fix'] = 0;

        $stats['titles_to_fix'] = Blog::badTitles()->count();
        $stats['desc_to_fix'] = Blog::badDescs()->count();
        $stats['no_desc'] = Blog::where(['active' => true])->whereNull('meta_desc_ru')->count();
        $stats['invalid_headings'] = Blog::badHeadings()->count();
        $stats['duplicates'] = Blog::where(['active' => true])->groupBy('title_ru')->havingRaw("COUNT(*) > 1")->count();*/

        return view('admin.blog.index', compact('items', 'stats', 'headline'));
    }

    public function stats(Request $req)
    {
      //dd($req->query());
      $from = $req->from;
      $to = $req->to;
      //dd($to);

      $byDay = Blog::lastTwoWeeks()
      ->select(DB::raw('DATE(created_at) as day, COUNT(*) as count'))
      ->groupBy(DB::raw('DATE(created_at)'))
      //->orderByDesc('day')
      ->get();
      //dd($byDay);

      $stats = [];
      $stats['lastTwoWeeks'] = Blog::lastTwoWeeks()->count();
      $stats['perDayLastTwoWeeks'] = round($stats['lastTwoWeeks'] / 14, 1);

      $byDaySelPeriod = null;
      if($from && $to) {
        $byDaySelPeriod = Blog::/*lastTwoWeeks()*/whereBetween(DB::raw('DATE(created_at)'), [$from, $to])
          //whereRaw("DATE(created_at) BETWEEN $from AND $to")
          /*where(function ($query) {
            $query->where('a', '=', 1)
                  ->orWhere('b', '=', 1);
          })*/
          ->select(DB::raw('DATE(created_at) as day, COUNT(*) as count'))
          ->groupBy(DB::raw('DATE(created_at)'))
          ->get();
        //dd($byDaySelPeriod);
        $stats['period'] = Blog::whereBetween(DB::raw('DATE(created_at)'), [$from, $to])->count();
        $periodDays = (strtotime($to) - strtotime($from)) / 86400 + 1;
        $stats['perPeriod'] = round($stats['period'] / $periodDays, 1);
      }

      // добавить возможность выбора дат
      $fields = [
        //['title' => 'Начальная дата', 'key' => 'from', 'required' => false, 'type' => 'date'],
        //['title' => 'Конечная дата', 'key' => 'to', 'required' => false, 'type' => 'date'],
      ];

      // и еще нужен линейный с приростом статей
      /*$count = Blog::active()->count();
      $counts = [];
      foreach(range(1, 14) as $idx => $n) {
        if($idx === 0) $counts[] = $count - Blog::anyDate(time() - 86400 * $n)->count();
        else  $counts[] = $counts[$idx-1] - Blog::anyDate(time() - 86400 * $n)->count();
      }
      $counts = array_reverse($counts);*/
      //dd($counts);

      //dd($byDay);

      return view('admin.blog.stats', compact('byDay', 'stats', 'fields', 'byDaySelPeriod', 'from', 'to' /*'counts'*/));
    }

    /*public function showFeedback() {
      $items = UserBlogFeedback::with('post')->paginate(20);

      return view('admin.blog.feedback', compact('items'));
    }*/

    public function showPostFeedback() {
      $post = Blog::where(['id' => request()->blog])->with('feedbacks')->first();
      $items = $post->feedbacks;
      return view('admin.blog.postFeedback', compact('items', 'post'));
    }
}
