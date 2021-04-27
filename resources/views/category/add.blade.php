@extends('layouts.master')

<?php

$form_action = route('category.store');
$mode = 'ADD';
$method = 'POST';
$actions = null;
$name = $list_type = $routes = '';
$view_all = false;
$order = 0;
$protected = 0;

if(isset($category))
{
	$name = $category->name;
	$order = $category->order;
    $protected = boolval($category->protected);

	$form_action = route('category.update', $category->id);
	$mode = 'UPDATE';
	$method = 'PUT';
	$actions = [
		[
			'type' => 'remove',
			'action' => route('category.remove', $category->id)
		]
	];
}


$fields = [
	[
		'label' => 'Title',
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
    ]


];

?>

@section('content')
	@include('layouts.close_button', ['title' => $mode.' COMMENT CATEGORY', 'icon' => 'fa fa-ban', 'actions' => $actions])
	<form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
		<div class="m-portlet__body">
			@csrf
			{{ method_field($method) }}
			<?php generate_form_fields($fields, $errors); ?>
		</div>
		@include('layouts.submit_button')
	</form>
@endsection