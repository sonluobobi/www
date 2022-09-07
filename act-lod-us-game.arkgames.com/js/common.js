//清楚空格
function trim(vStr)
{
	return vStr.replace(/(^[\s]*)|([\s]*$)/g,"");
}

//检查用户名有效性
function isUsername(vStr)
{
	var re = /^[a-zA-Z]{1}([a-zA-Z0-9]|[_]){3,15}$/;
	return re.test(trim(vStr));
}

//检查用户身份证
function checkID(id)
{
	var idNum = id;
	var errors = new Array(
       "验证通过",
       "身份证号码位数不对",
       "身份证含有非法字符",
       "身份证号码校验错误",
       "身份证地区非法"
		);
		//身份号码位数及格式检验
		
		var re;
		var len = idNum.length;
         //身份证位数检验
		if(len != 15 && len != 18)
		{
			return false; 
        }
		else if(len == 15)
		{
			re = new RegExp(/^(\d{6})()?(\d{2})(\d{2})(\d{2})(\d{3})$/);
        }
		else
		{
			re = new RegExp(/^(\d{6})()?(\d{4})(\d{2})(\d{2})(\d{3})([0-9xX])$/); 
		}

      var area={11:"北京",12:"天津",13:"河北",14:"山西",
       15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",
       32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",
       37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",
       45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",
       53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",
       64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",
       91:"国外"}

        var idcard_array = new Array();
        idcard_array = idNum.split("");
      
        //地区检验
        if(area[parseInt(idNum.substr(0,2))]==null) 
		{
			return false; 
        }

        //出生日期正确性检验
        var a = idNum.match(re);
        
        if (a != null)
		{
            if (len==15)
			{
				var DD = new Date("19"+a[3]+"/"+a[4]+"/"+a[5]);
				var flag = DD.getYear()==a[3]&&(DD.getMonth()+1)==a[4]&&DD.getDate()==a[5];
            }
			else if(len == 18)
			{
				var DD = new Date(a[3]+"/"+a[4]+"/"+a[5]);
				var flag = DD.getFullYear()==a[3]&&(DD.getMonth()+1)==a[4]&&DD.getDate()==a[5];
            }

            if (!flag)
			{
				return false;
            }
          
            //检验校验位
            if(len == 18)
			{
				S = (parseInt(idcard_array[0]) + parseInt(idcard_array[10])) * 7
				+ (parseInt(idcard_array[1]) + parseInt(idcard_array[11])) * 9
				+ (parseInt(idcard_array[2]) + parseInt(idcard_array[12])) * 10
				+ (parseInt(idcard_array[3]) + parseInt(idcard_array[13])) * 5
				+ (parseInt(idcard_array[4]) + parseInt(idcard_array[14])) * 8
				+ (parseInt(idcard_array[5]) + parseInt(idcard_array[15])) * 4
				+ (parseInt(idcard_array[6]) + parseInt(idcard_array[16])) * 2
				+ parseInt(idcard_array[7]) * 1 
				+ parseInt(idcard_array[8]) * 6
				+ parseInt(idcard_array[9]) * 3 ;
            
				Y = S % 11;
				M = "F";
				JYM = "10X98765432";
				M = JYM.substr(Y,1);//判断校验位
            
				//检测ID的校验位
				if(M == idcard_array[17])
				{
					return true;
				}
				else
				{
					return false; 
				} 
			}
		}
		else
		{
			return false; 
		}
	return true;
}

//检查用户真实名字
function isChinese(str)
{
	var badChar ="ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
		badChar += "abcdefghijklmnopqrstuvwxyz"; 
		badChar += "0123456789"; 
		badChar += " "+"　";//半角与全角空格 
		badChar += "`~!@#$%^&()-_=+]\\\\|:;\\\\\'<,>?/";//不包含*或.的英文符号 
	if ("" == str)
	{
		return false;
	}
	if (str.length < 2 || str.length > 4)
	{
		return false; 
	}
	for(var i=0;i<str.length;i++)
	{
		var c = str.charAt(i);//字符串str中的字符 
		if(badChar.indexOf(c) > -1)
		{
			return false; 
		}
	}
	return true; 
}

//密码格式是否正确
function isPassword(vStr)
{
	var vReg = /^[\w]{6,20}$/;
	$res = vReg.test(vStr);
	if (vStr.length < 6) return false;
	if (vStr.length > 20) return false;
	if(!$res)return false;
	return true;
}

