<?php
return array(
	//'配置项'=>'配置值'
//     'CONTROLLER_LEVEL'      =>  2,  //控制器的分级层次
    'URL_PARAMS_BIND' => true ,//开启请求参数绑定
//     'URL_PARAMS_BIND_TYPE'  =>  1, // URL变量绑定的类型 0 按变量名绑定 1 按变量顺序绑定
//     'URL_HTML_SUFFIX'       =>  '',  // URL伪静态后缀设置
);

//配置文件加载顺序
//惯例配置(ThinkPHP/Conf/convention.php)修改数据库连接，其他不改动->
//应用配置(Application/Common/Conf/config.php)主要配置的修改->
//模式配置(Application/Common/Conf/)->调试配置(ThinkPHP/Conf/debug.php)->
//状态配置(Application/Common/Conf/)->
//模块配置(Application/模块名称/Conf/config.php)->
//动态配置 