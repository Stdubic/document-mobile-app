@extends('layouts.master')

<?php

$process_user = get_current_user();
$laravel_version = app()->version();

$pdo = DB::connection()->getPdo();

$db_server_info = $pdo->getAttribute($pdo::ATTR_CONNECTION_STATUS);
$db_driver = $pdo->getAttribute($pdo::ATTR_DRIVER_NAME);
$db_driver_ver = $pdo->getAttribute($pdo::ATTR_SERVER_VERSION);

$https = (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS'])) ? 'Yes' : 'No';

$disk_total = disk_total_space(getcwd());
$disk_taken = $disk_total - disk_free_space(getcwd());

$disk_taken_perc = round((100 * $disk_taken) / $disk_total, 2);
$disk_taken = round($disk_taken / (1024 * 1024 * 1024), 2);
$disk_total = round($disk_total / (1024 * 1024 * 1024), 2);

if(function_exists('apache_get_modules'))
{
	$apache_modules = apache_get_modules();
	$apache_modules_count = count($apache_modules);
	sort($apache_modules);
}

$php_exts = get_loaded_extensions();
$php_exts_count = count($php_exts);
sort($php_exts);

$os = php_uname('s').' '.php_uname('r').' '.php_uname('v').' '.php_uname('m');
$memory = round(memory_get_usage(true) / (1024 * 1024), 2);
$cpu = function_exists('sys_getloadavg') ? round(sys_getloadavg()[0] * 100, 2) : 0;

?>

@section('content')
	@include('layouts.list_header', ['title' => 'Technical info', 'icon' => 'fa fa-info'])
	<div class="m-portlet__body">
		<ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
			<li class="nav-item m-tabs__item">
				<a href="#btabs-basic" class="nav-link m-tabs__link active" data-toggle="tab">
					<i class="fa fa-info"></i> Basic
				</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-routes" class="nav-link m-tabs__link" data-toggle="tab">
					<i class="fa fa-sitemap"></i> Routes
				</a>
			</li>
			<li class="nav-item m-tabs__item">
				<a href="#btabs-modules" class="nav-link m-tabs__link" data-toggle="tab">
					<i class="fa fa-cogs"></i> Modules
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="btabs-basic" role="tabpanel">
				<table width="100%" class="table table-bordered table-striped table-hover">
					<tbody align="center">
						<tr><td>Server name:</td><td>{{ $_SERVER['SERVER_NAME'] }}</td></tr>
						<tr><td>Server software:</td><td>{{ $_SERVER['SERVER_SOFTWARE'] }} via {{ PHP_SAPI }}</td></tr>
						<tr><td>IP address and protocol:</td><td>{{ $_SERVER['SERVER_ADDR'] }}:{{ $_SERVER['SERVER_PORT'] }} via {{ $_SERVER['SERVER_PROTOCOL'] }}</td></tr>
						<tr><td>Secure connection (HTTPS):</td><td>{{ $https }}</td></tr>
						<tr><td>PHP user:</td><td>{{ $process_user }}</td></tr>
						<tr><td>PHP version:</td><td>{{ PHP_VERSION }}</td></tr>
						<tr><td>Laravel framework version:</td><td>{{ $laravel_version }}</td></tr>
						<tr><td>DB server:</td><td>{{ $db_server_info }}</td></tr>
						<tr><td>DB driver:</td><td>{{ $db_driver }} {{ $db_driver_ver }}</td></tr>
						<tr><td>OS:</td><td>{{ $os }}</td></tr>
						<tr><td>Disk usage:</td><td>{{ $disk_taken }} / {{ $disk_total }} GB ({{ $disk_taken_perc }}%)</td></tr>
						<tr><td>Allocated memory (RAM):</td><td>{{ $memory }} MB</td></tr>
						<?php

						if(function_exists('sys_getloadavg'))
						{
							?>
							<tr><td>CPU usage:</td><td>{{ $cpu }}%</td></tr>
							<?php
						}

						?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane" id="btabs-routes" role="tabpanel">
				<div class="table-responsive">
					<table width="100%" class="table table-bordered table-striped table-hover js-datatable">
						<thead>
							<tr>
								<th>Methods</th>
								<th>URI</th>
								<th>Name</th>
								<th>Protected</th>
							</tr>
						</thead>
						<tbody align="center">
							<?php

							$routes = Route::getRoutes();

							foreach($routes as $route)
							{
								$path = preg_replace('%(\{.+?\})%', '<code>$1</code>', $route->uri());
								$protected = in_array('check_role_permissions', $route->gatherMiddleware());

								?>
								<tr>
									<td>@include('layouts.method_badge', ['methods' => $route->methods()])</td>
									<td><?= $path ?></td>
									<td>{{ $route->getName() }}</td>
									<td>@include('layouts.bool_badge', ['value' => $protected])</td>
								</tr>
								<?php
							}

							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane m-accordion m-accordion--bordered" id="btabs-modules" role="tabpanel">
				<?php

				if(function_exists('apache_get_modules'))
				{
					?>
					<div class="m-accordion__item">
						<div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_apache_modules_head" data-toggle="collapse" href="#m_accordion_apache_modules_body" aria-expanded="false">
							<span class="m-accordion__item-icon"><i class="fa fa-server"></i></span>
							<span class="m-accordion__item-title">Loaded Apache server modules ({{ $apache_modules_count }})</span>
							<span class="m-accordion__item-mode"></span>
						</div>
						<div class="m-accordion__item-body collapse" id="m_accordion_apache_modules_body" role="tabpanel" aria-labelledby="m_accordion_apache_modules_head" data-parent="#btabs-modules">
							<div class="m-accordion__item-content">
								<ul>
									<?php

									foreach($apache_modules as $value)
									{
										?>
										<li>{{ $value }}</li>
										<?php
									}

									?>
								</ul>
							</div>
						</div>
					</div>
					<?php
				}

				?>
				<div class="m-accordion__item">
					<div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_php_ext_head" data-toggle="collapse" href="#m_accordion_php_ext_body" aria-expanded="false">
						<span class="m-accordion__item-icon"><i class="fab fa-php"></i></span>
						<span class="m-accordion__item-title">Loaded PHP extensions ({{ $php_exts_count }})</span>
						<span class="m-accordion__item-mode"></span>
					</div>
					<div class="m-accordion__item-body collapse" id="m_accordion_php_ext_body" role="tabpanel" aria-labelledby="m_accordion_php_ext_head" data-parent="#btabs-modules">
						<div class="m-accordion__item-content">
							<ul>
								<?php

								foreach($php_exts as $value)
								{
									?>
									<li>{{ $value }}</li>
									<?php
								}

								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection