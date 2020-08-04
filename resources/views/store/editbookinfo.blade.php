<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
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
            <div class="container">
                <div class="mb-4">
                </div>
            <div class="ui grid two column">
                <div class="ui five wide column">
                   
                </div>
                <div class="ui column">
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
                    <h1>Book Info</h1>
                    <div class="mb-4">
                    </div>
                    <form id='formupload' class="ui form" method="POST" enctype="multipart/form-data" action="{{url('/editbook')}}">
                    {{csrf_field()}}  
                    
                       {{-- <input type="hidden" name="uID" value="{{session('user')->user_id}}"> --}}
                       <input type="hidden" name='bookid' value="{{$book->book_id}}">
                       <input type="hidden" name='booktype' value="{{$book->type}}">
                       {{-- <input type="hidden" name='mature' value="{{$book->mature}}"> --}}
                       <div class="field">
                            <label>UPLOAD COVER</label>
                            <input name="cover" type="file"></input>
                            </div> 
                       <div class="field">
                        <div class="required field">
                            <label>TITLE</label>
                            <input required name="title" value="{{$book->title}}" type="text" placeholder="Title book">
                        </div>
                        <div class="field">
                            
                            <input type="hidden" required name="progress" value="{{$book->progress}}">
                                <div class="required field">
                                    <label>PROGRESS</label>
                                    <div id="progressbook" class="ui progress"  data-value="1" data-total="100" >
                                            <div class="bar">
                                              <div class="progress"></div>
                                            </div>
                                            
                                            
                                          </div>
                                          <div class="ui icon buttons">
                                                <div id='decrement' class="decrement ui basic red button icon"><i class="minus icon"></i></div>
                                                <div id='increment' class="increment ui basic green button icon"><i class="plus icon"></i></div>
                                              </div>
                                          
                        </div>
                        <div class="required field">
                            <label>CATEGORY</label>
                            <div class="ui selection dropdown">
                                
                                    <input required type="hidden" name="category" value="{{$book->category_id}}">
                                    <i class="dropdown icon"></i>
                                    <div class="default text">Category</div>
                                    <div class="menu">
                                        @foreach($categories as $category)
                                      <div class="item" data-value="{{$category->category_id}}">{{$category->category_name}}</div>
                                      @endforeach

                                    </div>
                                  </div>
                        </div> 
                        <div class="field">
                        <label>ABOUT BOOK</label>
                            <textarea name="about" style="max-height:2rem;">{{$book->about}}</textarea>
                        </div>
                        <div class="ui form">
                                <div class="grouped fields">
                                  <label>PRICE</label>
                                  <div class="field">
                                    <div class="ui radio checkbox">
                                      <input id='freeradio' type="radio" value='free' name="free" @if($book->free==1)checked="checked" @endif>
                                      <label>Free</label>
                                    </div>
                                  </div>
                                  <div class="field">
                                    <div class="ui radio checkbox">
                                      <input type="radio" value='IDR' @if($book->free!=1)checked="checked" @endif name="example2">
                                      <label>IDR </label>
                                    </div>
                                  </div>
                                  <div id='pricefield' class="two fields">
                                          
                                        <div class="field">
                                                <label> Minimum price </label>
                                                <input id="minprice" value="{{$book->min_price}}" required name="minprice" pattern="\d*" min='14000' value='14000' step='500' type="number" placeholder="Minimum Price">
                                        </div>
                                        <div class="field">
                                                <label> Maximum price </label>
                                                <input id='maxprice' value="{{$book->max_price}}" required name="maxprice" pattern="\d*" min='14000' value='200000' step='500' type="number" placeholder="Minimum Price">
                                            </div>
                                      </div>
                                </div>
                              </div>
                        <div class="field">
                                <label>Rating</label>
                                <div class="ui slider checkbox">
                                    
                                        <input type="checkbox" name="mature" @if($book->mature==1)checked @endif>
                                        <label>Mature Content</label>
                                      </div>                                      
                        </div>
                        <div class="field">
                                <label>Tags </label>
                                <?php $mytag= "" ?>
                                @foreach ($book->tags()->get() as $tag)
                                <?php $mytag = $mytag.$tag->name.','?>
                                    {{-- {{$mytag=$mytag.$tag->name.','}} --}}
                                @endforeach
                                
                        <textarea name="tags" style="max-height:2rem;">{{rtrim($mytag,',')}}</textarea>
                                    <p> seperate each tag with comma</p>
                                </div>
                        <button id="btnsubmit"  class="ui primary button" type="submit">   
                            UPDATE INFO
                        </button>
                       
                </form>
                <div class="mt-8"></div>
                <form id="tableofcontentform" method="post" action="{{url('/edittoc')}}">
                    {{csrf_field()}}  
                    <h1>Table of content</h1>
                    <div class="field">
                    <input type="hidden" name="bookid" value="{{$book->book_id}}"/>
                    
                    
                    <textarea name="texttoc" style="max-height:2rem;">{{$book->toc}}</textarea>                   
                    
                    
                    Seperate each chapter with enter and each title with a "-"
                    example: 
                    <div style="background: transparent;
                    outline:none;
                    border:none;
                    selection:none;
                    font-size:18px; user-select:none;"  readonly rows=5>
