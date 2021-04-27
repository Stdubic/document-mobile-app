@extends('layouts.master')

<?php

if(!isset($settings) || !$settings) redirect(route('home'));

$timezones = timezone_identifiers_list();
sort($timezones);

foreach($timezones as &$value)
{
	$value = [
		'value' => $value,
		'label' => $value
	];
}

$storages = [
	[
		'value' => 'public',
		'label' => 'Local'
	],
	[
		'value' => 's3',
		'label' => 'AWS S3 bucket'
	]
];

$media_visibilities = [
	[
		'value' => 'public',
		'label' => 'Public'
	],
	[
		'value' => 'private',
		'label' => 'Private'
	]
];

$all_roles = [
	[
		'value' => '',
		'label' => '-'
	]
];

foreach($roles as $row)
{
	$all_roles[] = [
		'value' => $row->id,
		'label' => $row->name
	];
}

$fields_basic = [
	[
		'label' => 'App name',
		'tag' => 'input',
		'attributes' => [
			'id' => 'app_name',
			'name' => 'app_name',
			'type' => 'text',
			'value' => $settings->app_name,
			'maxlength' => 50,
			'required' => true,
			'autofocus' => true
		]
	],
	[
		'label' => 'App e-mail',
		'tag' => 'input',
		'attributes' => [
			'id' => 'app_email',
			'name' => 'app_email',
			'type' => 'email',
			'value' => $settings->app_email,
			'maxlength' => 50
		]
	],
    [
        'label' => 'Phone number',
        'tag' => 'input',
        'attributes' => [
            'id' => 'phone_number',
            'name' => 'phone_number',
            'type' => 'text',
            'value' => $settings->phone_number,
            'maxlength' => 50,
            'autofocus' => true
        ]
    ],
    [
        'label' => 'Description',
        'tag' => 'textarea',
        'value' => $settings->description,
        'attributes' => [
            'id' => 'description',
            'name' => 'description',
            'maxlength' => 5000,
            'rows' => 10,
            'cols' => 100
        ]
    ],
	[
		'label' => 'Force HTTPS',
		'tag' => 'checkbox',
		'side_label' => 'Yes',
		'attributes' => [
			'id' => 'https',
			'name' => 'https',
			'value' => 1,
			'type' => 'checkbox',
			'checked' => boolval($settings->https)
		]
	],
	[
		'label' => 'Min. password length',
		'tag' => 'input',
		'attributes' => [
			'id' => 'min_pass_len',
			'name' => 'min_pass_len',
			'type' => 'number',
			'value' => $settings->min_pass_len,
			'min' => 1,
			'required' => true
		]
	],
	[
		'label' => 'Money currency code',
		'tag' => 'input',
		'attributes' => [
			'id' => 'currency_code',
			'name' => 'currency_code',
			'type' => 'text',
			'value' => $settings->currency_code,
			'maxlength' => 3,
			'required' => true
		]
	],
	[
		'label' => 'Google API key',
		'tag' => 'input',
		'attributes' => [
			'id' => 'google_api_key',
			'name' => 'google_api_key',
			'type' => 'text',
			'value' => $settings->google_api_key,
			'maxlength' => 50
		]
	]
];

$fields_datetime = [
	[
		'label' => 'Timezone',
		'tag' => 'select',
		'options' => $timezones,
		'selected' => $settings->timezone,
		'attributes' => [
			'id' => 'timezone',
			'name' => 'timezone',
			'required' => true
		]
	],
	[
		'label' => 'Date format (<a href="https://php.net/manual/en/function.date.php" target="_blank" rel="external" class="m-link">help</a>)',
		'tag' => 'input',
		'attributes' => [
			'id' => 'date_format',
			'name' => 'date_format',
			'type' => 'text',
			'value' => $settings->date_format,
			'maxlength' => 15,
			'required' => true
		]
	],
	[
		'label' => 'Time format (<a href="https://php.net/manual/en/function.date.php" target="_blank" rel="external" class="m-link">help</a>)',
		'tag' => 'input',
		'attributes' => [
			'id' => 'time_format',
			'name' => 'time_format',
			'type' => 'text',
			'value' => $settings->time_format,
			'maxlength' => 15,
			'required' => true
		]
	]
];

$fields_registration = [
	[
		'label' => 'Active',
		'tag' => 'checkbox',
		'side_label' => 'Yes',
		'attributes' => [
			'id' => 'registration_active',
			'name' => 'registration_active',
			'value' => 1,
			'type' => 'checkbox',
			'checked' => boolval($settings->registration_active)
		]
	],
	[
		'label' => 'Registration role',
		'tag' => 'select',
		'options' => $all_roles,
		'selected' => $settings->registration_role_id,
		'attributes' => [
			'id' => 'registration_role_id',
			'name' => 'registration_role_id',
			'required' => true
		]
	]
];

