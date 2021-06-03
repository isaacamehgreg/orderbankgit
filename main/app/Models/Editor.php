<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Editor extends Model
{
    use SoftDeletes;
    public $fillable = ['user_id','content','slug', 'page_name', 'url'];
}
