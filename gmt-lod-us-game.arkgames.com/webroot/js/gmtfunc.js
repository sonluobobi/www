/**
 * GMT使用JS函数文件
 * author Juezhong Long
 * date 2010-07-06
 */

/**
 * 分页跳转函数
 * p 值为页码值
 */
var addI = 1;

function showNotice()
{
	var obj = document.getElementById("addForm");
	var notice = document.getElementById("add_notice");
	if (obj.style.display =="none")
	{
		obj.style.display ="";
		notice.value ="隐藏添加公告";
	}
	else 
	{
		obj.style.display ="none";
		notice.value ="显示添加公告";
	}
}
var index = 0;//初始下标
function adding(){
	index++;
	var table = document.getElementById("tbl");

	var addTr = table.insertRow(12);

	var td1 = addTr.insertCell();

	td1.innerHTML = '<select name="contents_cn_'+index+'" id="contents_cn_'+index+'" > <option value="cn" >cn </option> ' +
		'<option value="en" >en </option> ' +
		'<option value="ru" >ru </option> ' +
		'<option value="de" >de </option> ' +
		'<option value="fr" >fr </option> ' +
		'<option value="it" >it </option> ' +
		'<option value="pt" >pt </option> ' +
		'<option value="es" >es </option> ' +
		'<option value="tr" >tr </option> ' +
		'</select>';

	var td2 = addTr.insertCell();

	td2.innerHTML = '<textarea id="contents_'+index+'" name="contents_'+index+'" rows="6" cols="40"></textarea>';

}

var equip_index = 0;//初始下标
function addEquipEn(){
	equip_index++;
	var table = document.getElementById("tbl");

	var addTr = table.insertRow(16);

	var td1 = addTr.insertCell();
	td1.align="right";
	td1.innerHTML = '语言选择：<select name="contents_cn_'+equip_index+'" id="contents_cn_'+equip_index+'" > <option value="cn" >cn </option> ' +
		'<option value="en" >en </option> ' +
		'<option value="ru" >ru </option> ' +
		'<option value="de" >de </option> ' +
		'<option value="fr" >fr </option> ' +
		'<option value="it" >it </option> ' +
		'<option value="pt" >pt </option> ' +
		'<option value="es" >es </option> ' +
		'<option value="tr" >tr </option> ' +
		'</select>';

	var td4 = addTr.insertCell();
	td4.align="left";
	td4.innerHTML = '<内容>：<textarea id="contents_'+equip_index+'" name="contents_'+equip_index+'" rows="8" cols="80"></textarea>'
		+'标题：<textarea id="title_'+equip_index+'" name="title_'+equip_index+'" rows="1" cols="40"></textarea>';
}




/*var index = 0;//初始下标
var indexArr= new Array();

//新增一行
function addRow() {
	index++;
	indexArr.push(index);

	var showHtml = $("show").html();
	var html = "<tr id='tr##'>"+showHtml+"</tr>";
	html = html.replace(/##/g,index);//把##替换成数字

	$("show").before($(html));

	console.log("当前下标数组",indexArr);
}

//删除一行
function deleteRow(inde){
	$("#tr" + inde).remove();
	var a = indexArr.indexOf(parseInt(inde));

	if (a > -1) {
		indexArr.splice(a, 1);
		console.log("当前下标数组",indexArr);
	}

}*/

function mailReportIPSubmit(opt){
	$('opt').value=opt;
	$('myform').submit();
}


function pageGo(p)
{
	$('p').value = p;
	FS('myform',pt.writeBody);
}

function getSelectedIds()
{
	var queue_id_str = '';
	var obj = document.getElementsByName("select[]");

	for(var i=0;i<obj.length;i++)
	{
		if(obj[i].checked) {
			queue_id_str += obj[i].value + ',';
		}
	}
	return queue_id_str;
}

/**
 * 确定发送道具奖励操作
 */
function sendPropsConfirm() 
{
	var queue_id_str = '';
	var obj = document.getElementsByName("select[]");

	for(var i=0;i<obj.length;i++)
	{
		if(obj[i].checked) {
			queue_id_str += obj[i].value + ',';
		}
	}
	
	RQ('./?act=Notice.sendPropsConfirm&queue_id='+ queue_id_str,pt.writeBody);
} 


/**
 * 确定发送道具奖励操作
 */
function sendPropsDel() 
{
	var queue_id_str = '';
	var obj = document.getElementsByName("select[]");

	for(var i=0;i<obj.length;i++)
	{
		if(obj[i].checked) {
			queue_id_str += obj[i].value + ',';
		}
	}
	
	RQ('./?act=Notice.sendPropsDel&queue_id='+ queue_id_str,pt.writeBody);
} 


/**
 * EXCEL下载使用函数
 */
function downloadExcel() 
{
	var addinput = document.createElement("input");
	addinput.id = 'd';
	addinput.name = 'd';
	addinput.type = 'hidden';
	addinput.value = 1;
	$('myform').appendChild(addinput);
	$('myform').submit();
	$('myform').removeChild(addinput);
}

/**
 * 封禁、禁言操作
 * 参数说明：remind:提示信息,type为提交类型 1：封禁 2：禁言,roleId:角色ID,
 * 弹出封禁对话框
 */
function subBlockGag(remind,type,roleId) 
{
	var roleId = roleId;
	if(roleId == '' || roleId == null)
	{
		roleId = getCheckValue();
	}
	if(roleId == '')
	{
		debug(remind);
		return false;
	}
	var server_id = $('server_id').value;
	RQ('./?act=Player.userBlockGag&server_id=' + server_id + '&roleId=' + roleId + '&type=' + type,callbackBlockGag,'',1);
} 
/**
 * 封禁、禁言操作
 * 参数说明：remind:提示信息,type为提交类型 1：封禁 2：禁言,roleId:角色ID,
 * 弹出封禁对话框
 */
function subSetGm(remind,isGm,roleId) 
{
	var roleId = roleId;
	if(roleId == '' || roleId == null)
	{
		roleId = getCheckValue();
	}
	if(roleId == '')
	{
		debug(remind);
		return false;
	}
	var server_id = $('server_id').value;
	RQ('./?act=Player.setGm&server_id=' + server_id + '&roleId=' + roleId + '&isGm=' + isGm,setGm,'',1);
} 

