<?php if(!defined('APP_PATH')) {exit('error!');}?>
</div>
<div class="layui-footer">
    欢迎使用 &copy; <a href="<?php echo PATH_URL;?>" target="_black"><?php echo configGet('title');?></a><?php if($_SESSION['authen']['role'] == 'admin'):?> V<?php echo APP_VERSION;?>  <a href="JavaScript:void(0);"  id="update" version="<?php echo APP_VERSION;?>">检查更新</a><?php endif;?>
</div>
</div>
<script>
<?php if($_SESSION['authen']['role'] == 'admin'):?>
layui.use(['element','layer','jquery'],function(){
	var element = layui.element,
	layer = parent.layer === undefined ? layui.layer : top.layer,
	$ = layui.jquery;
	$(function(){
		$('#update').click(function(){
			var index = layer.msg('加载中，请稍候',{icon: 16,time:false});
	    	$.ajax({
		      url: 'https://img.52ecy.cn/service/CheckUpdate.php',
		      type: 'get',
		      success: function(res){
		        if($('#update').attr("version") < ReadErrIni('version',res)){
					layer.confirm('发现新版本，是否立即更新？', {
						btn: ['是', '否', '手动更新']
					,btn3: function(index, layero){
						window.open(ReadErrIni('url',res));
					}}, function(index, layero){
						index = layer.msg('系统正在更新，请稍待片刻...',{icon: 16,time:false});
						$.ajax({
							url: 'UpdateAction.html',
							type: 'get',
							dataType: 'json',
							success: function(res){
								if (res.code=='0000') {
									layer.open({title: '更新成功',icon: 6,content: res.msg}); 
								}else{
									layer.open({title: '更新失败',icon: 5,content: res.msg}); 
								}
							}
						})
					});
		        }else{
		        	layer.open({
					  title: '消息'
					  ,content: '当前使用的已经是最新版本!'
					});    
		        }
		      },
		      error: function(){
		      	layer.msg('检查更新失败，可能是网络问题造成的原因!', {icon: 5});
		      }
		    });
		    layer.close(index);
	    });
	})
});
function ReadErrIni(err,str){ 
	var reg=new RegExp("\\[1\\][\\s\\S]*?"+err+"\\s*=\\s*(.*)");
	return (str.match(reg) ||["",null])[1]
}
<?php else:?>
layui.use('element',function(){
	var element = layui.element;
})
<?php endif;?>
</script>
</body>
</html>