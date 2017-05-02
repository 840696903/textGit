<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>部门管理</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="../../../Public/bootstrap/css/bootstrap.min.css">
		<link type="text/css" rel="stylesheet" href="../../../Public/easyui/themes/default/easyui.css">
		<link type="text/css" rel="stylesheet" href="../../../Public/easyui/themes/icon.css">
		<script type="text/javascript" src="../../../Public/bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="../../../Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="../../../Public/easyui/locale/easyui-lang-zh_CN.js"></script>
		<script type="text/javascript">
		//条件重置
		function resetting(){
			$('#win').window('close');
		}
		//编辑/新增
		function saveOrUpdateDept(){
			$.post("../../../index.php?c=User&a=saveOrUpdateDept",
			{
				"deptName" : $("#deptName").val(),
				"deptid"   : $("#deptid").val()
			},function(data){
				$("#dg").datagrid('load');
			},"json");
			var contect = "部门管理-->部门表-->1条数据";
			var save = 3;
			if($("#deptid").val()==-1){
				save = 1; 
			}
			var log =new Array(save,contect);
			$.post("../../../index.php?c=User&a=addLog",{
				"log" : log
			},function(data){},"json");
			$('#win').window('close');
		}
		
		$(function(){
			$('#win').window('close'); 
			$('#dg').datagrid({    
                url:"../../../index.php/Home/Load/loadAllDeptList",   
                striped:true,
                rownumbers:true,
                frozenColumns:[[
    				{field:'DeptList',checkbox:true}
    		    ]],
                columns:[[    
                    {field:'did',title:'部门编号',width:100,align:'center'},    
                    {field:'deptname',title:'部门名称',width:300,align:'center'},   
                    {field:'number',title:'部门人数',width:300,align:'center'}
                ]],
    			toolbar: [{
    			    text   : '添加',
    				iconCls: 'icon-writenet',
    				handler: function(){
    					$("#search")[0].reset();
        				$('#win').window('open');  // open a window
						$("#deptid").val("-1");
						
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
								$.post("../../../index.php?c=User&a=deleteDept",
								{"rows" : $("#dg").datagrid("getSelections")},function(data){
									$("#dg").datagrid('load');
								},"json");
								var contect = "部门管理-->部门表-->"+rows.length+"条数据";
		        				var log =new Array(2,contect); 
		    					$.post("../../../index.php?c=User&a=addLog",{
									"log" : log
		        				},function(data){},"json");
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
						$("#deptName").val(row['deptname']);
						$("#deptid").val(row['did']);
						$('#win').window('open');  // open a window
        			}
    			},'-',{
    				text   : '刷新',
    				iconCls: 'icon-refreshnet',
    				handler: function(){
    					$.post("../../../index.php?c=User&a=loadAllDeptList",
	    					function(data){
								$("#dg").datagrid('load');
							},"json");
    				}
    			}]    
            }); 
		});
		</script>
		<style type="text/css">
		label{background-color:white;font-family: "微软雅黑";font-size: 16px;}
		input{width: 150px;}
		tr{height: 60px;}
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
							<label>部门管理</label>
						</td>
					</tr>
					<tr>
						<td class="label-td">
							<label for="deptName">部门名称：</label>
						</td>
						<td>
							<input type="text" class="input-td" name="deptName" id="deptName" placeholder="请填写部门名称">
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center;">
							<input style="width:120px;" class="btn btn-danger" value="提交" type="button" onclick="saveOrUpdateDept();"/>
        					<input style="width:120px;" class="btn btn-primary" value="取消" type="button" onclick="resetting();"/>
						</td>
					</tr>
				</table>
				<input type="hidden" class="form-control" id="deptid">
			</form>
        </div> 
	</body>
</html>
