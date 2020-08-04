<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <!-- tailwindcss !-->
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <meta name="_token" content="{{csrf_token()}}" />
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <title>View Traffics</title>
    @include('layouts.navbarcss')
    <style>
        #chart-container{
            width: 100%;
        }
    </style>
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
<div class="ui container">
    <div class="mt-4"></div>
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
            <h2 class="header">For the month of {{$data['year']}}-{{$data['month']}}, there have been a total of {{$data['thismonth']}} views to <?php if(isset($_GET['stories'])){
                if($_GET['stories']=='all')
                {
                    echo'all of your stories';
                }else {
                    
                    echo $data['infotraffic']->title;
                }
                }else{echo'all of your stories';};?> </h2>
            <div id="chart-container">Charts will load here!</div>
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