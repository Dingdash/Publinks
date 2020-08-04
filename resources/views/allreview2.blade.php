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
        .reviews-container{
            max-width: 50%;
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
            grid-template-columns: 100px 1fr;
            padding-left:2rem;
            padding-right:2rem;
            padding-top:2rem;
            padding-bottom:2rem;   
        }
        .meta-info{
            display:grid;
            grid-auto-flow:column;
        }
        #editbutton{
            display: grid;
            justify-content: end;
            align-content: center;
            grid-auto-flow: column;
            font-size: 15px;
            grid-gap:20px;
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
        .review-summary{
            display:grid;
            grid-template-columns: 2fr 4fr 2fr;
            align-content: space-around;
        }
        .progress,.progress-2,.progress-3,.progress-4,.progress-5{
    background:#F5F5F5;
    border-radius: 13px;
    height:18px;
    width:97%;
    padding:3px;
    margin:5px 0px 3px 0px;
}
.star{
    height:18px;
    padding:3px;
    
    font-size:15px !important;
    color:goldenrod;
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

    </style>
</head>
<body>

        
        
            </div>
    <div class="reviews-container mx-auto bg-white-darker">
            <div  class="ui header">
                Reviews 
                </div>

        <div class="review-row p-4">
            <div class="review-summary">
                <div class="left p-4">
                        <div class="ui statistic">
                                <div class="value">
                                  3.5
                                </div>
                                <div class="label">
                                    
                                </div>
                                <div class="label">
                                  Average Rating
                                </div>
                              </div>
                </div>
               <div class="progressbar">
                <div style="--tooltip-percent: 0%;" class="progress"> </div>
                <div style="--tooltip-percent: 30%;" class="progress-2"></div>
                <div style="--tooltip-percent: 0%;" class="progress-3"></div>
                <div style="--tooltip-percent: 0%;" class="progress-4"></div>
                <div style="--tooltip-percent: 0%;" class="progress-5"></div>
                </div>
                <div class="right">
                        <div style="width:auto;" class="stars"  >
                                
                                <i class="ui icon star" data-star="1"></i>
                                <i class="ui icon star" data-star="2"></i>
                                <i class="ui icon star" data-star="3"></i>
                                <i class="ui icon star" data-star="4"></i>
                                <i class="ui icon star" data-star="5"></i>
                                
                                
                        
                        </div>
                        <div> 100% </div>
                        <div style="width:auto;" class="stars"  >
                                <i class="ui icon star" data-star="1"></i>
                                <i class="ui icon star" data-star="2"></i>
                                <i class="ui icon star" data-star="3"></i>
                                <i class="ui icon star" data-star="4"></i>
                        </div>
                        <div> 10% </div>
                        <div style="width:auto;" class="stars"  >
                                <i class="ui icon star" data-star="1"></i>
                                <i class="ui icon star" data-star="2"></i>
                                <i class="ui icon star" data-star="3"></i>
                                
                        </div>
                        <div> 10% </div>
                        <div style="width:auto;" class="stars"  >
                                <i class="ui icon star" data-star="1"></i>
                                <i class="ui icon star" data-star="2"></i>
                                
                                
                        </div>
                        <div> 10% </div>
                        <div style="width:auto;" class="stars"  >
                                <i class="ui icon star" data-star="1"></i>
                        </div>
                        <div> 10% </div>
                </div>
            </div>
            <div class="single-content">
                    <div class="content">
                    <img src="https://semantic-ui.com/images/avatar/small/joe.jpg" alt="Smiley face" height="60" width="60">
                    <div class="isi">
                        <div class='meta-info'>Tere rated 5  <div id="editbutton"> edit</div></div>
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
            </div>
            
        </div>
    </div>
</body>
</html>