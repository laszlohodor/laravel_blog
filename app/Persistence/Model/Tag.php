<?php

namespace App\Persistence\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $table = 'blog_tag';
    public $timestamps = null;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function posts() {
        return $this->belongsTo(Post::class, 'post_id', 'id', Table::class);
    }
}
