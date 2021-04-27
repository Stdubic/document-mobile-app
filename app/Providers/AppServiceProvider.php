<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		$this->bindConfigs();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
	}

	private function bindConfigs()
	{
		config([
			'app.name' => setting('app_name'),
			'app.timezone' => setting('timezone'),
            'jwt.secret' => setting('jwt_secret_key'),
            'jwt.ttl' => setting('jwt_expiration_time'),
			'filesystems.disks.s3.key' => setting('aws_access_key_id'),
            'filesystems.disks.s3.secret' => setting('aws_secret_access_key'),
            'filesystems.disks.s3.region' => setting('aws_default_region'),
            'filesystems.disks.s3.bucket' => setting('aws_bucket_name'),
            'filesystems.disks.s3.url' => setting('aws_bucket_url')
		]);
	}
}
