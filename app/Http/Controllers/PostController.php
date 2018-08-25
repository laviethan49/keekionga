<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function upload(Request $req)
    {
    	//Validates Post Message
    	$validatedData = $req->validate([
	        'post_title' => 'required|max:500',
	        'post_message' => 'required|max:5000',
            'file[]' => 'required',
	    ]);
    	//Check Images
    	foreach ($req->file as $key => $value)
    	{
    		if(!file_exists($value))
				return back()
	    				->withInput($req->input())
	    				->withErrors(['File Type Of Image '.($key+1).' Not Supported, Please Choose Another, Or Change File Type With A Program']);
    	}
    	$imagePaths = array();
    	foreach ($req->file as $key => $value)
    	{
    		$randomString = rand(0, 1000000000000000000);
    		$value->storeAs('public/images', $randomString.'.jpeg');
    		$imagePaths[$key] = '/storage/images/'.$randomString.'.jpeg';
    	}
    	//Everything is set
    	$newPost = Post::newPost($req->post_title, $req->post_message, $imagePaths);

    	return back()->withErrors(['Post Successfully Created!']);
    }

    public function getAllPosts()
    {
    	$allPosts = Post::orderBy('created_at', 'desc')->get();
    	$postsWithImages = array();

    	foreach ($allPosts as $key => $post)
    	{
    		$postsWithImages[$key] = [
    			"post" => $post,
    			"images" => $post->images
    		];
    	}

    	return response()->json($postsWithImages);
    }
}
