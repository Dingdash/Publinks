<html>
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="_token" content="{{csrf_token()}}" />
        <link rel="stylesheet" href="{{asset('css/admin/manageusers.css')}}">
        <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
        <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
        <title>Books</title>
        <style>
        @media print
        {
        body * { visibility: hidden; }

        .notprint,.notprint *{display: none;}
        table * { visibility: visible; }
        #headerprint{visibility:visible;top:10px;left:30px; position:absolute;}
        table { position: absolute; top: 100px; left: 30px; }
        tfoot{visibility: hidden;}
        }
        </style>
    </head>
    
    <body>
        <div id="header">
            <div id='logo'>
                ADMIN
            </div>
            <div id="links">
                <a href="http://" target="_blank" rel="noopener noreferrer">Log Out</a>
            </div>
        </div>
    <div class='main-grid'>
        @include('admin.layout.aside')
                <main>
                        <div style="margin-top:20px;" class="ui breadcrumb">
                        <i class="right angle icon divider"></i>
                        <div class="section">Favorite Reports</div>
                        </div>
                                    <h1> Favorite Report </h1>
                                    <div id="btnclear" class="ui red button" onclick="javascript:window.location.href='/admin/favorites';return false; "> Clear Filter</div>
                                    <button id='btnprint' class='ui primary button' style="margin-bottom:20px;"> Print Table </button>
                                   
                                    <form class="ui form" >
                                      <div class="inline fields">
                                          <div class="two wide field" data-tooltip="search by booktitle">
                                                  <input id='text-search' name='q' value="{{Request::get('q')}}" type="text" placeholder="Search...">
                                          </div>
                                          <select id="filtergenre" name="c[]" value="" class="ui search dropdown" multiple>
                                            <option value="">Filter Categories</option>
                                            @foreach($categories as $c)
                                            <option value="{{$c->category_id}}">{{$c->category_name}}</option>
                                            @endforeach
                                          </select>
                                          <div class="ml-4">
                                            
                                          </div>
                                          <div class=" field">
                                                  <div class="block text-xs text-grey-dark ui toggle checkbox" for="1"><input id='cboxmature' type="checkbox" name="m" @if(Request::get('m')=='on'){{'checked'}}@endif>
                                                      <label>Mature</label>
                                                  </div>
                                                  
                                          </div>
                                          <div class="field">
                                            <input type="number" name="top" value="{{Request::get('top')}}"  id="dropshow" class="bg-white mb-4 p-3"  placeholder="Show top 5 ..."/>
                                            
                                          </div>
                                          <div class="field">
                                              <input class="ui green button" type="submit" value="Search">
                                          </div>
                                      </div>
                                          
                                  </form>
                                    <table id='data' class="ui celled table">
                                            <thead>
                                                
                                                    <tr><th>Book ID</th><th class="five wide">Book Title</th>
                                                    <th> Categories </th>
                                                    <th> Progress</th>
                                                    <th >Favorites</th>
                                                    
                                                    <th> Published </th>
                                                  </tr></thead>
                                        <tbody>
                                                @if($books!=null)
                                                
                                                        @foreach($books as $b)
                                                      <tr>
                                                            <td>
                                                                    {{$b->book_id}}
                                                                  </td>
                                                        <td>
                                                          {{$b->title}}
                                                        </td>
                                                        <td>
                                                                {{$b->cat->category_name}}
                                                              </td>
                                                        <td>{{$b->progress}}%</td>
                                                        
                                                        <td>
                                                                <h2 class="ui center aligned header">{{$b->countlikes()}}</h2>
                                                              </td>
                                                        <td>
                                                          <h2 class="ui center aligned header">{{$b->published}}</h2>
                                                                
                                                            
                                                        </td>
                                                      </tr>
                                                      @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                      
                                                            {{-- <tr><th colspan="7">
                                                                    <div class="ui right floated pagination menu">
                                                                      <a class="icon item">
                                                                        <i class="left chevron icon"></i>
                                                                      </a>
                                                                      <a class="item">1</a>
                                                                      <a class="item">2</a>
                                                                      <a class="item">3</a>
                                                                      <a class="item">4</a>
                                                                      <a class="item">1</a>
                                                                      <a class="item">2</a>
                                                                      <a class="item">3</a>
                                                                      <a class="item">4</a>
                                                                      <a class="item">1</a>
                                                                      <a class="item">2</a>
                                                                      <a class="item">3</a>
                                                                      <a class="item">4</a>
                                                                      <a class="icon item">
                                                                        <i class="right chevron icon"></i>
                                                                      </a>
                                                                    </div>
                                                                  </th> --}}
                                                                  
                                                    </tfoot>
                                                  </table>
                                                  @else
                                                  <div style="max-width:800px;" class='ui centered mx-auto'>
                                                        <div style='text-align:center;' class="ui placeholder segment">
                                                                <h1>There are no books</h1>
                                                                {{-- <p><a href="{{url('/createmenu')}}">click here to make a new one</a>  </p> --}}
                                                        </div>
                                                        
                                                    </div>
                                                  @endif
                                            
                                        </tbody>
                                      
                                       
                                        
                                    
                                </main>
    </div>
    </body>
    <script>
      $(document).ready(function(){
        $("#filtergenre").dropdown();
        $("#btnprint").click(function(){
            window.print();
        });
        function fetchdata(query)
        {
          $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
          $.ajax({
            type : 'get',
            url : "<?php echo url('admin/books/livesearch');?>",
            data:{'q':query},
            success: function(data){
              $("#data").html(data);
            }
          });
        }
         $("#text-search").on('keyup',function(){
          var query = $(this).val();
          fetchdata(query);
        });
      });
        
    </script>
  </html>