<?php
//可供选择的Soap服务器地址
$_CONFIG_SERVER = array(
	//首个为默认服务器
	array('server_name' => 's0.moyu.kunlun.com', 'server_address' => 'http://s0.moyu.kunlun.com/game_soap/game_master_serv/Soap_server.php', 'server_num' => '0' )
);	

/**
 * 响应消息通用字段值状态码宏定义
 */
define('RSP_MSG_CODE_OK', '0');
define('RSP_MSG_CODE_PARAM_ERROR', '1');
define('RSP_MSG_CODE_TIMEOUT', '2');
define('RSP_MSG_CODE_SERVER_ERROR', '3');
$arr_rsp_msg = array("操作成功", "消息包内容错误", "消息包超时", "服务器错误");


/**
* 图片类型定义(根据数据库对应的ID来定义)
*/
define('PICTURE_SORT_ID_FOR_NPC', '1');		//NPC类型在数据库中对应的ID是  : 1
define('PICTURE_SORT_ID_FOR_MONSTER', '2'); //怪物类型在数据库中对应的ID是 : 2
/************************* 资源服务器 end ***************************/

/************************* 任务类ID start *************************/
//普通任务大类
define('TASK_SORT_ID_FOR_NORMAL', '1');

//赏金任务大类
define('TASK_SORT_ID_FOR_REWARD', '2');

//全服任务大类
define('TASK_SORT_ID_FOR_WHOLE_SERVER', '3');

//跑环任务大类
define('TASK_SORT_ID_FOR_GO_CIRCLE', '4');

//副本任务大类
define('TASK_SORT_ID_FOR_COPY', '5');

///部分任务子类定义
//每日任务类
define('TASK_CHILD_SORT_ID_FOR_DAILY', '6');

//每日任务类子类定义
$_CONFIG_DAILY_TASK_SORT = array(array('id' => '1', 'title' => '系统分配每日任务类'),
								array('id' => '2', 'title' => 'NPC领取每日任务类'),
							);
							

$_CONFIG_TASK_ITEM_CONDITION_TYPE = array(array('id' => '1', 'title' => '杀怪类'));

/************************* 任务类ID end ***************************/

/************************* 活动系统 start **********************/
//活动分类
define('ACTIVITY_SORT_ID_OPERATION_FOR_FESTIVAL', 1);	//节日活动
define('ACTIVITY_SORT_ID_OPERATION_FOR_SYSTEM', 2);		//系统活动 (一般值周期性的活动）
/************************* 活动系统 end **********************/



/***************************************绝代双骄配置 start ******************************************************************/

//opcode 设置
define("OPCODE_PUBLISH_DATA",'activity');   //数据发布

define("PUBLISH_TYPE_FOR_ACTIVITY",1); //活动发布
define("PUBLISH_TYPE_FOR_DISCOUNT",2); //打折活动发布
define("PUBLISH_TYPE_FOR_ACTIVATION_CODE",3); //激活码批次发布
define("PUBLISH_TYPE_FOR_MALL",4);     //商城(普通商城和VIP商城)

define("OP_GMT_FIX_OPEACTIVITY_OPEN", 'openOpeActivityFix');     //开启固化活动
define("OP_GMT_FIX_OPEACTIVITY_CLOSE",'closeOpeActivityFix');     //关闭固化活动
define("OP_GMT_FIX_OPEACTIVITY_GET",'getOpeActivityFix');     //获取固化活动状态
define("OP_GMT_FIX_OPEACTIVITY_VOUCHER_TOP",18);     //-获取固化活动的充值排行活动充值排行名单
define("OP_GMT_FIX_OPEACTIVITY_ALL",'getOpeActivityFixDataAll');     //获取后台所有活动信息

define("OP_GMT_FIX_OPEACTIVITY_PUB_LANG_PACK",'activityPubLangPack');     //活动语言翻译


define("OP_GMT_SET_OPEN_DATE",'setServerOpenDate');     //调整开服时间
define("OP_GMT_PRE_STOP_CHARM",'preCharmStopAndReward');  //提前结束扭蛋活动


define("OP_GMT_BACKEND_ACTIVITY",'publishBackendActivity'); 	//新版后台活动


define("SYNC_TYPE_FOR_ALL",'all_server');     //同步到所有服
define("SYNC_TYPE_FOR_OFFICIAL",'official');  //同步到官服
define("SYNC_TYPE_FOR_UNION",'union');        //同步到联运服