/**
 * 取消封禁、禁言操作
 */
function undoBlockGag(remind,type,roleId) 
{
	var roleId = roleId;
	if(roleId == '' || roleId == null)
	{
		roleId = getCheckValue();
	}
	if(roleId == '')
	{
		debug(remind);
		return false;
	}
	var server_id = $('server_id').value;
	RQ('./?act=Player.undoUserBlockGag&server_id=' + server_id + '&roleId=' + roleId + '&type=' + type,callbackBlockGag,'',1);	
}

/**
 * 商城商品确认
 */
// function setGoodsConfirm(remind,queue_id) 
// {
	// var queue_id = queue_id;
	// if(queue_id == '' || queue_id == null)
	// {
		// debug(remind);
		// return false;
	// }
	// RQ('./?act=Goods.setGoodsConfirm&queue_id=' + queue_id,callbackSetGoodsConfirm,'queue_id='+queue_id,1);	
// }

/*
*显示宠物资质
*/
function showPetQualifications(pet_name,tale1,tale2,tale3,tale4,tale5,tale6){
	RQ('./?act=Log.showPetQualifications&pet_name=' + pet_name + '&tale1=' +tale1  + '&tale2=' +tale2+ '&tale3=' +tale3+ '&tale4=' +tale4+ '&tale5=' +tale5+ '&tale6=' +tale6 ,callbackPetQualifications,'',1);
}

function callbackPetQualifications(responseJson){
	var popNo = $('pageConfirm1_popNo');
	 popNo.addEvents({
                'click': function(){
                                pt.pageMasking("none");
                                $('pageConfirm1').setStyles({display: "none"});
                }
        });
        pt.pageMasking('block');
        $('pageConfirm1Head').set("html", responseJson['title']);
        $('pageConfirm1_popBody').set("html", responseJson['body']);
        pt.pagePoping("pageConfirm1");
}



/**
 *提交请求回调函数
 */
function callbackBlockGag(responseJson) 
{
	var popOk = $('pageConfirm_popOk');
	var popNo = $('pageConfirm_popNo');
	popOk.removeEvents('click');
	popOk.addEvents({
		'click': function(){
				var remind = responseJson['ext']['remind'];
				var op = responseJson['ext']['op'] != null ? responseJson['ext']['op'] : '';
				blockGagSubConfirm(remind,op);
		}
	});
	popNo.addEvents({
		'click': function(){
				pt.pageMasking("none");
				$('pageConfirm').setStyles({display: "none"});
		}
	});
	pt.pageMasking('block');
	$('pageConfirmHead').set("html", responseJson['title']);
	$('pageConfirm_popBody').set("html", responseJson['body']);
	pt.pagePoping("pageConfirm");
}

/**
 *提交请求回调函数
 */
function disbandGang(responseJson) 
{
	var popOk = $('pageConfirm_popOk');
	var popNo = $('pageConfirm_popNo');
	popOk.removeEvents('click');
	popOk.addEvents({
		'click': function(){
				var remind = responseJson['ext']['remind'];
				var gang_title = $('subform').gang_title.value;
				
				if(gang_title == "")
				{
					pageAlert(remind);	
					return false;
				}
				$('pageConfirm').setStyles({display: "none"});
				FS('subform',function(message) {
					alertFunc(message,"FS('myform',pt.writeBody,1);")
				},1);
				
		}
	});
	popNo.addEvents({
		'click': function(){
				pt.pageMasking("none");
				$('pageConfirm').setStyles({display: "none"});
		}
	});
	pt.pageMasking('block');
	$('pageConfirmHead').set("html", responseJson['title']);
	$('pageConfirm_popBody').set("html", responseJson['body']);
	pt.pagePoping("pageConfirm");
}

/**
 *清除二级密码
 */
function removePassword(responseJson) 
{
	var popOk = $('pageConfirm_popOk');
	var popNo = $('pageConfirm_popNo');
	popOk.removeEvents('click');
	popOk.addEvents({
		'click': function(){
				var remind = responseJson['ext']['remind'];
				var user_type = $('myform').user_type.value;
				var user_value = $('myform').user_value.value;
				
				if(user_type == "" || user_value == "")
				{
					pageAlert("用户类型和类型对应的内容都不能为空");
					return false;
				}
				$('pageConfirm').setStyles({display: "none"});
				FS('myform',function(message) {
					alertFunc(message,"FS('myform',pt.writeBody,1);")
				},1);
				
		}
	});
	popNo.addEvents({
		'click': function(){
				pt.pageMasking("none");
				$('pageConfirm').setStyles({display: "none"});
		}
	});
	pt.pageMasking('block');
	$('pageConfirmHead').set("html", responseJson['title']);
	$('pageConfirm_popBody').set("html", responseJson['body']);
	pt.pagePoping("pageConfirm");
}


/**
 *提交请求回调函数
 */
function callbackSetGoodsConfirm(responseJson) 
{
	var popOk = $('pageConfirm_popOk');
	var popNo = $('pageConfirm_popNo');
	popOk.removeEvents('click');
	popOk.addEvents({
		'click': function(){
				var remind = responseJson['ext']['remind'];
				var op = responseJson['ext']['op'] != null ? responseJson['ext']['op'] : '';
				blockGagSubConfirm(remind,op);
		}
	});
	popNo.addEvents({
		'click': function(){
				pt.pageMasking("none");
				$('pageConfirm').setStyles({display: "none"});
		}
	});
	pt.pageMasking('block');
	$('pageConfirmHead').set("html", responseJson['title']);
	$('pageConfirm_popBody').set("html", responseJson['body']);
	pt.pagePoping("pageConfirm");
}

/**
 *封禁解禁提交确认操作
 */
