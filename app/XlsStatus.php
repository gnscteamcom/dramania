<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XlsStatus extends Model
{
    const STATUS_DRAFT = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;
    const STATUS_UPDATED = 4;

    public function isStatusOf($id){
		return $this->id == $id;
    }
    
    public static function STATUS_DRAFT() {
        return XlsStatus::where([
			'xls_statuses.id' => static::STATUS_DRAFT
		])->first();
    }

    public static function STATUS_ACTIVE() {
        return XlsStatus::where([
			'xls_statuses.id' => static::STATUS_ACTIVE
		])->first();
    }

    public static function STATUS_DELETED() {
        return XlsStatus::where([
			'xls_statuses.id' => static::STATUS_DELETED
		])->first();
    }

    public static function STATUS_UPDATED() {
      return XlsStatus::where([
    'xls_statuses.id' => static::STATUS_UPDATED
    ])->first();
    }

    public function isStatusDraft(){
		return $this->isStatusOf(static::STATUS_DRAFT);
    }
    
	public function isStatusActive(){
		return $this->isStatusOf(static::STATUS_ACTIVE);
	}
}
