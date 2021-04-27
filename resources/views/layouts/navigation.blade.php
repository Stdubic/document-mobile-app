<ul class="m-menu__nav m-menu__nav--dropdown-submenu-arrow">
	<?php

	$tab = Route::currentRouteName();
	$navbar_schema = config('navbar');
	$user = Auth::user();
	$user_routes = $user->role->routes;

	foreach($navbar_schema as $page)
	{
		$type = $title = $icon_class = '';

		if(isset($page['type'])) $type = strtolower(trim($page['type']));
		if(isset($page['title'])) $title = trim($page['title']);
		if(isset($page['icon_class'])) $icon_class = trim($page['icon_class']);

		if($type == 'divider')
		{
			?>
			<li class="m-menu__section">
				<h4 class="m-menu__section-text">{{ $title }}</h4>
				<i class="m-menu__section-icon flaticon-more-v3"></i>
			</li>
			<?php
		}
		else if($type == 'url' || !isset($page['items']) || !count($page['items']))
		{
			$route = trim($page['route']);
			if(!$user->canViewRoute(route($route, [], false))) continue;

			if($route == $tab) $is_active_class = 'm-menu__item--active';
			else $is_active_class = '';

			?>
			<li class="m-menu__item {{ $is_active_class }}" aria-haspopup="true" >
				<a href="{{ route($route) }}" class="m-menu__link">
					<i class="m-menu__link-icon {{ $icon_class }}"></i>
					<span class="m-menu__link-title">
						<span class="m-menu__link-wrap">
							<span class="m-menu__link-text">{{ $title }}</span>
						</span>
					</span>
				</a>
			</li>
			<?php
		}
		else
		{
			$items = $page['items'];
			$items_check = false;
			$is_open_class = '';

			foreach($items as $item)
			{
				$route = trim($item['route']);
				if(!$user->canViewRoute(route($route, [], false))) continue;

				if($route == $tab) $is_open_class = 'm-menu__item--open';
				$items_check = true;
			}

			if(!$items_check) continue;

			?>
			<li class="m-menu__item m-menu__item--submenu {{ $is_open_class }}" aria-haspopup="true" m-menu-submenu-toggle="hover">
				<a href="javascript:;" class="m-menu__link m-menu__toggle">
					<i class="m-menu__link-icon {{ $icon_class }}"></i>
					<span class="m-menu__link-text">{{ $title }}</span>
					<i class="m-menu__ver-arrow la la-angle-right"></i>
				</a>
				<div class="m-menu__submenu">
					<span class="m-menu__arrow"></span>
					<ul class="m-menu__subnav">
						<li class="m-menu__item m-menu__item--parent" aria-haspopup="true">
							<span class="m-menu__link">
								<span class="m-menu__link-text">{{ $title }}</span>
							</span>
						</li>
						<?php

						foreach($items as $item)
						{
							$route = trim($item['route']);
							if(!$user->canViewRoute(route($route, [], false))) continue;

							$title = trim($item['title']);

							if($route == $tab) $is_active_class = 'm-menu__item--active';
							else $is_active_class = '';

							?>
							<li class="m-menu__item {{ $is_active_class }}" aria-haspopup="true" >
								<a  href="{{ route($route) }}" class="m-menu__link ">
									<i class="m-menu__link-bullet m-menu__link-bullet--dot">
										<span></span>
									</i>
									<span class="m-menu__link-text">{{ $title }}</span>
								</a>
							</li>
							<?php
						}

						?>
					</ul>
				</div>
			</li>
			<?php
		}
	}

	?>
	<li class="m-menu__section">
		<h4 class="m-menu__section-text">{{ $user->name }}</h4>
		<i class="m-menu__section-icon flaticon-more-v3"></i>
	</li>
	<li class="m-menu__item m-menu__item" aria-haspopup="true" >
		<a href="javascript:document.getElementById('logout-form').submit();" class="m-menu__link">
			<i class="m-menu__link-icon flaticon-logout"></i>
			<span class="m-menu__link-title">
				<span class="m-menu__link-wrap">
					<span class="m-menu__link-text">Logout</span>
				</span>
			</span>
		</a>
	</li>
</ul>