// 登录
var check = $("#result").text() == 'n' ? false : true;
function check_login(){
	var user=$("#user").val();
	var pass=$("#password").val();
	var verifycode = $("#verifycode").val();
	if(user=="" || pass==""){
		msg('#msg','用户名或密码不能为空！');
		return false;
	}else if(verifycode==""){
		msg('#msg','验证码不能为空！');
		return false;
	}
	event.preventDefault();
	$.ajax({
		url: 'Home/User/LoginAction/',
		type: 'POST',
		dataType: 'json',
		data: {username: user,password: pass,verifycode: verifycode},
		beforeSend: function(){
			$('#msg').addClass('text-success').text('正在登录...');
			$(".hwLayer-ok").attr('disabled',true);
		},
		success: function(res){
			if(res.code=='0000'){ //登录成功
				$('#result').html(res.username);
				$('#msg').addClass('text-success').text(res.msg);
				$("#dropdown").show();
				$("#form-btn").hide();
				$('#hw-layer-login').hwLayer('close');//关闭表单
				check = true;
			}else{
				msg('#msg',res.msg,false);
			}
			$(".hwLayer-ok").removeAttr('disabled');
		}
	});
}
// 注册
function check_register(){
	var name = $("#r_user_name").val();
	var pass = $("#r_password").val();
	var email = $("#r_email").val();
	if(name=="" || pass == "" || email == ""){
		msg('#msgt','用户名、密码、邮箱都不能为空！');
		return false;
	}else if(!/^(\w-*\.*)+@(\w-?)+(\.\w{2,})/.test(email)){
		msg('#msgt','邮箱不合法！');
		return false;
	}else if(!/^[a-zA-Z0-9\u4e00-\u9fa5]+$/.test(name)){
	 	msg('#msgt','用户名不合法！'); 
		return false;
	}else if (!/^(\w){6,20}$/.exec(pass)) {
		msg('#msgt','请输入6-20个字母、数字、下划线的密码！'); 
		return false;
	}
	event.preventDefault();
	$.ajax({
		url: 'Home/User/DoregisterAction/',
		type: 'POST',
		dataType: 'json',
		data: {username: name,password: pass,email: email},
		beforeSend: function(){
			$('#msgt').addClass('text-success').text('注册中...');
			$(".register-ok").attr('disabled',true);
		},
		success: function(res){
			if(res.code=='0000'){ 
				$('#msgt').addClass('text-success').text(res.msg);
			}else{
				msg('#msgt',res.msg,false);
			}
			$(".register-ok").removeAttr('disabled');
		}
	});
}
// 退出登录
function logout() {
	event.preventDefault();
	$.ajax({
		url: 'Home/User/LogoutAction/',
	});
	$("#dropdown").hide();
	$("#form-btn").show();
	check = false;
}
function msg(id,text,shake=true){
	$(id).addClass('text-danger').text(text);
	if (!shake) return;
	$("#login_form").removeClass('shake_effect');  
	setTimeout(function(){
		$("#login_form").addClass('shake_effect')
	},1); 
}
$(function(){
	// 显示表单
	$('#form-btn').hwLayer({
		width: 480,
		tapLayer: false
	});
	// 上传
	$("#upload").click(function(){
		if (check) {
			$("#display").show(); //上传
		}else{
			$("#form-btn").click(); //登录
		}
		return false;
	})
	$("#hide").click(function(){
		$("#display").hide(1000);
		$('#text').hide();
        $('#text').val('');
        size = 0;
		return false;
	})
	// 提交检测
	$("#create").click(function(){
		check_register();
		return false;
	})
	$("#login").click(function(){
		check_login();
		return false;
	})
	$("#logout").click(function(){
		logout();
		return false;
	})
	// 表单切换
	$('.message a').click(function () {
	    $('form').animate({
	        height: 'toggle',
	        opacity: 'toggle'
	    }, 'slow');
	});
})
function select(){
	$('#text').select();
}
(function(){
    var options = {};
    $('.js-uploader__box').uploader({
    	'selectButtonCopy':'请选择或拖拽文件',
    	'instructionsCopy':'你可以选择或拖拽多个文件',
    	'submitButtonCopy':'上传选择的文件',
    	'furtherInstructionsCopy':'你可以选择或拖拽更多的文件',
    	'secondarySelectButtonCopy':'选择更多的文件'
    });
}());