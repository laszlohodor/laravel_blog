<?php

namespace App\Persistence\Model;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public $table = 'blog_author';
    public $timestamps = null;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts() {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }
}
