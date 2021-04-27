<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<title>{{ setting('app_name') }} | Register</title>
		@include('layouts.header')
	</head>
	<body onload="initFonts();" class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(../../../assets/app/media/img//bg/bg-3.jpg);">
				<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
					<div class="m-login__container">
						<div class="m-login__logo">
							<img src="{{ asset('img/logo.png') }}" alt="Logo">
						</div>

						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">{{ setting('app_name') }} - Register</h3>
								<div class="m-login__desc">Enter your details to create your account:</div>
							</div>
							<form class="m-login__form m-form" action="{{ route('register') }}" method="post" autocomplete="off">
								@csrf
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Name" required autofocus maxlength="50" name="name">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="email" placeholder="E-mail" name="email" required maxlength="50">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="password" placeholder="Password" name="password" required minlength="{{ setting('min_pass_len') }}">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="password_confirmation" required minlength="{{ setting('min_pass_len') }}">
								</div>
								<div class="m-login__form-action">
									<button type="submit" id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">
										Sign Up
									</button>
									&nbsp;&nbsp;
									<a href="{{ route('login') }}" id="m_login_signup_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom m-login__btn">
										Cancel
									</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>