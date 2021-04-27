@extends('layouts.master')

<?php

$actions = [
    [
        'type' => 'remove',
        'action' => route('videos.remove-multi')
    ],
    [
        'type' => 'activate',
        'action' => route('videos.activate')
    ],
    [
        'type' => 'deactivate',
        'action' => route('videos.deactivate')
    ]
];


?>

@section('content')
    @include('layouts.list_header', ['title' => 'Videos', 'icon' => 'fa fa-clock', 'path' => 'videos.add', 'actions' => $actions])
    <div class="m-portlet__body">
        <div class="table-responsive">
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Protected</th>
                    <th>Active</th>
                    <th>@include('layouts.options_column_header')</th>
                </tr>
                </thead>
                <tbody align="center">
                <?php

                foreach($videos as $row)
                {
                ?>
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->created_at->format(setting('date_format')) }}</td>
                    <td>@include('layouts.bool_badge', ['value' => $row->protected])</td>
                    <td>@include('layouts.bool_badge', ['value' => $row->active])</td>
                    <td>@include('layouts.option_buttons', ['path' => route('videos.edit', $row->id), 'value' => $row->id])</td>
                </tr>
                <?php
                }

                ?>
                </tbody>
            </table>
        </div>
    </div>
@endsection