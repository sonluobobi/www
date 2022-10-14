<?php
/**
 * @filesource NoticeDao.php
 * @desc 游戏用户查询接口，Dao层;通过查询数据库或REST方式请求远程服务器获取数据信息
 * @author Juezhong Long
 * date 2010-07-13
 */

namespace dao;

use common;
use framework\data\pdo;

class NoticeDao 
{
	private $pdoHelper;
	private $pdo;
	
	function __construct() 
	{
		$this->pdo = pdo\PDOManager::getInstance("default");
		$this->pdoHelper = new pdo\PDOHelper("entity\\Notice");
        $this->pdoHelper->setPdo($this->pdo);
	}
	
	
	
	/**
	 * 获取所有本地公告
	 * @param unknown_type $platform
	 */
	public function getLocalNoticeList()
	{
		$where = " 1 ";
		
		if ($_SESSION['gupFlag']) 
		{
			$where .= " AND platform = '{$_SESSION['gupFlag']}'";
		}
		
		if ($_POST['title'])
		{
			$where .= " AND title LIKE '%{$_POST['title']}%'";
		}
		
		if ($_POST['begTime'])
		{
			$where .= " AND begTime >= '{$_POST['begTime']}'";
		}
		
		if ($_POST['endTime'])
		{
			$where .= " AND endTime <= '{$_POST['endTime']}'";
		}
		
		if ($_GET['id'])
		{
			$where .= " AND id={$_GET['id']}";
		}
				
		$notice_list = $this->pdoHelper->fetchAll($where,null,'*','id DESC');
		
		return $notice_list;
	}
	
	/**
	 * 获取所有本地正在生效的公告
	 * @param unknown_type $platform
	 */
	public function getNowNoticeList()
	{
		$where = " 1 ";

 		$now_date = date('Y-m-d h:i:s', time());


		$where .= " AND endTime >= '{$now_date}'";

		
		$notice_list = $this->pdoHelper->fetchAll($where,null,'*','id DESC');

		return $notice_list;
	}
	
	/**
	 * 获取所有本地公告
	 * @param unknown_type $platform
	 */
	public function getNoticeById($id)
	{
		$where .= " id IN({$id})";
		$notice = $this->pdoHelper->fetchAll($where,null,'*','id DESC');
	
		return $notice;
	}
	
	/**
	 * 获取所有本地公告
	 * @param unknown_type $platform
	 */
	public function getMaxNoticeId()
	{
		$sql = "select MAX(id) AS max_id from gm_notice LIMIT 1";
		$notice = $this->pdoHelper->fetchOneRecord($sql);
		if ($notice) 
		{
			$max_id = $notice['max_id'];
		}
		return $max_id;
	}
	
	
	public function deleteLocalNotice($id)
	{
		$where = " id IN({$id})";
		return $this->pdoHelper->remove($where);
	}
	
	
	/**
	 * 添加本地公告
	 * @param unknown_type $arr_param
	 */
	public function addLocalNotice($arr_param)
	{
		$fields  = array_keys($arr_param);
		return $this->pdoHelper->replaceRecord($arr_param, $fields);
	}

	/**
	 * 根据公告id列表，批量更新公告信息
	 * @param string $ids
	 * @param array $data
	 * @return boolean
	 */
	public function updateLocalNoticeByIds($ids, $data)
	{
		$where .= " id IN($ids)";
		$ret = $this->pdoHelper->update(array_keys($data),$data,$where);
	
		return $ret;
	}	
	
	/**
	 * 公告列表显示
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function getNoticeList($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_getNoticeList",$RestHost,$RestParams);
	}	
	
	/**
	 * 新增公告
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function setNotice($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_setNotice",$RestHost,$RestParams);
	}
	
	/**
	 * 删除公告
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function deleteNotice($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_deleteNotice",$RestHost,$RestParams);
	}

	/**
	 * 邮件发送
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function sendMail($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_sendMail",$RestHost,$RestParams);
	}
	
	/**
	 * 添加全服邮件
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function sendSysMail($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_sendSysMail",$RestHost,$RestParams);
	}
	
	/**
	 * 获取全服邮件
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function getSysMailList($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_getSysMailList",$RestHost,$RestParams);
	}
		
	/**
	 * 邮件发送入队列
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array 
	 */
	public function sendMailInsert($data,$serverList)
	{
		$arr->interfaceName = "Rest_sendMail";
		$arr->serverList = $serverList;
		$arr->dataResult = serialize($data);
		$queueObject = new \dao\QueueDao();
		return  $queueObject->QueueInsert($arr);
	}	
	
	/**
	 * 道具发送入队列
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array 
	 */
	public function sendPropsInsert($data,$serverList)
	{
		$arr->interfaceName = "Rest_Awards";
		$arr->serverList = $serverList;
		$arr->dataResult = serialize($data);
		$arr->status=3;
		$queueObject = new \dao\QueueDao();
		return  $queueObject->QueueInsert($arr);
	}	
		
	public function getsendPropsList($pagecount,$pageCurrent,$type)
        {
                $queueObject = new \dao\QueueDao();
                return $queueObject->getAwardsList($pagecount,$pageCurrent,$type);

        }

        public function sendPropsConfirm($arr_queue_id)
        {
                $queueObject = new \dao\QueueDao();
                foreach ($arr_queue_id as $queue_id)
                {
                	if (!$queueObject->sendPropsConfirm($queue_id))
                	{
                		return false;
                	}
                }
                return true;
        }

	public function sendPropsDel($arr_queue_id)
	{
                $queueObject = new \dao\QueueDao();
                foreach ($arr_queue_id as $queue_id)
                {
                	if (!$queueObject->sendPropsDel($queue_id))
                	{
                		return false;
                	}
                }
                return true;
                //return $queueObject->sendPropsDel($queue_id);
    }

    public function sendPropsRecal($arr_queue_id)
	{
                $queueObject = new \dao\QueueDao();
                foreach ($arr_queue_id as $queue_id)
                {
                	if (!$queueObject->sendPropsRecal($queue_id))
                	{
                		return false;
                	}
                }
                return true;
                //return $queueObject->sendPropsDel($queue_id);
    }
    
	/**
	 * 检查角色名
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function checkNicks($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_checkNicks",$RestHost,$RestParams);
	}

	/**
	 * 获取道具详细信息
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function getEquipDetail($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_getEquipDetail",$RestHost,$RestParams);
	}

	/**
	 * 查询误丢弃道具
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function getDiscardEquipList($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_getDiscardEquipList",$RestHost,$RestParams);
	}

	/**
	 * 恢复误丢弃道具
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function retrieveEquip($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_retrieveEquip",$RestHost,$RestParams);
	}
}

?>
