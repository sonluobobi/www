{include file="header.tpl"}

<div class="container">
    <fieldset>
       <legend>{include file="default_top.tpl"}</legend>
    </fieldset>

    <fieldset>
       <legend>
       目前已有小分组玩法: 1、岩魔   2、帝国争锋 3、boss之家 4、黄昏末日 5、军团战 6、飞鸽 7、深渊 8、军备战争<br/>
       大分组玩法：1、副本 2、临危、美女 3、丧尸危机 4、龙城矿战 5、3v3  6、勇者之路  
       </legend>
    </fieldset>
	
	<fieldset>
		<legend>已有pk服列表</legend>
		<table class="table table-hover">
			{section name=sec3 loop=$server_list}
			<tr>
			  <td class="active">{$server_list[sec3].var}</td>
			  <td class="active">{$server_list[sec3].txt}</td>
			</tr>
			{/section}
		</table>
	</fieldset>

	<fieldset>
		<legend>pk服配置</legend>
		<table class="table table-hover">
			<td class="active">域名</td>
			<td class="active">端口</td>
			<td class="active">ip</td>
			<td class="active">小分组玩法</td>
			<!--td class="active">大分组玩法</td-->
		</table>
	</fieldset>
	
	{section name=sec loop=$list}
	<fieldset>
		<legend>{$list[sec].id}--{$list[sec].ip}--{$list[sec].title}</legend>
		<table class="table table-hover">
			{section name=sec2 loop=$list[sec].info}
			<tr>
			  <td class="active">{$list[sec].info[sec2].domain}</td>
			  <td class="active">{$list[sec].info[sec2].port}</td>
			  <td class="active">{$list[sec].info[sec2].ip}</td>
			  <td class="active">{$list[sec].info[sec2].bossid}</td>
			  <!--td class="active">{$list[sec].info[sec2].finalwarid}</td-->
			</tr>
			{/section}
		</table>
	</fieldset>
	{/section}
</div>


{include file="footer.tpl"}
