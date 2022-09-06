<?php
/**
 * @filesource Rest.php
 * @desc 提供公用通信服务器Rest接口
 * @author xiaoyang qi
 * @date 2010-07－15
 * Usage:
 * common\Rest::CallRestInterFace("要调用的方法名",通信地址,接口参数);
 */
namespace common;
require_once('restClient/kunlunapi_php5_restlib.php');

class Rest {
	private static  $api_client='';
	/**
	 * 构造函数`初始化通信对象
	 * @param unknown_type $api_token
	 * @param unknown_type $server_addr
	 */
	public function __construct()
    {
        
    }
    /**
     * 析构函数，销毁通信对象
     */
	public function __destruct()
    {
    	self::$api_client = null;
    }
	
    /**
     * 静态方法
     * $interface 私有方法名
     * $RestHost  请求的url
     * $RestParams 参数数组
     */
    public static function CallRestInterFace($interface,$RestHost,$RestParams=''){
    	if(preg_match('/^(Rest\_){1,1}[a-zA-Z]{1,}/',$interface)){
    		self::$api_client = new \KunlunRestClient(TOKENKEY, $RestHost);
    		return self::$interface($RestHost,$RestParams);
    	}else{
    		throw new \Exception("Method name wrong");
    	}
	}
	
	public static function CallCommRestInterFace($interface,$RestHost,$RestParams=''){
		self::$api_client = new \KunlunRestClient(TOKENKEY, $RestHost);
		return self::Rest_Comm($interface, $RestParams);
	}

	public static function Rest_Comm($interface,$RestParams)
	{
		return self::$api_client->call_method($interface,$RestParams);
	} 

	private static function Rest_playerAddEquip($RestHost,$RestParams=''){
		return self::$api_client->call_method('Platform.addEquip',$RestParams);
	}
	
	/**
	 * 获取服务器基本信息
	 * @var String $RestHost 请求的地址
	 * @var Array $RestParams 参数数组
	 * @return 返回数组信息（retcode:结果标识，retmsg:结果信息 data:获取游戏的在线人数，总人数，防沉迷开关等）
	 */
	private static function Rest_getServerInfo($RestHost,$RestParams=''){
		return self::$api_client->call_method('GameTools.getServerInfo',$RestParams);
	}
	/**
	 * 获取游戏配制信息
	 * @var String $RestHost 请求的地址
	 * @var Array $RestParams 参数数组
	 * @return 返回数组信息（retcode:结果标识，retmsg:结果信息 data:获取游戏的配制表信息）
	 */
	private static function Rest_getServerConfig($RestHost,$RestParams=''){
		return self::$api_client->call_method('GameTools.getServerConfig',$RestParams);
	}
	/**
	 * 设置游戏配制信息
	 * @var String $RestHost 请求的地址
	 * @var Array $RestParams 参数数组
	 * @return 返回数组信息 （retcode:结果标识，retmsg:结果信息）
	 */
	private static function Rest_setServerConfig($RestHost,$RestParams=''){
		return self::$api_client->call_method('GameTools.setServerConfig',$RestParams);
	}
	
	/**
	 * 获取游戏商城
	 * @var String $RestHost 请求的地址
	 * @var Array $RestParams 参数数组
	 * @return 返回数组信息 (retcode:结果标识，retmsg:结果信息 data:获取游戏商城记录 )
	 */
	private static function Rest_getShopList($RestHost,$RestParams=''){
		return self::$api_client->call_method('GameTools.getShopList',$RestParams);
	}
	/**
	 * 设置游戏商城
	 * @var String $RestHost 请求的地址
	 * @var Array $RestParams 参数数组
	 * @return 返回数组信息 (retcode:结果标识，retmsg:结果信息)
	 */
	private static function Rest_setShop($RestHost,$RestParams=''){
		return self::$api_client->call_method('GameTools.setShop',$RestParams);
	}
	
	/**
	 * 获取玩家信息
	 * @var String $RestHost 请求的地址
	 * @var Array $RestParams 参数数组
	 */
	private static function Rest_PlayerList($RestHost,$RestParams=''){
		return self::$api_client->call_method('GameTools.GetPlayerInfo',$RestParams);
	}
	