function blockGagSubConfirm(remind,op) 
{
	if(op != 'undo')
	{
		var endTime = $('subform').endTime.value;
		if(endTime == '')
		{
			pageAlert(remind);	
			return false;
		}
	}
	var reason  = $('subform').reason.value;	
	if(reason == '')
	{
		pageAlert(remind);	
		return false;
	}
	$('pageConfirm').setStyles({display: "none"});
	FS('subform',function(message) {
		alertFunc(message,"FS('myform',pt.writeBody,1);")
	},1);
}

/**
* 宗族旗帜删除
* @param $_POST
* @return Array
*/

function deleteFactionFlag(delstr){
	var flag=confirm('是否删除');
	if(flag){
		if(delstr==''){
			delstr = getdelstr();
		}

		RQ('./?act=Role.deleteFactionFlag', function(message) {
              		alertFunc(message,"FS('myform',pt.writeBody,1);")
   		},'delstr='+delstr,1);
	}
}

/**
* 开服时间配置功能
*/
function setOpenTime(){
	var server_id=$('server_id').value;
	var time=$('time').value;
	RQ('./?act=Service.setOpenTime', function(message) {
        	alertFunc(message)
        },'setstr='+server_id+'_'+time,1);
}

function getdelstr()
{
  var rids = '';
  var selects = document.getElementsByName('select[]');
  for(var i=0;i<selects.length;i++)
  {
  	rids += selects[i].value + ',';
  }
  if(rids != '') rids = rids.substr(0,rids.length-1);
  return rids;
}



/**
 * 新增的弹出ALERT对话框，
 * 弹出后隐藏confirm层,
 * 单击关闭从新显示confirm层
 * 单为封、解禁，禁、解禁言的提交确认编写
 */
function pageAlert(message)
{
	$('pageConfirm').setStyles({display: "none"});
	var myeOk = $('pageAlert_popOk');
	myeOk.removeEvents('click');
	myeOk.addEvents({
		'click': function(){
				$('pageConfirm').setStyles({display: "block"});
				$('pageAlert').setStyles({display: "none"});
		}
	});
	$('pageAlert_popBody').set("html", message);
	pt.pagePoping("pageAlert");
}

/**
 * 外部调用pt.alert方法
 */
function debug(info)
{
	var xmlDebug = '<?xml version="1.0" encoding="utf-8" ?><message>' + info + '</message>';
	pt.alert(create_doc(xmlDebug));
}

/**
 * 单击单选按钮执行操作
 */
function checkOne() 
{
	var checkAll = true;
	var selects = document.getElementsByName('select[]');
	for(var i=0;i<selects.length;i++)
	{
		if(selects[i].checked == false)
		{
			checkAll = false;
			break;
		}
	}
	$('checkAll').checked = checkAll;
}

/**
 * 单击全选按钮执行操作
 */
function checkAlls()
{
  var selects = document.getElementsByName('select[]');
  var checkall = $('checkAll').checked;
  var v = (checkall == true) ? true : false;
  for(var i=0;i<selects.length;i++)
  {
	  selects[i].checked = v;
  }
}

/**
 * 获取roleId值
 */
function getCheckValue() 
{
  var rids = '';
  var selects = document.getElementsByName('select[]');
  for(var i=0;i<selects.length;i++)
  {
	  	if(selects[i].checked == true)
		{
			rids += selects[i].value + ',';			
		}
  }
  if(rids != '') rids = rids.substr(0,rids.length-1);
  return rids;
}

/**
 * 重定向页面内容到Body
 */
function RedirectUrl(url)
{
	RQ(url,pt.writeBody,'',1);
}

/**
 * 生成XML对象
 */
function create_doc(text)
{  
    var xmlDoc = null;  
    try //Internet Explorer  
    {  
      xmlDoc=new ActiveXObject("Microsoft.XMLDOM");  
      xmlDoc.async="false";  
      xmlDoc.loadXML(text);  
    }  
    catch(e)  
    {  
       try //Firefox, Mozilla, Opera, etc.  
       {  
         parser=new DOMParser();  
         xmlDoc=parser.parseFromString(text,"text/xml");  
       }  
       catch(e) {}  
     }  
     return xmlDoc;  
}  

function sameIp_select2(ip)
{
	var name=document.getElementsByName(ip);
	var n = name[0].checked;
	var v = (n == true) ? false : true;
	for(var i=0;i<name.length;i++)
	{
	  name[i].checked = v;
	}
}

/**
 * 公告类型选择图片地址框是否显示功能
 */
function changePopNotice(id,div) 
{
	if(id == 1)
	{
		$('' + div + '').style.display = '';
	}else{
		$('' + div + '').style.display = 'none';
	}
}

/**
 * 添加公告
 * AJAX 提交请求
 */
function addNotice() 
{
	FS('subform',function(responseText){
		var func;
		var message = responseText['title'];
		if(responseText['ext']['op'] > 0)
		{
			func = "FS('myform',pt.writeBody);";
		}else{
			func = 'RQ("./?act=Notice.add",pt.writeBody)';
		}
		alertFunc(message,func);
	});
}

/**
 * 编辑公告
 */
function editLocalNotice(id,title) 
{
	var html = $('bodyContentHead').innerHTML
	var server_id = "";
	var url = '/?act=Notice.manage&server_id=' + server_id + '&id=' + id + '&title=' + title +'&type=local';
	RQ(url,function(responseText){
		pt.writeBody(responseText);		
		changePopNotice($('type').value,'NoticeDIV');
		createDiv('spDiv',html);
	});
}

/**
 * 编辑公告
 */
function editNotice(id,title) 
{
	alert(id+"title="+title);
	var html = $('bodyContentHead').innerHTML
	var server_id = $('server_id').value;
	var url = '/?act=Notice.add&server_id=' + server_id + '&id=' + id + '&title=' + title;
	RQ(url,function(responseText){
		pt.writeBody(responseText);		
		changePopNotice($('type').value,'NoticeDIV');
		createDiv('spDiv',html);
	});
}

/**
 * 删除公告操作
 * 参数: remind 提示语；id 要删除的id，为空为多选删除
 */
