@extends('layouts.master')

<?php

$actions = [
    [
        'type' => 'remove',
        'action' => route('notification-groups.remove-multi')
    ]
];

?>

@section('content')
    @include('layouts.list_header', ['title' => 'Notification groups', 'icon' => 'fa fa-broadcast-tower', 'path' => 'notification-groups.add', 'actions' => $actions])
    <div class="m-portlet__body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Notifications</th>
                    <th>Created at</th>
                    <th>@include('layouts.options_column_header')</th>
                </tr>
                </thead>
                <tbody align="center">
                <?php

                foreach($groups as $row)
                {
                ?>
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ count($row->notifications) }}</td>
                    <td>{{ $row->created_at->format(setting('date_format')) }}</td>
                    <td>@include('layouts.option_buttons', ['path' => route('notification-groups.edit', $row->id), 'value' => $row->id])</td>
                </tr>
                <?php
                }

                ?>
                </tbody>
            </table>
        </div>
    </div>
@endsection