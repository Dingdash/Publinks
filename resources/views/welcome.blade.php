<html>
    <head>
            <link rel="stylesheet" href="{{asset('css/navbar.css')}}"/>
<link rel="stylesheet" href="{{asset('css/dist/min.css')}}">
<link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
        <style>
            body{
                margin: 0px;   
            }
            .contain{
                display:grid;
                grid-auto-rows: minmax(50px,auto);
            }
         
            .contain>.content{
                text-align:center;
            }
            .content>*>img{
                height: 200px;
                width: 200px;
                
            }
        </style>
    </head>
    <body>
    @include('layouts.navbar2')
        <div class="contain">
            
            <div class="content">
                    <div class="mt-10 mb-5"><img src="{{asset('assets/book.png')}}"/></div>
                    <div class="description text-4xl">
                        <p>Welcome to Publink</p>
                        <p>A platform to write and publish your stories.</p>
                        <p>Please login to use our website.</p>
                    </div>
            </div>
            
        </div>
    </body>
</html>