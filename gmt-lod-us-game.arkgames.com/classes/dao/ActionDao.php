<?php
namespace dao;

use framework\data\pdo;
use     common;

class ActionDao{
	/**
	 * 
	 * @var framework\data\pdo\PDOHelper
	 */
	private $pdoHelper;
	private $pdo;
	
	/**
	 * 构造函数
	 * @return
	 */
	public function __construct(){
		$this->pdo = pdo\PDOManager::getInstance('default');
		
		$this->pdoHelper = new pdo\PDOHelper("entity\\Action");
		$this->pdoHelper->setPdo($this->pdo);
	}
	/**
	 * 获取本级数据
	 */
	public function fetchActionOne($id){
		return $this->pdoHelper->fetchEntityByid($id);
	}
	/**
	 * 获取子级数据
	 */
	public function fetchActionSonOne($id){
		return $this->pdoHelper->fetchEntityBypid($id);
	}
	/**
	 * 获取权限列表
	 * @return entity\A
	 */
	public function fetchActionList($acttype,$listall = false){
		$where = 'pid = 0';
		//dongchen--20111216-start
		//$where_acttype = ($listall) ? '' : " AND acttype != '-1'";
		//dongchen--20111216-end
		if ($acttype=="1" || $acttype=="0") 
		{
			$where .= " AND acttype = '{$acttype}'";
			$rst = $this->pdoHelper->fetchAll($where,null,'*','id ASC');
		} 
		else 
		{
			$rst = $this->pdoHelper->fetchAll($where,null,'*','id ASC');
		}
		foreach($rst as $key =>$val)
		{
			
			$rst[$key]['ActRoot'] = $val;
			$rst[$key]['ActFirst'] = $this->pdoHelper->fetchAll("pid = {$val['id']} {$where_acttype}",null,'*','orderid,id ASC');
			if (!empty($rst[$key]['ActFirst']) && is_array($rst[$key]['ActFirst']))
			{
				$rst[$key]['ActSecond'] = array();
				foreach ($rst[$key]['ActFirst'] as $tKey=>$tVal)
				{
					$where = "pid = {$tVal['id']} {$where_acttype}";
					$tRst = $this->pdoHelper->fetchAll($where,null,'*','orderid ASC');
					if (!empty($tRst))
					{
						$actSecond = array();
						foreach ($tRst as $rKey=>$rVal)
						{
							$actSecond = array_merge($actSecond, array($rVal));
						}
						$rst[$key]['ActSecond'][$tVal['id']] = $actSecond;
					}
				}
			}
		}
		return $rst;
	}
	/**
	 * 添加，修改权限处理
	 * @return 
	 */
	//public function fetchActionSaveHandlebak($id,$object){
	//	foreach ($object as $key=>$value){
	//		$filed[] = $key;
	//	};
	//	$code = !empty($object->actcode) ?  substr($object->actcode,7) : '';
	//	$soapParm  = array($_SESSION['infoUser']['loginName'],common\Functions::getClientIP(),UMGMGAMESIGN."_".$object->acttitle,UMGMGAMESIGN."_".$code,UMGMGAMESIGN);
	//	if(empty($id)){
	//		if(!empty($code)){
	//			$return =  common\Soap::CallSaopInterface(UMURL,"addauth",$soapParm);
	//			if(!$return[0][1]) return false;
	//		}
	//		return  $this->pdoHelper->add($object,$filed);
	//	}else{
	//		if(!empty($code)){
        //                        $return =  common\Soap::CallSaopInterface(UMURL,"modauth",$soapParm);
        //                        if(!$return[0][1]) return false;
        //                }
	//		return $this->pdoHelper->update($filed,(Array)$object," id='{$id}' ");
	//	}
	//}
	public function fetchActionSaveHandle($id,$object,$umInfo){
		foreach ($object as $key=>$value){
			$filed[] = $key;
		};
		//dongchen--20111216-start
		if(empty($id)){
        	$row = $this->pdoHelper->fetchAll("1",null,'max(id) as maxid');
            $maxId = $row?$row[0]['maxid']+1:1;
            /*
            $info = array(
            	'menuKey' => 'gmt_action_'.$maxId,//'功能权限唯一编码',
                'menuName' =>$object->acttitle,//‘权限名称’,
                'menuUrl' =>$object->actcode, //‘权限请求地址’,
                'menuParent' =>$umInfo['id'], //‘父节点ID’,
                'menuType' =>($object->actdisplay=='block')?0:1, //‘权限类型 0 菜单权限 1 操作权限’,
           );
           $return = common\Functions::getUMReturn('iServer.menuAppend',$info,$_SESSION['infoUser']['systemId']);
           
           if($return[0] == 0) return $return;
           //*/
		   $object->actkey='gmt_action_'.$maxId;
           $object->id=$maxId;
           $filed[] ='id';
		   $filed[] ='actkey';
           return  $this->pdoHelper->add($object,$filed);
       }else{
       	   /*
           $info = array(
           		'menuId' => $umInfo['id'],
                'menuKey' => $umInfo['key'],//'功能权限唯一编码',
                'menuName' =>$object->acttitle,//‘权限名称’,
                'menuUrl' =>$object->actcode, //‘权限请求地址’,
                'menuType' =>($object->actdisplay=='block')?0:1, //‘权限类型 0 菜单权限 1 操作权限’,
           );
           $return = common\Functions::getUMReturn('iServer.menuEdit',$info,$_SESSION['infoUser']['systemId']);
           if(!$return[0]) return $return;
           //*/
           return $this->pdoHelper->update($filed,(Array)$object," id='{$id}' ");
       }
	   //dongchen--20111216-end
		
	}
	/**
	 * 删除权限处理
	 */
	/*public function fetchActionSaveDel($id){
		$secId = $this->pdoHelper->fetchAll("pid = '{$id}' ",null,'id');
		if(is_array($secId) && !empty($secId)){
		}
		return $this->pdoHelper->remove("id='{$id}'",null);
	}*/
	
