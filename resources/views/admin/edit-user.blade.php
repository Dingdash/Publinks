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
    <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    
    <title>Edit User</title>
</head>
<body>
        @include ('admin.layout.header')
    <div class="main-grid">
        @include('admin.layout.aside')
        <main>
            <div style="margin-top:20px;" class="ui breadcrumb">
                <i class="right angle icon divider"></i>
                <div class="section"><a href="{{url('admin/users')}}">Manage Users</a></div>
                <i class="right angle icon divider"></i>
                <div class="active section">Edit User</div>
            </div>
            <h1> Edit User </h1>
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
            <div class="ui two column stackable grid">
                <div class="column">
                    <div class="ui small form raised segment">
                        <form method="POST" action="" style="padding:0px;margin:0px;display:inline;">
                            {{csrf_field()}}
                            <div class="two fields">
                                <div class="nine wide field">
                                    <label>Email</label>
                                    <button name="email" class="ui class grey button" disabled value="<?php echo $user->email;?>"><?php echo $user->email;?></button>
                                    <input name="uID" type="hidden" value="{{$user->user_id}}">
                                </div>
                                <div class="nine wide field">
                                    <label>Username</label>
                                    <input type="text" name="username" value="<?php echo $user->username; ?>">
                                </div>
                            </div>
                            <div class="nine wide field">
                                <label>Name</label>
                                <input value="<?php echo $user->name; ?>" type="text" name="name" placeholder="Name">
                            </div>
                            <div class="field">
                                <label>Status :
                                    @if($user->status>0)
                                    Activated
                                    @elseif($user->status==0)
                                    Not Activated
                                    @else
                                    Banned
                                    @endif
                                </label>
                            </div>
                            <div class="ui buttons">
                                <a href='' class="ui button">Cancel</a>
                                <div class="or"></div>
                                <input type='submit' name='saveedituser' value='Save' class="ui blue button"/>
                            </div>
                        </form>
                        <form method="POST" action="" style="all:unset;">
                            {{csrf_field()}}
                            <input name="uID" type="hidden" value="{{$user->user_id}}">
                            <div class="ui pull right floated buttons">
                                @if($user->status>0)
                                <input name='ban' type='submit' class="ui red button" value='Ban'>
                                @else
                                <input name='unban' type='submit' class="ui green button" value='Unban'>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
                <div class="column">
                    <!-- <form class="ui small form raised segment">
                        <img class="ui small circular image"
                            src="https://cdn4.iconfinder.com/data/icons/avatars-21/512/avatar-circle-human-male-3-512.png">
                        <div style="margin-top: 15px;"> 
                            <label for="file" class="ui icon button">
                                <i class="file icon"></i>
                                Change Avatar</label>
                            <input type="file" id="file" style="display:none">
                            <button class="ui red icon button"><i class="remove icon"></i>Remove Avatar</button>
                        </div>
                        <div style="margin-top: 5px;" class="ui buttons">
                        
                        <button class="ui button"> Cancel</button>
                        <div class="or"></div>
                        <button class="ui blue button">Save</button>
                        </div>
                    </form> -->
                </div>
            </div>
        </main>
    </div>
</body>
<script>
    $('.ui.dropdown')
        .dropdown();
</script>

</html>