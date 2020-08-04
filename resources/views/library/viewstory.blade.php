<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.copyprotect')
    <!-- tailwindcss !-->
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <!-- tailwindcss !-->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Publink</title>
    <style>
        @media print{
        }
        #content>p{
          padding:0px;
          margin:0px;
        }
        #chapter-title{
          white-space: nowrap;
        }
        h2{
    background: black;
    color: white;
    font-size: 100%;
    font-weight: bold;
    margin: 0.7em 0 0.1em 0;
    padding: .25em 1em .25em 1em;
    -webkit-border-radius: .7em;
    -moz-border-radius: 1em;
    }
    .footerpage{
      display:flex;
      justify-content: space-between;
      min-width: 80%;
    }
      </style>
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
            <div class="mt-8">
              
            </div>
            <div class="container">
                {{-- <h1 class="ui centered header">
                  Title Chapter
                </h1> --}}
                <div  style="text-align:center; max-width: 60%; height:100%; overflow:auto; " class="ui mt-8 centered mx-auto" style="resize:vertical" >
                    @if(session('success'))
        <div class="ui icon success message ">
            <i class="info icon"></i>
            <div class="content">
                <div class="header">
                    Save Success
                </div>
                <p>{{session('success')}}</p>
            </div>
        </div>
        @endif
        </div>
        <div class="mt-8"></div>
              {{-- <input id="chapterid" type="hidden" name="chapterid" value="{{$chapter}}"/> --}}
                {{-- <div class='ui center aligned container'>
                    
                    <div class="ui compact menu">
                        <button id='italic-button' class="item">
                          <i class="italic icon"></i>
                        </button>
                        <button id='bold-button' class="item">
                          <i class="bold icon"></i>
                        </button>
                        <button id='under-button' class="item">
                            <i class="underline icon"></i>
                          </button>
                        <button id="left-icon" class="item">
                            <i class='align left icon'></i>
                          </button>
                        <button id="center-icon" class="item">
                          <i class='align center icon'></i>
                        </button>
                        <button id="right-icon" class="item">
                            <i class='align right icon'></i>
                          </button>
                          <button id="justify-icon" class="item">
                              <i class='align justify icon'></i>
                            </button>
                        
                        <button  id='header-button' class="item">
                          <i class="header icon"></i>
                        </button>
                        <button id='orderedlist-button' class="item">
                            <i class="list ol icon"></i>
                        </button>
                          <button id='unorderedlist-button' class="item">
                            <i class="list ul icon"></i>
                          </button>
                          <button id='undo-button' class="item">
                            <i class="undo icon"></i>
                          </button>
                          <button id='redo-button' class="item">
                            <i class="redo icon"></i>
                          </button>
                          <button id='link-button' class="item">
                            <i class='linkify icon'></i>
                          </button>
                          <button id='unlink-button' class="item">
                              <i class='unlink icon'></i>
                            </button>
                          
                          <button id="insertimage" class="item">
                            Insert Image
                          </button>
                          <div class="item">
                              <div id="publishtext" class="ui primary button">Publish</div>
                            </div>
                          <div class="item">
                              <button id='savetext' class="ui primary button" >Save</button>
                            </div>

                      </div>
                </div> --}}
      <h1>
      <div contenteditable="true" id="chapter-title" style="min-width:80%; padding:10px;max-width: 1000px; height:auto; overflow:auto; " class="ui mt-8 centered mx-auto" style="resize:vertical" rows="1" >Chapter title
      </div>
      </h1>
      <div id="content" class = "shadow-sm bg-white tailwind-container mx-auto"style="min-width:80%; min-height:50vh; padding:10px;max-width: 1000px; height:100%; overflow:auto; "  style="resize:vertical" >
        <?php echo $story;?>
{{--                     
          <div class="ui placeholder segment">
              <div class="ui two column stackable center aligned grid">
                <div class="ui vertical divider">Or</div>
                <div class="middle aligned row">
                  <div class="column">
                    <div class="ui icon header">
                      <i class="upload icon"></i>
                      Upload your story in PDF
                    </div>
                    <a href='createpdf' class="ui primary button">
                      Upload
                    </a>
                  </div>
                  <div class="column">
                    <div class="ui icon header">
                      <i class="pencil alternate icon"></i>
                      Make a Story Online
                    </div>
                    <div class="ui primary button">
                      Create
                    </div>
                  </div>
                </div>
              </div>
            </div> --}}
      </div>
      <div class="footerpage bg-white py-4 px-8 shadow-inner mx-auto tailwind-container">
        <div class="prev text-xl"><< Prev</div>
        <div class="dropdownstory text-xl">
              <select>
                <option> chapter one </option>
                <option> chapter one </option>
                <option> chapter one </option>
                <option> chapter one </option>
              </select>
        </div>
        <div class="next text-xl">Next >> </div>
        </div> 
      </div>
</body>
</html>