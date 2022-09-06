<?php
namespace dao;

use framework\data\pdo;

class QueueDao {
	/**
	 * 
	 * @var framework\data\pdo\PDOHelper
	 */
	private $pdoHelper;
	private $pdo;
	/** 
	 * 构造函数
	 * 
	 * @return 
	 */
	public function __construct()
	{
		$this->pdo = pdo\PDOManager::getInstance("default");

		$this->pdoHelper = new pdo\PDOHelper("entity\\Queue");
        $this->pdoHelper->setPdo($this->pdo);
	}
	/**
	 * 队列入库
	 */
	public function QueueInsert($object){
		$object->queueDate = date("Y-m-d H:i:s");
		$object->serverGroup = $_SESSION['gup'];
		$object->productId = $_SESSION['productId'];
		$filed = array();
		foreach ($object as $key=>$value){
			$filed[] = $key;
		}
		return  $this->pdoHelper->add($object,$filed);
	}

	public function getAwardsList($pagecount,$pageCurrent,$type){
		switch($type){
			case 1:
				$status='status=2';
				break;
			case 2:
				$status='status=1';
				break;
			case 3:
				$status='status=3';
				break;
			case 4:
				$status='status>=4';
				break;
		}
		$num=$this->pdoHelper->fetchValue("serverGroup={$_SESSION['gup']} and productId={$_SESSION['productId']} and interfaceName='Rest_Awards' and {$status}",null,'count(*) as num');
		if(!$num){
			$result=array(0,array());
		}else{
			$limit1 = ($pageCurrent-1)*$pagecount;
			$limit = "{$limit1},{$pagecount}";
			$rs = $this->pdoHelper->fetchAll("serverGroup={$_SESSION['gup']} and productId={$_SESSION['productId']} and interfaceName='Rest_Awards' and {$status}",null,'*','id desc',$limit);
			$result=array($num,$rs);
		}
		return $result;
	}

	public function sendPropsConfirm($queue_id){
		$object->status=0;
		return $this->pdoHelper->update(array('status'),(Array)$object," id='{$queue_id}' ");
	}

	public function setGoodsConfirm($queue_id){
		$object->status=0;
		return $this->pdoHelper->update(array('status'),(Array)$object," id='{$queue_id}' ");
	}

	public function sendPropsDel($queue_id){
		return $this->pdoHelper->remove(" id='{$queue_id}' ",null);
	}

	public function sendPropsRecal($queue_id){
		$object->status=4;
		return $this->pdoHelper->update(array('status'),(Array)$object," id='{$queue_id}' ");
	}
}
