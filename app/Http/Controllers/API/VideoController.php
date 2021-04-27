<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\VideoResource;
use App\Video;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\MediaStorage;
use App\Http\Requests\StoreVideo;
use JWTAuth;


class VideoController extends Controller
{
    public function index()
    {
        return VideoResource::collection(Video::where('active', 1)->orderBy('protected')->orderBy('created_at','desc')->paginate(20));
    }

    public function show(Video $video)
    {
        return new VideoResource($video);
    }

    public function store(StoreVideo $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json('user_not_found');
            }
        } catch (TokenExpiredException $e) {
            return response()->json('token_expired');

        } catch (TokenInvalidException $e) {
            return response()->json('token_invalid');

        } catch (JWTException $e) {
            return response()->json('token_absent');
        }

        $user_id = $user->id;

        $video = Video::create([
            'name' => $request->title,
            'user_id' => $user_id,
            'protected' => $request->protected,
            'description' => $request->description,
            'active' => 0
        ]);

        $video->filter_options()->attach( $request->input('filters') );
        $media_save = [
            'video' => 'videos/'.$video->id.'/video',
            'image' => 'videos/'.$video->id.'/image',
        ];

        $storage = new MediaStorage;
        $storage->handle(
            [
                'video' => $request->video,
                'image' => $request->image,
            ], $media_save);

        return new VideoResource($video);
    }
}
