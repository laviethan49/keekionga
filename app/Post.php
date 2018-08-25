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
//====================================================================================================
    public static function newPost($title, $message, $images)
    {
    	$post = new Post;
    		$post->title = $title;
    		$post->message = $message;
    	$post->save();

    	foreach ($images as $key => $image)
    	{
    		$img = new Image;
    			$img->path = $image;
    			$img->post_id = $post->id;
    		$img->save();
    	}

    	return $post;
    }
}
