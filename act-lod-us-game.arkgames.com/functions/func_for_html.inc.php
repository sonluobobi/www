<?php
/******************************************************************************
Filename              : func_for_html.inc.php
Author                : suwin zhong(frainyi@hotmail.com)
Date/time             : 2008-12-08
Purpose               : 共用的html方面的函数
Description           : 
Revisions             :

******************************************************************************/

/*
* function : 创建头部
*/
function setHeaderModule()
{
$str = <<<HEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="zhongsy">
<META http-equiv="Reply-to" content="frainyi@gmail.com">
<meta http-equiv="pragma" content="no-cache">
<link href="style/cp.css" rel="stylesheet" type="text/css">
<link href="style/pager.css" rel="stylesheet" type="text/css">
<link href="style/note.css" rel="stylesheet" type="text/css">
<link href="style/thickbox.css" rel="stylesheet" type="text/css">
<link type="text/css" href="style/redmond/jquery-ui-1.7.2.custom.css" rel="Stylesheet" />	
<link rel="stylesheet" type="text/css" href="style/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="style/timePicker.css" />
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src='js/jquery.autocomplete.pack.js'></script>
<script type="text/javascript" src="js/thickbox.js"></script>
<script type="text/javascript" src="js/jquery.dimensions.js"></script>
<script type="text/javascript" src="js/jquery.tooltip.pack.js"></script>
<script type="text/javascript" src="js/jquery.timePicker.js"></script>

<script type="text/javascript" src="libs/ckeditor/ckeditor.js"></script>

<script>jQuery.noConflict();</script>
<title>魔域2活动管理平台</title>
</head>

<body>
<div class="main">
HEADER;

	return $str;
}

/*
* function : 创建尾部
*/
function setFooterModule()
{
$str = <<<FOOTER
</div>
</body>
</html>
FOOTER;

	return $str;
}


/**
 * 打印登陆页面
 * 
 * @access public 
 * @global string $url 返回地址
 * @global bool $no_header 是否显示页头
 * @global bool $no_footer 是否显示页脚
 */
function Display_login() 
{
	$strLoginHtml =<<<HTMLLOGINPAGE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="style/cp.css" rel="stylesheet" type="text/css">
<title>魔域2活动管理平台</title>
</head>

<body bgcolor="#EEEEEE">
<div class="main">
	<form name="form" method="post" action="index.php">
		<table border="0" align="center" cellpadding="4" cellspacing="1">
			<tr align="center"><td colspan="2"><strong><font class="largefont">魔域2活动管理平台</font></strong></td></tr>
        	<tr>
        		<td align="right">登录帐号&nbsp;</td>
        		<td><input type="text" name="account" id="account" size="30" maxlength="50" value=""></td>
        	</tr>
			<tr>
        		<td align="right">登陆密码&nbsp;</td>
        		<td><input type="password" name="passwd" id="passwd" size="30" maxlength="50" value=""></td>
        	</tr>
        	<tr>
        		<td align="right">验证码&nbsp;</td>
        		<td><img src="libs/randomImage.php"></td>
        	</tr>
        	<tr>
        		<td align="right">确认验证码&nbsp;</td>
        		<td><input size="30" name="AuthCode" type="text" id="AuthCode"  maxlength="6"><br><font color="red">输入上面图片中数字</font></td>
        	</tr>
			<!--
			<tr>
			<td align="right">运营平台选择&nbsp; </td>
			<td>
			<select name="act_platform" id="act_platform" >
				<option value="zh" selected>大陆</option>
				<option value="tw" >港台</option>
			</select>
			<br><font color="red">请注意选择不同的运营平台</font>
			</td>
			</tr>
			-->
        	<tr align="center">
        		<td colspan="2">
        			<input type="submit" name="Submit" value="  提交  ">
        			<input name="reset" type="reset"   value="  重置  ">
        			<input name="opt_action" type="hidden" id="opt_action" value="login">
        		</td>
        	</tr>
        </table>
	</form>
</div>
</body>
</html>
HTMLLOGINPAGE;
	die($strLoginHtml);
}

/**
 * 页面转跳
 * 
 * @access public
 * @param string $url 转跳目标地址
 * @param string $text 转跳提示
 * @param integer $time 等待时间, 单位: 秒
 */
