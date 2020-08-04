@if(count($reviews)>0)
@foreach($reviews as $r)
<div class="single-content">
        <div class="content">
                @if($r->reviewer['profpic'])
                <img src="/storage/{{$r->reviewer->profpic }}" alt="Smiley face" height="75" width="60">
                @else
                <img src="/storage/default/default-avatar.png" alt="Smiley face" height="60" width="60">
                @endif
        <div class="isi">
            <div class='meta-info'>{{$r->reviewer['name']}} rated 
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
            {{-- <form class="ui reply form mt-5">
                <div  class="field">
                <input placeholder="give respond ..." type="text"/>
                </div>
                <div class="ui blue labeled submit icon button">
                <i class="icon edit"></i>Respond
                </div>
            </form> --}}
        </div>
        </div>
        @if($r->replier_id !=null)
        <div class="comment-row mt-4">
            <div class="ml-10">
                    <div >{{$r->replier->name}}</div>
                    <div class="ui label grey">Author</div>
                    <div class="mt-4">
                    </div>
                    <div style="text-align:justify;">{{$r->reply}}</div>
                    <div style="display:flex;justify-content:flex-end;">
                    <a class="ui icon button" data-tooltip="Report this Review" href="/flagreview/{{$r->review_id}}"> <i class="flag icon"></i></a>
                    </div> 
            </div>
        </div>
        @endif
</div>
@endforeach
</div>
@else
<div style="text-align:center;" class='text-xl noreview pb-8'>
This Book has no reviews.
</div>
@endif                  