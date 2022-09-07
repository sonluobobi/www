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
});

function remove_item(id) 
{
	if (confirm("确实要删除这条数据吗？")) 
	{
		window.location.href= "backend_activity.php?method=remove&id=" + id;
	}
}

function publishSingleServer(id)
{
	var msg = "确认执行发布操作吗？";
	$('msg').style.display = 'none';
	if(confirm(msg))
	{
		$('waiting').style.display = '';

		var pars  = "method=publish&sync_type=single&id="+id;
		var url   = 'backend_activity.php';
		var vAjax = new Ajax.Request(
		url,
		{
			method: 'POST',
			parameters: pars,
		    onSuccess: function(result) 
		    {
		    	var response = result.responseText;
				$('waiting').style.display = 'none';
				$('msg').style.display = '';
				var msg_info = 'id=' + id + ' -- ' + response;
				$('msg').innerHTML = msg_info;
				alert(msg_info);
		    }
		});
	}
}

function showOrHide()
{
	var traget=document.getElementById('remark');  
    if(traget.style.display=="none"){  
        traget.style.display="";  
    }else{  
        traget.style.display="none";
    }
}

</script>
<style type="text/css">
#msg { padding:4px; margin-left:20px; background:#f6a828; color:#fff;}
</style>
<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableHeader">
	<td width="8%">&nbsp;&nbsp;<?php
echo $_obj['title'];
?>
管理&nbsp;&nbsp;</td>
	</tr>
</table>
<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="bg_0">
		<td align="right" width="5%">操作&nbsp;</td>
		<td>
			<?php
if ($_obj['show_add'] == "1"){
?>
			&nbsp;&nbsp;<input alt="backend_activity.php?method=edit&height=400&width=800&KeepThis=true&TB_iframe=true" class="thickbox" style="height:28px;width:120px;" type="button" id="btnAddMallItem" value="添加活动" />
			<?php
}
?>
			&nbsp;&nbsp;<input class="button_small" type="button" name="btnFresh" value="刷新本页" onclick="window.location.href='backend_activity.php?method=list';">
		</td>
	</tr>
	<tr class="bg_1">
		<td align="right" width="5%">备注&nbsp;</td>
		<td>
			<strong><font color="red" size="3">
			<span>只支持单记录发布，同时勾选全服时，只发布到所有正式服。</span><br/>
			<span>召唤池活动 ---- 记录开始结束时间必须包含抽奖池中配置的时间范围 </span><br/>
			<input type="button" value="其他说明--隐藏或者显示" onclick="showOrHide()">
			<div id="remark" style="display:">
			</div>
			</font></strong>
		</td>
	</tr>
	<tr class="bg_0">
		<td align="right" width="5%">发布结果&nbsp;</td>
		<td>
			<strong><font color="red" size="3"><span id="msg" style="display:none;"></span></font></strong>
		</td>
	</tr>
</table>

<table width="98%" border="0" cellspacing="1" cellpadding="8" id="waiting" style="display:none">
	<tr class="bg_0"><td align="center"><img src="images/waiting.gif"><font color="red">操作中,请稍候……</font></td></tr>
</table>

<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableHeader" align="center">
		<td>id</td>
		<td>标题</td>
		<td>活动类型</td>
		<td>开始时间</td>
		<td>结束时间</td>
		<td>角色等级下限</td>
		<td>角色等级上限</td>

		<td>发布服务器</td>
		<td>创建时间</td>
		<td>更新时间</td>
		<td>发布时间</td>
		<td>操作</td>
	</tr>
	<?php
if (!empty($_obj['arr_act_list'])){
if (!is_array($_obj['arr_act_list']))
$_obj['arr_act_list']=array(array('arr_act_list'=>$_obj['arr_act_list']));
$_tmp_arr_keys=array_keys($_obj['arr_act_list']);
if ($_tmp_arr_keys[0]!='0')
$_obj['arr_act_list']=array(0=>$_obj['arr_act_list']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['arr_act_list'] as $rowcnt=>$arr_act_list) {
$arr_act_list['ROWCNT']=$rowcnt+1;
$arr_act_list['ALTROW']=$rowcnt%2;
$arr_act_list['ROWBIT']=$rowcnt%2;
$_obj=&$arr_act_list;
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
echo $_obj['caption'];
?>
</td>
		<td align="center"><?php
echo $_obj['sort_id_title'];
?>
</td>
		<td align="center"><?php
echo $_obj['begin_date'];
?>
</td>
		<td align="center"><?php
echo $_obj['end_date'];
?>
</td>		
		<td align="center"><?php
echo $_obj['character_level_min'];
?>
</td>
		<td align="center"><?php
echo $_obj['character_level_max'];
?>
</td>
		<td align="center"><a href="#server-list" class="server-list">服务器</a><div class="server" style="display:none;"><?php
echo $_obj['server_ids'];
?>
</div></td>
		<td align="center"><?php
echo $_obj['created'];
?>
</td>	
		<td align="center"><?php
echo $_obj['updated'];
?>
</td>	
		<td align="center"><?php
echo $_obj['publish_date'];
?>
</td>	
		<td align="center">
			&nbsp;&nbsp;<input alt="backend_activity.php?method=edit&height=500&width=800&id=<?php
echo $_obj['id'];
?>
&KeepThis=true&TB_iframe=true" class="thickbox" type="button"  value="编辑" /> 
			<?php
if ($_obj['need_other_data'] == "1"){
?>
			&nbsp;&nbsp;<input alt="backend_activity.php?method=editOtherData&height=500&width=960&id=<?php
echo $_obj['id'];
?>
&KeepThis=true&TB_iframe=true" class="thickbox" type="button"  value="配置其他数据" /> 
			<?php
}
?>
			<?php
if ($_obj['show_publish'] == "1"){
?>
			&nbsp;&nbsp;<input type="button" class="button_small" style="width:80px;height:28px" onclick="publishSingleServer('<?php
echo $_obj['id'];
?>
')" value=" 发布 ">
			<?php
}
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