	/**
     * 删除权限处理
    */
	//dongchen--20111216-start
    public function fetchActionSaveDel($id,$umInfo){
    	require('../data/cache/cache_menu.php');
        $tmp=array($menuTree,$setupTree);
        foreach($tmp as $tree){
        	foreach($tree as $value){
            	unset($root);
                unset($first);
                if($value['ActRoot']['id']==$id){
                	$root=$id;
                    $del[]=$id;
                }

                foreach($value['ActFirst'] as $ActFirst){
 	               if(!empty($root)){
    	               $del[]=$ActFirst['id'];
                   }else if($ActFirst['id']==$id){
        	           $del[]=$ActFirst['id'];
                       $second=$ActFirst['id'];
                       break;
                   }
                }

                if(!empty($root) || !empty($second)){
                	foreach($value['ActSecond'] as $Key=>$ActSecond1){
                    	foreach($ActSecond1 as $ActSecond){
                   	    	if(!empty($root)){
                            	$del[]=$ActSecond['id'];
                            }else if($Key==$second){
                                $del[]=$ActSecond['id'];
                            }
                        }
                    }
                }

                if(!empty($del)){
                	break;
                }

            }
            if(!empty($del)){
            	break;
            }
		}
				
		$where=empty($del)?"id='{$id}'":"id in (".implode(',',$del).")";
        $info = array(
        	'menuId' => $umInfo['id'],
        );
        $return = common\Functions::getUMReturn('iServer.menuDelete',$info,$_SESSION['infoUser']['systemId']);
        if(!$return[0]) return false;
        return $this->pdoHelper->remove($where,null);
    }
	//dongchen--20111216-end
	
	//add by yaozhong.cen 2012-8-20
	/**
	 * 从cache中根据actionCode获取action
	 */
	public function getActionByActionCodeFromCache($actionCode){
    	require('../data/cache/cache_menu.php');
        $tmp=array($menuTree,$setupTree);
        foreach($tmp as $tree){
        	foreach($tree as $value){
				if(!empty($value['ActRoot'])){
					if($value['ActRoot']['actcode']==$actionCode){
						return $value['ActRoot'];
					}
				}

				if(!empty($value['ActFirst'])){
					foreach($value['ActFirst'] as $ActFirst){
						if($ActFirst['actcode']==$actionCode){
							return $ActFirst;
						}
					}
				}
				if(!empty($value['ActSecond'])){
					foreach($value['ActSecond'] as $ActSecond1){
						if(!empty($ActSecond1)){
							foreach($ActSecond1 as $ActSecond){
								if($ActSecond['actcode']==$actionCode){
									return $ActSecond;
								}
							}
						}
					}
				}
            }
		}
	}
	/**
	 * 从cache中获取会记录操作日志的action
	 */
	public function getLogActionFromCache(){
		$result = array();
    	require('../data/cache/cache_menu.php');
        $tmp=array($menuTree,$setupTree);
        foreach($tmp as $tree){
        	foreach($tree as $value){
				if(!empty($value['ActRoot'])){
					if(self::isLog($value['ActRoot'])){
						$result[] = $value['ActRoot'];
					}
				}

				if(!empty($value['ActFirst'])){
					foreach($value['ActFirst'] as $ActFirst){
						if(self::isLog($ActFirst)){
							$result[] = $ActFirst;
						}
					}
				}
				if(!empty($value['ActSecond'])){
					foreach($value['ActSecond'] as $ActSecond1){
						if(!empty($ActSecond1)){
							foreach($ActSecond1 as $ActSecond){
								if(self::isLog($ActSecond)){
									if($ActSecond['actcode'] == './?act=Notice.add'){
										$ActSecond['acttitle'] = '公告添加/修改';
									}
									$result[] = $ActSecond;
								}
							}
						}
					}
				}
            }
		}
		
		return $result;
	}
	/**
	 * 判断一个操作是否会记录日志(用于搜索玩家管理日志)
	 */
	private function isLog($action){
		$actcode = strtolower($action['actcode']);
		//get, log, cache操作不记日志
		if($actcode == ''
		|| strstr($actcode, 'get') !== false
		|| strstr($actcode, 'query') !== false
		|| strstr($actcode, 'list') !== false
		|| strstr($actcode, 'log.') !== false
		|| strstr($actcode, 'cache.') !== false
		|| strstr($actcode, 'action.') !== false
		)
			return false;
		else
			return true;
	}
	//add by yaozhong.cen 2012-8-20
	
	public function getActionKeyByActionCode($actionCode)
	{
			return $this->pdoHelper->fetchAll("actcode = '{$actionCode}' ",null,'actkey');
	}
	public function getActionTitleByActionCode($actionCode)
	{
			return $this->pdoHelper->fetchAll("actcode= '{$actionCode}'",null,'acttitle');
	}
}
