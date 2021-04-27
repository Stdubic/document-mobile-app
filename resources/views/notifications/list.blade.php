@extends('layouts.master')

<?php

$actions = [
    [
        'type' => 'fire-notification',
        'action' => route('notifications.fire-multi')
    ],
    [
        'type' => 'remove',
        'action' => route('notifications.remove-multi')
    ]
];

?>

@section('content')
    @include('layouts.list_header', ['title' => 'Notifications', 'icon' => 'fa fa-broadcast-tower', 'path' => 'notifications.add', 'actions' => $actions])
    <div class="m-portlet__body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Notification groups</th>
                    <th>Created at</th>
                    <th>@include('layouts.options_column_header')</th>
                </tr>
                </thead>
                <tbody align="center">
                <?php

                foreach($notifications as $row)
                {
                ?>
                <tr>
                    <td>{{ $row->title }}</td>
                    <td>{{ $row->body }}</td>
                    <td>{{ count($row->groups) }}</td>
                    <td>{{ $row->created_at->format(setting('date_format')) }}</td>
                    <td>@include('layouts.option_buttons', ['path' => route('notifications.edit', $row->id), 'value' => $row->id])</td>
                </tr>
                <?php
                }

                ?>
                </tbody>
            </table>
        </div>
    </div>
@endsection