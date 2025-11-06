<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Jenssegers\Date\Date;

class Blog extends Model
{
    use HasFactory;
    protected $guarded=[];

    //protected $appends = ['short'];

    /*public function getDateAttribute() {
      $date = new Date($this->created_at);
      return $date->format("d F Y H:i");
    }*/

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    /*public function resolveRouteBinding($value, $field = null) {
        //dd(auth()->id());
        return !(auth()->id())
        ? $this->where([$field => $value, 'active' => true])->firstOrFail()
        : $this->where([$field => $value])->firstOrFail();
    }*/

    public function scopeActive(Builder $query): void
    {
      $query->where(['active' => true]);
    }

    public function scopeArchived(Builder $query): void
    {
      $query->where(['active' => false]);
    }

    public function scopeToday(Builder $query): void
  {
    $query->whereDate('created_at', DB::raw('CURDATE()'));
  }

  public function scopeAnyDate(Builder $query, $date): void
  {
    //$query->whereDate('created_at', date("Y-m-d", strtotime($date)));
    $query->whereDate('created_at', date("Y-m-d", $date));
  }

  public function scopeLastSevenDays($query) {
    return $query->whereDate('created_at', '>', now()->subDays(7));
  }

  public function scopeLastTwoWeeks($query) {
    return $query->whereDate('created_at', '>', now()->subDays(14));
  }

  public function scopeLastMonth($query) {
    return $query->whereDate('created_at', '>', now()->subDays(30));
  }

    public function scopeBadTitles(Builder $query): void
    {
      // OR LENGTH(seo_title_ru) < 50
      $query->where(['active' => true])->whereRaw('CHAR_LENGTH(seo_title_ru) > 65 OR CHAR_LENGTH(seo_title_ru) < 45');
    }

    public function scopeBadDescs(Builder $query): void {
      $query->where(['active' => true])->whereRaw('CHAR_LENGTH(meta_desc_ru) > 160 OR CHAR_LENGTH(meta_desc_ru) < 110');
    }

    public function scopeFiltered(Builder $query): void
    {
      if(request()->query('archive')) $query->where(['active' => false]);
      else $query->where(['active' => true]);
      $f = request()->filter;
      if($f === 'haslike') $query->where(['grade' => true]);
      if($f === 'hasdislike') $query->where(['grade' => false]);
      if($f === 'feedback') $query->whereNotNull('wishes');
    }

    public function genPostUrl() {
      if(!isset($this->category->parent)) return route('blog.postFirst',$this->genRouteParams());
      elseif(!isset($this->category->parent->parent)) return route('blog.post',$this->genRouteParams());
      else route('blog.postDeep',$this->genRouteParams());
    }

    public function genPostRoute() {
      /*if(isset($this->category->parent->parent) && $this->category->parent->parent) {
        return route('blog.postDeep', $this->genRouteParams());
      }
      elseif(isset($this->category->parent) && $this->category->parent) {
        return route('blog.post', $this->genRouteParams());
      }
      else {*/
        return route('blog.postFirst', $this->genRouteParams());
      //}
    }

    // сгенерировать параметры только в виде строки, для сайтмапа, это параметр string
    public function genRouteParams($string = false) {
        $params = [];
        /*if(isset($this->category->parent->parent->url)) {
            $params[]= $this->category->parent->parent->url;
        }
        if(isset($this->category->parent->url)) {
            $params[]= $this->category->parent->url;
        }*/
        $params[]= $this->category->slug;
        $params[]= $this->slug;
        return !$string ? $params : implode('/', $params);
    }

    public function genCategoryRouteParams($full = false) {
      $params = [];
      /*if(isset($this->category->parent->parent->url)) {
          $params[]= $this->category->parent->parent->url;
      }
      if(isset($this->category->parent->url)) {
          $params[]= $this->category->parent->url;
      }*/
      if($full) $params[]= $this->category->slug;
      return $params;
  }

    /*public function getShortAttribute() {
      $val = db_translate_return($this->description_ru, $this->description_kz);
      $val = strip_tags($val);
      $val = mb_substr($val, 0, 150);
      //dd($val);
      return $val . " ...";
    }

    public function resolvePostTitle() {
      if($this->short_title_ru) return db_translate($this->short_title_ru, $this->short_title_kz);
      return db_translate($this->title_ru, $this->title_kz);
    }*/

}
