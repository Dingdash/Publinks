<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    {{-- <link rel = "stylesheet" href="{{asset('css/browse.css')}}"> --}}
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Publink</title>
    <style>
        .linktobook:hover{
        color:black;
        }
    </style>
    @include('layouts.navbarcss')
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
    <div class="px-12">
        <div class="ui grid stackable">
            <div class="fourteen wide column">
            <div class="px-8">
                <form class="ui form">
                    <div class="fields">
                        <div class="four wide field">
                            <input placeholder="search by author,name,tags" value="{{Request::get('q')}}" name="q" type="text">
                        </div>
                        <div class="five wide field">
                            <select id="filtergenre" name="c[]" value="" class="ui search dropdown" multiple>
                                <option value="">Filter Categories</option>
                                @foreach($categories as $c)
                                <option value="{{$c->category_id}}">{{$c->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <div id="filter" style="margin-left:10px;" class="ui filter labeled icon green button">
                                <i class="filter icon"></i>
                                Filter
                                <input type="hidden" value="{{Request::get('smax')}}" name="smax">
                                <input type="hidden" value=" {{Request::get('smin')}}" name="smin">
                                <input type="hidden" value="{{Request::get('mture')}}" name="mture">
                            </div>
                            <div class="ui mini modal">
                                <div class="header">Filter</div>
                                <div class="content">
                                    <p>Minimum price: IDR</p>
                                    <input style="border: 1px #ccc solid;" name="mprice" min="0" step=1000 type="number" />
                                    <p>Maximum price: IDR</p>
                                    <input style="border: 1px #ccc solid;" name="mxprice" min="14000" step=1000 type="number" />
                                    <div class="mt-2">
                                    </div>
                                    <div class="block text-xs text-grey-dark ui toggle checkbox" for="1"><input id='cboxmature' type="checkbox" value="on" name="M">
                                        <label>Mature</label>
                                    </div>
                                </div>
                                <div class="actions">
                                    <div class="ui green approve button ok">Update</div>
                                    <div class="ui clear button ok">Clear filter</div>
                                </div>
                            </div>
                        <input type="submit" class="ui primary submit button" value="Go"/>
                        </div>
                    </div>
                </form>
            </div>
            </div>
            <div class="twelve wide column">
                <div class="ui grid stackable five column">
                    @foreach ($books as $b)
                        <div class="column ">
                            <a class="linktobook" href="{{url('book/'. $b->book_id)}}">
                                <div class="ui padded grid  ">   
                                    <div class="shadow-md bg-white p-4 mx-auto"> 
                                        <div class="center aligned mx-auto">
                                            @if($b->cover==null)
                                            <img style="
                                            max-height: 25rem;" src ="/storage/default/book-image-not-available.png"> </img>
                                            @else
                                            <img style="width:100%; height:21rem; max-height:25rem;" src ="/storage/{{$b->cover }}" >
                                            
                                            @endif
                                        </div> 
                                        <div class="break-word mt-1 font-bold">{{$b->penulis->name}}</div>
                                        <div class="font-thin"> {{$b->title}}</div>  
                                        <div class="mt-4 pb-4 flex" style="overflow-x:auto; max-width: 200px;
                                        min-height: 10px;">
                                        @foreach($b->tags as $t)
                                        <a class='ui black label' href = "/browse?q={{$t->name}}"> {{$t->name}}</a>
                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach      
                </div>
            </div>
            <div class="four wide column ">
                <div class="ui segment">
                    <div class="ui center aligned header">
                        Browse By Categories
                    </div>
                    @foreach($categories as $c)
                    <div class='text-xl'>
                        <a href="{{url()->current()}}?category={{$c->category_id}}">{{$c->category_name}}</a>
                    </div>
                    @endforeach
                </div>
                <div class="ui segment">
                        <div class="ui center aligned header">
                           What's New from Users
                        </div>
                        @foreach($newbook as $c)
                        <div class='text-xl'>
                            <a href="{{url('/book').'/'.$c->book_id}}">{{$c->title}}</a>
                        </div>
                        @endforeach
                    </div>
            </div>
            <div class="fourteen wide column mx-auto">
                @if($books->hasMorePages()|| $books->nextPageurl()!=null || $books->previousPageUrl()!=null)
                <tfoot>
                    <tr>
                        <th colspan="7">
                            <div class="ui pagination menu">
                            {{$books->render('admin.paginator.semanticpaginator')}}
                                <!-- <a class="icon item">
                                    <i class="left chevron icon"></i>
                                </a>
                                <a class="item">1</a>
                                <a class="item">2</a>
                                <a class="item">3</a>
                                <a class="item">4</a>
                                <a class="icon item">
                                    <i class="right chevron icon"></i>
                                </a> -->
                            </div>
                        </th>
                    </tr>
                </tfoot>
                @endif
            </div>
        </div>
    </div>
</body>
<script>
    $("#filtergenre").dropdown();
    $('input[name=M]').checkbox();
    $('#filter').click(function () {
            $('.mini.modal')
                .modal('show')
                ;
        });
        $('.mini.modal').modal({
            onApprove: function(e){
                if(e.hasClass('approve')){
                    $("input[name=smax]").val( $("input[name=mxprice]").val());
                    $("input[name=smin]").val( $("input[name=mprice]").val());
                   if($("input[name=M]").prop('checked'))
                   {
                    $("input[name=mture]").val('on');
                   }else{
                    $("input[name=mture]").val('');
                   }
                  
                }else if (e.hasClass('clear')){
                    $("input[name=smax]").val("");
                    $("input[name=smin]").val("");
                    $("input[name=smax]").val("");
                    $("input[name=mture]").val("");
                    $("input[name=minprice]").val("");
                    $("input[name=maxprice]").val("");
                    $("#cboxmature").prop('checked', false);
                  // $("#btnsearch").trigger('click');
                    // $("#cboxmature").val('0');
                }
            }
        });
    </script>
</html>

