<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<title>{{ setting('app_name') }} | 404</title>
		@include('layouts.header')
	</head>
	<body onload="initFonts();" onbeforeunload="blockPage();" class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-error-1" style="background-image: url('{{ asset('img/404.jpg') }}');">
				<div class="m-error_container">
					<span class="m-error_number">
						<h1>404</h1>
					</span>
					<p class="m-error_desc">OOPS! Something went wrong here</p>
					<p class="m-error_desc">
						<a href="{{ route('home') }}" class="m-link"><i class="fa fa-home"></i> Home</a>
					</p>
				</div>
			</div>
		</div>
	</body>
</html>