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
    <title>Notifications</title>
    <style>
        .notification-list{
            display:grid;
            grid-row-gap:1rem;
            padding-left:0.2rem;
            padding-right:0.2rem;
        }
        .notification-list>.single-notify{
            padding: 15px;
        }
        .single-notify>.content{
                display:grid;
                grid-auto-flow: column;
                   
        }
        .content>.delete{
            text-align:right;
        }
    </style>
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
<div class="mt-8"></div>
<div class="flex justify-between tailwind-container mx-auto px-8">
        <div class="text-4xl">
                Notifications
        </div>
        <div class="flex">
        <a href = "{{url('/notifications/markallasread')}}"class="text-white ui primary button">Mark All as Read</a>
            <div class="ml-2">
                
            </div>
            <a href = "{{url('/notifications/deleteall')}}"class="text-white ui primary button">Clear All</a>
            
        </div>          
</div>
<div class="mt-4"></div>
@if(count($notif)>0)
<div class="mx-auto notification-list tailwind-container">
    @foreach($notif as $n)
    
    
    <div class="shadow-md bg-white  single-notify">
    
    
    
        <div class="content">
            @if($n->type==1)
            <div class="text-xl">
                    <a href='{{url("u/".$n->author->user_id)}}''>{{$n->author->name}}</a> &nbsp; just published a book 
                    <a href="{{url('/book')}}/{{$n->book->book_id}}">{{$n->book->title}}</a>
                </div>
                 @if($n->isRead==0)
            <i class="ui icon circle red"></i>
            @endif
            @endif
            @if($n->type==2)
                <div class="text-xl">
                    <a href='{{url("u/".$n->author->user_id)}}''>{{$n->author->name}}</a> just followed you
                </div>
                 @if($n->isRead==0)
            <i class="ui icon circle red"></i>
            @endif
            @endif
            @if($n->type==3)
                <div class="text-xl">
                <a href='{{url("u/".$n->author->user_id)}}''>{{$n->author->name}}</a> just reviewed your book <a href="{{url('/singlereview')}}/{{$n->book->book_id}}/{{$n->author_id}}">{{$n->book->title}}</a>
                 @if($n->isRead==0)
            <i class="ui icon circle red"></i>
            @endif
                </div>
            @endif
            @if($n->type==4)
            <div class="text-xl">
                <a href='{{url("u/".$n->author->user_id)}}''>{{$n->author->name}}</a> just replied on your review <a href="{{url('/singlereview')}}/{{$n->book->book_id}}/{{$n->recipient}}">{{$n->book->title}}</a>
                 @if($n->isRead==0)
            <i class="ui icon circle red"></i>
            @endif
                </div>
            @endif
           
            
            @if($n->isRead==0)
            
            <form style="margin:0px;padding:0px; justify-self:end;"  action = '{{url("/notifications/markasread/".$n->id)}}' method="POST">{{csrf_field()}}<button type="submit" class="delete text-blue">Mark as Read</button></form>
            @endif
            <form style="margin:0px;padding:0px; justify-self:end;"  action = '{{url("/notifications/delete/".$n->id)}}' method="POST">{{csrf_field()}}<button type="submit" href='{{url("/notifications/delete/".$n->id)}}' class="delete text-blue">Delete</button></form>
            
               
        </div>
        <div class="time">
                <div class="flex text-sm">
                    {{$n->created_at->diffForHumans()}}
                </div>
        </div>
    </div>
    @endforeach
  
</div>
@else
    <div style="max-width:800px;" class='ui centered mx-auto'>
        <div style='text-align:center;' class="ui placeholder segment">
                <h1>You don't have any notification!</h1>
        </div>
    </div>
@endif
</body>
<script>
    
</script>
</html>