<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- tailwindcss !-->
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <!-- tailwindcss !-->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Publink</title>
    
    
    <style>
        #content>p{
          
          
        }
        #content{
         
        }
        #chapter-title{
          white-space: nowrap;
        }
        .savemenubutton{
    
        }
        #content>p{
          
        }
        h2{
    
    }
    
      </style>
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')

            <div class="mt-8">
              
            </div>
            <div class="container">
                {{-- <h1 class="ui centered header">
                  Title Chapter
                </h1> --}}
                <div  style="text-align:center; max-width: 60%; height:100%; overflow:auto; " class="ui mt-8 centered mx-auto" style="resize:vertical" >
                    @if(session('success'))
        <div class="ui icon success message ">
            <i class="info icon"></i>
            <div class="content">
                <div class="header">
                   Save Success
                </div>
                <p>{{session('success')}}</p>
            </div>
        </div>
        @endif
                 </div>
                 <div class="mt-8"></div>
               <input id="chapterid" type="hidden" name="chapterid" value="{{$chapter}}"/>
                <div class='ui center aligned container'>
                    
                    <div class="ui compact menu">
                        <button id='italic-button' class="item">
                          <i class="italic icon"></i>
                        </button>
                        <button id='bold-button' class="item">
                          <i class="bold icon"></i>
                        </button>
                        <button id='under-button' class="item">
                            <i class="underline icon"></i>
                          </button>
                        <button id="left-icon" class="item">
                            <i class='align left icon'></i>
                          </button>
                        <button id="center-icon" class="item">
                          <i class='align center icon'></i>
                        </button>
                        <button id="right-icon" class="item">
                            <i class='align right icon'></i>
                          </button>
                          <button id="justify-icon" class="item">
                              <i class='align justify icon'></i>
                            </button>
                        
                        <button  id='header-button' class="item">
                          <i class="header icon"></i>
                        </button>
                        <button id='orderedlist-button' class="item">
                            <i class="list ol icon"></i>
                        </button>
                          <button id='unorderedlist-button' class="item">
                            <i class="list ul icon"></i>
                          </button>
                          <button id='undo-button' class="item">
                            <i class="undo icon"></i>
                          </button>
                          <button id='redo-button' class="item">
                            <i class="redo icon"></i>
                          </button>
                          <button id='link-button' class="item">
                            <i class='linkify icon'></i>
                          </button>
                          <button id='unlink-button' class="item">
                              <i class='unlink icon'></i>
                            </button>
                          
                          <button id="insertimage" class="item">
                            Insert Image
                          </button>
                          <div class="item">
                              <div id="publishtext" class="ui primary button">Publish</div>
                            </div>
                          <div class="item">
                              <button id='savetext' class="ui primary button" >Save</button>
                            </div>

                      </div>
                      
                      <div style="text-align:left;" class="words p-4"></div>
                </div>
                
                <h1>
                <div contenteditable="true" id="chapter-title" style="min-width:80%; padding:10px;max-width: 1000px; height:auto; overflow:auto; text-align:center; " class="ui mt-8 centered mx-auto" style="resize:vertical" rows="1" >
                  
                  @if(isset($title))
                  {{$title}}
                  @else
                  Chapter
                  @endif
                  
                </div>
              </h1>
                <div id="content" contenteditable="true" style="min-width:60%; max-width: 1000px; height:100%; padding:25px; overflow:auto; " class="ui mt-2 centered mx-auto shadow-md bg-white" style="resize:vertical" >
                 @if(!isset($content))
                  <p>Replace this text with something awesome!</p>
                  @else
                  <?php echo html_entity_decode($content);?>
                  @endif

                </div>
               
        </div>
</body>
<script>
    var editing,c;
    

var elm = document.getElementById('chapter-title');
elm.onkeydown = function (e) {
    if (!e) {
        e = window.event;
    }
    if (e.preventDefault&&e.keyCode==13) {
        e.preventDefault();
    } else {
        
    }
};

// function toggle_edit()
// {
//     switch(editing){
//     case true:
// 	c.get(0).contentEditable = true;
// 	c.css({background:"#eeeeee"});
// 	// $("#header").html("<h2>You can now edit this document - but you can't save the results</h2>");
// 	editing=false;
// 	break;
//     case false:
// 	c.get(0).contentEditable = false;
// 	c.css({background:"white"});
// 	editing=true;
	
//         break;
//     }
// }
insidechapter = false;

