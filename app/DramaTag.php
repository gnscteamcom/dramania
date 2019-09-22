<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DramaTag extends Model
{
    protected $casts = ['drama_id' => 'string', 'genres' => 'json', 'episodes' => 'json'];

    public function drama() {
        return $this->belongsTo('\App\Drama', 'drama_id', 'id');
    }

    public function tag() {
        return $this->belongsTo('\App\Tag', 'tag_id', 'id');
    }
}
