@extends('layouts.master')

<?php

$form_action = route('notification-groups.store');
$mode = 'ADD';
$method = 'POST';
$actions = null;
$name = '';

if(isset($group))
{
    $name = $group->name;

    $form_action = route('notification-groups.update', $group->id);
    $mode = 'UPDATE';
    $method = 'PUT';
    $actions = [
        [
            'type' => 'remove',
            'action' => route('notification-groups.remove', $group->id)
        ]
    ];
}

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
    ]
];

?>

@section('content')
    @include('layouts.close_button', ['title' => $mode.' NOTIFICATION GROUP', 'icon' => 'fa fa-broadcast-tower', 'actions' => $actions])
    <form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
        <div class="m-portlet__body">
            @csrf
            {{ method_field($method) }}
            <?php generate_form_fields($fields, $errors); ?>
        </div>
        @include('layouts.submit_button')
    </form>
@endsection