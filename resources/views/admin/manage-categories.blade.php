<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{csrf_token()}}" />
    <link rel="stylesheet" href="{{asset('css/admin/manageusers.css')}}">
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Admin</title>
</head>
<body>
@include ('admin.layout.header')
@if(count($categories)>0)

    
<div class='main-grid'>
    @include('admin.layout.aside')
            <main>
                    <div style="margin-top:20px;" class="ui breadcrumb">
                    <i class="right angle icon divider"></i>
                    
                    <div class="section">Manage Categories</div>
                    </div>
                                <h1> Manage Categories </h1>
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
                                        <div style="max-width:500px" class="ui small form segment">
                                                <h4 class="ui dividing header">Add new Category</h4>
                                        <form method="POST" action="{{url('/admin/category/add')}}">
                                                {{csrf_field()}}
                                                <div class="field">
                                                        <input class="" type="text" name="category" placeholder="insert new category here" required/>
                                                </div>
                                            
                                            <input class="ui green button" type="submit" value="Add">
                                        </form>
                                    </div>
                                <table class="ui celled padded table">
                                    <thead>
                                        <tr>
                                            <!-- <th class="single line">USERID</th> -->
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                            <th>Last Updated</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $cat)
                                        <tr>
                                            <td>
                                                {{$cat->category_id}}
                                            </td>
                                            <td class="single line">
                                                {{$cat->category_name}}
                                            </td>
                                            <td>
                                                <a href="{{url("/admin/editcategories/".$cat->category_id)}}" class="ui button"> <i class="icon edit"></i>Edit</a>
                                                <a href="{{url("/admin/category/delete/".$cat->category_id)}}" class="ui negative button">Delete</a>
                                            </td>
                                            <td>
                                        {{ date(" d:m, F d Y", strtotime($cat->updated_at))}}
                                                <!-- <div class="ui large star rating" data-rating="3" data-max-rating="5"></div> -->
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @if($categories->hasMorePages()|| $categories->nextPageurl()!=null || $categories->previousPageUrl()!=null)
                                    <tfoot>
                                        <tr>
                                            <th colspan="7">
                                                <div class="ui pagination menu">
                                                {{$categories->render('admin.paginator.semanticpaginator')}}
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