$DISCOUNT_SORT_ID_FOR_CHAOS = 1; //洗炼打折分类ID
$DISCOUNT_SORT_ID_FOR_MALL  = 2; //商城打折分类ID





$RPC_REQUEST_PORT = ''; //远程调用端口447

//活动NPC配置

$ACTIVITY_NPC_CONFIG = array(

		array('id'=>10018,'title'=>'活动使者'),

);

//活动标题图片资源配置
$PIC_RESOURCE_CONFIG = array(
		array('id'=>'Y0001','title'=>'升级坐骑得珍宝'),
		array('id'=>'Y0002','title'=>'充值抢绝版道具'),
		array('id'=>'Y0003','title'=>'充值送豪礼'),
		array('id'=>'Y0004','title'=>'激活码兑奖'),
		array('id'=>'Y0005','title'=>'内测玩家回馈'),
		array('id'=>'Y0006','title'=>'精彩活动'),
		array('id'=>'Y0007','title'=>'VIP商城热卖'),
		array('id'=>'Y0008','title'=>'VIP阳光普照'),
		array('id'=>'Y0009','title'=>'游历奖励也疯狂'),
		array('id'=>'Y0010','title'=>'充值劲爆返现'),
		array('id'=>'y0012','title'=>'更新公告'),
);

//活动项NPC
$NPC_CONFIG = array(

		array('id'=>10018,'title'=>'活动使者'),


);


//VIP商城VIP等级配置
$VIP_MALL_LEVEL = array(
		array('id'=>0,'title'=>'0级'),
		array('id'=>1,'title'=>'1级'),
		array('id'=>2,'title'=>'2级'),
		array('id'=>3,'title'=>'3级'),
		array('id'=>4,'title'=>'4级'),
		array('id'=>5,'title'=>'5级'),
		array('id'=>6,'title'=>'6级'),
		array('id'=>7,'title'=>'7级'),
		array('id'=>8,'title'=>'8级'),
		array('id'=>9,'title'=>'9级'),
		array('id'=>10,'title'=>'10级'),
		array('id'=>11,'title'=>'11级'),
		array('id'=>12,'title'=>'12级'),
);

//商城分类配置
$MALL_SORTS = array
(
	1 =>'普通道具',
	2 =>'VIP道具',
	3 => '充值魔石',
);

//限购类型
$MALL_LIMIT_BUY_MAP = array(
	0 => '不限购',
	1 => '永久性限购',
	2 => '按天限购',
);

$VIP_MALL_SORT = array(
		9 => 'VIP商城',

);

//不需要录入道具ID的兑换项
$NO_NEED_EQUIP_EXCHANGE_TYPE = array(5,9);

//是否开放发布活动后台数据，如果为true则不考虑发布时间，如果为false则必须要在星期一至星期五的10-18点才开放发布数据
define("ACT_PUBLISH_OPEN",true);   


define("ACT_EXH_TIMES",500);    //活动期间兑换次数不能超过50
define("EDAY_EXH_TIMES",250);    //每天兑换次数不能超过10
define('AE_PLAYER_MAX_NUM', 2000); //指定帐号兑换，最大帐号数

/***************************************绝代双骄配置 end ******************************************************************/

//活动项分类
//$activity_item_sort_id_map = array(1 => '节日活动',2 => '系统活动');
$activity_item_sort_id_map = array(1 => '节日活动');

//渠道限制类型
$activity_platform_map = array(0 => '所有',  1=> 'IOS', 2 => '安卓');

//活动兑换条件分类(常规兑换类)
$ae_sort_id_map = array(
	1 => '道具兑换(暂只支持道具兑换道具或装备,参数1:金币,参数2:兽魂,参数3:魔石,参数4:是否为充值魔石(0/1),参数5:炼金展示道具ID(非炼金不填),参数6:是否支持装备兑换装备(0/1)',
	//2 => '活动内魔石消费额度兑换',
	3 => '活动内魔石充值额度兑换',
	5 => '无条件兑换类',
	6=> '更新公告',
	9 => '指定账户兑换',
	10 => '活动内单笔充值额度兑换',
	11 => '圣诞飘雪',
	12 => '主城彩花',
);

//活动兑换奖励分类
$are_sort_id_map = array(array('id'=>1, 'title'=>'奖励固定道具'), array('id'=>0, 'title'=>'无奖励'), array('id'=>2, 'title'=>'奖励随机道具'));