	/**
	 * 获取帮会玩家信息
	 * @var String $RestHost 请求的地址
	 * @var Array $RestParams 参数数组
	 */
	private static function Rest_getGangPlayerInfo($RestHost,$RestParams=''){
		return self::$api_client->call_method('GameTools.getGangPlayerInfo',$RestParams);
	}
	
	/**
	 * 解散帮会
	 * @param unknown_type $RestHost
	 * @param unknown_type $RestParams
	 */
	private static function Rest_disbandGang($RestHost,$RestParams=''){
		return self::$api_client->call_method('GameTools.disbandGang',$RestParams);
	}
	
	/**
	 * 清除二级密码
	 * @param unknown_type $RestHost
	 * @param unknown_type $RestParams
	 */
	private static function Rest_removePassword($RestHost,$RestParams=''){
		return self::$api_client->call_method('GameTools.removePassword',$RestParams);
	}
		
	
	/**
	 * 获取游戏某天在线数据
	 * @var String $RestHost 请求的地址
	 * @var Array $RestParams 参数数组
         * @return 返回数组信息 (retcode:结果标识，retmsg:结果信息 data:获取在线数据列表)
	 */
	private static function Rest_getOnlineData($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getOnlineData',$RestParams);
	}
	
	/**
	 * 获取游戏玩家信息
	 * @var String $RestHost 请求的地址
	 * @var Array $RestParams 参数数组
	 * @author Juezhong Long
	 */
	private static function Rest_getUserList($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getUserList',$RestParams);
	}
	
	/**
	 * 游戏加载数查询
	 * @param unknown_type $RestHost
	 * @param unknown_type $RestParams
	 */
	private static function Rest_getGameLoadData($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getGameLoadData',$RestParams);
	}
	
	/**
	 * 获取断交侠客信息
	 * @var String $RestHost 请求的地址
	 * @var Array $RestParams 参数数组
	 * @author Juezhong Long
	 */
	private static function Rest_getPetInfo($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getPetInfo',$RestParams);
	}
	
	
	/**
	 * 获取游戏玩家封禁列表
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add Juezhong Long
	 */
	private function Rest_getBanLoginlist($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getBanLoginlist',$RestParams);
	}
	
	/**
	 * 获取游戏玩家禁言列表
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add Juezhong Long
	 */
	private function Rest_getBanTalkList($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getBanTalkList',$RestParams);
	}
	
	/**
	 * 玩家封禁设置
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add Juezhong Long
	 */
	private static function Rest_banLogin($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.banLogin',$RestParams);
	}
	
	/**
	 * 玩家解禁设置
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add Juezhong Long
	 */
	private static function Rest_unBanLogin($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.unBanLogin',$RestParams);
	}
	
	/**
	 * 玩家禁言设置
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add Juezhong Long
	 */
	private static function Rest_banTalk($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.banTalk',$RestParams);
	}	

	/**
	 * 玩家解禁言设置
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add Juezhong Long
	 */
	private static function Rest_unBanTalk($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.unBanTalk',$RestParams);
	}	

	/**
	 * 设置取消GM账号
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add yaozhong cen
	 */
	private static function Rest_setGm($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.setGm',$RestParams);
	}

	/**
	 * 踢人
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add yaozhong cen
	 */
	private static function Rest_setOffLine($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.setOffLine',$RestParams);
	}

	/**
	 * 检查角色名
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add yaozhong cen
	 */
	private static function Rest_checkNicks($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.checkNicks',$RestParams);
	}	

	/**
	 * 获取角色详细信息
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add yaozhong cen
	 */
	private static function Rest_getChDetail($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getChDetail',$RestParams);
	}

	/**
	 * 获取商品销售统计
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add yaozhong cen
	 */
	private static function Rest_getGoodsStatList($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getGoodsStatList',$RestParams);
	}

	/**
	 * 查询等级分布
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add yaozhong cen
	 */
	private static function Rest_getLevelDistributionList($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getLevelDistributionList',$RestParams);
	}

	/**
	 * 查询道具流向
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add yaozhong cen
	 */
	private static function Rest_getEquipFlowList($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getEquipFlowList',$RestParams);
	}

	/**
	 * 获取道具详细信息
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add yaozhong cen
	 */
	private static function Rest_getEquipDetail($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getEquipDetail',$RestParams);
	}	

	/**
	 * 查询误丢弃道具信息
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add yaozhong cen
	 */
	private static function Rest_getDiscardEquipList($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getDiscardEquipList',$RestParams);
	}

