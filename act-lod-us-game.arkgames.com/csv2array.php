<?php

require('common.php');

$arr_field = array();
$arr_value = array();

$arr_equip = array();

$row = 1;
$target_file = ACTIVITY_DIR.'/equip.inc';
$file_path   = ACTIVITY_DIR.'/EquipBase.csv';

$handle = fopen($file_path,"r");

while ($data = fgetcsv($handle)) 
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
			}
			elseif ($field == 'title__s')
			{
				$field = str_replace('__s','',$field);
			}
			
			$arr_equip[$index][$field] = $value;
		}
	}
	
	//把数据保存到文件中
	if ($arr_equip)
	{
		exec(" rm -f ".$target_file);
		file_put_contents($target_file,"<?php \n\r return ",FILE_APPEND);
		file_put_contents($target_file,var_export($arr_equip,true),FILE_APPEND);
		file_put_contents($target_file,";\n\r ?>",FILE_APPEND);
		
		echo "生成道具数组文件成功.".$target_file."\n\r";
		echo "<pre>";
		print_r($arr_equip);
	}
}
else 
{
	echo "道具数据错误\n";
}






?>