//昵称格式是否正确
function isNickName(vStr)
{
	var re=/^(\w|[\u4E00-\u9FA5]){1,25}$/;
	return re.test(trim(vStr));
}

//检查邮箱格式
function isEmail(vStr)
{
	var re= /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,4}){1,4})$/;
	return re.test(trim(vStr));
}

//检查电话格式
function isPhone(vStr)
{ 
	if (6 > vStr.length)
		return false;
	var Letters = "0123456789()+-";
	for (i = 0; i < vStr.length; i++)
	{
		var CheckChar = vStr.charAt(i);
		if (Letters.indexOf(CheckChar) == -1)
		{
			return false;
		}
	}
	return true;
}

//检查邮政编码
function isZipcode(vStr)
{
    var i,j,strTemp;
     strTemp="0123456789";
    if ( vStr.length !=6)
        return false;
    for (i=0;i<vStr.length;i++)
    {
		j=strTemp.indexOf(vStr.charAt(i));
		if (j==-1)
			return false;
    }
    return true;
}

//判断是否为数字
function isNumeric(vStr)   
{
	var ValidChars = "0123456789";
	var IsNumber=true;
	var Char;

	for (i = 0; i < vStr.length && IsNumber == true; i++)
	{
		Char = vStr.charAt(i);
		if (ValidChars.indexOf(Char) == -1)
		{
			IsNumber = false;
			break;
		}
	}   
	return IsNumber;      
}  

//全选/全取消 checkbox
function doSelectAll(theBox, theName, theState)
{
	elm = theBox.form.elements;
  	for (i = 0; i < elm.length; i++) 
  	{
		if (("checkbox" == elm[i].type) && (-1 != elm[i].name.indexOf(theName)))
		{
			elm[i].checked = theState;
		}
	}
}

//判断是否最少选择一项checkbox
function doCheckSelect(theBox, theName)
{
	elm = theBox.form.elements;
  	for (i = 0; i < elm.length; i++) 
  	{
		if (("checkbox" == elm[i].type) && (-1 != elm[i].name.indexOf(theName)) && (true == elm[i].checked))
		{
			return true;
		}
	}
	return false;
}

//判断获取checkbox系列的值
function getCheckValue(theBox, theName)
{
	elm = theBox.form.elements;
	val = '';
  	for (i = 0; i < elm.length; i++) 
  	{
		if (("checkbox" == elm[i].type) && (-1 != elm[i].name.indexOf(theName)) && (true == elm[i].checked))
		{
			val += elm[i].value + '_';
		}
	}
	if ('' != val)
		val = val.substr(0, val.length - 1);
	
	return val;
}

function urlencode (str) {
    var hexStr = function (dec) {
        return '%' + (dec < 16 ? '0' : '') + dec.toString(16).toUpperCase();
    };

    var ret = '',
            unreserved = /[\w.-]/; // A-Za-z0-9_.- // Tilde is not here for historical reasons; to preserve it, use rawurlencode instead
    str = (str+'').toString();

    for (var i = 0, dl = str.length; i < dl; i++) {
        var ch = str.charAt(i);
        if (unreserved.test(ch)) {
            ret += ch;
        }
        else {
            var code = str.charCodeAt(i);
            if (0xD800 <= code && code <= 0xDBFF) { // High surrogate (could change last hex to 0xDB7F to treat high private surrogates as single characters); https://developer.mozilla.org/index.php?title=en/Core_JavaScript_1.5_Reference/Global_Objects/String/charCodeAt
                ret += ((code - 0xD800) * 0x400) + (str.charCodeAt(i+1) - 0xDC00) + 0x10000;
                i++; // skip the next one as we just retrieved it as a low surrogate
            }
            // We never come across a low surrogate because we skip them, unless invalid
            // Reserved assumed to be in UTF-8, as in PHP
            else if (code === 32) {
                ret += '+'; // %20 in rawurlencode
            }
            else if (code < 128) { // 1 byte
                ret += hexStr(code);
            }
            else if (code >= 128 && code < 2048) { // 2 bytes
                ret += hexStr((code >> 6) | 0xC0);
                ret += hexStr((code & 0x3F) | 0x80);
            }
            else if (code >= 2048) { // 3 bytes (code < 65536)
                ret += hexStr((code >> 12) | 0xE0);
                ret += hexStr(((code >> 6) & 0x3F) | 0x80);
                ret += hexStr((code & 0x3F) | 0x80);
            }
        }
    }
    return ret;
}