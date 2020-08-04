<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/admin/manageusers.css')}}">
    <link rel="stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Dashboard</title>
</head>
<body>
    @include ('admin.layout.header')
    <div class="main-grid">
        @include('admin.layout.aside')
        <main>
            <div style="margin-top:20px;" class="ui breadcrumb">
                <i class="right angle icon divider"></i>
                <div class="active section">Dashboard</div>
            </div>
            <h1 class="px-4"> Dashboard </h1>
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
           
            <div class="ui stackable grid sm:center three statistics">
                <div class="statistic">
                    <div class="value">
                        <i class="icon user"> 
                        </i>
                        {{$usercount}}
                    </div>
                    <div class="label">Registered Users</div>
                </div>
                <div class="statistic">
                        <div class="value">
                            <i class="icon book"> 
                            </i>
                            {{$bookcount}}
                        </div>
                        <div class="label">Product Items</div>
                    </div>
                    <div class="statistic">
                        <div class="value">
                            <i class="icon money">
                            </i>
                            {{$transactioncount}}
                        </div>
                        <div class="label">Transactions</div>
                    </div>
            </div>
            <div class="ui stackable grid">
                <div class="eight wide column">
                        <div class="text-3xl mb-4 text-center">
                            Best Selling Product this month    
                        </div>
                        <select id="dropshow" class="bg-white mb-4">
                                <option value>Show </option>
                                @for($i=10;$i>0;$i-=5)
                                <option value="{{$i}}">Top {{$i}} </option>
                                @endfor
                        </select>
                        <div id="bestsellingchart" class=" sm:w-full">
                        </div>
                </div>
                <div class="eight wide column">
                    <div class="text-3xl mb-4 text-center">
                        New Registered User
                    </div>
                    <table class="ui celled table">
                        <thead>
                            <tr><th>Username</th><th>Name</th><th>Registration Date</th> </tr>
                        </thead>
                        <tbody>
                            @foreach($lastuser as $u)
                            <tr>
                            <td ><a data-tooltip="click here to edit user" href="{{url('admin/edituser').'/'.$u->user_id}}">{{$u->username}}</a></td><td>{{$u->name}}</td><td>{{$u->created_at}}</td>
                            <tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
           
        </main>
    </div>
</body>
<script>
    $('.ui.dropdown')
        .dropdown();
       let jsondata;
        
        function bestselling(show,m=null,y=null)
        {
            var s = show;
            if(show!=null)
            {
                s = show;
                
            }
            var url = "<?php echo url('getbest?');?>"+"S="+s+"&M="+m;
            if(m==null)
            {url = "<?php echo url('getbest');?>";
            
            }
            
            
            
          fetch(url).then(
              
        function(u){ 
           
            return u.json();}
      ).then(
        function(json){
          jsondata = json;
          const dataSource = {
  chart: {
    caption: "Best Selling Product This Month",
    yaxisname: "Number of Buys",
    aligncaptionwithcanvas: "0",
    plottooltext: "<b>$dataValue</b> purchases",
    theme: "fusion",
    palettecolors:"5d62b5,29c3be,f2726f"
  },
  data: (jsondata)
};
FusionCharts.ready(function() {
  var myChart = new FusionCharts({
    type: "line",
    renderAt: "bestsellingchart",
    width: "100%",
    labelDisplay:"rotate",
    dataFormat: "json",
    dataSource: dataSource
  }).render();
});
        }
      )
            
        }
        bestselling(5,null,'');
            
        
        
       $('#dropshow').change(function(){
            var show = $(this).val();
            if(show !='')
            {
                bestselling(show,'','');
            }
       });
        


</script>

</html>