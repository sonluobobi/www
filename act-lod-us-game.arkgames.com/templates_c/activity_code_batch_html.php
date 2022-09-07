<?php
echo $_obj['module_header'];
?>

<style type="text/css">
.labelbox {
 display:block;
 float:left;
 width:160px;
 border-bottom:1px solid #BBE4FD;
 margin-bottom:4px;
}

</style>
<script type="text/javascript">
jQuery(function($) {

	function update_status()
	{
		$(".type-gift-pack").autocomplete("equip_api.php?opt=equip", {
			width: 200,
			autoFill: true,
			matchContains: false,
			max:30
		});
		$('.drop-row').click(function(){
			$(this).parent().parent().remove();
		});
	}
	update_status();
	
	count_reward = 5;	
	
	$('#btnAddReward').click(function() 
	{
		rs_reward_txt = 			
		'<tr class="bg_0"><td>' +
		  	'&nbsp;&nbsp;&nbsp;礼包道具'+count_reward+':&nbsp;<input type="text" class="type-gift-pack" name="gift_pack_id[]" id="gift_pack_id_'+count_reward+'" size="30">'+
		  	'&nbsp;&nbsp;数量:&nbsp;<input type="text" class="onlynum" name="gift_pack_num[]" id="gift_pack_num_'+count_reward+'" size="2">'+ 
		  	'&nbsp;&nbsp;<a href="#" class="drop-row"><img src="images/b_drop.png" border="0" alt="删除该道具" /></a>' + 
		'</td></tr>';		
		$('#addReward').after(rs_reward_txt);
		count_reward = count_reward + 1;
		update_status();
	});

	$(".dateSelect").datepicker({
	dateFormat: 'yy-mm-dd', showOn: 'button', buttonImage: 'images/calendar.gif', buttonImageOnly: true
	});

	$('#publishKLServer').click
	(
			function() 
			{
				$('#msg').text('正在发布同步活动...');
				$('#msg').show();			
				$.ajax
				({
					type: "POST",
					url: "publish_data.php",
					data: "publish_type=act_code&sync_type=all",
					success: function(msg) 
					{
						var myDate=new Date();
						var dateString =" " + myDate.getFullYear() + "-" + (myDate.getMonth() + 1) + "-" + myDate.getDate() + 
										" " + myDate.getHours() + ":" + myDate.getMinutes() + ":" + myDate.getSeconds();
						if (msg=='') 
						{
							$('#msg').text("活动发布失败！" + dateString);
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

function share_item(id, dom) 
{
	var vars = "c=ActCode&a=ShareBatch&batch_id=" + id + "&t=<?php
echo $_obj['t'];
?>
&s=<?php
echo $_obj['s'];
?>
&author=<?php
echo $_obj['author'];
?>
";
	if (confirm("确实要同步这条数据吗？")) {
		jQuery(dom).disabled = true;	
		$('msg_share').style.display = '';
		jQuery.ajax({
			type:"GET",
			url:"interface.php",
			data:vars,
			success: function(msg) {
				jQuery(dom).disabled = false;
				$('msg_share').style.display = 'none';
				alert(msg);
				window.location.reload();
			}
		});
	}
}
</script>
<div id="batch_info" style="display:none">
<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableHeader"><td>&nbsp;&nbsp;激活码批次信息管理</td></tr>
</table>
<table width="98%" border="0" cellspacing="1" cellpadding="8">
		
	<tr class="bg_0">
		<td colspan="6" align="center"><font color="red" size="4">&nbsp;&nbsp;本页面的激活码生成仅供测试使用,有新的激活码需求请联系技术人员&nbsp;
			
			</font>
		</td>
	</tr>
		
	<tr class="bg_0">
		<td align="left">
	    <!--  
		&nbsp;图片资源&nbsp;
		&nbsp;<select id="res_id">
		<?php
if (!empty($_obj['pic_res_list'])){
if (!is_array($_obj['pic_res_list']))
$_obj['pic_res_list']=array(array('pic_res_list'=>$_obj['pic_res_list']));
$_tmp_arr_keys=array_keys($_obj['pic_res_list']);
if ($_tmp_arr_keys[0]!='0')
$_obj['pic_res_list']=array(0=>$_obj['pic_res_list']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['pic_res_list'] as $rowcnt=>$pic_res_list) {
$pic_res_list['ROWCNT']=$rowcnt+1;
$pic_res_list['ALTROW']=$rowcnt%2;
$pic_res_list['ROWBIT']=$rowcnt%2;
$_obj=&$pic_res_list;
?>
		<option value="<?php
echo $_obj['id'];
?>
"><?php
echo $_obj['title'];
?>
</option>
		<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
		<option value="0">无</option>  
		</select>
		-->
		<input type="hidden" name="pack_num" id="pack_num" value="<?php
echo $_obj['pack_num'];
?>
"></input>
		<input type="hidden" name="batch_id" id="batch_id" value="<?php
echo $_obj['batch_item']['id'];
?>
"></input>
		批次名称:&nbsp;<input type="text" name="title" id="title" value="<?php
echo $_obj['batch_item']['title'];
?>
" size="30">&nbsp;&nbsp;
		<!--  前缀(2个字母):&nbsp;<input type="text" name="activation_prefix" id="activation_prefix" value="" size="8" >&nbsp;&nbsp; 
		生成数量:&nbsp;<input type="text" class="onlynum" name="num" id="num" value="" size="12" maxlength="6">&nbsp;&nbsp;-->
		有效开始时间:&nbsp;<input type="text" class="onlynum dateSelect" name="start_time" id="start_time" value="<?php
echo $_obj['batch_item']['start_time'];
?>
" size="20" maxlength="14">&nbsp;&nbsp;
		有效结束时间:&nbsp;<input type="text" class="onlynum dateSelect" name="end_time" id="end_time" value="<?php
echo $_obj['batch_item']['end_time'];
?>
" size="20" maxlength="14">&nbsp;&nbsp;
	
		</td>
	</tr>
		
	<tr class="bg_0">
		<td>&nbsp;&nbsp;
		玩家等级:&nbsp;下限<input type="text" name="character_level_min" id="character_level_min" size="4" value="<?php
echo $_obj['batch_item']['character_level_min'];
?>
" />&nbsp;上限<input type="text" name="character_level_max" id="character_level_max" size="4" value="<?php
echo $_obj['batch_item']['character_level_max'];
?>
" />&nbsp;
		领取限制:&nbsp;<input type="text" name="use_num_pre" id="use_num_pre" size="4" value="<?php
echo $_obj['batch_item']['use_num_pre'];
?>
" />（每人可使用次数（0：不限制）&nbsp;
		是否限制角色:&nbsp;<input type="text" name="is_limit_character" id="is_limit_character" size="4" value="<?php
echo $_obj['batch_item']['is_limit_character'];
?>
" />&nbsp;（0：不限制角色，限制player_id，1：限制角色，不限制player_id）
		</td>
	</tr>
	<tr class="bg_0">
		<td>
			所有人使用限制:&nbsp;<input type="text" name="is_global_use" id="is_global_use" size="4" value="<?php
echo $_obj['batch_item']['is_global_use'];
?>
" />&nbsp;（-1:所有人可用; 0:不限制; >0:累积可被使用次数）
			&nbsp;选择渠道:&nbsp;<select name="channel" id="channel" >
			<?php
if (!empty($_obj['channel_map'])){
if (!is_array($_obj['channel_map']))
$_obj['channel_map']=array(array('channel_map'=>$_obj['channel_map']));
$_tmp_arr_keys=array_keys($_obj['channel_map']);
if ($_tmp_arr_keys[0]!='0')
$_obj['channel_map']=array(0=>$_obj['channel_map']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['channel_map'] as $rowcnt=>$channel_map) {
$channel_map['ROWCNT']=$rowcnt+1;
$channel_map['ALTROW']=$rowcnt%2;
$channel_map['ROWBIT']=$rowcnt%2;
$_obj=&$channel_map;
?>
				<?php
if ($_obj['hit'] == "1"){
?>
				<option value="<?php
echo $_obj['id'];
?>
" selected="selected"><?php
echo $_obj['title'];
?>
</option>
				<?php
} else {
?>
				<option value="<?php
echo $_obj['id'];
?>
"><?php
echo $_obj['title'];
?>
</option>
				<?php
}
?>
			<?php
}
$_obj=$_stack[--$_stack_cnt];}
?></select>
		</td>
	</tr>
	<tr class="tableHeader">
	<td  colspan="2">
		<label style="width:100px;">选择服务器</label>
	</td>
	</tr>
	<?php
if (!empty($_obj['serv_list'])){
if (!is_array($_obj['serv_list']))
$_obj['serv_list']=array(array('serv_list'=>$_obj['serv_list']));
$_tmp_arr_keys=array_keys($_obj['serv_list']);
if ($_tmp_arr_keys[0]!='0')
$_obj['serv_list']=array(0=>$_obj['serv_list']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['serv_list'] as $rowcnt=>$serv_list) {
$serv_list['ROWCNT']=$rowcnt+1;
$serv_list['ALTROW']=$rowcnt%2;
$serv_list['ROWBIT']=$rowcnt%2;
$_obj=&$serv_list;
?>
	<tr class="bg_<?php
echo $_obj['ROWBIT'];
?>
">
		<td>
			<label class="labelbox"><input type="checkbox"     id="id_<?php
echo $_obj['server_name'];
?>
" name="<?php
echo $_obj['server_name'];
?>
" value="<?php
echo $_obj['server_name'];
?>
" class="serverBox" onclick="selectServerItem(this)" /><?php
echo $_obj['title'];
?>
</label>

			<?php
if (!empty($_obj['server_ids'])){
if (!is_array($_obj['server_ids']))
$_obj['server_ids']=array(array('server_ids'=>$_obj['server_ids']));
$_tmp_arr_keys=array_keys($_obj['server_ids']);
if ($_tmp_arr_keys[0]!='0')
$_obj['server_ids']=array(0=>$_obj['server_ids']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['server_ids'] as $rowcnt=>$server_ids) {
$server_ids['ROWCNT']=$rowcnt+1;
$server_ids['ALTROW']=$rowcnt%2;
$server_ids['ROWBIT']=$rowcnt%2;
$_obj=&$server_ids;
?>
				<?php
if ($_obj['hit'] == "1"){
?>
					<label class="labelbox"><input type="checkbox" checked="checked" id="id_<?php
echo $_stack[$_stack_cnt-1]['server_name'];
?>
_<?php
echo $_obj['serv_id'];
?>
" name="server_ids[]" value="<?php
echo $_obj['serv_id'];
?>
" class="serverBox"  onclick="selectServer(this)"/><?php
echo $_obj['serv_name'];
?>
</label>
				<?php
} else {
?>
					<label class="labelbox"><input type="checkbox"  id="id_<?php
echo $_stack[$_stack_cnt-1]['server_name'];
?>
_<?php
echo $_obj['serv_id'];
?>
" name="server_ids[]" value="<?php
echo $_obj['serv_id'];
?>
" class="serverBox"  onclick="selectServer(this)"/><?php
echo $_obj['serv_name'];
?>
</label>
				<?php
}
?>

			<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
		</td>		
	</tr>
	<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
    
	
	<?php
if ($_obj['pack_num'] != "0"){
?>
	
	<?php
if (!empty($_obj['pack_list'])){
if (!is_array($_obj['pack_list']))
$_obj['pack_list']=array(array('pack_list'=>$_obj['pack_list']));
$_tmp_arr_keys=array_keys($_obj['pack_list']);
if ($_tmp_arr_keys[0]!='0')
$_obj['pack_list']=array(0=>$_obj['pack_list']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['pack_list'] as $rowcnt=>$pack_list) {
$pack_list['ROWCNT']=$rowcnt+1;
$pack_list['ALTROW']=$rowcnt%2;
$pack_list['ROWBIT']=$rowcnt%2;
$_obj=&$pack_list;
?>
	<tr class="bg_0" id="addReward">
			<td>&nbsp;&nbsp;
			礼包道具<?php
echo $_obj['id'];
?>
:&nbsp;<input type="text" class="type-gift-pack" name="gift_pack_id[]" id="gift_pack_id_<?php
echo $_obj['id'];
?>
" size="30" value="<?php
echo $_obj['equip_id'];
?>
">
			&nbsp;数量:&nbsp;<input type="text" name="gift_pack_num[]" id="gift_pack_num_<?php
echo $_obj['id'];
?>
" size="2" value="<?php
echo $_obj['equip_num'];
?>
">
			&nbsp;&nbsp;<input class="button_small" type="button" value="追加礼包道具" id="btnAddReward">
			&nbsp;&nbsp;<a href="#" class="drop-row"><img src="images/b_drop.png" border="0" alt="删除该道具" /></a>
		</td>
	</tr>
	<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
	
	<?php
} else {
?>
	
	<tr class="bg_0" id="addReward">
		<td>&nbsp;&nbsp;
			礼包道具1:&nbsp;<input type="text" class="type-gift-pack" name="gift_pack_id[]" id="gift_pack_id_1" size="30">
			&nbsp;数量:&nbsp;<input type="text" name="gift_pack_num[]" id="gift_pack_num_1" size="2">
			&nbsp;&nbsp;<input class="button_small" type="button" value="追加礼包道具" id="btnAddReward">
		</td>
	</tr>
	
	<?php
}
?>
	<tr class="bg_0">
		<td align='center'>
		<?php
if ($_obj['is_edit'] == "1"){
?>
			<input class="button_big" type="button" id="btnCreate" value="保存修改" onclick="createInvitationCode()">
		<?php
} else {
?>
			<input class="button_big" type="button" id="btnCreate" value="生成激活码" onclick="createInvitationCode()">
		<?php
}
?>
        </td>	
	</tr>
</table>
</div>

<table width="98%" border="0" cellspacing="1" cellpadding="8" id="tblWaiting" style="display:none">
	<tr class="bg_0"><td align="center"><img src="images/waiting.gif"><font color="red">正在修改激活码批次信息,请稍候……</font></td></tr>
</table>
<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableHeader"><td>&nbsp;&nbsp;激活码批次信息管理</td></tr>
</table>
<table width="98%" border="0" cellspacing="1" cellpadding="8" id="msg_share" style="display:none">
	<tr class="bg_0"><td align="center"><img src="images/waiting.gif"><font color="red">正在共享激活码,请稍候……</font></td></tr>
</table>

<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<form action="" method="POST" name="FrmSearch">
	<tr class="bg_0">
		<td align="right" width="7%">批次&nbsp;</td>
		<td width="10%">
			&nbsp;<input type="text" name="batch_title" id="batch_title_id" value="<?php
echo $_obj['batch_title_value'];
?>
" size="14">
		</td>
		<td align="right" width="7%">前缀&nbsp;</td>
		<td width="10%">
			&nbsp;<input type="text" name="activation_prefix" id="activation_prefix" value="<?php
echo $_obj['activation_prefix'];
?>
" size="14">
		</td>
		
		<td>&nbsp;<input class="button_small" type="submit" id="subSearch" value=" 查 询 "></td>
	</tr>
	</form>
</table>
<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableHeader" align="center">
		<td width="5%">ID</td>
		<td width="6%">批次</td>
		<td width="3%">前缀</td>
		<td width="30%">礼包</td>
		<td width="6%">等级限制</td>
		<td width="4%">次数限制</td>
		<td width="5%">限制(角色/账号)</td>
		<td width="10%">有效服务器</td>
		<td width="8%">开始时间</td>
		<td width="8%">结束时间</td>
        <td width="5%">批次类型</td>
		<td width="10%">操作</td>
		
	</tr>
	<?php
if (!empty($_obj['arr_invitation_code_list'])){
if (!is_array($_obj['arr_invitation_code_list']))
$_obj['arr_invitation_code_list']=array(array('arr_invitation_code_list'=>$_obj['arr_invitation_code_list']));
$_tmp_arr_keys=array_keys($_obj['arr_invitation_code_list']);
if ($_tmp_arr_keys[0]!='0')
$_obj['arr_invitation_code_list']=array(0=>$_obj['arr_invitation_code_list']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['arr_invitation_code_list'] as $rowcnt=>$arr_invitation_code_list) {
$arr_invitation_code_list['ROWCNT']=$rowcnt+1;
$arr_invitation_code_list['ALTROW']=$rowcnt%2;
$arr_invitation_code_list['ROWBIT']=$rowcnt%2;
$_obj=&$arr_invitation_code_list;
?>
	<tr class="bg_<?php
echo $_obj['ROWBIT'];
?>
" align="center">
		<td><?php
echo $_obj['id'];
?>
</td>
		<td><a href="codeListByBatch.php?height=1500&width=800&batch_id=<?php
echo $_obj['id'];
?>
&title=<?php
echo $_obj['title'];
?>
"  target="_blank"><?php
echo $_obj['title'];
?>
</a></td>
		<td><?php
echo $_obj['activation_prefix'];
?>
</td>
		<td><?php
echo $_obj['gift_pack'];
?>
</td>
		<td><?php
echo $_obj['character_level_min'];
?>
-<?php
echo $_obj['character_level_max'];
?>
</td>
		<td><?php
echo $_obj['use_num_pre'];
?>
</td>
		<td><?php
echo $_obj['is_limit_character'];
?>
</td>
		<td><?php
echo $_obj['server_ids'];
?>
</td>
		<td>&nbsp;<?php
echo $_obj['start_time'];
?>
</td>
		<td>&nbsp;<?php
echo $_obj['end_time'];
?>
</td>
        <td><?php
echo $_obj['batch_type'];
?>
</td>
		<td align="center">
			<a href="activity_code_batch.php?opt=edit&id=<?php
echo $_obj['id'];
?>
">修改</a> 
			<?php
if ($_obj['sync_status'] == "2"){
?>
			<input type="button" onclick="share_item(<?php
echo $_obj['id'];
?>
, this)" value="大区共享" id="share_<?php
echo $_obj['id'];
?>
"/>
			<?php
}
?>
			<!-- <input type="button" onclick="remove_item(<?php
echo $_obj['id'];
?>
)" value="删除" />  -->

			<a target="_blank" href="act_code_use_export.php?method=export&batch_id=<?php
echo $_obj['id'];
?>
">导出使用记录</a> 
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

<script language="javascript">

function checkBatchInfo()
{
	if($F('batch_id') > 0)
	{
		document.getElementById('batch_info').style.display= "";
	}
	else
	{
		document.getElementById('batch_info').style.display= "none";
	}
}

function checkCodePrefix(str)
{
	if(str.length !=2)
	{
		alert('激活码前缀必须是2个字符');
		Field.focus('activation_prefix');
		Field.select('activation_prefix');
		return false;
	}
	
}
function appendInvitationCode()
{
	var title = $F('title');
	var num = $F('num');
	var start_time = $F('start_time');
	var end_time = $F('end_time');
	
	if ('' == trim(title))
	{
		alert("请先输入批次名！");
		Field.focus('title');
		Field.select('title');
		return false;
	}

	if ('' == trim(num))
	{
		alert("请先输入要追加的数量！");
		Field.focus('num');
		Field.select('num');
		return false;
	}

	if ('' == trim(start_time))
	{
		alert("请先输入有效开始时间！");
		Field.focus('start_time');
		Field.select('start_time');
		return false;
	}

	if ('' == trim(end_time))
	{
		alert("请先输入有效结束时间！");
		Field.focus('end_time');
		Field.select('end_time');
		return false;
	}

	var prefix = $F('activation_prefix');
	
	$('btnCreate').disabled = true;
	$('subSearch').disabled = true;
	$('tblWaiting').style.display = '';

	var pars  = 'num=' + num + '&title=' + title + '&activation_prefix='  + prefix + 
	'&start_time=' + start_time + '&end_time='+ end_time  +
	'&opt=appendInvitationCode';
	var url   = 'activity_code_batch.php';
	var vAjax = new Ajax.Request(
	url,
	{
	method: 'post',
	parameters: pars,
	onSuccess: function(result) {
		var response = result.responseText;
		
		$('btnCreate').disabled = false;
		$('subSearch').disabled = false;
		$('tblWaiting').style.display = 'none';
		
		if (response == 'sucessed')
		{
			alert("追加激活码成功！");
			document.location.reload(true);
		}
		else if(response == 'false')
		{
			alert("追加激活码失败！");
		}
		else
		{
			alert(response);
		}
	}
	}
	);
	
}


function createInvitationCode()
{
	//var resource_id = $F('res_id');  
	var batch_id = $F('batch_id');
	var title = $F('title');
	
	var start_time = $F('start_time');
	var end_time = $F('end_time');
	
	var gift_pack_id = $F('gift_pack_id_1');
	var gift_pack_num = $F('gift_pack_num_1');
	var character_level_max = $F('character_level_max');
	var character_level_min = $F('character_level_min');
	var use_num_pre = $F('use_num_pre');
	var is_limit_character    = $F('is_limit_character');
	var is_global_use = $F('is_global_use');
	var channel = $F('channel');
	
	if ('' == trim(title))
	{
		alert("请先输入批次名！");
		Field.focus('title');
		Field.select('title');
		return false;
	}
	
	if ('' == trim(start_time))
	{
		alert("请先输入有效开始时间！");
		Field.focus('start_time');
		Field.select('start_time');
		return false;
	}

	if ('' == trim(end_time))
	{
		alert("请先输入有效结束时间！");
		Field.focus('end_time');
		Field.select('end_time');
		return false;
	}

	
	var server_ids = '';
	var boxs = document.getElementsByName('server_ids[]');
	var len = boxs.length;
	for(var i=0;i<len;++i)
	{
		if(boxs[i].checked == true)
		{
			server_ids += boxs[i].value + ',';
		}
	}
	if ('' == server_ids)
	{
		alert("请选择服务器！");
		return false;
	}
	
    /*
	$('btnCreate').disabled = true;
	$('subSearch').disabled = true;
	$('tblWaiting').style.display = '';
    */

    //检查礼包道具和道具数量
    var gift_pack_id_arr  = document.getElementsByName('gift_pack_id[]');
    var gift_pack_num_arr = document.getElementsByName('gift_pack_num[]');
    var pack_equip_size   = gift_pack_id_arr.length;
    
    var gift_pack_content = "";

    for(var k=0;k<pack_equip_size;k++)
    {
        var tmp_value = gift_pack_id_arr[k].value;
        var tmp_equip_arr = tmp_value.split(',');

        if(tmp_equip_arr.length != 2)
        {
            alert("礼包道具配置错误，正确格式:道具名称,道具ID");
            return false;
        }

        if(tmp_equip_arr[0] =='' || tmp_equip_arr[1] <=0 )
        {
            alert("礼包道具配置错误，正确格式:道具名称,道具ID");
            return false;
        }

        if(gift_pack_num_arr[k].value <=0 )
        {
            alert("礼包道具数量必须大于零");
            return false;
        }

        if(k < (pack_equip_size-1)) {
            gift_pack_content +=  tmp_value+","+gift_pack_num_arr[k].value+ '|';
        }else {
            gift_pack_content +=  tmp_value+","+gift_pack_num_arr[k].value;
        }
    }
	

	var pars  = 'title=' + title + 
				'&gift_pack_id=' + gift_pack_content + '&server_ids=' + server_ids + 
				'&start_time=' + start_time + '&end_time=' + end_time + '&character_level_max=' + character_level_max + 
				'&character_level_min=' + character_level_min + '&use_num_pre=' + use_num_pre + '&is_limit_character=' + is_limit_character + '&is_global_use=' + is_global_use +
				
				'&batch_id=' + batch_id + '&channel=' + channel +
				'&opt=save';
	var url   = 'activity_code_batch.php';
	var vAjax = new Ajax.Request(
		url,
		{
			method: 'POST',
			parameters: pars,
		    onSuccess: function(result) {
				var response = result.responseText;
				
				$('btnCreate').disabled = false;
				$('subSearch').disabled = false;
				$('tblWaiting').style.display = 'none';
				
				if (response == 'sucessed')
				{
					alert("修改成功！");
					document.location.reload(true);
				}
				else if(response == 'false')
				{
					alert("修改失败！");
				}
				else
				{
					alert(response);
				}
		    }
		}
	);
}

checkBatchInfo();

function selectServerItem(box)
{
	var id = box.id;
	var boxs = document.getElementsByTagName('input');
	var len = boxs.length;
	for(var i=0;i<len;++i)
	{
		var sub_id = boxs[i].id;
	
		if((sub_id.indexOf(id,0) == 0 && sub_id.length == id.length) || sub_id.indexOf(id+'_',0) == 0)
		{
			boxs[i].checked = box.checked;
		}
		
	}
	
	if(!box.checked)
	{
		document.getElementById('selectAll').checked = false;
	}	
	
}

function selectServer(obj) {
	if(!obj.checked) 
	{
		jQuery('#selectAll').attr('checked', false);
		var tmp_id = obj.id;
		currentIdArr = tmp_id.split('_');
		var type_id = currentIdArr[0]+"_"+currentIdArr[1];
		jQuery('#'+type_id).attr('checked', false);
	}
	else 
	{
		var root = this;
		root.isAll = '';
		jQuery('.serverBox').each(function (index) {
			if(!jQuery(this).attr('checked')) {
				root.isAll = 'noooo';
				//alert(root.isAll);
				return false;
			}
		});
		if(root.isAll=='') jQuery('#selectAll').attr('checked', true);
	}
}

</script>