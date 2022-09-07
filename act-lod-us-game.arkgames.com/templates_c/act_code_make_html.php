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

		count_reward = 2;
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
					$('#msg').text('正在发布活动...');
					$('#msg').show();
					$('#syncTestServer').hide();
					$('#publishKLServer').hide();
					$('#publishUnionServer').hide();
					$.ajax
					({
						type: "POST",
						url: "publish_data.php",
						data: "publish_type=act_code&sync_type=offical",
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
							$('#msg').fadeOut(50000);
							$('#syncTestServer').show();
							$('#publishKLServer').show();
							$('#publishUnionServer').show();
						}
					});
				}
		);

		$('#publishUnionServer').click
		(
				function()
				{
					$('#msg').text('正在发布活动...');
					$('#msg').show();
					$('#syncTestServer').hide();
					$('#publishKLServer').hide();
					$('#publishUnionServer').hide();
					$.ajax
					({
						type: "POST",
						url: "publish_data.php",
						data: "publish_type=act_code&sync_type=union",
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

							$('#msg').fadeOut(50000);
							$('#syncTestServer').show();
							$('#publishKLServer').show();
							$('#publishUnionServer').show();
						}
					});
				}
		);

		$('#publishTestServer').click
		(
				function()
				{
					$('#msg').text('正在发布活动...');
					$('#msg').show();
					$('#syncTestServer').hide();
					$('#publishKLServer').hide();
					$('#publishUnionServer').hide();
					$.ajax
					({
						type: "POST",
						url: "publish_data.php",
						data: "publish_type=act_code&sync_type=test",
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
							$('#msg').fadeOut(50000);
							$('#syncTestServer').show();
							$('#publishKLServer').show();
							$('#publishUnionServer').show();
						}
					});
				}
		);


	});
</script>
<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableHeader">
		<td colspan="2">
			&nbsp;&nbsp;激活码管理
		</td>
		<!--	<tr class="bg_1">
                <td align="left" colspan="2">
                        <input  class="button_big" type="button" name="publishTestServer" id="publishTestServer" value="发布到测试服"/>
                     <input  class="button_big" type="button" name="publishKLServer" id="publishKLServer" value="发布到官服"/>
                </td>
            </tr>
            <tr class="bg_1">
                <td align="right" width="5%">发布结果&nbsp;</td>
                <td>
                    <strong><font color="red" size="3"><span id="msg" style="display:none;"></span></font></strong>
                </td>

            </tr>-->
</table>
<form action="" method="POST" name="add_code" onsubmit=" return checkForm();">
	<table width="98%" border="0" cellspacing="1" cellpadding="8">
		<tr class="bg_0">
			<td align="left">
				批次名称:&nbsp;<input type="text" name="title" id="title" value="<?php
echo $_obj['title'];
?>
" size="18">&nbsp;&nbsp;
				生成数量:&nbsp;<input type="text" class="onlynum" name="num" id="num" value="<?php
echo $_obj['num'];
?>
" size="12" maxlength="6">（上限：<?php
echo $_obj['code_max'];
?>
）&nbsp;&nbsp;
				有效开始时间:&nbsp;<input type="text" class="onlynum dateSelect" name="start_time" id="start_time" value="<?php
echo $_obj['start_time'];
?>
" size="20" maxlength="14">&nbsp;&nbsp;
				有效结束时间:&nbsp;<input type="text" class="onlynum dateSelect" name="end_time" id="end_time" value="<?php
echo $_obj['end_time'];
?>
" onchange="show_time_tips();" size="20" maxlength="14">&nbsp;&nbsp;
				<font color="red" size="3">日期统一以 00:00:00 结算</font>&nbsp;&nbsp;
				<font color="red" size="3"><div id="div_time"></div></font>
			</td>
		</tr>

		<tr class="bg_0">
			<td>
				玩家等级:&nbsp;下限<input type="text" name="character_level_min" id="character_level_min" size="4" value="1" />&nbsp;上限<input type="text" name="character_level_max" id="character_level_max" size="4" value="300" />&nbsp;
				领取限制:&nbsp;<input type="text" name="use_num_pre" id="use_num_pre" size="4" value="1" />（默认只能使用1次，需要多次需要把批次告知开发）&nbsp;
				是否限制角色:&nbsp;<input type="text" name="is_limit_character" id="is_limit_character" size="4" value="1" />&nbsp;（0：不限制角色，限制player_id，1：限制角色，不限制player_id）
			</td>
		</tr>
		<tr class="bg_0">
			<td>
				所有人使用限制:&nbsp;<input type="text" name="is_global_use" id="is_global_use" size="4" value="0" />&nbsp;（-1:所有人可用; 0:不限制; >0:累积可被使用次数）
				&nbsp;选择渠道:&nbsp;<select name="channel" id="channel" ><?php
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
?><option value="<?php
echo $_obj['id'];
?>
"><?php
echo $_obj['title'];
?>
</option><?php
}
$_obj=$_stack[--$_stack_cnt];}
?></select>
				&nbsp;<font color="red" size="3">批次类型:</font>&nbsp;<select name="batch_type" id="batch_type" ><?php
