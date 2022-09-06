<?php
/**
 * @filesource NoticeService.php
 * @desc 游戏用户查询接口，Service层
 * @author Juezhong Long
 * date 2010-07-13
 */

namespace service;

use framework\core;
use entity;
use dao;
use framework\util;
use common;
use ctrl\LogCtrl;

class NoticeService extends ServersAbs
{
	private $NoticeDao;
	private $pagecount; //每页显示的条数
	private $pageCurrent; //当前页数
	private $result = array();
	private $list = array();

	/**
	 * @desc 初始化父类构造函数，实例化NoticeDao对象
	 */
	public function __construct()
	{
		parent::__construct();
		$this->NoticeDao = util\Singleton::get("dao\\NoticeDao");
		$this->pagecount = !empty($_POST['pagecount']) ? $_POST['pagecount'] : 10;
		$this->pageCurrent = !empty($_POST['p']) ? $_POST['p'] : 1;
	}

	/**
	 * 公告添加
	 */
	public function serviceAdd()
	{
		if($_POST)
		{
			if(!isset($_POST['server_ids']))
			{
				//file_put_contents("/home/xingzeng.jiang/www/t1.jd.kunlun.com/gmt/cyz.log", "!!!!!!!!!!!!!!!!!\r\n",FILE_APPEND);
				echo $this->_LANG['SelectServers'];
				exit();
			}

			if(empty($_POST['title']))
			{
				echo $this->_LANG['notitle'];
				exit();
			}

			$_POST['title'] = trim($_POST['title']);
			if(common\Functions::get_str_len($_POST['title'])>100){
				echo $this->_LANG['noticeTitleError'];
				exit();
			}

			if(empty($_POST['type']))
			{
				echo $this->_LANG['noChangeType'];
				exit();
			}

			if(empty($_POST['begTime']) || empty($_POST['endTime']))
			{
				echo $this->_LANG['noChangeTime'];
				exit();
			}
			
			

			if(!empty($_POST['cycle'])&&!is_numeric($_POST['cycle']))
            {
                echo $this->_LANG['noticeCycleError'];
                exit();
            }

			if(empty($_POST['contents']))
			{
				echo $this->_LANG['noContent'];
				exit();
			}

            $_POST['content'] = trim($_POST['contents']);
			if(common\Functions::get_str_len($_POST['content'])>500)
			{
                //echo $this->_LANG['noticeContentError'];
                //exit();
             }

             $content = $_POST['content'];

			/*
			if (get_magic_quotes_gpc())
			{
				$content = htmlspecialchars_decode(stripslashes($_POST['content']));
			}else{
				$content = htmlspecialchars_decode($_POST['content']) ;
			}			

			//echo $content;exit();

			$content = str_replace('&nbsp;', ' ', $content);
			$content = strip_tags($content, '<a><link>');
			$output = preg_split( '/(<link.*?>)/ms', $content ,-1, PREG_SPLIT_DELIM_CAPTURE ); 
			$output_str = '';

			if (!empty($output))
			{
				foreach ($output as $c) 
				{
					if (empty($c)) continue;

					if (strpos($c, '<link') === 0)
					{
						$output_str .= $c;
					}
					else
					{
						//$output_str .= '<color=#f95b5b>' . $c . '</color>';
						$output_str .=  $c;
					}
				}
			}

			if (!empty($output_str))
			{
				$content = $output_str;
			}
			else
			{
				//$content = '<color=#f95b5b>' . $content . '</color>';
				$content =  $content;
			}
			//*/

           // $content = htmlspecialchars($_POST['content'],ENT_QUOTES);
          
            	
            $tollgate_id = isset($_POST['tollgate_id']) ?  intval(trim($_POST['tollgate_id'])) : 0;

			$cn_ary = [];
			$cn_ary['default'] = 'en';
			$cn_ary['en'] = $content;
			
			for($i = 1;$i<= 100;$i++)
			{
				if(isset($_POST['contents_cn_'.$i]) && isset($_POST['contents_'.$i]))
				{
					$cn_ary[$_POST['contents_cn_'.$i]] = $_POST['contents_'.$i];
				}
			}
			
			

			$RestParm = array(
					'title'      =>  $_POST['title'], //标题
					'type'     	 =>  $_POST['type'],  //公告类型,
					'author'     	 =>  $_POST['author'], //发起人
					'begTime'     =>  $_POST['begTime'], //有效时间
					'endTime'    =>  $_POST['endTime'],  //结束时间
					'tollgate_id' => $tollgate_id, //关卡id
					'content'    =>  json_encode($cn_ary), //内容
					'cycle' 	 =>  $_POST['cycle'], //间隔
					'pictureUrl' =>  $_POST['pictureUrl'], //地址？看起来没有用到
					'status'     =>  $_POST['status'], //状态
					'ext' 		 =>  '',
				);
			if(!empty($_POST['id'])) $RestParm['id'] = $_POST['id'];
			
			$arr_server_name = array();
			
			if ($_POST['act'] == "edit" && $_POST['server_id_str'])
			{
				$server_id_str = $_POST['server_id_str'];
				$_POST['server_ids'] = explode(',', $server_id_str);
				file_put_contents("/tmp/liao_data.log", var_export($_POST['server_ids'],true));
			}
			
			//添加本地公告
			foreach ($_POST['server_ids'] as $sid)
			{
				$arr_server_name[] = common\Functions::getServerUrl($sid,'serverName');
			}
			
			 
			
			$arr_param = $RestParm;
			
			
			if(empty($_POST['id']))
			{
				$max_id = $this->NoticeDao->getMaxNoticeId();
				if ($max_id) {
					$arr_param['id'] = $max_id+1;
				}else {
					$arr_param['id'] = 100000; //避免跟旧版本的数据产生冲突
				}
			}
			
			
			
			$arr_param['platform']     = $_SESSION['gupFlag'];
			$arr_param['server_names'] = implode(',', $arr_server_name);
			$arr_param['server_ids']   = implode(',', $_POST['server_ids']);
				
			//$last_insert_id = $this->NoticeDao->addLocalNotice($arr_param); //添加到本地的公告
			
		    	
								
			//编辑
			if(!empty($_POST['id']))
			{
				$RestParm['act_type'] = 'edit';
			}
			else 
			{
				$RestParm['id'] = $last_insert_id;
				$RestParm['act_type'] = 'add';
			}
			
			/*foreach ($_POST['server_ids'] as $sid)
			{
				$server_url = common\Functions::getServerUrl($sid,'server'); //获取游戏服的地址
				if($server_url == false) throw new \Exception($this->_LANG['SelectServers']); //不存在返回false
				$ActionService = util\Singleton::get("service\\ActionService");
				
				$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);
				
				
			
				if($_POST['id'] > 0)
				{
				   
					LogCtrl::CallOperationLogs($sid,'',$sid,$action['actkey'],$this->_LANG['noticeEditTitle'],$this->_LANG['notice'].'id : '.$_POST['id'].' , '.$this->_LANG['title'].' : '.$_POST['title']);
				}else{
				   
					LogCtrl::CallOperationLogs($sid,'',$sid,$action['actkey'],$this->_LANG['noticeAddTitle'],$this->_LANG['notice'].$this->_LANG['title'].' : '.$_POST['title']);
				}
			
				
				$serverReturn = $this->NoticeDao->setNotice($server_url.RESTSUFFIX,$RestParm);
			}*/




			
		   $new_RestParm['msg'][] = array(
				'id'      =>  5, //标题
				'title'      =>  $_POST['title'], //标题
				'language'     	 =>  0,  //公告类型,
				'minVersion'     	 =>  '', //发起人
				'maxVersion'     	 =>  '', //发起人
				'startTime'     =>  strtotime($_POST['begTime']) - 18000, //有效时间
				'endTime'    =>  strtotime($_POST['endTime'])- 18000,  //结束时间
				'content'    =>  $content, //内容
			);
			file_put_contents('/www/wwwroot/lod-us-game.arkgames.com/cfg/notice/notice_en.txt',json_encode($new_RestParm,JSON_UNESCAPED_UNICODE));


			for($i = 1;$i<= 100;$i++)
			{
				if(isset($_POST['contents_cn_'.$i]) && isset($_POST['contents_'.$i]))
				{
					//$cn_ary[$_POST['contents_cn_'.$i]] = $_POST['contents_'.$i];

					$new_RestParm = [];

					$new_RestParm['msg'][] = array(
						'id'      =>  5, //标题
						'title'      =>  $_POST['title'], //标题
						'language'     	 =>  0,  //公告类型,
						'minVersion'     	 =>  '', //发起人
						'maxVersion'     	 =>  '', //发起人
						'startTime'     =>  strtotime($_POST['begTime'])- 18000, //有效时间
						'endTime'    =>  strtotime($_POST['endTime'])- 18000,  //结束时间
						'content'    =>  $_POST['contents_'.$i], //内容
					);
					file_put_contents('/www/wwwroot/lod-us-game.arkgames.com/cfg/notice/notice_'.$_POST['contents_cn_'.$i].'.txt',json_encode($new_RestParm,JSON_UNESCAPED_UNICODE));
				}
			}

			//如果是国外的服，调用sh脚本

			if(in_array(4391903,$_POST['server_ids']) or in_array(4390903,$_POST['server_ids']))
			{

				//exec('rsync  -rltpDvP --password-file /tmp/password.txt /data/zlcs/www/common/data/act/test/ rsync://zlcs-lodweb@lod-us-game.arkgames.com/zlcs-lodweb/cfg/notice',$out,$k);
				file_put_contents('/www/wwwroot/lod-us-game.arkgames.com/cfg/b.txt',111);
			}

			
			//var_dump($new_RestParm);
			
			exit();
			 
			return $serverReturn;
		}
	}


