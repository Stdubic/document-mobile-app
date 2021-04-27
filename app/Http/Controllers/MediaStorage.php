<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class MediaStorage extends Controller
{
	const THUMBS_DIR = '/thumbs/';
	const MARKED_REMOVAL_KEY = 'marked_removal';
	const VISIBILITY_KEY = 'visibility';
	const OLD_NAMES_KEY = 'old_names';
	const NEW_NAMES_KEY = 'new_names';
	const FILENAME_GLUE = '-';

	private $disk = null;

	public function __construct($disk = null)
	{
		if(empty($disk)) $disk = setting('media_storage');
		$this->disk = Storage::disk($disk);
	}

	public function handle($media, $pairs = [])
	{
		$this->delete($media);
		$this->changeVisibility($media);
		$this->rename($media);
		$this->save($media, $pairs);
	}

	private function save($media, $pairs)
	{
		$pairs = (array) $pairs;

		foreach($pairs as $key => $upload_dir)
		{
			if(!isset($media[$key])) continue;

			$thumbs_dir = $upload_dir.self::THUMBS_DIR;
			$files = is_object($media[$key]) ? [$media[$key]] : $media[$key];

			foreach($files as $file)
			{
				$filename = $this->generateFilename($file->getClientOriginalName());
				if($file->getClientSize() > setting('max_upload_size') || !$this->isMedia($filename)) continue;

				$this->disk->putFileAs($upload_dir, $file, $filename, setting('media_visibility'));
				if($this->isImage($filename)) $this->disk->put($thumbs_dir.$filename, $this->makeThumb($file), setting('media_visibility'));
			}
		}
	}

	private function rename($media)
	{
		$old_names = isset($media[self::OLD_NAMES_KEY]) ? $media[self::OLD_NAMES_KEY] : [];
		$new_names = isset($media[self::NEW_NAMES_KEY]) ? $media[self::NEW_NAMES_KEY] : [];

		foreach($old_names as $key => $old_name)
		{
			$new_name = $this->generateFileName($new_names[$key]);
			if(empty($new_name)) continue;

			$dir = pathinfo($old_name, PATHINFO_DIRNAME);
			$ext = $this->getExt($old_name);
			$new_name = $dir.'/'.$new_name.'.'.$ext;

			if($old_name == $new_name || !$this->disk->exists($old_name) || $this->disk->exists($new_name)) continue;

			$this->disk->move($old_name, $new_name);
			if($this->isImage($old_name)) $this->disk->move($this->getThumb($old_name), $this->getThumb($new_name));
		}
	}

	private function changeVisibility($media)
	{
		$old_names = isset($media[self::OLD_NAMES_KEY]) ? $media[self::OLD_NAMES_KEY] : [];
		$visibilities = isset($media[self::VISIBILITY_KEY]) ? $media[self::VISIBILITY_KEY] : [];

		foreach($old_names as $key => $old_name)
		{
			if(!$this->disk->exists($old_name)) continue;

			$this->disk->setVisibility($old_name, $visibilities[$key]);
			if($this->isImage($old_name)) $this->disk->setVisibility($this->getThumb($old_name), $visibilities[$key]);
		}
	}

	private function delete($media)
	{
		$media = isset($media[self::MARKED_REMOVAL_KEY]) ? $media[self::MARKED_REMOVAL_KEY] : [];

		foreach($media as $file)
		{
			if(!$this->disk->exists($file)) continue;

			$this->disk->delete($file);
			if($this->isImage($file)) $this->disk->delete($this->getThumb($file));
		}
	}

	private function generateFileName($filename)
	{
		return preg_replace('/\s+/', self::FILENAME_GLUE, trim($filename));
	}

	private function makeThumb($file)
	{
		$file = Image::make($file);
		if(!$file) return null;

		$width = $file->width();
		$height = $file->height();

		$crop_w = ($width > $height) ? setting('thumb_width_landscape') : setting('thumb_width_portrait');
		$crop_h = round(($crop_w * $height) / $width);

		return (string) $file->resize($crop_w, $crop_h)->encode();
	}

	public function deleteDir($dir)
	{
		return $this->disk->deleteDirectory($dir);
	}

	public function getExt($file)
	{
		return strtolower(pathinfo($file, PATHINFO_EXTENSION));
	}

	public function isMedia($file)
	{
		return $this->isImage($file) || $this->isVideo($file);
	}

	public function isImage($file)
	{
		$ext = $this->getExt($file);
		$extensions = preg_split('/\s+/', strtolower(setting('image_filter')));

		return in_array($ext, $extensions);
	}

	public function isVideo($file)
	{
		$ext = $this->getExt($file);
		$extensions = preg_split('/\s+/', strtolower(setting('video_filter')));

		return in_array($ext, $extensions);
	}

	public function getThumb($file)
	{
		$name = basename($file);
		$name = str_replace('/'.$name, self::THUMBS_DIR.$name, $file);

		return $this->disk->exists($name) ? $name : $file;
	}

	public function files($dir)
	{
		return $this->disk->files($dir);
	}

	public function size($file)
	{
		return $this->disk->size($file);
	}

	public function url($file)
	{
		return $this->disk->url($file);
	}

	public function getVisibility($file)
	{
		return $this->disk->getVisibility($file);
	}

	public function lastModified($file)
	{
		return Carbon::createFromTimestamp($this->disk->lastModified($file));
	}
}
