<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
	<head>
		<title>用户管理</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="http://localhost:8080/tp/Public/bootstrap/css/bootstrap.min.css">
		<link type="text/css" rel="stylesheet" href="http://localhost:8080/tp/Public/easyui/themes/default/easyui.css">
		<link type="text/css" rel="stylesheet" href="http://localhost:8080/tp/Public/easyui/themes/icon.css">
		<script type="text/javascript" src="http://localhost:8080/tp/Public/bootstrap/js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/tp/Public/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/tp/Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="http://localhost:8080/tp/Public/easyui/locale/easyui-lang-zh_CN.js"></script>
		<script type="text/javascript">
			//翻页功能
			function trunPage(pageNo,pageSize,type){
				if(type<0){				//向前翻页
					pageNo=(pageNo-1);
					if(pageNo<1){
						alert("已经是第一页了");
						return;
					}
				}else if(type==0){		//向后翻页
					pageNo=(pageNo+1);
					$total = <?php echo ($data["total"]); ?>;
					if(pageNo>parseInt($total/pageSize+1)){
						alert("已经是最后一页了");
						return;
					}
				}else{					//跳转页面
					pageNo=type;
				}
				location.href = "http://localhost:8080/tp/index.php/Home/User/AloadUserList/pageNo/"+pageNo+"/pageSize/10";
			}
			//新增修改功能
			function openWin(type){
				if(type){		//修改
					var rows = $("input[name='checkboxRow']:checked");
					if(rows.length > 1){
						alert("你只能选中一行进行编辑！");
						return;
					}
					if(rows.length == 0){
						alert("请先选中一行进行编辑！");
						return;
					}
					var row = rows.eq(0).val();
					$("#userId").val(row);
					$.post("http://localhost:8080/tp/index.php/Home/User/loadThisUser",{"uid":row},function(data){
								//表单回填数据 
								$("#userId").val(data.uid);
								$("input:radio[name='userSex']").removeAttr('checked');
								$("input:radio[name='userSex']:eq("+data.usersex+")").prop("checked",'checked');//员工性别
								$("#userName").val(data.username);//员工工号
				                $("#tureName").val(data.turename);//员工姓名
				                $("#userPass").val(data.userpass);//员工密码
				                $("#userPhone").val(data.userphone);//员工电话
					},"json");
					
				}else{			//新增
					$("#userId").val("-1");
					$("#search")[0].reset();
				}
				$("#myModal").modal("toggle");
			}
			
			//删除
			function AdeleteUser(){
				var rows = $("input[name='checkboxRow']:checked");
				var uids = new Array();
				for(var i=0;i<rows.length;i++){
					uids[i] = rows.eq(i).val();
					alert(uids);
				}
				alert("555");
				alert(uids);
			}
		</script>
		
	</head>
	<body>
		<div class="btn-group" role="group" aria-label="..." style="width:90%;margin:1%;">
			<button type="button" class="btn btn-default" onclick="openWin(0);"><span class="glyphicon glyphicon-plus"></span>新增</button>
			<button type="button" class="btn btn-default" onclick="openWin(1);"><span class="glyphicon glyphicon-pencil"></span>修改</button>
			<button type="button" class="btn btn-default" onclick="AdeleteUser();"><span class="glyphicon glyphicon-trash"></span>删除</button>
			<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-share-alt"></span>导出Excel</button>
		</div>
		
		<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">新增/修改</h4>
					</div>
					<div class="modal-body">
						<!-- 新增用户弹出窗口 -->
						<form id="search" action="http://localhost:8080/tp/index.php/Home/User/AsaveOrUpdateUser"  method="post">
							<input type="text"name="uid" id="userId" value="-1">
							<div class="form-group group-inline">
								<label for="userName">员工工号：</label>
								<input class="form-control" type="text" name="userName" id="userName" placeholder="请填写员工工号">
							</div>
							<div class="form-group group-inline">
								<label for="tureName">员工姓名：</label>
								<input class="form-control" type="text" name="tureName" id="tureName" placeholder="请填写员工姓名">
							</div>
							<div class="form-group group-inline">
								<label>员工性别：</label>
		                   		<input style="width: 20px;" type="radio"  name="userSex" value="0" >女
								<input style="width: 20px;" type="radio"  name="userSex" value="1" checked>男
							</div>
							<div class="form-group group-inline">
								<label for="userPass">员工密码：</label>
								<input class="form-control" type="text" name="userPass" id="userPass" value="123456" placeholder="请填写员工密码">
							</div>
							<div class="form-group group-inline">
								<label for="userPhone">员工电话：</label>
								<input class="form-control" type="text" name="userPhone" id="userPhone" placeholder="请填写员工电话">
							</div>
							<div class="form-group group-inline">
								<input style="width:120px;" class="btn btn-danger" value="提交" type="submit" />
		       					<input style="width:120px;" class="btn btn-primary" value="取消" type="button" data-dismiss="modal" onclick=""/>
							</div>
						</form>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
		<table style="width:90%;margin:1%;" class="table table-striped table-bordered table-condensed">
			<tr>
				<td><input type="checkbox" onclick="allCheckde(this);"/>全选</td>
				<td>用户id</td>
				<td>用户工号</td>
				<td>用户密码</td>
				<td>用户姓名</td>
				<td>用户电话</td>
				<td>用户性别</td>
			</tr>
			<?php if(is_array($data["rows"])): $i = 0; $__LIST__ = $data["rows"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$da): $mod = ($i % 2 );++$i;?><tr>
					<td><input name="checkboxRow" type="checkbox" value="<?php echo ($da["uid"]); ?>"/></td>
					<td><?php echo ($da["uid"]); ?></td>
					<td><?php echo ($da["username"]); ?></td>
					<td><?php echo ($da["userpass"]); ?></td>
					<td><?php echo ($da["turename"]); ?></td>
					<td><?php echo ($da["userphone"]); ?></td>
					<td><?php echo ($da['usersex']==0?"女":"男"); ?></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
		<div class="container">
			<nav aria-label="Page navigation">
				<ul class="pagination">
					<li><a href="#">总共<b style="color:red;"><?php echo ($data["total"]); ?></b>条数据</a></li>
					<li>
						<a href="javascript:trunPage(<?php echo ($data["pageNo"]); ?>,10,-1);" aria-label="Previous">
							<span aria-hidden="true">&laquo;</span>
						</a>
					</li>
					<li><a href="javascript:trunPage(1,10,1);">1</a></li>
					<li><a href="javascript:trunPage(2,10,2);">2</a></li>
					<li><a href="javascript:trunPage(3,10,3);">3</a></li>
					<li><a href="javascript:trunPage(4,10,4);">4</a></li>
					<li><a href="javascript:trunPage(5,10,5);">5</a></li>
					<li>
						<a href="javascript:trunPage(<?php echo ($data["pageNo"]); ?>,10,0);" aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
						</a>
					</li>
					<li><a href="#">当前第<b style="color:red;"><?php echo ($data["pageNo"]); ?></b>页</a></li>
				</ul>
			</nav>
		</div>
	</body>
</html>