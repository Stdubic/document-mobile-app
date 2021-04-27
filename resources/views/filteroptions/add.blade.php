@extends('layouts.master')

<?php

$form_action = route('filteroptions.store');
$mode = 'ADD';
$method = 'POST';
$actions = null;
$name = $list_type = $routes = '';
$view_all = false;
$active_filter = null;
$protected = 0;
$order = 0;

if(isset($filter))
{
	$name = $filter->title;
	$list_type = $filter->type;
    $active_filter = $filter->filter_id;
    $protected = boolval($filter->protected);
    $order = $filter->order;

	$form_action = route('filteroptions.update', $filter->id);
	$mode = 'UPDATE';
	$method = 'PUT';
	$actions = [
		[
			'type' => 'remove',
			'action' => route('filteroptions.remove', $filter->id)
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
$all_filters = [
    [
        'value' => '',
        'label' => '-'
    ]
];

foreach($filters as $row)
{
    $all_filters[] = [
        'value' => $row->id,
        'label' => $row->title
    ];
}

$fields = [
    [
        'label' => 'Filter',
        'tag' => 'select',
        'options' => $all_filters,
        'selected' => $active_filter,
        'attributes' => [
            'id' => 'filter_id',
            'name' => 'filter_id',
            'required' => true
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
        'label' => 'Order',
        'tag' => 'input',
        'attributes' => [
            'id' => 'order',
            'name' => 'order',
            'type' => 'order',
            'value' => $order,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true
        ]
    ],

];

?>

@section('content')
	@include('layouts.close_button', ['title' => $mode.' FILTER OPTIONS', 'icon' => 'fa fa-ban', 'actions' => $actions])
	<form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
		<div class="m-portlet__body">
			@csrf
			{{ method_field($method) }}
			<?php generate_form_fields($fields, $errors); ?>
		</div>
		@include('layouts.submit_button')
	</form>
@endsection