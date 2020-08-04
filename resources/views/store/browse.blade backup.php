<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel = "stylesheet" href="{{asset('css/browse.css')}}">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Publink</title>
    @include('layouts.navbarcss')
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
        
    <div class="outer-grid">   
            
                    <div class=" ml-10 mt-3">
                        
                            <div style="min-width:50%;" class="ui icon input mr-3">
                              <input id='querytext' class="prompt" type="text" placeholder="Search by title,author,tags">
                              
                            </div>
                            
                            <button id="btnsearch" class="ui black button">
                                Search
                            </button>
                            
                            <div id="filter" style="margin-left:10px;" class="ui filter labeled icon blue button">
                                    <i class="filter icon"></i>
                                    Filter
                            </div>
                            
                            <select id="filtergenre" class="ui search dropdown" multiple="">
                                <option value="">Filter Categories</option>
                                @foreach($categories as $c)
                                <option value="{{$c->category_id}}">{{$c->category_name}}</option>
                                @endforeach
                              </select>
                    </div>
                 
            <div class="main-grid mt-8">
                    
                    
                      <div class="product-grid">
                        @foreach($books as $book)
                        <div class='grid-items'>
                        <a href="{{url('book/'. $book->book_id)}}">
                            @if($book->cover==null)
                            <img src="https://cdn11.bigcommerce.com/s-gho61/stencil/31cc7cb0-5035-0136-2287-0242ac11001b/e/3dad8ea0-5035-0136-cda0-0242ac110004/images/no-image.svg">
                            @else
                            <img src ="{{route('book.image', ['filename' => $book->cover]) }}" >
                            @endif
                            <div class="break-word mt-1 font-bold">{{$book->penulis['name']}} </div>
                            <div class="font-thin"> {{$book->title}}</div>
                            {{-- <div >
                                <i class="ui icon eye"></i>200 <i class="ui icon like"></i>50
                            </div> --}}
                          
                        </a>
                      </div>
                        @endforeach
                    </div>
                        
                   
                   <div class='pagination'>
                     tes
                   </div>
            </div>
            <div class='sidebar-right'>
                    <div class="ui segment">
                        <h3 class="header center aligned ui">
                            Categories
                        </h3>
                        @foreach($categories as $category)
                        <div class="row">
                        <a href="{{url()->current()}}?category={{$category->category_id}}">{{$category->category_name}}</a>
                        </div>
                        @endforeach
                    </div>
                    <div class="ui segment">
                            <h3 class="header center aligned ui">
                                Best Selling Books
                            </h3>
                            <div class="row">
                                Single Item
                            </div>
                        </div>
            </div>
            <footer>
                {{-- pagination --}}
            </footer>
    </div> 
    <div class="ui mini modal">
            <div class="header">Filter</div>
            <div class="content">
                <p>Minimum price: IDR</p>
                <input style="border: 1px #ccc solid;" min="0" step=1000 type="number" />
                <p>Maximum price: IDR</p>
                <input style="border: 1px #ccc solid;" min="14000" step=1000 type="number" />
                <div class="mt-2">
                </div>
                <div class="block text-xs text-grey-dark ui toggle checkbox" for="1"><input id='cboxmature' type="checkbox" name="Mature">
                    <label>Mature</label>
                </div>
            </div>
            <div class="actions">
                <div class="ui green approve button ok">Update</div>
                <div class="ui clear button ok">Clear filter</div>
                <div class="ui red cancel button">Cancel</div>
            </div>
        </div>
</body>
<script>
    $(document).ready(function(){
      var mature=null;
        $("#filtergenre").dropdown();
        $('#filter').click(function () {
            $('.mini.modal')
                .modal('show')
                ;
        });
        $("#btnsearch").click(function(){
          var q = $("#querytext").val();
          var categories = $("#filtergenre").dropdown('get value');
         var m= $("#cboxmature").val();
          $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
          $.ajax({
            type : 'get',
            url : "<?php echo url('/cobasearch');?>",
            data:{'q':q,'c':categories,'m':mature},
            success: function(data){
              $(".main-grid").html(data);
            }
          });
        });
        $('.mini.modal').modal({
            onApprove: function(e){
                if(e.hasClass('approve')){
                  if($("#cboxmature").is(":checked"))
                  {
                    mature = 1;
                  }
                  else{
                    mature =-1;
                  }
                  
                    // alert('tes');
                    $("#btnsearch").trigger('click');
                }else if (e.hasClass('clear')){
                  mature=-1;
                  $("#cboxmature").prop('checked', false);
                  $("#btnsearch").trigger('click');
                    // $("#cboxmature").val('0');
                }
            }
        });
    });
      
    
    </script>
</html>

