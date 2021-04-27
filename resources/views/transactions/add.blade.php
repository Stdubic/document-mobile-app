@extends('layouts.master')

<?php

$form_action = route('transactions.store');
$mode = '';
$method = 'POST';
$actions = null;
$name = $list_type = $routes = '';
$view_all = false;
$protected = 0;
$selected_user = false;

if(isset($transactions))
{
	$selected_user = $transactions->user_id;


	$form_action = route('transactions.update', $transactions->id);
	$mode = 'UPDATE';
	$method = 'PUT';
	$actions = [
		[
			'type' => 'remove',
			'action' => route('transactions.remove', $transactions->id)
		]
	];
}
$all_users = [
    [
        'value' => '',
        'label' => '-'
    ]
];

foreach($users as $row)
{
    $all_users[] = [
        'value' => $row->id,
        'label' => $row->surname.' '.$row->name
    ];
}


$fields = [
    [
        'label' => 'Select User to upgrade',
        'tag' => 'select',
        'options' => $all_users,
        'selected' => $selected_user,
        'attributes' => [
            'id' => 'user_id',
            'name' => 'user_id',
            'required' => true
        ]
    ]

];

?>

@section('content')
	@include('layouts.close_button', ['title' => $mode.' UPGRADE USER', 'icon' => 'fa fa-ban', 'actions' => $actions])
	<form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
		<div class="m-portlet__body">
			@csrf
			{{ method_field($method) }}
			<?php generate_form_fields($fields, $errors); ?>
		</div>
		@include('layouts.submit_button')
	</form>
@endsection