	/**
	 * 恢复误丢弃道具信息
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add yaozhong cen
	 */
	private static function Rest_retrieveEquip($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.retrieveEquip',$RestParams);
	}	

	/**
	 * 公告列表
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add Juezhong Long
	 */
	private static function Rest_getNoticeList($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getNoticeList',$RestParams);
	}	
	
	/**
	 * 添加公告
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add Juezhong Long
	 */
	private static function Rest_setNotice($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.setNotice',$RestParams);
	}	

	/**
	 * 删除公告
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add Juezhong Long
	 */
	private static function Rest_deleteNotice($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.deleteNotice',$RestParams);
	}		
	
	/**
	 * 发送邮件
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add Juezhong Long
	 */
	private static function Rest_sendMail($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.sendMail',$RestParams);
	}	
	
	/**
	 * 发送邮件
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add Juezhong Long
	 */
	private static function Rest_sendSysMail($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.sendSysMail',$RestParams);
	}
	
	/**
	 * 获取全服邮件列表
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add Juezhong Long
	 */
	private static function Rest_getSysMailList($RestHost,$RestParams=''){
		return  self::$api_client->call_method('GameTools.getSysMailList',$RestParams);
	}

	/**
	 * 发送道具
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 * add Juezhong Long
	 */
	private static function Rest_Awards($RestHost,$RestParams=''){
		return  self::$api_client->call_method('Platform.Awards',$RestParams);
	}
	/**
	 * 获取大区冲值日志
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 */
	private static function Rest_getVouchList($RestHost,$RestParams=''){
		return  self::$api_client->call_method('CRegion.getVouchList',$RestParams);
	}
	/**
	 * 获取角色升级日志
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 */
	private static function Rest_getChUpgradeList($RestHost,$RestParams=''){
		return  self::$api_client->call_method('CRegion.getChUpgradeList',$RestParams);
	}
	/**
	 * 获取异常监控日志
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 */
	private static function Rest_getExceptionList($RestHost,$RestParams=''){
		return  self::$api_client->call_method('CRegion.getExceptionList',$RestParams);
	}
	/**
	 * 获取大区消费日志
	 * String $RestHost 请求的地址
	 * Array $RestParams 参数数组
	 */
	private static function Rest_getConsumList($RestHost,$RestParams=''){
		return  self::$api_client->call_method('CRegion.getConsumList',$RestParams);
	}
	/**
         * 获取PassPort用户信息
         * @var String $RestHost 请求的地址
         * @var Array $RestParams 参数数组
	 * @return 数组信息 (retcode:结果标识，retmsg:结果信息 data:PassPort用户信息)
         */
        private static function Rest_getInfoByUname($RestHost,$RestParams=''){
                return  self::$api_client->call_method('user.getInfoByUname',$RestParams);
        }
	 /**
         * 获取游戏用户余额
         * @var String $RestHost 请求的地址
         * @var Array $RestParams 参数数组
         * @return 数组信息 (retcode:结果标识，retmsg:结果信息,balance:金币数量,ustate:状态 )
         */
        private static function Rest_balance($RestHost,$RestParams=''){
                return  self::$api_client->call_method('CRegion.balance',$RestParams);
        }
        
     private static function Rest_f9377GetToplist($RestHost,$RestParams='')
     {
     	return  self::$api_client->call_method('interface_comm.f9377GetToplist',$RestParams);
     }
     
     /**
      * 获取发奖日志
      * @param unknown_type $RestHost
      * @param unknown_type $RestParams
      */
     private static function Rest_getRewardList($RestHost,$RestParams='')
     {
     	return  self::$api_client->call_method('CRegion.getRewardList',$RestParams);
     }
     
     /**
      * 获取某玩家某时间段的商城赠送日志
      * @param unknown_type $RestHost
      * @param unknown_type $RestParams
      */
     private static function Rest_getMallGiftList($RestHost,$RestParams='')
     {
     	return  self::$api_client->call_method('CRegion.getMallGiftList',$RestParams);
     }
	 
	/**
	 * 获取游戏服剩余元宝
	 * @param unknown_type $RestHost
	 * @param unknown_type $RestParams
	 */
	private static function Rest_getRemainGold($RestHost,$RestParams='')
	{
     	return  self::$api_client->call_method('CRegion.getRemainGold',$RestParams);
	}

}
?>
