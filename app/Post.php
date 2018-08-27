<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Image;

class Post extends Model
{
    protected $table = 'posts';

    public function images()
    {
    	return $this->hasMany('App\Image', 'post_id');
    }
}
