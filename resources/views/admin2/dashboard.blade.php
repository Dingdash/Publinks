<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{asset('css/admin/manageusers.css')}}"> --}}
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <!-- tailwindcss !-->
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    

    <style>
    .grid-container{
        display:grid;
        grid-template-columns: 240px 1fr;
        height: 100vh;
    }
    
    
    
    </style>
    <title>Edit User</title>
</head>
<body>
        <div class="grid-container">
            <div class="sidebar bg-black text-white shadow-md p-4">
                <div class="ui image circular small text-center">

                </div>
                <div class="ui item">
                    wejwjew
                </div>
            </div>
            <div class="content bg-grey-light pl-4 pt-4">
                
                <h1 class="ui header">Admin Dashboard</h1>
            </div>
            
            
        </div>
        
</body>
<script>
    $('.ui.dropdown')
        .dropdown();

        $('.ui.sidebar')
    .sidebar({
        context: $('.bottom.segment')
    })
    .sidebar('attach events','#toggle')
    ;
    

</script>

</html>