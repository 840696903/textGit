<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>日志信息</title>
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
			$("#search")[0].reset();
		}
		//条件搜索
		function doSearch(pageNo){
			$.post("../../../index.php/Home/Load/loadLogList/pageNo/1/pageSize/10",
			{
				"operation":$("#operation").val(),
                "userid":$("#userid").val(),
				"sT"    :$('#sT').datebox('getValue'),// 获取日期输入框的值
				"eT"   :$('#eT').datebox('getValue')// 获取日期输入框的值
			},function(data){
				$("#dg").datagrid("loadData",{
					rows:data.rows,
					total:data.total
				});
			},"json");
		}
		$(function(){
			$('#dg').datagrid({    
                url:"../../../index.php/Home/Load/loadLogList/pageNo/1/pageSize/10",   
                striped:true,
                pagination:true,
                rownumbers:true,
                fitColumns:true,
                frozenColumns:[[
    				{field:'logList',checkbox:true}
    		    ]],
                columns:[[    
                    {field:'lid',title:'日志编号',align:'center'},    
                    {field:'operation',title:'日志操作',align:'center',formatter: function(value){
        				if (value==1){
        					return "添加";
        				} else if(value==2) {
        					return "删除";
        				} else if(value==3) {
        					return "修改";
        				} else if(value==4) {
        					return "请假";
        				} else if(value==5) {
        					return "销假";
        				} else if(value==6) {
        					return "审批";
        				} else if(value==7) {
        					return "导出excel";
        				} else if(value==8) {
        					return "辞职";
        				}else{
        					return "";
            			}
        			}},     
                    {field:'content',title:'日志内容',width:200,align:'center'},  
                    {field:'time',title:'操作时间',width:200,align:'center'},  
                    {field:'5',title:'操作用户',align:'center'}
                ]],
    			toolbar: [{
    				text   : '删除',
    				iconCls: 'icon-deletenet',
    				handler: function(){
    					var rows = $("#dg").datagrid("getSelections");
						if(rows.length < 1){
							alert("请先勾选一行进行删除！");
							return;
						}else{
							if(confirm("确认删除？")){
								$.post("../../../index.php?c=User&a=deleteLog",
								{"rows" : $("#dg").datagrid("getSelections")},function(data){
									$("#dg").datagrid("loadData",{
										rows:data.rows,
										total:data.total
									});
								},"json");
								var contect = "日志管理-->日志表-->"+rows.length+"条数据";
		        				var log =new Array(2,contect); 
		    					$.post("../../../index.php?c=User&a=addLog",{
									"log" : log
		        				},function(data){},"json");
							}
						}    
					}
    			},'-',{
    				text   : '刷新',
    				iconCls: 'icon-refreshnet',
    				handler: function(){
    					$("#dg").datagrid('loading');
    					$.post("../../../index.php/Home/Load/loadLogList/pageNo/1/pageSize/10",{
    						"operation":$("#operation").val(),
    		                "userid":$("#userid").val(),
    						"sT"    :$('#sT').datebox('getValue'),// 获取日期输入框的值
    						"eT"   :$('#eT').datebox('getValue')// 获取日期输入框的值
    					},function(data){
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
					$.post("../../../index.php/Home/Load/loadLogList/pageNo/"+pageNumber+"/pageSize/"+pageSize,{
						"operation":$("#operation").val(),
		                "userid":$("#userid").val(),
						"sT"    :$('#sT').datebox('getValue'),// 获取日期输入框的值
						"eT"   :$('#eT').datebox('getValue')// 获取日期输入框的值
					},function(data){
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
		select{width: 155px;}
		.label-td{width:90px;}
		.input-td{width:270px;height:30px;}
		</style>
	</head>
	<body>
		<div style="width: 100%;height: 100px;background-color:#CAFFE4;">
    		<form id="search" >
                <div class="customerFrom">
                    <label for="operation">操作内容：&nbsp;&nbsp;&nbsp;</label>
                    <select id="operation">
                        <option value="0">按操作内容搜索</option>
    					<option value='1'>添加</option>
    					<option value='2'>删除</option>
    					<option value='3'>修改</option>
    					<option value='4'>请假</option>
    					<option value='5'>销假</option>
    					<option value='6'>审批</option>
    					<option value='7'>导出Excl</option>
    					<option value='8'>辞职</option>
                    </select>
                </div>
                <div class="customerFrom">
                    <label for="userid">操作员工：&nbsp;&nbsp;&nbsp;</label>
                    <select id="userid">
                        <option value="0">按操作员工搜索</option>
                        <?php
                        
    						foreach ($_SESSION["allusers"] as $u){
    						    echo "<option value='{$u['uid']}'>{$u['turename']}</option>";
    						}
						?>
                    </select>
                </div>
                <div class="customerFrom">
                    <label>操作时间(开始)：</label>
    				<input id="sT" class="easyui-datetimebox">
                </div>
    			<div class="customerFrom">
                    <label>操作时间(结束)：</label>
    				<input id="eT" class="easyui-datetimebox">
                </div>
    			<div class="customerFrom">
    				<input style="width:120px;"  value="查询" type="button" onclick="doSearch(1)"/>
    				<input style="width:120px;"  value="重置" type="button" onclick="resetting()" />
    			</div>   
            </form>  
		</div>
		<table id="dg"></table>
	</body>
</html>
