<?php
/*******************************************
Filename              : class.mySmartTemplate.php
Author                : suwin zhong(frainyi@hotmail.com)
Date/time             : 2006-07-14
Purpose               : smartTemplate扩展类配置
Description           : 
Revisions             :
*******************************************/

require_once('class.smarttemplate.php');

class MySmartTemplate extends smarttemplate
{
	function MySmartTemplate($template_filename = '') 
	{
        $this->SmartTemplate($template_filename);

        //模板目录
        $this->template_dir = './templates/';
        //编译目录
        $this->temp_dir = './templates_c/';
        //缓存目录
        $this->cache_dir = './templates_c/';
        //缓存存在时间
        $this->cache_lifetime = 600;
    }
}
?>