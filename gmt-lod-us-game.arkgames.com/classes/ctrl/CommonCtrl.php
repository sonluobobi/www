<?php
namespace ctrl;

//use view;
use framework\mvc\view;
use framework\util;
use framework\mvc\view\smarty;
use framework\core\Context;
use \view\RedirectView;
use	common;

class CommonCtrl extends CtrlBase
{
	public $service; //服务类标识
	public $tpl_name='Base.html'; //基本模板
	public $tpl_query = 'Base.Query.html'; //查询模板
	public $tpl_data = 'Base.Data.html'; //数据展示模板
	public $req_entity_name='comm'; //标识
	public $titles;
	public $fields;
	public $lang_title;//标题国际化标识
	public $query_user_type = true;
	public $query_date_config = array('beginDate', 'endDate'); //查询基本配置

	public function __construct($service_name='CommonService'){
		parent::__construct();
		$this->service = util\Singleton::get("service\\".$service_name);
	}

	public function set_req_entity_name($req_entity_name)
	{
		if (empty($req_entity_name)) return false;
		$this->req_entity_name = $req_entity_name;
		$this->service->set_req_entity_name($req_entity_name);
	}

	public function getData()
	{
		$func_name = $this->dispatcher->getCtrlMethodName();
		$this->set_req_entity_name($func_name);
		return $this->service->$func_name();
	}

	/**
	 * 展示数据
	 * @param  string $tpl_name     [模板名称]
	 * @return [type]               [description]
	 */
	public function display($tpl_name='')
	{
		empty($tpl_name) && $tpl_name = $this->tpl_name;

		$comm_data = array();
		$params = array();
		$params['dataList'] = array();
		$params['pages'] = '';

		if (!empty($_REQUEST['search']) || $_POST['d'] == 1)
		{
			//点击查询后操作
			$comm_data = $this->getData();
			isset($comm_data['list']) && $params['dataList'] =  $comm_data['list'];
			isset($comm_data['pages']) && $params['pages'] =  $comm_data['pages'];
		}

		if($_POST['d'] == 1 && $params['dataList'])
		{
			$title_list = array();
			foreach($this->titles as $title_name)
			{
				$title_list[] = $this->_LANG[$title_name];
			}

			$list_download = $params['dataList'];

			//格式化下载数据
			$fields = $this->fields;
			if (!empty($fields) && !empty($list_download))
			{
				$list_download_tmp = array();
				foreach ($list_download as $_info)
				{
					$tmp = array();
					foreach($fields as $field)
					{
						$tmp[$field] = isset($_info[$field]) ? $_info[$field] : '';
					}
					$list_download_tmp[] = $tmp;
				}

				$list_download = $list_download_tmp;
			}

			array_unshift($list_download, $title_list);

			$filename = Context::getCurrentTime().'_' . $this->lang_title;
			common\PhpExcel::downloadExcel($filename,$this->lang_title,$list_download,'xls');
		}

		$params['titles'] = $this->titles;
		$params['fields'] = $this->fields;
		$params['tpl_query'] = $this->tpl_query;
		$params['tpl_data'] = $this->tpl_data;
		$params['lang_title'] = $this->lang_title;

		$params['query_user_type'] = $this->query_user_type;
		$params['query_date_config'] = $this->query_date_config;

		$params['act'] = $_REQUEST['act'];

		return new smarty\SmartyView($tpl_name, $params);
	}

	public function showJson($tpl_name='')
	{
		empty($tpl_name) && $tpl_name = $this->tpl_name;

		$comm_data = array();
		$params = array();
		$params['dataList'] = array();
		$params['pages'] = '';

		if (!empty($_REQUEST['search']))
		{
			//点击查询后操作
			$comm_data = $this->getData();
			isset($comm_data['list']) && $params['dataList'] =  $comm_data['list'];
			isset($comm_data['pages']) && $params['pages'] =  $comm_data['pages'];
		}

		$params['titles'] = $this->titles;
		$params['fields'] = $this->fields;
		$params['tpl_query'] = $this->tpl_query;
		$params['tpl_data'] = $this->tpl_data;
		$params['lang_title'] = $this->lang_title;

		$params['query_user_type'] = $this->query_user_type;
		$params['query_date_config'] = $this->query_date_config;

		$params['act'] = $_REQUEST['act'];

		$smarty = new smarty\SmartyView($tpl_name, $params);
		$title = $this->_LANG[$this->lang_title];
		return view\JSONView::showJson($title,$smarty->fetch());
	}
}