layui.use(['form','layer','table'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : top.layer,
        $ = layui.jquery,
        table = layui.table;
        index = layer.msg('加载中，请稍候',{icon: 16,time:false});
        setTimeout(function(){layer.close(index);},1000);
    //用户列表
    var tableIns = table.render({
        elem: '#picList',
        url : 'QueryAction',
        cellMinWidth : 95,
        page : true,
        height : "full-125",
        limits : [10,15,20,25],
        limit : 20,
        id : "picListTable",
        cols : [[
            {type: "checkbox", fixed:"left", width:50},
            {field: 'picpid', title: '图片ID', minWidth:80, align:"center"},
            {field: 'picuid', title: '上传用户', minWidth:80, align:'center'},
            {field: 'picdate', title: '上传时间', align:'center'},
            {field: 'picip', title: 'IP', minWidth:80, align:'center'},
            {title: '操作', width:200, templet:'#picListBar',fixed:"right",align:"center"}
        ]]
    });

    //搜索
    $(".search_btn").on("click",function(){
        if($(".searchVal").val() != ''){
            table.reload("picListTable",{
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
        var checkStatus = table.checkStatus('picListTable'),
            data = checkStatus.data,
            picId = [];
        if(data.length > 0) {
            for (var i in data) {
                picId.push(data[i].picId);
            }
            layer.confirm('确定删除选中的图片？', {icon: 3, title: '提示信息'}, function (index) {
                var index = layer.msg('删除中，请稍候',{icon: 16,time:false,shade:0.8});
                setTimeout(function(){
                    $.post("DelAction",{
                        picId : picId
                    },function(data){
                        tableIns.reload();
                        index = layer.msg('加载中，请稍候',{icon: 16,time:false});
                        setTimeout(function(){layer.close(index);},1000);
                    })
                },100);
            })
        }else{
            layer.msg("请选择需要删除的图片");
        }
    })

    //列表操作
    table.on('tool(picList)', function(obj){
        var layEvent = obj.event,
            data = obj.data;
        if(layEvent === 'del'){ //删除
            layer.confirm('确定删除此图片？',{icon:3, title:'提示信息'},function(index){
                var index = layer.msg('删除中，请稍候',{icon: 16,time:false,shade:0.8});
                setTimeout(function(){
                    $.post("DelAction",{
                        picId : data.picId
                    },function(data){
                        tableIns.reload();
                        index = layer.msg('加载中，请稍候',{icon: 16,time:false});
                        setTimeout(function(){layer.close(index);},1000);
                    })
                },100);
            });
        } else if(layEvent === 'copy'){ 
            copyToClipboard('https://ws3.sinaimg.cn/large/'+data.picpid);
        }else if(layEvent === 'look'){ //预览
            layer.open({
                title: false,
                type:2,
                area: ['80%','80%'],
                scrollbar: false,
                content: 'https://ws3.sinaimg.cn/large/'+data.picpid
            }); 
        }
    });
})