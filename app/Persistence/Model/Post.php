<?php

namespace App\Persistence\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $table = 'blog_post';
    public $timestamps = null;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author() {
        return $this->belongsTo(Author::class, 'author_id', 'id', Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags() {
        return $this->hasMany(Tag::class, 'post_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category() {
        return $this->belongsToMany(Category::class, 'blog_post_to_category', 'post_id', 'category_id', Post::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function related() {
        return $this->belongsToMany(Post::class, 'blog_related', 'blog_post_id', 'blog_related_post_id', Post::class);
    }
}
