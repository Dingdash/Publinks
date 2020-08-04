<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="_token" content="{{csrf_token()}}" />
        <link rel="stylesheet" href="{{asset('css/dist/min.css')}}">
        <link rel="stylesheet" href="{{asset('css/admin/manageusers.css')}}">
        <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
        <title>Transaction</title>
        <style>
        @media print
        {
        body * { display: none; }
        .notprint,.notprint *{display: none;}
        table * { visibility: visible; }
        table { position: absolute; top: 60px; left: 0px; }
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
                    <div class="section">Transaction Reports</div>
                    </div>
                    <h1 id='print'> Transaction Reports </h1>
                    <div class="ui form">
                        <div class="fields pb-4">
                            <div class="field">
                            <label>From Date</label>
                            @if(isset($_GET['fromto']))
                            <input value="{{$_GET['fromto']}}" id='fromdate' type="date" placeholder="">
                            @else
                            <input value="" id='fromdate' type="date" placeholder="">
                            @endif
                            </div>
                            <div class="field">
                            <label>To Date</label> @if(isset($_GET['todate']))
                            <input value="{{$_GET['todate']}}" id='todate' type="date" placeholder="">
                            @else
                            <input id='todate' type="date" placeholder="">
                            @endif
                            </div>
                        </div>
                        <div id="btnproceed" class="ui primary button">Proceed</div>
                        <div id="btnclear" class="ui red button">Clear Filter</div>
                    </div>
                    @if($trans->count()>0)
                    @if(isset($_GET['transid']))
                    <h1> Transaction ID: <?php echo $_GET['transid'];?> </h1>
                    <table class="ui celled table">
                        <thead>
                            <tr>
                                <!-- <th class="single line">USERID</th> -->
                                <th>Product_id</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Transaction_Date</th> 
                                @if(isset($_GET['transid'])) @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trans as $t)
                                @foreach($t->details as $t)
                            <tr>
                            
                            <td>{{$t->book_id}}</td>
                            <td> {{$t->product_item}}
                                <td>IDR {{number_format($t->price,0,',','.')}}</td>
                            <td>{{$t->created_at}}</td>
                            @if(isset($_GET['transid'])) @else
                            <td>
                                <a href={{url('/admin/transactions?transid='.$t->transaction_id)}}>View Details</a>
                            </td>
                            @endif
                            </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                    @else   
                    <table class="ui celled striped table">
                        <thead>
                            <tr>
                                <!-- <th class="single line">USERID</th> -->
                                <th>Transaction_id</th>
                                <th>Total</th>
                                <th>Transaction_Date</th> 
                                <th>Actions</th>
                            </tr>
                        </thead>
                            <tbody>
                                @foreach($trans as $t)
                                <tr>   
                                    <td>{{$t->transaction_id}}</td>
                                    <td>IDR {{number_format($t->total,0,',','.')}}</td>
                                    <td>{{$t->created_at}}</td>
                                    <td>
                                        <a href={{url('/admin/transactions?transid='.$t->transaction_id)}}>View Details</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            @if($trans->hasMorePages()|| $trans->nextPageurl()!=null || $trans->previousPageUrl()!=null)
                            <tfoot>
                                <tr>
                                    <th colspan="7">
                                        <div class="ui pagination menu">
                                        {{$trans->render('admin.paginator.semanticpaginator')}}
                                        </div>
                                    </th>
                                </tr>
                            </tfoot>
                            @else
                            <tfoot>
                                <tr><th colspan="7"></th></tr>
                            </tfoot>
                            @endif
                        </table>
                        @endif
                    @endif
            </main>
    </div>
</body>
    <script>
        $("#btnproceed").click(function(){
            fromdate = ($('#fromdate').val());
            todate=($('#todate').val());
            url = "{{ url('/admin/transactions') }}"+'?fromto='+fromdate+'&todate='+todate;
            window.location.href=url;
        });
        $("#btnclear").click(function(){
            fromdate = ($('#fromdate').val());
            todate=($('#todate').val());
            url = "{{ url('/admin/transactions') }}";
            window.location.href=url;
        });
        
    </script>
    