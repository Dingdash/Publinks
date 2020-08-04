<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <link rel = "stylesheet" href="{{asset('css/checkout.css')}}">
    <!-- tailwindcss !-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <script src="https://js.xendit.co/v1/xendit.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Publink</title>
    @include('layouts.navbarcss')
</head>
<style>
    .overlay {
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
                background-color: rgba(0,0,0,0.5);
                z-index: 10;
            }

    #three-ds-container {
                width: 550px;
                height: 450px;
                line-height: 200px;
                position: fixed;
                top: 25%;
                left: 40%;
                margin-top: -100px;
                margin-left: -150px;
                background-color: #ffffff;
                border-radius: 5px;
                text-align: center;
                z-index: 11; /* 1px higher than the overlay layer */
            }
</style>
<script>Xendit.setPublishableKey('xnd_public_development_O4CAfL8k0LSqkcU7KBPSWOSMNTx9NN6l3fpRxnm3UrWhDA51jg');</script>
<script>
    
        $(function () {

            function getTokenData () {
                
                return {
                    amount: $("#total").val(),
                    card_number: $("#card-number").val(),
                    card_exp_month: $("#card-exp-month").val(),
                    card_exp_year: $("#card-exp-year").val(),
                    card_cvn: "123",
                    is_multiple_use: false,
                    should_authenticate:  true
                };
            }
            
            $('#fake').click(function(){
                $('#pay').click();
            });
            var shouldEnableMeta = false;
            var $form = $('#payment-form');
            $form.submit(function (event) {
                Xendit.setPublishableKey("xnd_public_development_O4CAfL8k0LSqkcU7KBPSWOSMNTx9NN6l3fpRxnm3UrWhDA51jg");
        
                // Disable the submit button to prevent repeated clicks:
                $form.find('#fake').prop('disabled', true);
        
                // Request a token from Xendit:
                var tokenData = getTokenData();
                
                Xendit.card.createToken(tokenData, xenditResponseHandler);
        
                // Prevent the form from being submitted:
                return false;
            });
        
            $('#bundle-authentication').change(function() {
                if(this.checked) {
                    $('#card-cvn').val('');
                }
            });
        
            function xenditResponseHandler (err, creditCardCharge) {
                $form.find('.submit').prop('disabled', false);
                
        
                if (err) {
                    alert(err.message);
                    return displayError(err);
                }
                
        
                if (creditCardCharge.status === 'APPROVED' || creditCardCharge.status === 'VERIFIED') {
                    ;
                    sendToken(creditCardCharge.id,$("#total").val());
                    
                    
                } else if (creditCardCharge.status === 'IN_REVIEW') {
                    
                    window.open(creditCardCharge.payer_authentication_url, 'sample-inline-frame');
                    
                    $('.overlay').show();
                    $('#three-ds-container').show();
                } else if (creditCardCharge.status === 'FRAUD') {
                    
                    displayError(creditCardCharge);
                    $('.overlay').hide();
                    $('#three-ds-container').hide();
                } else if (creditCardCharge.status === 'FAILED') {
                    
                    displayError(creditCardCharge);
                }
            }
        
            function displayError (err) {
                $('#three-ds-container').hide();
                $('.overlay').hide();
                var response = JSON.parse(err);
                $('#error .result').text(JSON.stringify(err, null, 4));
                $('#error').show();
                    // console.log(err);
                var requestData = {};
                $.extend(requestData, getTokenData(), getFraudData());
                if (shouldEnableMeta) {
                    requestData["meta_enabled"] = true;
                } else {
                    requestData["meta_enabled"] = false;
                }
                // $('#error .request-data').text(JSON.stringify(requestData, null, 4));
            };
            function displaySuccess (creditCardCharge) {
                $('#three-ds-container').hide();
                $('.overlay').hide();
                $('#success .result').text(JSON.stringify(creditCardCharge, null, 4));
                $('#success').show();
                
                // alert(creditCardCharge.authentication_id);
                
                var requestData = {};
                $.extend(requestData, getTokenData(), getFraudData());
                if (shouldEnableMeta) {
                    requestData["meta_enabled"] = true;
                } else {
                    requestData["meta_enabled"] = false;
                }
                $('#success .request-data').text(JSON.stringify(requestData, null, 4));
        
            }
            function getFraudData () {
                return null;
            }
            function hideResults() {
                $('#success').hide();
                $('#error').hide();
            }
            function savetrans(amount,extid)
            {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                $.ajax({
                type:'POST',
                url:'/savetrans',
                data:{q:amount, id:extid},
                success:function(data){
                    $('#three-ds-container').hide();
                     window.location="/browse";
                    // alert(data);
                    // alert('success');
                        
                    }
                });
            }
            function sendToken(tokenid,amount)
            {
                console.log(tokenid,amount);
                     $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    });
                $.ajax({
                type:'POST',
                url:'/bayar',
                data:{amount:amount, token_id:tokenid},
                success:function(data){
                    var json = JSON.parse(data);
                    console.log(json);
                    console.log(json.status);
                        if(json.status=="CAPTURED")
                        {
                            $('#three-ds-container').hide();
                            savetrans(amount,json.external_id);
                            alert('payment successful');
                            //  window.location="/browse";
                           
                        }else{
                            alert('payment unsuccessful there was an error');
                            window.location.reload();
                           
                        }
                    }
                });

                
            }
           
        });
        
        </script>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
            <div class='grid-info'>
                <form id="payment-form" method="POST" class="ui form" action="javascript:void(0);">
                    <h4 class="ui dividing header">Card Info</h4>
                    <div class="two fields">
                        <div class="field">
                            <input type="text" name="shipping[first-name]" placeholder="First Name">
                        </div>
                        <div class="field">
                            <input type="text" name="shipping[last-name]" placeholder="Last Name">
                        </div>
                    </div>
                    <div class="fields">
                        <div class="seven wide field">
                            <label>Card Number</label>
                            <input id='card-number' type="text" name="card[number]" maxlength="16" placeholder="Card #">
                        </div>
                        <div class="seven wide field">
                            <label>Card Number</label>
                            <input id='' type="text" name="tes" maxlength="16" placeholder="Card #" value="4000000000000002">
                        </div>
                        <div class="three wide field">
                            <label>CVC</label>
                            <input id='card-cvn' type="text" name="card[cvc]" maxlength="3" placeholder="CVC">
                        </div>
                        <div class="six wide field">
                            <label>Expiration</label>
                            <div class="two fields">
                                <div class="field">
                                    <select id='card-exp-month' class="ui fluid search dropdown" name="card[expire-month]">
                                        <option value="">Month</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <input type="text" id='card-exp-year' name="card[expire-year]" maxlength="4" placeholder="Year">
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="fields">
                        <div class="six wide field">
                                You can go back and<a href="{{url('/cart')}}" class="link"> edit your cart. </a>
                        </div>
                        <div style='float:left; display:none;' class='three wide field right floated'>
                            <button id='pay' class="submit ui blue button" type="submit">Pay Now</button>
                        </div>
                    </div>
                   
                </form>
            </div>

            <div class="ui centered header">
                   Summary
                  </div>
            @if(count($cart)==0)
            <div style="max-width:800px;" class='ui centered mx-auto'>
                    <div style='text-align:center;' class="ui placeholder segment">
                            <h1>Your shopping cart is empty!</h1>
                    </div>
                    
                </div>
            @else
            <div style="max-width: 840px;" class="outer-grid ui centered mx-auto">
                
               <div class="header-grid">
                   <div class="text-xl grid-col">
                       <div class="">Items({{count($cart)}})</div>
                       <div></div>
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
                        <div class="grid-col">
                                <div></div>
                                <div class="grid-button"><div><p> {{$c->buku->title}} By {{$c->buku->penulis->name}}</p>
                                    
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
                    
                    <div class="grid-col">
                            <div></div>
                            <div></div>

                            <div class='text-right text-xl'>IDR {{number_format($total,0,',','.')}}</div>
                            <input id="total" type="hidden" name="amount" value="{{$total}}">
                        </div>
                </div>
                <div  style='float:left;' class='three wide field right floated'>
                        <button id='fake'  class="submit ui blue button" type="submit">Pay Now</button>
                </div>
                
            </div>
            @endif


            <div class='overlay' style='display:none;'>
            </div>
            <div id="three-ds-container" style="display:none;">
                    <iframe height="450" width="550" id="sample-inline-frame" name="sample-inline-frame"> </iframe>
                </div>
                <div id="success" style="display:none;">
                        <p>Success! Use the token id below to charge the credit card.</p>
                        <div class="request">
                            <span>REQUEST DATA</span>
                            <pre class="request-data"></pre>
                        </div>
                        <span>RESPONSE</span>
                        <pre class="result"></pre>
                    </div>
        
                    <div id="error" style="display:none;">
                        <p>Whoops! There was an error while processing your request.</p>
                        <div class="request">
                            <span>REQUEST DATA</span>
                            <pre class="request-data"></pre>
                        </div>
                        <span>RESPONSE</span>
                        <pre class="result"></pre>
                    </div>
            


</body>

</html>