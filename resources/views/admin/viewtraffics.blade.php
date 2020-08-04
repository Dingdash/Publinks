<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/admin/manageusers.css')}}">
    <link rel="stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <script src="{{asset('js/tablesort.min.js')}}"></script>
    
    <meta name="_token" content="{{csrf_token()}}" />
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    
    
    <style>
        #chart-container{
            width: 100%;
        }
    </style>
    <title>View Traffics Admin</title>
</head>

<body>
    
    
    @include ('admin.layout.header')
    <div class="main-grid">
        
    @include ('admin.layout.aside')
    <main>
    
    <div style="margin-top:20px;" class="ui breadcrumb">
        <i class="right angle icon divider"></i>
        <div class="section"><a href="{{url('admin/managebooks')}}">Manage Books</a></div>
        <i class="right angle icon divider"></i>
        <div class="section">View Traffics</div>
    </div>
    <h1 class="header">
            View Traffic Info
        </h1>
        
        <div class="mt-4">
        </div>
        <form class="flex" method="get">
            <div class="ui selection dropdown">
                    <input type="hidden" name="time" <?php if(isset($_GET['time'])){echo "value = '".$_GET['time']."'";}?>>
                    <i class="dropdown icon"></i>
                    <div class="default text">Choose Time</div>
                    <div class="menu">                                
                        @foreach($dropdown as $d)
                    <div class="item" data-value="{{$d}}">{{$d}}</div>
                    {{-- <div class="item" data-value="0">Female</div> --}}
                    @endforeach
                    </div>
            </div>
            <div class="ml-8">
            </div>
            <div class="ui selection dropdown">
                <input type="hidden" name="stories" <?php if(isset($_GET['stories'])){echo "value = '".$_GET['stories']."'";}?>>
                <i class="dropdown icon"></i>
            <div class="default text"></div>
                <div class="menu">
                        <div class="item" data-value="all">all</div>
                    @if(!$data['books']->isEmpty())
                    @foreach($data['books'] as $d)
                <div class="item" data-value="{{$d->book_id}}">{{$d->title}}</div>
                @endforeach
                @endif
                </div>
            </div>
            <div class="ml-8">
                <input type="submit" class="ui primary button" value="go"/>
            </div>
        </form>
        <h2 class="header">For the month of {{$data['year']}}-{{$data['month']}}, there have been a total of {{$data['thismonth']}} views to 
           @if(isset($_GET['stories']))
            @if($_GET['stories']=='all')
                all of {{$d->penulis->username}}'s Stories
            @else
            {{$data['infotraffic']->title}}
            @endif
            @else
            {{$data['infotraffic']->title}}
            @endif
            </h2>
        <div id="chart-container">Charts will load here!</div>
        </main>
    </div>
    

</body>
<script type="text/javascript">
    FusionCharts.ready(function(){
    var fusioncharts = new FusionCharts({
    type: 'line',
    renderAt: 'chart-container',
    width: '100%',
    height: '400',
    dataFormat: 'json',
    dataSource: {
        // Chart Configuration
        "chart": {
            "xAxisName": "Timeline",
            "yAxisName": "Views",
            "numberSuffix": "",
            "theme": "fusion",
            "labelDisplay": "Auto",
            "rotateLabels":"0",
        "useEllipsesWhenOverflow":"0"
        },
        // Chart Data
        "data": [<?php
        
            if($traffic)
            {
                echo json_decode($traffic);
            }
        ?>]
        }
});
    fusioncharts.render();
    });
    $(".ui.dropdown").dropdown();
</script>
</html>