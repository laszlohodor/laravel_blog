<?php

namespace App\Persistence\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'blog_category';
    public $timestamps = null;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts() {
        return $this->belongsToMany(Post::class, 'blog_post_to_category', 'category_id', 'post_id');
    }

}
