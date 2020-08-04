<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <!-- tailwindcss !-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <meta name="_token" content="{{csrf_token()}}" />
    <title>Route Lists</title>
</head>
<body>
        <div class="ui container">
                <table class="ui celled table">
                        <thead>
                          <tr><th>METHOD</th>
                          <th>URI</th>
                          <th>NAME</th>
                          <th>Action</th>
                        </tr></thead>
                        <tbody>
                            @foreach($list as $l)
                            
                          <tr>
                            <td data-label="Name">{{$l['method']}}</td>
                            <td data-label="Age">{{$l['uri']}}</td>
                            <td data-label="Job">{{$l['name']}}</td>
                            <td data-label="Job">{{$l['action']}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
        </div>
        
</body>
</html>