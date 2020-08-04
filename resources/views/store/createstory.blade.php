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
    <title>Publink</title>
    
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
            
                
            <div class="ui grid centered">
                
                <div class="ui column lg:max-w-lg sm:mx-4 md:max-w-lg">
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
                    
                    
                    <div class="shadow-md bg-white p-4">
                            <h1 class='mb-4'>Create a Book</h1>
                            <form id='formupload' class="ui form" method="POST" action="{{url('/newstory')}}">
                                {{csrf_field()}}  
                                   {{-- <input type="hidden" name="uID" value="{{session('user')->user_id}}"> --}}
                                    {{-- <div class="field"> --}}
                                    {{-- <label>UPLOAD PDF</label>
                                    <input name="pdf" accept="application/pdf" type="file"></input>
                                    </div> --}}
                                    <div class="required field">
                                        <label>TITLE</label>
                                        <input required name="title" type="text" placeholder="Title book">
                                    </div>
                                    <div class="required field">
                                        <label>CATEGORY</label>
                                        <div class="ui selection dropdown">
                                                <input required type="hidden" name="category">
                                                <i class="dropdown icon"></i>
                                                <div class="default text">Category</div>
                                                <div class="menu">
                                                    @foreach($categories as $category)
                                                  <div class="item" data-value="{{$category->category_id}}">{{$category->category_name}}</div>
                                                  @endforeach
                                                  {{-- <div class="item" data-value="0">Female</div> --}}
                                                </div>
                                              </div>
                                    </div> 
                                    {{-- <div class="required field">
                                    <label>EMAIL</label>
                                        <input required name="email" type="email" placeholder="Email">
                                    </div> --}}
                                    <div class="field">
                                    <label>ABOUT BOOK</label>
                                        <textarea name="about" style="max-height:2rem;"></textarea>
                                    </div>
                                
                                    <button id="btnsubmit"  class="ui primary button" type="submit">   
                                       Create
                                    </button>
                            </form>
                    </div>
                   
                </div>
            </div>
        
</body>
<script>
    $('.ui.dropdown')
  .dropdown()
;
    $("#btnsubmit").click(function(e){
        e.preventDefault();
        var value2 = $("input[name='title']").val();
        var value = $("input[name='category']").val();
        if(value2=="")
        {
            alert('you must insert a title');
        }else if(value== "")
        {
            alert('You must select a category');
        }else
        {
            $("#formupload").submit();
        }
    });
</script>
</html>