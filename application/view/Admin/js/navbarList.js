layui.use(['form','layer','table'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        table = layui.table;
    index = layer.msg('加载中，请稍候',{icon: 16,time:false});
    setTimeout(function(){layer.close(index);},1000);
    //导航栏列表
    var tableIns = table.render({
        elem: '#navbarList',
        url : 'QueryAction',
        cellMinWidth : 95,
        page : true,
        height : "full-200",
        limit : 20,
        limits : [10,15,20,25],
        id : "navbarListTable",
        cols : [[
            {type: "checkbox", fixed:"left", width:50},
            {field: 'navbarId', title: 'ID', width:60, align:"center"},
            {field: 'navbarName', title: '导航', width:200},
            {field: 'navbarHide', title: '是否隐藏', align:'center',width:200, templet:function(d){
                return '<input type="checkbox" name="navbarHide" id="'+d.navbarId+'" lay-filter="navbarHide" lay-skin="switch" lay-text="是|否" '+d.navbarHide+'>'
            }},
            {field: 'icon', title: '图标'},
            {field: 'navbarUrl', title: '地址'},
            {title: '操作', width:200, templet:'#navbarListBar',fixed:"right",align:"center"}
        ]]
    });

    //是否隐藏
    form.on('switch(navbarHide)', function(data){
        // var index = layer.msg('修改中，请稍候',{icon: 16,time:false,shade:0.8}),
        hide = 'y';
        setTimeout(function(){
            // layer.close(index);
            if(data.elem.checked){
                layer.msg("隐藏成功！");
            }else{
                layer.msg("取消隐藏成功！");
                hide = 'n';
            }
            $.post("HideAction",{
                id : data.elem.id,
                hide : hide
            })
        },100);
    })

    //搜索
    $(".search_btn").on("click",function(){
        if($(".searchVal").val() != ''){
            table.reload("navbarListTable",{
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

    //添加导航
    function addnavbar(edit){
        var index = layui.layer.open({
            type: 2,
            title: '添加导航',
            shadeClose: true,
            shade: false,
            maxmin: true, 
            area: ['893px', '600px'],
            content: 'navbarAdd',
            success : function(layero, index){
                var body = layui.layer.getChildFrame('body', index);
                if(edit){
                    body.find(".navbarId").val(edit.navbarId);
                    body.find(".navbarName").val(edit.navbarName);
                    body.find(".navbarUrl").val(edit.navbarUrl);
                    body.find(".navbarIcon").val(edit.icon);
                    body.find(".navbarHide input[name='navbarHide']").prop("checked",edit.navbarHide);
                    form.render();
                }
                setTimeout(function(){
                    layui.layer.tips('点击此处返回导航列表', '.layui-layer-setwin .layui-layer-close', {
                        tips: 3
                    });
                },500)
            }
        })
        layui.layer.full(index);
        //改变窗口大小时，重置弹窗的宽高，防止超出可视区域（如F12调出debug的操作）
        $(window).on("resize",function(){
            layui.layer.full(index);
        })
    }
    $(".addNews_btn").click(function(){
        addnavbar();
    })

    //批量删除
    $(".delAll_btn").click(function(){
        var checkStatus = table.checkStatus('navbarListTable'),
            data = checkStatus.data,
            navbarsId = [];
        if(data.length > 0) {
            for (var i in data) {
                navbarsId.push(data[i].navbarId);
            }
            layer.confirm('确定删除选中的导航？', {icon: 3, title: '提示信息'}, function (index) {
                var index = layer.msg('批量删除中，请稍候',{icon: 16,time:false,shade:0.8});
                setTimeout(function(){
                    $.post("DelAction",{
                        navbarsId : navbarsId 
                    },function(data){
                        tableIns.reload();
                        index = layer.msg('加载中，请稍候',{icon: 16,time:false});
                        setTimeout(function(){layer.close(index);},1000);
                    })
                },100);
            })
        }else{
            layer.msg("请选择需要删除的导航");
        }
    })

    //列表操作
    table.on('tool(navbarList)', function(obj){
        var layEvent = obj.event,
            data = obj.data;
        if(layEvent === 'edit'){ //编辑
            addnavbar(data);
        } else if(layEvent === 'del'){ //删除
            layer.confirm('确定删除此导航？',{icon:3, title:'提示信息'},function(index){
                var index = layer.msg('删除中，请稍候',{icon: 16,time:false,shade:0.8});
                setTimeout(function(){
                    $.post("DelAction",{
                        navbarsId : data.navbarId
                    },function(data){
                        tableIns.reload();
                        index = layer.msg('加载中，请稍候',{icon: 16,time:false});
                        setTimeout(function(){layer.close(index);},1000);
                    })
                },100);
            });
        } else if(layEvent === 'look'){ //预览
            window.open(data.navbarUrl);
        }
    });
})