if (!empty($_obj['batch_type_map'])){
if (!is_array($_obj['batch_type_map']))
$_obj['batch_type_map']=array(array('batch_type_map'=>$_obj['batch_type_map']));
$_tmp_arr_keys=array_keys($_obj['batch_type_map']);
if ($_tmp_arr_keys[0]!='0')
$_obj['batch_type_map']=array(0=>$_obj['batch_type_map']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['batch_type_map'] as $rowcnt=>$batch_type_map) {
$batch_type_map['ROWCNT']=$rowcnt+1;
$batch_type_map['ALTROW']=$rowcnt%2;
$batch_type_map['ROWBIT']=$rowcnt%2;
$_obj=&$batch_type_map;
?><option value="<?php
echo $_obj['id'];
?>
"><?php
echo $_obj['title'];
?>
</option><?php
}
$_obj=$_stack[--$_stack_cnt];}
?></select>
			</td>
		</tr>
		<tr class="bg_0">
			<td>
				礼包内容:&nbsp;<input type="text" style="height:25px;" name="gift_pack" id="gift_pack" size="150" value="<?php
echo $_obj['gift_pack'];
?>
">
			</td>
		</tr>
		<tr class="bg_0">
			<td>
				<font color="red" size="3">(礼包格式：道具类型,道具id,数量|道具类型,道具id,数量 )(1,3,800|2,1104,5|1,2,10)</font>
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

		<tr class="bg_0">
			<td align='center'>
				<input type="hidden" name="can_make_code" id="can_make_code" value="<?php
echo $_obj['can_make_code'];
?>
" >
				<input type="hidden" name="code_max" id="code_max" value="<?php
echo $_obj['code_max'];
?>
" >
				<input type="hidden" name="opt" id="opt" value="make_code" >
				<input class="button_big" type="submit" id="btnCreate" value="生成激活码" >
				<strong><font color="blue" size="4"><?php
echo $_obj['retmsg'];
?>
</font></strong>

			</td>
		</tr>
	</table>

</form>
<!--
<table width="98%" border="0" cellspacing="1" cellpadding="8" id="tblWaiting" style="display:none">
	<tr class="bg_0"><td align="center"><img src="images/waiting.gif"><font color="red">正在生产激活码,请稍候……</font></td></tr>
</table>
-->

<?php
echo $_obj['module_footer'];
?>

<script language="javascript">
	var use_code_limit=<?php
echo $_obj['use_code_limit'];
?>
;

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

	function show_time_tips()
	{
		var start_time = $F('start_time');
		var end_time = $F('end_time');

		if ('' != start_time && '' != end_time)
		{
			var time_str = '有效时间为：'+start_time+' 00:00:00 到'+end_time+' 00:00:00';
			jQuery('#div_time').text(time_str);
		}
	}

	function checkForm()
	{
		var title = $F('title');
		var num = $F('num');
		var code_max = $F('code_max');
		var can_make_code = $F('can_make_code');
		var start_time = $F('start_time');
		var end_time = $F('end_time');

		var gift_pack = $F('gift_pack');
		var character_level_max = $F('character_level_max');
		var character_level_min = $F('character_level_min');
		var use_num_pre = $F('use_num_pre');
		var is_limit_character    = $F('is_limit_character');

		num = parseInt(num);
		code_max = parseInt(code_max);

		if(num > code_max )
		{
			alert("生成激活码数量上限为:"+code_max);
			Field.focus('num');
			Field.select('num');
			return false;
		}
		if ('' == gift_pack)
		{
			alert("请填写礼包内容！");
			Field.focus('gift_pack');
			Field.select('gift_pack');
			return false;
		}

		if ('' == title)
		{
			alert("请先输入批次名！");
			Field.focus('title');
			Field.select('title');
			return false;
		}

		if ('' == num || 0 == num)
		{
			alert("请先输入要生成的数量！");
			Field.focus('num');
			Field.select('num');
			return false;
		}

		if ('' == start_time)
		{
			alert("请先输入有效开始时间！");
			Field.focus('start_time');
			Field.select('start_time');
			return false;
		}

		if ('' == end_time)
		{
			alert("请先输入有效结束时间！");
			Field.focus('end_time');
			Field.select('end_time');
			return false;
		}

		if (start_time == end_time)
		{
			alert("请先输入有效时间！");
			Field.focus('end_time');
			Field.select('end_time');
			return false;
		}

		if (use_num_pre == 0 || use_num_pre > use_code_limit)
		{
			alert("激活码领取次数控制在"+use_code_limit+"次以内，如果需要开放更多次数的请联系技术人员！");
			Field.focus('use_num_pre');
			Field.select('use_num_pre');
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

		$('btnCreate').disabled = true;
		$('tblWaiting').style.display = '';

		return true;

	}

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