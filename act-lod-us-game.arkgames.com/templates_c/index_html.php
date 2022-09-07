<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>活动管理平台</title>
<script type="text/javascript">

/***********************************************
* Collapsible Frames script- ?Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/


var columntype="rows"
var defaultsetting=""

function getCurrentSetting(){
	if (document.body)
		return (document.body.cols)? document.body.cols : document.body.rows
}

function setframevalue(coltype, settingvalue){
	if (coltype=="rows")
		document.body.rows=settingvalue
	else if (coltype=="cols")
		document.body.cols=settingvalue
}

function resizeFrame(contractsetting){
	if (getCurrentSetting()!=defaultsetting)
		setframevalue(columntype, defaultsetting)
	else
		setframevalue(columntype, contractsetting)
}

function init(){
	if (!document.all && !document.getElementById) return
	if (document.body!=null){
		columntype=(document.body.cols)? "cols" : "rows"
		defaultsetting=(document.body.cols)? document.body.cols : document.body.rows
	} else
		setTimeout("init()",100)
}

setTimeout("init()",100)


</script>
</head>
<frameset rows="*" cols="180,*" framespacing="0" frameborder="yes" border="0">
  <frameset rows="*" cols="*,7" framespacing="0" frameborder="NO" border="0">
		<frame src="menu.php" name="menu" scrolling="yes">
		<frame src="fc.htm" name="rightFrame" scrolling="NO" noresize>
	</frameset>
  <frameset rows="34,*" cols="*" framespacing="0" frameborder="NO" border="0">
		<frame src="top.php" name="top" scrolling="NO" noresize id="top">
		<frame src="main.php" name="main">
  </frameset>
</frameset>
<noframes><body>
你的浏览器不支持 frame，请升级！
</body></noframes>
</html>
