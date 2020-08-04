<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/auth/login.css')}}">
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Publink</title>
</head>
<body>
@include('layouts.navbar2')
<div style='margin-top:2rem;'>
    </div>
        <div class="ui centered stackable grid container">
            <div class="nine wide column computer">
                @if(session('error'))
                <div class="ui icon error message">
                    <i class="lock icon"></i>
                    <div class="content">
                        <div class="header">
                            Login failed!
                        </div>
                        <p>{{session('error')}}</p>
                    </div>
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
                <div class="ui fluid card">
                    <div class="content">
                        <div class="ui huge header">Login</div>
                        <form class="ui form" method="POST" action="">  
                            {{csrf_field()}}    
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">
                                        <i class="user icon"> </i>
                                    </div>
                                    <input  type="text" name="uID" value="<?php echo Cookie::get('uID');?>" placeholder="Enter your Username or Email">
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">
                                        <i class="lock icon"> </i>
                                    </div>
                                    <input  type="password" name="password" value="<?php echo Cookie::get('password');?>" placeholder="Enter your password">
                                </div>
                            </div>
                            <div class="inline field">
                                <div class="ui checkbox">
                                    <input  type="checkbox" name="remember">
                                    <label> Remember Me </label>
                                </div> 
                            </div>
                            <div class="inline field">
                                <a href="{{url('forgotpass')}}"> Forgot your Password?</a>
                                <a href="<?php echo ('/resendactivate');?>"> Resend Activation</a>
                            </div>
                            <div class="field">
                                <a href="<?php echo url('register');?>" class="link">Click here to Sign Up</a>
                            </div>
                            <button class="ui primary button" type="submit">   
                                Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>