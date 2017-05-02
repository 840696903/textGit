<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" >
		<title>测试</title>
	</head>
	<body>
		<b><?php echo (date('Y-m-d',$aaa)); ?></b>
		<p style="color:red;"><?php echo ($bbb); ?></p>
		<b><?php echo date('Y-m-d',$aaa);?></b>
		
		<p style="color:red;"><?php echo ($ccc[2]); ?></p>
		<p ><?php echo ($aobj->name); ?></p>
		<p style="color:red;"><?php echo ($aob->class); ?></p>
		<b><?php echo (session('rue')); ?></b>
		
		<p style="color:red;"><?php echo ($sex==1?"男":"女"); ?></p>
		<!-- 遍历所有数据 -->
		<?php if(is_array($ccc)): $i = 0; $__LIST__ = $ccc;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c1): $mod = ($i % 2 );++$i; echo ($c1); ?><br/><?php endforeach; endif; else: echo "" ;endif; ?>
		<hr>
		<?php if(is_array($ccc)): $i = 0; $__LIST__ = array_slice($ccc,2,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c1): $mod = ($i % 2 );++$i; echo ($c1); ?><br/><?php endforeach; endif; else: echo "" ;endif; ?>
		
	</body>
</html>