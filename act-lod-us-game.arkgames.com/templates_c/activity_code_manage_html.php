<?php
echo $_obj['module_header'];
?>

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
				$('#msg').text('正在发布激活码到官服...');
				$('#msg').show();		
				$('#publishTestServer').hide();
				$('#publishKLServer').hide();
				$('#syncToPl').hide();		
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
							$('#msg').text("激活码发布失败！" + dateString);
						} else 
						{
							$('#msg').text(msg + dateString);
						}
						$('#msg').fadeOut(50000); 
						$('#publishTestServer').show();
						$('#publishKLServer').show();
						$('#syncToPl').show();
					}
				});
			}
	);
	
	$('#publishTestServer').click
	(
			function() 
			{
				$('#msg').text('正在发布激活码到测试服...');
				$('#msg').show();	
				$('#publishTestServer').hide();
				$('#publishKLServer').hide();
				$('#syncToPl').hide();		
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
							$('#msg').text("激活码发布失败！" + dateString);
						} else 
						{
							$('#msg').text(msg + dateString);
						}
						$('#msg').fadeOut(50000); 
						$('#publishTestServer').show();
						$('#publishKLServer').show();
						$('#syncToPl').show();
					}
				});
			}
	);

    <?php
if ($_obj['sync_pl'] == "do"){
?>
    $('#syncToPl').click
	(
			function() 
			{
				$('#msg').text('正在发布激活码到网页领取后台...');
				$('#msg').show();	
				$('#publishTestServer').hide();
				$('#publishKLServer').hide();
				$('#syncToPl').hide();
				var vars = "c=ActCode&a=SyncBatchCodeToPl&t=<?php
echo $_obj['t'];
?>
&s=<?php
echo $_obj['s'];
?>
&author=<?php
echo $_obj['author'];
?>
";		
				$.ajax
				({
					type: "GET",
					url: "interface.php",
					data:vars,
					success: function(msg) 
					{
						var myDate=new Date();
						var dateString =" " + myDate.getFullYear() + "-" + (myDate.getMonth() + 1) + "-" + myDate.getDate() + 
										" " + myDate.getHours() + ":" + myDate.getMinutes() + ":" + myDate.getSeconds();
						if (msg=='succ') 
						{
							$('#msg').text("激活码发布成功！" + dateString);
						} else 
						{
							$('#msg').text("激活码发布失败！" + msg + dateString);
						}
						$('#msg').fadeOut(50000); 
						$('#publishTestServer').show();
						$('#publishKLServer').show();
						$('#syncToPl').show();
					}
				});
			}
	);
    <?php
}
?>
});
</script>
<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableHeader">
	<td colspan="2">
		&nbsp;&nbsp;激活码发布
	</td>
	<tr class="bg_1">
		<td align="left" colspan="2"> 
		    	<input  class="button_big" type="button" name="publishTestServer" id="publishTestServer" value="发布到测试服"/>
			 <input  class="button_big" type="button" name="publishKLServer" id="publishKLServer" value="发布到官服"/>
			 <?php
if ($_obj['sync_pl'] == "do"){
?>
			 <input  class="button_big" type="button" name="syncToPl" id="syncToPl" value="发布到网页领取后台"/>
			 <?php
}
?>
		</td>
	</tr>	
	<tr class="bg_1">
		<td align="right" width="5%">发布结果&nbsp;</td>
		<td>
			<strong><font color="red" size="3"><span id="msg" style="display:none;"></span></font></strong>
		</td>
	</tr>
</table>


<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableHeader">
		<td>&nbsp;&nbsp;激活码查询</td>
	</tr>
</table>
<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<form action="" method="POST" name="FrmSearch" onsubmit=" return checkForm();">
	<tr class="bg_0">
		<td align="right" width="10%">激活码&nbsp;</td>
		<td width="20%">
			&nbsp;<input type="text" name="code" id="code" value="<?php
echo $_obj['code_value'];
?>
" size="30" style="height:25px;">
		</td>
		<td>
			<input type="hidden" name="opt" id="opt" value="search">
			<input class="button_small" type="submit" id="subSearch" value=" 查 询 "></td>
	</tr>
	</form>
