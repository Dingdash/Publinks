<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Publink</title>
    
</head>
<body>
@include('layouts.navbar2')
    <div class="page-login">
        <div class="ui centered stackable grid container">
            <div class="nine wide column">
                @if(session('error'))
                <div class="ui icon error message">
                    <i class="lock icon"></i>
                    <div class="content">
                        <div class="header">
                            Error
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
                        <div class="ui huge header">Activation</div>
                        <form class="ui form" method="POST" action="">  
                            {{csrf_field()}}    
                            <div class="field">
                                <p>Email</p>
                                <div class="ui labeled input">
                                    <input required type="text" name="email" placeholder="Enter your Email">
                                </div>
                            </div>
                            <div class="field">
                            <p>Activation Code</p>
                                <div class="ui labeled input">
                                    <input required type="text" name="code" placeholder="Enter your activation code">
                                </div>
                            </div>
                            <div class="field">
                                <a href="{{url('/resendactivate')}}"> Click here to Resend Activation Code</a>
                            </div>
                            <button class="ui primary button" type="submit">
                                Activate
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>