function Redirect($url = '', $text = '', $time = '1')
{
	if (empty($url))
	{
		if ($_SERVER['HTTP_REFERER'])
			$url = $_SERVER['HTTP_REFERER'];
		else
		{
			if ($_SERVER[QUERY_STRING])
				$url = $_SERVER[QUERY_STRING];
		}

$str = <<<REDIRECTPAGE
<html>
<head>
<meta http-equiv=content-type content="text/html; charset=gb2312">
<link href="style/cp.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/xp_progress.js"></script>
</head>
<body>
<div class="main">
<script type="text/javascript">
function redirectpage()
{
	bar1.togglePause();
}
var bar1= createBar(300, 18, 'white', 1, 'black', '#7B869A', 38, 7, $time, "redirectpage()");
</script>
<span class="normalfont"><img src="images/information.gif" border="0" align="absmiddle"> 
	<b>$text</b><br>
</div>
</body>
</html>
REDIRECTPAGE;
die($str);

	}

$str = <<<REDIRECTPAGE
<html>
<head>
<meta http-equiv=content-type content="text/html; charset=gb2312">
<link href="style/cp.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/xp_progress.js"></script>
</head>
<body>
<div class="main">
<script type="text/javascript">
function redirectpage()
{
	bar1.togglePause()
	window.location="$url"
}
var bar1= createBar(300, 18, 'white', 1, 'black', '#7B869A', 38, 7, $time, "redirectpage()");
</script>
<span class="normalfont"><img src="images/information.gif" border="0" align="absmiddle"> 
	<b>$text</b><br>
	<a href="$url">如果你的浏览器没有响应,请点击这里返回.</a> </span>
</div>
</body>
</html>
REDIRECTPAGE;

	die($str);
}


//将性别转成html
//$default : 默认选项值
//$showNull : 是否显示空值的项
function gender2HtmlSelected($default = '', $showNull = true)
{
	global $_CONFIG_GLOBAL_GENDER;
	$arr_gender = $_CONFIG_GLOBAL_GENDER;

	$html = '<select id="SelGender" name="SelGender">' . "\r";
	foreach ($arr_gender AS $gender)
	{
		if ($default == $gender['id'])
			$selected = 'selected';
		else
			$selected = '';

		if (true == $showNull)
			$html .= '<option value="' . $gender['id'] . '" ' . $selected . '>' . $gender['title'] . '</option>' . "\r";
		else
		{
			if ('' != $gender['id'])
				$html .= '<option value="' . $gender['id'] . '" ' . $selected . '>' . $gender['title'] . '</option>' . "\r";
		}
	}
	$html .= '</select>' . "\r";

	return $html;
}

//将国家转成html
function nation2HtmlSelected($default = '', $showNull = true)
{
	global $_CONFIG_GLOBAL_NATION;
	$arr_nation = $_CONFIG_GLOBAL_NATION;

	$html = '<select id="SelNation" name="SelNation">' . "\r";
	foreach ($arr_nation AS $nation)
	{
		if ($default == $nation['id'])
			$selected = 'selected';
		else
			$selected = '';

		if (true == $showNull)
			$html .= '<option value="' . $nation['id'] . '" ' . $selected . '>' . $nation['title'] . '</option>' . "\r";
		else
		{
			if ('' != $nation['id'])
				$html .= '<option value="' . $nation['id'] . '" ' . $selected . '>' . $nation['title'] . '</option>' . "\r";
		}
	}
	$html .= '</select>' . "\r";

	return $html;
}

/*将国家转成checkbox类型html
	params : string $default = 1,2,3,4.... 默认选中项
			 int $cols = 2 一行显示几个
*/
function nation2HtmlCheckbox($default = '', $cols = 2)
{
	global $_CONFIG_GLOBAL_NATION_FOR_CHECKBOX;
	$arr_nation = $_CONFIG_GLOBAL_NATION_FOR_CHECKBOX;

	if ('' != trim($default))
		$arr_default = explode(',', $default);
	else
		$arr_default = array();

	$html = '';
	$no = 1;
	foreach ($arr_nation AS $nation)
	{
		if (in_array($nation['id'], $arr_default))
			$checked = 'checked';
		else
			$checked = '';

		if ('' != $nation['id'])
		{
			if (0 == $nation['id'])
				$nation['title'] = '<font color="red">' . $nation['title'] . '</font>';

			$html .= '&nbsp;' . $nation['title'] . '&nbsp;<input type="checkbox" name="ChkNation[]" id="ChkNation[]" value="' . $nation['id'] . '" ' . $checked . '>' . "\r";
			if ($no < $cols)
				$no++;
			else
			{
				$html .= '<br>' . "\r";
				$no = 1;
			}
				
		}
	}

	return $html;
}

