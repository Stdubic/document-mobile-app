@extends('layouts.master')

<?php

$form_action = route('filters.store');
$mode = 'ADD';
$method = 'POST';
$actions = null;
$name = $list_type = $routes = '';
$view_all = false;
$protected = 0;
$order = 0;

if(isset($filter))
{
	$name = $filter->title;
	$list_type = $filter->type;
    $protected = boolval($filter->protected);
    $order = $filter->order;

	$form_action = route('filters.update', $filter->id);
	$mode = 'UPDATE';
	$method = 'PUT';
	$actions = [
		[
			'type' => 'remove',
			'action' => route('filters.remove', $filter->id)
		]
	];
}

$list_types = [
	[
		'value' => 'dropdown',
		'label' => 'Dropdown'
	],
	[
		'value' => 'select',
		'label' => 'Select'
	]
];

$fields = [
	[
		'label' => 'Title',
		'tag' => 'input',
		'attributes' => [
			'id' => 'title',
			'name' => 'title',
			'type' => 'text',
			'value' => $name,
			'maxlength' => 50,
			'required' => true,
			'autofocus' => true
		]
	],
    [
        'label' => 'Protected',
        'tag' => 'checkbox',
        'side_label' => 'Yes',
        'attributes' => [
            'id' => 'protected',
            'name' => 'protected',
            'value' => 1,
            'type' => 'checkbox',
            'checked' => $protected
        ]
    ],

	[
		'label' => 'Type',
		'tag' => 'select',
		'options' => $list_types,
		'selected' => $list_type,
		'attributes' => [
			'id' => 'type',
			'name' => 'type',
			'required' => true
		]
	],
    [
        'label' => 'Order',
        'tag' => 'input',
        'attributes' => [
            'id' => 'order',
            'name' => 'order',
            'type' => 'text',
            'value' => $order,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true
        ]
    ],

];

?>

@section('content')
	@include('layouts.close_button', ['title' => $mode.' FILTER', 'icon' => 'fa fa-ban', 'actions' => $actions])
	<form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
		<div class="m-portlet__body">
			@csrf
			{{ method_field($method) }}
			<?php generate_form_fields($fields, $errors); ?>
		</div>
		@include('layouts.submit_button')
	</form>
@endsection