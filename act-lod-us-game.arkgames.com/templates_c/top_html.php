<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>

<style type="text/css">
<!--
a {
  color: #333333;
  background-color: transparent;
  text-decoration: none;
}
a:visited { 
  color: #333333;
  background-color: transparent;
  text-decoration: none;  
}
a:hover { 
  color: #999999;
  text-decoration: underline;
}
td {
	font-size: 12px;
	font-family: Tahoma, Verdana, Arial;
}

.topbg {
	background-image: url(images/topbg.gif);
	background-repeat: repeat-x;
}
-->
</style>

<script>
var top_year = <?php
echo $_obj['top_year'];
?>
;
var top_month = <?php
echo $_obj['top_month'];
?>
;
var top_date = <?php
echo $_obj['top_date'];
?>
;
var top_hour = <?php
echo $_obj['top_hour'];
?>
;
var top_minute = <?php
echo $_obj['top_minute'];
?>
;
var top_seconds = <?php
echo $_obj['top_seconds'];
?>
;

var myDate = new Date();
myDate.setFullYear(top_year);
myDate.setMonth(top_month);
myDate.setDate(top_date);
myDate.setHours(top_hour);
myDate.setMinutes(top_minute);
myDate.setSeconds(top_seconds);

var cur_microtime = myDate.getTime();

setInterval(function(){
var myDate = new Date(cur_microtime);
cur_microtime = cur_microtime + 1000;
var top_time=myDate.getFullYear()+"年"+(myDate.getMonth()+1)+"月"+myDate.getDate()+"日 "+myDate.getHours()+"点"+myDate.getMinutes()+"分"+myDate.getSeconds()+"秒";
document.getElementById("top_time"). innerHTML=top_time;
},1000);

</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="34" border="0" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
	<tr class='topbg'> 
		<td width="20%">活动管理</td>
		<td width="60%" align="center">&nbsp;欢迎你：<?php
echo $_obj['accountname'];
?>
 | <?php
echo $_obj['time_zone'];
?>
 | <span id='top_time'> </td>
		<td width="20%" align="right">
			<a href="logout.php" target="_top">退出登陆</a>
		</td>
	</tr>
</table>
</body>
</html>