//将国家转成html第二种格式
function nation2HtmlSelectedFormat2($default = '')
{
	global $_CONFIG_GLOBAL_NATION_FOR_CHECKBOX;
	$arr_nation = $_CONFIG_GLOBAL_NATION_FOR_CHECKBOX;

	$html = '<select id="SelNation" name="SelNation">' . "\r" . 
				'<option value="">全部</option>' . "\r";
	foreach ($arr_nation AS $nation)
	{
		if ($default == $nation['id'])
			$selected = 'selected';
		else
			$selected = '';

		if ('' != $nation['id'])
			$html .= '<option value="' . $nation['id'] . '" ' . $selected . '>' . $nation['title'] . '</option>' . "\r";
	}
	$html .= '</select>' . "\r";

	return $html;
}

//将国家转成html第三种格式
function nation2HtmlSelectedFormat3($default = '')
{
	global $_CONFIG_GLOBAL_NATION_FOR_CHECKBOX;
	$arr_nation = $_CONFIG_GLOBAL_NATION_FOR_CHECKBOX;

	$html = '<select id="SelNation" name="SelNation">' . "\r" . 
				'' . "\r";
	foreach ($arr_nation AS $nation)
	{
		if ($default == $nation['id'])
			$selected = 'selected';
		else
			$selected = '';

		if ('' != $nation['id'])
			$html .= '<option value="' . $nation['id'] . '" ' . $selected . '>' . $nation['title'] . '</option>' . "\r";
	}
	$html .= '</select>' . "\r";

	return $html;
}

//将职业转成html
function faction2HtmlSelected($default = '', $showNull = true)
{
	global $_CONFIG_GLOBAL_FACTION;
	$arr_faction = $_CONFIG_GLOBAL_FACTION;

	$html = '<select id="SelFaction" name="SelFaction">' . "\r";
	foreach ($arr_faction AS $faction)
	{
		if ($default == $faction['id'])
			$selected = 'selected';
		else
			$selected = '';

		if (true == $showNull)
			$html .= '<option value="' . $faction['id'] . '" ' . $selected . '>' . $faction['title'] . '</option>' . "\r";
		else
		{
			if ('' != $faction['id'])
				$html .= '<option value="' . $faction['id'] . '" ' . $selected . '>' . $faction['title'] . '</option>' . "\r";
		}
	}
	$html .= '</select>' . "\r";

	return $html;
}

/*将职业转成checkbox类型html
	params : string $default = 1,2,3,4.... 默认选中项
			 int $cols = 2 一行显示几个
*/
function faction2HtmlCheckbox($default = '', $cols = 2)
{
	global $_CONFIG_GLOBAL_FACTION_FOR_CHECKBOX;
	$arr_faction = $_CONFIG_GLOBAL_FACTION_FOR_CHECKBOX;

	if ('' != trim($default))
		$arr_default = explode(',', $default);
	else
		$arr_default = array();

	$html = '';
	$no = 1;
	foreach ($arr_faction AS $faction)
	{
		if (in_array($faction['id'], $arr_default))
			$checked = 'checked';
		else
			$checked = '';

		if ('' != $faction['id'])
		{
			if (0 == $faction['id'])
				$faction['title'] = '<font color="red">' . $faction['title'] . '</font>';

			$html .= '&nbsp;' . $faction['title'] . '&nbsp;<input type="checkbox" name="ChkFaction[]" id="ChkFaction[]" value="' . $faction['id'] . '" ' . $checked . '>' . "\r";
			if ($no < $cols)
				$no++;
			else
			{
				$html .= '<br>' . "\r";
				$no = 1;
			}
				
		}
	}

	return $html;
}

//将职业转成html
function faction2HtmlSelectedFormat2($default = '')
{
	global $_CONFIG_GLOBAL_FACTION_FOR_CHECKBOX;
	$arr_faction = $_CONFIG_GLOBAL_FACTION_FOR_CHECKBOX;

	$html = '<select id="SelFaction" name="SelFaction">' . "\r" . 
				'<option value="">全部</option>';
	foreach ($arr_faction AS $faction)
	{
		if ($default == $faction['id'])
			$selected = 'selected';
		else
			$selected = '';

		if ('' != $faction['id'])
			$html .= '<option value="' . $faction['id'] . '" ' . $selected . '>' . $faction['title'] . '</option>' . "\r";
	}
	$html .= '</select>' . "\r";

	return $html;
}

