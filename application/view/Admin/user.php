<?php if(!defined('APP_PATH')) {exit('error!');}?>
<form class="layui-form">
	<blockquote class="layui-elem-quote quoteBox">
		<form class="layui-form">
			<div class="layui-inline">
				<div class="layui-input-inline">
					<input type="text" class="layui-input searchVal" placeholder="搜索用户名或邮箱" />
				</div>
				<a class="layui-btn search_btn" data-type="reload">搜索</a>
			</div>
			<!-- <div class="layui-inline">
				<a class="layui-btn layui-btn-normal addNews_btn">添加用户</a>
			</div> -->
			<div class="layui-inline">
				<a class="layui-btn layui-btn-danger layui-btn-normal delAll_btn">批量删除</a>
			</div>
		</form>
	</blockquote>
	<table id="userList" lay-filter="userList"></table>
</form>
<script type="text/javascript" src="<?php echo PATH_VIEW;?>Admin/js/userList.js"></script>
