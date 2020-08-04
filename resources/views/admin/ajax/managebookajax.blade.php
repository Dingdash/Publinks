
<table id='data' class="ui celled table">
        <thead>
            
                <tr><th>Book ID</th><th class="five wide">Book Title</th>
                <th> Categories </th>
                <th> Progress</th>
                <th class="notprint">Actions</th>
                <th >Favorites</th>
                <th> Last Updated </th>
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
                <td class="notprint" style="text-ailgn:center;">
                        <p> <a href="{{url('/viewtraffics')}}"> View Traffics</a>
                </td>
                
                <td>
                        <h2 class="ui center aligned header">{{$b->countlikes()}}</h2>
                      </td>
                <td>
                        {{ Carbon\Carbon::parse($b->updated_at)->diffForHumans() }}
                        
                    
                </td>
              </tr>
              @endforeach
            
            <tfoot>
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
                   
                          
            </tfoot>
        @endif