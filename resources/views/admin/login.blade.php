<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/admin/login.css')}}">
    <link rel="stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    
    <title>Admin Login</title>
</head>
<body class="bg-grey-dark">
    <div class="h-full sm:block md:flex sm:items-center">
    <div class="ui centered stackable grid container ">
        <div class="ten wide column computer">
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
            @if(session('info'))
            <div class="ui icon info message">
                <i class="info icon"></i>
                <div class="content">
                    <div class="header">
                        Info
                    </div>
                    <p>{{session('info')}}</p>
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
            <div class="ui bg-white card fluid center aligned shadow-lg">
                <div class="content">
                    <div class="ui huge header text-center">Admin Login</div>
                    <form class="ui form" method="POST" action="{{url('/admin')}}">  
                        {{csrf_field()}}    
                        <div class="field pb-4 pt-4">
                            <label> Username </label>
                            <div class="ui labeled input">
                                <div class="ui label">
                                    <i class="user icon"> </i>
                                </div>
                                
                                <input  type="text" name="uID" value="" placeholder="Enter your Username or Email">
                            </div>
                        </div>
                        <div class="field pb-4">
                                <label> Password </label>
                            <div class="ui labeled input">
                                <div class="ui label">
                                    <i class="lock icon"> </i>
                                </div>
                                <input  type="password" name="uPASS" value="" placeholder="Enter your password">
                            </div>
                        </div>
                        <button class="ui primary button" type="submit">   
                            Login
                        </button>
                        <div class="ui error message"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
    <script>
    $('.ui.form')
    .form({
        username: {
        identifier  : 'uID',
        rules: [
            {
            type   : 'empty',
            prompt : 'Please enter a username'
            }
        ]
        },
        name: {
        identifier  : 'password',
        rules: [
            {
            type   : 'empty',
            prompt : 'Please enter your password'
            }
        ]
        },
    })
;
    </script>
</html>