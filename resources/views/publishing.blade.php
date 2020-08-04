<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8">
    
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
    <title>Publish New Version</title>
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
                Publish
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
                                    Success, your book has been published.
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
            <div class="text-xl">
                This is where you can publish your book {{Session::get('user')->name}} with the click of a button.
            </div>
    @if($books!=null)
            <div class="mt-4"></div>
            <div class="p-4 shadow-md bg-white">
                <div class="font-medium text-xl"> Clicking this button will publish your book for the first time and make it available for purchase. Don't hesitate to publish! You can update your book as often as you like, and your readers will get free updates.</div>
                <div class="mt-12">
                </div>
                <form method="POST" action="/publishing" class="ui buttons">
                  {{csrf_field()}}
                  <input type="hidden" name="bookid" value="{{$books->book_id}}">
                    <input type="submit" name="SUBMIT" value="Cancel" class="ui button"/>
                    <div class="or"></div>
                    <input type="submit" name="SUBMIT" value="Publish" class="ui blue button"/>
                </form>
            </div>
          </div>
    @endif
</div>
</body>
</html>