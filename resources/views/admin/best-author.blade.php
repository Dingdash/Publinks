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
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <title>Best Author</title>
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
        <div class="section">Best Author Reports</div>
    </div>
    <h1 class=""> Best Author Reports</h1>
            <!--<button id='btnprint' class='ui primary button' > Print Table </button>-->
            <a href="{{url('admin/bestauthor')}}" class='ui red button'> Clear Filter </a>

    <div class="mt-10">
            <form class="ui form" >
                        <div class="inline fields">
                            <div class="field">
                            <label>From Date</label>
                            @if(isset($_GET['from']))
                            <input  required class="p-3 shadow-outline" value="{{$_GET['from']}}" id='fromdate' type="month" name="from" placeholder="">
                            @else
                            <input required  class="p-3 shadow-outline" value="" id='fromdate' type="month"  name="from" placeholder="">
                            @endif
                            </div>
                            <div class="field">
                            <label>To Date    &nbsp;&nbsp;&nbsp;&nbsp;</label> @if(isset($_GET['to']))
                            <input  required class="p-3 shadow-outline" value="{{$_GET['to']}}" id='todate' type="month" name="to" placeholder="">
                            @else
                            <input required class="p-3 shadow-outline" id='todate' type="month" name="to" placeholder="">
                            @endif
                            </div>
                            
                            
                        </div>
                        <div  class="inline fields">
                                <div class="field">
                                        <input type="number" name="top" id="dropshow" class="bg-white mb-4 p-3"  placeholder="Show top 5 ..."/>
                                        <input class="ui green button" type="submit" value="Go">
                                </div>
                        </div>
            </form>
    </div>
    <div id="bestsellingchart" class="md:w-full sm:w-64 min-h-screen">
                    

    </div>
</main>
</body>
<script>
    $(document).ready(function(){
        $("#btnprint").click(function(){
            window.print();
        });
        var from = "<?php echo $_GET['from'] ?? '';?>";
        var to = "<?php echo $_GET['to']?? '';?>";
        var dataSource = null;
        if(from === '' && to === '')
        {
             dataSource = {
        chart: {
            caption: "Best Author This Month",
            yaxisname: "Number of Bought Products",
            aligncaptionwithcanvas: "0",
            plottooltext: "<b>$dataValue</b> bought",
            theme: "fusion",
            palettecolors:"5d62b5,29c3be,f2726f"
        },
        data: (<?php echo ($best);?>)
        };
        }else{
             dataSource = {
        chart: {
            caption: "Best Author from "+ from + " to "+ to,
            yaxisname: "Number of Bought Products",
            aligncaptionwithcanvas: "0",
            plottooltext: "<b>$dataValue</b> bought",
            theme: "fusion",
            palettecolors:"5d62b5,29c3be,f2726f"
        },
        data: (<?php echo ($best);?>)
        };
        }
                
        FusionCharts.ready(function() {
        var myChart = new FusionCharts({
            type: "bar2d",
            renderAt: "bestsellingchart",
            width: "100%",
            
            dataFormat: "json",
            dataSource: dataSource
        }).render();});
    });
</script>
</html>