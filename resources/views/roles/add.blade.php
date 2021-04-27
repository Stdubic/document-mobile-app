@extends('layouts.master')

<?php

$form_action = route('roles.store');
$mode = 'ADD';
$method = 'POST';
$actions = null;
$name = $list_mode = $routes = '';
$view_all = false;

if(isset($role))
{
	$name = $role->name;
	$view_all = boolval($role->view_all);
	$list_mode = $role->mode;
	$routes = $role->routes;

	$form_action = route('roles.update', $role->id);
	$mode = 'UPDATE';
	$method = 'PUT';
	$actions = [
		[
			'type' => 'remove',
			'action' => route('roles.remove', $role->id)
		]
	];
}

$list_modes = [
	[
		'value' => App\Role::LIST_MODE_WHITE,
		'label' => 'Whitelist'
	],
	[
		'value' => App\Role::LIST_MODE_BLACK,
		'label' => 'Blacklist'
	]
];

$fields = [
	[
		'label' => 'Name',
		'tag' => 'input',
		'attributes' => [
			'id' => 'name',
			'name' => 'name',
			'type' => 'text',
			'value' => $name,
			'maxlength' => 50,
			'required' => true,
			'autofocus' => true
		]
	],
	[
		'label' => 'View all records',
		'tag' => 'checkbox',
		'side_label' => 'Yes',
		'attributes' => [
			'id' => 'view_all',
			'name' => 'view_all',
			'value' => 1,
			'type' => 'checkbox',
			'checked' => $view_all
		]
	],
	[
		'label' => 'Mode',
		'tag' => 'select',
		'options' => $list_modes,
		'selected' => $list_mode,
		'attributes' => [
			'id' => 'mode',
			'name' => 'mode',
			'required' => true
		]
	],
	[
		'label' => 'Routes - regex pattern, each in new line, methods delimited with "'.App\Role::METHOD_DELIM.'"',
		'tag' => 'textarea',
		'value' => $routes,
		'attributes' => [
			'id' => 'routes',
			'name' => 'routes',
			'maxlength' => 1000,
			'rows' => 10,
			'cols' => 50
		]
	]
];

?>

@section('content')
	@include('layouts.close_button', ['title' => $mode.' ROLE', 'icon' => 'fa fa-ban', 'actions' => $actions])
	<form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
		<div class="m-portlet__body">
			@csrf
			{{ method_field($method) }}
			<?php generate_form_fields($fields, $errors); ?>
		</div>
		@include('layouts.submit_button')
	</form>
@endsection