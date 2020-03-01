<?php

namespace App\Persistence\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $table = 'blog_tag';
    public $timestamps = null;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts() {
        return $this->belongsToMany(Post::class, 'blog_post_to_tag', 'tag_id', 'post_id');
    }
}
