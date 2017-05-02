<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>角色管理</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="../../../Public/bootstrap/css/bootstrap.min.css">
		<link type="text/css" rel="stylesheet" href="../../../Public/easyui/themes/default/easyui.css">
		<link type="text/css" rel="stylesheet" href="../../../Public/easyui/themes/icon.css">
		<script type="text/javascript" src="../../../Public/bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="../../../Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="../../../Public/easyui/locale/easyui-lang-zh_CN.js"></script>
		<script type="text/javascript">
		//条件重置
		function mresettingRole(){
			$('#winmenu').window('close');
			$("#search2")[0].reset();
		}
		//条件重置
		function resettingRole(){
			$('#winrole').window('close');
			$("#search1")[0].reset();
		}
		//条件重置
		function resetting(){
			$('#win').window('close');
			$("#search")[0].reset();
		}
		//编辑/新增
		function saveOrUpdateRole(){
			$.post("../../../index.php?c=User&a=saveOrUpdateRole",
			{
				"roleName" : $("#roleName").val(),
				"roleid"   : $("#roleid").val()
			},function(data){
				$("#dg").datagrid('load');
			},"json");
			var contect = "角色管理-->角色表-->1条数据";
			var save = 3;
			if($("#roleid").val()==-1){
				save = 1; 
			}
			var log =new Array(save,contect);
			$.post("../../../index.php?c=User&a=addLog",{
				"log" : log
			},function(data){},"json");
			$('#win').window('close');
		}
		
		$(function(){
			$('#winmenu').window('close');
			$('#winrole').window('close');
			$('#win').window('close'); 
			$('#dg').datagrid({    
                url:"../../../index.php/Home/Load/loadRoleList",   
                striped:true,
                rownumbers:true,
                frozenColumns:[[
    				{field:'ProductList',checkbox:true}
    		    ]],
                columns:[[    
                    {field:'0',title:'角色编号',width:100,align:'center'},    
                    {field:'1',title:'角色名称',width:300,align:'center'}
                ]],
    			toolbar: [{
    			    text   : '添加',
    				iconCls: 'icon-writenet',
    				handler: function(){
    					$("#search")[0].reset();
        				$('#win').window('open');  // open a window
						$("#roleid").val("-1");
						
					}
    			},'-',{
    				text   : '编辑',
    				iconCls: 'icon-editnet',
    				handler: function(){
    					var rows = $("#dg").datagrid("getSelections");
						if(rows.length > 1){
							alert("你只能选中一行进行编辑！");
							return;
						}
						if(rows.length == 0){
							alert("请先选中一行进行编辑！");
							return;
						}
						var row = rows[0];
						//表单回填数据
						$("#roleName").val(row[1]);
						$("#roleid").val(row[0]);
						$('#win').window('open');  // open a window
        			}
    			},'-',{
    				text   : '刷新',
    				iconCls: 'icon-refreshnet',
    				handler: function(){
    					$.post("../../../index.php?c=User&a=loadRoleList",function(data){
								$("#dg").datagrid('load');
						},"json");
    				}
    			},'-',{
    				text   : '删除',
    				iconCls: 'icon-deletenet',
    				handler: function(){
    					var rows = $("#dg").datagrid("getSelections");
						if(rows.length < 1){
							alert("请先勾选一行进行删除！");
							return;
						}else{
							if(confirm("确认删除？")){
								$("#dg").datagrid('loading');
								$.post("../../../index.php?c=User&a=deleteRole",
								{"rows" : $("#dg").datagrid("getSelections")},function(data){
									$("#dg").datagrid('load');
								},"json");
								var contect = "角色管理-->角色表-->"+rows.length+"条数据";
		        				var log =new Array(2,contect); 
		    					$.post("../../../index.php?c=User&a=addLog",{
									"log" : log
		        				},function(data){},"json");
							}	
						}    
					}
    			},'-',{
					text   : '修改用户角色',
					iconCls: 'icon-mini-edit',
					handler: function(){
    					var rows = $("#dg").datagrid("getSelections");
						if(rows.length > 1){
							alert("对不起，你只能选中一行进行编辑！");
							return;
						}
						if(rows.length == 0){
							alert("对不起，请先选中一行进行编辑！");
							return;
						}
						//表单回填
						var row = rows[0];
						$("#readRoleName").val(row[1]);
						$("#rroleid").val(row[0]);
						$.post("../../../index.php?c=User&a=editRoleUser",{
							"roleid":row[0]
						},function(data){
    						$("#roleUser").empty();
							for(var i = 0; i < data.length; i++){
								$("#roleUser").append("<div id='Muids' style='width:80px;margin-left:5px;margin-top:5px;float:left;' class='checkbox-inline'><input type='checkbox' value='"+data[i][0]+"' name='roids'"+(data[i][2]==1?'checked':"")+"/><span style='margin-left: 5px;'>"+data[i][1]+"</span></div>");
							}
    					},"json");
    					$('#winrole').window('open'); 
    				}
				},'-',{
					text   : '修改角色权限',
					iconCls: 'icon-mini-edit',
					handler: function(){
    					var rows = $("#dg").datagrid("getSelections");
						if(rows.length > 1){
							alert("对不起，你只能选中一行进行编辑！");
							return;
						}
						if(rows.length == 0){
							alert("对不起，请先选中一行进行编辑！");
							return;
						}
						//表单回填
						var row = rows[0];
						$("#mreadRoleName").val(row[1]);
						$("#mroleid").val(row[0]);
						$.post("../../../index.php?c=User&a=editRoleMenu",{
							"mroleid":row[0]
						},function(data){
    						$("#roleMenu").empty();
							for(var i = 0; i < data.length; i++){
								$("#roleMenu").append("<div id='Muids' style='width:100px;margin-left:5px;margin-top:5px;float:left;' class='checkbox-inline'><input type='checkbox' value='"+data[i][0]+"' name='mroids'"+(data[i][2]==1?'checked':"")+"/><span style='margin-left: 5px;'>"+data[i][1]+"</span></div>");
							}
    					},"json");
    					$('#winmenu').window('open'); 
    				}
				}]   
            }); 
		});
		//修改用户角色
		function editUserRole(){
    		var roidsCheckbox = $("input[name='roids']:checked");
    		var roids = new Array();
    		for(var i = 0; i < roidsCheckbox.length; i++){
    			roids.push(roidsCheckbox.eq(i).val());
        	}
			$.post("../../../index.php?c=User&a=editUserRole",{
					"roleid":$("#rroleid").val(),
    				"roids":roids
	    	},function(data){
	    			$("#dg").datagrid('load');
			},"json");
    		$('#winrole').window('close');
    		var contect = "角色管理-->角色表-->1条用户角色数据";
			var log =new Array("修改",contect); 
			$.post("../../../index.php?c=User&a=addLog",{
				"log" : log
			},function(data){},"json");
		}
		//修改角色权限
		function editMenuRole(){
    		var mroidsCheckbox = $("input[name='mroids']:checked");
    		var mroids = new Array();
    		for(var i = 0; i < mroidsCheckbox.length; i++){
    			mroids.push(mroidsCheckbox.eq(i).val());
        	}
			$.post("../../../index.php?c=User&a=editMenuRole",{
					"mroleid":$("#mroleid").val(),
    				"mroids":mroids
	    	},function(data){
	    			$("#dg").datagrid('load');
			},"json");
    		$('#winmenu').window('close');
    		var contect = "角色管理-->角色表-->1条角色权限数据";
			var log =new Array("修改",contect); 
			$.post("../../../index.php?c=User&a=addLog",{
				"log" : log
			},function(data){},"json");
		}
		</script>
		<style type="text/css">
		label{background-color:white;font-family: "微软雅黑";font-size: 16px;}
		.label-td{width:100px;}
		.input-td{width:350px;height:30px;}
		</style>
	</head>
	<body>
		<table id="dg"></table>
		<div id="win" class="easyui-window" title="编辑/添加" style="width:600px;height:350px"   
        data-options="iconCls:'icon-save',modal:true">   
			<form id="search">
				<table style="align:center;width:470px;margin:auto;" >
    				<tr>
						<td colspan="2" style="text-align:center;">
							<label>角色管理</label>
						</td>
					</tr>
					<tr>
						<td class="label-td">
							<label for="roleName">角色名称：</label>
						</td>
						<td>
							<input type="text" class="input-td" name="roleName" id="roleName" placeholder="请填写角色名称">
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center;">
							<input style="width:120px;" class="btn btn-danger" value="提交" type="button" onclick="saveOrUpdateRole();"/>
        					<input style="width:120px;" class="btn btn-primary" value="取消" type="button" onclick="resetting();"/>
						</td>
					</tr>
				</table>
				<input type="hidden" class="form-control" name="roleid" id="roleid" >
			</form>
        </div> 
        <!-- 修改用户角色 -->
        <div id="winrole" class="easyui-window" title="修改用户角色" style="width:600px;height:350px"   
        data-options="iconCls:'icon-save',modal:true">   
			<form id="search1">
				<input type="hidden" name="rroleid" id="rroleid" value="" />
				<table style="align:center;width:470px;margin:auto;" >
    				<tr>
						<td colspan="2" style="text-align:center;">
							<label>修改用户角色</label>
						</td>
					</tr>
					<tr>
						<td class="label-td">
							<label for="readRoleName">角色名称：</label>
						</td>
						<td>
							<input type="text" class="input-td" name="readRoleName" id="readRoleName" readonly>
						</td>
					</tr>
					<tr>
						<td class="label-td">
							<label for="roleUser">用户列表：</label>
						</td>
						<td>
							<div id="roleUser" style="width:350px;height:150px;margin-top: 10px;border: solid 1px #c5c5c5;" >
                            </div>
						</td>
					</tr>
					<tr> 
						<td colspan="2" style="text-align:center;">
							<input style="width:120px;" class="btn btn-danger" value="提交" type="button" onclick="editUserRole();"/>
        					<input style="width:120px;" class="btn btn-primary" value="取消" type="button" onclick="resettingRole();"/>
						</td>
					</tr>
				</table>
			</form>
        </div> 
        <!-- 修改角色权限 -->
        <div id="winmenu" class="easyui-window" title="修改角色权限" style="width:700px;height:500px"   
        data-options="iconCls:'icon-save',modal:true">   
			<form id="search2">
				<input type="hidden" name="mroleid" id="mroleid" value="" />
				<table style="align:center;width:570px;margin:auto;" >
    				<tr>
						<td colspan="2" style="text-align:center;">
							<label>修改角色权限</label>
						</td>
					</tr>
					<tr>
						<td class="label-td">
							<label for="mreadRoleName">角色名称：</label>
						</td>
						<td>
							<input type="text"style="width:450px;" class="input-td" name="mreadRoleName" id="mreadRoleName" readonly>
						</td>
					</tr>
					<tr>
						<td class="label-td">
							<label for="roleMenu">菜单列表：</label>
						</td>
						<td>
							<div id="roleMenu" style="width:450px;height:250px;margin-top: 10px;border: solid 1px #c5c5c5;" >
                            </div>
						</td>
					</tr>
					<tr style="height:60px;"> 
						<td colspan="2" style="text-align:center;">
							<input style="width:120px;" class="btn btn-danger" value="提交" type="button" onclick="editMenuRole();"/>
        					<input style="width:120px;" class="btn btn-primary" value="取消" type="button" onclick="mresettingRole();"/>
						</td>
					</tr>
				</table>
			</form>
        </div> 
	</body>
</html>
