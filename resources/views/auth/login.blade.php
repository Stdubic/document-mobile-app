<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<title>{{ setting('app_name') }} | Log in</title>
		@include('layouts.header')
	</head>
	<body onload="initFonts();" class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(../../../assets/app/media/img//bg/bg-3.jpg);">
				<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
					<div class="m-login__container">
						<div class="m-login__logo">
							<img src="{{ asset('img/logo-front.png') }}" alt="Logo">
						</div>

						<div class="m-login__signin">
							<div class="m-login__head" align="center">
								<h3 class="m-login__title">{{ setting('app_name') }}</h3>
								<small>Powered by <a class="m-link" href="{{ config('custom.dev_url') }}" rel="external" target="_blank">{{ config('custom.dev_name') }}</a></small>
							</div>
							<form class="m-login__form m-form" action="{{ route('login') }}" method="post">
								@csrf
								<div class="form-group m-form__group">
									<input class="form-control m-input" type="email" autofocus required maxlength="50" placeholder="E-mail" name="email">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" required placeholder="Password" name="password" minlength="{{ setting('min_pass_len') }}">
								</div>
								<div class="row m-login__form-sub">
									<div class="col m--align-right m-login__form-right">
										<a href="{{ route('password.request') }}" id="m_login_forget_password" class="m-link">
											Forget Password?
										</a>
									</div>
								</div>
								<div class="m-login__form-action">
									<button type="submit" id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
										Log in
									</button>
								</div>
							</form>
						</div>
						<?php

						if(setting('registration_active'))
						{
							?>
							<div class="m-login__account">
								<span class="m-login__account-msg">Don't have an account yet?</span>
								&nbsp;&nbsp;
								<a href="{{ route('register') }}" id="m_login_signup" class="m-link m-link--light m-login__account-link">Sign Up</a>
							</div>
							<?php
						}

						?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>