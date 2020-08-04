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
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
    
    .stars>i{
        cursor: pointer;
    }
    .fullstar{
        color: gold;
    }
    @media only screen and (max-width: 480px) {
        .margin-auto{
            margin-left: 0px;
            margin-right:0px;
            text-align: center;
            width: 100%;
            height: 190px;
        }
        .margin-auto>img{
            width:140px;
            height:180px;
        
        }
    }
    @media only screen and (min-width: 600px) {
        .margin-auto{
            margin-left: 0px;
            margin-right:0px;
            text-align: center;
            width: 140px;
            height: 190px;
        }
        .margin-auto>img{
            height:100%;
            width:auto;
        
        }
    }
    </style>
    <title>Publink</title>
    @include('layouts.navbarcss')
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
            <div class="container">
                <div class="mb-4">
                </div>
            <div class="ui stackable grid two column">
                <div class="ui five wide column">
                </div>
                <div class="ui column segment">
                        @if(count($errors)>0)
                        <div class="ui error message">
                            <div class="header">
                                There were some errors with your submission
                            </div>
                            <ul class="list">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            </ul>
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
                    <h1>Review for {{$book->title}}</h1>
                    <div class="mb-4">
                    </div>
                    <form  class="ui form" method="POST"  action="{{url('/review')}}">
                    {{csrf_field()}}  
                    <input type='hidden' value = "{{$book->book_id}}" name='bookid'>
                    <input type="hidden" name="score">
                        {{-- <input type="hidden" name="uID" value="{{session('user')->user_id}}"> --}}
                        <div class="fields">
                            <div class=" field" > 
                            @if($book->cover==null)
                                <img width="140" height="180"  src="/storage/default/book-image-not-available.png" alt=""> 
                            @else
                            <img style="object-fit: cover;  max-height:21rem;" src ="/storage/{{$book->cover }}" >
                            @endif
                            </div>
                            <div class="field">
                                    <label>{{$book->title}}</label>
                                    <div>{{$book->penulis->name}}</div>
                            </div>
                        </div> 
                        <div class="two fields">
                            <div style="width:auto;" class="field">
                            <label> My rating : </label>
                            </div>
                            <div style="width:auto;" class="stars pl-2"  >
                                    <i class="ui icon star" data-star="1"></i>
                                    <i class="ui icon star" data-star="2"></i>
                                    <i class="ui icon star" data-star="3"></i>
                                    <i class="ui icon star" data-star="4"></i>
                                    <i class="ui icon star" data-star="5"></i>
                                    <a class="ml-2" href=""> clear</a>
                            </div>
                            <div class="loading" style="display:none;">
                                saving...
                            </div>
                        </div>
                        {{-- <div class="required field">
                        <label>EMAIL</label>
                            <input required name="email" type="email" placeholder="Email">
                        </div> --}}
                        <div class="field">
                        <label>What Did you Think ?</label>
                            <textarea name="content" style="min-height: 200px; resize:none;"></textarea>
                        </div>
                        <button id="btnsubmit"  class="ui primary button" type="submit">   
                            Save
                        </button>
                </form>
                </div>
            </div>
        </div>
</body>
<script>
    $(document).ready(function(){
        var ratedIndex = -1;
        $(".stars>a").click(function(e){
            e.preventDefault();
            ratedIndex = -1;
            $("input[name=score]").val(ratedIndex+1);
            resetstarColors();
        });
        $(".ui.icon.star").click(function(){
            ratedIndex = parseInt($(this).data('star'));
            $("input[name=score]").val(ratedIndex);
        });
        $(".ui.icon.star").mouseover(function(){
            resetstarColors();
            var currentIndex = parseInt($(this).data('star'));
            for(var i=0; i<=currentIndex-1; i++)
            {
                $(".ui.icon.star:eq("+i+")").css('color','gold');
            }
        });
        $(".ui.icon.star").mouseleave(function(){
            resetstarColors();
            if(ratedIndex>-1)
            {
                for(var i=0; i<=ratedIndex-1; i++)
            {
                $(".ui.icon.star:eq("+i+")").css('color','gold');
            }

            }
        });

        function resetstarColors()
        {
            $(".ui.icon.star").css('color','black');

        }
            //         $.ajaxSetup({

            // headers: {

            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            // }

            // });
            // $.ajax({
            // url: '/review',
            // type: 'post',
            // data: {search:search},
            // beforeSend: function(){
            //     // Show image container
            //     $("#loader").show();
            // },
            // success: function(response){
            //     $('.response').empty();
            //     $('.response').append(response);
            // },
            // complete:function(data){
            //     // Hide image container
            //     $("#loader").hide();
            // }
            // });
    });
</script>
</html>