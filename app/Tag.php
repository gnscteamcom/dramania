<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    const TAG_NEWS = 1;
    const TAG_POPULAR = 2;
    const TAG_LATEST = 3;

}
