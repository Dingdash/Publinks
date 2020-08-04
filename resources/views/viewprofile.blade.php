<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{csrf_token()}}" />
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    
    <title>View Profile</title>
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
<div class="container mx-auto mt-4">
    <h1 class="ui align centered header">{{$user->name }}</h1>
    @if($user->profpic)
    <img style="border:1px solid #021a40;" src="/storage/{{ $user->profpic }}" class="ui centered circular image p-1 w-64 h-64">
    @else
    <img style="border:1px solid #021a40;" src="/storage/default/default-avatar.png"  class="ui centered circular image p-1">
    @endif
    <div style='text-align:center;' class="mx-auto mt-8">
        @if($youraccount==true)
        <button class="ui green button" onclick="window.location.href='{{url('editprofile')}}'" class="item">Edit Profile</button>
        @else
        @if($isfollowing==true)
        <a href="{{url('/unfollowact/'.$user->user_id)}}" class="ui red button">
            Unfollow
        </a>
        @else
        <a href="{{url('/followact/'.$user->user_id)}}" class="ui blue button">
            Follow
        </a>
        
        @endif
        @endif
        
        
    </div>   
    <div style="width:80%;" class="mx-auto">
        <div class="ui secondary pointing menu">
          <a class="active item">
            <i class="info icon"></i> About
          </a>
          <a href="{{url('/followers/'.$lastsegment)}}" class="item">
            <i class="users icon"></i> Followers
          </a>
          <a href='{{url('/following/'.$lastsegment)}}'class="item">
            <i class="users icon"></i> Following
          </a>
          <div class="right menu">
            
            
          </div>
        </div>
    </div>
    <div style="width:60%;" class="mx-auto mt-8">
        <div class="ui vertical segment">
            <div class='text-xl'>
                <?php echo nl2br($user->about,false);?>
            </div>
        </div>   
        @if($user->website)
        <div class="ui vertical segment">
                <p class="text-xl">Website :    <a class="lg:ml-2" href="{{$user->website}}">  {{$user->website}}</a></p>
        </div>
        @endif
    </div>

</div>
{{-- <div class="container mx-auto">
        <div class=" w-48 mx-auto">
        <img src="https://d39qdlcrvnra4b.cloudfront.net/avatars/991718/full/eric-elliott-profile.jpeg?1541463963" class="bg-blue rounded-full h-48 w-48 flex items-center justify-center" ></img>
        <div class="lg:my-4">
        <div style='text-align:center;' class="text-2xl">Eric Elliot</div>
        </div>
        </div>
        <div class="leading-normal text-xl px-24 max-w-xl mx-auto break-word">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Error debitis dignissimos assumenda quia numquam, est cupiditate voluptate maiores veniam minima esse illo dicta, similique consequatur facere totam ratione impedit distinctio. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Beatae hic quisquam voluptate velit autem eligendi ex! Quisquam, natus voluptates officia, impedit aperiam quas ullam earum velit corrupti odit sapiente vero?
            
            <p class="mt-4">Website :    <a class="lg:ml-2" href="http://www.carminenoviello.com">  http://www.carminenoviello.com</a></p>
        </div>
</div> --}}
</body>
<script>
        $('.ui.rating').rating('disable');
      
</script>
</html>