function delNotice(remind,delNotice,id) 
{
	var id = id;
	if(id == '' || id == null)
	{
		id = getCheckValue();
	}
	if(id == '')
	{
		debug(remind);
		return false;
	}
	divConfirm(delNotice,'call',2,id);

}

/**
 * 开始公告操作
 * 参数: remind 提示语；id 要删除的id，为空为多选删除
 */
function startNotice(remind,startNotice,id) 
{
	var id = id;
	if(id == '' || id == null)
	{
		id = getCheckValue();
	}
	if(id == '')
	{
		debug(remind);
		return false;
	}
	divConfirm(startNotice,'notice_start',2,id);
}

/**
 * 暂停公告操作
 * 参数: remind 提示语；id 要删除的id，为空为多选删除
 */
function pauseNotice(remind,pauseNotice,id) 
{
	var id = id;
	if(id == '' || id == null)
	{
		id = getCheckValue();
	}
	if(id == '')
	{
		debug(remind);
		return false;
	}
	divConfirm(pauseNotice,'notice_pause',2,id);
}

/**
 * 开始公告回调
 */
function notice_start(id) 
{
	var server_id = $('server_id').value;
	var url = '/?act=Notice.startAndPause&server_id=' + server_id +'&id=' + id+'&status=1';
	RQ(url,function(responseText){
			alertFunc(responseText,"FS('myform',pt.writeBody,1)");
		},
	'',1);
}

/**
 * 暂停公告回调
 */
function notice_pause(id) 
{
	var server_id = $('server_id').value;
	var url = '/?act=Notice.startAndPause&server_id=' + server_id +'&id=' + id+'&status=2';
	RQ(url,function(responseText){
			alertFunc(responseText,"FS('myform',pt.writeBody,1)");
		},
	'',1);
}

/**
 * 编辑全服邮件
 */
function editSysMail(id,title) 
{
	var html = $('bodyContentHead').innerHTML
	var server_id = $('server_id').value;
	var url = '/?act=Notice.sendSysMail&server_id=' + server_id + '&id=' + id + '&title=' + title;
	RQ(url,function(responseText){
		pt.writeBody(responseText);		
		changePopNotice($('type').value,'NoticeDIV');
		createDiv('spDiv',html);
	});
}

/**
 * 删除公告操作
 * 参数: remind 提示语；id 要删除的id，为空为多选删除
 */
function deleteNotice(remind,delNotice,id) 
{
	var id = id;
	if(id == '' || id == null)
	{
		id = getCheckValue();
	}
	if(id == '')
	{
		debug(remind);
		return false;
	}
	divConfirm(delNotice,'notice_call',2,id);

}

/**
 * 删除回调
 */
function notice_call(id) 
{
	var url = '/?act=Notice.deleteNotice&id=' + id;
	RQ(url,function(responseText){
			alertFunc(responseText,"FS('myform',pt.writeBody,1)");
		},
	'',1);
}


/**
 * 删除回调
 */
function call(id) 
{
	var server_id = $('server_id').value;
	var url = '/?act=Notice.del&server_id=' + server_id +'&id=' + id;
	RQ(url,function(responseText){
			alertFunc(responseText,"FS('myform',pt.writeBody,1)");
		},
	'',1);
}

/**
 *
 * @param 删除用户
 * @param delNotice
 * @param id
 * @returns {boolean}
 */
function deleteUser(remind,delNotice,id)
{

	
	divConfirm(delNotice,'user_call',2,id);
}

/**
 * 删除回调
 */
function user_call(id) 
{
	var url = '/?act=User.deleteuser&id=' + id;
	RQ(url,function(responseText){
			alertFunc(responseText,"FS('myform',pt.writeBody,1)");
		},
	'',1);
	
	document.location.reload();
}



/**
*  弹出框提示
*/

function confirmClew(message, callback, title)
{
	
	var title = ($type(title)=="string") ? title : '提示信息'
	$('pageConfirmHead').set('html', title);
	$('pageConfirm_popBody').set('html', message);
	$('pageConfirm_popOk').removeEvents();
	$('pageConfirm_popOk').addEvents({ 'click': function(){ eval(callback); pt.alertCancel(); }});
	$('pageConfirm_popNo').set('class', 'button');
	$('pageConfirm_popNo').removeEvents();
	$('pageConfirm_popNo').addEvents({ 'click': function(){ pt.alertCancel(); }});

	pt.pagePoping('pageConfirm');

}
/**
*程序回调弹出框
*/
function processBackCallConfirm(responseJson)
{
        var popOk = $('pageConfirm_popOk');
        var popNo = $('pageConfirm_popNo');
        var formName = '';
        popOk.removeEvents('click');
        popOk.addEvents({
                'click': function(){
                                formName = document.forms[0].name;
                                FS(formName);
                                pt.pageMasking('none');
                                $('pageConfirm').setStyles({display: "none"});
                }
        });
        popNo.addEvents({
                'click': function(){
                                pt.pageMasking("none");
                                $('pageConfirm').setStyles({display: "none"});
                }
        });

        pt.pageMasking('block');
        $('pageConfirmHead').set("html", responseJson['title']);
        $('pageConfirm_popBody').set("html", responseJson['body']);
        pt.pagePoping("pageConfirm");
}

/**
 * 选择发送邮件输入roleid或是上传excel文件
 */
function changeSendType(t,notice) 
{
	if(t == 1)
	{
		$('rids').style.display = '';
		$('excleFile').value = '';
		$('excleFile').style.display = 'none';
	}else{
		$('rids').style.display = 'none';
		$('rids').value = '';
		$('excleFile').style.display = '';
	}
	$('caption').innerHTML = notice;
}

/**
 * 新增的confirm层弹出
 * @params message 显示信息，callFunc 新增click方法
 */
function divConfirm(message,callFunc,hiddenBack,params) 
{
	var popOk = $('pageConfirm_popOk');
	var popNo = $('pageConfirm_popNo');
	popOk.removeEvents('click');
	popOk.addEvents({
		'click': function(){
				$('pageConfirm').setStyles({display: "none"});
				eval(callFunc + '("'+ params +'")');
				if(hiddenBack == 1) pt.pageMasking("none");
		}
	});
	popNo.addEvents({
		'click': function(){
				pt.pageMasking("none");
				$('pageConfirm').setStyles({display: "none"});
		}
	});
	pt.pageMasking("block");
	$('pageConfirm_popBody').set("html", message);
	pt.pagePoping("pageConfirm");
}

