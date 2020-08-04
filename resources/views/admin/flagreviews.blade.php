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
    <title>Flagged Reviews</title>
</head>
<body>
@include ('admin.layout.header')


    
<div class='main-grid'>
    @include('admin.layout.aside')
            <main>
                    <div style="margin-top:20px;" class="ui breadcrumb">
                    <i class="right angle icon divider"></i>
                    <div class="section">Flagged Reviews</div>
                    </div>
                    
                                <h1>Flagged Reviews</h1>
                                
                                <form class="ui form">
                                       
                                        
                                    </form>
                                    @if(count($flags)>0)
                                <table class="ui celled padded table">
                                    <thead>
                                        <tr>
                                            <th>Review_id</th>
                                            <th>Amount of Flagged</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($flags as $f)
                                        <tr>
                                            <td>
                                                {{$f->review_id}}
                                            </td>
                                            <td class="single line">
                                                {{$f->jum}}
                                            </td>
                                            <td>
                                                <a href="{{url('/admin/flags/'.$f->review_id)}}">View Details</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
        </main>
</div>

</body>
<script>
   
    
</script>
</html>