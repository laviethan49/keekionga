<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Post;
use App\Image;

class PostController extends Controller
{
    public function createPost(Request $req)
    {
    	//Validates Post Message
    	$validatedData = $req->validate([
	        'post_title' => 'required|max:500',
	        'post_message' => 'required|max:5000',
	    ]);
    	//Check Images
        if(isset($req->file))
        {
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
        }

        $post = new Post;
            $post->title = $req->post_title;
            $post->message = $req->post_message;
        $post->save();

        if(isset($req->file))
        {
            foreach ($imagePaths as $key => $image)
            {
                $img = new Image;
                    $img->path = $image;
                    $img->post_id = $post->id;
                $img->save();
            }
        }

    	return back()->withErrors(['Post Successfully Created!']);
    }

    public function getTenPosts()
    {
    	$tenPosts = Post::orderBy('created_at', 'desc')->take(10)->get();
    	$postsWithImages = array();

    	foreach ($tenPosts as $key => $post)
    	{
    		$postsWithImages[$key] = [
    			"post" => $post,
    			"images" => $post->images
    		];
    	}

    	return response()->json($postsWithImages);
    }

    public function tenMorePosts(Request $req)
    {
        $tenMore = Post::orderBy('created_at', 'desc')->where('id', '<', $req->lastID)->take(10)->get();
        $postsWithImages = array();

        foreach ($tenMore as $key => $post)
        {
            $postsWithImages[$key] = [
                "post" => $post,
                "images" => $post->images
            ];
        }

        return response()->json($postsWithImages);
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

    public function editPost(Request $req)
    {
        $id = $req->postID;
        $title = $req->post_title_input;
        $message = $req->post_message_input;
        $delete = $req->images_to_delete;
        $add = $req->post_images_input;

        $validatedData = $req->validate([
            'post_title_input' => 'required|max:500',
            'post_message_input' => 'required|max:5000',
        ]);

        if($add[0] != null)
        {
            foreach ($add as $key => $value)
            {
                if(!file_exists($value))
                    return back()->withErrors(['File Type Of Image '.($key+1).' Not Supported, Please Choose Another, Or Change File Type With A Program']);
            }
            foreach ($add as $key => $path)
            {
                $randomString = rand(0, 1000000000000000000);
                $path->storeAs('public/images', $randomString.'.jpeg');

                $image = new Image;
                    $image->path = '/storage/images/'.$randomString.'.jpeg';
                    $image->post_id = $id;
                $image->save();
            }
        }

        if(isset($delete))
        {
            foreach ($delete as $key => $path)
            {
                $image = Image::where('path', $path)->delete();
                $fileName = str_replace('/storage', '/public', $path);
                Storage::delete($fileName);
            }
        }

        $post = Post::find($id);
            $post->title = $title;
            $post->message = $message;
        $post->save();

        return back()->withErrors(['Post Successfully Updated!']);
    }

    public function deletePost(Request $req)
    {
        $id = $req->postID;

        $delete = Post::find($id)->images()->get();

        foreach ($delete as $key => $value)
        {
            $path = $value->path;
            $fileName = str_replace('/storage', '/public', $path);
            Storage::delete($fileName);
        }

        Post::find($id)->delete();

        return back()->withErrors(['Post Successfully Deleted!']);
    }

    public function getMonthOptions()
    {
        $posts = Post::all();
        $months = array();

        foreach ($posts as $key => $post)
        {
            $month = $post->created_at->format("F");
            $monthNum = $post->created_at->format("n");

            if(!in_array([$monthNum => $month], $months))
                $months[$monthNum] = $month;
        }

        return response()->json($months);
    }

    public function getPostsForMonth(Request $req)
    {
        $month = $req->month_num;
        $postsForMonth = Post::orderBy('created_at', 'desc')->where( DB::raw('MONTH(created_at)'), '=', $month )->get();
        $postsWithImages = array();

        foreach ($postsForMonth as $key => $post)
        {
            $postsWithImages[$key] = [
                "post" => $post,
                "images" => $post->images
            ];
        }

        return response()->json($postsWithImages);
    }

    public function special(Request $req)
    {
        $post = Post::find($req->postID);
            $post->special = 1;
        $post->save();

        return response()->json($post);
    }
    public function unspecial(Request $req)
    {
        $post = Post::find($req->postID);
            $post->special = 0;
        $post->save();

        return response()->json($post);
    }
    public function hidePost(Request $req)
    {
        $post = Post::find($req->postID);
            $post->hidden = 1;
        $post->save();

        return response()->json($post);
    }
    public function showPost(Request $req)
    {
        $post = Post::find($req->postID);
            $post->hidden = 0;
        $post->save();

        return response()->json($post);
    }
}
