<?php session_start();?>
<!DOCTYPE html> 
<html>
	<head>
		<title>用户注册</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="../../../Public/bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src="../../../Public/bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="../../../Public/bootstrap/js/bootstrap.min.js"></script>
		<style type="text/css">
        .panel{height:360px;box-shadow:15px 15px 15px gray;margin-top:120px;}
        .btn{width:100px;}
        </style>
	</head>
	<body>
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-primary">
				<div class="panel-heading">用户注册</div>
				<div class="panel-body">
					<form action="../../../index.php/Home/User/reg" method="post" onsubmit="">
						<div class="form-group">
							<label for="userName">手机：</label>
							<input class="form-control" type="text" name="userName" id="userName" placeholder="输入手机号">
						</div>
						<div class="form-group">
							<label for="userPass">密码：</label>
							<input class="form-control" type="password" name="userPass" id="userPass" placeholder="输入密码">
						</div>
						<div class="form-group">
							<label for="trueName">姓名：</label>
							<input class="form-control" type="text" name="trueName" id="trueName" placeholder="输入姓名">
						</div>
						<div class="form-group" style="text-align: center;">
							<span>已有帐号，<a href="login.php">立即登录</a></span>
							<input class="btn btn-default" type="reset" value="取消">
							<input class="btn btn-primary" type="submit" value="注册">
						</div>
						<div>
							<b style="color:red;">
            				<?php 
            				    if(isset($_SESSION["errormessing"])){
								    echo $_SESSION["errormessing"];
								    unset($_SESSION["errormessing"]);
            				    }
            				?>
            				</b>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>