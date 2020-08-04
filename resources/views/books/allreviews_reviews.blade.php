@if(count($reviews)>0)
    @foreach($reviews as $r)
    <div class="single-content shadow-sm bg-white">
            <div class="content">
                    @if($r->reviewer['profpic'])
                    <img src="/storage/{{$r->reviewer->profpic}}" alt="Smiley face" height="60" width="60">
                    
                    @else
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNet1sAwGFVjUIztYvi3qIZhxb7sKR_Kp7KcmJ4hhH6xYdDlgE" alt="Smiley face" height="60" width="60">
                    @endif
            
            <div class="isi">
                <div class='meta-info'>{{$r->reviewer['name']}} rated  @if($r->reply!=null)<button href="#" class='editbutton'> Edit</button>@endif
                    <div style="width:auto;" class=" pl-2"  >
                        <?php 
                            if($r->score->score !=null)
                            {
                                $score = $r->score->score;
                            }else {
                                $score = 0;
                            }
                            ?>
                        @for($i=0;$i <5; $i++)
                            @if($i<($score))
                        <i class="ui fullstar icon star" data-star=""></i>
                        @else
                        <i class="ui greystar icon star" data-star=""></i>
                        @endif
                        @endfor
                    </div> 
                </div>
                <div class="mb-4"></div>
                <div style="text-align:justify;">{{$r->content}}</div>
                @if($r->replier_id==null)
                <form method="POST" class="ui reply form mt-5">
                        <div  class="field">
                        <input type="hidden" name="reviewid" value="{{$r->review_id}}">
                        <input type="hidden" name="author" value={{Session::get('user')->user_id}}>
                        <input placeholder="give respond ..." name="reply" type="text"/>
                        </div>
                        <button class="respondbutton ui blue labeled submit icon button">
                        <i class="icon edit"></i>Respond
                        </button>
                    </form>
                @else
                <form style="display:none;" method="POST" class="ui reply form mt-5">
                        <div  class="field">
                        <input type="hidden" name="reviewid" value="{{$r->review_id}}">
                        <input type="hidden" name="author" value={{Session::get('user')->user_id}}>
                        <input placeholder="give respond ..." name="reply" type="text"/>
                        </div>
                        <button class="respondbutton ui blue labeled submit icon button">
                        <i class="icon edit"></i>Respond
                        </button>
                    </form>
                @endif
                  <div style="display:flex;justify-content:flex-end;">
                    <a class="ui icon button" data-tooltip="Report this Review" href="/flagreview/{{$r->review_id}}"> <i class="flag icon"></i></a>
                </div> 
            </div>
            </div>
            @if($r->replier_id !=null)
            <div class="comment-row shadow-md bg-white-dark ">
                <div class="ml-10">
                        <div >{{$r->replier->name}}</div>
                        <div class="ui label grey">Author</div>
                        <div class="mt-4">
                        </div>
                        <div style="text-align:justify;">{{$r->reply}}</div>
                </div>
            </div>
            @else
            @endif
    </div>
    @endforeach
</div>
@else
    <div style="text-align:center;" class='text-xl noreview pb-8'>
    This Book has no reviews.
    </div>
@endif