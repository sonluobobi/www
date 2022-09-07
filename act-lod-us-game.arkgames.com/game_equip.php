<?php

//模板文件
$template_name = 'game_equip.html';
require('common.php');

$target_file = ACTIVITY_DIR.'/equip.inc';
$equip_base = ACTIVITY_DIR.'/EquipBase.inc';
$file_path   = ACTIVITY_DIR.'/EquipBase.csv';
$equip_list = require_once $target_file;

$http_opt = trim($_POST['method']);

//上传新的CSV文件来更新游戏道具信息
if ($http_opt == 'update')
{
	try {
		$arr_field = array();
		$arr_value = array();
		
		$arr_equip = array();
		$equip_simple = array(); //存在简单的数据
		
		$row = 1;
		
		if (strpos($_FILES['file']['name'],'.csv') === false)
		{
			throw new Exception("请上传CSV类型文件");
		}
		
		$tmp_file = $_FILES['file']['tmp_name'];
		if (!move_uploaded_file($tmp_file,$file_path))
		{
			throw new Exception("上传文件失败");
		}
			
		$handle = fopen($file_path,"r");
		
		while (($data = fgetcsv($handle))) 
		{
			if ($row == 1) 
			{
				$row++;
				continue;
			}
			
			if ($row ==2)
			{
				$arr_field = $data;
			}
			else 
			{
				$arr_value[] = $data;
			}
			
			$row++;
			
		}
		fclose($handle);
		
		if (count($arr_value) > 0 && count($arr_field) > 0)
		{
			foreach ($arr_value as $index=> $arr)
			{
				foreach ($arr as $key=>$value)
				{
					$field = $arr_field[$key];
					
					if ($field == 'id__kn')
					{
						$field = str_replace('__kn','',$field);
						$equip_id = $value;
					}
					elseif ($field == 'title__s')
					{
						$field = str_replace('__s','',$field);
					}
					
					$arr_equip[$index][$field] = $value;
					
					if (in_array($field, array('id','title')))
					{
						$equip_simple[$equip_id][$field] = $value;
					}
					
				}
			}
			
			//把数据保存到文件中
			if ($arr_equip)
			{
				exec(" rm -f ".$target_file);
				exec(" rm -f ".$equip_base);
				
				file_put_contents($target_file,"<?php \n\r return ",FILE_APPEND);
				file_put_contents($target_file,var_export($arr_equip,true),FILE_APPEND);
				file_put_contents($target_file,";\n\r ?>",FILE_APPEND);
				
				file_put_contents($equip_base,"<?php \n\r return ",FILE_APPEND);
				file_put_contents($equip_base,var_export($equip_simple,true),FILE_APPEND);
				file_put_contents($equip_base,";\n\r ?>",FILE_APPEND);
				
				//echo "生成道具数组文件成功.".$target_file."\n\r";
				throw new Exception("成功更新游戏道具");
				//echo "<pre>";
				//print_r($arr_equip);
			}
		}
		else 
		{
			throw new Exception("游戏道具错误");
		}
	}catch (Exception $e) {
		$tpl->assign(array('msg'=>$e->getMessage()));
	}
	
	
$tpl->assign(array(
		'equip_list' => $arr_equip,
	    	));
	
}
//搜索
elseif ($http_opt == 'search')
{
	
	$equip_id    = trim($_POST['equip_id']);
	$equip_title = trim($_POST['equip_title']);
	
	$target_equip = array();
	
	if ($equip_list)
	{
		foreach ($equip_list as $equip)
		{
			if ($equip_id && $equip_title)
			{
				if ($equip['id'] == $equip_id && $equip['title'] == $equip_title)
				{
					$target_equip[] = $equip;
				}
			}
			elseif ($equip_id && empty($equip_title)) 
			{
				if ($equip['id'] == $equip_id )
				{
					$target_equip[] = $equip;
				}
			}
			elseif (!$equip_id && $equip_title)
			{
				if (is_integer(strpos($equip['title'], $equip_title)))
				{
					$target_equip[] = $equip;
				}
				
				/*
				if ($equip['title'] == $equip_title )
				{
					$target_equip[] = $equip;
				}*/
			}
			
		}
	}

	$tpl->assign(array(
		'equip_list' => format_equip_for_show($target_equip),
		'equip_id' => $equip_id,
		'equip_title' => $equip_title,
	    	));
}
elseif ('auto_sync' == $http_opt)
{
	//手动同步道具
	$succ_msg = '';

	$sync_file = str_replace('\\', '/', dirname(dirname(__FILE__))) . '/common/sync_equip.php';
	if (!file_exists($sync_file))
	{
		die("file is not exits -- $sync_file");
	}

	$command = " php $sync_file do";
	exec($command, $output);
	$result_retmsg = json_encode($output);
	
	if (stripos($result_retmsg, 'done') !== false)
	{
		$succ_msg = '同步成功';
	}

	die($succ_msg);
}
else
{
	
	$tpl->assign(array(
		'equip_list' => format_equip_for_show($equip_list),
	    	));
}

//格式化需要展示的道具数据
function format_equip_for_show($equip_list)
{
	//五行类型
	$color_sort_id_map = array('' => '无','1' => '火', '2' => '水', '3' => '木', '4' => '光', '5' => '暗');

	$ret = array();

	if (empty($equip_list))
	{
		return $ret;
	}

	foreach($equip_list as $_k => $detail)
	{
		$tmp = $detail;
		//$color_sort_id = intval($detail['color_sort_id']);
		//isset($color_sort_id_map[$color_sort_id]) && $tmp['color_sort_id'] = $color_sort_id_map[$color_sort_id];

		$need_trace = intval($detail['need_trace']);
		$need_trace_desc = '否';
		$need_trace == 1 && $need_trace_desc = '是';
		$tmp['need_trace'] = $need_trace_desc;

		$ret[] = $tmp;
	}

	return $ret;
}

$tpl->output();





?>
