<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XlsFile extends Model
{
    public function status() {
        return $this->belongsTo('\App\XlsStatus', 'xls_status_id', 'id');
    }

    public function language() {
        return $this->belongsTo('\App\Language', 'language_id', 'id');
    }

    public function type() {
        return $this->belongsTo('\App\XlsFileType', 'xls_file_type_id', 'id');
    }
}
