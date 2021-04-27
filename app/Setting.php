<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $fillable = [
		'app_name',
		'app_email',
		'https',
		'timezone',
		'date_format',
		'time_format',
		'currency_code',
		'google_api_key',
		'min_pass_len',
		'jwt_secret_key',
		'jwt_expiration_time',
		'media_storage',
		'media_visibility',
		'max_upload_size',
		'thumb_width_landscape',
		'thumb_width_portrait',
		'image_filter',
		'video_filter',
		'registration_active',
		'registration_role_id',
		'aws_access_key_id',
		'aws_secret_access_key',
		'aws_default_region',
		'aws_bucket_name',
		'aws_bucket_url',
        'client_id',
        'client_secret',
        'amount',
        'duration',
        'onesignal_rest_api_key',
        'onesignal_user_auth_key',
        'onesignal_app_id',
        'video_upload',
        'phone_number',
        'description'
    ];
}
