<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EditorModel extends Model
{
	use SoftDeletes;
	protected $table = 'editors';
    public $fillable = ['user_id','content','slug', 'page_name', 'url'];
}
