<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<body>
<div id="tes">

</div>
<div id="loadmore">
    
</div>
</body>
<script>
    $(document).ready(function(){
        function load_data(url)
        {
            if(url==null)
            {
            $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
            $.ajax({
                type : 'get',
                url : "<?php echo url('/tesloadmore');?>",
                
                success: function(data){
                        $("#tes").append(data.data);
                    $("#loadmore").html('<button id="loadmorebutton"  value="'+data.next+'">Load More</button>');
                }   
                });
            }else
            {  
            $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
            $.ajax({
                type : 'get',
                url : url,
                success: function(data){
                        $("#tes").append(data.data);
                        if(data.next!=null)
                        {
                        $("#loadmore").html('<button id="loadmorebutton"  value="'+data.next+'">Load More</button>');
                        }else{
                            $("#loadmore").remove();
                        }
                    }   
                });
            }
        }
        $(document).on('click', '#loadmorebutton', function(){
        var id = $(this).attr('value');
        $('#load_more_button').html('<b>Loading...</b>');
        load_data(id);
        });
        load_data();
});
</script>