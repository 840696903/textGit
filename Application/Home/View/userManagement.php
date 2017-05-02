<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>用户管理</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="../../../Public/bootstrap/css/bootstrap.min.css">
		<link type="text/css" rel="stylesheet" href="../../../Public/easyui/themes/default/easyui.css">
		<link type="text/css" rel="stylesheet" href="../../../Public/easyui/themes/icon.css">
		<script type="text/javascript" src="../../../Public/bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="../../../Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="../../../Public/easyui/locale/easyui-lang-zh_CN.js"></script>
		<script type="text/javascript">
		//添加或修改用户
		function saveOrUpdateUser(){
			$.post("../../../index.php/Home/User/saveOrUpdateUser",
				{
				"uid":$("#userId").val(),
				"userName":$("#userName").val(),
                "tureName":$("#tureName").val(),
                "userSex":$('input:radio[name="userSex"]:checked').val(),
                "userPass":$("#userPass").val(),
				"userPhone":$("#userPhone").val(),
				"did":$("#userDept").val()
				},function(data){
					$("#dg").datagrid("loadData",{
						rows:data.rows,
						total:data.total
					});
				},"json");
// 			var contect = "用户管理-->用户表-->1条数据";
// 			var save = 3;
// 			if($("#userId").val()==-1){
// 				save = 1; 
// 			}
// 			var log =new Array(save,contect);
// 			$.post("../../../index.php?c=User&a=addLog",{
// 				"log" : log
// 			},function(data){},"json");
				$('#win').window('close');
		}
		
		$(function(){
			$('#win').window('close');
			$('#dg').datagrid({    
                url:"../../../index.php/Home/User/loadUserList/pageNo/1/pageSize/10",   
                striped:true,
                pagination:true,
                rownumbers:true,
                frozenColumns:[[
					{field:'UserList',checkbox:true}
    		    ]],
                columns:[[    
                    {field:'uid',title:'用户id',width:120,align:'center',hidden:true}, 
                    {field:'username',title:'用户工号',width:120,align:'center'},    
                    {field:'userpass',title:'用户密码',width:100,align:'center'},  
                    {field:'turename',title:'用户姓名',width:150,align:'center'},
                    {field:'userphone',title:'用户电话',width:100,align:'center'}, 
                    {field:'usersex',title:'用户性别',width:100,align:'center',formatter: function(value){
        				if (value==1){
        					return "男";
        				} else {
           					return "女";
        				}} 
                    },
                    {field:'deptname',title:'所在部门',width:100,align:'center'},
                    {field:'ddid',title:'所在部门id',hidden:true}
                ]],
                toolbar:[{
    			    text   : '添加',
    				iconCls: 'icon-writenet',
    				handler: function(){
						$("#userId").val("-1");
    					$("#search")[0].reset();
        				$('#win').window('open');  // open a window
						
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
								$.post("../../../index.php/Home/User/deleteUser",
								{"rows" : $("#dg").datagrid("getSelections")},function(data){
									$("#dg").datagrid("loadData",{
										rows:data.rows,
										total:data.total
									});
								},"json");
// 								var contect = "用户管理-->用户表-->"+rows.length+"条数据";
// 		        				var log =new Array(2,contect); 
// 		    					$.post("../../../index.php?c=User&a=addLog",{
// 									"log" : log
// 		        				},function(data){},"json");
							}
						}    
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
						$("#userId").val(row['uid']);
						$("input:radio[name='userSex']").removeAttr('checked');
						$("input:radio[name='userSex']:eq("+row['usersex']+")").prop("checked",'checked');//员工性别
						$("#userName").val(row['username']);//员工工号
		                $("#tureName").val(row['turename']);//员工姓名
		                $("#userPass").val(row['userpass']);//员工密码
		                $("#userPhone").val(row['userphone']);//员工电话
		                $("#userDept").val(row['ddid']);//所在部门
						$('#win').window('open'); 
        			}
    			},'-',{
    				text   : '刷新',
    				iconCls: 'icon-refreshnet',
    				handler: function(){
    					$("#dg").datagrid('loading');
    					$.post("../../../index.php/Home/User/User/loadUserList/pageNo/1/pageSize/10",function(data){
    						$("#dg").datagrid("loadData",{
    							rows:data.rows,
    							total:data.total
    						});
    						$("#dg").datagrid('loaded');
    					},"json");
    				}
    			}]     
            }); 
			var pager = $("#dg").datagrid("getPager");
			pager.pagination({
				pageList: [5,8,10,20],
				onSelectPage:function(pageNumber, pageSize){
					$("#dg").datagrid('loading');
					$.post("../../../index.php/Home/User/loadUserList/pageNo/"+pageNumber+"/pageSize/"+pageSize,function(data){
						$("#dg").datagrid("loadData",{
							rows:data.rows,
							total:data.total
						});
						$("#dg").datagrid('loaded');
					},"json");
				}
			});
		});
		</script>
		<style type="text/css">
		.customerFrom{float: left;margin-left: 30px;margin-top: 10px;}
		label{background-color:white;font-family: "微软雅黑";font-size: 16px;}
		input{width: 150px;}
		select{width: 155px;}
		.trs{height: 60px;}
		.label-td{width:100px;}
		.input-td{width:350px;height:30px;}
		</style>
	</head>
	<body>
		<table id="dg"></table>
		<!-- 新增用户弹出窗口 -->
		<div id="win" class="easyui-window" title="编辑/添加" style="width:600px;height:500px;"   
        data-options="iconCls:'icon-save',modal:true">   
			<form id="search">
				<input type="text"name="userId" id="userId" value="-1">
				<table style="align:center;width:470px;margin:auto;" >
					<tr class="trs">
						<td class="label-td">
							<label for="userName">员工工号：</label>
						</td>
						<td>
							<input class="input-td" type="text" id="userName" placeholder="请填写员工工号">
						</td>
					</tr>
					<tr class="trs">
						<td>
							<label for="tureName">员工姓名：</label>
						</td>
						<td>
							<input class="input-td" type="text" id="tureName" placeholder="请填写员工姓名">
						</td>
					</tr>
					<tr class="trs">
						<td class="label-td">
							<label>员工性别：</label>
						</td>
						<td>
                    		<input style="width: 20px;" type="radio"  name="userSex" value="0" >女
							<input style="width: 20px;" type="radio"  name="userSex" value="1" checked>男
						</td>
					</tr>
					<tr class="trs">
						<td>
							<label for="userPass">员工密码：</label>
						</td>
						<td>
							<input class="input-td" type="text" id="userPass" value="123456" placeholder="请填写员工密码">
						</td>
					</tr>
					<tr class="trs">
						<td>
							<label for="userPhone">员工电话：</label>
						</td>
						<td>
							<input class="input-td" type="text" id="userPhone" placeholder="请填写员工电话">
						</td>
					</tr>
					<tr class="trs">
						<td>
							<label for="userDept">所在部门：</label>
						</td>
						<td>
                            <select id="userDept"  class="form-control">
                                <option id="tPSearch" value="0">请选择部门:</option>
                                <?php 
            						foreach ($_SESSION["depts"] as $d){
            						    echo "<option name='userdepts' value='{$d['did']}'>{$d['deptname']}</option>";
            						}
        						?>
                            </select>
						</td>
					</tr>
					<tr class="trs">
						<td colspan="2" style="text-align:center;">
							<input style="width:120px;" class="btn btn-danger" value="提交" type="button" onclick="saveOrUpdateUser();"/>
        					<input style="width:120px;" class="btn btn-primary" value="取消" type="button" onclick="closeWin();"/>
						</td>
					</tr>
				</table>
			</form>
        </div> 
	</body>
</html>
