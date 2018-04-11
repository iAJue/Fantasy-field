layui.use(['form','layer','table'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        table = layui.table;
    index = layer.msg('加载中，请稍候',{icon: 16,time:false});
    setTimeout(function(){layer.close(index);},1000);
    //用户列表
    var tableIns = table.render({
        elem: '#userList',
        url : 'QueryAction',
        cellMinWidth : 95,
        page : true,
        height : "full-125",
        limits : [10,15,20,25],
        limit : 20,
        id : "userListTable",
        cols : [[
            {type: "checkbox", fixed:"left", width:50},
            {field: 'userName', title: '用户名', minWidth:100, align:"center"},
            {field: 'userEmail', title: '用户邮箱', minWidth:200, align:'center',templet:function(d){
                return '<a class="layui-blue" href="mailto:'+d.userEmail+'">'+d.userEmail+'</a>';
            }},
            {field: 'userIp', title: 'IP', align:'center'},
            {field: 'userStatus', title: '用户状态', align:'center'},
            {field: 'userGrade', title: '用户权限', align:'center'},
            {field: 'userEndTime', title: '注册时间', align:'center',minWidth:150},
            {title: '操作', minWidth:175,fixed:"right",align:"center",templet:function(d){
                var userStatus = d.userStatus != '限制使用' ? '已启用' : '已禁用';
                return '<a class="layui-btn layui-btn-xs layui-btn-green" lay-event="usable">'+userStatus+'</a><a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>';
            }}
        ]]
    });

    //搜索
    $(".search_btn").on("click",function(){
        if($(".searchVal").val() != ''){
            table.reload("userListTable",{
                page: {
                    curr: 1 //重新从第 1 页开始
                },
                where: {
                    key: $(".searchVal").val()  //搜索的关键字
                }
            })
        }else{
            layer.msg("请输入搜索的内容");
        }
    });

    //批量删除
    $(".delAll_btn").click(function(){
        var checkStatus = table.checkStatus('userListTable'),
            data = checkStatus.data,
            usersId = [];
        if(data.length > 0) {
            for (var i in data) {
                if(data[i].userGrade != '超级管理员'){
                    usersId.push(data[i].usersId);
                }
            }
            if (usersId.length == 0){
                layer.msg('管理员账号不允许被删除！', {icon: 2});
                return;
            }
            layer.confirm('确定删除选中的用户？', {icon: 3, title: '提示信息'}, function (index) {
                var index = layer.msg('删除中，请稍候',{icon: 16,time:false,shade:0.8});
                setTimeout(function(){
                    $.post("DelAction",{
                        usersId : usersId
                    },function(data){
                        tableIns.reload();
                        index = layer.msg('加载中，请稍候',{icon: 16,time:false});
                        setTimeout(function(){layer.close(index);},1000);
                    })
                },100);
            })
        }else{
            layer.msg("请选择需要删除的用户");
        }
    })

    //列表操作
    table.on('tool(userList)', function(obj){
        var layEvent = obj.event,
            data = obj.data;

        if(layEvent === 'usable'){ //启用禁用
            if(data.userGrade == '超级管理员'){
                layer.msg('管理员账号不允许被禁用！', {icon: 2});
                return;
            }
            var _this = $(this),
                usableText = "是否确定禁用此用户？",
                btnText = "已禁用",
                seal = 'n';
            if(_this.text()=="已禁用"){
                usableText = "是否确定启用此用户？",
                btnText = "已启用",
                seal = 'y';
            }
            layer.confirm(usableText,{
                icon: 3,
                title:'系统提示',
                cancel : function(index){
                    layer.close(index);
                }
            },function(index){
                 $.post("DisableAction",{
                    uid : data.usersId,
                    seal : seal
                })
                _this.text(btnText);
                layer.close(index);
            },function(index){
                layer.close(index);
            });
        }else if(layEvent === 'del'){ //删除
            if(data.userGrade == '超级管理员'){
                layer.msg('管理员账号不允许被删除！', {icon: 2});
                return;
            }
            layer.confirm('确定删除此用户？',{icon:3, title:'提示信息'},function(index){
                var index = layer.msg('删除中，请稍候',{icon: 16,time:false,shade:0.8});
                setTimeout(function(){
                    $.post("DelAction",{
                    usersId : data.usersId 
                },function(data){
                    tableIns.reload();
                    index = layer.msg('加载中，请稍候',{icon: 16,time:false});
                    setTimeout(function(){layer.close(index);},1000);
                })
                },100);
            });
        }
    });
})