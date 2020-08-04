<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Publink</title>
    <style>
        .grid-items{
            display:grid;
            grid-template-columns: 1fr fit-content(300px);
            align-items: center;
            row-gap: 10px;
        }
        .right-items{
            place-items: center;
        }
    </style>
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
<div class="mt-8"></div>
<div class="ui container">
        <h1 class="ui header">
                Transaction History
        </h1>
</div>
<div class="mt-4"></div>
<div class="ui stackable grid container">
    <div class="ten wide column mx-auto">
      @foreach($transdata as $t)
        <div  class="ui card fluid">
          <div class="content">
            <div class="header">Transaction ID : {{$t->transaction_id}} </div>
            <div class="summary">{{$t->created_at}}</div>
          </div>
          <div class="content">
            <h4 class="ui sub header">Items</h4>
            <div class="grid-items">
                @foreach ($t->details as $d)
                  <div class="left-item">{{$d->product_item}} </div>
                  <div style="max-height:25px;" class="right-item ui label black">IDR {{number_format($d->price,0,',','.')}}</div>
                  @endforeach
            </div>
          </div>
          <div class="extra content">
            <div class="label ui black">Total : IDR {{number_format($t->total,0,',','.')}}</div>
          </div>
        </div>
      @endforeach
    </div>
</div>
</body>
</html>