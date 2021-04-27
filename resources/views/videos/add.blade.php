@extends('layouts.master')

<?php

$form_action = route('videos.store');
$mode = 'ADD';
$method = 'POST';
$actions = $video_upload_dir = $image_upload_dir = null;
$title = '';
$description = '';
$protected = 0;

if(isset($video))
{
    $title = $video->name;
    $description = $video->description;

    $form_action = route('videos.update', $video->id);
    $mode = 'UPDATE';
    $method = 'PUT';
    $video_upload_dir = 'videos/'.$video->id.'/video';
    $image_upload_dir = 'videos/'.$video->id.'/image';

    $protected = boolval($video->protected);
    $actions = [
        [
            'type' => 'remove',
            'action' => route('videos.remove', $video->id)
        ]
    ];
}



$fields_basic = [
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
        'label' => 'Video description',
        'tag' => 'textarea',
        'value' => $description,
        'attributes' => [
            'id' => 'description',
            'name' => 'description',
            'maxlength' => 500,
            'rows' => 10,
            'cols' => 50
        ]
    ]

];

$fields_video = [
    [
        'label' => 'Video',
        'tag' => 'input',
        'attributes' => [
            'id' => 'contest_video',
            'name' => 'media[video]',
            'type' => 'file',
            'accept' => 'video/*',
            'onchange' => 'showMedia(this, \'video-gallery\');'
        ]
    ]
];

$fields_image = [
    [
        'label' => 'Image',
        'tag' => 'input',
        'attributes' => [
            'id' => 'contest_image',
            'name' => 'media[image]',
            'type' => 'file',
            'accept' => 'image/*',
            'onchange' => 'showMedia(this, \'image-gallery\');'
        ]
    ]
];
$fields_protected = [

    [
        'label' => 'Protected',
        'tag' => 'checkbox',
        'side_label' => 'Yes',
        'attributes' => [
            'id' => 'protected',
            'name' => 'protected',
            'value' => 1,
            'type' => 'checkbox',
            'checked' => $protected
        ]
    ]
];

if(isset($filter_options_per_video)){
$array = array();
foreach ($filter_options_per_video as $item){

    $array[] = $item['filter_options_id'];

}
}
foreach ($filter_options as $filter_option){
if(isset($filter_options_per_video)){
    if (in_array($filter_option['id'], $array)) {
        $active = true;
    }
    else {
        $active = false;
    }
    }
else{
    $active = false;
    }
    $fields_filters[] = array(
                    'label' => $filter_option['filter']['title'],
                    'tag' => 'checkbox',
                    'side_label' => $filter_option['title'],
                    'attributes' => [
                        'id' => $filter_option['id'],
                        'name' => 'filters['.$filter_option['id'].']',
                        'value' => $filter_option['id'],
                        'type' => 'checkbox',
                        'checked' => $active,
                    ]);
}

?>

@section('content')
    @include('layouts.close_button', ['title' => $mode.' VIDEO', 'icon' => 'fa fa-clock', 'actions' => $actions])
    <div class="m-portlet__body">
        <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary m-tabs-line--2x" role="tablist">
            <li class="nav-item m-tabs__item">
                <a href="#btabs-basic" class="nav-link m-tabs__link active" data-toggle="tab"><i class="fa fa-info"></i> Basic</a>
            </li>
            <li class="nav-item m-tabs__item">
                <a href="#btabs-media" class="nav-link m-tabs__link" data-toggle="tab"><i class="fa fa-image"></i> Media</a>
            </li>
            <li class="nav-item m-tabs__item">
                <a href="#btabs-protected" class="nav-link m-tabs__link " data-toggle="tab"><i class="fa fa-exclamation-triangle"></i> Protected</a>
            </li>
            <li class="nav-item m-tabs__item">
                <a href="#btabs-filters" class="nav-link m-tabs__link " data-toggle="tab"><i class="fa fa-search"></i> Filters</a>
            </li>
        </ul>
        <form class="m-form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form" enctype="multipart/form-data">
            <div class="m-portlet__body tab-content">
                @csrf
                {{ method_field($method) }}
                <div class="tab-pane active" id="btabs-basic" role="tabpanel">
                    <?php generate_form_fields($fields_basic, $errors); ?>

                </div>
                <div class="tab-pane" id="btabs-media" role="tabpanel">
                    <?php

                    generate_gallery_fields([
                        'fields' => $fields_video,
                        'gallery_id' => 'video-gallery',
                        'upload_dir' => $video_upload_dir,
                        'errors' => $errors
                    ]);

                    generate_gallery_fields([
                        'fields' => $fields_image,
                        'gallery_id' => 'image-gallery',
                        'upload_dir' => $image_upload_dir,
                        'errors' => $errors
                    ]);

                    ?>
                </div>
                <div class="tab-pane" id="btabs-protected" role="tabpanel">
                    <?php generate_form_fields($fields_protected, $errors); ?>

                </div>
                <div class="tab-pane" id="btabs-filters" role="tabpanel">
                    <?php generate_form_fields($fields_filters, $errors); ?>

                </div>

            </div>
            @include('layouts.submit_button')
        </form>
    </div>
@endsection