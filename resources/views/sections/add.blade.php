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
$all_documents = [
    [
        'value' => '',
        'label' => '-'
    ]
];

foreach($documents as $document)
{
    $all_documents[] = [
        'value' => $document->id,
        'label' => $document->title
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
    [
        'label' => 'Description',
        'tag' => 'input',
        'attributes' => [
            'id' => 'description',
            'name' => 'description',
            'type' => 'text',
            'value' => $name,
            'maxlength' => 50,
            'required' => true,
            'autofocus' => true
        ]
    ],
    [
        'label' => 'Document',
        'tag' => 'select',
        'options' => $all_documents,
        'attributes' => [
            'id' => 'document_id',
            'name' => 'document_id',
            'required' => true,
            'onchange' => 'Section.listSectionsFromDocument(this)'
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
            <div >
                <label>Section</label>
                <input type="hidden" name="parent_section_id" id="selected_section_id" value="0">
                <div id="sections" class="sections form-group m-form__group">

                </div>
            </div>


        </div>
        @include('layouts.submit_button')
    </form>
@endsection