/**
 * 弹出消息，执行指定方法
 * 参数：message 弹出信息
 *      func 点击确定执行的方法
 *		showBack 点击click 背景是否隐藏 ，0：隐藏 ，1：显示
 */
function alertFunc(message,func,showBack)
{
	var func = func != '' ? func : '';
	var showBack = showBack == 1 ? 1 : 0;
	pt.pageMasking("block");
	var myeOk = $('pageAlert_popOk');
	myeOk.removeEvents('click');
	myeOk.addEvents({
		'click': function(){
				if(func != '') eval(func);
				if (showBack == 0) pt.pageMasking("none");
				$('pageAlert').setStyles({display: "none"});
		}
	});
	$('pageAlert_popBody').set("html", message);
	pt.pagePoping("pageAlert");
}

/**
 * 动态添加DIV
 */
function createDiv(divId,html) 
{
	var div = document.getElementById(divId);
	if(div != null) div.parentNode.removeChild(div);
	div = document.createElement("div");
	div.id = divId;
	div.name = divId;
	div.style.display = 'none';
	div.innerHTML = html;
	$('bodyContents').appendChild(div)
}

/**
 * 创建FCK编辑器
 */
function createEditor()
{
	var sBasePath = "/js/fckeditor/" ;
	var oFCKeditor = new FCKeditor('content') ;
	oFCKeditor.BasePath	= sBasePath ;
	oFCKeditor.ReplaceTextarea();
}

/**
 * 通过JS实现历史的前进、后退
 */
var goHistory = {
	//定义一个全局数组
	hashList : new Array(''),

	//定义一个全局变量，用来作为hash的编号
	hashNO : 0,
	
	//首页div文件内容
	firstDiv : '',

	//内容div的ID值
	bodyContent : 'bodyContents',

	//添加历史记录
	addHash : function(newHash)
	{
		//将初次装载的页面的hash添加进数组
		if(this.hashNO == 0)
		{
			this.firstDiv = $('' + this.bodyContent +'').innerHTML;
			$('linkPre').style.backgroundImage  = "url('img/jump_left_1.png')";
			this.addClickEvent('linkPre');
			$('linkReload').style.backgroundImage  = "url('img/jump_flush_2.png')";
			this.addClickEvent('linkReload');
		}
		//当新增历史不在最后一页时处理
		if(this.hashNO != (this.hashList.length - 1))
		{
			//删除此页标识以后的数组项
			this.hashList.splice(this.hashNO + 1, this.hashList.length - this.hashNO);
			$('linkNext').style.backgroundImage  = "url('img/jump_right_0.png')";
			$('linkNext').removeEvents('click');
		}

		//连续的相同请求不做历史记录
		if(newHash != this.hashList[this.hashList.length - 1])
		{
			this.hashNO = this.hashList.length;
			this.hashList[this.hashNO] = newHash;
		}
		//更改后退图片
	},

	//回退
	linkPre : function()
	{
		var preNum = this.hashNO - 1;
		this.linkJump(preNum);
	},
	
	//前进
	linkNext : function()
	{
		var nextNum = this.hashNO + 1;
		this.linkJump(nextNum);
	},

	//刷新
	linkReload : function()
	{
		this.linkJump(this.hashNO);
	},

	//跳转函数，前进、回退均通过此函数跳转
	linkJump : function(index)
	{
		this.hashNO = index;
		var maxNum = this.hashList.length - 1;
		if(index <= 0)	//第一个历史片段处理
		{
			$('' + this.bodyContent +'').innerHTML = this.firstDiv;
			$('linkPre').style.backgroundImage  = "url('img/jump_left_0.png')";
			$('linkPre').removeEvents('click');

			$('linkNext').style.backgroundImage  = "url('img/jump_right_1.png')";	
			this.addClickEvent('linkNext');
		}else{
			if(index >= maxNum)//最后一个历史片段处理
			{
				$('linkPre').style.backgroundImage  = "url('img/jump_left_1.png')";
				this.addClickEvent('linkPre');

				$('linkNext').style.backgroundImage  = "url('img/jump_right_0.png')";
				$('linkNext').removeEvents('click');
			}else{//处理其他的历史片段
				this.addClickEvent('linkPre');
				this.addClickEvent('linkNext');
				$('linkPre').style.backgroundImage  = "url('img/jump_left_1.png')";
				$('linkNext').style.backgroundImage  = "url('img/jump_right_1.png')";
			}	
			var myObject = JSON.decode(this.hashList[index]);
			RQ(myObject.url,pt.writeBody,myObject.params,1);	
		}
	},

	//添加onclick事件
	addClickEvent : function(t)
	{
		var t = t != '' ? t : 'linkReload';
		var func;
		if(t == 'linkPre')
		{
			func = 'goHistory.linkPre()';
		}else if(t == 'linkNext') {
			func = 'goHistory.linkNext()';
		}else{
			func = 'goHistory.linkReload()';
		}
		$('' + t +'').removeEvents('click');
		$('' + t +'').addEvent('click', function(event){
				eval(func);
			});

	},
	
	//测试使用，显示所有的历史记录
	showHash : function() 
	{
		var html  = this.hashList.length + '\t\n';
		for(var k = 0; k < this.hashList.length; k++)
		{
			html += k + ' = ' + this.hashList[k] + '\t\n';
		}
		$('debug').innerHTML = html;
	}
}


function singleSendMail(responseJson) 
{
	var popOk = $('pageConfirm_popOk');
	var popNo = $('pageConfirm_popNo');
	popOk.removeEvents('click');
	popOk.addEvents({
		'click': function(){
					FS('subform',function(message) {
						var msg = message.split("|");
						$('pageConfirm').setStyles({display: "none"});
						if(msg[0] == 1)
						{
							alertFunc(msg[1]);
						}else{
							pageAlert(message);
						}	
				},0);
		}
	});
	popNo.addEvents({
		'click': function(){
				pt.pageMasking("none");
				$('pageConfirm').setStyles({display: "none"});
		}
	});
	pt.pageMasking('block');
	$('pageConfirmHead').set("html", responseJson['title']);
	$('pageConfirm_popBody').set("html", responseJson['body']);
	pt.pagePoping("pageConfirm");
}

