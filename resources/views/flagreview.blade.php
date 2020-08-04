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
   
    </style>
    <title>Flag</title>
    @include('layouts.navbarcss')
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
            <div class="ui container">
                <h1> Flag review for Abuse</h1>
                <div class="text-3xl"> You are flagging this review</div>
                <div class="mb-8">

                </div>
                <div class="text-xl">
                    "{{$r->content}}"
                </div>
                <div class="mb-8">

                </div>
                <div class="text-lg">Why are you flagging this review?</div>
                <div class="mb-4">
                    <form class="ui form" method="POST">
                        {{csrf_field()}}
                    <input type="hidden" name="uID" value="{{Session::get('user')->user_id}}">
                    <input type="hidden" name="reviewid" value="{{$r->review_id}}">
                        <div class="grouped fields">
                         
                          <div class="field">
                            <div class="ui radio checkbox">
                              <input type="radio" name="choice" value="Spam or Self-Promoted" checked="" tabindex="0" class="hidden">
                              <label class="font-bold">Spam or Self-Promotional</label>
                              <div class='p-8'>The review is spam or self-promotional.</div>
                            </div>
                          </div>
                          <div class="field">
                            <div class="ui radio checkbox">
                              <input type="radio" name="choice" value="Irrelevant" tabindex="0" class="hidden">
                              <label class='font-bold'>Irrelevant</label>
                              <div class='p-8'>The review is irrelevant</div>
                            </div>
                          </div>
                         
                          <div class="field">
                            <div class="ui radio checkbox">
                              <input type="radio" name="choice" value="Inappropriate" tabindex="0" class="hidden">
                              <label class='font-bold'>Inappropriate</label>
                              <div class='p-8'>The review contains hate speech</div>
                            </div>
                          </div>
                        </div>
                       <div class='font-bold'>explanation*</div>
                        <textarea required name="description" id="" cols="30" rows="10"></textarea>
                        <div class="mt-4"></div><button class="ui button" type='submit'>Flag</button>
                        <input type="hidden" value="{{url()->previous()}}" name="url">
                    </form>
                </div>
               
            </div>
</body>
<script>
    $(document).ready(function(){
        $('.ui.radio.checkbox')
  .checkbox()
;
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
           
    });
</script>
</html>