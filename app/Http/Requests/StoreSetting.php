<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSetting extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'app_name' => 'required|max:50',
			'app_email' => 'required|max:50|email',
			'https' => 'boolean',
			'timezone' => 'required|timezone',
			'date_format' => 'required|max:15',
			'time_format' => 'required|max:15',
			'currency_code' => 'required|max:3',
			'google_api_key' => 'max:50',
			'min_pass_len' => 'required|integer|min:1',
			'jwt_secret_key' => 'required|max:128',
			'jwt_expiration_time' => 'required|integer|min:1',
			'media_storage' => 'max:50',
			'media_visibility' => 'max:10',
			'max_upload_size' => 'required|integer|min:1',
			'thumb_width_landscape' => 'required|integer|min:1',
			'thumb_width_portrait' => 'required|integer|min:1',
			'image_filter' => 'max:500',
			'video_filter' => 'max:500',
			'registration_active' => 'boolean',
			'registration_role_id' => 'required|integer|min:1',
			'aws_access_key_id' => 'max:128',
			'aws_secret_access_key' => 'max:128',
			'aws_default_region' => 'max:128',
			'aws_bucket_name' => 'max:50',
			'aws_bucket_url' => 'max:1000',
            'onesignal_rest_api_key' => 'nullable|string|max:128',
            'onesignal_user_auth_key' => 'nullable|string|max:128',
            'onesignal_app_id' => 'nullable|string|max:128'
        ];
    }
}
