
function checkTime(ctime, obj)
{
	if(ctime == '') {
		alert('时间为空')
		obj.focus();
		return false;
	}
	var arr_time = ctime.split(':');
	var hour = trim(arr_time[0]);
	var min = trim(arr_time[1]);
	if (!isNumeric(hour) || !isNumeric(min)) {
		alert("时间格式错误");
		obj.focus();
		return false;
	}
	if (parseInt(hour) >= 24 || parseInt(hour) < 0 || parseInt(min) >= 60 || parseInt(min) < 0) {
		alert("时间格式错误");
		obj.focus();
		return false;
	}
	return true;
}

function checkDatetime(cdatetime, obj)
{
	if (check(cdatetime) == false) {
		alert("请正确输入时间,日期与时间之间用空格隔开,精确到秒(如：2008-04-19 09:00:00)");
		obj.focus();
		return false;
	}
	if (cdatetime.length != 19) {
		alert("时间格式错误，长度必须是19");
		return false;
	}
	if(cdatetime.substring(11,13)<0 || cdatetime.substring(11,13)>23){
		alert("时间的小时已超出0到23范围，请重新输入");
		obj.focus();
		return false;
	}
	if(cdatetime.substring(14,16)<0 || cdatetime.substring(14,16)>59){
		alert("时间的小时已超出0到59范围，请重新输入");
		obj.focus();
		return false;
	}
	if(cdatetime.substr(17,2)<0 || cdatetime.substr(17,2)>59){
		alert("时间的小时已超出0到59范围，请重新输入");
		obj.focus();
		return false;
	}

	var dateStart=cdatetime.split('-');
	if(dateStart.length!=3) {
		alert('请输入正确的开始发布时间格式');
		obj.focus();
		return false;
	}
	for(var i=0;i<dateStart.length;i++) {
		if(dateStart[i]=="") {
			alert('请输入正确的开始发布时间格式');
			obj.focus();
			return false;
		}
	}
	var yearlyStart=year(dateStart[0]);
	var monthlyStart=month(dateStart[1]);
	if (yearlyStart==0&&monthlyStart==0) {
		var days = numberOfDays(dateStart[1],dateStart[0]);
		today = new Date();
		y = today.getYear();
		m = (today.getMonth() + 1);
		if (dateStart[0] < y){
   			alert("时间中请输入年份大于等于今年的年份");
   			obj.focus();
   			return false;
		}
		if (dateStart[2].substring(0,2)<=days && dateStart[2].substring(0,2)>0) {
 			//;
		} else {
 			alert("对不起此月只有"+days+"天");
 			obj.focus();
 			return false;
		}
	} else {
 		alert("时间中请输入年份小于1970的年份，月份1至12月份");
 		obj.focus();
 		return false;
	}
	return true;
}
function month(month)
{
 if(month>=1&&month<=12)
  return 0;
 else
  return 1;
}
function year(year)
{
 if(year>=1970)
  return 0;
 else
  return 1;
}
function numberOfDays(month,year)
{
    month=month-1;
    var numDays=new Array(31,28,31,30,31,30,31,31,30,31,30,31);
    n=numDays[month];
    if(month==1&&year%4==0) ++n;
    return n;
}
function  check(datetimeStr){   
	var r = datetimeStr.match(/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/);     
    if(r==null)
        return false;
    return true; 
}

function isArray(obj)
{ 
    return (typeof obj=='object') && obj.constructor==Array; 
} 

function selectOption(select_id, check_id)
{
	var obj = document.getElementById(select_id);
	for (var i=0;i<obj.options.length;++i) {
		if (obj.options[i].value == check_id) {
			obj.options[i].selected = true;
			break;
		}
	}
}

function showTip(id)
{
	var obj = document.getElementById(id);
	obj.style.display = 'block';
}

function hidTip(id)
{
	var obj = document.getElementById(id);
	obj.style.display = 'none';
}
