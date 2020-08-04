<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <!-- tailwindcss !-->
     <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
       
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Wishlist</title>
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
            <div class="container mt-4">
                <div class="ui centered header">
                  Your Wishlist
                </div>
                @if(count($wishlist)==0)
                    <div style="max-width:800px;" class='ui centered mx-auto'>
                        <div style='text-align:center;' class="ui placeholder segment">
                                <h1>You don't have any wishlist.</h1>
                        </div>
                    </div>
                @else
                <div style="max-width: 800px;" class="ui centered mx-auto">
                    @foreach($wishlist as $wish)
                    <div class="ui placeholder segment">
                        <div class="flex mb-4">
                            @if($wish->book->cover==null)
                         <img style="width:140px; height:200px"  src ="/storage/default/book-image-not-available.png">
                        @else
                        <img style="width:140px; height:200px" src="/storage/{{$wish->book->cover}}" />
                        @endif
                        <div style="width:100%" class='p-3'>
                            <div style='' class="mb-4">
                                {{$wish->book->title}}
                            </div> 
                            
                            <div style='min-height: 150px;' class="text-justify break-words">
                                   {{$wish->book->about}}
                            </div>
                            <form method="POST" action="{{url('wishlist/remove/'.$wish->wishlist_id)}} style='margin:0px;padding:0px;'">
                                {{csrf_field()}}
                                <button type="submit" class="pr-8 text-blue">
                                    Remove from Wishlist    
                                </button>
                                <a href='/book/{{$wish->book->book_id}}' class="p-3 mt-8 bg-blue text-sm text-white rounded"> View Details </a>
                            </form>
                        </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
        </div>
</body>
</html>