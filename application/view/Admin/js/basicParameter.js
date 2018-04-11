layui.use(['form','layer','jquery'],function(){
	var form = layui.form,
		layer = parent.layer === undefined ? layui.layer : top.layer,
		laypage = layui.laypage,
		$ = layui.jquery;

 	var systemParameter;
 	form.on("submit(systemParameter)",function(data){
 		//弹出loading
 		var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
        $.post("UpdateAction",{
        	register : $("input[name='register']:checked").val(),
			tourist : $("input[name='tourist']:checked").val(),
			verification : $("input[name='verification']:checked").val(),
			explore : $("input[name='explore']:checked").val(),
            limitip : $(".limitip").val(),
            title : $(".title").val(),
            keywords : $(".keywords").val(),
            siteinfo : $(".siteinfo").val(),
            description : $(".description").val(),
            record : $(".record").val(),
            footerinfo : $(".footerinfo").val(),
            username : $(".username").val(),
            password : $(".password").val(),
            level : $(".level").val(),
            user : $(".user").val(),
            pass : $(".pass").val(),
            etime : $(".etime").val(),
        },function(res){
        
        })
        setTimeout(function(){
            layer.close(index);
			layer.msg("系统基本参数修改成功！");
        },500);
 		return false;
 	})

 	//加载数据
	$.ajax({
		url : "DataAction",
		type : "get",
		dataType : "json",
		success : function(data){
			fillData(data);
		}
	})

 	//填充数据方法
 	function fillData(data){
 		$('#register').prop('checked', data.register == 'y' ? true : false);
 		$('#tourist').prop('checked', data.tourist == 'y' ? true : false);
 		$('#verification').prop('checked', data.verification == 'y' ? true : false);
 		$('#explore').prop('checked', data.explore == 'y' ? true : false);
 		$(".limitip").val(data.limitip);
 		$(".title").val(data.title);
		$(".siteinfo").val(data.siteinfo);
		$(".keywords").val(data.keywords);
		$(".description").val(data.description);
		$(".record").val(data.record);
		$(".footerinfo").val(data.footerinfo);
		$(".username").val(data.username);
		$(".password").val(data.password); 
		$(".level").val(data.level)
		$(".user").val(data.user);
		$(".pass").val(data.pass); 
		$(".etime").val(data.etime); 
 		form.render();
 	}
})
