<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Sale;
use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Support\Facades\Log;

class GenSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gen-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = public_path() . '/sitemap.xml';
        //dd($path);
        $domain = 'astana.';
        $scheme = 'https';
        if(config('app.city') === 'Алматы') $domain = '';
        $domain .= 'expertremonta.kz';
        $baseUrl = "$scheme://$domain";

        //SitemapGenerator::create("http://$domain")->writeToFile($path);

        $lastSaleMod = date('c', strtotime(\App\Models\Sale::max('updated_at')));
        $lastReviewMod = date('c', strtotime(\App\Models\Review::max('updated_at')));
        $lastVacancyMod = date('c', strtotime(\App\Models\Vacancy::max('updated_at')));
        $lastBlogMod = date('c', strtotime(\App\Models\Blog::max('updated_at')));

        //dd($lastReviewMod);

        $sitemapIndexContent = "<urlset xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd' xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";


        $sitemapContent = "<urlset xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd' xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>	
        <url>
            <loc>$scheme://$domain</loc>
            <lastmod>$lastSaleMod</lastmod>
            <changefreq>weekly</changefreq>
            <priority>1</priority>
	    </url>
        <url>
            <loc>$scheme://$domain/uslugi</loc>
            <lastmod>2024-02-05T09:42:17+00:00</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
	    </url>";

        foreach(\App\Models\service::all() as $i) {
            $date = date('c', strtotime($i->updated_at));
            $sitemapContent .= "<url>
            <loc>$scheme://$domain/uslugi/$i->url</loc>
            <lastmod>$date</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
	    </url>";
        }

        foreach(\App\Models\category::active()->with('service')->get() as $i) {
            $date = date('c', strtotime($i->updated_at));
            if(!$i->service) continue;
            $sUrl = $i->service->url;
            $sitemapContent .= "<url>
            <loc>$scheme://$domain/uslugi/$sUrl/$i->url</loc>
            <lastmod>$date</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
	    </url>";
        }

        foreach(\App\Models\Vacancy::all() as $i) {
            $date = date('c', strtotime($i->updated_at));
            $sitemapContent .= "<url>
            <loc>$scheme://$domain/vacancy/$i->url</loc>
            <lastmod>$date</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
	    </url>";
        }

        foreach(\App\Models\VacancyCategory::all() as $i) {
            $date = date('c', strtotime($i->updated_at));
            $sitemapContent .= "<url>
            <loc>$scheme://$domain/vacancies/category/$i->url</loc>
            <lastmod>$date</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.6</priority>
	    </url>";
        }

        $sitemapContent .= "<url>
        <loc>$scheme://$domain/price</loc>
        <lastmod>2024-02-05T09:42:17+00:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
        </url>
        <url>
        <loc>$scheme://$domain/gallery</loc>
        <lastmod>2024-02-05T09:42:17+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
        </url>
        <url>
        <loc>$scheme://$domain/reviews</loc>
        <lastmod>$lastReviewMod</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
        </url>
        <url>
        <loc>$scheme://$domain/contact</loc>
        <lastmod>2024-02-05T09:42:17+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
        </url>
        <url>
        <loc>$scheme://$domain/franchise</loc>
        <lastmod>2024-02-05T09:42:17+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
        </url>
        <url>
        <loc>$scheme://$domain/vacancies-office</loc>
        <lastmod>2024-02-05T09:42:17+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
        </url>
        <url>
        <loc>$scheme://$domain/vacancies-landing</loc>
        <lastmod>2024-02-05T09:42:17+00:00</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
        </url>
        <url>
        <loc>$scheme://$domain/vacancies</loc>
        <lastmod>$lastVacancyMod</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
        </url>
        <url>
        <loc>$scheme://$domain/blog</loc>
        <lastmod>$lastBlogMod</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
        </url>
        ";
    
        $sitemapContent .= "</urlset>";

        file_put_contents(public_path() . '/sitemaps/index.xml', $sitemapContent);

        $sitemapIndexContent .= "<url>
            <loc>$scheme://$domain/sitemaps/index.xml</loc>
            <lastmod>$lastBlogMod</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
	      </url>";

        // лог делать в другой файл, для крон действий
        //Log::debug('Sitemap are successfully generated');
        Log::channel('cron')->debug('Index sitemap is successfully generated');

         $sitemapContent = "<urlset xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd' xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";
          // категории блога верхние, с вложенными
            foreach(\App\Models\BlogCategory::whereNull('parent_id')->with('childs.childs')->get() as $i) {
              $date = date('c', strtotime($i->updated_at));
              $sitemapContent .= "<url>
              <loc>$baseUrl/blog/category/$i->url</loc>
              <lastmod>$date</lastmod>
              <changefreq>weekly</changefreq>
              <priority>0.8</priority>
        </url>";
              foreach($i->childs as $child) {
                  $date = date('c', strtotime($child->updated_at));
                  $sitemapContent .= "<url>
                      <loc>$baseUrl/blog/category/$i->url/$child->url</loc>
                      <lastmod>$date</lastmod>
                      <changefreq>weekly</changefreq>
                      <priority>0.8</priority>
                  </url>";
                  foreach($child->childs as $deepChild) {
                      $date = date('c', strtotime($deepChild->updated_at));
                      $sitemapContent .= "<url>
                          <loc>$baseUrl/blog/category/$i->url/$child->url/$deepChild->url</loc>
                          <lastmod>$date</lastmod>
                          <changefreq>weekly</changefreq>
                          <priority>0.8</priority>
                      </url>";
                  }
              }
          }
         $sitemapContent .= "</urlset>";
         file_put_contents(public_path() . '/sitemaps/blog_categories.xml', $sitemapContent);
         Log::channel('cron')->debug('Blog categories sitemap is successfully generated');

         $sitemapIndexContent .= "<url>
            <loc>$scheme://$domain/sitemaps/blog_categories.xml</loc>
            <lastmod>$lastBlogMod</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
	      </url>";


         $sitemapContent = "";
         // сами посты, опубликованные
         $posts = \App\Models\Blog::active()/*->orderBy('id')*/->latest()->with('category.parent.parent')->get();
         $count = count($posts);
         foreach($posts as $idx => $post) {
            $date = date('c', strtotime($post->updated_at));
            $routeParams = $post->genRouteParams(true);
            if($idx % 100 === 0) $sitemapContent = "<urlset xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd' xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";

            $sitemapContent .= "<url>
                        <loc>$baseUrl/blog/$routeParams</loc>
                        <lastmod>$date</lastmod>
                        <changefreq>weekly</changefreq>
                        <priority>0.8</priority>
            </url>";
            // /*|| $count - 1 === $idx*/
            if($idx % 100 === 99 && $idx > 0 || $count - 1 === $idx) {
              $sitemapContent .= "</urlset>";
              $iteration = ceil($idx / 100);
              file_put_contents(public_path() . "/sitemaps/blog_posts$iteration.xml", $sitemapContent);
              $sitemapIndexContent .= "<url>
                <loc>$scheme://$domain/sitemaps/blog_posts$iteration.xml</loc>
                <lastmod>$lastBlogMod</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.9</priority>
            </url>";
            }
        }
        $sitemapIndexContent .= "</urlset>";

        Log::channel('cron')->debug('Blog posts sitemaps are successfully generated');  
        file_put_contents(public_path() . "/sitemap.xml", $sitemapIndexContent);  
        Log::channel('cron')->debug('Root sitemap is successfully generated');      
        
        
    }
}
