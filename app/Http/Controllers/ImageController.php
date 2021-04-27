<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ImageController extends Controller
{

    public function store(Request $request)
    {
        $unique_name = md5($request->image. time());
        $media_save = [
            'image' => 'images/'.$unique_name
        ];

        $storage = new MediaStorage;
        $storage->handle( [ 'image' => $request->image], $media_save);

        $image = $storage->files('images/'.$unique_name);
        $image = empty($image) ? null : $storage->url($image[0]);

        return response()->json(['image_url' => $image]);
    }
}