$fields_jwt = [
	[
		'label' => 'Secret key',
		'tag' => 'input',
		'attributes' => [
			'id' => 'jwt_secret_key',
			'name' => 'jwt_secret_key',
			'type' => 'text',
			'value' => $settings->jwt_secret_key,
			'maxlength' => 128,
			'required' => true
		]
	],
	[
		'label' => 'Expiration time',
		'tag' => 'input',
		'group' => [
			'right' => 'min'
		],
		'attributes' => [
			'id' => 'jwt_expiration_time',
			'name' => 'jwt_expiration_time',
			'type' => 'number',
			'value' => $settings->jwt_expiration_time,
			'min' => 1,
			'required' => true
		]
	]
];

$fields_media = [
	[
		'label' => 'Storage',
		'tag' => 'select',
		'options' => $storages,
		'selected' => $settings->media_storage,
		'attributes' => [
			'id' => 'media_storage',
			'name' => 'media_storage',
			'required' => true
		]
	],
	[
		'label' => 'Visibility',
		'tag' => 'select',
		'options' => $media_visibilities,
		'selected' => $settings->media_visibility,
		'attributes' => [
			'id' => 'media_visibility',
			'name' => 'media_visibility',
			'required' => true
		]
	],
	[
		'label' => 'Max. upload size (per file)',
		'tag' => 'input',
		'group' => [
			'right' => 'MB'
		],
		'attributes' => [
			'id' => 'max_upload_size',
			'name' => 'max_upload_size',
			'type' => 'number',
			'value' => $settings->max_upload_size / (1024 * 1024),
			'min' => 1,
			'required' => true
		]
	],
	[
		'label' => 'Thumbnail width - landscape',
		'tag' => 'input',
		'group' => [
			'right' => 'px'
		],
		'attributes' => [
			'id' => 'thumb_width_landscape',
			'name' => 'thumb_width_landscape',
			'type' => 'number',
			'value' => $settings->thumb_width_landscape,
			'min' => 300,
			'max' => 1600,
			'required' => true
		]
	],
	[
		'label' => 'Thumbnail width - portrait',
		'tag' => 'input',
		'group' => [
			'right' => 'px'
		],
		'attributes' => [
			'id' => 'thumb_width_portrait',
			'name' => 'thumb_width_portrait',
			'type' => 'number',
			'value' => $settings->thumb_width_portrait,
			'min' => 300,
			'max' => 1600,
			'required' => true
		]
	],
	[
		'label' => 'Image filter (each extension in new line)',
		'tag' => 'textarea',
		'value' => $settings->image_filter,
		'attributes' => [
			'id' => 'image_filter',
			'name' => 'image_filter',
			'maxlength' => 500,
			'rows' => 10,
			'cols' => 50
		]
	],
	[
		'label' => 'Video filter (each extension in new line)',
		'tag' => 'textarea',
		'value' => $settings->video_filter,
		'attributes' => [
			'id' => 'video_filter',
			'name' => 'video_filter',
			'maxlength' => 500,
			'rows' => 10,
			'cols' => 50
		]
	]
];

