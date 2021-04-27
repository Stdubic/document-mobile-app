<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<title>{{ setting('app_name') }} | Admin panel</title>

		@include('layouts.header')

		<link rel="stylesheet" type="text/css" href="{{ asset('metronic/vendors/custom/datatables/datatables.bundle.css') }}">

		<script defer src="{{ asset('metronic/vendors/custom/datatables/datatables.bundle.js') }}"></script>
	</head>
	<body onload="mainInit();" onbeforeunload="blockPage();" class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<header id="m_header" class="m-grid__item m-header" m-minimize-offset="200" m-minimize-mobile-offset="200">
				<div class="m-container m-container--fluid m-container--full-height">
					<div class="m-stack m-stack--ver m-stack--desktop">
						<div class="m-stack__item m-brand  m-brand--skin-dark">
							<div class="m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									<a href="{{ route('home') }}" class="m-brand__logo-wrapper">
										<img src="{{ asset('img/logo.png') }}" alt="Logo" width="150">
									</a>
								</div>
								<div class="m-stack__item m-stack__item--middle m-brand__tools">
									<!-- BEGIN: Left Aside Minimize Toggle -->
									<a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block
					 ">
										<span></span>
									</a>
									<!-- END -->
									<!-- BEGIN: Responsive Aside Left Menu Toggler -->
									<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
										<span></span>
									</a>
									<!-- END -->
									<!-- BEGIN: Topbar Toggler -->
									<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
										<i class="flaticon-more"></i>
									</a>
									<!-- BEGIN: Topbar Toggler -->
								</div>
							</div>
						</div>

						<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
							<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
								<div class="m-stack__item m-topbar__nav-wrapper">
									<div class="btn-group m--margin-right-10 m--margin-top-10">
										<a href="{{ route('users.edit', Auth::user()->id) }}" class="btn btn-primary m-btn m-btn--icon m-btn--wide m-btn--md">
											<span>
												<i class="fa fa-user"></i>
												<span>{{ Auth::user()->name }}</span>
											</span>
										</a>
										<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split m-btn m-btn--md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
										<div class="dropdown-menu dropdown-menu-right">
											<a class="dropdown-item" href="{{ route('users.edit', Auth::user()->id) }}">
												<i class="fa fa-user"></i> Profile
											</a>
											<a class="dropdown-item" href="javascript:document.getElementById('logout-form').submit();">
												<i class="flaticon-logout"></i> Logout
											</a>
											<form id="logout-form" action="{{ route('logout') }}" method="post" hidden>
												@csrf
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
				<button type="button" class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn">
					<i class="la la-close"></i>
				</button>

				<div id="m_aside_left" class="m-grid__item m-aside-left m-aside-left--skin-dark">
					<!-- Side Content -->
					<div
						id="m_ver_menu"
						class="m-aside-menu m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
						m-menu-vertical="1"
						m-menu-scrollable="1" m-menu-dropdown-timeout="500"
						style="position: relative;">
							@include('layouts.navigation')
					</div>
					<!-- END Side Content -->
				</div>


					<div class="m-grid__item m-grid__item--fluid m-wrapper">
						<div class="m-content">
							<div class="m-portlet m-portlet--bordered m-portlet--rounded m-portlet--unair m-portlet--responsive-mobile" id="main_portlet">
								@yield('content')
							</div>
						</div>
					</div>
				</div>

			<footer class="m-grid__item	m-footer">
				<div class="m-container m-container--fluid m-container--full-height m-page__container">
					<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
						<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
							<span class="m-footer__copyright">
								Powered by
								<a href="{{ config('custom.dev_url') }}" class="m-link" target="_blank" rel="external">{{ config('custom.dev_name') }}</a>
							</span>
						</div>
						<?php

                        if(count($errors))
                        {
                        ?>
						<div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
							<ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
								<li class="m-nav__item">
									<a href="javascript:displayErrors('error-messages');" title="Display errors" class="m-nav__link">
                                            <span class="m-badge m-badge--danger m-badge--wide">
                                                <i class="fa fa-exclamation-triangle"></i> {{ count($errors) }}
                                            </span>
									</a>
								</li>
							</ul>
						</div>
                        <?php
                        }

                        ?>
					</div>
				</div>
			</footer>
		</div>

		<div id="m_scroll_top" class="m-scroll-top" title="Back to top">
			<i class="la la-arrow-up"></i>
		</div>

		<span id="error-messages" hidden>{{ json_encode($errors->all()) }}</span>
	</body>
</html>