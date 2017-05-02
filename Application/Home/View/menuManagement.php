<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>菜单管理</title>
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
		function saveOrUpdateMenu(){
			$.post("../../../index.php?c=User&a=saveOrUpdateMenu",
			{
				"parentID" : $("#parentID").val(),
				"menuName" : $("#menuName").val(),
				"menuid"   : $("#menuid").val(),
				"menuURL"   : $("#menuURL").val()
			},function(data){
				$("#dg").datagrid("loadData",{
					rows:data.rows,
					total:data.total
				});
			},"json");
			var contect = "菜单管理-->菜单表-->1条数据";
			var save = 3;
			if($("#menuid").val()==-1){
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
                url:"../../../index.php/Home/Load/loadAllMenuList/pageNo/1/pageSize/10",   
                striped:true,
                pagination:true,
                rownumbers:true,
                fitColumns:true,
                frozenColumns:[[
    				{field:'DeptList',checkbox:true}
    		    ]], 
                columns:[[    
                    {field:'mid',title:'菜单编号',align:'center'},    
                    {field:'menuname',title:'菜单名称',align:'center'},   
                    {field:'url',title:'URL',align:'center'},   
                    {field:'level',title:'菜单等级',align:'center'},   
                    {field:'parintname',title:'父级菜单',align:'center'}
                ]],
    			toolbar: [{
    			    text   : '添加',
    				iconCls: 'icon-writenet',
    				handler: function(){
    					$("#search")[0].reset();
        				$('#win').window('open');  // open a window
						$("#menuid").val("-1");
						
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
								$.post("../../../index.php?c=User&a=deleteMenu",
								{"rows" : $("#dg").datagrid("getSelections")},function(data){
									$("#dg").datagrid("loadData",{
										rows:data.rows,
										total:data.total
									});
								},"json");
								var contect = "菜单管理-->菜单表-->"+rows.length+"条数据";
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
						$("#menuid").val(row['mid']);
						$("#menuName").val(row['menuname']);
						$("#menuURL").val(row['url']);
						$("#parentID").val(row['level']);
						$('#win').window('open');  // open a window
        			}
    			},'-',{
    				text   : '刷新',
    				iconCls: 'icon-refreshnet',
    				handler: function(){
    					$("#dg").datagrid('loading');
    					$.post("../../../index.php?c=User&a=loadAllMenuList&pageNo=1&pageSize=10",function(data){
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
					$.post("../../../index.php?c=User&a=loadAllMenuList&pageNo="+pageNumber+"&pageSize="+pageSize,function(data){
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
							<label>菜单管理</label>
						</td>
					</tr>
					<tr>
						<td class="label-td">
							<label for="menuName">菜单名称：</label>
						</td>
						<td>
							<input type="text" class="input-td" name="menuName" id="menuName" placeholder="请填写菜单名称">
						</td>
					</tr>
					<tr>
						<td class="label-td">
							<label for="menuURL">地址(URL)：</label>
						</td>
						<td>
							<input type="text" class="input-td" name="menuURL" id="menuURL" placeholder="请填写菜单地址(URL)">
						</td>
					</tr>
					<tr>
						<td class="label-td">
							<label for="parentID">父级菜单：</label>
						</td>
						<td>
    						<select id="parentID" class="input-td"  name="parentID">
                                <option id="tPSearch" value="0">请选择父级菜单</option>
                                <?php 
//             						foreach ($_SESSION["parentID"] as $p){
//             						    echo "<option value='$p['mid']'>$p['menuname']</option>";
//             						}
        						?>
                            </select>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:center;">
							<input style="width:120px;" class="btn btn-danger" value="提交" type="button" onclick="saveOrUpdateMenu();"/>
        					<input style="width:120px;" class="btn btn-primary" value="取消" type="button" onclick="resetting();"/>
						</td>
					</tr>
				</table>
				<input type="hidden" class="form-control" name="menuid" id="menuid" placeholder="菜单编号">
			</form>
        </div> 
	</body>
</html>
