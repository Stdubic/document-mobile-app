@extends('layouts.master')

<?php

$form_action = route('sections.store');
$mode = 'ADD';
$method = 'POST';
$actions = null;
$name = $list_mode = $routes = '';
$view_all = false;

if(isset($section))
{
    $name = $section->title;
    $view_all = boolval($section->view_all);
    $list_mode = $section->mode;
    $routes = $section->routes;

    $form_action = route('documents.update', $section->id);
    $mode = 'UPDATE';
    $method = 'PUT';
    $actions = [
        [
            'type' => 'remove',
            'action' => route('documents.remove', $section->id)
        ]
    ];
}


$fields = [
    [
        'label' => 'Title',
        'tag' => 'input',
        'attributes' => [
            'id' => 'name',
            'name' => 'title',
            'type' => 'text',
            'value' => $name,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true
        ]
    ],
];

?>

@section('content')
    @include('layouts.close_button', ['title' => $mode.' SECTION', 'icon' => 'fa fa-ban', 'actions' => $actions])
    <form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
        <div class="m-portlet__body">
            @csrf
            {{ method_field($method) }}
            <?php generate_form_fields($fields, $errors); ?>



            <?php
            if(isset($sentences)){
            ?>
            <label>Senteces:</label>
            <table width="100%" class="table table-bordered table-striped table-hover js-datatable">
                <thead>
                <tr>
                    <th>Sentance</th>
                    <th>Date</th>
                    <th>@include('layouts.options_column_header')</th>
                </tr>
                </thead>
                <?php
                foreach($sentences as $row)
                {
                ?>

                <tbody align="center">
                <tr>
                    <td>{{ $row->title }}</td>
                    <td>{{ $row->created_at->format(setting('date_format')) }}</td>
                    <td>@include('layouts.option_buttons', ['path' => route('sentences.edit', $row->id), 'value' => $row->id])</td>
                </tr>
                </tbody>

                <?php
                }
                }
                ?>
            </table>
        </div>
        @include('layouts.submit_button')
    </form>
@endsection