$fields_aws = [
	[
		'label' => 'Access key ID',
		'tag' => 'input',
		'attributes' => [
			'id' => 'aws_access_key_id',
			'name' => 'aws_access_key_id',
			'type' => 'text',
			'value' => $settings->aws_access_key_id,
			'maxlength' => 128
		]
	],
	[
		'label' => 'Secret access key',
		'tag' => 'input',
		'attributes' => [
			'id' => 'aws_secret_access_key',
			'name' => 'aws_secret_access_key',
			'type' => 'text',
			'value' => $settings->aws_secret_access_key,
			'maxlength' => 128
		]
	],
	[
		'label' => 'Default region',
		'tag' => 'input',
		'attributes' => [
			'id' => 'aws_default_region',
			'name' => 'aws_default_region',
			'type' => 'text',
			'value' => $settings->aws_default_region,
			'maxlength' => 50
		]
	],
	[
		'label' => 'Bucket name',
		'tag' => 'input',
		'attributes' => [
			'id' => 'aws_bucket_name',
			'name' => 'aws_bucket_name',
			'type' => 'text',
			'value' => $settings->aws_bucket_name,
			'maxlength' => 50
		]
	],
	[
		'label' => 'Bucket URL',
		'tag' => 'input',
		'attributes' => [
			'id' => 'aws_bucket_url',
			'name' => 'aws_bucket_url',
			'type' => 'url',
			'value' => $settings->aws_bucket_url,
			'maxlength' => 1000
		]
	]
];
$fields_paypal = [
    [
        'label' => 'Client ID',
        'tag' => 'input',
        'attributes' => [
            'id' => 'client_id',
            'name' => 'client_id',
            'type' => 'text',
            'value' => $settings->client_id,
            'maxlength' => 128
        ]
    ],
    [
        'label' => 'Client Secret',
        'tag' => 'input',
        'attributes' => [
            'id' => 'client_secret',
            'name' => 'client_secret',
            'type' => 'text',
            'value' => $settings->client_secret,
            'maxlength' => 128
        ]
    ],
    [
        'label' => 'Amount',
        'tag' => 'input',
        'group' => [
            'right' => $settings->currency_code,
		],
        'attributes' => [
            'id' => 'amount',
            'name' => 'amount',
            'type' => 'number',
            'value' => $settings->amount,
            'min' => 1,
			'required'=> true
        ]
    ],
    [
        'label' => 'Duration',
        'tag' => 'input',
        'group' => [
            'right' => 'months',
        ],
        'attributes' => [
            'id' => 'duration',
            'name' => 'duration',
            'type' => 'number',
            'value' => $settings->duration,
            'min' => 1,
            'required' => true
        ]
    ],
];
$fields_onesignal = [
    [
        'label' => 'REST API key',
        'tag' => 'input',
        'attributes' => [
            'id' => 'onesignal_rest_api_key',
            'name' => 'onesignal_rest_api_key',
            'type' => 'text',
            'value' => $settings->onesignal_rest_api_key,
            'maxlength' => 128
        ]
    ],
    [
        'label' => 'User auth key',
        'tag' => 'input',
        'attributes' => [
            'id' => 'onesignal_user_auth_key',
            'name' => 'onesignal_user_auth_key',
            'type' => 'text',
            'value' => $settings->onesignal_user_auth_key,
            'maxlength' => 128
        ]
    ],
    [
        'label' => 'App id',
        'tag' => 'input',
        'attributes' => [
            'id' => 'onesignal_app_id',
            'name' => 'onesignal_app_id',
            'type' => 'text',
            'value' => $settings->onesignal_app_id,
            'maxlength' => 128
        ]
    ]
];

$fields_video = [
    [
        'label' => 'Video upload',
        'tag' => 'checkbox',
        'side_label' => 'Yes',
        'attributes' => [
            'id' => 'video_upload',
            'name' => 'video_upload',
            'value' => 1,
            'type' => 'checkbox',
            'checked' => boolval($settings->video_upload)
        ]
    ],
];


?>

@section('content')
	@include('layouts.close_button', ['title' => 'SETTINGS', 'icon' => 'fa fa-cogs'])
	<div class="m-portlet__body">
		<ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
			<li class="nav-item m-tabs__item">
				<a href="#btabs-basic" class="nav-link m-tabs__link active" data-toggle="tab"><i class="fa fa-info"></i> Basic</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-datetime" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-calendar-alt"></i> Date & time</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-registration" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-user-plus"></i> Registration</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-jwt" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-lock"></i> JWT</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-media" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-image"></i> Media</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-aws" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-database"></i> AWS</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-paypal" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-money-bill-alt"></i> PayPal</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-onesignal" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-broadcast-tower"></i> OneSignal</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-video" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-image"></i> Video upload</a>
			</li>

		</ul>
		<form class="m-form form-notify" action="{{ route('settings.update', $settings->id) }}" method="post" autocomplete="off" id="main-form">
			<div class="m-portlet__body tab-content">
				@csrf
				{{ method_field('PUT') }}
				<div class="tab-pane active" id="btabs-basic" role="tabpanel">
					<?php generate_form_fields($fields_basic, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-datetime" role="tabpanel">
					<?php generate_form_fields($fields_datetime, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-registration" role="tabpanel">
					<?php generate_form_fields($fields_registration, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-jwt" role="tabpanel">
					<?php generate_form_fields($fields_jwt, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-media" role="tabpanel">
					<?php generate_form_fields($fields_media, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-aws" role="tabpanel">
					<?php generate_form_fields($fields_aws, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-paypal" role="tabpanel">
                    <?php generate_form_fields($fields_paypal, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-onesignal" role="tabpanel">
                    <?php generate_form_fields($fields_onesignal, $errors); ?>
				</div>
				<div class="tab-pane" id="btabs-video" role="tabpanel">
                    <?php generate_form_fields($fields_video, $errors); ?>
				</div>

			</div>
			@include('layouts.submit_button')
		</form>
	</div>
@endsection