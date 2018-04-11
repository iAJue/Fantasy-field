<?php if(!defined('APP_PATH')) {exit('error!');}?>
<form class="layui-form layui-row">
	<div class="layui-col-md3 layui-col-xs12 user_right">
		<div class="layui-upload-list">
			<img class="layui-upload-img layui-circle" id="photo">
		</div>
		<button type="button" class="layui-btn layui-btn-primary" id="upload"><i class="layui-icon">&#xe67c;</i> 掐指一算，我要换一个头像了</button>
	</div>
	<div class="layui-col-md6 layui-col-xs12">
		<div class="layui-form-item">
			<label class="layui-form-label">用户名</label>
			<div class="layui-input-block">
				<input type="text" class="layui-input username">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">用户组</label>
			<div class="layui-input-block">
				<input type="text" disabled class="layui-input layui-disabled role">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">注册时间</label>
			<div class="layui-input-block">
				<input type="text" disabled class="layui-input layui-disabled time">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">注册ip</label>
			<div class="layui-input-block">
				<input type="text" disabled class="layui-input layui-disabled ip">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">注册邮箱</label>
			<div class="layui-input-block">
				<input type="text" value="" disabled class="layui-input layui-disabled email">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">旧密码</label>
			<div class="layui-input-block">
				<input type="password" value="" placeholder="请输入旧密码" lay-verify="required|oldPwd" class="layui-input pwd">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">新密码</label>
			<div class="layui-input-block">
				<input type="password" value="" placeholder="请输入新密码" lay-verify="required|newPwd" id="oldPwd" class="layui-input password">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">确认密码</label>
			<div class="layui-input-block">
				<input type="password" value="" placeholder="请确认新密码" lay-verify="required|confirmPwd" class="layui-input password">
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" lay-submit="" lay-filter="changeUser">立即提交</button>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript" src="<?php echo PATH_VIEW;?>Admin/js/userInfo.js"></script>
