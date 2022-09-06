<?php
/**
 * @filesource PlayerDao.php
 * @desc 游戏用户查询接口，Dao层;通过查询数据库或REST方式请求远程服务器获取数据信息
 * @author Juezhong Long
 * date 2010-07-06
 */

namespace dao;

use common;
use framework\data\pdo;

class PlayerDao 
{
	
	private $pdoHelper;
	private $pdo;
	
	function __construct() 
	{
		$this->pdo = pdo\PDOManager::getInstance("default");

		$this->pdoHelper = new pdo\PDOHelper("entity\\Player");
        $this->pdoHelper->setPdo($this->pdo);
	}
	
	public function TestList()
	{
		//支持批量查询，$sid格式 1,2,3,..N
		$where = "1";
		return $this->pdoHelper->fetchAll($where,null,"*");
	}
	
	public function addEquip($RestHost,$RestParams)
	{
	    return common\Rest::CallRestInterFace("Rest_playerAddEquip",$RestHost,$RestParams);
	}
	
	/**
	 * 获取玩家信息列表
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function getPlayerInfo($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_getUserList",$RestHost,$RestParams);
	}
	
	/**
	 * 游戏加载数查询
	 * @param unknown_type $RestHost
	 * @param unknown_type $RestParams
	 */
	public function getGameLoadData($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_getGameLoadData",$RestHost,$RestParams);
	}
	
	
	/**
	 * 帮会用户信息查询
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function getGangPlayerInfo($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_getGangPlayerInfo",$RestHost,$RestParams);
	}
	
	/**
	 * 解散帮会
	 * @param unknown_type $RestHost
	 * @param unknown_type $RestParams
	 */
	public function disbandGang($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_disbandGang",$RestHost,$RestParams);
	}
	
	/**
	 * 清除二级密码
	 * @param unknown_type $RestHost
	 * @param unknown_type $RestParams
	 */
	public function removePassword($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_removePassword",$RestHost,$RestParams);
	}
	
	/**
	 * 获取断交侠客信息
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function getPetInfo($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_getPetInfo",$RestHost,$RestParams);
	}
	
	/**
	 * 获取玩家封禁列表
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型* 
	 * @return Array
	 */
	public function getBanLoginlist($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_getBanLoginlist",$RestHost,$RestParams);		
	}
	
	/**
	 * 获取玩家禁言列表
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型* 
	 * @return Array
	 */
	public function getBanTalkList($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_getBanTalkList",$RestHost,$RestParams);		
	}
	
	/**
	 * 设置玩家封禁，禁言yerInfo
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型* 
	 * @return Array
	 */
	public function setBlockGag($RestHost,$RestParams)
	{
		if($_POST['type'] == 1) //封禁
		{
			$method = 'banLogin';
		}elseif($_POST['type'] == 2){ //禁言
			$method = 'banTalk';
		}
		return common\Rest::CallRestInterFace("Rest_".$method,$RestHost,$RestParams);		
	}	

	/**
	 * 解禁及解禁言玩家
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型* 
	 * @return Array
	 */
	public function setUndoBlockGag($RestHost,$RestParams)
	{
		if($_POST['type'] == 1) //解禁
		{
			$method = 'unBanLogin';
		}elseif($_POST['type'] == 2){	//解禁言
			$method = 'unBanTalk';
		}
		return common\Rest::CallRestInterFace("Rest_".$method,$RestHost,$RestParams);		
	}		

	/**
	 * 设置及取消GM账号
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型* 
	 * @return Array
	 */
	public function setGm($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_setGm",$RestHost,$RestParams);		
	}

	/**
	 * 踢人
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型* 
	 * @return Array
	 */
	public function setOffLine($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_setOffLine",$RestHost,$RestParams);		
	}


	/**
	 * 获取角色详细信息
	 * @param $RestHost 请求的服务器接口地址
	 * @param $RestParams 请求参数，Array类型
	 * @return Array
	 */
	public function getChDetail($RestHost,$RestParams)
	{
		return common\Rest::CallRestInterFace("Rest_getChDetail",$RestHost,$RestParams);
	}

	/**
	 * 查询等级分布
	 */
	public function getLevelDistributionList($RestHost,$RestParams){
		return  common\Rest::CallRestInterFace("Rest_getLevelDistributionList",$RestHost,$RestParams);
	}

	/**
	 * 查询道具流向
	 */
	public function getEquipFlowList($RestHost,$RestParams){
		return  common\Rest::CallRestInterFace("Rest_getEquipFlowList",$RestHost,$RestParams);
	}

	/**
	 * 检查名字
	 */
	public function checkNicks($RestHost,$RestParams){
		return  common\Rest::CallRestInterFace("Rest_checkNicks",$RestHost,$RestParams);
	}
}

?>
