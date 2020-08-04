<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <style>
    .greystar{
        color: gainsboro;
        
    }
    .fullstar{
        color: goldenrod;

    }
    .book-detail {
            margin-top:-10px;
                height:auto;
                display: grid;
                max-width: 100%;
                grid-template-columns: repeat(1, 1fr);
                padding-left: 20px;
                padding-bottom:20px;
            }
            @media (min-width: 320px) and (max-width: 480px) {
                    .book-detail {
                    height:auto;
                    display: grid;
                    max-width: 100%;
                    grid-template-columns: repeat(1, 1fr);
                    padding-left: 20px;
                    padding-bottom:20px;
                    text-align:center;
                }
            }
            @media(min-width:768px) {
                .book-detail {
                    height: auto;
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                }
            }
            .book-detail-left>img {
                width: 200px;
                height: 250px;
                
            }
            .book-detail-left {
                height:auto;
            }
            .book-detail-right{
                max-width:90%;
                
            }
            .reviews-container{
            max-width: 90%;
            display:grid;
            grid-auto-rows: minmax(0px,auto);
        }
        .tags{
        max-width: 90%;
        display:flex;
        display: -webkit-flex;
        -webkit-flex-direction: row;
        -webkit-flex-wrap: wrap;
        }
        .slider {
        -webkit-appearance: none;  /* Override default CSS styles */appearance: none;
        width: 40%; /* Full-width */height: 15px;border-radius: 5px;   
        background: #d3d3d3; /* Grey background */
        outline: none; /* Remove outline */
        opacity: 0.7; /* Set transparency (for mouse-over effects on hover) */
        -webkit-transition: .2s; /* 0.2 seconds transition on hover */
            transition: opacity .2s;
        }
