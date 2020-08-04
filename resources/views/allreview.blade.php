<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
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
        .greystar{
            color: gainsboro;
            
        }
        .fullstar{
            color: goldenrod;
        }
        .reviews-container{
            
            display:grid;
            grid-auto-rows: minmax(0px,auto);
        }
        .comment-row{
            padding-left:2rem;
            padding-right:2rem;
            padding-top:2rem;
            padding-bottom:2rem;
            background-color: #f9f9f9;
        }
        .single-content{
            margin-top:4px;
            display:grid;
            grid-template-rows: auto auto;
            border-radius: 4px;
            border-width: 1px;
            border: solid;
            border-color: rgba(220,220,220,0.25);
        }
        .review-row>.single-content>.content{
            display:grid;
            grid-row-gap:5px;
            grid-template-rows: auto 1fr;
            padding-left:2rem;
            padding-right:2rem;
            padding-top:2rem;
            padding-bottom:2rem;   
        }
       
        .meta-info{
            display:grid;
            grid-auto-flow:column;
            grid-template-columns: auto 9fr 1fr;
            /* justify-content: start; */
            min-width: 100%;
        }
        .editbutton{
            
            grid-column-start:3;
            font-size: 15px;
            color:skyblue;
        }
        .progressbar{
            display: grid;
            align-content: space-around;
        }
        .right{
            display:grid;
            align-content: space-around;
            grid-template-columns: auto auto;
            grid-column-gap: 2px;
        }
        .icon.star.padareview{
        
    height:27px;
            padding-top:2px;
    margin:8px 0px 5px 0px;
        }
        .ratingnumber{
            height:27px;
            padding-top:2px;
    margin:8px 0px 5px 0px;
        }
        .review-summary{
            display:grid;
            grid-template-columns: 2fr 4fr 2fr;
            align-content: center;
            

        }
        .stars{
            display:grid;
        
            grid-template-columns: 1fr auto;
        }
        @media only screen and (max-width: 500px) {
            .reviews-container{
            
            margin-left: 0.2rem;
            margin-right: 0.2rem;
            
        }
            .review-summary{
            display:grid;
            padding-left: 20px;
            padding-right:10px;
            grid-auto-rows: minmax(100px, auto);
            grid-template-columns: 18% 40% auto;
            grid-template-areas: "col col col"
                                "b b c";
            }
            .secor{
                text-align: center;
                grid-area:col;
            }
            .progressbar{
                grid-area: b;
                
            }
            .setar{
                grid-area:c;
                
                align-content: space-around;
                
            }

        }
    .progress,.progress-2,.progress-3,.progress-4,.progress-5{
    background:#F5F5F5;
    border-radius: 13px;
    height:18px;
    width:97%;
    padding:3px;
    margin:5px 0px 3px 0px;
    }

.progress:after,.progress-2:after,.progress-3:after,.progress-4:after,.progress-5:after{
    content: '';
    display: block;
    background: #337AB7;
    width:0%;
    height: 100%;
    border-radius: 9px;
}
.progress:after{
    width:var(--tooltip-percent);
}
.progress-2:after{
	width:var(--tooltip-percent);
}
.progress-3:after{
	width:var(--tooltip-percent);
}
.progress-4:after{
	width:var(--tooltip-percent);
}
.progress-5:after{
	width:var(--tooltip-percent);
}
.book-reviews-img{
    width:180px;
    height:240px;        
}
.book-reviews-img>img{
    width:auto;
    height:100%;
}
    </style>
