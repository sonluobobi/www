<?php if(!defined('SMARTY_DIR')) exit('no direct access allowed'); ?>
<?php $_smarty_tpl->decodeProperties('a:1:{s:15:"file_dependency";a:1:{s:11:"F2279308526";a:2:{i:0;s:39:"../template/template/Player.detail.html";i:1;i:1494313491;}}}'); ?>
<?php /* Smarty version Smarty3-b5, created on 2021-03-15 10:42:40
         compiled from "../template/template/Player.detail.html" */ ?>
<div align="center">
<form id="subform" name="subform" method="post" action="./?act=Player.setGm">
<table width="98%" class="tableContent" align="center" >
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['pid'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['player_id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['account'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['account'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['roleId'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['nick'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['nick'];?>
</td>
	</tr>

	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['level'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['level'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['gender'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['gender'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['prof'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['prof'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['vip'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['vip'];?>
</td>
	</tr>

	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['created_time'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['created'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['lastLoginTime'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['now_login_time'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['lastLoginIp'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['now_login_ip'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['logout_time'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['logout_time'];?>
</td>
	</tr>

	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['silver'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['silver'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['vit'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['vit'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['endurance'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['endurance'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['contribute'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['contribute'];?>
</td>
	</tr>
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['hornor'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['hornor'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['shouhun'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['shouhun'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['gang_title'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['gang_title'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['gang_job'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['gang_job'];?>
</td>
	</tr>
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['lover_nick'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['lover_nick'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['hidden_lover_nick'];?>
</td><td><?php if ($_smarty_tpl->getVariable('data')->value['chinfo']['hidden_lover_nick']==1){ echo $_smarty_tpl->getVariable('lang')->value['yes']; }else{  echo $_smarty_tpl->getVariable('lang')->value['no']; }?></td>
	</tr>
</table>

<br><br><strong><?php echo $_smarty_tpl->getVariable('lang')->value['fightDetail'];?>
</strong><br>
<table width="98%" class="tableContent" align="center">
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['hp'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['hp'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['max_hp'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['max_hp'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['base_max_hp'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['base_max_hp'];?>
</td>
	</tr>
	
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['hp2'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['hp2'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['max_hp2'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['max_hp2'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['hp3'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['hp3'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['max_hp3'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['max_hp3'];?>
</td>
	</tr>

	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['min_attack'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['min_attack'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['base_min_attack'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['base_min_attack'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['max_attack'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['max_attack'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['base_max_attack'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['base_max_attack'];?>
</td>
	</tr>

	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['defence_phy'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['defence_phy'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['base_defence_phy'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['base_defence_phy'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['defence_magic'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['defence_magic'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['base_defence_magic'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['base_defence_magic'];?>
</td>
	</tr>
	
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['douzhi'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['douzhi'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['base_douzhi'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['base_douzhi'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['dodge'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['dodge'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['base_dodge'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['base_dodge'];?>
</td>
	</tr>

	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['critical_hit'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['critical_hit'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['base_critical_hit'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['base_critical_hit'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['parry'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['parry'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['base_parry'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['base_parry'];?>
</td>
	</tr>

	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['luck'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['luck'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['base_luck'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['base_luck'];?>
</td>
	</tr>
	
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['addi_harm'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['addi_harm'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['addi_harm_perc'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['addi_harm_perc'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['reduce_harm'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['reduce_harm'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['reduce_harm_perc'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['reduce_harm_perc'];?>
</td>
	</tr>

	<tr>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['kill_force'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['kill_force'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['fight_capacity'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['fight_capacity'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['top_fight_capacity'];?>
</td><td><?php echo $_smarty_tpl->getVariable('data')->value['chinfo']['top_fight_capacity'];?>
</td>
	</tr>
</table>

<br><br><strong><?php echo $_smarty_tpl->getVariable('lang')->value['babelDetail'];?>
</strong><br>
<table width="98%" class="tableContent" align="center">
	<tr>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['max_babel_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['now_babel_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['is_fetch_rewrad'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['now_level_arrive_time'];?>
</th>
	</tr>
	<?php if ($_smarty_tpl->getVariable('data')->value['babel']){?>
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('data')->value['babel']['max_babel_id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('data')->value['babel']['now_babel_id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('data')->value['babel']['is_fetch_rewrad'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('data')->value['babel']['now_level_arrive_time'];?>
</td>
	</tr>
	<?php }?>
</table>

<br><br><strong><?php echo $_smarty_tpl->getVariable('lang')->value['chTitles'];?>
</strong><br>
<table width="98%" class="tableContent" align="center">
	<tr>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['title_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['title_name'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['title_expire'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['title_is_show'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['title_is_active'];?>
</th>
	</tr>
	<?php if ($_smarty_tpl->getVariable('data')->value['chtitles']){?>
	<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['chtitles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['title'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['expire'];?>
</td>

		<?php if ($_smarty_tpl->getVariable('v')->value['is_show']==1){?>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['title_show'];?>
</td>
		<?php }else{ ?>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['title_not_show'];?>
</td>
		<?php }?>

		<?php if ($_smarty_tpl->getVariable('v')->value['is_active']==1){?>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['title_active'];?>
</td>
		<?php }else{ ?>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['title_not_active'];?>
</td>
		<?php }?>

	</tr>
	<?php }} ?>
	<?php }?>
</table>

<br><br><strong><?php echo $_smarty_tpl->getVariable('lang')->value['chshenbing'];?>
</strong><br>
<table width="98%" class="tableContent" align="center">
	<tr>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['shenbing_level'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['shenbing_element_one'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['shenbing_element_two'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['shenbing_element_three'];?>
</th>
	</tr>
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('data')->value['shenbing_level'];?>
</td>
		<?php if ($_smarty_tpl->getVariable('data')->value['shenbing_elements']){?>
		<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['shenbing_elements']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
			<td><?php echo $_smarty_tpl->getVariable('v')->value['star'];?>
</td>
		<?php }} ?>
		<?php }?>
	</tr>
</table>

<?php if ($_smarty_tpl->getVariable('data')->value['shenbing_xilians']){?>
<br><br><strong><?php echo $_smarty_tpl->getVariable('lang')->value['shenbing_xilians'];?>
</strong><br>
<table width="98%" class="tableContent" align="center">
	<tr>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['shenbing_sort_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['shenbing_effect_type'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['quality'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['shenbing_effect_value'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['shenbing_own'];?>
</th>
	</tr>
	 <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['shenbing_xilians']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['sort_id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['effect_type'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['quality'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['effect_value'];?>
</td>

		<?php if ($_smarty_tpl->getVariable('v')->value['own']==1){?>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['shenbing_own_one'];?>
</td>
		<?php }elseif($_smarty_tpl->getVariable('v')->value['own']==2){?>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['shenbing_own_two'];?>
</td>
		<?php }elseif($_smarty_tpl->getVariable('v')->value['own']==3){?>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['shenbing_own_three'];?>
</td>
		<?php }elseif($_smarty_tpl->getVariable('v')->value['own']==4){?>
		<td><?php echo $_smarty_tpl->getVariable('lang')->value['shenbing_own_four'];?>
</td>
		<?php }else{ ?>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['own'];?>
</td>
		<?php }?>

	</tr>
	<?php }} ?>
</table>
<?php }?>

<br><br><strong><?php echo $_smarty_tpl->getVariable('lang')->value['chgoddess'];?>
</strong><br>
<table width="98%" class="tableContent" align="center">
	<tr>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['goddess_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['goddess_name'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['goddess_level'];?>
</th>
	</tr>
	<?php if ($_smarty_tpl->getVariable('data')->value['goddess_info']){?>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['goddess_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['goddess_id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['goddess_name'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['level'];?>
</td>
	</tr>
	<?php }} ?>
	<?php }?>

</table>

<br><br><strong><?php echo $_smarty_tpl->getVariable('lang')->value['chdragon'];?>
</strong><br>
<table width="98%" class="tableContent" align="center">
	<tr>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['dragon_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['dragon_star'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['level'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['fight_capacity'];?>
</th>
	</tr>
	<?php if ($_smarty_tpl->getVariable('data')->value['chdragons']){?>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['chdragons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['star'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['level'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['fight_capacity'];?>
</td>
	</tr>
	<?php }} ?>
	<?php }?>

</table>

<br><br><strong><?php echo $_smarty_tpl->getVariable('lang')->value['zhuangbeiDetail'];?>
</strong><br>
<table width="98%" class="tableContent" align="center">
	<tr>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['order_by'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['equip_title'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['equip_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['getDetail'];?>
</th>
	</tr>
	<?php if ($_smarty_tpl->getVariable('data')->value['zhuangbei']){?>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['zhuangbei']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['order_by'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['equip_title'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['equip_id'];?>
</td>
		<td><a href="javascript:void(0);" onclick="RQ('./?act=Notice.getEquipDetail&server_id=<?php echo $_REQUEST['server_id'];?>
&equipId=<?php echo $_smarty_tpl->getVariable('v')->value['equip_id'];?>
',getEquipDetail,'',0);"><?php echo $_smarty_tpl->getVariable('lang')->value['getDetail'];?>
</a></td>
	</tr>
	<?php }} ?>
	<?php }?>

</table>

<br><br><strong><?php echo $_smarty_tpl->getVariable('lang')->value['itemsDetail'];?>
</strong><br>
<table width="98%" class="tableContent" align="center">
	<tr>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['order_by'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['equip_title'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['equip_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['ch_equip_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['stack_num'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['getDetail'];?>
</th>
	</tr>
	<?php if ($_smarty_tpl->getVariable('data')->value['chitems']){?>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['chitems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['order_by'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['title'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['equip_id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['ch_equip_id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['stack_num'];?>
</td>
		<!--<td><a href="javascript:void(0);" onclick="RQ('./?act=Notice.getEquip&single=1&isGm=0&server_id=<?php echo $_REQUEST['server_id'];?>
&roleId=<?php echo $_smarty_tpl->getVariable('v')->value['roleId'];?>
&roleName=<?php echo $_smarty_tpl->getVariable('v')->value['roleName'];?>
',setGm,'',0);"><?php echo $_smarty_tpl->getVariable('lang')->value['getDetail'];?>
</a></td>-->
		<td><a href="javascript:void(0);" onclick="RQ('./?act=Notice.getEquipDetail&server_id=<?php echo $_REQUEST['server_id'];?>
&equipId=<?php echo $_smarty_tpl->getVariable('v')->value['equip_id'];?>
',getEquipDetail,'',0);"><?php echo $_smarty_tpl->getVariable('lang')->value['getDetail'];?>
</a></td>
	</tr>
	<?php }} ?>
	<?php }?>

</table>
<br><br><strong><?php echo $_smarty_tpl->getVariable('lang')->value['petDetail'];?>
</strong><br>
<table width="98%" class="tableContent" align="center">
	<thead>
	<tr>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['nick'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['base_id'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['level'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['douzhi'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['critical_hit'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['dodge'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['parry'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['fight_capacity'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['luck'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['kill_force'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['jieshu'];?>
</th>
		<th><?php echo $_smarty_tpl->getVariable('lang')->value['huanhua_num'];?>
</th>
	</tr>
	</thead>
	<?php if ($_smarty_tpl->getVariable('data')->value['chpets']){?>
    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('data')->value['chpets']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
	<tr>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['nick'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['base_id'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['level'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['douzhi'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['critical_hit'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['dodge'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['parry'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['fight_capacity'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['luck'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['kill_force'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['jieshu'];?>
</td>
		<td><?php echo $_smarty_tpl->getVariable('v')->value['huanhua_num'];?>
</td>
	</tr>
	<?php }} ?>
	<?php }?>
</table>
<!--
<input type="hidden" id="server_ids[]" name="server_ids[]" value="<?php echo $_GET['server_id'];?>
"/>
<input type="hidden" id="server_id" name="server_id" value="<?php echo $_GET['server_id'];?>
"/>
<input type="hidden" id="roleId" name="roleId" value="<?php echo $_GET['roleId'];?>
" />
<input type="hidden" id="isGm" name="isGm" value="<?php echo $_GET['isGm'];?>
"/>
-->
</form>

</div>