<?php

sort($methods);

foreach($methods as $method)
{
	$method = strtoupper($method);

	switch($method)
	{
		case 'GET':
		{
			$state = 'info';
			break;
		}
		case 'POST':
		{
			$state = 'success';
			break;
		}
		case 'PUT':
		{
			$state = 'warning';
			break;
		}
		case 'DELETE':
		{
			$state = 'danger';
			break;
		}
		case 'PATCH':
		{
			$state = 'primary';
			break;
		}
		default:
		{
			$state = 'secondary';
			break;
		}
	}

	?><span class="m-badge m-badge--{{ $state }} m-badge--wide">{{ $method }}</span> <?php
}