//特殊条件兑换活动兑换条件分类(特殊条件兑换类)
$aes_sort_id_map = array(
	1 => '角色等级达成类',
	2 => '阶段内充值金额达成类',
	3 => '阶段内消费元宝达成类',
	4 => '阶段内最大单笔充值达成',
	5 => '阶段内充值购买达成(参数1:魔石数, 参数2:充值金额(RMB或美元)*100,参数3:收益率%,参数4:google_play_id,参数5:韩服IOS购买需充值金额)',
	//12 => '充值排行榜达成类',
	13 => '坐骑等级达成类',
	15 => '消费排行榜活动(不可做成固化活动)(参数1:名次下限,参数2:名次上限,参数3:要求最低消费魔石,参数4:消费结束时间偏移天数)',
	21 => '角色装备栏12件装备宝石总等级达成',
	22 => '角色战力达成',
	//29 => '全服VIP X人数达成(参数1:VIP,参数2:人数)',
	33 => '拥有X个指定资质幻兽的达成(参数1:个数,参数2:资质)',
	35 => 'VIP等级达成',
	36 => 'x个10品质幻兽幻化星级(参数1:个数,参数2:幻化星数)',
	37 => 'x个幻兽战力达成(参数1:个数,参数2:要求战力)',
	38 => '金色或以上装备洗练金色总X条达成',
	39 => '金色或以上装备洗练紫色以上总X条达成',
	40 => '在关卡或副本或野外额外掉落道具(参数1:掉落条件ID)',
	41 => 'x个宝石达到y等级以上(参数1:个数,参数2:宝石等级)',
	42 => '关卡总星数达成',
	43 => 'x个7资质(或以上)幻兽幻化星级(参数1:个数,参数2:幻化星数)',
	44 => '幻兽训练总次数',
	45 => '版本更新达成(参数1:需要更新到的客户端版本号)',
	46 => '出战合体幻兽拥有X个Y品阶宝物(参数1:个数,参数2:宝物品阶)',
	47 => '翅膀/神兵/砸金蛋/红女神(参数1:对应固化活动ID,仅开启时间有效,(参数2-4不填会用默认值)参数2:第1名充值下限(默认10000魔石),参数3:2-3名充值下限(默认5000魔石),参数4:4-10名充值下限(默认2000魔石))',

	50 => 'ios帐号绑定奖励',
	51 => '每日任务积分达成',
	52 => '被召回人VIP等级达成(参数1:VIP等级)',
	53 => '已召回人数达成(参数1:已召回人数, 参数2:VIP等级)',
	54 => '召回码使用活动(仅控制此活动是否显示)',
	55 => '被召回人登录签到(参数1:第X天签到)',
	56 => '魅力排行榜排名达成',
	57 => '送花排行榜排名达成',
	58 => '神兵觉醒保底活动(仅控制时间)',
	60 => '每月首冲礼包(参数1:类型(1=幻兽,2=道具,3=女神),参数2:幻兽/道具/女神基础ID,参数3:特效ID)',
	61 => '魔豆活动重置',
	62 => '神器铸造活动(仅控制时间)',
	63 => '幸运转盘(参数1:对应csv表RouletteLuckBase中的ID)',
	64 => '装备抽奖(参数1:对应csv表RouletteZBBase中的ID)',
	65 => '点击链接',
	66 => '夏日打靶活动(参数1:使用第几套配置,取值 1到9999)',
	67 => '充值商城首冲双倍活动重置',
	68 => '积分狂揽时间控制(参数1:是否开启积分回馈(0/1))',
	//69 => '全服充值排行榜(参数1:充值结束时间偏移天数,参数2:第1名充值下限(默认10000魔石),参数3:2-3名充值下限(默认5000魔石),参数4:4-10名充值下限(默认2000魔石))',
	//70 => '全服消费排行榜(参数1:消费结束时间偏移天数,参数2:第1名消费下限(默认10W),参数3:2-3名消费下限(默认5W),参数4:4-10名消费下限(默认2W))',
	69 => '全服充值排行榜(废弃，请勿使用)',
	70 => '全服消费排行榜(废弃，请勿使用)',
	72 => '点球大战',
	73 => '丢雪球(参数1:使用第几套配置,取值>= 10000)',

	//101 => '活动期间内幻兽训练达成(参数1:需要达成次数)',
	//102 => '活动时间内坐骑进化次数(参数1:需要达成次数)',
	//103 => '活动时段内砸紫蛋次数(参数1:需要达成次数)',
);