//将怪物类型转成html
function monster2HtmlSelected($default = '', $showNull = true, $setChangeEvent = false)
{
	global $_CONFIG_GLOBAL_MONSTER;
	$arr_monster = $_CONFIG_GLOBAL_MONSTER;

	if ($setChangeEvent)
		$changeEvent = 'onChange="selMonsterChange(this.options[this.options.selectedIndex].value)"';

	$html = '<select id="SelMonster" name="SelMonster" ' . $changeEvent . '>' . "\r";
	foreach ($arr_monster AS $monster)
	{
		if ($default == $monster['id'])
			$selected = 'selected';
		else
			$selected = '';

		if (true == $showNull)
			$html .= '<option value="' . $monster['id'] . '" ' . $selected . '>' . $monster['title'] . '</option>' . "\r";
		else
		{
			if ('' != $monster['id'])
				$html .= '<option value="' . $monster['id'] . '" ' . $selected . '>' . $monster['title'] . '</option>' . "\r";
		}
	}
	$html .= '</select>' . "\r";

	return $html;
}

//将怪物属性转成html
function monsterCategory2HtmlSelected($default = '', $showNull = true, $setChangeEvent = false)
{
	global $_CONFIG_GLOBAL_MONSTER_CATEGORY;
	$arr_monster_category = $_CONFIG_GLOBAL_MONSTER_CATEGORY;

	if ($setChangeEvent)
		$changeEvent = 'onChange="selMonsterCategoryChange(this.options[this.options.selectedIndex].value)"';

	$html = '<select id="SelMonsterCategory" name="SelMonsterCategory" ' . $changeEvent . '>' . "\r";
	foreach ($arr_monster_category AS $monster_category)
	{
		if ($default == $monster_category['id'])
			$selected = 'selected';
		else
			$selected = '';

		if (true == $showNull)
			$html .= '<option value="' . $monster_category['id'] . '" ' . $selected . '>' . $monster_category['title'] . '</option>' . "\r";
		else
		{
			if ('' != $monster_category['id'])
				$html .= '<option value="' . $monster_category['id'] . '" ' . $selected . '>' . $monster_category['title'] . '</option>' . "\r";
		}
	}
	$html .= '</select>' . "\r";

	return $html;
}

//创建NPC系统管理目录
function npcSysMenu($id)
{
	$arr_npc_sys_page = array(
			array('id' => '1', 'title' => '功能性NPC类型', 'tip' => '管理功能性NPC的类型', 'url' => 'npc_sort_manage.php'), 
			array('id' => '2', 'title' => '功能性NPC', 'tip' => '管理功能性NPC对象', 'url' => 'npc_sale_manage.php'), 
			array('id' => '3', 'title' => '怪物NPC', 'tip' => '管理怪物NPC对象', 'url' => 'npc_monster_manage.php'), 
					);

	$str = '';
	foreach ($arr_npc_sys_page AS $npc_sys_page)
	{
		$now_id = $npc_sys_page['id'];
		$now_title = $npc_sys_page['title'];
		$now_tip = $npc_sys_page['tip'];
		$now_url = $npc_sys_page['url'];

		if ($id == $now_id)
		{
			$str .= '<td align="center" width="10%" class="tableHeader" title="' . $now_tip . '">' . "\r\n" . 
							$now_title  . "\r\n" . 
					  '</td>'  . "\r\n";
		}
		else
		{
			$str .= '<td align="center" width="10%" onclick="window.location.href=\'' . $now_url .'\'" class="bg_0" style="cursor:pointer" title="' . $now_tip . '" ' . "\r\n" . 
							'onmouseover="this.className=\'tableHeader\'" onmouseout="this.className=\'bg_0\'">' . "\r\n" . 
							$now_title . "\r\n" . 
					'</td>' . "\r\n";
		}
	}

	$html = '<table width="98%" border="0">' . "\r\n" . 
				'<tr class="bg_0">' . "\r\n" . 
					$str . "\r\n" .  
				'<td>&nbsp;&nbsp;</td>' . "\r\n" . 
				'</tr>' . "\r\n" . 
			'</table>' . "\r\n";

	return $html;
}