</head>
<body>
    @include('layouts.navbar2')
    
    <div class="reviews-container md:max-w-xl sm:max-w-6xl md:mx-auto   bg-white-darker">
            <div class="book-reviews">
                    <div class="text-4xl font-semibold">{{$book->title}}</div>
                    <div class='book-reviews-img'>
                        @if($book->cover!=null)
                        <img src ="/storage/{{$book->cover }}" >
                        @else
                        <img src="/storage/default/book-image-not-available.png">
                        @endif
                    </div>
                </div>
            <div class="text-xl font-bold md:mx-0 sm:ml-4">
                Reviews 
                </div>
        <div class="review-row md:p-4">
            <div class="review-summary">
                <div class="md:p-4 secor">
                        <div class="ui statistic">
                                <div class="value">
                                        {{($ratings['average']['SCORE'])}}
                                </div>
                                
                                <div class="label">
                                Average Rating
                                </div>
                            </div>
                </div>
                <div class="progressbar">
                    <div style="--tooltip-percent: {{$ratings['scores'][5]['percentage']}}%;" class="progress sm:max-w-xs md:max-w-full"> </div>
                    <div style="--tooltip-percent: {{$ratings['scores'][4]['percentage']}}%;" class="progress sm:max-w-xs md:max-w-full"></div>
                    <div style="--tooltip-percent: {{$ratings['scores'][3]['percentage']}}%;" class="progress sm:max-w-xs md:max-w-full"></div>
                    <div style="--tooltip-percent: {{$ratings['scores'][2]['percentage']}}%;" class="progress sm:max-w-xs md:max-w-full"></div>
                    <div style="--tooltip-percent: {{$ratings['scores'][1]['percentage']}}%;" class="progress sm:max-w-xs md:max-w-full"></div>
                </div>
                <div class="md:right setar">
                        <div class="stars"  >
                            <div>
                                <i class="ui fullstar icon star padareview" data-star="1"></i>
                                <i class="ui fullstar icon star padareview" data-star="2"></i>
                                <i class="ui fullstar icon star padareview" data-star="3"></i>
                                <i class="ui fullstar icon star padareview" data-star="4"></i>
                                <i class="ui fullstar icon star padareview" data-star="5"></i>
                            </div>
                                <div class="ratingnumber"> {{$ratings['scores'][5]['percentage']}}% </div>
                        </div>
                       
                        <div style="width:auto;" class="stars"  >
                            <div>
                                <i class="ui fullstar icon star padareview" data-star="1"></i>
                                <i class="ui fullstar icon star padareview" data-star="2"></i>
                                <i class="ui fullstar icon star padareview" data-star="3"></i>
                                <i class="ui fullstar icon star padareview" data-star="4"></i>
                                <i class="ui greystar icon star padareview"></i>
                            </div>
                                <div class='ratingnumber'> {{$ratings['scores'][4]['percentage']}}% </div>
                        </div>
                       
                        <div style="width:auto;" class="stars"  >
                            <div>
                                <i class="ui fullstar icon star padareview" data-star="1"></i>
                                <i class="ui fullstar icon star padareview" data-star="2"></i>
                                <i class="ui fullstar icon star padareview" data-star="3"></i>
                                <i class="ui greystar icon star padareview"></i>
                                <i class="ui greystar icon star padareview"></i>
                            </div>
                                <div class="ratingnumber"> {{$ratings['scores'][3]['percentage']}}% </div> 
                        </div>
                       
                        <div style="width:auto;" class="stars"  >
                            <div>
                                <i class="ui fullstar icon star padareview" data-star="1"></i>
                                <i class="ui fullstar icon star padareview" data-star="2"></i>
                                <i class="ui greystar icon star padareview"></i>
                                <i class="ui greystar icon star padareview"></i>
                                <i class="ui greystar icon star padareview"></i>  
                            </div>
                                <div class="ratingnumber"> {{$ratings['scores'][2]['percentage']}}% </div>
                        </div>
                        <div style="width:auto;" class="stars"  >
                            <div>
                                <i class="ui fullstar icon star padareview" data-star="1"></i>
                                <i class="ui greystar icon star padareview"></i>
                                <i class="ui greystar icon star padareview"></i>
                                <i class="ui greystar icon star padareview"></i>
                                <i class="ui greystar icon star padareview"></i>
                            </div>
                                <div class="ratingnumber"> {{$ratings['scores'][1]['percentage']}}% </div>
                        </div>
                      
                </div>
                
            </div>
            {{-- <div class="single-content">
                    <div class="content">
                    <img src="https://semantic-ui.com/images/avatar/small/joe.jpg" alt="Smiley face" height="60" width="60">
                    <div class="isi">
                        <div class='meta-info'>Tere rated 5 <button class='editbutton'> Edit</button></div>
                        <div class="mb-4"></div>
                        <div style="text-align:justify;">empora dolorem consectetur iure. Autem, voluptates similique?</div>
                        <form class="ui reply form mt-5">
                            <div  class="field">
                            <input placeholder="give respond ..." type="text"/>
                            </div>
                            <div class="ui blue labeled submit icon button">
                            <i class="icon edit"></i>Respond
                            </div>
                        </form>
                    </div>
                    </div>
                    <div class="comment-row mt-4">
                        <div class="ml-10">
                                <div >nama author</div>
                                <div class="ui label grey">Author</div>
                                <div class="mt-4">
                                </div>
                                <div style="text-align:justify;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam iusto, nesciunt optio praesentium quos quam nulla a, eveniet ipsum similique mollitia repudiandae reiciendis id explicabo voluptas labore! Labore, numquam ab! Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore eveniet illo, nam eligendi harum obcaecati, et culpa dolor perferendis distinctio soluta temporibus consequuntur, impedit minima! Laborum aut assumenda ipsam fugiat! Lorem ipsum dolor sit amet consectetur, adipisicing elit. Reiciendis optio temporibus error aspernatur sunt culpa pariatur ullam impedit deserunt, dolore distinctio numquam quas tempora dolorem consectetur iure. Autem, voluptates similique?</div>
                        </div>
                    </div>
            </div> --}}
        </div>
    </div>
    <div class="ajax-load text-center" style="display:none">
            <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More Reviews</p>
        </div>
