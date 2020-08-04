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
    <title>Publink</title>
    @include('layouts.navbarcss')
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')

            <div class="container mt-4">
                <div class="ui centered header">
                  What would you like to do ?
                </div>
                <div style="max-width: 800px;" class="ui centered mx-auto">
                    <div class="ui placeholder segment">
                        <div class="ui two column center aligned very relaxed stackable grid">
                          <div class="middle aligned row">
                            <div class="column">
                              <div class="ui icon header">
                                <i class="upload icon"></i>
                                Upload your story in PDF
                              </div>
                              <a href="{{url('createpdf')}}" class="ui primary button">
                                Upload
                              </a>
                            </div>
                            <div class="column">
                              <div class="ui icon header">
                                <i class="pencil alternate icon"></i>
                                Make a Story Online
                              </div>
                            <a href ="{{url('newstory')}}" class="ui primary button">
                                Create
                              </a>
                            </div>
                          </div>
                          
                        </div>
                        <div class="ui vertical divider">Or</div>
                      </div>
                </div>
        </div>
</body>
</html>