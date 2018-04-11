<?php if(!defined('APP_PATH')) {exit('error!');}?>
    <div class="jq22-container">
        <div class="jq22-content bgcolor-3">
        	<div id="div1"><?php foreach ($pic as $value) :?>
             	<div class="box"><a href="<?php echo PATH_URL.$value['pid'];?>" target="_blank"><img src="https://ws3.sinaimg.cn/<?php echo $level;?>/<?php echo $value['pid'];?>" alt=""></a></div><?php endforeach; ?>
            </div>
      </div>
    </div>
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo PATH_VIEW;?>Home/js/jquery.waterfall.js"></script> 
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
    var page = 5;
    $("#div1").waterfall({
        itemClass: ".box",
        minColCount: 2,
	    spacingHeight: 10,
	    resizeable: true,
	    ajaxCallback: function(success, end) {
            if(page===false)return;page++;
            $.ajax({
                url: '<?php echo $active=='Explore'?'RandomAction':'NewestdownAction?page=\'+page+\''?>',
                dataType: 'json',
                success: function(res){
                    if (res != '') {
                        var str = "";
                        var templ = '<div class="box" style="opacity:0;filter:alpha(opacity=0);"><div class="pic"><a href="<?php echo PATH_URL;?>{{href}}" target="_blank"><img src="{{src}}" /></div></div>';
                        for(var i = 0; i < res.src.length; i++) {
                            temp2 = templ.replace("{{src}}", res.src[i]);
                            url = res.src[i];
                            str += temp2.replace("{{href}}",url.match(/[a-zA-Z0-9_.]{25,}/)[0]);
                        }
                        $(str).appendTo($("#div1"));
                    }else{
                        page = false;
                        alert('亲，到底了~。~');
                    }
                    success();
                    end();
                }
            });
	    }
	});
	</script>
  </body>
</html>
