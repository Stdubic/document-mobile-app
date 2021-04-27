@extends('layouts.master')

<?php

$form_action = route('sentences.store');
$mode = 'ADD';
$method = 'POST';
$actions = null;
$name = $list_mode = $routes = '';
$view_all = false;

if(isset($sentence))
{
    $name = $sentence->text;
    $view_all = boolval($sentence->view_all);
    $list_mode = $sentence->mode;
    $routes = $sentence->routes;

    $form_action = route('sentences.update', $sentence->id);
    $mode = 'UPDATE';
    $method = 'PUT';
    $actions = [
        [
            'type' => 'remove',
            'action' => route('sentences.remove', $sentence->id)
        ]
    ];
}
$all_documents = [
    [
        'value' => -1,
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
        'label' => 'Text',
        'tag' => 'textarea',
        'value' => $name,
        'attributes' => [
            'id' => 'text',
            'name' => 'text',
            'rows' => 10,
            'cols' => 50,
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
            'onchange' => 'Sentence.listSectionsFromDocument(this)'
        ]
    ],
];

?>

@section('content')
    @include('layouts.close_button', ['title' => $mode.' Sentence', 'icon' => 'fa fa-ban', 'actions' => $actions])
    <form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form">
        <div class="m-portlet__body">
            @csrf
            {{ method_field($method) }}
            <?php generate_form_fields($fields, $errors); ?>
            <div >
                <label>Belongs to Section</label>
                <input type="hidden" name="section_id" id="section_id" value="0">
                <div id="sections" class="sections form-group m-form__group">

                </div>
                <span id="message" class="m-form__help"></span>
            </div>


        </div>
        @include('layouts.submit_button')
    </form>
@endsection