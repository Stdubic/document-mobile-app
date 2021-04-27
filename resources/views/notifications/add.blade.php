@extends('layouts.master')

<?php

$form_action = route('notifications.store');
$mode = 'ADD';
$method = 'POST';
$actions = null;
$title = $body = '';
$notification_groups = [];

if(isset($notification))
{
    $title = $notification->title;
    $body = $notification->body;
    $notification_groups = $notification->groups;

    $form_action = route('notifications.update', $notification->id);
    $mode = 'UPDATE';
    $method = 'PUT';

    $actions = [
        [
            'type' => 'fire-notification',
            'action' => route('notifications.fire', $notification->id)
        ],
        [
            'type' => 'remove',
            'action' => route('notifications.remove', $notification->id)
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
            'value' => $title,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true
        ]
    ],
    [
        'label' => 'Body',
        'tag' => 'input',
        'attributes' => [
            'id' => 'body',
            'name' => 'body',
            'type' => 'text',
            'value' => $body,
            'maxlength' => 150,
            'required' => true
        ]
    ]
];

?>

@section('content')
    @include('layouts.close_button', ['title' => $mode.' NOTIFICATION', 'icon' => 'fa fa-broadcast-tower', 'actions' => $actions])
    <form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
        <div class="m-portlet__body">
            @csrf
            {{ method_field($method) }}
            <?php generate_form_fields($fields, $errors); ?>
            <div class="form-group m-form__group">
                <label class="m-checkbox m-checkbox--solid m-checkbox--primary" title="Toggle all">
                    <input type="checkbox" onclick="toggleCheckboxes(this.checked, 'groups-checkbox');"><span></span> Notification groups
                </label>
                <div class="m-checkbox-list m--margin-left-30">
                    <?php

                    foreach($groups as $curr_group)
                    {
                    $checked = '';

                    foreach($notification_groups as $group)
                    {
                        if($group->notification_group_id == $curr_group->id)
                        {
                            $checked = 'checked';
                            break;
                        }
                    }

                    ?>
                    <label class="m-checkbox m-checkbox--solid m-checkbox--primary">
                        <input type="checkbox" class="groups-checkbox" name="groups[]" value="{{ $curr_group->id }}" {{ $checked }}><span></span> {{ $curr_group->name }}
                    </label>
                    <?php
                    }

                    ?>
                </div>
            </div>
        </div>
        @include('layouts.submit_button')
    </form>
@endsection