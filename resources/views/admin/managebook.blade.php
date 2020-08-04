<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{csrf_token()}}" />
    <link rel="stylesheet" href="{{asset('css/admin/manageusers.css')}}">
    <link rel="stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <script src="{{asset('js/tablesort.min.js')}}"></script>
    <title>Manage Books</title>
    <style>
            @media print
{
body * { visibility: hidden; 


}
html, body {
        border: 1px solid white;
        height: 99%;
        page-break-after: avoid;
        page-break-before: avoid;
     }
.notprint,.notprint *{display: none;}
table * { visibility: visible; }
#headerprint{visibility:visible;top:10px;left:30px; position:absolute;}
table { position: absolute; top: 100px; left: 30px; }
tfoot{visibility: hidden;}
}
        </style>
</head>
<body>

@include ('admin.layout.header')
<div class='main-grid'>
@include('admin.layout.aside')
    <main>
    <div style="margin-top:20px;" class="ui breadcrumb">
        <i class="right angle icon divider"></i>
        <div class="section">Manage Books</div>
    </div>
    <h1 class=""> Manage Book </h1>
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
<div class="ui icon success message ">
    <i class="info icon"></i>
    <div class="content">
        <div class="header">
            Success
        </div>
        <p>{{session('success')}}</p>
    </div>
</div>
@endif
            {{-- <button id='btnprint' class='ui primary button' > Print Table </button> --}}
            <a href="{{url('admin/managebooks')}}" class='ui red button'> Clear Filter </a>

    <div class="mt-10">
            <form class="ui form" >
                <div class="inline fields">
                    <div class="two wide field" data-tooltip="search by booktitle">
                            <input id='text-search' name='q' type="text" placeholder="Search...">
                    </div>
                    <div class="two wide field">
                            <div class="block text-xs text-grey-dark ui toggle checkbox" for="1"><input id='cboxmature' type="checkbox" name="m" @if(Request::get('m')=='on'){{'checked'}}@endif>
                                <label>Mature</label>
                            </div>
                    </div>
                    <div class="field">
                        <input class="ui green button" type="submit" value="Search">
                    </div>
                </div>
                    
            </form>
    </div>
<table id='data' class="ui celled table sortable">
<thead>
<tr><th>Book ID</th><th class="five wide">Book Title</th>
<th> Categories </th>
<th> Progress</th>
<th> Published</th>
<th> Mature </th>
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
<td>{{$b->published}}</td>
<td>
    @if($b->mature==null || $b->mature >0)
    {{'Not Mature'}}
    @else
    {{'Mature'}}
    @endif
</td>
<td class="notprint" style="">
    <div class="ui form" >
            <div class="field">
                    <button class="ui secondary button" onclick="window.location.href = '{{url('/admin/previewbook/'.$b->book_id)}}' ">Preview Book</button>
            </div>
            <div class="field">
                
                <div class="ui buttons">
                        <button class="ui green button" onclick="window.location.href = '{{url('/admin/viewtraffics/'.$b->book_id.'/'.$b->author)}}' ">View Traffics</button>
                        
                        @if($b->status==1)
                        <form method="POST" action="/admin/deletebook">
                            {{csrf_field()}}
                            <input type="hidden" name="bookid" value="{{$b->book_id}}">
                        <button data-tooltip="Remove" class="ui blue icon button">
                            <i class="trash icon"></i>
                          </button>
                        </form>
                          @else
                          
                          <form method="POST" action="/admin/restorebook">
                            {{csrf_field()}}
                            <input type="hidden" name="bookid" value="{{$b->book_id}}">
                        <button data-tooltip="Restore" class="ui red icon button">
                            <i class="undo icon"></i>
                          </button>
                        </form>

                          @endif
                </div>
            </div>
    </div>
        
</td>
<td>
    <h2 class="ui center aligned header">{{$b->countlikes()}}</h2>
    </td>
<td>
    
    {{ Carbon\Carbon::parse($b->updated_at)->diffForHumans() }}
    

</td>
</tr>
@endforeach
</tbody>
<tfoot>
<tr>
<th colspan="9">
@if($books->hasMorePages()|| $books->nextPageurl()!=null || $books->previousPageUrl()!=null)
<div class="ui pagination menu">
{{$books->render('admin.paginator.semanticpaginator')}}
</div>
@endif
</th>
</tr>
</tfoot>
@else
<div style="max-width:800px;" class='ui centered mx-auto'>
<div style='text-align:center;' class="ui placeholder segment">
    <h1>You don't have any story</h1>
    <p><a href="{{url('/createmenu')}}">click here to make a new one</a>  </p>
</div>
</div>
@endif
</tbody>
</table>
</main>
</body>
<script>
    $(document).ready(function(){
        $('table').tablesort();
        $("#btnprint").click(function(){
            window.print();
        });
    });
</script>
</html>