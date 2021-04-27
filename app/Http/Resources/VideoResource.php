<?php

namespace App\Http\Resources;

use App\VideoFilterOptions;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\MediaStorage;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $storage = new MediaStorage;

        $image = $storage->files('videos/'.$this->id.'/image');
        $image = empty($image) ? null : $storage->url($storage->getThumb($image[0]));

        $video = $storage->files('videos/'.$this->id.'/video');
        $video = empty($video) ? null : $storage->url($video[0]);

        $filter_options = VideoFilterOptions::where('video_id', $this->id)->pluck('filter_options_id')->toArray();

        return [
            'id' => $this->id,
            'title' => $this->name,
            'user' => $this->user,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'image' => $image,
            'video' => $video,
            'filter_options'=> $filter_options,
            'protected' => $this->protected,
            'description' => $this->description,
        ];
    }
}