/**
 * 设置取消GM账号
 */
function setGm(responseJson) 
{
	var popOk = $('pageConfirm_popOk');
	var popNo = $('pageConfirm_popNo');
	popOk.removeEvents('click');
	popOk.addEvents({
		'click': function(){
				// FS('subform',function(message) {
					// var msg = message.split("|");
					// $('pageConfirm').setStyles({display: "none"});
					// if(msg[0] == 1)
					// {
						// alertFunc(msg[1]);
					// }else{
						// pageAlert(message);
					// }	
				// },0);
				FS('subform',function(message) {
					// alert('111111111');
					var msg = message.split("|");
					$('pageConfirm').setStyles({display: "none"});
					if(msg[0] == 1)
					{
						alertFunc(msg[1],"FS('myform',pt.writeBody,1);");
					}else{
						alertFunc(message,"FS('myform',pt.writeBody,1);");
					}
				},1);
		}
	});
	popNo.addEvents({
		'click': function(){
				pt.pageMasking("none");
				$('pageConfirm').setStyles({display: "none"});
		}
	});
	pt.pageMasking('block');
	$('pageConfirmHead').set("html", responseJson['title']);
	$('pageConfirm_popBody').set("html", responseJson['body']);
	pt.pagePoping("pageConfirm");
}

/**
 * 恢复误丢弃道具确认
 */
function retrieveEquip(responseJson) 
{
	var popOk = $('pageConfirm_popOk');
	var popNo = $('pageConfirm_popNo');
	popOk.removeEvents('click');
	popOk.addEvents({
		'click': function(){
				FS('subform',function(message) {
					var msg = message.split("|");
					$('pageConfirm').setStyles({display: "none"});
					if(msg[0] == 1)
					{
						alertFunc(msg[1],"FS('myform',pt.writeBody,1);");
					}else{
						alertFunc(message,"FS('myform',pt.writeBody,1);");
					}
				},1);
		}
	});
	popNo.addEvents({
		'click': function(){
				pt.pageMasking("none");
				$('pageConfirm').setStyles({display: "none"});
		}
	});
	pt.pageMasking('block');
	$('pageConfirmHead').set("html", responseJson['title']);
	$('pageConfirm_popBody').set("html", responseJson['body']);
	pt.pagePoping("pageConfirm");
}

/**
 * 查询玩家详细信息
 */
function getChDetail(responseJson) 
{
	var popOk = $('pageConfirm_popOk');
	var popNo = $('pageConfirm_popNo');
	popOk.removeEvents('click');
	popOk.addEvents({
		'click': function(){
				// FS('subform',function(message) {
					// // alert('111111111');
					// var msg = message.split("|");
					// $('pageConfirm').setStyles({display: "none"});
					// if(msg[0] == 1)
					// {
						// alertFunc(msg[1],"FS('myform',pt.writeBody,1);");
					// }else{
						// alertFunc(message,"FS('myform',pt.writeBody,1);");
					// }
				// },1);
				$('pageConfirm').setStyles({display: "none"});
				$('pageConfirm').setStyles({width: "400px"});
				FS('myform',pt.writeBody,1);
		}
	});
	popNo.addEvents({
		'click': function(){
				$('pageConfirm').setStyles({display: "none"});
				$('pageConfirm').setStyles({width: "400px"});
				FS('myform',pt.writeBody,1);
		}
	});
	pt.pageMasking('block');
	$('pageConfirm').setStyles({width: "900px"});
	$('pageConfirmHead').set("html", responseJson['title']);
	$('pageConfirm_popBody').set("html", responseJson['body']);
	pt.pagePoping("pageConfirm");
}

/**
 * 查询道具详细信息
 */
function getEquipDetail(responseJson) 
{
	// var popOk = $('pageConfirm_popOk');
	// var popNo = $('pageConfirm_popNo');
	// popOk.removeEvents('click');
	// popOk.addEvents({
		// 'click': function(){
				// $('pageConfirm').setStyles({display: "none"});
				// $('pageConfirm').setStyles({width: "400px"});
				// FS('myform',pt.writeBody,1);
		// }
	// });
	// popNo.addEvents({
		// 'click': function(){
				// $('pageConfirm').setStyles({display: "none"});
				// $('pageConfirm').setStyles({width: "400px"});
				// FS('myform',pt.writeBody,1);
		// }
	// });
	// pt.pageMasking('block');
	// $('pageConfirm').setStyles({width: "1400px"});
	// $('pageConfirmHead').set("html", responseJson['title']);
	// $('pageConfirm_popBody').set("html", responseJson['body']);
	// pt.pagePoping("pageConfirm");
	
	
	var popOk = $('pageAlert_popOk');
	popOk.removeEvents('click');
	popOk.addEvents({
		'click': function(){
				$('pageAlert').setStyles({display: "none"});
				$('pageAlert').setStyles({width: "400px"});
		}
	});
	pt.pageMasking('block');
	$('pageAlert').setStyles({width: "1400px"});
	// $('pageAlertHead').set("html", responseJson['title']);
	$('pageAlert_popBody').set("html", responseJson['body']);
	pt.pagePoping("pageAlert");
}

function rowindex(tr)
{
  if (Browser.isIE)
  {
    return tr.rowIndex;
  }
  else
  {
    table = tr.parentNode.parentNode;
    for (i = 0; i < table.rows.length; i ++ )
    {
      if (table.rows[i] == tr)
      {
        return i;
      }
    }
  }
}

