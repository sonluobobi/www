<?php
echo $_obj['module_header'];
?>

<script type="text/javascript">
jQuery(function($)
{
	$('.server-list').tooltip
	(
		{
			bodyHandler: function() 
			{ 
        		return $(this).parent().find(".server").html(); 
	    	}, 
	    	showURL: false 
		}
	);

	$('#auto_sync').click
	(
			function() 
			{
				$('#msg').text('正在执行同步...');
				$('#msg').show();	
					
				$.ajax
				({
					type: "POST",
					url: "game_equip.php",
					data: "method=auto_sync",
					success: function(msg) 
					{
						var myDate=new Date();
						var dateString =" " + myDate.getFullYear() + "-" + (myDate.getMonth() + 1) + "-" + myDate.getDate() + 
										" " + myDate.getHours() + ":" + myDate.getMinutes() + ":" + myDate.getSeconds();
						if (msg=='') 
						{
							$('#msg').text("同步失败 !" + dateString);
						} else 
						{
							$('#msg').text(msg + dateString);
						}
						
						$('#msg').fadeOut(10000); 
					}
				});
			}
	);

});

</script>
<style type="text/css">
#msg { padding:4px; margin-left:20px; background:#f6a828; color:#fff;}
</style>
<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableHeader">
	<td width="8%">&nbsp;&nbsp;更新游戏道具信息</td>
	</tr>
</table>

<form action="game_equip.php" method="POST" enctype="multipart/form-data" name="update">
<input type="hidden" name="method" value="update"></input>
<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="bg_0">
		<td align="center" width="50%" colspan="2">
		
			&nbsp;&nbsp;上传道具CSV文件：<input type="file" name="file" id="file"></input>
			
			&nbsp;&nbsp;<input type="submit" name="update_equip" id="update_equip" class="button_small"  value="更 新" />
		</td>
	</tr>
	<tr class="bg_1">
		<td align="right" width="10%"><input class="button_big" type="button" style="width:180px;" id="auto_sync" value="从游戏服获取道具列表" />&nbsp;&nbsp;操作结果&nbsp;</td>
		<td>
			<strong><font color="red" size="3"><span id="msg" style="display:block;"><?php
echo $_obj['msg'];
?>
</span></font></strong>
		</td>
	</tr>
</table>
</form>

<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableHeader"><td>&nbsp;&nbsp;搜索(道具名称支持模糊搜索)</td></tr>
</table>
<form action="game_equip.php" method="POST" name="FrmSearch">
	<input type="hidden" name="method" value="search"></input>
		
	<table width="98%" border="0" cellspacing="1" cellpadding="8">		
		<tr class="bg_0" >
			<td width="15%">&nbsp;&nbsp;道具ID:&nbsp;<input type="text" class="onlynum" name="equip_id" id="equip_id" value="<?php
echo $_obj['equip_id'];
?>
" size="14"></td>
			
			<td width="23%">&nbsp;&nbsp;道具名称:&nbsp;<input type="text" name="equip_title" id="equip_title" value="<?php
echo $_obj['equip_title'];
?>
" size="30"></td>	
			
			<td>				
				&nbsp;&nbsp;<input type="submit" id="subSearch" class="button_small" value=" 查 询 ">
				&nbsp;&nbsp;<input type="button" name="btnFresh" class="button_small" value="刷新本页" onclick="window.location.href='game_equip.php?method=list';">
			</td>
		</tr>
	</table>
</form>

<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableHeader" align="center">
		<td width="10%">道具ID</td>
		<td width="10%">道具名称</td>
		<td width="5%">堆叠数</td>
		<td width="5%">品阶颜色</td>
		<td width="5%">是否跟踪</td>
		<td width="60%">介绍</td>
		
	</tr>
	<?php
if (!empty($_obj['equip_list'])){
if (!is_array($_obj['equip_list']))
$_obj['equip_list']=array(array('equip_list'=>$_obj['equip_list']));
$_tmp_arr_keys=array_keys($_obj['equip_list']);
if ($_tmp_arr_keys[0]!='0')
$_obj['equip_list']=array(0=>$_obj['equip_list']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['equip_list'] as $rowcnt=>$equip_list) {
$equip_list['ROWCNT']=$rowcnt+1;
$equip_list['ALTROW']=$rowcnt%2;
$equip_list['ROWBIT']=$rowcnt%2;
$_obj=&$equip_list;
?>
	<tr class="bg_<?php
echo $_obj['ROWBIT'];
?>
">
		<td align="center"><?php
echo $_obj['id'];
?>
</td>
		<td align="center"><?php
echo $_obj['title'];
?>
</td>
		<td align="center"><?php
echo $_obj['stack_num'];
?>
</td>
		<td align="center"><?php
echo $_obj['quality'];
?>
</td>
		<td align="center"><?php
echo $_obj['need_trace'];
?>
</td>
		<td align="center"><?php
echo $_obj['intro'];
?>
</td>
		
	</tr>
	<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
</table>
<table width="98%" border="0" cellspacing="1" cellpadding="3" class="pageNav">
	<tr>
		<td>共 <strong><?php
echo $_obj['total'];
?>
</strong>, 显示 <strong><?php
echo $_obj['from'];
?>
 - <?php
echo $_obj['to'];
?>
</strong></td>
		<td align="right"><?php
echo $_obj['pagenav'];
?>
</td>
	</tr>
</table>
<?php
echo $_obj['module_footer'];
?>
