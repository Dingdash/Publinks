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
    <title>Manage User</title>
</head>
<body>
@include ('admin.layout.header')


    
<div class='main-grid'>
    @include('admin.layout.aside')
            <main>
                    <div style="margin-top:20px;" class="ui breadcrumb">
                    <i class="right angle icon divider"></i>
                    <div class="section">Manage Users</div>
                    </div>
                    
                                <h1> Manage Users </h1>
                                
                                <form class="ui form">
                                        <div class="fields pb-4">
                                            <div class="field" data-tooltip="search by username or name">
                                            <input type="text" name="query" placeholder="Search Username or Name"  id=""/>
                                            
                                            </div>
                                            <div class="field">
                                                    <button type='submit' id="btnproceed" class="ui green button">Search</button>
                                            </div>
                                        </div>
                                        <div id="btnclear" class="ui red button" onclick="javascript:window.location.href='/admin/users';return false; "> Clear Filter</div>
                                    </form>
                                    @if(count($users)>0)
                                <table class="ui celled padded table">
                                    <thead>
                                        <tr>
                                            <!-- <th class="single line">USERID</th> -->
                                            <th>Username</th>
                                            <th>Name</th>
                                            <th>Registration Date</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Last Login</th> 
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>
                                                {{$user->username}}
                                            </td>
                                            <td class="single line">
                                                {{$user->name}}
                                            </td>
                                            <td>
                                           {{ date("F,d,Y", strtotime($user->created_at))}}
                                                <!-- <div class="ui large star rating" data-rating="3" data-max-rating="5"></div> -->
                                            </td>
                                            <td class="btnsend">
                                                {{$user->email}}
                                                <!--{{$user->email}}<p><a href="">send email</a></p>-->
                                            
                                            </td>
                                            @if($user->status==0)
                                            <td>Not Activated</td>
                                            @elseif($user->status<0)
                                            <td>Banned</td>
                                            @else
                                            <td>Activated</td>
                                            @endif
                                            <td>{{ date("F,d,Y", strtotime($user->last_login))}}</td>
                                            <!-- <td class="right aligned">
                                              80% <br>
                                              <a href="#">18 studies</a>
                                            </td> -->
                                            <td><a href='{{url("admin/edituser/".$user->user_id)}}'><button class="ui icon button "> <i class="cog icon"></i></button></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @if($users->hasMorePages()|| $users->nextPageurl()!=null || $users->previousPageUrl()!=null)
                                    <tfoot>
                                        <tr>
                                            <th colspan="7">
                                                <div class="ui pagination menu">
                                                {{$users->render('admin.paginator.semanticpaginator')}}
                                                    <!-- <a class="icon item">
                                                        <i class="left chevron icon"></i>
                                                    </a>
                                                    <a class="item">1</a>
                                                    <a class="item">2</a>
                                                    <a class="item">3</a>
                                                    <a class="item">4</a>
                                                    <a class="icon item">
                                                        <i class="right chevron icon"></i>
                                                    </a> -->
                                                </div>
                                            </th>
                                        </tr>
                                    </tfoot>
                                    @endif
                                </table>
                            </main>
</div>
@endif
<form id='email-form' action="{{url('sendemail')}}" method = "POST" class="ui modal form">
    {{csrf_field()}}
    <div class="header">Send Email</div>
    <div class="content">
    <p>Email Recipient : <button id='email' class="ui class grey button" disabled></button></p>
    <input id="valueemail" type = "hidden" name  = "email"/>
    Subject:
    <p></p>
    <p><input  placeholder="subject" name = "subject" type="text"></p>
    <p><textarea name='message' placeholder="message"></textarea>
    </p>
    </div>
    <div class="actions">
    <div id="cancelemail" class="ui cancel button">Cancel</div>
    <div id="btnsubmit" class="ui primary button" onclick="sendemail()">Send</div>
    </div>
</form>
</body>
<script>
    $('.ui.modal').modal();
    function sendemail()
    {
        var email = $('.ui.modal').find('#valueemail').val();
        var subject = $('.ui.modal').find("input[name='subject']").val();
        var message = $('.ui.modal').find("textarea[name='message']").val();
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('sendemail') }}",
                method: 'post',
                data: {
                    email: email,
                    subject: subject,
                    message: message
                },
                success: function(result){
                    alert(result.success);
                }});
    }
    $('.btnsend').find('a').click(function(e){
        var email = $(this).parent().parent().get(0).firstChild.nodeValue;
        
        $('.ui.modal').find('#email').html(email);
        $('.ui.modal').find('#valueemail').val(email);
        
        e.preventDefault();
        $('.ui.modal').modal('show');
    });
    $("#cancelemail").click(function(){
        $('input').val("");
        $('textarea').val("");
    });
    
</script>
</html>