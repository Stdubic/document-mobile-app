<?php

namespace App\Http\Controllers;


use App\FilterOption;
use App\Http\Requests\StoreVideo;
use App\Video;
use App\VideoFilterOptions;
use Illuminate\Http\Request;
use App\Http\Requests\MultiValues;
use Illuminate\Support\Facades\Auth;

class VideoBackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos  = Video::orderBy('created_at','dec')->get();

        return view('videos.list',compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $filter_options = FilterOption::with('filter')->orderBy('filter_id','asc')->orderBy('order','asc')->get();

        return view('videos.add',compact('filter_options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVideo $request)
    {

        $video = Video::create([
            'name' => $request->title,
            'user_id' => Auth::user()->id,
            'description' => $request->description,
            'protected' => $request->protected,
            'active' => 1
        ]);

        $video->filter_options()->attach( $request->filters );

        $media_save = [
            'video' => 'videos/'.$video->id.'/video',
            'image' => 'videos/'.$video->id.'/image',
        ];

        $storage = new MediaStorage;
        $storage->handle($request->media, $media_save);

        return redirect(route('videos.list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $contest
     * @return \Illuminate\Http\Response
     */
    public function show(Video $contest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $filter_options = FilterOption::with('filter')->orderBy('filter_id','asc')->orderBy('order','asc')->get();
        $video = Video::findOrFail($id);
        $filter_options_per_video = VideoFilterOptions::where('video_id', $id)->get();

        return view('videos.add', compact('video','filter_options','filter_options_per_video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVideo $request, $id)
    {
        Video::findOrFail($id)->update([
            'name' => $request->title,
            'user' => Auth::user()->id,
            'description' => $request->description,
            'protected' => $request->protected,
        ]);

        $video = Video::find($id);

        $video->filter_options()->sync( $request->filters );

        $media_save = [
            'video' => 'videos/'. $id.'/video',
            'image' => 'videos/'. $id.'/image',
        ];

        $storage = new MediaStorage;
        $storage->handle($request->media, $media_save);

        return redirect(route('videos.list'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Video::findOrFail($id)->delete();

        $storage = new MediaStorage;
        $storage->deleteDir('videos/'.$id);

        return redirect(route('videos.list'));
    }

    public function multiRemove(MultiValues $request)
    {
        $values = $request->values;
        $storage = new MediaStorage;

        foreach($values as $id)
        {
            Video::find($id)->delete();
            $storage->deleteDir('videos/'.$id);
        }

        return back();
    }
    public function multiActivate(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id)
        {
            Video::find($id)->update([
                'active' => 1
            ]);
        }

        return back();
    }

    public function multiDeactivate(MultiValues $request)
    {
        $values = $request->values;

        foreach($values as $id)
        {
            Video::find($id)->update([
                'active' => 0
            ]);
        }

        return back();
    }

}