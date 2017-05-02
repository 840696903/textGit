<?php if (!defined('THINK_PATH')) exit();?><html>
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
        	<b>欢迎你，<?php echo (session('myName')); ?></b>
    				<a href="login.php">退出</a>
        </div>   
        <div data-options="region:'west',title:'系统菜单',split:true" style="width:200px;">
        	<ul class="easyui-tree">
        		<?php if(is_array($menus)): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m1): $mod = ($i % 2 );++$i; if($m1["level"] == 1): ?><li>
        					<span ><?php echo ($m1["menuname"]); ?></span>
        					<ul>
        						<?php $mid = $m1["mid"]; ?>
        						<?php if(is_array($menus)): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m2): $mod = ($i % 2 );++$i; if($m2["level"] == 2 AND $m2["parentid"] == $mid): ?><li><a href="javascript:addTabs('<?php echo ($m2["menuname"]); ?>','<?php echo ($m2["url"]); ?>');"><?php echo ($m2["menuname"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        					</ul>
        				</li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
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