<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- tailwindcss !-->
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    
    <title>Follow List</title>
    <style>
        .follow-list{
            display:grid;
            grid-template-columns:repeat(5,1fr);
            
            grid-gap:20px;
            min-height:300px;
        }
        .card{
            padding:20px;
            display:grid;
            grid-template-rows: auto 1fr auto;
        }
        .profpic{
            margin-right: auto;
            margin-left: auto;
            width:160px;
            height:160px;
            border-radius:50%;
        }
        
        .card>.content{
            margin-top:4px;
        }
        .card>.content>.title{
            padding-left:20px;
        }
        .card>.content>.meta{
            padding-left:20px;
        }
        .extra-content{
            
            text-align:center;
            padding-left: 20px;
            padding-right: 20px;
        }      
    </style>

    
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
{{-- {{var_dump($list[0]->follower->username)}} --}}
<div style="width:80%;" class="mx-auto mt-4">
        <h1 class="ui align centered header">{{$user->name }}</h1>
        @if($user->profpic)
    <img style="border:1px solid #021a40;" src="/storage/{{ $user->profpic}}"  class="ui centered circular image p-1 w-64 h-64">
    @else
    <img style="border:1px solid #021a40;" src="/storage/default/default-avatar.png" class="ui centered circular image p-1">
    @endif
        <div style='text-align:center;' class="mx-auto mt-8">
            @if($youraccount==true)
            <button class="ui green button" onclick="window.location.href='{{url('editprofile')}}'" class="item">Edit Profile</button>
            @else
            @if($isfollowing==true)
            <form action="{{url('/unfollowact/'.$user->user_id)}}"method = 'GET'>
            <input type='submit' value="Unfollow" style="width:150px;" class="ui red button"/>
            @else
            <form action="{{url('/followact/'.$user->user_id)}}" method='GET'>
            <input type='submit' value="Follow" style="width:150px;" class="ui blue button"/>
            @endif
            @endif
        </form>
        </div>
<div class="ui secondary pointing menu">
        <a href="{{url('/u/'.$lastsegment)}}" class=" item">
            <i class="info icon"></i> About
        </a>
    <a href="{{url('/followers/'.$lastsegment)}}" class="@if($menu=='follower'){{"active"}}@endif item">
            <i class="users icon"></i> Followers
        </a>
        <a href="{{url('/following/'.$lastsegment)}}" class="@if($menu=='following'){{"active"}}@endif item">
            <i class="users icon"></i> Following
        </a>
        <div class="right menu">    
        </div>
    </div>
