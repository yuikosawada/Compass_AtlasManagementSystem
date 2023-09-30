<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments()
    {
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    // 投稿が削除されたらコメントも同時に削除（まだ機能してない）
    public static function boot()
    {
        parent::boot();
        static::deleted(function ($post) {
            $post->postComments()->delete();
        });
    }

    public function Likes()
    {
        return $this->hasMany('App\Models\Posts\Like');
    }

    public function subCategories()
    {
        // リレーションの定義
        return $this->belongsToMany('App\Models\Categories\SubCategory', 'post_sub_categories', 'post_id', 'sub_category_id');
    }

    // コメント数
    public function commentCounts($post_id)
    {
        return Post::with('postComments')->find($post_id)->postComments()->count();
    }

    // いいね数
    public function likeCounts($post_id)
    {
        return Like::where('like_post_id', $post_id)->get()->count();
    }
    // public function likeCounts($post_id){
    //     return $this->where('like_post_id', $post_id)->get()->count();
    // }

}
