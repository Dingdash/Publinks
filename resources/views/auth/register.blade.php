<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/auth/login.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Publink</title>
</head>
<body>
@include('layouts.navbar2')
<div style='margin-top:2rem;'></div>
    <div class="page-login">
        <div class="ui centered stackable grid container">
            <div class="nine wide column">
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
                @if(session('error'))
                <div class="ui icon error message">
                    <i class="info icon"></i>
                    <div class="content">
                        <div class="header">
                            Registration Failed!
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
                        <div class="ui huge header">Register</div>
                        <form class="ui form" method="POST" action="">  
                            {{csrf_field()}}    
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">
                                        <i class="envelope icon"> </i>
                                    </div>
                                    <input  type="email" name="email" placeholder="Enter your email address">
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">
                                        <i class="user icon"> </i>
                                    </div>
                                    <input  type="text" name="name" placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">
                                        <i class="user icon"> </i>
                                    </div>
                                    <input  type="text" name="username" placeholder="Enter your username">
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">
                                        <i class="lock icon"> </i>
                                    </div>
                                    <input  type="password" name="password" placeholder="Enter your password">
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui labeled input">
                                    <div class="ui label">
                                        <i class="lock icon"> </i>
                                    </div>
                                    <input  type="password" name="password_confirmation" placeholder="Confirm password">
                                </div>
                            </div>
                            <button class="ui primary button" type="submit">Register</button>
                        </form>
                    </div>                    
                </div>
                <div class="ui fluid card">
                    <div class="content"> 
                        <div class="ui form">
                            <div class="field">
                                <label>Already have an account?</label>   
                            </div>
                            <div class="field">
                                <a class="item" href="<?php echo url('login');?>"  rel="noopener noreferrer">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>