</table>
<table width="98%" border="0" cellspacing="1" cellpadding="8">
	<tr class="tableHeader" align="center">
		<td width="5%">ID</td>
		<td width="10%">批次</td>
		<td width="8%">激活码</td>
		<td width="6%">等级限制</td>
		<td width="4%">次数限制</td>
		<td width="5%">限制(角色/账号)</td>
		<td width="5%">使用者UID</td>
		<td width="5%">使用者角色ID</td>
		<td width="5%">使用者所在大区ID</td>
		<td width="10%">发布到服务器</td>
		<td width="10%">开始时间</td>
		<td width="10%">结束时间</td>
		
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
echo $_obj['batch_id'];
?>
&title=<?php
echo $_obj['batch_title'];
?>
"  target="_blank"><?php
echo $_obj['batch_title'];
?>
</td>
		<td align="left">&nbsp;<?php
echo $_obj['code'];
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
echo $_obj['user_player_id'];
?>
</td>
		<td><?php
echo $_obj['user_character_id'];
?>
</td>
		<td><?php
echo $_obj['user_serv_id'];
?>
</td>
		<td><?php
echo $_obj['serverlist'];
?>
</td>
		<td><?php
echo $_obj['start_time'];
?>
</td>
		<td><?php
echo $_obj['end_time'];
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
		<td align="right"><input type="hidden"  id="is_used" value="<?php
echo $_obj['is_used'];
?>
"><?php
echo $_obj['pagenav'];
?>
</td>
	</tr>
</table>
<?php
echo $_obj['module_footer'];
?>

<script language="javascript">

function checkForm()
{
	var act_code = $F('code');
	if(act_code =="")
	{
		alert('请输入需要查询的激活码');
		Field.focus('code');
		Field.select('code');
		return false;
	}
	return true;
	
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
	var url   = 'activity_code_manage.php';
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
	var resource_id = $F('res_id');  
		
	var title = $F('title');
	var prefix = $F('activation_prefix');
	var num = $F('num');
	
	var start_time = $F('start_time');
	var end_time = $F('end_time');
	
	var gift_pack_id = $F('gift_pack_id_1');
	var gift_pack_num = $F('gift_pack_num_1');
	var server_ids = $F('server_ids');
	var character_level_max = $F('character_level_max');
	var character_level_min = $F('character_level_min');
	var use_num_pre = $F('use_num_pre');
	var is_limit_character    = $F('is_limit_character');
	
	if ('' == trim(title))
	{
		alert("请先输入批次名！");
		Field.focus('title');
		Field.select('title');
		return false;
	}

	if ( prefix.length != 2)
	{
		alert("激活码前缀必须是2个字符！");
		Field.focus('activation_prefix');
		Field.select('activation_prefix');
		return false;
	}

	if ('' == trim(num))
	{
		alert("请先输入要生成的数量！");
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

	if ('' == trim(server_ids))
	{
		alert("请先输入有效服务器！");
		Field.focus('server_ids');
		Field.select('server_ids');
		return false;
	}
	
	if (trim(use_num_pre) == 0 || trim(use_num_pre) > 5)
	{
		alert("激活码领取次数控制在5次以内，如果需要开放更多次数的请联系技术人员！");
		Field.focus('use_num_pre');
		Field.select('use_num_pre');
		return false;
	}
	   
	$('btnCreate').disabled = true;
	$('subSearch').disabled = true;
	$('tblWaiting').style.display = '';
   
		
    //检查奖励道具和道具数量
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
    		
	var pars  = 'num=' + num + '&title=' + title + '&activation_prefix=' + prefix + 
				'&gift_pack_id=' + gift_pack_content + '&server_ids=' + server_ids + 
				'&start_time=' + start_time + '&end_time=' + end_time + '&character_level_max=' + character_level_max + 
				'&character_level_min=' + character_level_min + '&use_num_pre=' + use_num_pre + '&is_limit_character=' + is_limit_character + 
				'&res_id=' + resource_id +
				'&opt=createInvitationCode';
	var url   = 'activity_code_manage.php';
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
					alert("激活码批次生成成功！");
					document.location.reload(true);
				}
				else if(response == 'false')
				{
					alert("激活码批次生成失败！");
				}
				else
				{
					alert(response);
				}
		    }
		}
	);
}
</script>
