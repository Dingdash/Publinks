<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel = "stylesheet" href="{{asset('css/cart.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <!-- tailwindcss !-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Cart</title>
    
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')

            <div class="container mt-4">
                <div class="ui centered header">
                  Your Shopping Cart
                </div>
                @if(count($cart)==0)
                <div style="max-width:800px;" class='ui centered mx-auto'>
                        <div style='text-align:center;' class="ui placeholder segment">
                                <h1>Your shopping cart is empty!</h1>
                        </div>
                        
                    </div>
                @else
                <div style="max-width: 840px;
  background: #F9FAFB;
  border-color: rgba(34, 36, 38, 0.15);
  -webkit-box-shadow: 0px 2px 25px 0 rgba(34, 36, 38, 0.05) inset;
          box-shadow: 0px 2px 25px 0 rgba(34, 36, 38, 0.05) inset;              
  padding: 1em 1em;
  border-radius: 0.28571429rem;
  " class="outer-grid ui centered mx-auto">
                    
                   <div class="header-grid">
                       <div class="text-xl grid-col">
                           <div class="text-left item-label">Items({{count($cart)}})</div>
                           
                           <div class='text-right'>Price in IDR</div>
                          
                       </div>
                      
                   </div>
                   <div class="content-grid">
                        <?php $total = 0;
                        ?>
                       @foreach($cart as $c)
                       
                        {{-- <div class="grid-col">
                                <div><img class='imgcart' src="https://d2sofvawe08yqg.cloudfront.net/composingsoftware/small2x?1550973563" alt=""></div>
                                <div>tes</div>
                                <div class='text-right'>{{$c->price}}</div>
                            </div> --}}
                        <?php $total += $c->price;?>
                            <div class="grid-col itemcart">
                                    <div><img class='imgcart' @if($c->buku->cover==null) src="https://cdn11.bigcommerce.com/s-gho61/stencil/31cc7cb0-5035-0136-2287-0242ac11001b/e/3dad8ea0-5035-0136-cda0-0242ac110004/images/no-image.svg" @else src="/storage/{{$c->buku->cover}}" @endif alt=""></div>
                                    <div class="grid-button">
                                        <div class="judul-buku">{{$c->buku->title}}
                                         
                                        </div>
                                        <div class="penulis">By {{$c->buku->penulis->name}}</div>
                                        
                                        <div class='btnremove'>
                                            
                                            {{-- <button onclick="window.location.href='/cart/delete/{{$c->id}}'" class="ui button red">Remove from cart</button> --}}
                                        <form action="{{url('/cart/delete/'.$c->id)}}" method="POST">
                                            {{csrf_field()}}
                                            
                                            <button class = 'ui button red' type="submit">Remove from cart</button></form>
                                        </div>
                                    </div>
                                    @if($c->price>0)

                                    <div class='text-right'>{{number_format($c->price,0,',','.')}}</div>
                                    @else
                                        <div class="text-right">Free</div>
                                    @endif
                                </div>
                                
                                @endforeach
                   </div>
                   
                   <div class="footer-grid">
                                <div class='text-right text-xl'>IDR {{number_format($total,0,',','.')}}</div>
                    </div>
                    @if($total!=0)
                    <div class='checkout'>
                            <button onclick="window.location.href='/checkout'" class="ui button green">Checkout</button>
                    </div>
                    @else
                    <div class='checkout'>
                            <button onclick="window.location.href='/checkout/pay'" class="ui button green">Pay Now</button>
                    </div>
                    @endif
                </div>
                @endif
               
        </div>
</body>
</html>