Chapter 1 - Global warming<br>
Chapter 2 - Environment<br>
Chapter 3 - Forest<br>
Chapter 4 - East Asia</div> 
                </div>                  
                    
                    <button id="btntoc" class="ui primary button" type="submit"> UPDATE TABLE OF CONTENT </button>
                </form>
                </div>
            </div>
        </div>
</body>
<script>
    $(document).ready(function(){

        $("#minprice").on('change',function(e){
        if($("#minprice").val()<14000)
        {
            alert('price must be at least 14.000');
            $("#minprice").val(14000);
        }
        if($("#minprice").val()>parseInt($("#maxprice").val())-2000)
        {
            $("#maxprice").val(parseInt($("#minprice").val())+2000);        
        }
        if ($("#minprice").val()>=2000000-2000)
        {

            $("#minprice").val(2000000-2000);
        }
    });
    $("#maxprice").on('change',function(e){
        
        
        if($("#maxprice").val()<(parseInt($("#minprice").val())+2000))
        {
            $("#maxprice").val(parseInt($("#minprice").val())+2000);   
            // $("#minprice").val($("#maxprice").val());
        }
         if ($("#maxprice").val()>2000000)
        {

            $("#maxprice").val(2000000);
        }

    });
        $('.ui.dropdown')
.dropdown('set selected',$("input[name='category']").val());

setprogress();
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
    $("#tocbutton").click(function(e){
        e.preventDefault();
        alert('tes');
    });
    // changeprogress(10);
    $("#increment").click(function(){
        if(getpercent()+10<=100)
        {
            changeprogress(getpercent()+10);
        }else{
            changeprogress(100);
        }
        
    });
    $("#decrement").click(function(){
        if(getpercent()-10>=0)
        {
            changeprogress(getpercent()-10);
        }else{
            changeprogress(0);
        }
        
    });
   
    if($("#freeradio").is(':checked'))
    {
        
        $("#pricefield").hide();
    }
    function changeprogress(val)
    {
        $("#progressbook").progress({
        percent:val
    });
        $("input[type=hidden][name=progress]").val(val);
    }
    function setprogress()
    {
        $("#progressbook").progress({
        percent: $("input[type=hidden][name=progress]").val()
    });
        

    }
    function getpercent()
    {
        return $("#progressbook").progress('get percent');
    }
    $('input[type=radio]').change(function() {
        
    if (this.value == 'free') {
        $("input[name=example2]").prop("checked", false);
        $("#pricefield").hide();
        $('#minprice').removeAttr('required');
        $('#maxprice').removeAttr('required');
    }
     if (this.value == 'IDR') {
        $("input[name=free]").prop("checked", false);
        $("#pricefield").show();
        $('#minprice').prop('required',true);
        $('#maxprice').prop('required',true);
    }
    
});

    });
    
   
</script>
</html>