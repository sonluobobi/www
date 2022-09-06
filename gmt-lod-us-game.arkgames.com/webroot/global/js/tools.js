
function queryNextServer()
{
	var obj = document.getElementById('server_id');
	var len = obj.options.length;
	var selected_index = '';
	var selected_value = '';
	for(var i=0; i < len; i++)
	{
		if(obj.options[i].selected == true)
		{
			selected_index = i;  //被选中项的索引
			selected_value = obj.options[i].value; //被选中项的值
			break;
		}
	}
	selected_index = selected_index >len ? len : selected_index;
	selected_index = selected_index +1;
	obj.options[selected_index].selected = true;
}

//查询上一个游戏服
function queryUpServer()
{
	var obj = document.getElementById('server_id');
	var len = obj.options.length;
	var selected_index = '';
	var selected_value = '';
	for(var i=0; i < len; i++)
	{
		if(obj.options[i].selected == true)
		{
			selected_index = i;  //被选中项的索引
			selected_value = obj.options[i].value; //被选中项的值
			break;
		}
	}
	selected_index = selected_index >0 ? selected_index : 1;
	selected_index = selected_index - 1;
	obj.options[selected_index].selected = true;
}