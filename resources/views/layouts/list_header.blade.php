<div class="m-portlet__head">
	<div class="m-portlet__head-wrapper">
		<div class="m-portlet__head-caption">
			<div class="m-portlet__head-title">
				<span class="m-portlet__head-icon">
					<i class="{{ $icon }}"></i>
				</span>
				<h3 class="m-portlet__head-text m--font-primary">{{ strtoupper($title) }}</h3>
			</div>
		</div>
		<div class="m-portlet__head-tools">
			<ul class="m-portlet__nav">
				<li class="m-portlet__nav-item">
					<a href="{{ url()->full() }}" title="Refresh" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-refresh"></i></a>
				</li>
				<li class="m-portlet__nav-item">
					<a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-angle-down"></i></a>
				</li>
				<li class="m-portlet__nav-item">
					<a href="#" m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon"><i class="la la-expand"></i></a>
				</li>
			</ul>
			<?php

			if(isset($actions))
			{
				?>
				<div class="dropdown m--margin-left-10">
					<button type="button" form="main-form" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span>
							<i class="fa fa-cogs"></i>
							<span>Actions</span>
						</span>
					</button>
					<div class="dropdown-menu">
						@include('layouts.action_buttons', compact('actions'))
					</div>
				</div>
				<?php
			}

			if(isset($path) && getUser()->canViewRoute(route($path, [], false)))
			{
				?>
				<a href="{{ route($path) }}" class="btn btn-success m-btn m-btn--icon m--margin-left-10">
					<span>
						<i class="fa fa-plus"></i>
						<span>Add</span>
					</span>
				</a>
				<?php
			}

			?>
		</div>
	</div>
</div>