//创建NPC分类管理目录
function npcMenu($id)
{
	$arr_npc_page = array(
			array('id' => '1', 'title' => '买卖型', 'tip' => '管理买卖型NPC', 'url' => 'npc_sale_manage.php'), 
			array('id' => '2', 'title' => '技能型', 'tip' => '管理技能型NPC', 'url' => 'npc_skill_manage.php'), 
			array('id' => '3', 'title' => '系统型', 'tip' => '管理系统型NPC', 'url' => 'npc_system_manage.php'), 
			array('id' => '4', 'title' => '任务型', 'tip' => '管理任务型NPC', 'url' => 'npc_task_manage.php'), 
					);

	$str = '';
	foreach ($arr_npc_page AS $npc_page)
	{
		$now_id = $npc_page['id'];
		$now_title = $npc_page['title'];
		$now_tip = $npc_page['tip'];
		$now_url = $npc_page['url'];

		if ($id == $now_id)
		{
			$str .= '<td align="center" width="10%" class="tableHeader" title="' . $now_tip . '">' . "\r\n" . 
							$now_title  . "\r\n" . 
					  '</td>'  . "\r\n";
		}
		else
		{
			$str .= '<td align="center" width="10%" onclick="window.location.href=\'' . $now_url .'\'" class="bg_0" style="cursor:pointer" title="' . $now_tip . '" ' . "\r\n" . 
							'onmouseover="this.className=\'tableHeader\'" onmouseout="this.className=\'bg_0\'">' . "\r\n" . 
							$now_title . "\r\n" . 
					'</td>' . "\r\n";
		}
	}

	$html = '<table width="98%" border="0">' . "\r\n" . 
				'<tr class="bg_0">' . "\r\n" . 
					$str . "\r\n" .  
				'<td>&nbsp;&nbsp;</td>' . "\r\n" . 
				'</tr>' . "\r\n" . 
			'</table>' . "\r\n";

	return $html;
}

//创建道具系统管理目录
function equipSysMenu($id)
{
	$arr_equip_sys_page = array(
			array('id' => '1', 'title' => '道具类型', 'tip' => '管理道具的类型', 'url' => 'equip_sort_manage.php'), 
			array('id' => '2', 'title' => '道具', 'tip' => '管理道具对象', 'url' => 'equip_weapon_manage.php'), 
					);

	$str = '';
	foreach ($arr_equip_sys_page AS $equip_sys_page)
	{
		$now_id = $equip_sys_page['id'];
		$now_title = $equip_sys_page['title'];
		$now_tip = $equip_sys_page['tip'];
		$now_url = $equip_sys_page['url'];

		if ($id == $now_id)
		{
			$str .= '<td align="center" width="10%" class="tableHeader" title="' . $now_tip . '">' . "\r\n" . 
							$now_title  . "\r\n" . 
					  '</td>'  . "\r\n";
		}
		else
		{
			$str .= '<td align="center" width="10%" onclick="window.location.href=\'' . $now_url .'\'" class="bg_0" style="cursor:pointer" title="' . $now_tip . '" ' . "\r\n" . 
							'onmouseover="this.className=\'tableHeader\'" onmouseout="this.className=\'bg_0\'">' . "\r\n" . 
							$now_title . "\r\n" . 
					'</td>' . "\r\n";
		}
	}

	$html = '<table width="98%" border="0">' . "\r\n" . 
				'<tr class="bg_0">' . "\r\n" . 
					$str . "\r\n" .  
				'<td>&nbsp;&nbsp;</td>' . "\r\n" . 
				'</tr>' . "\r\n" . 
			'</table>' . "\r\n";

	return $html;
}

//创建道具分类管理目录
function equipMenu($id)
{
	$arr_equip_page = array(
			array('id' => '1', 'title' => '装备类', 'tip' => '管理装备类型的道具', 'url' => 'equip_weapon_manage.php'), 
			array('id' => '2', 'title' => '补给品类', 'tip' => '管理补给品类型的道具', 'url' => 'equip_supplies_manage.php'), 
			array('id' => '3', 'title' => '大红大蓝类', 'tip' => '管理大红大蓝类型的道具', 'url' => 'equip_rb_manage.php'), 
			array('id' => '4', 'title' => '宝石类', 'tip' => '管理宝石类型的道具', 'url' => 'equip_jewel_manage.php'), 
			array('id' => '5', 'title' => '合成书类', 'tip' => '管理合成书类型的道具', 'url' => 'equip_book_manage.php'), 
			array('id' => '6', 'title' => '综合类', 'tip' => '管理功能，垃圾，任务，清洗，打孔等类型的道具', 'url' => 'equip_normal_manage.php'), 
					);

	$str = '';
	foreach ($arr_equip_page AS $equip_page)
	{
		$now_id = $equip_page['id'];
		$now_title = $equip_page['title'];
		$now_tip = $equip_page['tip'];
		$now_url = $equip_page['url'];

		if ($id == $now_id)
		{
			$str .= '<td align="center" width="10%" class="tableHeader" title="' . $now_tip . '">' . "\r\n" . 
							$now_title  . "\r\n" . 
					  '</td>'  . "\r\n";
		}
		else
		{
			$str .= '<td align="center" width="10%" onclick="window.location.href=\'' . $now_url .'\'" class="bg_0" style="cursor:pointer" title="' . $now_tip . '" ' . "\r\n" . 
							'onmouseover="this.className=\'tableHeader\'" onmouseout="this.className=\'bg_0\'">' . "\r\n" . 
							$now_title . "\r\n" . 
					'</td>' . "\r\n";
		}
	}

	$html = '<table width="98%" border="0">' . "\r\n" . 
				'<tr class="bg_0">' . "\r\n" . 
					$str . "\r\n" .  
				'<td>&nbsp;&nbsp;</td>' . "\r\n" . 
				'</tr>' . "\r\n" . 
			'</table>' . "\r\n";

	return $html;
}