	/**
	 * 公告添加
	 */
	public function ServiceAddPush()
	{

		if($_POST)
		{
			if(!isset($_POST['server_ids']))
			{
				//file_put_contents("/home/xingzeng.jiang/www/t1.jd.kunlun.com/gmt/cyz.log", "!!!!!!!!!!!!!!!!!\r\n",FILE_APPEND);
				common\Functions::alertFunc($this->_LANG['SelectServers']);
				exit();
			}

			if(empty($_POST['push_title']))
			{
				common\Functions::alertFunc($this->_LANG['notitle']);
				exit();
			}

			$_POST['push_title'] = trim($_POST['push_title']);
			if(common\Functions::get_str_len($_POST['push_title'])>100){
				common\Functions::alertFunc($this->_LANG['noticeTitleError']);
				exit();
			}


			if(empty($_POST['contents']))
			{
				common\Functions::alertFunc($this->_LANG['noContent']);
				exit();
			}

			$_POST['content'] = trim($_POST['contents']);
			if(common\Functions::get_str_len($_POST['content'])>500)
			{
				common\Functions::alertFunc($this->_LANG['noticeContentError']);
				exit();
			}

			$content = $_POST['content'];

			$RestParm = array(
				'title'      =>  $_POST['push_title'], //标题
				'type'     	 =>  1, //公告类型,
				'author'     	 =>  0, //发起人
				'begTime'     =>  20110101, //有效时间
				'endTime'    =>  20110102,//结束时间
				'tollgate_id' => 0, //关卡id
				'content'    =>  $_POST['content'], //内容
				'cycle' 	 =>  15, //间隔
				'pictureUrl' =>  0, //地址？看起来没有用到
				'status'     =>  0, //状态
				'time'     =>  strtotime($_POST['begTime']), //状态
				'ext' 		 =>  999, //用来区分公告还是短信
			);


			if(!empty($_POST['id'])) $RestParm['id'] = $_POST['id'];

			$arr_server_name = array();
			

			//var_dump($_POST['server_ids']);
			//die;

			foreach ($_POST['server_ids'] as $sid)
			{
				$server_url = common\Functions::getServerUrl($sid,'server'); //获取游戏服的地址
				if($server_url == false) throw new \Exception($this->_LANG['SelectServers']); //不存在返回false
				$arr_server_name [] = $server_url;
				//$serverReturn = $this->NoticeDao->setNotice($server_url.RESTSUFFIX,$RestParm);

				$url_with_get = 'http://'.$server_url.'/webproxy.php?act=addNotice';

				echo $url_with_get;
				die;
				$postfields = array('data' => json_encode($RestParm));
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url_with_get);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
				curl_setopt($ch, CURLOPT_TIMEOUT, 300);
				$result = curl_exec($ch);
				curl_close($ch);
			}

			common\Functions::alertFunc('发送成功');

			return $result;
		}
	}
	
	/*
	 * 开始或者暂停公告
	* $_GET['server_id'] 服务器 id
	* $_GET['id'] 公告id列表，逗号相隔
	* $_GET['status'] 状态  1:开始  2:暂停
	*/
	public function startAndPause()
	{
		$msg = '';//返回信息
		$ids = explode(',', $_GET['id']);
		$post_all_ids = count($ids);//传递过来的id数
		$status = intval($_GET['status']); //1:开始   2:暂停
	
		$notices = $this->getNoticeById($_GET['id']);
	
		if (empty($notices)) return $this->_LANG['delErrorPop'];
	
		$handle_all_ids = count($notices); //存在于本地数据库中真实id数
		$succ_ids = array();
	
		foreach ($notices as $info)
		{
			$RestParm = array();
				
			$RestParm = array(
					'id'		 =>  $info['id'],
					'title'      =>  $info['title'],
					'type'     	 =>  $info['type'],
					'author'     =>  $info['author'],
					'begTime'    =>  $info['begTime'],
					'endTime'    =>  $info['endTime'],
					'tollgate_id'    =>  isset($info['tollgate_id']) ? $info['tollgate_id'] : 0,
					'content'    =>  $info['content'],
					'type'       =>  $info['type'],
					'cycle' 	 =>  $info['cycle'],
					'pictureUrl' =>  $info['pictureUrl'],
					'status'     =>  $status,
					'ext' 		 =>  $info['ext'],
					'platform' 		 =>  $info['platform'],
					'server_names' 		 =>  $info['server_names'],
					'server_ids' 		 =>  $info['server_ids'],
			);
				
			$RestParm['act_type'] = 'edit';
			$server_ids = explode(',', $info['server_ids']);
			$id = $info['id'];
			$succ = true;
				
			foreach ($server_ids as $sid)
			{
				$server_url = common\Functions::getServerUrl($sid,'server');
				if($server_url == false) throw new \Exception($this->_LANG['SelectServers']); //不存在返回false
				$ActionService = util\Singleton::get("service\\ActionService");
				$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);
				LogCtrl::CallOperationLogs($sid,'',$sid,$action['actkey'],$action['acttitle'],$this->_LANG['notice'].'id : '.$id);
				$serverReturn = $this->NoticeDao->setNotice($server_url.RESTSUFFIX,$RestParm);
	
				if (!isset($serverReturn['retcode']) || $serverReturn['retcode'] != 0)
				{
					//再次尝试
					$serverReturn = $this->NoticeDao->setNotice($server_url.RESTSUFFIX,$RestParm);
				}
	
				if (!isset($serverReturn['retcode']) || $serverReturn['retcode'] != 0)
				{
					$succ = false;
					$msg .= 'nid='.$id.'|server_id='.$sid.'|msg='.(isset($serverReturn['retmsg']) ? $serverReturn['retmsg']:'')." \n";
				}
			}
				
			$succ && $succ_ids[] = $id;//该公告下所有对应的服务器都操作成功，则为处理成功
		}
	
		$succ_all_ids = count($succ_ids);
		$msg = "传递($post_all_ids)条公告 \n 需要处理共($handle_all_ids)条 \n 成功处理共($succ_all_ids) \n ".$msg;
	
		if (!empty($succ_ids))
		{
			//更新本地notice status
			$succ_ids_str = implode(',', $succ_ids);
			$this->NoticeDao->updateLocalNoticeByIds($succ_ids_str, array('status'=>$status));
		}
	
		return $msg;
	}

    /**
     * 获取一条公告信息
     */
    public function serviceGetOne()
    {
		$RestParm = array(
                            'id'       =>  $_GET['id'],
                            'type'     =>  '',
                            'opType'   =>  '',
                            'opValue'  =>  '',
                            'begTime'   =>  '',
                            'endTime'  =>  '',
                            'page'     =>  $this->pageCurrent,
                            'pagecount' =>  $this->pagecount
                        );
        try {
            $server_url = common\Functions::getServerUrl($_GET['server_id'],'server');
            if($server_url == false) throw new \Exception($this->_LANG['SelectServers']);
            $serverReturn = $this->NoticeDao->getNoticeList($server_url.RESTSUFFIX,$RestParm);
        }catch (Exception $e) {
            throw new \Exception($e->getMessage(), "\n");
        }
        if($serverReturn['retcode'] == 0)
        {
            return $serverReturn['data'][0];
        }else{
            throw new \Exception("Query Error \n");
        }
    }
    
        
    
    /**
     * 获取一条公告信息
     */
    public function getSysMailById($mail_id)
    {
    	$RestParm = array(
    			'id'       =>  $mail_id,
    			'begTime'  =>  '',
    			'endTime'  =>  '',
    			'page'     =>  $this->pageCurrent,
    			'pagecount' =>  $this->pagecount
    	);
    	try {
    		$server_url = common\Functions::getServerUrl($_GET['server_id'],'server');
    		if($server_url == false) throw new \Exception($this->_LANG['SelectServers']);
    		$serverReturn = $this->NoticeDao->getSysMailList($server_url.RESTSUFFIX,$RestParm);
    	}catch (Exception $e) {
    		throw new \Exception($e->getMessage(), "\n");
    	}
    	if($serverReturn['retcode'] == 0)
    	{
    		return $serverReturn['data'][0];
    	}else{
    		throw new \Exception("Query Error \n");
    	}
    }

	/**
	 * 公告列表
	 */
	public function serviceLists()
	{
		if($_POST)
		{
			$RestParm = array(
								'id'       =>  $_POST['id'],
								'type'     =>  $_POST['type'],
								'opType'   =>  $_POST['opType'],
								'opValue'  =>  $_POST['opValue'],
								'begTime'   =>  $_POST['begTime'],
								'endTime'  =>  $_POST['endTime'],
								'page'     =>  $this->pageCurrent,
								'pagecount' =>  $this->pagecount
							);
			try {
				$server_url = common\Functions::getServerUrl($_POST['server_id'],'server');
				if($server_url == false) throw new \Exception($this->_LANG['SelectServers']);
				$serverReturn = $this->NoticeDao->getNoticeList($server_url.RESTSUFFIX,$RestParm);
			}catch (Exception $e) {
	    		throw new \Exception($e->getMessage(), "\n");
			}
			file_put_contents("/tmp/liao_gmt.log", var_export($serverReturn,true),FILE_APPEND);
			$pageNums = !empty($serverReturn['totalRows']) ? $serverReturn['totalRows'] : 0;
			if($serverReturn['retcode'] == 0)
			{
				/**
				 * 为下载列表转换特殊标识
				 */
				if($_POST['d'] == 1)
				{
					$this->list[] = array(
									$this->_LANG['notice'].'Id',
									$this->_LANG['notice'].$this->_LANG['title'],
									$this->_LANG['author'],
									$this->_LANG['putTime'],
									$this->_LANG['beginDate'],
									$this->_LANG['endDate'],
									$this->_LANG['tollgate_id'],
									$this->_LANG['noticeType'],
									$this->_LANG['status'],
									$this->_LANG['content'],
									$this->_LANG['cycle'],
									$this->_LANG['picUrl']
								);

				}
				foreach($serverReturn['data'] as $tmp)
				{
					!empty($tmp['begTime']) && $tmp['begTime'] = date('Y-m-d H:i:s', $tmp['begTime']);
					!empty($tmp['endTime']) && $tmp['endTime'] = date('Y-m-d H:i:s', $tmp['endTime']);

					if($_POST['d'] == 1)
					{
						if($tmp['type'] == 1)
						{
							$tmp['type'] = $this->_LANG['scrollNotice'];
						}elseif($tmp['type'] == 2){
							$tmp['type'] = $this->_LANG['talkNotice'];
						}elseif($tmp['type'] == 3){
							$tmp['type'] = $this->_LANG['scrollAndTalkNotice'];
						}
						$tmp['status'] = $tmp['status'] == 1 ? $this->_LANG['normal'] : $this->_LANG['pause'] ;
					}else{
						$tmp['noticeInfo'] = base64_encode(json_encode($tmp));
					}
					$this->list[] = $tmp;
				}
				unset($serverReturn);
			}else{
				throw new \Exception("Query Error " . json_encode($serverReturn) . "\n");
			}
		}
		$this->result['list'] = &$this->list;
		$subPages = new common\SubPages($this->pagecount,$pageNums,$this->pageCurrent);
		$this->result['pages'] = $subPages->show_SubPages();
		return $this->result;
	}
	
	/**
	 * 获取所有本地公告列表
	 */
	public function getLocalNoticeList()
	{
		$this->list = $this->NoticeDao->getLocalNoticeList();
		if ($this->list) {
			$pageNums = count($this->list);
		}else {
			$pageNums = 0;
		}
		
		$this->result['list'] = &$this->list;
		$subPages = new common\SubPages($this->pagecount,$pageNums,$this->pageCurrent);
		$this->result['pages'] = $subPages->show_SubPages();
		
		return $this->result;
	}
	
	public function getNoticeById($id)
	{
		return $this->NoticeDao->getNoticeById($id);
	}
	
	/**
	 * 获取全服邮件列表
	 */
	public function getSysMailList()
	{
		if($_POST)
		{
			$RestParm = array(
					'id'       =>  $_POST['id'],
					'begTime'  =>  $_POST['begTime'],
					'endTime'  =>  $_POST['endTime'],
					'page'     =>  $this->pageCurrent,
					'pagecount' =>  $this->pagecount
			);
			
			try {
				$server_url = common\Functions::getServerUrl($_POST['server_id'],'server');
				if($server_url == false) throw new \Exception($this->_LANG['SelectServers']);
				$serverReturn = $this->NoticeDao->getSysMailList($server_url.RESTSUFFIX,$RestParm);
			}catch (Exception $e) {
				throw new \Exception($e->getMessage(), "\n");
			}
			
			$pageNums = !empty($serverReturn['data']) ? count($serverReturn['data']) : 0;
			if($serverReturn['retcode'] == 0)
			{
				foreach($serverReturn['data'] as $tmp)
				{
					$this->list[] = $tmp;
				}
				unset($serverReturn);
			}else{
				throw new \Exception("Query Error " . json_encode($serverReturn) . "\n");
			}
		}
		
		$this->result['list'] = &$this->list;
		$subPages = new common\SubPages($this->pagecount,$pageNums,$this->pageCurrent);
		$this->result['pages'] = $subPages->show_SubPages();
		return $this->result;
	}
	

	/**
	 * 删除公告
	 */
	public function serviceDel()
	{
		$RestParm = array(
						'id'  =>  $_GET['id'],
					);
		$ActionService = util\Singleton::get("service\\ActionService");
		$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);
		LogCtrl::CallOperationLogs($_GET['server_id'],'',$_GET['server_id'],$action['actkey'],$action['acttitle'],$this->_LANG['notice'].'id : '.$_GET['id']);
		$server_url = common\Functions::getServerUrl($_GET['server_id'],'server');
		if($server_url == false) throw new \Exception($this->_LANG['SelectServers']);
		$serverReturn = $this->NoticeDao->deleteNotice($server_url.RESTSUFFIX,$RestParm);
		
		$this->NoticeDao->deleteLocalNotice($_GET['id']);
		
		return $serverReturn;
	}
	
	/**
	 * 删除邮件
	 * @param unknown_type $notice
	 * @throws \Exception
	 * @return unknown
	 */
	public function deleteNotice($id_str)
	{
		$ActionService = util\Singleton::get("service\\ActionService");
		$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);
		
		$arr_notice = $this->NoticeDao->getNoticeById($id_str);
		
		if ($arr_notice)
		{
			foreach ($arr_notice as $notice)
			{
				$RestParm = array(
						'id'  =>  $notice['id'],
				);
				
				$arr_server_id = explode(',', $notice['server_ids']);
				
				foreach ($arr_server_id as $server_id)
				{
						
					LogCtrl::CallOperationLogs($server_id,'',$server_id,$action['actkey'],$action['acttitle'],$this->_LANG['notice'].'id : '.$notice['id']);
					$server_url = common\Functions::getServerUrl($server_id,'server');
					if($server_url == false) throw new \Exception($this->_LANG['SelectServers']);
					$serverReturn = $this->NoticeDao->deleteNotice($server_url.RESTSUFFIX,$RestParm);
				}
				
			}
		}
				
		$this->NoticeDao->deleteLocalNotice($id_str);
		
		return $serverReturn;
	}

	/**
	 * 邮件发送
	 */
	public function ServiceSendMail()
	{
		$RestArr =array();
		$j = 0;

		$_POST['content'] = $_POST['content_mail'];

		if(empty($_POST['server_ids']))
		{
			return $this->_LANG['SelectServers'];
		}
		if(empty($_POST['title']) || empty($_POST['content']))
		{
			return $this->_LANG['noInput'];
		}
		else
		{
			if (get_magic_quotes_gpc())
			{
				$_POST['content'] = htmlspecialchars(stripslashes($_POST['content']));
			}else{
				$_POST['content'] = htmlspecialchars($_POST['content']) ;
			}

			$_POST['content'] = htmlspecialchars_decode($_POST['content']) ;

		}

		if(!empty($_FILES['excleFile']['name'])) //处理文件上传
		{
			$fileName = common\Functions::UploadFile($_FILES['excleFile'],2097152,array('application/vnd.ms-excel'),"../data/upload/mail/");
			if(!$fileName[0])
			{
				common\Functions::debug($fileName[1]);
			}
			$ExcleData = common\PhpExcel::readExcel($fileName[1]);
			if(is_array($ExcleData[0]['cells']) && count($ExcleData[0]['cells'])>1)
			{
				for ($i=2;$i<=count($ExcleData[0]['cells']);$i++)
				{
	 				$RestArr['roleId'][$j] = $ExcleData[0]['cells'][$i];
	 				$j++;
	 			}
			}
		}
		return $this->mailSend($RestArr);
	}

	/**
	 * 邮件发送请求方法
	 * @param Array
	 */
	private function mailSend($roleArr,$useQueue=false)
	{
		$queue = $useQueue; //$queue为选择入队列还是直接发送，true：入队列,false：直接发送
		$RestArr['uid'] = '';
		$RestArr['roleId'] = '';
		$RestArr['roleName'] = '';
		$RestArr['title'] = $_POST['title'];
		$RestArr['content'] = $_POST['content'];
		if(!empty($_POST['rids']))
		{
			if($_POST['receiverType'] == 1)  //按角色ID发送
			{
				$RestArr['roleId'] = $_POST['rids'];
			}else{
				$RestArr['roleName'] = $_POST['rids']; //按角色名发送
			}
		}else{
			if($_POST['receiverType'] == 1)  //按角色ID发送
			{
				$RestArr['roleId'] = $this->getRoleids($roleArr['roleId']);
			}else{
				$RestArr['roleName'] = $this->getRoleids($roleArr['roleId']); //按角色名发送
			}
		}
		if($queue)
		{
			$serverList = implode(',',$_POST['server_ids']);
			$serverReturn =  $this->NoticeDao->sendMailInsert($RestArr,$serverList);
			if($serverReturn > 0)
			{
				$result['retmsg'] = $this->_LANG['sendSccuess'];
			}else{
				$result['retmsg'] = $this->_LANG['sendFail'];
			}
		}
		else
		{
			if(!empty($RestArr['roleName'])){
				$roleExplain = '角色名 : '.$RestArr['roleName'];
			}elseif(!empty($RestArr['roleId']))
			{
				$roleExplain = '角色id : '.$RestArr['roleId'];
			}else{
				$roleExplain = '全服角色';
			}

			foreach($_POST['server_ids'] as $sid)
			{
				$ActionService = util\Singleton::get("service\\ActionService");
				$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);
				$server_url = common\Functions::getServerUrl($sid,'server');
				LogCtrl::CallOperationLogs($sid,$this->_LANG['title'].' : '.$_POST['title'],$roleExplain,
				$action['actkey'],$action['acttitle'],$roleExplain);
				$result = $this->NoticeDao->sendMail($server_url.RESTSUFFIX,$RestArr);
			}
		}

		return $result;
	}
	
	
	
	/**
	 * 添加全服邮件
	 */
	public function sendSysMail()
	{
		$_POST['content'] = $_POST['content_mail'];
	
		if(empty($_POST['server_ids']))
		{
			return $this->_LANG['SelectServers'];
		}
		if(empty($_POST['expired_date']))
		{
			return "请输入有效的过期时间";
		}
		if(empty($_POST['title']) || empty($_POST['content']))
		{
			return $this->_LANG['noInput'];
		}
		else
		{
			if (get_magic_quotes_gpc())
			{
				$_POST['content'] = htmlspecialchars(stripslashes($_POST['content']));
			}else{
				$_POST['content'] = htmlspecialchars($_POST['content']) ;
			}
	
			$_POST['content'] = htmlspecialchars_decode($_POST['content']) ;
		}
				
		foreach($_POST['server_ids'] as $server_id)
		{
			$server_url = common\Functions::getServerUrl($server_id,'server');
			$result = $this->NoticeDao->sendSysMail($server_url.RESTSUFFIX,$_POST);
		}
	
		return $result;
	}

	/**
	 * 将角色ID字符化
	 * @param $roleArr
	 * @return String
	 */
	private function getRoleids($roleArr=array())
	{
		$rids = array();
		foreach($roleArr as $tmp)
		{
			$rids[]= $tmp[1];
		}
		return implode(',',$rids);
	}

	/**
	 * 道具发送
	 * @return unknown_type
	 */
	public function ServiceSendProps()
	{
		$RestArr = array('uid' => '');
		$j = 0;

		if(empty($_POST['server_id']))
		{
			common\Functions::debug($this->_LANG['SelectServers']);
		}

		if(empty($_POST['rids']) && empty($_FILES['excleFile']['name']))
		{
			common\Functions::debug($this->_LANG['emptyReiver']);
		}

//		$serverList = implode(',',$_POST['server_ids']); //多服发送
		$serverList = $_POST['server_id'];

		if(!empty($_FILES['excleFile']['name'])) //处理文件上传，接收角色ID
		{
			$fileName = common\Functions::UploadFile($_FILES['excleFile'],2097152,array('application/vnd.ms-excel'),"../data/upload/props/");
			if(!$fileName[0])
			{
				common\Functions::debug($fileName[1]);
			}
			$ExcleData = common\PhpExcel::readExcel($fileName[1]);
			if(is_array($ExcleData[0]['cells']) && count($ExcleData[0]['cells'])>1)
			{
				for ($i=2;$i<=count($ExcleData[0]['cells']);$i++)
				{
	 				$RestArr['cid'][$j] = $ExcleData[0]['cells'][$i];
	 				$j++;
	 			}
			}
		}

		/**
		 * 如果使用输入的文本提交，格式化角色ID或角色名进入数组
		 */
		if(!empty($_POST['rids']))
		{
			$RestArr['cid'] = $_POST['rids'];
		}else{
			$RestArr['cid'] = $this->getRoleids($RestArr['cid']);
		}

		//按角色名发送
		if($_POST['receiverType'] == 2)
		{
			$RestArr['cname'] = $RestArr['cid'];
			unset($RestArr['cid']);
		}

		//检查角色名
		if($_POST['is_check_role_name'] && $_POST['receiverType'] == 2)
		{
			$server_url = common\Functions::getServerUrl($_POST['server_id'],'server');
			$serverReturn = $this->NoticeDao->checkNicks($server_url.RESTSUFFIX,array('nicks' => $RestArr['cname']));
				
			if($serverReturn['retcode'] > 0)
			{
				common\Functions::debug($serverReturn['retmsg']);
				return;
			}
			$exist_nicks = $serverReturn['data']['exist_nicks'];
			$nexist_nicks = $serverReturn['data']['nexist_nicks'];
			
			if (!empty($exist_nicks))
			{
				$retmsg = '存在的角色名有['.$exist_nicks.']';
			}
			
			if (!empty($nexist_nicks))
			{
				if ($retmsg) {
					$retmsg .= '；不存在的角色名有['.$nexist_nicks.']';
				}else {
					$retmsg = '不存在的角色名有['.$nexist_nicks.']';
				}
			}
			$retmsg = htmlspecialchars($retmsg);
					
			common\Functions::debug($retmsg);
			
			return;
		}

		if(empty($_FILES['propsFile']['name']))
		{
			common\Functions::debug($this->_LANG['PropsFileNotExist']);
		}

		if(empty($_POST['title']) || empty($_POST['content']) || empty($_POST['reason']))
		{
			common\Functions::debug($this->_LANG['emptyTitleContentReason']);
		}
		//保存标题,说明,理由,操作者 信息
		if(!empty($_POST['title']))
		{
			$RestArr['title'] = $_POST['title'];
		}
		if(!empty($_POST['content']))
		{
			$RestArr['content'] = $_POST['content'];
		}
		if(!empty($_POST['reason']))
		{
			$RestArr['reason'] = $_POST['reason'];
		}
		$RestArr['author'] = $_SESSION['infoUser']['fullname'];

		/**
		 * 处理上传的道具文件
		 */
		$fileName2 = common\Functions::UploadFile($_FILES['propsFile'],2097152,array('application/vnd.ms-excel'),"../data/upload/props/");
		if(!$fileName2[0])
		{
			common\Functions::debug($fileName2[1]);
		}
		
		//配置不能通过GMT发送的道具
		$forbid_send_equip = array(
			21011704=>'充值魔石',
			//21011703=>'10充值魔石',
			//21010061 => '充值魔石宝箱',
		);
		
		//放开权限的道具列表
		$special_check_equip = array(21011704);
		//获取是否有发送功能道具的权限
		$has_send_function_equip_auth = $this->check_action_auth('function_equip');

		$equip_name_arr = array_values($forbid_send_equip);
		$equip_name_str = implode(',', $equip_name_arr);
				
		$ExcleData = common\PhpExcel::readExcel($fileName2[1]);
		if(is_array($ExcleData[0]['cells']) && count($ExcleData[0]['cells'])>1)
		{
			for ($i=2;$i<=count($ExcleData[0]['cells']);$i++)
			{
				$equip_id = $ExcleData[0]['cells'][$i][1];
				if (!isset($forbid_send_equip[$equip_id]) || ($has_send_function_equip_auth && in_array($equip_id, $special_check_equip)))
				{
					$array = array();
					$array['gift'] = $ExcleData[0]['cells'][$i][1];
					$array['name'] = $ExcleData[0]['cells'][$i][2];
					$array['num'] = $ExcleData[0]['cells'][$i][3];
					$array['ext'] = $ExcleData[0]['cells'][$i][4];
					$RestArr['gift'][$j] = $array;
					$j++;
				}
				else 
				{
					$retmsg = "不能在GMT中发送以下道具:".$equip_name_str;
					return array('retmsg'=>$retmsg);
				}
			}
		}
		
		//$RestArr['ext'] = array('title'=>$_POST['title'],'content'=>$_POST['content']);
		if(!empty($RestArr) && is_array($RestArr))
		{
			//目前一次最多允许发送8种道具
			if (count($RestArr['gift']) > 8)
			{
				return array('retmsg'=>$this->_LANG['propsTypeOver']);
			}

			$giftExplain = '';
			foreach($RestArr['gift'] as $gift)
				$giftExplain .= 'id:'.$gift['gift'].' | 礼品名:'.$gift['name'].' | 数量'.$gift['num'].' | 类型'.$this->_LANG['awardType_ex'][$gift['ext']]."<br>\r\n";
			$RestArr['gift'] = base64_encode(json_encode($RestArr['gift']));
			$insertId = $this->NoticeDao->sendPropsInsert($RestArr,$serverList);
			$info = $insertId > 0 ? $this->_LANG['propsSendSucess'] : $this->_LANG['propsSendFail'];
			$ActionService = util\Singleton::get("service\\ActionService");
			$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);
			$giftExplain = "奖品队列ID:$insertId<br>\r\n发奖理由:{$RestArr['reason']}<br>\r\n" . $giftExplain;
			$roleExplain = $RestArr['cid'] ? '角色id : ' . $RestArr['cid'] : '角色名 : ' . $RestArr['cname'];
			LogCtrl::CallOperationLogs($serverList,$giftExplain,$RestArr['cid'],$action['actkey'],$action['acttitle'],$roleExplain);
			return array('retmsg'=>$info);
		}else{
			common\Functions::debug($this->_LANG['dataError']);
		}
	}

	 public function sendPropsList()
     {
                global $init;
                foreach($init['serverList'] as $value){
                        $servername[$value['Server_id']]=$value['Server_name'];
                        $serverid[]=$value['Server_id'];
                }
                $type=intval($_POST['type'])?intval($_POST['type']):3;
                $_POST['type'] = $type;
                
                $serverReturn = $this->NoticeDao->getsendPropsList($this->pagecount,$this->pageCurrent,$type);
                foreach($serverReturn[1] as $key=>$value){
                        $tmp=unserialize($value['dataResult']);
                        $serverList = $value['serverList'];

                        $tmp0=json_decode(base64_decode($tmp['gift']));
                        $data[$key]['SendPropsInfo'] = '';

                        if (!empty($tmp0))
                        {
	                        foreach($tmp0 as $value1)
	                        {

								$tmp1="道具id:".$value1->gift." | 礼品名:".$value1->name." | 数量:".$value1->num." | 类型:". $this->_LANG['awardType_ex'][$value1->ext];
								$data[$key]['SendPropsInfo'].=$data[$key]['SendPropsInfo']?"<br/>".$tmp1:$tmp1;
	                        }
                        }

                        if ($serverList != 9999)
                        {

	                        $data[$key]['receiver']=$tmp['uid']?$tmp['uid']:$tmp['cname']?$tmp['cname']:(strlen($tmp['cid'])>100?substr($tmp['cid'], 0, 100).'...':$tmp['cid']);
	                        $server=explode(',',$value['serverList']);
	                        foreach($server as $key1=>$value1){
	                            $server[$key1]=$servername[$value1];
	                        }
                        	$data[$key]['severlist'] = implode(',',$server);

                        	empty($data[$key]['receiver']) && $data[$key]['receiver'] = '所有玩家';
                        }
                        else
                        {
                        	$data[$key]['severlist'] = '全服';
                        	$data[$key]['receiver']= '全服';
                        }

                        $json_tmp_title = '';
						$tmp['title'] = json_decode($tmp['title'],ture);

						foreach($tmp['title'] as $t_key => $t_val)
						{
							$json_tmp_title.= "{".$t_key.':'.$t_val."}";
						}

						$json_tmp_content = '';
					$tmp['content'] = json_decode($tmp['content'],ture);

						foreach($tmp['content'] as $t_key => $t_val)
						{
							$json_tmp_content.= "{".$t_key.':'.$t_val."}";
						}

                        $data[$key]['queue_id']  = $value['id'];
                        $data[$key]['queueDate']  = $value['queueDate'];
						$data[$key]['title']     = $json_tmp_title;
						$data[$key]['content']   = nl2br(htmlentities($json_tmp_content));
						$data[$key]['reason']    = $tmp['reason'];
						$data[$key]['status']    = $value['status'];
						$data[$key]['description']    = $value['description'];
						$data[$key]['author'] = empty($tmp['author']) ? '--' : $tmp['author'];
						$data[$key]['expire'] = !empty($tmp['expire']) ? date('Y-m-d H:i:s', $tmp['expire']) : '';
                }
                $subPages = new common\SubPages($this->pagecount,$serverReturn[0],$this->pageCurrent);
                $result['list'] =$data;
                $result['pages'] = $subPages->show_SubPages();
                return $result;

        }

        public function sendPropsConfirm()
        {
        		if (isset($_GET['queue_id']))
        		{
        			$queue_id_list = explode(',', $_GET['queue_id']);
        			foreach ($queue_id_list as $tmp_id) 
        			{
        				if ($tmp_id > 0) {
        					$arr_queue_id[] = $tmp_id;
        				}
        			}
        		}
        		
        		if (!$arr_queue_id)
        		{
        			throw new \Exception($this->_LANG['argvError']);
        		}
        		//print_r($arr_queue_id);exit;
        		if ($this->NoticeDao->sendPropsConfirm($arr_queue_id))
        		{
        			return true;
        		}
        		else {
        			throw new \Exception($this->_LANG['sqlQueryError']);
        		}
                
        }

	 public function sendPropsDel()
	 {
                if (isset($_GET['queue_id']))
                {
                	$queue_id_list = explode(',', $_GET['queue_id']);
                	foreach ($queue_id_list as $tmp_id)
                	{
                		if ($tmp_id > 0) {
                			$arr_queue_id[] = $tmp_id;
                		}
                	}
                }
                
                if (!$arr_queue_id)
                {
                	throw new \Exception($this->_LANG['argvError']); //
                }
                
                if ($this->NoticeDao->sendPropsDel($arr_queue_id))
                {
                	return true;
                }
                else {
                	throw new \Exception($this->_LANG['sqlQueryError']);
                }
	 }

        public function sendPropsRecal()
	 {
                if (isset($_GET['queue_id']))
                {
                	$queue_id_list = explode(',', $_GET['queue_id']);
                	foreach ($queue_id_list as $tmp_id)
                	{
                		if ($tmp_id > 0) {
                			$arr_queue_id[] = $tmp_id;
                		}
                	}
                }
                
                if (!$arr_queue_id)
                {
                	throw new \Exception($this->_LANG['argvError']);
                }
                
                if ($this->NoticeDao->sendPropsRecal($arr_queue_id))
                {
                	return true;
                }
                else {
                	throw new \Exception($this->_LANG['sqlQueryError']);
                }
                

        }

	/**
	 * 获取道具详细信息
	 * @return Array
	 */
	public function getEquipDetail()
	{
		if(empty($_REQUEST['equipTitle']) && empty($_REQUEST['equipId']))
		{
			throw new \Exception($this->_LANG['noEquipIdAndTitle']);
		}
		$RestParm = array(
				'equipTitle'    =>  $_REQUEST['equipTitle'],
				'equipId'    =>  $_REQUEST['equipId'],
			);
		//$ActionService = util\Singleton::get("service\\ActionService");
		//$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);
		//LogCtrl::CallOperationLogs($_POST['server_id'], $_POST['isGm'] ? $this->_LANG['setGm'] : $this->_LANG['unsetGm'],$action['actkey'],$this->_LANG['setGmTitle'],'角色id:'.$_POST['roleId']);
		$server_url = common\Functions::getServerUrl($_REQUEST['server_id'],'server');
		$serverReturn = $this->NoticeDao->getEquipDetail($server_url.RESTSUFFIX,$RestParm);
		return $serverReturn;
	}

	/**
	 * 查询误丢弃道具
	 * @return Array
	 */
	public function getDiscardEquipList()
	{
		if(empty($_REQUEST['roleId']) && empty($_REQUEST['roleName']))
		{
			throw new \Exception($this->_LANG['emptyRoleNameRoleId']);
		}
		$RestParm = array(
				'roleName'		=>	$_REQUEST['roleName'],
				'roleId'		=>	$_REQUEST['roleId'],
				'equipTitle'    =>  $_REQUEST['equipTitle'],
				'equipId'		=>  $_REQUEST['equipId'],
				'begTime'		=>  $_REQUEST['beginDate'],
				'endTime'		=>  $_REQUEST['endDate'],
				'page'			=>  $this->pageCurrent,
				'pagecount'		=>  $this->pagecount
			);

		$server_url = common\Functions::getServerUrl($_REQUEST['server_id'],'server');
		$serverReturn = $this->NoticeDao->getDiscardEquipList($server_url.RESTSUFFIX,$RestParm);
		//file_put_contents('/tmp/gmt_cyz.log', "return===>".var_export($serverReturn,true). "\r\n", FILE_APPEND);
		if($serverReturn['retcode'])
		{
			throw new \Exception($serverReturn['retmsg']);
		}
		$subPages = new common\SubPages($this->pagecount,$serverReturn['data']['totalRows'],$this->pageCurrent);
		$result['list'] = $serverReturn['data']['data'];
		$result['pages'] = $subPages->show_SubPages();
		return $result;
	}

	/**
	 * 设置取消GM账号
	 * @return Array
	 */
	public function retrieveEquip()
	{
		if(empty($_POST['roleId']) || empty($_POST['chEquipId']) || empty($_POST['equipId']))
		{
			throw new \Exception($this->_LANG['noRoleIdCeidEid']);
		}
		$RestParm = array(
				'roleId'    =>  $_POST['roleId'],
				'chEquipId'    =>  $_POST['chEquipId'],
				'equipId'    =>  $_POST['equipId'],
				'author'    =>  $_SESSION['infoUser']['fullname'],
			);

		$server_url = common\Functions::getServerUrl($_REQUEST['server_id'],'server');
		$serverReturn = $this->NoticeDao->retrieveEquip($server_url . RESTSUFFIX,$RestParm);
		return $serverReturn;
	}

	/**
	 * 道具发送, 去掉excel导入，支持手动输入
	 */
	public function ServiceSendPropsEquip()
	{
	    //这里是邮件发送的地方：蔡建成
		$RestArr = array('uid' => '');
		$j = 0;
		if(empty($_POST['server_id']))
		{
			common\Functions::alertFunc($this->_LANG['SelectServers']);
		}

//		$serverList = implode(',',$_POST['server_ids']); //多服发送
		$serverList = $_POST['server_id'];
		$serverList = intval($serverList);
		$flag_is_all = $serverList == 9999 ? true :false;
		$flag_is_ch_all = false;

		$endTime_str = $_POST['endTime'];
		if (empty($endTime_str))
		{
			common\Functions::alertFunc($this->_LANG['noEndTime']);
		}

		$endTime = strtotime($endTime_str);
		if (empty($endTime))
		{
			common\Functions::alertFunc($this->_LANG['dateFormatErr']);
		}

		if ($endTime <= time())
		{
			common\Functions::alertFunc($this->_LANG['time_less_cur']);
		}

		$RestArr['expire'] = $endTime;
		
		if (!$flag_is_all)
		{
		   
		
			if(!empty($_POST['rids']) || !empty($_FILES['excleFile']['name']))
			{
			     
				//common\Functions::debug($this->_LANG['emptyReiver']);
				if(!empty($_FILES['excleFile']['name'])) //处理文件上传，接收角色ID
				{
				   
					$fileName = common\Functions::UploadFile($_FILES['excleFile'],2097152,array('application/vnd.ms-excel'),"../data/upload/props/");
					if(!$fileName[0])
					{
						common\Functions::debug($fileName[1]);
					}
					
				
					$ExcleData = common\PhpExcel::readExcel($fileName[1]);
					
					if(is_array($ExcleData[0]['cells']) && count($ExcleData[0]['cells'])>1)
					{
						for ($i=2;$i<=count($ExcleData[0]['cells']);$i++)
						{
			 				$RestArr['cid'][$j] = $ExcleData[0]['cells'][$i];
			 				$j++;
			 			}
					}
				}
				

				/**
				 * 如果使用输入的文本提交，格式化角色ID或角色名进入数组
				 *
				 *
				 */

				if($_POST['rids'] <= 11)
				{
					//common\Functions::alertFunc('不存在的角色名1');
				}

				if(!empty($_POST['rids']))
				{
					$RestArr['cid'] = $_POST['rids'];
				}else{
					$RestArr['cid'] = $this->getRoleids($RestArr['cid']);
				}

				//按角色名发送
				if($_POST['receiverType'] == 2)
				{
					$RestArr['cname'] = $RestArr['cid'];
					unset($RestArr['cid']);
				}

				//检查角色名
				if($_POST['is_check_role_name'] && $_POST['receiverType'] == 2)
				{
					$server_url = common\Functions::getServerUrl($_POST['server_id'],'server');
					$serverReturn = $this->NoticeDao->checkNicks($server_url.RESTSUFFIX,array('nicks' => $RestArr['cname']));
						
					if($serverReturn['retcode'] > 0)
					{
						common\Functions::alertFunc($serverReturn['retmsg']);
					}
					$exist_nicks = $serverReturn['data']['exist_nicks'];
					$nexist_nicks = $serverReturn['data']['nexist_nicks'];
					
					if (!empty($exist_nicks))
					{
						$retmsg = '存在的角色名有['.$exist_nicks.']';
					}
					
					if (!empty($nexist_nicks))
					{
						if ($retmsg) {
							$retmsg .= '；不存在的角色名有['.$nexist_nicks.']';
						}else {
							$retmsg = '不存在的角色名有['.$nexist_nicks.']';
						}
					}
					$retmsg = htmlspecialchars($retmsg);
							
					common\Functions::alertFunc($retmsg);
				}
			}
			else
			{
				//本服所有人
				$flag_is_ch_all = true;
			
			}
			
		}



		if(empty($_POST['title']) || empty($_POST['content']) || empty($_POST['reason']))
		{
			common\Functions::debug($this->_LANG['emptyTitleContentReason']);
		}
		//保存标题,说明,理由,操作者 信息
		if(!empty($_POST['title']))
		{

			$title_ary['default'] = 'en';
			$title_ary['en'] = $_POST['title'];

			for($i = 1;$i<100; $i++)
			{
				if(isset($_POST['title_'.$i]) && isset($_POST['contents_cn_'.$i]))
				{
					$title_ary[$_POST['contents_cn_'.$i]] = $_POST['title_'.$i];
				}
			}
			$RestArr['title'] = json_encode($title_ary);
		}
		if(!empty($_POST['content']))
		{
			//$RestArr['content'] = $_POST['content'];
			$content_ary['default'] = 'en';
			$content_ary['en'] = $_POST['content'];

			$content_ary['topType'] =  $_POST['topType'];
			//$content_ary['topEndTime'] =strtotime($_POST['topEndTime']);

			if(isset($_POST['tollgate_limit']) and !empty($_POST['tollgate_limit']))
			{
				$content_ary['tollgate_limit']	 = $_POST['tollgate_limit'];
			}

			if(isset($_POST['question_id']) and !empty($_POST['question_id']))
			{
				$content_ary['question_id']	 = $_POST['question_id'];
			}

			if(isset($_POST['question_award']) and !empty($_POST['question_award']))
			{
				$content_ary['question_award']	 = $_POST['question_award'];
			}



			if(isset($_POST['question_tollgate']) and !empty($_POST['question_tollgate']))
			{
				$content_ary['question_tollgate']	 = $_POST['question_tollgate'];
			}
			if(isset($_POST['question_create']) and !empty($_POST['question_create']))
			{
				$content_ary['question_create']	 = $_POST['question_create'];
			}

			if(isset($_POST['question_effect']) and !empty($_POST['question_effect']))
			{
				$content_ary['question_effect']	 = explode(",",$_POST['question_effect']);
			}

			if(isset($_POST['question_first']) and !empty($_POST['question_first']))
			{
				$content_ary['question_first']	 = explode(",",$_POST['question_first']);
			}


			for($i = 1;$i<100; $i++)
			{
				if(isset($_POST['contents_'.$i]) && isset($_POST['contents_cn_'.$i]))
				{
					$content_ary[$_POST['contents_cn_'.$i]] = $_POST['contents_'.$i];
				}
			}
			$RestArr['content'] = json_encode($content_ary);
		}
		if(!empty($_POST['reason']))
		{
			$RestArr['reason'] = $_POST['reason'];
		}
		$RestArr['author'] = $_SESSION['infoUser']['fullname'];
		
	
		
		if($_POST['rids'] != ''){
		    $RestArr['rids'] = explode(',',$_POST['rids']);
		   
		}
		else
		{
		     $RestArr['rids'] = [];
		    
		}
		
		
		
		//组合道具规则

		$attachment = [];

		foreach ($_POST['equip_id'] as $key => $val)
		{
			if($val and $_POST['equip_num'][$key])
			{
				$attachment[] = [
					"resourceType"=>2,
                	"resourceValue"=> (int)$val,
                	"counts"=>(int)$_POST['equip_num'][$key],
				];
			}
		}

		foreach ($_POST['resou_id'] as $key => $val)
		{
			if($val and $_POST['resou_num'][$key])
			{
				$attachment[] = [
					"resourceType"=>1,
					"resourceValue"=>(int)$val,
					"counts"=>(int)$_POST['resou_num'][$key],
				];
			}
		}
		$RestArr['attachment'] = $attachment;
		$RestArr['chapter'] = (int)$_POST['chapter'];
		$RestArr['castle'] = (int)$_POST['castle'];
		//组合道具规则end
		
	   // $RestArr['equip_id'] =$_POST['equip_id']
		
    	

		
	    //标签
	    $server_url = common\Functions::getServerUrl( $_POST['server_id'],'server'); //获取游戏服的地址
	    
	   //common\Functions::debug($server_url);
	    
	    $url_with_get = 'http://'.$server_url.'/webproxy.php?act=addmail';
		$postfields = array('data' => json_encode($RestArr));
		

		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_with_get);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
		curl_setopt($ch, CURLOPT_TIMEOUT, 300);
		$result = curl_exec($ch);
		curl_close($ch);
	    
	    common\Functions::debug('发送成功');
	    die;

		/**
		 * 处理上传的道具文件
		 */
		$equip_ids = isset($_POST['equip_id']) ? $_POST['equip_id'] : array();
		$equip_nums = isset($_POST['equip_num']) ? $_POST['equip_num'] : array();

			//$error_msg = $this->_LANG['equip_id'] . '-' . $this->_LANG['dataError'];
			//common\Functions::debug($error_msg);
		
		$equip_info_arr = array();	

		if (!empty($equip_ids) && !empty($equip_nums))
		{
			$cnt = count($equip_ids);

			if ($cnt != count($equip_nums))
			{
				$error_msg = $this->_LANG['equip_id'] . '-' . $this->_LANG['equip_num'] . '-' . $this->_LANG['dataError'];
				common\Functions::debug($error_msg);
			}

			//检查道具信息
			$equip_file = INCLUDE_PATH . '/data/equip.php';

			if (!file_exists($equip_file))
			{
				common\Functions::debug($this->_LANG['equipFileNotExists']);
			}

			$equip_map = include $equip_file;

			if(empty($equip_map))
			{
				common\Functions::debug($this->_LANG['emptyEquipMap']);
			}

			//配置不能通过GMT发送的道具
			$forbid_send_equip = array(
				21011704=>'充值魔石',
				//21011703=>'10充值魔石',
				//21010061 => '充值魔石宝箱',
			);
			
			//放开权限的道具列表
			$special_check_equip = array(21011704);
			//获取是否有发送功能道具的权限
			$has_send_function_equip_auth = $this->check_action_auth('function_equip');


			$equip_name_arr = array_values($forbid_send_equip);
			$equip_name_str = implode(',', $equip_name_arr);

			for($i=0;$i<$cnt;$i++)
			{
				if (!empty($equip_ids[$i]))
				{
					$_equip_id = trim($equip_ids[$i]);
					$_equip_num = intval(trim($equip_nums[$i]));
					$_equip_num < 1 && $_equip_num = 1;

					if (!$_equip_id || !isset($equip_map[$_equip_id]))
					{
						$error_msg = sprintf($this->_LANG['equipIdNotExists'],$_equip_id);
						common\Functions::alertFunc($error_msg);
					}

					if (!isset($forbid_send_equip[$_equip_id]) || ($has_send_function_equip_auth && in_array($_equip_id, $special_check_equip)))
					{
						$tmp = array();
						$tmp['gift'] = $_equip_id;
						$tmp['name'] = $equip_map[$_equip_id]['title'];
						$tmp['num'] = $_equip_num;
						$tmp['ext'] = 1;
						$equip_info_arr[] = $tmp;
					}
					else 
					{
						$retmsg = $this->_LANG['equipNotAllowedToSend'].$equip_name_str;
						common\Functions::alertFunc($retmsg);
					}
				}
			}
		}

		//common\Functions::debug(json_encode($equip_info_arr));

		if (empty($equip_info_arr))
		{
			//common\Functions::debug($this->_LANG['equipInfoWrong']);
		}

		$RestArr['gift'] = $equip_info_arr;

		//$RestArr['ext'] = array('title'=>$_POST['title'],'content'=>$_POST['content']);
		if(!empty($RestArr) && is_array($RestArr))
		{

			//目前一次最多允许发送8种道具
			if (count($RestArr['gift']) > 8)
			{
				common\Functions::alertFunc($this->_LANG['propsTypeOver']);
			}

			$giftExplain = '';
			if (!empty($RestArr['gift']))
			{
				foreach($RestArr['gift'] as $gift)
				{
					$giftExplain .= 'id:'.$gift['gift'].' | 礼品名:'.$gift['name'].' | 数量'.$gift['num'].' | 类型'.$this->_LANG['awardType_ex'][$gift['ext']]."<br>\r\n";
				}
			}
			$RestArr['gift'] = base64_encode(json_encode($RestArr['gift']));
			$insertId = $this->NoticeDao->sendPropsInsert($RestArr,$serverList);
			$info = $insertId > 0 ? $this->_LANG['propsSendSucess'] : $this->_LANG['propsSendFail'];

			$ActionService = util\Singleton::get("service\\ActionService");
			$action = $ActionService->getActionByActionCodeFromCache('./?act='.$_GET['act']);
			$giftExplain = "奖品队列ID:$insertId<br>\r\n发奖理由:{$RestArr['reason']}<br>\r\n" . $giftExplain;
			if ($flag_is_all)
			{
				$roleExplain = '全服';
				$operationObject = '全服';
			}
			elseif ($flag_is_ch_all) {
				$roleExplain = '所有玩家';
				$operationObject = '所有玩家';
			}
			else
			{
				$operationObject = '';
				$roleExplain = $RestArr['cid'] ? '角色id : ' . $RestArr['cid'] : '角色名 : ' . $RestArr['cname'];
			}
			/*$alter  = [
				'serverList'=>json_encode($serverList),
				'giftExplain'=>json_encode($giftExplain),
				'operationObject'=>json_encode($operationObject),
				'actkey'=>json_encode($action['actkey']),
				'acttitle'=>json_encode($action['acttitle']),
				'$roleExplain'=>json_encode($roleExplain),
			];*/

			//common\Functions::alertFunc(json_encode($alter));

			LogCtrl::CallOperationLogs($serverList,$giftExplain,$operationObject,$action['actkey'],$action['acttitle'],$roleExplain);
			return array('retmsg'=>$info);
		}else{
			common\Functions::debug($this->_LANG['dataError']);
		}
	}
}

?>
