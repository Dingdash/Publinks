
<div class="ui huge inverted menu">
            @if(session('user'))
            <a class="item" href="{{url('/browse')}}">
                Publink
            </a>
            @else
            Publink
            @endif
            <div class="right menu">
                    @if(session('user'))
                    <a class="item" href="{{url('/createmenu')}}">
                        Make a story
                    </a>
                    <a class="item"href="{{url('/wishlist')}}">
                        Wishlist
                    </a>
                    <a class="item" href="{{url('/cart')}}" >
                        Cart
                    </a>
                    <div class="item">
                      <div class="iconotif">
                          <i class="bell outline icon "></i>
                          <div class="ui teal circular mini label" id="countnotif" >4</div>
                      </div>
                      <div class="ui wide notification popup bottom right transition ">
                        <div class="ui segment" style="width:400px; height:auto;">
                          <div class="flex justify-between ">
                            <div>Notifications   </div>
                              {{-- <a href="http://" class="text-teal hover:text-teal-700">Mark all as Read</a>  --}}
                            </div>  
                            <div class="mb-2">
                            </div>
                              {{-- <div class="notificationsitem">
                                  <div class="ui celled list">
                                      <div class='item'>
                                      <div class='content'>
                                        <a class='text-teal'>Millan kumar</a>
                                        <div class='description'>2 hrs ago</div>          
                                        <div class='description'>Someone just bought your product</div>
                                      </div>
                                    </div>
                                  </div>
                              </div> --}}
                              <div class="notificationbottom text-center mt-2" style="width:100%;">
                                  <a class="text-teal" href="<?php echo url('notifications');?>" > See All Notifications</a>
                              </div>
                        </div>  
                    </div>
                  </div>
                    <div class="ui dropdown item">
                            {{session('user')->name}}
                            <i class="dropdown icon"></i>
                            <div class="menu">
                                    <a href="{{url('editprofile')}}" class="item">Edit Profile</a>
                                    <a href="{{url('library')}}" class="item">Library</a>
                                    <a class='item' href="{{url('/authorstory')}}">
                                      Your Stories
                                  </a>
                                    <a href="{{url('u/'.Session::get('user')->user_id)}}" class='item'> View Profile</a>
                                    <a href="{{url('transhistory')}}" class="item">Transaction History</a>
                                    <a style="width:100%;" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color:black;" class="item">Log Out</a>
                                    <form style="display:none;" id="logout-form" class="item" method='post' action="{{url('/logout')}}">
                                      {{csrf_field()}}    
                                    </form>
                            </div>
                          </div>
                  @else
                  <a class="item" href="<?php echo url('login');?>"  rel="noopener noreferrer">Login</a>
                  <a class="item" href="<?php echo url('register');?>"  rel="noopener noreferrer">Sign Up</a>
                  @endif
            </div>
          </div>
          <script>
            
              $('.ui.dropdown').dropdown();
          $('#countnotif').hide();
          $('.iconotif').popup({on: 'click'});
        //   
          $.ajax({
            type : 'get',
            url : "<?php echo url('/unreadnotif');?>",
            success: function(data){
            console.log(data);
            if(data>0)
            {
            $("#countnotif").show();
            $("#countnotif").html(data);
            }else{
            $("#countnotif").hide();  
            }
            }
          });
          setInterval(function(){
            $.ajax({
            type : 'get',
            url : "<?php echo url('/unreadnotif');?>",
            success: function(data){
            console.log(data);
            if(data>0)
            {
            $("#countnotif").show();
            $("#countnotif").html(data);
            }else{
            $("#countnotif").hide();
            }
            }
          });
          },10000  );
            
        
</script>