//创建技能系统管理目录
function skillSysMenu($id)
{
	$arr_skill_sys_page = array(
			array('id' => '1', 'title' => '技能类型', 'tip' => '管理技能的类型', 'url' => 'skill_sort_manage.php'), 
			array('id' => '2', 'title' => '技能', 'tip' => '管理技能对象', 'url' => 'skill_initiative_manage.php?action=admin'), 
					);

	$str = '';
	foreach ($arr_skill_sys_page AS $skill_sys_page)
	{
		$now_id = $skill_sys_page['id'];
		$now_title = $skill_sys_page['title'];
		$now_tip = $skill_sys_page['tip'];
		$now_url = $skill_sys_page['url'];

		if ($id == $now_id)
		{
			$str .= '<td align="center" width="10%" class="tableHeader" title="' . $now_tip . '">' . "\r\n" . 
							$now_title  . "\r\n" . 
					  '</td>'  . "\r\n";
		}
		else
		{
			$str .= '<td align="center" width="10%" onclick="window.location.href=\'' . $now_url .'\'" class="bg_0" style="cursor:pointer" title="' . $now_tip . '" ' . "\r\n" . 
							'onmouseover="this.className=\'tableHeader\'" onmouseout="this.className=\'bg_0\'">' . "\r\n" . 
							$now_title . "\r\n" . 
					'</td>' . "\r\n";
		}
	}

	$html = '<table width="98%" border="0">' . "\r\n" . 
				'<tr class="bg_0">' . "\r\n" . 
					$str . "\r\n" .  
				'<td>&nbsp;&nbsp;</td>' . "\r\n" . 
				'</tr>' . "\r\n" . 
			'</table>' . "\r\n";

	return $html;
}

//创建技能分类管理目录
function skillMenu($id)
{
	$arr_skill_page = array(
			array('id' => '1', 'title' => '主动技能类', 'tip' => '管理主动技能', 'url' => 'skill_initiative_manage.php?action=admin'), 
			array('id' => '2', 'title' => '被动技能类', 'tip' => '管理被动技能', 'url' => 'skill_passive_manage.php?action=admin'), 
			array('id' => '3', 'title' => '预备环境技能类', 'tip' => '管理预备环境技能', 'url' => 'skill_pre_env_manage.php?action=admin'), 
			array('id' => '4', 'title' => '道具使用技能类', 'tip' => '管理道具使用技能', 'url' => 'skill_equip_use_manage.php?action=admin'), 
			array('id' => '5', 'title' => '综合类', 'tip' => '管理综合类', 'url' => 'skill_normal_manage.php?action=admin'),  
					);

	$str = '';
	foreach ($arr_skill_page AS $skill_page)
	{
		$now_id = $skill_page['id'];
		$now_title = $skill_page['title'];
		$now_tip = $skill_page['tip'];
		$now_url = $skill_page['url'];

		if ($id == $now_id)
		{
			$str .= '<td align="center" width="10%" class="tableHeader" title="' . $now_tip . '">' . "\r\n" . 
							$now_title  . "\r\n" . 
					  '</td>'  . "\r\n";
		}
		else
		{
			$str .= '<td align="center" width="10%" onclick="window.location.href=\'' . $now_url .'\'" class="bg_0" style="cursor:pointer" title="' . $now_tip . '" ' . "\r\n" . 
							'onmouseover="this.className=\'tableHeader\'" onmouseout="this.className=\'bg_0\'">' . "\r\n" . 
							$now_title . "\r\n" . 
					'</td>' . "\r\n";
		}
	}

	$html = '<table width="98%" border="0">' . "\r\n" . 
				'<tr class="bg_0">' . "\r\n" . 
					$str . "\r\n" .  
				'<td>&nbsp;&nbsp;</td>' . "\r\n" . 
				'</tr>' . "\r\n" . 
			'</table>' . "\r\n";

	return $html;
}