</div>
    <div style="width:80%;"  class="follow-list mx-auto">
        @if($menu=="follower")
        @foreach($list as $l)

            
            {{-- {{($l->follower->isFollowing(Session::get('user')))}} --}}
            {{-- {{var_dump($l->follower->user_id)}}
            {{var_dump($l->follower->followers->count())}}
            {{var_dump($l->follower->following->count())}} --}}
            @if($l->follower->user_id == Session::get('user')->user_id)
            <div class="card">
                <div class="profpic">
                    @if($l->follower->profpic)

                        <img class="profpic"src="/storage/{{$l->follower->profpic}}"></img>
                        @else
                        <img class="profpic"src="/storage/default/default-avatar.png"></img>
                        @endif
                </div>

                <div class="content">
                    <div class="title">
                        <a href="{{url('/u/'.$l->follower->user_id)}}" class="href"> {{$l->follower->name}}</a>
                    </div>
                    <div class="meta">
                            <i class="user icon"></i> {{$l->follower->followers->count()}} <i style="margin-left:5px;" class="book icon"></i> {{$l->follower->books->count()}}
                    </div>
                </div>
                <div class="extra-content">
                        <button onclick= "location.href= '{{url('/u/'.$l->follower->user_id)}}'" data-user="{{$l->follower->user_id}}"  class=" bg-green hover:bg-green-dark h-12 w-full text-white font-bold py-2 px-4 rounded-full">
                                You
                        </button>       
                </div>
            </div>
            @else
                <div class="card">
                    <div class="profpic">
                        @if($l->follower->profpic)

                        <img class="profpic"src="/storage/{{$l->follower->profpic}}"></img>
                        @else
                        <img class="profpic"src="/storage/default/default-avatar.png"></img>
                        @endif
                    </div>
                    <div class="content">
                        <div class="title">
                            <a href="{{url('/u/'.$l->follower->user_id)}}" class="href"> {{$l->follower->name}}</a>
                        </div>
                        <div class="meta">
                                <i class="user icon"></i> {{$l->follower->followers->count()}} <i style="margin-left:5px;" class="book icon"></i> {{$l->follower->books->count()}}
                        </div>
                    </div>
                    @if($l->follower->isFollowing(Session::get('user'))==0)
                    <div class="extra-content">
                            <button url="{{url('/followact')}}" data-user="{{$l->follower->user_id}}"  class="btnsubmit bg-blue hover:bg-blue-dark h-12 w-full text-white font-bold py-2 px-4 rounded-full">
                                    Follow
                            </button> 
                    </div>
                    @else
                    <div class="extra-content">
                            <button url="{{url('/unfollowact')}}" data-user="{{$l->follower->user_id}}"  class="btnsubmit bg-red hover:bg-red-dark h-12 w-full text-white font-bold py-2 px-4 rounded-full">
                                    Unfollow
                            </button>
                    </div>
                    @endif
                </div>
                @endif
        @endforeach
        @endif
        @if($menu=="following")
        @foreach($list as $l)     
            @if($l->following->user_id == Session::get('user')->user_id)
            <div class="card">
                <div class="profpic">
                    @if($l->following->profpic)

                        <img class="profpic"src="/storage/{{$l->following->profpic}}"></img>
                        @else
                        <img class="profpic"src="/storage/default/default-avatar.png"></img>
                        @endif
                </div>
                <div class="content">
                    <div class="title">
                        <a href="{{url('/u/'.$l->following->user_id)}}" class="href"> {{$l->following->name}}</a>
                    </div>
                    <div class="meta">
                            <i class="user icon"></i> {{$l->following->followers->count()}} <i style="margin-left:5px;" class="book icon"></i> {{$l->following->books->count()}}
                    </div>
                </div>
                <div class="extra-content">
                        <button onclick= "location.href= '{{url('/u/'.$l->following->user_id)}}'" data-user="{{$l->following->user_id}}"  class=" bg-green hover:bg-green-dark h-12 w-full text-white font-bold py-2 px-4 rounded-full">
                            You
                        </button>       
                </div> 
            </div>
            @else
                <div class="card">
                    <div class="profpic">
                        @if($l->following->profpic)

                        <img class="profpic"src="/storage/{{$l->following->profpic}}"></img>
                        @else
                        <img class="profpic"src="/storage/default/default-avatar.png"></img>
                        @endif
                    </div>
                    <div class="content">
                        <div class="title">
                            <a href="{{url('/u/'.$l->following->user_id)}}" class="href"> {{$l->following->name}}</a>
                        </div>
                        <div class="meta">
                                <i class="user icon"></i> {{$l->following->followers->count()}} <i style="margin-left:5px;" class="book icon"></i> {{$l->following->books->count()}}
                        </div>
                    </div>
                    @if($l->following->isFollowing(Session::get('user'))==0)
                    <div class="extra-content">
                            <button url="{{url('/followact')}}" data-user="{{$l->following->user_id}}"  class="btnsubmit bg-blue hover:bg-blue-dark h-12 w-full text-white font-bold py-2 px-4 rounded-full">
                                    Follow
                            </button>
                    </div>
                    @else
                    <div class="extra-content">
                            <button url="{{url('/unfollowact')}}" data-user="{{$l->following->user_id}}"  class="btnsubmit bg-red hover:bg-red-dark h-12 w-full text-white font-bold py-2 px-4 rounded-full">
                                    Unfollow
                            </button>
                    </div>
                    @endif
                </div>
                @endif
        @endforeach
        @endif
    </div>
</body>
<script>
    $(document).ready(function(){
      
            $(".btnsubmit").click(function(){
                var btn = $(this);
                var userid = $(this).attr('data-user');
                var followercount = btn.parent().parent().find('.meta').get(0).firstChild.nextSibling.nextSibling.nodeValue;
                var urlunfollow = "<?php echo url('/unfollowact');?>";
                var urlfollow = "<?php echo url('/followact');?>";
                $.ajax({
                type:'POST',
                url:$(this).attr('url'),
                data:{uID:userid,ajax:'tes'},
                
                success:function(data){
                   
                    if(data=='follow success')
                    {
                        
                        btn.removeClass('bg-blue');
                        btn.removeClass('hover:bg-blue-dark');
                        btn.addClass('bg-red');
                        btn.addClass('hover:bg-red-dark');
                        btn.html('Unfollow');
                        followercount = parseInt(followercount)+1;
                        btn.parent().parent().find('.meta').get(0).firstChild.nextSibling.nextSibling.nodeValue=followercount;
                        btn.attr("url",urlunfollow);
                        
                    }else if (data=='unfollow success')
                    {
                        btn.removeClass('bg-red');
                        btn.removeClass('hover:bg-red-dark');
                        btn.addClass('bg-blue');
                        btn.addClass('hover:bg-blue-dark');
                        btn.html('Unfollow');
                        followercount = parseInt(followercount)-1;
                        btn.parent().parent().find('.meta').get(0).firstChild.nextSibling.nextSibling.nodeValue=followercount;
                        btn.attr("url",urlfollow);
                        btn.html("Follow");
                    }else
                    {
                        
                    }
                }

                });
                
            });
    });
</script>
</html>