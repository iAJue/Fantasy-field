layui.use(['form','layer'],function(){
    var form = layui.form
    layer = parent.layer === undefined ? layui.layer : top.layer,
    $ = layui.jquery;
 
    form.on("submit(addnavbar)",function(data){
        //弹出loading
        var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
        $.post("AddAction",{
            navbarId : $(".navbarId").val(),
            navbarName : $(".navbarName").val(),
            navbarUrl : $(".navbarUrl").val(),
            navbarIcon : $(".navbarIcon").val(),
            navbarHide : $("input[name='navbarHide']:checked").val(),
        },function(res){
        
        })
        setTimeout(function(){
            top.layer.close(index);
            top.layer.msg("导航添加成功！");
            layer.closeAll("iframe");
            //刷新父页面
            parent.location.reload();
        },500);
        return false;
    })
})