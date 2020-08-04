<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.copyprotect')
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/dist/min.css')}}">
    <!-- tailwindcss !-->
    <link rel = "stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <style>
    canvas {
        margin-left:0px;
        margin-right:0px;
        box-shadow: 2px 2px 8px #ddd;
      }
      .viewcanvas{
          width:100%;
          overflow:auto;
          
      }
      @media print
{    
    body
    {
        display: none !important;
    }
}
    </style>
    <script src="{{asset('js/jquery.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('semantic/dist/semantic.min.css') }}">
        <script src="{{asset('semantic/dist/semantic.min.js')}}"></script>
    <title>Publink</title>
    @include('layouts.navbarcss')
    @include('layouts.copyprotect')
</head>
<body class="bg-grey-lighter">
@include('layouts.navbar2')
    <div class="container mx-32">
        
            <div class="p-4 text-center text-3xl font-bold chapter-title">
                {{$book->title}}
                
            </div>
            <div class="p-4 text-center text-2xl font-bold" id="pages">
                
                
            </div>
            <div class="text-center text-xl p-2">
                <button onclick="prevpage()">Prev    </button>
                <button id="next" onclick="nextpage()">Next</button>
                <button id="zoom" onclick="zoom()"> zoom</button>
                <button id="zoomout" onclick="zoomout()"> zoomout</button>
                
            </div>
            <div class="text-center p-2">
                <input type="number" id="jumptopage">
                <button id="jump" onclick="jumptopage()">Jump to Page</button>
            </div>
            <div class="text-center">
                <div class="viewcanvas">
                <canvas id="canvas"  >
                </canvas>  
                </div>
            </div>
    </div>
</body>
<script type="text/javascript" src="//mozilla.github.io/pdf.js/build/pdf.js">
</script>
<script>
    let url = "<?php echo '/storage/'.$book->uri;?>";
    let pageNum = 1;
    // let url  = 'https://download.nikonimglib.com/archive2/payY500AHbkQ02bXMhb14TZo4978/D3300_NT(En)02.pdf';
    let scale = 1;
    let numPages=0;

function render(pageNum,url)
{
    window['pdfjs-dist/build/pdf'].getDocument(url).promise.then(pdf=>{
    

    numPages=pdf.numPages;
    document.getElementById('pages').innerHTML = "Page "+ pageNum + " of "+ pdf.numPages; 
        pdf.getPage(pageNum).then(page=>{
            
    var viewport = page.getViewport({scale:scale});

    // Prepare canvas using PDF page dimensions
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    canvas.height = viewport.height;
    canvas.width = viewport.width;
    var renderContext = {
      canvasContext: context,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);
    renderTask.promise.then(function () {
      console.log('Page rendered');
    });
    
        });
});


}
function nextpage()
{   
    
    if(pageNum!=numPages)
    {
        pageNum=pageNum+1;
    render(pageNum,url);
    }
   
}
function prevpage()
{   
    
    if(pageNum!=1)
    {
        pageNum=pageNum-1;
    render(pageNum,url);
    }
   
}
function jumptopage()
{
    if(document.getElementById('jumptopage').value>numPages)
    {
        alert('You cannot jump into this page');
    }else{
        pageNum = parseInt(document.getElementById('jumptopage').value);
        
        
    }
    render(pageNum,url);
}
function zoom(){
    scale = scale+1;
    render(pageNum,url);
    
  
}
function zoomout()
{
    if(scale-1>0)
    {
        scale = scale-1;
    render(pageNum,url);
    }
    

}
render(pageNum,url);


   


   

</script>
</html>