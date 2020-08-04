<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
    <h1 class="header">
      
      {{$stories->title}}
    </h1>
    <a href={{url('/newchapter/'.$stories->book_id)}}>Click here to add new chapter!</a>
    <h5> Click and drag on any of the table rows below to move the order around.</h5>
  @if($stories!=null)
    <table class="ui celled padded table">
        <thead>
          <tr><th>Chapter Title</th>
          <th class="">Actions</th>
          <th> Last Updated </th>
          <th> Published </th>
        </tr></thead>
        <tbody>
          @foreach($chapters as $s)
          <tr class="chapter-item" chapterid="{{$s->chapter_id}}">
            <td>
              <h4 class="ui image header">
                <div class="content">
                  {{$s->chapter_title}}
                </div>
              </div>
            </h4></td>
            <td>
                <a href="{{url('/editstory/'.$s->chapter_id)}}" class="ui blue icon button">
                  <i class="edit icon"></i>
                  Edit 
                </a>
                <a href="{{url('/deletechapter/'.$s->chapter_id)}}" onclick="return confirm('are you sure you want to delete this chapter?')" class="ui red icon button">
                  <i class="remove icon"></i>
                  Delete 
                </a>
            </td>            
            <td>{{ Carbon\Carbon::parse($s->updated_at)->diffForHumans() }}</td>
            <td>
                @if($s->published!=null || $s->published!="")
                Published
                @else
                Unpublished
                @endif
            </td>
          </tr>
          @endforeach
        </tbody>
        {{-- <tfoot>
        @if($chapters->hasMorePages()|| $chapters->nextPageurl()!=null || $chapters->previousPageUrl()!=null)
        
            <tr>
                <th colspan="4">
                    <div class="ui pagination menu">
                    {{$chapters->render('admin.paginator.semanticpaginator')}}       
                    </div>
                </th>
            </tr>
        
        @else
      </tfoot> --}}
        <tfoot>
          <tr>
              <th colspan="4">
              </th>
          </tr>
      </tfoot>
        
      </table>
      @endif
</div>        
</body>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> 
<script src="https://raw.githubusercontent.com/furf/jquery-ui-touch-punch/master/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript">
 $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
  $('tbody').sortable({
      update: function(event,ui){
        var pageidarray = new Array();
        $('.chapter-item').each(function(e){
          pageidarray.push($(this).attr('chapterid'));
        });
        
                $.ajax({
            type:'POST',
            url:"<?php echo url('updatesort');?>",
            data:{p:pageidarray},
            success:function(data)
            {
              alert(data);
            }
        });   
  }}
  );
</script>
</html>