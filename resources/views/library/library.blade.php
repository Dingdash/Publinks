<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- tailwindcss !-->
        <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
        <link rel = "stylesheet" href="{{asset('css/library.css')}}">
        <!-- tailwindcss !-->
        <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
<title>Publink</title>
@include('layouts.navbarcss')
</head>
@include('layouts.navbar2')
<body class="bg-grey-lightest ">
<div class="tailwind-container mx-auto">
        <div class="flex justify-between px-8 mb-8"> 
                <div class="text-4xl">
                Library
                </div>        
                <div class="ui secondary pointing menu">
                <a href="{{url('/library?libraryType=current')}}" class="
                <?php 
                if(isset($_GET['libraryType']))
                {
                        if ($_GET['libraryType']=='current'){
                        echo "active";
                        }
                }
                ?> item">
                        Current
                </a>
                <a href='{{url('/library?libraryType=archived')}}'class="  <?php 
                if(isset($_GET['libraryType']))
                {
                        
                        if ($_GET['libraryType']=='archived'){
                        echo "active";
                        }
                }
                ?>  item">
                Favorites
                </a>
                </div>          
        </div>
        <div class="ui grid stackable five column">
            
                @foreach ($book as $b)
                
                <div class="column ">
                        <div class="ui padded grid  ">   
                                <div class="shadow-md bg-white p-4 mx-auto"> 
                                        <div class="center aligned mx-auto">
                                                @if(!$b->book->cover)
                                                
                                            <img style="
                                            max-height: 25rem;" src ="/storage/default/book-image-not-available.png"> </img>
                                            @else
                                            <img style="min-height: 21rem;" src ="/storage/{{$b->book->cover }}" >
                                            @endif
                                        </div> 
                                        <div class="break-word mt-1 font-bold"><a href="{{url('/u/'.$b->book->penulis->user_id)}}">{{$b->book->penulis->name}}</a></div>
                                        <div class="font-thin"> {{$b->book->title}}</div>  
                                        <div class="mt-4 flex justify-between">
                                                
                                                        <button class="button text-blue-dark font-semibold" onclick="window.location.href='{{url('read/'.$b->book->book_id)}}'">Read Book</button>
                                        
                                                
                                                @if($b->favorited==0)
                                                <button class="ui icon circular button btnbookmark" data-tooltip="Add to Favorites" data-id="{{$b->book->book_id}}">
                                                        <i class=" icon black sm bookmark"> </i>
                                                        <span class="hidden text-sm"> Please Wait... </span>
                                                </button>
                                                @else
                                                <button class="ui icon circular button btndelete" data-tooltip="Remove from Favorites" data-id="{{$b->book->book_id}}">
                                                                <i class=" icon black sm trash"> </i>
                                                                <span class="hidden text-sm"> Please Wait... </span>
                                                        </button>
                                                @endif
                                        </div>
                                </div>
                        </div>
                </div>
                @endforeach
        </div>
</div>
</body> 
        <script>
                $(document).ready(function(){
                      
                        $(document).on('click','.btnbookmark',function(e){
                        $(this).find('span').removeClass('hidden');
                        $(this).addClass('disabled');
                        toremove=$(this).parentsUntil('.padded');
                        // toremove.remove();
                        var bookid = $(this).attr('data-id');
                        $.ajax({
                        type:'POST',
                        url: "<?php echo url('/addtolib');?>",
                        data:{bookID:bookid},
                        beforeSend: function(){
                        $(this).find('span').show();
                        $(this).addClass('disabled');
                        },
                        success: function(){
                                alert('successfully Updated!!');
                                toremove.remove();
                        },
                        error : function(){
                                alert('there was something error');
                                $(this).find('span').hide();
                                $(this).removeClass('disabled');
                        }
                        });});
                        $(document).on('click','.btndelete',function(e){
                        toremove=$(this).parentsUntil('.padded');
                        // toremove.remove();
                        //TODO DATABASE
                        var bookid = $(this).attr('data-id');
                        $.ajax({
                        type:'POST',
                        url: "<?php echo url('/delfromlib');?>",
                        data:{bookID:bookid},
                        beforeSend: function(){
                        $(this).find('span').show();
                        $(this).addClass('disabled');
                        },
                        success: function(){
                                alert('successfully Updated!!');
                                toremove.remove();
                        },
                        error : function(){
                                alert('there was something error');
                                $(this).find('span').hide();
                                $(this).removeClass('disabled');
                        }
                        });
                });
                });        
        </script>
</html>