//创建任务系统管理目录
function taskSysMenu($id)
{
	$arr_task_sys_page = array(
			array('id' => '1', 'title' => '任务类型', 'tip' => '管理任务的类型', 'url' => 'task_sort_manage.php'), 
			array('id' => '2', 'title' => '任务', 'tip' => '管理任务对象', 'url' => 'task_normal_manage.php?action=admin'), 
					);

	$str = '';
	foreach ($arr_task_sys_page AS $task_sys_page)
	{
		$now_id = $task_sys_page['id'];
		$now_title = $task_sys_page['title'];
		$now_tip = $task_sys_page['tip'];
		$now_url = $task_sys_page['url'];

		if ($id == $now_id)
		{
			$str .= '<td align="center" width="10%" class="tableHeader" title="' . $now_tip . '">' . "\r\n" . 
							$now_title  . "\r\n" . 
					  '</td>'  . "\r\n";
		}
		else
		{
			$str .= '<td align="center" width="10%" onclick="window.location.href=\'' . $now_url .'\'" class="bg_0" style="cursor:pointer" title="' . $now_tip . '" ' . "\r\n" . 
							'onmouseover="this.className=\'tableHeader\'" onmouseout="this.className=\'bg_0\'">' . "\r\n" . 
							$now_title . "\r\n" . 
					'</td>' . "\r\n";
		}
	}

	$html = '<table width="98%" border="0">' . "\r\n" . 
				'<tr class="bg_0">' . "\r\n" . 
					$str . "\r\n" .  
				'<td>&nbsp;&nbsp;</td>' . "\r\n" . 
				'</tr>' . "\r\n" . 
			'</table>' . "\r\n";

	return $html;
}

//创建任务分类管理目录
function taskMenu($id)
{
	$arr_task_page = array(
			array('id' => '1', 'title' => '普通任务类', 'tip' => '管理普通任务', 'url' => 'task_normal_manage.php?action=admin&sort='.TASK_SORT_ID_FOR_NORMAL), 
			array('id' => '2', 'title' => '赏金任务类', 'tip' => '管理赏金任务', 'url' => 'task_normal_manage.php?action=admin&sort='.TASK_SORT_ID_FOR_REWARD), 
			array('id' => '3', 'title' => '全服任务类', 'tip' => '管理全服任务', 'url' => 'task_normal_manage.php?action=admin&sort='.TASK_SORT_ID_FOR_WHOLE_SERVER), 
					);

	$str = '';
	foreach ($arr_task_page AS $task_page)
	{
		$now_id = $task_page['id'];
		$now_title = $task_page['title'];
		$now_tip = $task_page['tip'];
		$now_url = $task_page['url'];

		if ($id == $now_id)
		{
			$str .= '<td align="center" width="10%" class="tableHeader" title="' . $now_tip . '">' . "\r\n" . 
							$now_title  . "\r\n" . 
					  '</td>'  . "\r\n";
		}
		else
		{
			$str .= '<td align="center" width="10%" onclick="window.location.href=\'' . $now_url .'\'" class="bg_0" style="cursor:pointer" title="' . $now_tip . '" ' . "\r\n" . 
							'onmouseover="this.className=\'tableHeader\'" onmouseout="this.className=\'bg_0\'">' . "\r\n" . 
							$now_title . "\r\n" . 
					'</td>' . "\r\n";
		}
	}

	$html = '<table width="98%" border="0">' . "\r\n" . 
				'<tr class="bg_0">' . "\r\n" . 
					$str . "\r\n" .  
				'<td>&nbsp;&nbsp;</td>' . "\r\n" . 
				'</tr>' . "\r\n" . 
			'</table>' . "\r\n";

	return $html;
}

//将每日任务子类转成html
function dailyTaskChildSort2HtmlSelected($default = '', $showNull = true, $disabled = false)
{
	global $_CONFIG_DAILY_TASK_SORT;
	$arr_child_sort = $_CONFIG_DAILY_TASK_SORT;

	if ($disabled)
		$state = 'disabled';
	else
		$state = '';

	$html = '<select id="child_task_sort_id" name="child_task_sort_id" ' . $state . '>' . "\r";
	foreach ($arr_child_sort AS $child_sort)
	{
		if ($default == $child_sort['id'])
			$selected = 'selected';
		else
			$selected = '';

		if (true == $showNull)
			$html .= '<option value="' . $child_sort['id'] . '" ' . $selected . '>' . $child_sort['title'] . '</option>' . "\r";
		else
		{
			if ('' != $child_sort['id'])
				$html .= '<option value="' . $child_sort['id'] . '" ' . $selected . '>' . $child_sort['title'] . '</option>' . "\r";
		}
	}
	$html .= '</select>' . "\r";

	return $html;
}

