<meta name="application-name" content="{{ setting('app_name') }}">
<meta name="author" content="{{ config('custom.dev_name') }}">
<link rel="author" href="{{ config('custom.dev_url') }}">
<meta http-equiv="content-type" content="text/html">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="canonical" href="{{ url()->current() }}">
<link rel="alternate" hreflang="en" href="{{ url()->current() }}">

<meta name="twitter:card" content="summary">
<meta property="og:type" content="website">
<meta property="og:title" content="{{ setting('app_name') }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ asset('img/logo.png') }}">

<link rel="shortcut icon" type="image/ico" href="{{ asset('img/favicon.ico') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('metronic/vendors/base/vendors.bundle.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('metronic/demo/default/base/style.bundle.css') }}">

<script defer src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
<script defer src="{{ asset('metronic/vendors/base/vendors.bundle.js') }}"></script>
<script defer src="{{ asset('metronic/demo/default/base/scripts.bundle.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
<script defer src="{{ asset('js/main.js') }}"></script>