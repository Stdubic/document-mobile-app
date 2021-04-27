@extends('layouts.master')

<?php

$form_action = route('documents.store');
$mode = 'ADD';
$method = 'POST';
$actions = null;
$name = $list_mode = $routes = '';
$view_all = false;

if(isset($document))
{
    $name = $document->title;
    $view_all = boolval($document->view_all);
    $list_mode = $document->mode;
    $routes = $document->routes;

    $form_action = route('documents.update', $document->id);
    $mode = 'UPDATE';
    $method = 'PUT';
    $actions = [
        [
            'type' => 'remove',
            'action' => route('documents.remove', $document->id)
        ]
    ];
}

?>

@section('content')
	@include('layouts.close_button', ['title' => $mode.' DOCUMENT', 'icon' => 'fa fa-ban', 'action' => 'onclick=saveNode()', 'actions' => $actions])
    <style type="text/css">
        .container {
            display: flex;
            flex-direction: row;
            width: 100%;
            justify-content: space-between;
        }
        .controls{
            margin: auto;
            width: 60%;
            padding: 10px;
        }

        #structure,
        #edit {
            width: 50%;
            border: 1px solid silver;
            margin: 20px;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }
    </style>
    <div class="controls">
        <button class=" btn btn-success m-btn m-btn--icon" onclick="addSentence()">Add sentence</button>
        <button class=" btn btn-success m-btn m-btn--icon" onclick="addSection()">Add sub-section</button>
        <button class=" btn btn-success m-btn m-btn--icon" onclick="addImage()">Add image</button>
        <button class=" btn btn-danger m-btn m-btn--icon" onclick="deleteNode()">Delete X</button>
    </div>
    <div class="container">
        <div id="structure"></div>
        <div id="edit">
        </div>
    </div>

    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions"> <button onclick="saveNode()" class="btn btn-success" type="submit"> <span> <i class="fa fa-save"></i> <span>Save</span> </span> </button>
        </div>
    </div>


    <script>
        const userToken = "<?=$user?>";
        window.addEventListener('load', function() {
            const edit_document_id = -1;
            refreshDocument(edit_document_id);
        });
    </script>
@endsection