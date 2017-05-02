<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>渠道管理</title>
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
		function saveOrUpdateChannel(){
			$.post("../../../index.php?c=User&a=saveOrUpdateChannel",
			{
				"channelName" : $("#channelName").val(),
				"channelNo"   : $("#channelNo").val()
			},function(data){
				$("#dg").datagrid('load');
			},"json");
			var contect = "渠道管理-->渠道表-->1条数据";
			var save = 3;
			if($("#channelNo").val()==-1){
				save = 1; 
			}
			var log =new Array(save,contect);
			$.post("../../../index.php?c=User&a=addLog",{
				"log" : log
			},function(data){},"json");
			$('#win').window('close');
		}
		
		$(function(){
			var title ="渠道管理";
			$('#win').window('close'); 
			$('#dg').datagrid({    
                url:"../../../index.php/Home/Load/loadAllChannelList",   
                striped:true,
                rownumbers:true,
                frozenColumns:[[
    				{field:'ChannelList',checkbox:true}
    		    ]],
                columns:[[    
                    {field:'channelid',title:'渠道编号',width:100,align:'center'},    
                    {field:'channame',title:'渠道名称',width:300,align:'center'},    
                    {field:'isshow',title:'是否被删除',width:100,align:'center',formatter: function(value){
        				if (value==1){
        					return "未删除";
        				} else {
        					return "已删除";
        				}
        			},styler: function(value,row,index){
        				if (value == 0){
        					return 'background-color:red;color:#000000;';
        				}
        			}}
                ]],
    			toolbar: [{
    			    text   : '添加',
    				iconCls: 'icon-writenet',
    				handler: function(){
    					$("#search")[0].reset();
        				$('#win').window('open');  // open a window
						$("#channelNo").val("-1");
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
								$.post("../../../index.php?c=User&a=deleteChannel",{
									"rows" : $("#dg").datagrid("getSelections")
								},function(data){
									$("#dg").datagrid('load');
								},"json");
								
								var contect = "渠道管理-->渠道表-->"+rows.length+"条数据";
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
						$("#channelName").val(row['channame']);
						$("#channelNo").val(row['channelid']);
						$('#win').window('open');  // open a window
        			}
    			},'-',{
    				text   : '刷新',
    				iconCls: 'icon-refreshnet',
    				handler: function(){
    					$.post("../../../index.php/Home/Load/loadAllChannelList",function(data){
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
			<input type="hidden"  name="channelNo" id="channelNo" >
    			<table style="align:center;width:470px;margin:auto;" >
    				<tr>
						<td colspan="2" style="text-align:center;">
							<label>渠道管理</label>
						</td>
					</tr>
					<tr>
						<td class="label-td">
							<label for="channelName">渠道名称：</label>
						</td>
						<td>
							<input type="text" class="input-td" name="channelName" id="channelName" placeholder="请填写渠道名称">
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center;">
							<input style="width:120px;" class="btn btn-danger" value="提交" type="button" onclick="saveOrUpdateChannel();"/>
            				<input style="width:120px;" class="btn btn-primary" value="取消" type="button" onclick="resetting();"/>
						</td>
					</tr>
				</table>
			</form>
        </div> 
	</body>
</html>
