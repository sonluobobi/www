// -*-coding:utf-8; mode:javascript-mode;-*-

/**
 * isHis 是否添加为历史记录
 */
function FS(formId, callback, isHis)
{
	// alert('before');
	var queryForm = $(formId);
	if($type(queryForm)=="element" && queryForm.tagName=='FORM')
	{
		var send  = queryForm.toQueryString();
		var url   = queryForm.action;
		// alert(url);
		// pt.alert('url' + url + ' send' + send);
		RQ(url, callback, send, isHis);
	}
}

function RQ(url, callback, send, isHis)
{
	pt.pageLoading("block");
	var nSend   =  null  ;
	var nMethod = 'get'  ;
	var nUrl    =  url   ;
	if ($type(send)=="string" && send!="")
	{
		nSend   = send;
		nMethod = 'post'
	}
	
	var jsonRequest = new Request({
		url: nUrl,
		method: nMethod,
		//evalScripts: true,
		onSuccess: function(responseText, responseXML) {
		
		/**
		 * 为兼容IE浏览器做新的修改
		 * author ：Juezhong Long
		 * date : 2010-07-23
		 */
		//修改开始位置
		try{
			pt.alert(responseXML);
		}
		catch(e)
		{
			pt.pageLoading("none");
			if(typeof callback == "function")
			{
				var obj = null;
				try {
					obj = JSON.decode(responseText);
				}
				catch(e) { ; }

				if(obj == null)
				{
					obj = responseText;
				}
				callback.call(window, obj);
			}
		}
		//修改结束位置	

			/*if (responseXML==null)
			{
				if(typeof callback == "function")
				{
					var obj = null;
					try {
						obj = JSON.decode(responseText);
					}
					catch(e) { ; }

					if(obj == null)
					{
						obj = responseText;
					}
					callback.call(window, obj);
				}
			}
			else {
				pt.alert(responseXML);
			}*/
		}
	}).send(nSend);
	
	/**
	 * 为实现历史前进、后退新增 isHis 为可选参数
	 * author : Juezhong long
	 * date : 2010-07-21
	 */
	var isHis = isHis == undefined ? true : false;
	if(isHis && typeof(goHistory) == 'object')
	{
		var params = send == undefined ? '' : send;
		goHistory.addHash(JSON.encode({url: url, params: params}));
	}
};

var PageInit = new Class({

	initialize: function()
	{
		this.popDivInit();
		this.menuInit();
	},

	menuInit: function()
	{
		var menuGrp = $$('div.menuDiv');
		menuGrp.each(function(item, index){
			var itemAct      = item.getPrevious();
			var itemActFirst = itemAct.getFirst();
			var itemActBkimg = itemActFirst.getStyle('background-image');
			var itemDisplay = item.getStyle('display');
			itemActFirst.setStyle('background-image',
								  (itemDisplay=="none") ? itemActBkimg.replace('_down', '_right'):
								  itemActBkimg.replace('_right', '_down'));
			itemAct.addEvent('click', function(e){
				var itemDisplay = item.getStyle('display');
				var itemActBkimg  = itemActFirst.getStyle('background-image');
				item.setStyle('display', (itemDisplay=="none") ? 'block' : 'none');
				itemActFirst.setStyle('background-image',
									  (itemDisplay=="none") ? itemActBkimg.replace('_right', '_down'):
									  itemActBkimg.replace('_down', '_right'));
			});
		});
	},

	popDivInit: function()
	{
		var mye = $$('div.popDiv');
		mye.each(function(item, index){
			var nHandle = item.getFirst().getFirst();
			var alertDrag = new Drag.Move(item, {
				container: 'pageMask',
				snap: 5,
				handle: nHandle
			});
		});
	}
});