/* Mouse-over effects */
.slider:hover {
  opacity: 1; /* Fully shown on mouse-over */
}
/* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */ 
.slider::-webkit-slider-thumb {
  -webkit-appearance: none; /* Override default look */appearance: none;
  width: 25px; /* Set a specific slider handle width */height: 25px;border-radius: 50%; 
  background: #4CAF50; /* Green background */
  cursor: pointer; /* Cursor on hover */
}
.slider::-moz-range-thumb {
  width: 25px; /* Set a specific slider handle width */
  height: 25px; /* Slider handle height */
  background: #4CAF50; /* Green background */
  cursor: pointer; /* Cursor on hover */
}
        .product-review{
            background-color:#e8eaed;
        }
        .comment-row{
            padding-left:2rem;
            padding-right:2rem;
            padding-top:2rem;
            padding-bottom:2rem;
            background-color: #e1e5eb;
        }

        .single-content{
            margin-top:4px;
            display:grid;
            grid-template-rows: auto auto;
            border-radius: 4px;
            border-width: 1px;
            border: solid;
            border-color: rgba(220,220,220,0.55);
        }
        .review-row>.single-content>.content{
            display:grid;
            grid-template-columns: 100px 1fr;
            padding-left:2rem;
            padding-right:2rem;
            padding-top:2rem;
            padding-bottom:2rem;   
        }
        .meta-info{
            display:grid;
            grid-auto-flow:column;
            justify-content: start;
        }
        .review-summary{
            max-width: 100%;
            margin:auto;
            display:grid;
            grid-template-columns: 2fr 4fr 2fr;
            align-content: space-around;
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
        .progress,.progress-2,.progress-3,.progress-4,.progress-5{
            background:#F5F5F5;
            border-radius: 13px;
            height:18px;
            width:97%;
            padding:3px;
            margin:5px 0px 3px 0px;
        }
/* .stars>.star{
    height:18px;
    padding:3px;
    
    font-size:15px !important;
    color:goldenrod;
} */

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
#editbutton{
    display: grid;
    justify-content: end;
    align-content: center;
    grid-auto-flow: column;
    font-size: 15px;
    grid-gap:20px;
}        
    </style>
    <title>Publink</title>
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
<div class=" mx-auto">
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
        <div class="book-detail bg-white">
            <div class="book-detail-left lg:p-20">
                {{-- {{var_dump($book)}} --}}
               
                <p class="text-2xl">{{$book->title}}</p>
                @if($book->cover==null)
                <img src ="/storage/default/book-image-not-available.png">
                @else
                <img style="object-fit: cover; height:auto; max-width:250px;" src ="/storage/{{$book->cover }}" >
                @endif
                <p class="text-sm">{{$book->penulis->name}}</p>
                <p class="text-2xl ">{{$book->progress}}% Completed</p>
                @if($book->mature==0 || $book->mature=="0" || $book->mature=="")
                @else
                <p class="text-lg text-red font-semibold">Rated Mature </p>
                @endif
                <p class="text-sm text-grey">last updated on {{$book->updated_at}} </p>
                <div class='tags'>
                        @if(count($book->tags)>0)
                            @foreach($book->tags as $tag)
                                <div class="pb-4 mr-2">
                                        <div class="ui tag tagitem label">
                                            {{$tag->name}}
                                        </div>
                                </div>
                            @endforeach
                        @endif
                </div>
            </div>
            <div class="book-detail-right lg:pt-20">
                 <form method="POST" action={{url('cart/add/'.$book->book_id)}}>
                <div style="min-height:60%;">
                    
                <p class="text-2xl max-w-sm mb-5">{{$book->title}}</p>
                <p class="text-justify text-1xl pr-10">{{$book->about}}</p>
                <input type="hidden" name="free" value="{{$book->free}}">
                <div class="mb-4"></div>
            @if($book->published==0)
           
          <div class="text-xl">  Sorry this book hasn't been published by the author.</div>
            @else
                @if(!$inlib)
                @if($book->free==0)
                <div class="text-xl mb-4">
                        How much you want to pay ?
                    </div>
                <input class="slider" style="min-width: 40%;" name='price' min="{{$book->min_price}}" max="{{$book->max_price}}" value={{$book->min_price}} step="100" type="range">
                <div class="mb-4"></div>
                <div id='text-price' class="text-2xl tracking-wide">
                    Price : IDR {{number_format($book->min_price,0,',','.')}}
                </div>
                <div class="mb-2"></div>
                @else
                <div class="text-2xl tracking-wide">
                    Price : Free!
                </div>
                @endif
                @endif
            </div>
            <div>
                @if(session('user')->user_id==$book->author)
                    <button id='btnedit' onclick="window.location.href='{{url('/authorstory')}}'" class="ui blue icon button">
                    <i class="edit icon"></i>
                    Edit
                    
                </button>
                <a href="{{url('read/'.$book->book_id)}}">
                    <div class="ui black button">Read this book</div>
                </a>
                @else
                @if($inlib)
                <a href="{{url('read/'.$book->book_id)}}">
                        <div class="ui black button">Read this book</div>
                </a>
                <a href="{{url('review/'.$book->book_id)}}">
                    <div class="ui primary button">Write a review</div>
                </a>
                @else
             {{csrf_field()}}
                  
                <button type="submit" class="bg-blue text-white text-1xl p-4">
                    Add to cart
                </button>
                
                </form>
                <div class="mb-4"></div>
                <form action="{{url('addtowishlist/'.$book->book_id)}}" method='POST'>
                    {{csrf_field()}}
                <button type="submit" class="text-blue">Add to Wishlist</button>
                </form>
                @endif
                @endif
                @endif
            </div>
        
        </div>
        </div>
        {{-- <hr class=" h-1"> --}}
        <div class="author bg-grey-light">
            <div style="text-align:center;" class="pt-5 mb-4 text-2xl">Table of Content</div>
            <div style='text-align:center;' class="mx-auto mt-8">
            </div>
            <div class="leading-normal text-center text-xl font-semibold sm:px-32 lg:px-32 mx-auto break-word pb-4"><?php echo nl2br($book->toc,false);?>

                 
            </div>
        </div>
        <div class="author bg-grey-lighter">
            <div style="text-align:center;" class="pt-5 mb-4 text-2xl">About the Author</div>
            <div class="w-48 mx-auto">
                @if($book->penulis->profpic!=null)
                <img style="text-align:center;" src="{{'/storage/'. $book->penulis->profpic}}" class="bg-blue rounded-full h-48 w-48 flex items-center justify-center">
                @else
                <img style="text-align:center;" src="/storage/default/default-avatar.png" class="bg-blue rounded-full h-48 w-48 flex items-center justify-center">
                @endif
            </div>
            <h1 class="ui align centered header">{{$book->penulis->name }} </h1>
            <div style='text-align:center;' class="mx-auto mt-8">
                    <a class="ui align centered green button" href="{{url('u/'.$book->penulis->user_id)}}" class="item">View Profile</a>
            </div>
            <div class="leading-normal text-justify text-xl sm:px-32 lg:px-32 mx-auto break-word pb-4">
                <?php echo nl2br($book->penulis->about,false);?>
                
                    @if($book->penulis->website!=null)
                <p class="mt-4">Website :    <a class="lg:ml-2" href="{{$book->penulis->website}}">  {{$book->penulis->website}}</a></p>
                @endif
            </div>
        </div>
        
    </div>
    <div class="product-review">
            <div class="reviews-container mx-auto">
                    <div class="mt-4"></div>
                    <div class="ui header">
                            Reviews
                    </div>
                    @if(count($reviews)>0)
                    <div class="review-summary">
                            <div class="left p-4">
                                    <div class="ui statistic">
                                            <div class="value">
                                            {{($ratings['average']['SCORE'])}}
                                            </div>
                                            <div class="label">  
                                            </div>
                                            <div class="label">
                                            Average Rating
                                            </div>
                                        </div>
                            </div>
                            <div class="progressbar">
                            <div style="--tooltip-percent: {{$ratings['scores'][5]['percentage']}}%;" class="progress"> </div>
                            <div style="--tooltip-percent: {{$ratings['scores'][4]['percentage']}}%;" class="progress"></div>
                            <div style="--tooltip-percent: {{$ratings['scores'][3]['percentage']}}%;" class="progress"></div>
                            <div style="--tooltip-percent: {{$ratings['scores'][2]['percentage']}}%;" class="progress"></div>
                            <div style="--tooltip-percent: {{$ratings['scores'][1]['percentage']}}%;" class="progress"></div>
                            </div>
                            <div class="right">
                                    <div style="width:auto;" class="stars"  >
                                            <i class="ui fullstar icon star" data-star="1"></i>
                                            <i class="ui fullstar icon star" data-star="2"></i>
                                            <i class="ui fullstar icon star" data-star="3"></i>
                                            <i class="ui fullstar icon star" data-star="4"></i>
                                            <i class="ui fullstar icon star" data-star="5"></i>
                                    </div>
                                    <div class="text-right"> {{$ratings['scores'][5]['percentage']}}% </div>
                                    <div style="width:auto;" class="stars"  >
                                            <i class="ui fullstar icon star" data-star="1"></i>
                                            <i class="ui fullstar icon star" data-star="2"></i>
                                            <i class="ui fullstar icon star" data-star="3"></i>
                                            <i class="ui fullstar icon star" data-star="4"></i>
                                            <i class="ui greystar icon star "></i>
                                    </div>
                                    <div class="text-right"> {{$ratings['scores'][4]['percentage']}}% </div>
                                    <div style="width:auto;" class="stars"  >
                                            <i class="ui fullstar icon star" data-star="1"></i>
                                            <i class="ui fullstar icon star" data-star="2"></i>
                                            <i class="ui fullstar icon star" data-star="3"></i>
                                            <i class="ui greystar icon star "></i>
                                            <i class="ui greystar icon star "></i>
                                            
                                    </div>
                                    <div class="text-right"> {{$ratings['scores'][3]['percentage']}}% </div>
                                    <div style="width:auto;" class="stars"  >
                                            <i class="ui fullstar icon star" data-star="1"></i>
                                            <i class="ui fullstar icon star" data-star="2"></i>
                                            <i class="ui greystar icon star "></i>
                                            <i class="ui greystar icon star "></i>
                                            <i class="ui greystar icon star "></i>
                                    </div>
                                    <div class="text-right"> {{$ratings['scores'][2]['percentage']}}% </div>
                                    <div style="width:auto;" class="stars"  >
                                            <i class="ui fullstar icon star" data-star="1"></i>
                                            <i class="ui greystar icon star "></i>
                                            <i class="ui greystar icon star "></i>
                                            <i class="ui greystar icon star "></i>
                                            <i class="ui greystar icon star "></i>
                                    </div>
                                    <div class="text-right"> {{$ratings['scores'][1]['percentage']}}% </div>
                            </div>
                        </div>
                    <div class="review-row p-4">
                    </div>
                    @else
                        <div style="text-align:center;" class='text-xl noreview pb-8'>
                        This Book has no reviews.
                        </div>
                    @endif
                </div>
    </div>  
