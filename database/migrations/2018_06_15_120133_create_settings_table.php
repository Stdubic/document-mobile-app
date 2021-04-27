<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
			$table->tinyIncrements('id')->unsigned();
			$table->string('app_name', 50);
			$table->string('app_email', 50);
			$table->string('timezone', 50);
			$table->string('date_format', 15);
			$table->string('time_format', 15);
			$table->string('currency_code', 3);
			$table->string('google_api_key', 50)->nullable();
			$table->unsignedTinyInteger('min_pass_len');
			$table->string('jwt_secret_key', 128);
			$table->unsignedInteger('jwt_expiration_time');
			$table->string('media_storage', 50);
			$table->unsignedInteger('max_upload_size');
			$table->unsignedSmallInteger('thumb_width_landscape');
			$table->unsignedSmallInteger('thumb_width_portrait');
			$table->string('image_filter', 500)->nullable();
			$table->string('video_filter', 500)->nullable();
			$table->boolean('registration_active');
			$table->unsignedSmallInteger('registration_role_id');
			$table->string('aws_access_key_id', 128)->nullable();
			$table->string('aws_secret_access_key', 128)->nullable();
			$table->string('aws_default_region', 128)->nullable();
			$table->string('aws_bucket_name', 50)->nullable();
			$table->string('aws_bucket_url', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
