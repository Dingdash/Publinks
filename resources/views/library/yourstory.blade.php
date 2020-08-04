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
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Your Story</title>
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
<div class="ui container mt-8">
        <h1 class="header">Your Stories</h1>
    @if($books!=null)
    <table class="ui celled padded table">
        <thead>
          <tr><th class="four wide">Book Title</th>
          <th>Type</th>
          <th colspan="4" class="">Actions</th>
          <th> Favorites </th>
          <th> Last Updated </th>
        </tr></thead>
        <tbody>
            @foreach($books as $b)
          <tr>
            <td>
              {{$b->title}}
            </td>
            <td>
              {{$b->type}}
            </td>
            <td>
                @if($b->type=='STORIES')
                <div class="buttons">
                <button onclick="window.location.href='{{url('/editbook/'.$b->book_id)}}'" class="ui blue icon button">
                  <i class="edit icon"></i>
                  Edit Info
                </button>
                <button onclick="window.location.href='{{url('/editbook/stories/'.$b->book_id)}}'" class="ui blue icon button">
                  <i class="edit icon"></i>
                  Edit Stories
                </button>
                </div>
                @else
                  <button onclick="window.location.href='{{url('/editbook/'.$b->book_id)}}'" class="ui blue icon button">
                    <i class="edit icon"></i>
                    Edit Info
                  </button>
                  <button onclick="window.location.href='{{url('/editbook/pdf/'.$b->book_id)}}'" class="ui blue icon button">                          
                    Upload New Version
                  </button>
                @endif                    
            </td>
            <td  style="text-align:center;">
                <p> <a href="{{url('/viewtraffics/'.$b->book_id)}}"> View Traffics</a>
            </td>
            <td>
                <p> <a href="{{url('/allreview')}}/{{$b->book_id}}"> View Reviews</a>
            </td>
            <td>
              <p> <a href="{{url('/publishing')}}/{{$b->book_id}}"> Publish</a>
            </td>
            <td>
                <h2 class="ui center aligned header">{{$b->countlikes()}}</h2>
            </td>
            <td>
                {{ Carbon\Carbon::parse($b->updated_at)->diffForHumans() }}
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
        <th colspan="8">
        <tr></tr>  
        </th> 
        </tfoot>
      </table>
      @else
      <div style="max-width:800px;" class='ui centered mx-auto'>
            <div style='text-align:center;' class="ui placeholder segment">
                    <h1>You don't have any story</h1>
                    <p><a href="{{url('/createmenu')}}">click here to make a new one</a> </p>
            </div>
        </div>
      @endif
</div>  
</body>
<script>
  
</script>
</html>