<?php
session_start();
?>
<html>
	<head>
		<title>欢迎</title>
		<meta charset="utf-8">
		<link type="text/css" rel="stylesheet" href="../../../Public/easyui/themes/default/easyui.css">
		<link type="text/css" rel="stylesheet" href="../../../Public/easyui/themes/icon.css">
		<script type="text/javascript" src="../../../Public/bootstrap/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="../../../Public/easyui/jquery.easyui.min.js"></script>
		<script type="text/javascript" src="../../../Public/easyui/locale/easyui-lang-zh_CN.js"></script>
		<script type="text/javascript">
		function addTabs(title,url){
			var tab = $('#tt').tabs('exists',title);
			if(tab){
				$("#tt").tabs("select", title);
				tab = $("#tt").tabs("getTab", title),
				$('#tt').tabs('update', {
					tab: tab,
					options: {}
				});
			}else{
    			$('#tt').tabs('add',{
    				title:title,
    				selected:true,
    				closable:true,
    				content:'<iframe style="border:none;" src="'+url+'"  width=100% height=100%></iframe>'
    			});
			}
		}
		$(function(){
			$("#calendar").calendar({
				formatter: function(date){
					return "<a class='calendarShow' title='点击查看当天日程'>"+date.getDate()+"<br/><span>点击查看</span></a>";
				},
				onSelect: function(date){
					var y = date.getFullYear();
					var m = date.getMonth()+1;
					var d = date.getDate();
// 					addTabs("日程"+y+"-"+m+"-"+d,"../../../View/scheduleList.php?searchDate="+y+"-"+m+"-"+d);
				}
			});

			
			$(".m1").click(function(){
				if($(this).attr("aa") == 0){
					$(this).parent().find("ul").show(300);
					$(this).attr("aa", 1);
				}else{
					$(this).parent().find("ul").hide(300);
					$(this).attr("aa", 0);
				}
			});
		}); 
		</script>
	</head> 
	<body class="easyui-layout">   
        <div data-options="region:'north',split:false,collapsible:false" style="height:50px;">
        	<b>欢迎你，<?php echo $_SESSION["myName"];?></b>
    				<a href="login.php">退出</a>
        </div>   
        <div data-options="region:'west',title:'系统菜单',split:true" style="width:200px;">
        	<ul class="easyui-tree">
				<?php 
				foreach($_SESSION["menus"] as $m){   
				    if($m['level'] == 1){
				        echo "<li>";
					    echo     "<span class='m1' aa='0' style='cursor:pointer;'>{$m['menuname']}</span>";
					    echo     "<ul style='display:none;'>";
					    foreach($_SESSION["menus"] as $m3){
					        if($m3['level'] == 2 && $m3['parentid'] == $m['mid']){
					            echo "<li><a href='javascript:addTabs(\"{$m3['menuname']}\",\"{$m3['url']}\")'>{$m3['menuname']}</a></li>";
					        }
					    }
					    echo     "</ul>";
				        echo "</li>";
				    }
				}
				?>
			</ul>
        </div>   
        <div data-options="region:'center'" style="padding:5px;background:#eee;">
        	<div id="tt" class="easyui-tabs" data-options="fit:true">   
                <div title="日程" >  
                	  <div id="cc" class="easyui-calendar" data-options="fit:true" style="height:100%"></div> 
                </div>   
            </div> 
        </div>   
    </body> 
</html>


