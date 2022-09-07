<?php
/******************************************************************************
Filename              : func_for_db.inc.php
Author                : suwin zhong(frainyi@hotmail.com)
Date/time             : 2008-12-10
Purpose               : 数据库类函数集
Description           : 
Revisions             :

******************************************************************************/
/**
 * function : 格式化插入数据库的数据
 * params : 
 * 	$arrData : 要格式化的数据
  * return : array
 */
function insertFormat($arrData)
{
	if (is_array($arrData))
	{
		foreach($arrData as $key => $val)
		{
			//字段
			$strField .= '`' . $key . '`,';
			
			//对应的值
			if (!is_int($val) && !is_float($val)) //非整数和浮点形
				$strVal .= "'" . $val . "',";
			else
				$strVal .= $val . ",";
		}
		$arrResult['fields'] = substr($strField, 0, -1); //去掉最后面的,号
		$arrResult['values'] = substr($strVal, 0, -1); //去掉最后面的,号
		return $arrResult;
	}
	else
		return array();
}

/**
 * function : 格式化要更新的字段
 * params : 
 * 	$arrData : 要格式化的数据
  * return : str
 */
function updateFormat($arrData)
{
	$str = '';

	if (is_array($arrData))
	{
		foreach($arrData as $key => $val)
		{
			if ('' != trim($key))
			{
				//字段
				$str .= '`' . $key . '` = ';
			
				//对应的值
				if (!is_int($val) && !is_float($val))
					$str .= "'" . $val . "',";
				else
					$str .= $val . ",";
			}
		}
		$str = substr($str, 0, -1); //去掉最后面的,号
	}

	return $str;
}

function searchFormat($arrData)
{
	$str = '';

	if (is_array($arrData))
	{
		foreach($arrData as $key => $val)
		{
			if ('' != trim($key))
			{
				//字段
				$str .= '`' . $key . '` = ';
			
				//对应的值
				if (!is_int($val) && !is_float($val))
					$str .= "'" . $val . "' and ";
				else
					$str .= $val . " and ";
			}
		}
		$str = substr($str, 0, -5);//去掉最后面的,号
	}

	return $str;
}
?>
