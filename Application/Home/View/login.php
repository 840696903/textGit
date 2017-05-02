<?php
session_start();
?>
<!DOCTYPE html> 
<html>
	<head>
		<meta charset="UTF-8">
		<title>登录</title>
		<link type="text/css" rel="stylesheet" href="../../../Public/easyui/themes/default/easyui.css">
		<link type="text/css" rel="stylesheet" href="../../../Public/easyui/themes/icon.css">
		<link type="text/css" rel="stylesheet" href="../../../Public/bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="../../../Public/>bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="../../../Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="../../../Public/easyui/locale/easyui-lang-zh_CN.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row" style="margin-top: 200px;">
				<div class="col-md-4 col-md-push-4">
					<div class="panel panel-primary">
						<div class="panel-title bg-danger" style="height:30px;">登录</div>
						<div class="panel-body">
							<form action="../../../index.php/Home/User/login" method="post">
								<div class="form-group form-inline">
									<label for="userName">用户名：</label>
									<input class="" id="userName" name="userName" type="text" placeholder="请输入用户名：" />
								</div>
								<div class="form-group form-inline">
									<label for="userPass">密&nbsp;&nbsp;&nbsp;&nbsp;码：</label>
									<input id="userPass" name="userPass" type="password" placeholder="请输入密码：" />
								</div>
								<span>未注册，<a href="reg.php">立即注册</a></span>
								<input class="btn btn-primary center-block" type="submit" value="登录"/>
								<b style="color:red;"><?php if(isset($_SESSION["errormessing"])){
								    echo $_SESSION["errormessing"];
								    unset($_SESSION["errormessing"]);
								}?></b>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</body>
</html>