<!DOCTYPE html>
<html>
<head>
    <title>Paypal payment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <style type="text/css">
        .container {
            display: flex;
            margin: 18% 4%;
            flex: 1;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.3);
            height: 100%;
            padding: 6% 0%;
        }
        .loading{
            display:none;
            z-index: 1000;
            flex:1;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: absolute;
            top:0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.7);
        }
        p {
            padding: 1px 15px;
            font-weight: 600;
            text-align: center;
            font-family: Open Sans;
            font-family: 'Open Sans', sans-serif;
            font-size: 24px;
        }

    </style>
</head>
<body>
<div class="container">
    <p>Thank you {{$user->name}}, we will process your upgrade request.</p>

</body>
</html>