<?php

namespace App\Http\Controllers;
//for validation 
use App\Http\Requests\StoreImgRequest;
//
use App\Http\Requests\StorePostRequest;
use App\Models\img;
use App\Models\post;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = post::get();

        return response()->json([
            'massage' => 'this is from post',
            'post' => $posts,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $post = new post;

        $post->name = $request->name;
        $post->img = $request->img;
        $post->save();

        return response()->json([
            'masage' => 'new post created',
            'post' => $post,

        ]);
    }

    /**
     * Display the specified resource.
     */
    // public function show(post $post)
    // {
    //     return response()->json([
    //         'masage'=> 'new post created',
    //         'post'=> $post,

    //      ]);
    // }

    public function show($id)
    {
        $post = post::find($id);
        return response()->json([
            'masage' => 'simgle post',
            'post' => $post,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, post $post)
    {
        $post->name = $request->name ?? $post->name;
        $post->img = $request->img ?? $post->img;
        $post->save();

        return response()->json([
            'masage' => 'post updated',
            'post' => $post,

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(post $post)
    {
        return response()->json([
            'masage' => 'post deleted',
            'post' => $post->delete(),

        ]);
    }


    // imges operations--------------------------------------------------------
    // ------------------------------------------------------------------------

    public function uplodeimg(StoreImgRequest $request)
    {

        //     'fbimg' => 'require|mimes:jpg,png,pdf,gif|max:2048'

        $path = $request->fbimg->store('uploads', 'public');

        $img = new img;
        $img->fbimg = $path;
        $img->save();

        $url = Storage::url($path);

        return response()->json([
            'massage' => "img uploded sucesfully",
            'url' => $url,
            'img_id' => $img->id,
            'data' => $img,


        ]);



    }

    // -------------------------get all img---------------------------------------

    public function getAllImg()
    {
        // Path to the images directory in the public folder
        $imges = img::all();

        // Generate URLs for each file
        $images = $imges->map(function ($img) {
            return [
                'id' => $img->id,
                'url' => Storage::url($img->fbimg),
            ];
        });

        return response()->json(['images' => $images]);

    }

    // -----------------------------Delete a img-------------------------------
    public function deleteImg(img $img)
    {

        return response()->json([
            'massage' => 'An img Deleted',
            'data' => $img->delete()
        ]);
    }


    //--------------------find a singel img-------------------------

    public function showImg($id)
    {

        $img = img::find($id);

        if (!$img) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        // Construct the URL to access the image
        // $fileUrl = asset('/uplodes/' . $image->fbimg);

        return response()->json([
            'url' => Storage::url($img->fbimg),
            'id'=>$img->id,
        ], 200);
    }
}