$params_one_two = array(5,6,15,29,33,36,37,40,41,43,45,46,47,52,53,54,55,60,63,64,66,68,69,70,73,101,102,103);
$params_three_four = array(5,6,15,47,60,69,70);

//掉落条件id列表
//4=>'野外所有怪'
$drop_cond_map = array(1=>'关卡', 2=>'副本', 3=>'普通野外炎魔', 4 => 'BOSS野外炎魔');

//固化活动，起点id 
$static_activity_start_id = 5800000;

//幸运女神活动
define('ACT_LUCK_GODNESS', 49);

//怪物猎人
define('ACT_MONSTER_HUNTER', 59);

//周年庆幸运女神活动
define('ACT_ZHOUNIANQING_LUCK_GODNESS', 71);


//激活码批次类型
define('BATCH_TYPE_LOCAL', 1);
define('BATCH_TYPE_SYNC', 2);
$batch_type_map = array(BATCH_TYPE_LOCAL => '本区有效', BATCH_TYPE_SYNC => '多区共享');

//接口token
define('INTERFACE_TOKEN', 's#2E1!m3Y');
define('INTERFACE_FILE', '/interface.php');
define('INTERFACE_SIGN', 'act');

//激活码共享配置
$sync_platform_map = array(
	'zh' => array('ios', 'yyb'),
	'sgp' => array('ru', 'eu', 'br', 'na', 'en', 'ar'),
	//'ru' => array('kr'),
);

//激活码批次同步配置
$sync_batch_map = array(
	'ios' => 'zh',
	'yyb' => 'zh',
	'ru' => 'sgp',
	'eu' => 'sgp',
	'br' => 'sgp',
	'na' => 'sgp',
	'en' => 'sgp',
	'ar' => 'sgp',
);

//配置同步激活码到pl领取后台
$sync_act_code_to_pl = array(
	'ios' => 1,
	//'ru' => 1,
);

define('TOKEN_EXPORT_IMPORT', 'M1#oY+u!');
define('IMPORT_EXPIRE_TIME', 24*3600); //上传过期时间1天

//格式化map 数据，用于 smarty 展示
function format_map($arr_map, $select_arr=array())
{
	$data = array();

	foreach ($arr_map as $key => $value) {
		$tmp = array();
		$tmp['id'] = $key;
		$tmp['title'] = $value;
		$tmp['hit'] = 0;

		if (!empty($select_arr) && isset($select_arr[$key]))
		{
			$tmp['hit'] = 1;
		}

		$data[] = $tmp;
	}

	return $data;
}


//资源类型
$res_type_map = array(0 => '无', 1 => '神兵', 2 => '龙', 3=> '幻兽');

//组id列表
$opeact_gourp_id_map = array( 0 => '默认');
$opeact_gourp_id_map[51] = '限时兑换1';
$opeact_gourp_id_map[52] = '限时兑换2';

//签到定制客户端样式id列表
$sign_style_id_map = array();
$sign_style_id_map[1] = '情人节';
$sign_style_id_map[2] = '周年庆典';
$sign_style_id_map[3] = '六日签到';
$sign_style_id_map[4] = '酒节登陆';
$sign_style_id_map[5] = '圣诞签到';

$sign_style_id_title = array();
$sign_style_id_title[1] = 'ope_shengdansign';
$sign_style_id_title[2] = 'ope_shengdansign_zhounian';
$sign_style_id_title[3] = 'sign6day';
$sign_style_id_title[4] = 'sign_wine';
$sign_style_id_title[5] = 'ope_shengdansign_0';

$sign_award_type_map = array();
$sign_award_type_map[1] = '累积天数';
$sign_award_type_map[2] = '登录日期';


$sign_style_id_day = array();
$sign_style_id_day[3] = 6;


//酿酒同类活动客户端样式id列表
$wine_style_id_map = array();
$wine_style_id_map[1] = '酿酒活动';
$wine_style_id_map[2] = '堆雪人';


//新后台数据
$backend_activity_sort_id_map = array();
$backend_activity_sort_id_map[1] = '召唤池活动';
$backend_activity_sort_id_map[2] = '签到定制1';
$backend_activity_sort_id_map[3] = '签到定制2';
$backend_activity_sort_id_map[4] = '调查问卷';

//不需要其他数据
$backend_act_no_need_other_data = array();
//$backend_act_no_need_other_data[1] = 1;


?>
