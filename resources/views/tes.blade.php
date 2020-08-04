
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- tailwindcss !-->
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <!-- tailwindcss !-->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Publink</title>
    
    
    <style>
        #content>p{
        padding:0px;
        margin:0px;
        }
        #chapter-title{
            white-space: nowrap;
        }
        .savemenubutton{
    
        }
        h2{
            background: black;
            color: white;
            font-size: 100%;
            font-weight: bold;
            margin: 0.7em 0 0.1em 0;
            padding: .25em 1em .25em 1em;
            -webkit-border-radius: .7em;
            -moz-border-radius: 1em;
        }
    
    </style>
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
            <div class="mt-8"></div>
            <div class="container">
                <div  style="text-align:center; max-width: 60%; height:100%; overflow:auto; " class="ui mt-8 centered mx-auto" style="resize:vertical" >
                    @if(session('success'))
                    <div class="ui icon success message ">
                        <i class="info icon"></i>
                        <div class="content">
                            <div class="header">
                            Save Success
                            </div>
                            <p>{{session('success')}}</p>
                        </div>
                    </div>
                    @endif
                </div>
                    <div class="mt-8"></div>
                <div id="rescontent" role="article" style="user-select:none;-moz-user-select:none;-webkit-user-select:none;-ms-user-select:none;-webkit-touch-callout:none;cursor:default" onselectstart="return false" ondragstart="return false" unselectable="on" class="story_text">
                </div>
        </div>
</body>
</html>