function isSelectionInsideElement(tagName) {
    var sel, containerNode;
    tagName = tagName.toUpperCase();
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.rangeCount > 0) {
            containerNode = sel.getRangeAt(0).commonAncestorContainer;
        }
    } else if ( (sel = document.selection) && sel.type != "Control" ) {
        containerNode = sel.createRange().parentElement();
    }
    while (containerNode) {
        if (containerNode.nodeType == 1 && containerNode.tagName == tagName) {
          alert(tagName);
            return true;
        }
        containerNode = containerNode.parentNode;
    }
    return false;
}
function addLink()
{
  var url = prompt('Write the URL here','http:\/\/');
  if(url!=null)
  {
    document.execCommand('createLink', false, url);
  }
}
function add_edit_button(button,cmd,val)
  { 
    button.click(function(){
      var focused = document.activeElement;
      
      if(insidechapter==false)
      {
        document.execCommand(cmd,false,val);
      }else
      {
        
      }
      
    });
  }
    $(document).ready(function(){
      var editor = document.getElementById('content');
      var words =  document.querySelector('.words');
      

      function WordCount(str) {
    var totalSoFar = 0;
    
    str = str.replace(/(^\s*)|(\s*$)/gi,"");
    str = str.replace(/\&nbsp;/g, '');
    str = str.replace(/[ ]{2,}/gi," ");
    str = str.replace(/\n /,"\n");

    
    for (var i = 1; i < str.length; i++) {
        if (str[i] === " ") {
            totalSoFar ++;
        }
    }
    return totalSoFar; 
}

      function getwordcount()
{
  var cont = $("#content").html();
    cont = cont.replace(/<[^>]*>/g," ");
cont = cont.replace(/\s+/g, ' ');
var regex = /\s+/gi;

cont = cont.trim();
var n = WordCount(cont);

  //   var arr = editor.textContent.trim().replace(/\s+/g, ' ').split(' ');
 if(WordCount(cont)==0)
 {
  words.textContent ="Wordcount: "+ 0;
 }else
 {
  words.textContent = !n ? 0 : "Wordcount: "+ n;
 }
  

      
}
editor.addEventListener('input',getwordcount);
    getwordcount();

      $("#savetext").click(function(){
        
        savetext();
      });
      $("#publishtext").click(function(){
        publishtext();
      });
      $("#chapter-title").focusin(function(){
        insidechapter=true;
    });
    $("#content").focusin(function(){
        insidechapter=false;
    });
      // document.execCommand('defaultParagraphSeparator', false, 'p');
     editing=false;
     c = $("#content");
    //  b = $("#toggleedit").click(toggle_edit);
     add_edit_button($("#left-icon"),"justifyleft",null);
     add_edit_button($("#justify-icon"),"justifyfull",null);
     add_edit_button($("#center-icon"),"justifycenter",null);
     add_edit_button($("#right-icon"),"justifyright",null);
     add_edit_button($("#italic-button"),"italic",null);
     add_edit_button($("#under-button"),"underline",null);
     add_edit_button($("#bold-button"),"bold",null);
     add_edit_button($("#orderedlist-button"),'insertHTML','<ol><li>one</ol></li>');
     add_edit_button($("#unorderedlist-button"),'insertHTML','<ul><li>one</ul></li>');
     $("#link-button").click(function(){
      addLink();
     });
     add_edit_button($("#header-button"),'insertHTML','<h2>H</h2>');
     add_edit_button($("#undo-button"),'undo',null);
     add_edit_button($("#redo-button"),'redo',null);
     add_edit_button($("#unlink-button"),'unlink',null);
     $("#insertimage").click(function(){
      var url = prompt('Write the image URL here','http:\/\/');
      if(url!=null)
      {
        document.execCommand('insertImage', false, url);
      }
     });
     function publishtext()
     {
      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        var content = $("#content").html();
        var chapterid = $("#chapterid").val();
        var title = $("#chapter-title").html();
        $.ajax({
                
                url:"<?php echo url('/savestories');?>",
                type:'POST',
                data:{chapterid:chapterid,content:content,title:title,p:"true"},
                success:function(data){
                  console.log(data);
                    if(data=='saved')
                    {
                        alert('saved');
                        
                    }else if (data=='published')
                    {
                        
                        alert('published')

                    }else
                    {
                        alert('error occured');
                    }
                }

                });
     }
     function savetext()
     {
      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        var content = $("#content").html();
        var chapterid = $("#chapterid").val();
        var title = $("#chapter-title").html();
        
        $.ajax({
                
                url:"<?php echo url('/savestories');?>",
                type:'POST',
                data:{chapterid:chapterid,content:content,title:title,p:"false"},
                success:function(data){
                  console.log(data);
                    if(data=='saved')
                    {
                        alert('saved');
                        
                    }else if (data=='published')
                    {
                        
                        alert('published')

                    }else
                    {
                        alert('error occured');
                    }
                }

                });

     }
     
    //  toggle_edit();
});

</script>
</html>