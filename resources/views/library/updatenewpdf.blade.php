<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Upload New Version</title>
    <style>
    .book-img{
    max-width:280px;
    max-height:300px;
    }
    </style>
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
<div class="ui container mt-8">
        <h1 class="header">
                Upload
            </h1>
            @if(count($errors)>0)
                <div class="ui error message">
                    <div class="header">
                    There were some errors with your submission
                    </div>
                    <ul class="list">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif   
            @if(session('success'))
                <div class="ui icon success message">
                    <i class="info icon"></i>
                    <div class="content">
                        <div class="header">
                            Success
                        </div>
                        <p>{{session('success')}}</p>
                    </div>
                </div>
                @endif
            <div class="book-info">
                <h3 class="header">
                {{$books->title}}
                </h3>
                @if($books->cover!=null)
                <img class="book-img" src ="/storage/{{$books->cover }}" >
                @endif
            </div>
            <div class="text-sm">
                Last Updated On {{$books->updated_at}}
            </div>
            <div class="text-xl">This is where you can upload your new version of the book.</div>
    @if($books!=null)
        <div class="mt-4"></div>
        <div class="p-4 shadow-md bg-white">
            <form id='formupload' class="ui form" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}  
                    <input type="hidden" value="{{$books->book_id}}" name="bookid">
                    {{-- <input type="hidden" name="uID" value="{{session('user')->user_id}}"> --}}
                    <div class="field">
                    <label>UPLOAD PDF</label>
                    <input name="pdf" accept="application/pdf" type="file"></input>
                    </div>
                    <div  class="ui buttons">
                    {{csrf_field()}}
                        <input type="hidden" name="bookid" value="{{$books->book_id}}">
                        <input type="submit" name="SUBMIT" value="Cancel" class="ui button"/>
                        <div class="or"></div>
                        <input type="submit" name="SUBMIT" value="Upload" class="ui blue button"/>
                    </div>
            </form>
        </div>

    @endif
</div>
</body>
</html>