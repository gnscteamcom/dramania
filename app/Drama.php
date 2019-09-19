<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drama extends Model
{
    protected $casts = ['id' => 'string', 'genres' => 'json', 'episodes' => 'json'];

    public function language() {
        return $this->belongsTo('\App\Language', 'language_id', 'id');
    }
}
