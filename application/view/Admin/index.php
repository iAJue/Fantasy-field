<?php if(!defined('APP_PATH')) {exit('error!');}?>
<blockquote class="layui-elem-quote layui-bg-green">亲爱的 <?php echo $username;?> ，<span id="nowTime"></span>
  . 欢迎使用 <?php echo configGet('title');?> 图床
</blockquote>
<?php if($_SESSION['authen']['role'] == 'admin'):?>
    <div class="layui-col-lg6 layui-col-md12">
    <blockquote class="layui-elem-quote title"><i class="layui-icon" style="font-size: 16px;">&#xe705;</i> 站点信息</blockquote>
    <table class="layui-table">
      <tbody>
        <tr><td>网站名称</td><td><?php echo configGet('title');?></td></tr>
        <tr><td>当前版本</td><td>V<?php echo APP_VERSION;?></td></tr>
        <tr><td>开发作者</td><td><a href="http://www.52ecy.cn" title="官方博客">阿珏</a></td></tr>
        <tr><td>数据库表前缀</td> <td><?php echo $prefix;?></td></tr>
        <tr><td>PHP版本</td><td><?php echo PHP_VERSION;?></td></tr>
        <tr><td>MySQL版本</td><td><?php echo $version;?></td></tr>
        <tr><td>最大上传限制</td><td><?php echo ini_get('upload_max_filesize'); ?></td></tr>
        <tr><td>允许上传文件最大数</td><td><?php echo ini_get('max_file_uploads');?></td></tr>
        <tr><td>脚本最大执行时长</td><td><?php echo ini_get('max_execution_time');?></td></tr>
        <tr><td>脚本最大消耗内存</td><td><?php echo ini_get('memory_limit');?></td></tr>
        <tr><td>脚本最大解析时长</td><td><?php echo ini_get('max_input_time');?></td></tr>
        <tr><td>服务器环境</td><td><?php echo $_SERVER['SERVER_SOFTWARE'];?></td></tr>
        <tr><td>GD图形处理库</td><td><?php echo $gd_ver;?></td></tr>
      </tbody>
    </table>
    </div>
    <div class="layui-col-lg6 layui-col-md12">
        <blockquote class="layui-elem-quote title"><i class="layui-icon" style="font-size: 16px;">&#xe645;</i> 官方消息</blockquote>
        <table class="layui-table">
            <tbody id="messenger"></tbody>
        </table>
    </div>  
<script type="text/javascript">
layui.use(['jquery'],function(){
    var $ = layui.jquery;
    var insertText='';
    $.ajax({
      url: 'https://img.52ecy.cn/service/messenger.php',
      type: 'get',
      dataType: 'json',
      success: function(res){
        for (var i = 0; i < res.items.length; i++) {
            insertText += '<tr><td><a href="'+res.items[i].url+'">'+res.items[i].title+'</a></td><td>'+res.items[i].time+'</td></tr>';
        }
        document.getElementById("messenger").innerHTML=insertText;
      },
      error: function(){
        document.getElementById("messenger").innerHTML='<tr><td>获取官方消息失败，可能是网络问题造成的原因</tr></td>';
      }
    });
});
</script>
<?php else:?>
    <table class="layui-table">
      <tbody>
        <tr><td>网站名称</td><td><?php echo configGet('title');?></td></tr>
        <tr><td>用户组</td><td>普通用户</td></tr>
        <tr><td>注册时间</td> <td><?php echo $time;?></td></tr>
        <tr><td>注册IP</td><td><?php echo $ip;?></td></tr>
        <tr><td>我的邮箱</td><td><?php echo $email;?></td></tr>
        <tr><td>我的托管</td><td><?php echo $count; ?></td></tr>
      </tbody>
    </table>
<?php endif;?>
<script type="text/javascript">
//获取系统时间
var newDate = '';
getLangDate();
//值小于10时，在前面补0
function dateFilter(date){
    if(date < 10){return "0"+date;}
    return date;
}
function getLangDate(){
    var dateObj = new Date(); //表示当前系统时间的Date对象
    var year = dateObj.getFullYear(); //当前系统时间的完整年份值
    var month = dateObj.getMonth()+1; //当前系统时间的月份值
    var date = dateObj.getDate(); //当前系统时间的月份中的日
    var day = dateObj.getDay(); //当前系统时间中的星期值
    var weeks = ["星期日","星期一","星期二","星期三","星期四","星期五","星期六"];
    var week = weeks[day]; //根据星期值，从数组中获取对应的星期字符串
    var hour = dateObj.getHours(); //当前系统时间的小时值
    var minute = dateObj.getMinutes(); //当前系统时间的分钟值
    var second = dateObj.getSeconds(); //当前系统时间的秒钟值
    var timeValue = "" +((hour >= 12) ? (hour >= 18) ? "晚上" : "下午" : "上午" ); //当前时间属于上午、晚上还是下午
    newDate = dateFilter(year)+"年"+dateFilter(month)+"月"+dateFilter(date)+"日 "+" "+dateFilter(hour)+":"+dateFilter(minute)+":"+dateFilter(second);
    document.getElementById("nowTime").innerHTML = timeValue+"好！当前时间为： "+newDate+"　"+week;
    setTimeout("getLangDate()",1000);
}
</script>