//将任务项完成条件分类转成html
function taskItemType2HtmlSelected($default = '', $showNull = true, $disabled = false)
{
	global $_CONFIG_TASK_ITEM_CONDITION_TYPE;
	$arr_condition_type = $_CONFIG_TASK_ITEM_CONDITION_TYPE;

	if ($disabled)
		$state = 'disabled';
	else
		$state = '';

	$html = '<select id="condition_type" name="condition_type" ' . $state . ' onchange="SelTaskItemTypeUpdate(this.options[this.options.selectedIndex].value);">' . "\r";
	foreach ($arr_condition_type AS $condtion_type)
	{
		if ($default == $condtion_type['id'])
			$selected = 'selected';
		else
			$selected = '';

		if (true == $showNull)
			$html .= '<option value="' . $condtion_type['id'] . '" ' . $selected . '>' . $condtion_type['title'] . '</option>' . "\r";
		else
		{
			if ('' != $condtion_type['id'])
				$html .= '<option value="' . $condtion_type['id'] . '" ' . $selected . '>' . $condtion_type['title'] . '</option>' . "\r";
		}
	}
	$html .= '</select>' . "\r";

	return $html;
}

//创建图片系统管理目录
function pictureSysMenu($id)
{
	$arr_picture_sys_page = array(
			array('id' => '1', 'title' => '图片类型', 'tip' => '管理图片的类型', 'url' => 'picture_sort_manage.php'), 
			array('id' => '2', 'title' => '已上传图片管理', 'tip' => '管理所有已被上传的图片', 'url' => 'picture_manage.php'), 
					);

	$str = '';
	foreach ($arr_picture_sys_page AS $picture_sys_page)
	{
		$now_id = $picture_sys_page['id'];
		$now_title = $picture_sys_page['title'];
		$now_tip = $picture_sys_page['tip'];
		$now_url = $picture_sys_page['url'];

		if ($id == $now_id)
		{
			$str .= '<td align="center" width="10%" class="tableHeader" title="' . $now_tip . '">' . "\r\n" . 
							$now_title  . "\r\n" . 
					  '</td>'  . "\r\n";
		}
		else
		{
			$str .= '<td align="center" width="10%" onclick="window.location.href=\'' . $now_url .'\'" class="bg_0" style="cursor:pointer" title="' . $now_tip . '" ' . "\r\n" . 
							'onmouseover="this.className=\'tableHeader\'" onmouseout="this.className=\'bg_0\'">' . "\r\n" . 
							$now_title . "\r\n" . 
					'</td>' . "\r\n";
		}
	}

	$html = '<table width="98%" border="0">' . "\r\n" . 
				'<tr class="bg_0">' . "\r\n" . 
					$str . "\r\n" .  
				'<td>&nbsp;&nbsp;</td>' . "\r\n" . 
				'</tr>' . "\r\n" . 
			'</table>' . "\r\n";

	return $html;
}

//将武器子类转成html
function weaponChildSort2HtmlSelected($default = '', $showNull = true, $disabled = false)
{
	global $CONFIG_EQUIP_WEAPON_CHILD_SORT;
	$arr_child_sort = $CONFIG_EQUIP_WEAPON_CHILD_SORT;

	if ($disabled)
		$state = 'disabled';
	else
		$state = '';

	$html = '<select id="SelWeaponChildSort" name="SelWeaponChildSort" ' . $state . '>' . "\r";
	foreach ($arr_child_sort AS $child_sort)
	{
		if ($default == $child_sort['id'])
			$selected = 'selected';
		else
			$selected = '';

		if (true == $showNull)
			$html .= '<option value="' . $child_sort['id'] . '" ' . $selected . '>' . $child_sort['title'] . '</option>' . "\r";
		else
		{
			if ('' != $child_sort['id'])
				$html .= '<option value="' . $child_sort['id'] . '" ' . $selected . '>' . $child_sort['title'] . '</option>' . "\r";
		}
	}
	$html .= '</select>' . "\r";

	return $html;
}
?>