var pt = {
	
	location: function(url)
	{
		location = url;
	},

	writeBody: function(html)
	{
		$('bodyContents').set("html", html);
		var editor = $('content');
		if(editor != null)
		{
			createEditor();
		}
	},

	alert: function(responseXML)
	{
		var myeOk = $('pageAlert_popOk');
		myeOk.addEvents({
			'click': function(){
					pt.pageMasking("none");
					$('pageConfirm').setStyles({display: "none"});
					$('pageAlert').setStyles({display: "none"});
					myeOk.removeEvents('click');
			}
		});
		this.pageMasking("block");
		var message = responseXML.getElementsByTagName("message")[0].childNodes[0].nodeValue;
		$('pageAlert_popBody').set("html", message);
		this.pagePoping("pageAlert");
	},
	
	confirm: function(responseXML)
	{
		var myeOk = $('pageAlert_popOk');
		myeOk.addEvents({
			'click': function(){
					pt.pageMasking("none");
					$('pageAlert').setStyles({display: "none"});
			}
		});
		this.pageMasking("block");
		var message = responseXML.getElementsByTagName("message")[0].childNodes[0].nodeValue;
		$('pageAlert_popBody').set("html", message);
		this.pagePoping("pageConfirm");
	},

	pageLoading: function(display)
	{
		this.pageMasking(display);
		$('pageLoad').setStyles({display: display});
	},
	
	pageMasking: function(display)
	{
		var nHeight = window.getScrollHeight()+'px';
		$('pageMask').setStyles({top: '0px', height: nHeight, display: display});
	},
	/**
	 * 关闭警告
	 */
	alertCancel: function()
	{
		this.popCancel('pageConfirm');
	},
	/**
	 * 关闭弹出
	 */
	popCancel: function(elt)
	{
		var mye = $$('div.popDiv');
		var elt = $(elt);
		var myeCount = 0;
		mye.each(function(item, index){
			if (item==elt) {
				pt.divToggle(elt, 'none');
			} else if (item.getStyle('display')=="block") {
				myeCount++;
			}
		});
		if (myeCount==0 && $('pageLoad').getStyle("display")=="none") { this.pageMasking('none'); }
	},

	pagePoping: function(elt)
	{
		this.pageMasking("block");
		
		var mye = $(elt);
		if ($type(mye)!="element") { return; }
		mye.setOpacity(0);
		mye.setStyles({display: "block"});

		var ew = mye.getStyle("width").toInt();
		var ww = $(window).getScrollWidth().toInt();
		var lt = (ww/2 - ew/2) + 'px';
		var tp = $(document.body).getScrollTop().toInt() + $(window).getHeight().toInt()/3;

		mye.setStyles({left: lt, top: tp});
		mye.setOpacity(1);
	},

	divToggle: function(elt, display)
	{
		var mye = $(elt); if (mye==null) { return; }
		var nDisplay = mye.getStyle('display');
		if ($type(display)==false) {
			display = (nDisplay=="block") ? 'none' : 'block';
		} else {
			display = (display=="none") ? 'none' : 'block';
		}
		mye.setStyle("display", display);
		return display;
	},
	
	/**
	 * 下拉层按钮控制，上下箭头，凸起凹下控制
	 */
	buttonToggle: function(elt, grp)
	{
		var mye = $(elt); var myt = $(elt+'Act').getFirst();
		if (mye==null || myt==null) { return; }
		var myd = mye.get('id');
		if ($type(grp)!=false)
		{
			$$(grp).each(function(item, index) { 
				var itd = $(item).get('id');
				if (itd==myd) { $(itd+'Act').blur(); return; }
				pt.divToggle(item, 'none');
				var myb = $(itd+'Act').getFirst().getFirst().getFirst();
				myb.setStyle('background-image', myb.getStyle('background-image').replace('up.gif', 'down.gif'));
				$(itd+'Act').getFirst().setStyle("background-position", "left top");

				if (grp=="div.ctrlBar")
				{
					$(itd+'Act').getFirst().setStyle("border-bottom-color", "#aaa");
					$(itd+'Act').getFirst().addEvents({
						'mouseover': function(){ $(itd+'Act').getFirst().setStyle("border-bottom-color", "#888"); },
						'mouseout':  function(){ $(itd+'Act').getFirst().setStyle("border-bottom-color", "#aaa"); }
					});
				}
			});
		}
		var myb = myt.getFirst().getFirst();
		var display = pt.divToggle(mye);
		if (display=="none") {
			myb.setStyle('background-image', myb.getStyle('background-image').replace('up.gif', 'down.gif'));
			myt.setStyle("background-position", "left top");
			if (grp=="div.ctrlBar")
			{
				myt.setStyle("border-bottom-color", "#888");
				myt.addEvents({
					'mouseover': function(){ myt.setStyle("border-bottom-color", "#888"); },
					'mouseout':  function(){ myt.setStyle("border-bottom-color", "#aaa"); }
				});
			}
		} else {
			myb.setStyle('background-image', myb.getStyle('background-image').replace('down.gif', 'up.gif'));
			myt.setStyle("background-position", "left bottom");
			if (grp=="div.ctrlBar")
			{
				myt.setStyle("border-bottom-color", "#fff");
				myt.addEvents({
					'mouseover': function(){ myt.setStyle("border-bottom-color", "#fff"); },
					'mouseout':  function(){ myt.setStyle("border-bottom-color", "#fff"); }
				});
			}
		}
	}
};
