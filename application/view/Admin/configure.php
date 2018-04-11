<?php if(!defined('APP_PATH')) {exit('error!');}?>
	<form class="layui-form">
		<table class="layui-table mag0">
			<colgroup>
				<col width="25%">
				<col width="45%">
				<col>
		    </colgroup>
		    <thead>
		    	<tr>
		    		<th>参数名</th>
		    		<th>参数值</th>
		    		<th pc>参数说明</th>
		    	</tr>
		    </thead>
		    <tbody>
		    	<tr>
		    		<td>开启注册</td>
		    		<td><input type="checkbox" name="register" id="register" lay-filter="register" lay-skin="switch" lay-text="是|否"></td>
		    		<td pc>是否允许游客注册</td>
		    	</tr>
		    	<tr>
		    		<td>游客上传</td>
		    		<td><input type="checkbox" name="tourist" id="tourist" lay-filter="tourist" lay-skin="switch" lay-text="是|否"></td>
		    		<td pc>是否允许游客上传，开启后游客将可以上传图片</td>
		    	</tr>
		    	<tr>
		    		<td>开启注册验证</td>
		    		<td><input type="checkbox" name="verification" id="verification" lay-filter="verification" lay-skin="switch" lay-text="是|否"></td>
		    		<td pc>是否需要注册激活才能登录，开启后未激活账号将无法登陆</td>
		    	</tr>
		    	<tr>
		    		<td>开启探索</td>
		    		<td><input type="checkbox" name="explore" id="explore" lay-filter="explore" lay-skin="switch" lay-text="是|否"></td>
		    		<td pc>是否开启探索界面</td>
		    	</tr>
		    	<tr>
		    		<td>注册限制</td>
		    		<td><input type="text" class="layui-input limitip" lay-verify="number" placeholder="请输入注册数量"></td>
		    		<td pc>一个ip在24小时内允许注册的数量</td>
		    	</tr>
		    	<tr>
		    		<td>站点标题</td>
		    		<td><input type="text" class="layui-input title" lay-verify="required" placeholder="请输入站点标题"></td>
		    		<td pc>你网站的名字</td>
		    	</tr>
		    	<tr>
		    		<td>站点副标题</td>
		    		<td><input type="text" class="layui-input siteinfo" placeholder="请输入站点副标题"></td>
		    		<td pc>站点浏览器标题 = 站点标题 + 副标题</td>
		    	</tr>
		    	<tr>
		    		<td>站点关键字</td>
		    		<td><input type="text" class="layui-input keywords" placeholder="请输入网站关键字"></td>
		    		<td pc>keywords</td>
		    	</tr>
		    	<tr>
		    		<td>站点描述</td>
		    		<td><textarea placeholder="请输入网站描述" class="layui-textarea description"></textarea></td>
		    		<td pc>description</td>
		    	</tr>
		    	<tr>
		    		<td>网站备案号</td>
		    		<td><input type="text" class="layui-input record" placeholder="请输入网站备案号"></td>
		    		<td pc>工信部备案号</td>
		    	</tr>
		    	<tr>
		    		<td>首页底部信息</td>
		    		<td><textarea placeholder="请输入底部信息" class="layui-textarea footerinfo"></textarea></td>
		    		<td pc>支持html，可用于添加流量统计代码</td>
		    	</tr>
		    	<tr>
		    		<td>新浪账号</td>
		    		<td><input type="text" class="layui-input username" lay-verify="required" placeholder="请输入新浪微博账号"></td>
		    		<td pc>需要登录才能上传图片到新浪图床</td>
		    	</tr>
		    	<tr>
		    		<td>新浪密码</td>
		    		<td><input type="text" class="layui-input password" lay-verify="required" placeholder="请输入新浪微博密码"></td>
		    		<td pc>没有小号？<a href="tencent://AddContact/?fromId=45&fromSubId=1&subcmd=all&uin=1638211921">点我购买(全新4级账号，随机送会员)</a></td>
		    	</tr>
		    	<tr>
		    		<td>缩略图级别</td>
		    		<td><input type="text" class="layui-input level" lay-verify="number" placeholder="请输入缩略图级别"></td>
		    		<td pc>探索界面缩略图级别(0-7)</td>
		    	</tr>
		    	<tr>
		    		<td>163邮箱账号</td>
		    		<td><input type="text" class="layui-input user" lay-verify="required" lay-verify="email" placeholder="请输入163邮箱账号"></td>
		    		<td pc>用于用户注册发送验证码使用</td>
		    	</tr>
		    	<tr>
		    		<td>163邮箱密码</td>
		    		<td><input type="text" class="layui-input pass" lay-verify="required" placeholder="请输入163邮箱密码"></td>
		    		<td pc>没有小号？<a href="tencent://AddContact/?fromId=45&fromSubId=1&subcmd=all&uin=1638211921">点我购买(全新163账号，已开各种服务)</a></td>
		    	</tr>
		    	<tr>
		    		<td>验证码有效时间</td>
		    		<td><input type="text" class="layui-input etime" lay-verify="number" placeholder="请输入验证码有效时间"></td>
		    		<td pc>注册验证码有效时间(小时)</td>
		    	</tr>
		    </tbody>
		</table>
		<div class="magt10 layui-right">
			<div class="layui-input-block" style="text-align: right;">
				<button class="layui-btn" lay-submit="" lay-filter="systemParameter">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
		    </div>
		</div>
	</form>
	<script type="text/javascript" src="<?php echo PATH_VIEW;?>Admin/js/basicParameter.js"></script>