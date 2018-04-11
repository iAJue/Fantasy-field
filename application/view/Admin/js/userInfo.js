layui.use(['form','layer','upload','laydate'],function(){
    form = layui.form;
    $ = layui.jquery;
    var layer = parent.layer === undefined ? layui.layer : top.layer,
        upload = layui.upload;
    // 获取数据
    $.ajax({
        type: 'GET',
        url: 'DataAction',
        dataType: 'json',
        success: function(userInfo){
            $(".username").val(userInfo.username); 
            $(".role").val(userInfo.role); 
            $(".time").val(userInfo.time); 
            $(".ip").val(userInfo.ip); 
            $(".email").val(userInfo.email); 
            $("#photo").attr("src",userInfo.photo);
            form.render();
        }
    });
    //上传头像
    upload.render({
        elem: '#upload',
        url: 'UploadAction',
        accept: 'images',
        exts: 'jpg|png|gif|bmp|jpeg',
        size: 1024,
        before: function(obj){ 
            layer.msg('上传头像中，请稍候',{icon: 16,time:false,shade:0.8});
        },
        done: function(res, index, upload){
            if (res.code == '0') {
                $('#photo').attr('src',res.src);
                layer.closeAll(); 
            }else{
                layer.msg(res.msg, {icon: 2,anim: 6}); 
            }
        }
    });

    //提交个人资料
    form.on("submit(changeUser)",function(data){
        var index = layer.msg('提交中，请稍候',{icon: 16,time:false,shade:0.8});
        setTimeout(function(){
            $.post("UpdateAction",{
                username : $(".username").val(),
                pwd : $(".pwd").val(),
                password : $(".password").val()
            },function(res){
                layer.close(index);
                layer.msg(res);
            })
        },100);
        return false;
    })

    //添加验证规则
    form.verify({
        newPwd : function(value, item){
            if(value.length < 6){
                return "密码长度不能小于6位";
            }
        },
        confirmPwd : function(value, item){
            if(!new RegExp($("#oldPwd").val()).test(value)){
                return "两次输入密码不一致，请重新输入！";
            }
        }
    })
})