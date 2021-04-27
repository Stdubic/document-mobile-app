@extends('layouts.master')

<?php

$form_action = route('terms.store');
$mode = 'ADD';
$method = 'POST';
$actions = null;
$name = $list_type = $routes = '';
$view_all = false;
$description = '';


if(isset($term))
{
	$name = $term->title;
	$description = $term->description;


	$form_action = route('terms.update', $term->id);
	$mode = 'UPDATE';
	$method = 'PUT';
	$actions = [
		[
			'type' => 'remove',
			'action' => route('terms.remove', $term->id)
		]
	];
}

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
        'label' => 'Description',
        'tag' => 'textarea',
        'value' => $description,
        'attributes' => [
            'id' => 'description',
            'name' => 'description',
            'maxlength' => 5000,
            'rows' => 50,
            'cols' => 100
        ]
    ]

];

?>

@section('content')
	@include('layouts.close_button', ['title' => $mode.' TERMS OF USE', 'icon' => 'fa fa-ban', 'actions' => $actions])
	<form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
		<div class="m-portlet__body">
			@csrf
			{{ method_field($method) }}
			<?php generate_form_fields($fields, $errors); ?>
		</div>
		@include('layouts.submit_button')
	</form>
@endsection