/**
   * 新增一个图片
   */
  function addImg(obj,divName)
  {
      ++addI;
     if($(divName).rows.length>25){
                        alert('您生成的太多了！');
                        return false;
      }
      var src  = obj.parentNode.parentNode;
      var idx  = rowindex(src);
      var tbl  = document.getElementById('gallery-table');
      var row  = tbl.insertRow(idx + 1);
      var cell1 = row.insertCell(-1);
      var cell2 = row.insertCell(-1);
	cell1.style.textAlign="right";
      cell1.innerHTML = src.cells[0].innerHTML;
      cell2.innerHTML += src.cells[1].innerHTML.replace(/(.*)(addImg)(.*)(\[)(\+)/i, "$1removeImg$3$4-");
      if(cell2.innerHTML.indexOf("galleryson") > 0){
	    cell2.innerHTML = cell2.innerHTML.replace(/galleryson\d{1,3}/g,"galleryson"+addI);
	    cell2.innerHTML = cell2.innerHTML.replace(/items\[\d+\]/g, "items["+addI+"]");
      }
  }

  /**
   * 删除图片上传
   */
  function removeImg(obj)
  {
      var row = rowindex(obj.parentNode.parentNode);
      var tbl = document.getElementById('gallery-table');

      tbl.deleteRow(row);
  }

  function addImg2(obj,divName)
  {
      var nums = divName.replace(/[^0-9]/ig,"");
      var src  = obj.parentNode.parentNode;
      var idx  = rowindex(src);
      var tbl  = document.getElementById(divName);
      var row  = tbl.insertRow(idx + 1);
      var cell1 = row.insertCell(-1);
      cell1.innerHTML = src.cells[0].innerHTML.replace(/(.*)(addImg)(.*)(\[)(\+)/i, "$1removeImg$3$4-");	
      if(cell1.innerHTML.indexOf('items') > 0){
		cell1.innerHTML = cell1.innerHTML.replace(/items\[\d+\]/g, "items["+nums+"]");	
      }
  }
  /**
   * 删除图片上传
   */
  function removeImg2(obj,divName)
  {
      var row = rowindex(obj.parentNode.parentNode);
      var tbl = document.getElementById(divName);
      tbl.deleteRow(row);
  }

  /**
  * 公告二次确认
  * 参数说明：remind:提示信息,,
  * 弹出封禁对话框
  */
  function noticeAdd(remind)
  { 
        RQ('./?act=Notice.add&confirm=1',callbackNoticeAdd,'',1);
 }    


/**
 *提交请求回调函数
 */
function callbackNoticeAdd(responseJson)
{
        var popOk = $('pageConfirm_popOk');
        var popNo = $('pageConfirm_popNo');
        
	var server_ids='',title,author,type,begTime,endTime,cycle,pictureUrl,content,status1='';
        var obj1 = document.getElementsByName('server_ids[]'),obj2 = document.getElementsByName('status');
        var i;
        for(i = 0; i < obj1.length; i++)
        {
                if(obj1[i].checked == true)
                {
			server_ids=server_ids?server_ids+','+responseJson['ext']['servername'][obj1[i].value]:responseJson['ext']['servername'][obj1[i].value];
                }
        }
        for(i = 0; i < obj2.length; i++)
        {
                if(obj2[i].checked == true)
                {
                        status1=obj2[i].value;
                }
        }

	popOk.removeEvents('click');
        popOk.addEvents({
                'click': function(){
                                var remind = responseJson['ext']['remind'];
                                NoticeAddConfirm(remind);
                }
        });
        popNo.addEvents({
                'click': function(){
                                pt.pageMasking("none");
                                $('pageConfirm').setStyles({display: "none"});
                }
        });
        pt.pageMasking('block');
        $('pageConfirmHead').set("html", responseJson['title']);
        $('pageConfirm_popBody').set("html", responseJson['body']);
        pt.pagePoping("pageConfirm");
	$('mask_serverName').innerHTML=server_ids?server_ids:$('servername').innerHTML;
        $('mask_title').innerHTML=$('title').value;
        $('mask_author').innerHTML=$('author').value;
        $('mask_begTime').innerHTML=$('begTime').value;
        $('mask_endTime').innerHTML=$('endTime').value;
         $('mask_tollgate_id').innerHTML=$('tollgate_id').value;
        $('mask_cycle').innerHTML=$('cycle').value;
        $('mask_pictureUrl').innerHTML=$('pictureUrl').value;
        $('mask_status'+status1).style.display='';
        $('mask_content').innerHTML=$('contents').value;
		//var oEditor = FCKeditorAPI.GetInstance('content') ;
		// alert(oEditor.GetHTML());
        //$('mask_content').innerHTML=oEditor.GetHTML();
		//$('content').value = oEditor.GetHTML();
	if($('type').value){
        	$('mask_d'+$('type').value).style.display='';
	}
}


/**
 *封禁解禁提交确认操作
 */
function NoticeAddConfirm(remind)
{
        $('pageConfirm').setStyles({display: "none"});
        FS('subform',function(message) {
        		var func = 'RQ("./?act=Notice.lists&actkey=gmt_action_28",pt.writeBody)';
                alertFunc(message, func);
        },1);
} 

function recyle_do_check(obj, selects, checked_status)
{
	var id = obj.id;
	
	var obj_next
	for(var i=0;i<selects.length;i++)
	{
		obj_next = selects[i];

		if (obj_next.getAttribute('pid')==id)
		{
			obj_next.checked = checked_status;
		}
	}

}

function do_check(obj)
{
	var id = obj.id
	var checked_status = obj.checked
	var pid = obj.getAttribute('pid');
	
	var obj_next
	var selects = document.getElementsByName('actions[]');
	for(var i=0;i<selects.length;i++)
	{
		obj_next = selects[i];

		if (obj_next.id == pid)
		{
			obj_next.checked = checked_status;
		}

		if (obj_next.getAttribute('pid')==id)
		{
			recyle_do_check(obj_next, selects, checked_status);
			obj_next.checked = checked_status;
		}
	}

}

function restoreVip(tools_cid, tools_pid, vip_old) 
{
	var msg = "确认执行此操作吗？";
	if(confirm(msg))
	{
		var server_id = $('server_id').value;
		var vip = $('vip').value;

		var url = './?act=Tools.restore&type=1&server_id=' + server_id + '&pid=' + tools_pid + '&cid=' + tools_cid + '&vip=' + vip + '&vip_old=' + vip_old;
		RQ(url,'','',1);
		FS('myform',pt.writeBody);
	}
}

function restoreEquip(tools_cid, tools_pid) 
{
	var msg = "确认执行 [清理道具] 操作吗？";
	if(confirm(msg))
	{
		var server_id = $('server_id').value;
		var equip_id = $('equip_id').value;
		var equip_num = $('equip_num').value;

		var url = './?act=Tools.restore&type=2&server_id=' + server_id + '&pid=' + tools_pid + '&cid=' + tools_cid + '&equip_id=' + equip_id + '&equip_num=' + equip_num;
		RQ(url,'','',1);
		FS('myform',pt.writeBody);
	}
}

function restoreOrderId(tools_cid, tools_pid) 
{
	var msg = "确认执行此操作吗？";
	if(confirm(msg))
	{
		var server_id = $('server_id').value;
		var order_id = $('order_id').value;

		var url = './?act=Tools.restore&type=3&server_id=' + server_id + '&pid=' + tools_pid + '&cid=' + tools_cid + '&order_id=' + order_id;
		RQ(url,'','',1);
		FS('myform',pt.writeBody);
	}
} 

//权限加载
function auth_load(obj) 
{
	var account = obj.value;
	var url = '/?act=Auth.action&type=load&account=' + account;
	RQ(url,function(responseText){
		var len = responseText.body.length;

		if (len > 0)
		{
			var selects = document.getElementsByName('actions[]');
			for(var j=0;j<selects.length;j++)
			{
				var obj_next
				obj_next = selects[j];
				var act_value = obj_next.value;

				for(var i=0;i<len;i++)
				{
					if (act_value == responseText.body[i])
					{
						obj_next.checked = 'checked';
						break;
					}
				}
			}
		}
	});
}

function restoreShouhun(tools_cid, tools_pid) 
{
	var msg = "确认执行 [删除兽魂] 操作吗？";
	if(confirm(msg))
	{
		var server_id = $('server_id').value;
		var shouhun_num = $('shouhun_num').value;

		var url = './?act=Tools.restore&type=4&server_id=' + server_id + '&pid=' + tools_pid + '&cid=' + tools_cid + '&shouhun_num=' + shouhun_num;
		RQ(url,'','',0);
		FS('myform',pt.writeBody);
	}
}

function restoreItemBarEquip(tools_cid, tools_pid) 
{
	var msg = "确认执行 [删除装备栏装备(角色身上)] 操作吗？";
	if(confirm(msg))
	{
		var server_id = $('server_id').value;
		var equip_id = $('itembar_equip_id').value;

		var url = './?act=Tools.restore&type=5&server_id=' + server_id + '&pid=' + tools_pid + '&cid=' + tools_cid + '&equip_id=' + equip_id;
		RQ(url,'','',1);
		FS('myform',pt.writeBody);
	}
}

function restoreItemBarEquipJlLev(tools_cid, tools_pid) 
{
	var msg = "确认执行 [设置装备栏精炼等级] 操作吗？";
	if(confirm(msg))
	{
		var server_id = $('server_id').value;
		var equip_id = $('del_itembarequip_id').value;
		var jl_lev = $('jl_lev').value;

		var url = './?act=Tools.restore&type=6&server_id=' + server_id + '&pid=' + tools_pid + '&cid=' + tools_cid + '&equip_id=' + equip_id + '&jl_lev=' + jl_lev;
		RQ(url,'','',1);
		FS('myform',pt.writeBody);
	}
}


function rewardExtendExpire(tools_id,tools_cid, tools_nick, tools_type) 
{
	var server_id = $('server_id').value;

	var url = './?act=Log.getRewardList&type='+tools_type+'&server_id=' + server_id + '&id=' +tools_id + '&roleId=' + tools_cid + '&roleName=' + tools_nick;
	RQ(url,'','',1);
	FS('myform',pt.writeBody);
}

function restoreGameGold(tools_cid, tools_pid) 
{
	var msg = "确认执行 [扣除赠送魔石] 操作吗？";
	if(confirm(msg))
	{
		var server_id = $('server_id').value;
		var game_gold = $('game_gold').value;

		var url = './?act=Tools.restore&type=7&server_id=' + server_id + '&pid=' + tools_pid + '&cid=' + tools_cid + '&game_gold=' + game_gold;
		RQ(url,'','',0);
		FS('myform',pt.writeBody);
	}
}

function restoreSilver(tools_cid, tools_pid) 
{
	var msg = "确认执行 [扣除金币] 操作吗？";
	if(confirm(msg))
	{
		var server_id = $('server_id').value;
		var silver = $('silver').value;

		var url = './?act=Tools.restore&type=11&server_id=' + server_id + '&pid=' + tools_pid + '&cid=' + tools_cid + '&game_gold=' + silver;
		RQ(url,'','',0);
		FS('myform',pt.writeBody);
	}
}

function restoreOther(tools_cid, tools_pid, tools_type, msg_title) 
{
	var msg = "确认执行 ["+msg_title+"] 操作吗？";
	if(confirm(msg))
	{
		var server_id = $('server_id').value;

		var url = './?act=Tools.restore&type='+tools_type+'&server_id=' + server_id + '&pid=' + tools_pid + '&cid=' + tools_cid;
		RQ(url,'','',0);
		FS('myform',pt.writeBody);
	}
}

function delMessageTree(remind,msg,id) 
{
	var id = id;
	if(id == '' || id == null)
	{
		id = getCheckValue();
	}
	if(id == '')
	{
		debug(remind);
		return false;
	}
	divConfirm(msg,'do_del_message_tree',2,id);

}

function do_del_message_tree(id) 
{
	var server_id = $('server_id').value;
	var url = '/?act=MessageTree.del&server_id=' + server_id +'&id=' + id;
	RQ(url,function(responseText){
			alertFunc(responseText,"FS('myform',pt.writeBody,1)");
		},
	'',1);
}