</body>
<script>
    $(document).ready(function(){
        $("#btnedit").click(function(e){
            e.preventDefault();
        });
        $("input[name='price']").on('input',function(){
            $('#text-price').html('Price : IDR '+ numberformat($(this).val())) ;
        });
        function numberformat(number)
        {
        var bilangan = number;
        var	reverse = bilangan.toString().split('').reverse().join(''),
            ribuan 	= reverse.match(/\d{1,3}/g);
            ribuan	= ribuan.join('.').split('').reverse().join('');
        // Cetak hasil	
        return ribuan;
        }
        function load_data(url)
        {
            if(url==null)
            {
               
        $.ajax({
            type : 'get',
            url : "<?php echo url('/ajaxreviews/');?>/<?php echo $book->book_id; ?>",
            success: function(data){
                $(".review-row").append(data.data);
                if(data.next!=null)
                {
                    $(".review-row").append('<div id="loadreviewbutton" value="'+data.next+'" style="max-width:500px;margin-left:auto;margin-right:auto;margin-top:1rem; " class="ui fluid button ">Load More</div>');
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
    $(document).on('click', '#loadreviewbutton', function(){
            var id = $(this).attr('value');
            $('#loadreviewbutton').html('<b>Loading...</b>');
            load_data(id);
    });

        load_data();
            
    }); 
    
</script>
</html>