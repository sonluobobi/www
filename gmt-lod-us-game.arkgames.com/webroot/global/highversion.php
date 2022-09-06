<?php
	require 'common.php';
	require 'base.php';
	$php_self = substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
	require 'checkLogin.php';

	$server_list = array();

	foreach($platform_map as $_sign => $_detail)
	{
		$server_list[$_sign] = $_detail['title'];
	}

	$server_list[$p] = $platform_map[$p]['title'];

	$smarty->assign("option_values", array_keys($server_list));
	$smarty->assign("option_output", array_values($server_list));
	$smarty->assign("option_selected", $server_id, true);
	
	$retmsg = '';
	$content = '';
	$log_folder = 'highversion';
	$handle = 'view';
	$platform_info = $platform_map[$p];
	$server_selected = $platform_info['title'];
	$smarty->assign("server_selected", $server_selected, true);

	if (!empty($do_search) && $do_search == 'do')
	{
		if (($do_open = httpGetVal('do_open')) == 'open')
		{
			$handle = 'open';
		}
		elseif (($do_close = httpGetVal('do_close')) == 'close')
		{
			$handle = 'close';
		}
	}

	$field_key = 'domain';
	$ios_pl = 'pl';
	$ios_pl_map = array();
	$ios_pl_map['ios'] = 'pl2';
	$ios_pl_map['quickios'] = 'pl2';
	$ios_pl_map['ttzrios'] = 'pl2';
	$ios_pl_map['sywj'] = 'pl2';
	$ios_pl_map['lqcs'] = 'pl2';
	$ios_pl_map['lmqs'] = 'pl2';
	$ios_pl_map['qtld'] = 'pl2';

	$ios_pl_map['ru'] = 'pl2';
	$ios_pl_map['eu'] = 'pl2';
	$ios_pl_map['br'] = 'pl2';
	$ios_pl_map['sgp'] = 'pl2';
	$ios_pl_map['ar'] = 'pl2';
	$ios_pl_map['na'] = 'pl2';
	$ios_pl_map['kr'] = 'pl2';
	$ios_pl_map['jp'] = 'pl2';
	
	if (!empty($ios_pl_map) && isset($ios_pl_map[$p]))
	{
		$ios_pl = $ios_pl_map[$p];
		$field_key = 'https_domain';
	}

	$smarty->assign('ios_pl', $ios_pl, true);
	$smarty->assign('domain', $platform_info[$field_key], true);

	$server_url = $ios_pl . $platform_info[$field_key] . PL_FOR_SERVER . '?c=Config&a=HighVersionAccessSwitch&handle='.$handle;
	$log_msg = $auth_user . ' -- '. $p . ' -- url='. $server_url;
	'view' != $handle && do_log($log_msg, $log_folder, $log_folder);

	$result = func_requestUrl($server_url, false, 3);

	if (!empty($result) && $result['retcode']==0)
	{
		$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : '操作成功';
		
		if (!empty($result['data']))
		{	
			$content = '当前状态 -- ' . $result['data'];
		}
		else
		{
			$content = '当前状态 -- ' . $handle;
		}
	}
	else
	{
		$retmsg = !empty($result['retmsg']) ? $result['retmsg'] : 'no data';
	}
	
	$caption = '测试高版本白名单';
	$smarty->assign('caption', $caption, true);

	$smarty->assign("content", $content);
	$smarty->assign("retmsg", $retmsg, true);
	$smarty->display('highversion.tpl');