</body>
<script>
$(document).ready(function(){

    function replyaction(author,message,reviewid)
    {
        
      
        
        $.ajax({
            type : 'post',
            data: {a:author,m:message,r:reviewid},
            url: '/replyreview',
            success: function(data){
                if(data==1)
                {
                        location.reload();
                }
            
            }   
        });
    }
    function load_data(url)
        {   
            if(url==null)
            {
      
        $.ajax({
            type : 'get',
            url : "<?php echo url('/ajaxreviews/ratereviewcontroller');?>/<?php echo $book->book_id; ?>",
            success: function(data){
                $(".review-row").append(data.data);
                if(data.next!=null)
                {
                    $(".review-row").append('<div id="loadreviewbutton" value="'+data.next+'" style="max-width:500px;margin-left:auto;margin-right:auto;margin-top:1rem; " class="ui fluid button ">load More</div>');
                }else{
                    $("#loadreviewbutton").remove();
                }
                
                // $("#loadmore").html('<button id="loadmorebutton"  value="'+data.next+'">Load More</button>');
            }   
        });
            }else
            {     
               
                $.ajax({
                type : 'get',
                url : url,
                success: function(data){
                    console.log(data);
                    $(".review-row").append(data.data);
                    if(data.next!=null)
                    {
                        $(".review-row").append('<div id="loadreviewbutton" value="'+data.next+'" style="max-width:500px;margin-left:auto;margin-right:auto; margin-top:1rem;" class=" ui fluid button ">load More</div>');
                    }else{
                        $("#loadreviewbutton").remove();
                    }
                }   
                });
            }
        }
    $(document).on('click','.editbutton',function(e){
        var form = $(this).parent().parent().find('form');
        form.show();
    });
    $(document).on('click','.respondbutton',function(e){
        e.preventDefault();
        var form =   $(this).closest('form');
        var author= form.find('input[name="author"]').val();
        var reply =  form.find('input[name="reply"]').val();
        var reviewid =  form.find('input[name="reviewid"]').val();
        if(reply.trim().length==0)
        {
            alert('you need to add a text to reply');
        }else
        {
            replyaction(author,reply,reviewid);
        }
        });
        $(document).on('click', '#loadreviewbutton', function(){
        var id = $(this).attr('value');
        $('#loadreviewbutton').html('<b>Loading...</b>');
        load_data(id);
        });
        load_data();
    });
</script>
</html>