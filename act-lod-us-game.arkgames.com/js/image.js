var isShowBigImage = false;
function SetShowBigImage(isShow) 
{
	isShowBigImage = isShow;
}
function ShowImage(obj) 
{
	var divObj = "bigImageShow";
	var ttop = event.clientY - 120;       //控件的定位点高(离上一控件的Y)
	var tleft = event.clientX + 30;     //控件的定位点宽(离上一控件的X)
	var thei = obj.clientHeight;    //控件本身的高
	var twid = obj.clientWidth;     //控件本身的宽
	$(divObj).style.top = ttop;//设置显示大图片的位置
	$(divObj).style.left = tleft;
	$(divObj).innerHTML = "<img src='" + obj.src + "' alt='' align='absmiddle'/>";
	SetShowBigImage(true);
	$(divObj).style.display = 'block';
}        
function HideImage() 
{
	SetShowBigImage(false);
	setTimeout(ClearImageA, 1000);
}
function ClearImageA() 
{
	if (!isShowBigImage)
		$('bigImageShow').style.display = 'none';
}