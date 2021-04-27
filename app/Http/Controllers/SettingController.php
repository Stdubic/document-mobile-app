<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSetting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
		$settings = Setting::firstOrFail();
        $roles = Role::orderBy('name')->get();

        return view('settings.add', compact('settings', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSetting $request)
    {
        $status = Setting::firstOrFail()->update([
			'app_name' => $request->app_name,
			'app_email' => strtolower($request->app_email),
			'https' => isset($request->https),
			'timezone' => $request->timezone,
			'date_format' => $request->date_format,
			'time_format' => $request->time_format,
			'currency_code' => $request->currency_code,
			'google_api_key' => $request->google_api_key,
			'min_pass_len' => $request->min_pass_len,
			'jwt_secret_key' => $request->jwt_secret_key,
			'jwt_expiration_time' => $request->jwt_expiration_time,
			'media_storage' => $request->media_storage,
			'media_visibility' => $request->media_visibility,
			'max_upload_size' => 1024 * 1024 * $request->max_upload_size,
			'thumb_width_landscape' => $request->thumb_width_landscape,
			'thumb_width_portrait' => $request->thumb_width_portrait,
			'image_filter' => strtolower($request->image_filter),
			'video_filter' => strtolower($request->video_filter),
			'registration_active' => isset($request->registration_active),
			'registration_role_id' => $request->registration_role_id,
			'aws_access_key_id' => $request->aws_access_key_id,
			'aws_secret_access_key' => $request->aws_secret_access_key,
			'aws_default_region' => $request->aws_default_region,
			'aws_bucket_name' => $request->aws_bucket_name,
			'aws_bucket_url' => $request->aws_bucket_url,
			'client_id' => $request->client_id,
			'client_secret' => $request->client_secret,
			'amount' => $request->amount,
			'duration' => $request->duration,
            'onesignal_rest_api_key' => $request->onesignal_rest_api_key,
            'onesignal_user_auth_key' => $request->onesignal_user_auth_key,
            'onesignal_app_id' => $request->onesignal_app_id,
            'video_upload' => $request->video_upload,
            'phone_number' => $request->phone_number,
            'description' => $request->description,
		]);

		return redirect(route('settings.edit'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
