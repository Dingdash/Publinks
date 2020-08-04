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
        <title>Userlog</title>
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
    @include ('admin.layout.header')
    <div class='main-grid'>
    @include('admin.layout.aside')
<main>
    <div style="margin-top:20px;" class="ui breadcrumb">
        <i class="right angle icon divider"></i>
        <div class="section">Userlog Reports</div>
    </div>
    <h1 class=""> User Logs </h1>
    <!--<button id='btnprint' class='ui primary button' > Print Table </button>-->
    <div class="mt-10">
        <form class="ui form" >
                    <div class="inline fields">
                        <div class="field"  data-tooltip="search by username or userid">
                                <input id='text-search'  type="text" name='q' placeholder="search...">
                        </div>
                        <div class="field">
                                <button class = 'ui primary button' type="submit">Search </button>
                                <a href="{{url('admin/userlog')}}" class='ui red button'> Clear Filter </a>
                        </div>
                    </div>
        </form>
    </div>
    <table id='data' class="ui celled table">
        <thead>
            <tr><th class='one wide'>Log ID</th>
            <th class="one wide">User_id</th>
            <th class="five wide">Username</th>
            <th class="five wide"> Description </th>
            <th> Created_at</th>
            </tr>
        </thead>
        <tbody>
            @if($userlog!=null)
                @foreach($userlog as $b)
                <tr>
                    <td>{{$b->id}}</td>
                    <td>{{$b->user_id}}</td>
                    <td>{{$b->user->username}}</td>
                    <td>{{$b->text}}</td>
                    <td>{{ ($b->created_at)}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                @if($userlog->hasMorePages()|| $userlog->nextPageurl()!=null || $userlog->previousPageUrl()!=null)
                <tfoot>
                    <tr>
                        <th colspan="7">
                            <div class="ui pagination menu">
                            {{$userlog->render('admin.paginator.semanticpaginator')}}
                            </div>
                        </th>
                    </tr>
                </tfoot>
                @endif
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
</html>