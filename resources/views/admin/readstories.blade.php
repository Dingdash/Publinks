<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.copyprotect')
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <style>
    .dropdownui>select{
        min-width:200px;
    }
    </style>
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Publink</title>
    
</head>
<body class="bg-grey-lighter">

    
    <div class="container mx-32 mt-24">
          <a href="{{url('/admin/managebooks')}}">Back to Admin</a>
        <div class="px-16 bg-white shadow-md" style="min-height:600px;">
            <div class="p-4 text-center text-3xl font-bold chapter-title">
                {{$book->title}}
            </div>
            
            <div class="p-4 text-center text-2xl font-semibold">
                @if(count($chapter)>0)
                    {{$chapter[0]->chapter_title}}
                @else
                Sorry no stories has been published yet
                @endif
            </div>
            <div class="text-xl">
                
                <?php 
                
                if(count($chapter)>0)
                {
                    
                    $file=File::get(storage_path('app/public'.$chapter[0]->published));
                ?>
                <?php echo $file;
                
                }?>
               
            </div>
        </div>
        <div class="p-8 shadow-md bg-grey-lighter flex justify-between">
            <div class="text-xl">
                @if($chapter->previousPageUrl()!=null)    
                <a href="{{$chapter->previousPageUrl()}}">Prev</a>
                @endif
            </div>
            <div class="dropdownui"><select class="dropdownval">
                <?php 
                $i = 1;?>
                @foreach($options as $c)    
                @if($i==$chapter->currentPage())
                <option selected value=?page={{$i}}>{{$c->chapter_title}}</option>
                @else
                <option value=?page={{$i}}>{{$c->chapter_title}}</option>
                @endif
                <?php $i++;?>
                @endforeach
            </select></div>
            <div class="text-xl">
                @if($chapter->nextPageurl()!=null)    
                <a href="{{$chapter->nextPageurl()}}">Next</a>
                @endif
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function(){
        $(".dropdownval").change(function(){
            current='<?php echo url()->current();?>'+$(this).val();
            window.location.href=current;
        });
    });
</script>
</html>