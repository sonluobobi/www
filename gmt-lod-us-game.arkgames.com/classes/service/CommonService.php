<?php 

namespace service;
use entity;
use dao;
use common;
use framework\util;

class CommonService extends ServersAbs
{
	public $pagecount;
	public $page;
	public $server_id;
	public $server_all = false;
	public $server_name;
	public $req_entity_name='comm'; //标识
	public $method='DataAccesser.getEntityList';
	public $check_server_id_flag = true; //检查服务器
	public $check_user_type_flag = true; //检查用户类型及值
	public $check_date_flag = true; //同时检查开始及结束日期
	public $check_endDate_flag = false; //检查结束日期
	public $check_beginDate_flag = false; //检查开始日期

	public function __construct()
	{
		parent::__construct();

		$server_id = $this->httpGetVal('server_id');

		if($server_id)
		{
			$this->server_id = $server_id;
			if($server_id == 9999) {
				$this->server_all = true;
			}else {
				$this->server_url  = common\Functions::getServerUrl($server_id,'server');
				$this->server_name = common\Functions::getServerUrl($server_id,'serverName');
			}
		}
		
		$this->pagecount = !empty($_REQUEST['pagecount']) ? $_REQUEST['pagecount'] : 30;
		$this->page = !empty($_REQUEST['p']) ? $_REQUEST['p'] : 1;

		if(!empty($_POST['d']) && $_POST['d'] == 1)
		{
			$this->pagecount = $_REQUEST['pagecount'] = 5000;
			$this->page = $_REQUEST['p'] = 1;
		}
	}

	public function show_error($msg='')
	{
		if (empty($msg)) return false;

		throw new \Exception($msg);
		return false;
	}

	/**
	 * 获取http字段值
	 * @param unknown_type $key
	 * @return string
	 */
	public function httpGetVal($key)
	{
		$value = '';
		
		if (isset($_POST[$key])) 
		{
			$value = $_POST[$key];
		}
		
		if (!$value)
		{
			if (isset($_GET[$key]))
			{
				$value = $_GET[$key];
			}
		}
		
		$value = trim($value);
		
		return $value;
	}

	//设置标识
	public function set_req_entity_name($req_entity_name='')
	{
		!empty($req_entity_name) && $this->req_entity_name = $req_entity_name;
	}

	public function set_method($method='')
	{
		!empty($method) && $this->method = $method;
	}

	//获取传递给服务器端参数
	public function getRestParam()
	{
		$arr_data = array();

		$method = 'get_param_'.$this->req_entity_name;

		if (method_exists($this, $method))
		{
			$arr_data = $this->$method($arr_data);
		}
		else
		{
			$arr_data = $_REQUEST;
		}

		//传递查询标识
		$arr_data['req_entity_name'] = $this->req_entity_name;
		unset($arr_data['search'], $arr_data['act']);

		return $arr_data;
	}

	//验证参数
	public function check_params()
	{
		$ret = true;

		if ($this->check_server_id_flag && empty($this->server_id))
		{
			return $this->show_error($this->_LANG['SelectServers']);
		}

		if ($this->check_date_flag)
		{
			$ret = $this->check_date();
		}

		if ($this->check_user_type_flag)
		{
			$ret = $this->check_user_type();
		}

		$method = 'check_params_'.$this->req_entity_name;

		if (method_exists($this, $method))
		{
			$ret = $this->$method();
		}

		return $ret;
	}

	//验证用户类型
	public function check_user_type()
	{
		$user_type = $this->httpGetVal('user_type');
		$user_value = $this->httpGetVal('user_value');

		if (empty($user_type) || empty($user_value))
		{
			$this->show_error($this->_LANG['userTypeError']);
			return false;
		}

		return true;
	}

	//验证开始日期
	public function check_beginDate()
	{
		$beginDate = $this->httpGetVal('beginDate');

		if (empty($beginDate))
		{
			$this->show_error($this->_LANG['begOrEndDateEmpty']);
			return false;
		}

		return true;
	}

	//验证结束日期
	public function check_endDate()
	{
		$endDate = $this->httpGetVal('endDate');

		if (empty($endDate))
		{
			$this->show_error($this->_LANG['begOrEndDateEmpty']);
			return false;
		}

		return true;
	}

	//同时验证开始及结束日期
	public function check_date()
	{
		$beginDate = $this->httpGetVal('beginDate');
		$endDate = $this->httpGetVal('endDate');

		if (empty($beginDate) || empty($endDate))
		{
			throw new \Exception($this->_LANG['begOrEndDateEmpty']);
			return false;
		}

		if(strtotime($beginDate)>strtotime($endDate)){
			$this->show_error($this->_LANG['dateError']);
			return false;
		}

		return true;
	}

	//格式化数据
	public function formatData($arr_data)
	{
		if (empty($arr_data) || !is_array($arr_data)) return array();

		$method = 'format_'.$this->req_entity_name;

		if (method_exists($this, $method))
		{
			$arr_data = $this->$method($arr_data);
		}

		return $arr_data;
	}

	//通用获取数据
	public function comm()
	{
		$tempArr = array();
		//验证参数
		$check_flag = $this->check_params();

		if (!$check_flag)
		{
			return $tempArr;
		}

		$restParam = $this->getRestParam();
		//$this->show_error(json_encode($restParam));
		$ret = common\Rest::CallCommRestInterFace($this->method,$this->server_url.RESTSUFFIX,$restParam);
		if($ret['retcode'] != 0) $this->show_error($ret['retmsg']);
		$tempArr['list'] = $this->formatData($ret['data']);
        $subPages = new common\SubPages($this->pagecount,$ret['total'],$this->page);
        $tempArr['pages'] = $subPages->show_SubPages();
		$tempArr['sum'] = empty($tempArr['list']) ? 0 : count($tempArr['list']);
		return $tempArr;
	}
}