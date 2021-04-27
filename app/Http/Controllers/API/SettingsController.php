<?php

namespace App\Http\Controllers\API;

use Illuminate\Routing\Controller;
use App\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $setting = Setting::firstOrFail();
        return response()->json(['onesignal_app_id' => setting('onesignal_app_id'),'video_upload' => $setting->video_upload,'phone_number' => $setting->phone_number,'description' => $setting->description]);
    }

}
