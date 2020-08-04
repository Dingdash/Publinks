<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Edit Profile</title>
    @include('layouts.navbarcss')
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
            <div class="container">
                <div class="mb-4">
                </div>
            <div class="ui grid stackable two column centered">
                <div class="ui four wide column">
                        <div class="shadow md bg-white pt-6 pb-2">
                            <div class="text-center">
                                    @if($user->profpic!=null)
                                
                                <img style=" border:1px solid #021a40;" class="rounded-full h-64 w-64 p-1" src="/storage/{{ $user->profpic }}">
                                @else
                                <img style=" border:1px solid #021a40;" class="rounded-full h-56 w-56 p-1" src="/storage/default/default-avatar.png">
                                @endif    
                            </div>
                                
                                <p  class='mt-4 mx-auto text-center text-xl'>{{$user->name}}</p>
                        </div>
                </div>
                <div class="ui column">
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
                    <div class="shadow-md p-6 bg-white">
                            <h1>Edit Profile</h1>
                            <div class="mb-4">
                                </div>
                        <form class="ui form" method="POST" enctype="multipart/form-data" action="{{url('/editprofile')}}">
                            {{csrf_field()}}  
                                <input type="hidden" name="uID" value="{{$user->user_id}}">
                                <div class="field">
                                <label>UPLOAD AVATAR</label>
                                <input name="photo" accept="image/gif, image/jpeg, image/png" type="file"></input>
                                </div>
                                <div class="required field">
                                    <label>NAME</label>
                                    <input value = "<?php echo $user->name;?>" required name="name" type="text" placeholder="Name">
                                </div>
                                
                                <div class="required field">
                                <label>EMAIL</label>
                                    <input value="<?php echo $user->email;?>" required name="email" type="email" placeholder="Email">
                                </div>
                                <div class="field">
                                <label>ABOUT YOU</label>
                                    <textarea name="about" style="max-height:2rem;"> <?php echo $user->about;?></textarea>
                                </div>
                                <div class="field">
                                    <label for="">NEW PASSWORD</label>
                                    <input minlength="6" maxlength="14" name="password" type="text" name="password">
                                    <div class='text-grey-dark' for="">leave it empty if you don't want to change your password</div>
                                </div>
                                <div class="field">
                                    <label for="">WEBSITE</label>
                                    <input name="website" type="text" value="<?php echo $user->website;?>" name="" placeholder="http://www.example.com" id="">
                                </div>
                                <button class="ui primary button" type="submit">   
                                    Save Settings
                                </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>