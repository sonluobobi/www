<?php
namespace ctrl;

class SearchCtrl extends CommonCtrl{
	/** 
	 * 构造函数，继承父方法
	 * 
	 * @return void
	 * @access public
	 */
	public function __construct(){
		parent::__construct('SearchService');
	}

	//角色幻兽查询
	public function Pet()
	{
		$this->query_date_config = array();
		$this->titles = array('pet_base_id', 'pet_nick','pet_level', 'exp','status','fight_capacity','star');
		$this->fields = array('base_id','nick','level', 'exp','status','fight_capacity','star');
		$this->lang_title = 'searchPet';
		return $this->display();
	}

	//角色交易查询
	public function Trade()
	{
		$this->titles = array('trade_date', 'roleId','accountId', 'roleName','gold','num','equip_id', 'equip_title', 'equip_prof');
		$this->fields = array('updated','saler_character_id','saler_player_id', 'saler_nick','sale_gold','sale_num','equip_id','equip_title','equip_prof');
		$this->lang_title = 'searchTrade';
		return $this->display();
	}

	//军团仓库查询
	public function GangStorage()
	{
		$this->tpl_query = 'GangStorage.Query.html';
		$this->query_user_type = false;
		$this->titles = array('gang_title', 'operator_name', 'log_type','equip_id', 'equip_title', 'contribute','operated_name','created');
		$this->fields = array('gang_title','operator_name','log_type','equip_id', 'equip_title','contribute','operated_name','created');
		$this->lang_title = 'searchGangStorage';
		return $this->display();
	}

	//赠送元宝
	public function AddGameGold()
	{
		$this->titles = array('accountId', 'accountName','roleId', 'add_num','memo', 'created');
		$this->fields = array('player_id','account','character_id', 'add_num','memo', 'created');
		$this->lang_title = 'searchAddGameGold';
		return $this->display();
	}

	//删除赠送元宝
	public function DelGameGold()
	{
		$this->titles = array('accountId', 'accountName','roleId', 'del_num','memo', 'created');
		$this->fields = array('player_id','account','character_id', 'del_num','memo', 'created');
		$this->lang_title = 'searchDelGameGold';
		return $this->display();
	}

	//充值元宝
	public function VoucherGold()
	{
		$this->titles = array('accountId', 'accountName','roleId', 'add_num','memo', 'created', 'state');
		$this->fields = array('player_id','account','character_id', 'add_num','memo', 'created', 'state');
		$this->lang_title = 'searchVoucherGold';
		return $this->display();
	}

	//删除元宝
	public function DelVoucherGold()
	{
		$this->titles = array('accountId', 'roleId', 'del_num', 'equip_id', 'created', 'state');
		$this->fields = array('player_id','character_id', 'del_num', 'equip_id', 'created', 'state');
		$this->lang_title = 'searchDelVoucherGold';
		return $this->display();
	}

	//体力,耐力，兽魂新增查询
	public function MoneyAdd()
	{
		$this->tpl_query = 'MoneyAdd.Query.html';
		$this->titles = array('accountId', 'roleId', 'gold_type','comm_add_num', 'memo', 'created');
		$this->fields = array('player_id','character_id', 'gold_type', 'add_num', 'memo', 'created');
		$this->lang_title = 'searchMoneyAdd';
		return $this->display();
	}

	//体力,耐力，兽魂使用查询
	public function MoneyUse()
	{
		$this->tpl_query = 'MoneyAdd.Query.html';
		$this->titles = array('accountId', 'roleId', 'service_id', 'gold_type', 'use_gold', 'old_gold', 'new_gold', 'equip_id', 'equip_num', 'memo', 'created');
		$this->fields = array('player_id','character_id', 'service_id', 'gold_type', 'use_gold', 'old_gold', 'new_gold', 'equip_id', 'equip_num', 'memo', 'created');
		$this->lang_title = 'searchMoneyUse';
		return $this->display();
	}

	//聊天记录
	public function ChatLog()
	{
		$this->tpl_query = 'ChatLog.Query.html';
		$this->titles = array('chat_type', 'from_cid','from_nick', 'from_aid', 'chat_created', 'recv_cid', 'recv_nick', 'recv_aid','chat_content');
		$this->fields = array('chat_type', 'from_cid','from_nick', 'from_aid', 'created', 'recv_cid', 'recv_nick', 'recv_aid','chat_content');
		$this->lang_title = 'chat_log_title';
		return $this->display();
	}

	//创角总数日志
	public function RoleCreatedLog()
	{
		$this->query_user_type = false;
		$this->query_date_config = array('beginDate');
		$this->titles = array('stat_date', 'created_num');
		$this->fields = array('date', 'num');
		$this->lang_title = 'role_created_log_title';
		return $this->display();
	}

	//改名日志
	public function RenameLog()
	{
		$this->query_date_config = array();
		$this->titles = array('accountId', 'roleId', 'rename_src_nick', 'rename_dst_nick', 'rename_created');
		$this->fields = array('player_id', 'cid', 'src_nick', 'dst_nick', 'created');
		$this->lang_title = 'rename_log_title';
		return $this->display();
	}

	//登录日志
	public function LoginLog()
	{
		$this->titles = array('accountId', 'accountName','roleId', 'roleName', 'level', 'online_second', 'now_login_time', 'loginIp', 'logout_time');
		$this->fields = array('pid', 'account','cid',  'nick', 'level', 'online_second', 'now_login_time', 'now_login_ip','created');
		$this->lang_title = 'login_log_title';
		return $this->display();
	}

	//军团成员仓库查询
	public function GangMemberStorages()
	{
		$this->query_date_config = array();
		$this->titles = array('roleId', 'roleName', 'equip_id', 'equip_title', 'expire');
		$this->fields = array('cid', 'nick', 'equip_id', 'equip_title', 'exp');
		$this->lang_title = 'gangmember_storages_title';
		return $this->display();
	}

	//角色活动参与日志
	public function ActivityLog()
	{
		$this->query_date_config = array();
		$this->tpl_query = 'ActivityLog.Query.html';
		$this->titles = array('roleId', 'activity_id','activity_item_id', 'activity_item_start_time', 'join_times', 'join_last_datetime', 'today_join_times', 'activity_state', 'bout_id', 'activity_created', 'updated');
		$this->fields = array('character_id', 'activity_id','activity_item_id', 'activity_item_start_time', 'join_times', 'join_last_datetime', 'today_join_times', 'state', 'bout_id', 'created','updated');
		$this->lang_title = 'activity_log_title';
		return $this->display();
	}

	//当前后台活动列表
	public function ActivityList()
	{
		$this->query_date_config = array();
		$this->query_user_type = false;
		$this->tpl_query = 'ActivityList.Query.html';
		$this->tpl_data = 'ActivityList.Data.html';
		$this->titles = array('activity_id', 'activity_title','activity_start_time', 'activity_end_time', 'activity_created');
		$this->fields = array('id', 'title','start_time', 'end_time', 'created');
		$this->lang_title = 'activity_list_title';

		if (!empty($_REQUEST['act_id']))
		{
			$this->tpl_name = 'ActivityItemList.Base.html';
			$this->tpl_data = 'Base.Data.html';
			$this->titles = array('activity_id', 'activity_item_id','activity_item_title', 'activity_item_start_time', 'activity_item_end_time', 'activity_created');
			$this->fields = array('activity_id', 'id','title', 'start_datetime', 'end_datetime', 'created');
			$this->lang_title = 'activity_item_list_title';

		 	return $this->showJson();

		}

		return $this->display();
	}

	//排行榜查询
	public function TopList()
	{
		$this->tpl_query = 'TopList.Query.html';
		$this->query_user_type = false;
		$this->query_date_config = array('beginDate');
		$this->titles = array('toplist_rank', 'roleName', 'roleId', 'accountId');
		$this->fields = array('rank', 'nick', 'cid', 'pid');
		$this->lang_title = 'toplist_title';
		return $this->display();
	}

	//交易双方汇总信息查询
	public function TradeSucc()
	{
		$this->tpl_query = 'TradeSucc.Query.html';
		$this->query_user_type = false;
		$this->titles = array('master_cid', 'master_pid', 'master_nick', 'slave_cid', 'slave_pid', 'slave_nick', 'equip_id', 'equip_title', 'equip_num', 'trade_gold_num', 'created');
		$this->fields = array('master_cid', 'master_pid', 'master_nick', 'slave_cid', 'slave_pid', 'slave_nick', 'equip_id', 'equip_title', 'equip_num', 'reward_module_id', 'created');
		$this->lang_title = 'trade_succ_title';
		return $this->display();
	}

	//历史密令
	public function SecretOrder()
	{
		$this->tpl_query = 'SecretOrder.History.html';
		$this->query_user_type = false;
		$this->titles =  array('secret_order_id', 'secret_order_type', 'beginDate', 'endDate', 'secret_order_scratch_time', 'secret_order_top_n', 'grid1_content', 'grid2_content', 'grid3_content', 'grid4_content', 'grid5_content', 'grid6_content', 'secret_order_content', 'secret_order_reward_equips', 'created');
		$this->fields = array('id', 'type', 'begin_time', 'end_time', 'scratch_time', 'top_n', 'grid1', 'grid2', 'grid3', 'grid4', 'grid5', 'grid6', 'content', 'reward_equips', 'created');
		$this->lang_title = 'secret_order_title_history';
		return $this->display();
	}

	//成功破解查询
	public function SecretOrderCracked()
	{
		$this->tpl_query = 'SecretOrder.Cracked.html';
		$this->titles =  array('record_id', 'roleId', 'accountId', 'secret_order_type', 'secret_order_rank', 'secret_order_id', 'secret_order_content', 'secret_order_cracked_time', 'updated');
		$this->fields = array('id', 'cid', 'player_id', 'type', 'rank', 'secret_order_id', 'content',  'created', 'updated');
		$this->lang_title = 'secret_order_title_cracked';
		return $this->display();
	}

	//参与破解查询
	public function SecretOrderJoined()
	{
		$this->tpl_query = 'SecretOrder.Joined.html';
		$this->titles =  array('record_id', 'roleId', 'accountId', 'secret_order_type', 'secret_order_id','grid1_cracked_time','grid2_cracked_time','grid3_cracked_time','grid4_cracked_time','grid5_cracked_time','grid6_cracked_time','created', 'updated');
		$this->fields = array('id', 'cid', 'player_id', 'type', 'secret_order_id', 'grid1', 'grid2', 'grid3', 'grid4', 'grid5', 'grid6', 'created', 'updated');
		$this->lang_title = 'secret_order_title_joined';
		return $this->display();
	}

	//密令库列表
	public function SecretOrderList()
	{
		$this->tpl_query = 'SecretOrder.List.html';
		$this->query_date_config = array();
		$this->query_user_type = false;
		$this->titles =  array('record_id', 'secret_order_type', 'grid1_content', 'grid2_content', 'grid3_content', 'grid4_content', 'grid5_content', 'grid6_content', 'secret_order_content', 'secret_order_reward_equips', 'created');
		$this->fields = array('id', 'type', 'grid1', 'grid2', 'grid3', 'grid4', 'grid5', 'grid6', 'content', 'reward_equips', 'created');
		$this->lang_title = 'secret_order_title_list';
		return $this->display();
	}

	//军团信息查询
	public function Gang()
	{
		$this->tpl_query = 'Gang.Query.html';
		$this->query_date_config = array();
		$this->query_user_type = false;
		$this->titles =  array('gang_id', 'gang_type', 'gang_title', 'level', 'get_vip_reward_num', 'gang_member_count', 'gang_war_level', 'created');
		$this->fields = array('id', 'type', 'title', 'level', 'get_vip_reward_num', 'member_count', 'gang_war_level',  'created');
		$this->lang_title = 'search_gang_title';
		return $this->display();
	}

	//最强战队下注
	public function BestTeamSupport()
	{
		$this->titles =  array('record_id', 'roleId', 'accountId', 'jie', 'key','level_key','top_n','team_id','team_title','support_silver','is_win', 'start_level', 'end_level','support_created');
		$this->fields = array('id', 'cid', 'player_id', 'jie', 'key', 'level_key', 'top_n', 'team_id', 'title', 'silver', 'is_win', 'start_level', 'end_level', 'created');
		$this->lang_title = 'search_best_team_support_title';
		return $this->display();
	}

	//冲值请求列表
	public function VoucherRequest()
	{
		$this->tpl_query = 'Voucher.Request.html';
		$this->query_date_config = array();
		$this->query_user_type = false;
		$this->titles =  array('optIp', 'created', 'consumer_memo');
		$this->fields = array('ip', 'created', 'desc');
		$this->lang_title = 'search_voucher_request_title';
		return $this->display();
	}

	//角色操作备注
	public function BriefDesc()
	{
		$this->query_date_config = array();
		$this->titles = array('record_id', 'roleId', 'accountId','roleName', 'level', 'logActtitle','consumer_memo', 'created');
		$this->fields = array('id', 'cid', 'player_id', 'nick', 'level', 'sort','msg', 'created');
		$this->lang_title = 'search_brief_desc_title';
		return $this->display();
	}

	//定向礼包
	public function DirectionalGift()
	{
		$this->titles =  array('record_id', 'roleId', 'accountId', 'directional_gift_open_time', 'directional_gift_info');
		$this->fields = array('id', 'cid', 'player_id', 'created', 'gift_info');
		$this->lang_title = 'directional_gift_title';
		return $this->display();
	}

	//神兵洗练日志
	public function ShenBingLog()
	{
		$this->titles =  array('record_id', 'roleId', 'shenbing_sort_id','old_effect_owner', 'old_effect_type','old_effect_value','new_effect_owner','new_effect_type','new_effect_value', 'created');
		$this->fields = array('id', 'cid', 'sort_id','old_effect_owner', 'old_effect_type','old_effect_value','new_effect_owner','new_effect_type','new_effect_value','updated');
		$this->lang_title = 'shenbing_log_title';
		return $this->display();
	}

	//许愿树日志
	public function WishingTree()
	{
		$this->tpl_query = 'WishingTree.query.html';
		$this->query_date_config = array();
		$this->titles =  array('record_id', 'roleId', 'pid', 'wishing_tree_op_type', 'wishing_tree_tab_id', 'equip_id', 'equip_num', 'wishing_tree_date_int', 'wishing_tree_award', 'created');
		$this->fields = array('id', 'cid', 'player_id','op_type', 'tab_id','equip_id','equip_num','date_int','awards','created');
		$this->lang_title = 'wishing_tree_title';
		return $this->display();
	}

	//背包道具赠送日志
	public function PresentEquip()
	{
		$this->tpl_query = 'PresentEquip.query.html';
		$this->titles =  array('record_id', 'present_equip_from_cid', 'present_equip_from_pid', 'equip_id', 'equip_num', 'present_equip_to_cid', 'present_equip_to_pid', 'present_equip_content', 'created');
		$this->fields = array('id', 'from_cid','from_pid', 'equip_id','equip_num','to_cid','to_pid','content','created');
		$this->lang_title = 'present_equip_title';
		return $this->display();
	}

	//圣域争霸战况猜想
	public function ShenYuGuess()
	{
		$this->titles =  array('record_id', 'roleId', 'shenyu_guess_top1', 'shenyu_guess_top2', 'shenyu_guess_top3', 'shenyu_guess_silver', 'shenyu_guess_state', 'shenyu_guess_total_silver', 'created');
		$this->fields = array('id', 'cid','top1', 'top2','top3','silver', 'state','total_silver', 'created');
		$this->lang_title = 'shenyu_guess_title';
		return $this->display();
	}

	//少数派
	public function ChoiceQuestion()
	{
		$this->titles =  array('record_id', 'roleId', 'choice_question_quesion_id', 'choice_question_option_id', 'choice_question_state', 'created', 'updated');
		$this->fields = array('id', 'cid','question_id', 'option_id','state','created', 'updated');
		$this->lang_title = 'choice_question_title';
		return $this->display();
	}

	//积分狂揽,转盘
	public function RotaryJiFen()
	{
		$this->tpl_query = 'RotaryJifen.query.html';
		$this->titles =  array('record_id', 'roleId','rotary_jifen_op_type','rotary_jifen_sort_id','rotary_jifen_cond_value','rotary_jifen_odds_value','rotary_jifen_rotary_level','rotary_jifen_jifen_today','rotary_jifen_pre_cond_value','rotary_jifen_pre_odds_value','rotary_jifen_pre_rotary_level','rotary_jifen_pre_jifen_today', 'created');
		$this->fields = array('id', 'cid','op_type','sort_id','cond_value','odds_value','rotary_level','jifen_today','pre_cond_value','pre_odds_value','pre_rotary_level','pre_jifen_today','created');
		$this->lang_title = 'rotary_jifen_rotary_title';
		return $this->display();
	}

	//积分狂揽,积分获得
	public function RotaryJiFenGet()
	{
		$this->titles =  array('record_id','roleId', 'rotary_jifen_get_jifen_today','rotary_jifen_stat_day','rotary_jifen_voucher_today','rotary_jifen_jifen_return','rotary_jifen_return_percent','rotary_jifen_return_day','rotary_jifen_jifen_yesterday','rotary_jifen_jifen_left', 'rotary_jifen_pre_jifen_left','created');
		$this->fields = array('id', 'cid','jifen_today','stat_day','voucher_today','jifen_return','return_percent','return_day','jifen_yesterday','jifen_left', 'pre_jifen_left','created');
		$this->lang_title = 'rotary_jifen_get_title';
		return $this->display();
	}

	//积分狂揽,积分使用
	public function RotaryJiFenUse()
	{
		$this->titles =  array('record_id', 'roleId', 'rotary_jifen_use_pre_jifen_left','rotary_jifen_jifen_use','rotary_jifen_use_jifen_left', 'created');
		$this->fields = array('id', 'cid', 'pre_jifen_left','jifen_use','jifen_left', 'created');
		$this->lang_title = 'rotary_jifen_use_title';
		return $this->display();
	}

	//军团图腾，登记列表
	public function GangTotemRegister()
	{
		$this->tpl_query = 'GangTotemRegister.query.html';
		$this->titles =  array('record_id','gang_totem_register_type_id','roleId','roleName','gang_id','gang_totem_register_obj_id_base','gang_totem_register_obj_id_ch','gang_totem_register_obj_order_by', 'gang_totem_register_fc_register_obj', 'updated');
		$this->fields = array('id', 'type_id','character_id','nick','gang_id','obj_id_base','obj_id_ch','obj_order_by','fc_register_obj','updated');
		$this->lang_title = 'gang_totem_register';
		return $this->display();
	}

	//军团图腾, 排行榜
	public function GangTotemToplist()
	{
		$this->tpl_query = 'GangTotemToplist.query.html';
		$this->tpl_data = 'GangTotemToplist.data.html';
		$this->query_date_config = array();
		$this->query_user_type = false;
		$this->titles = array('gang_totem_register_type_id', 'rank', 'gang_id','gangName','gang_master_nick', 'fc_gang_total', 'server');
		$this->fields = array('type_id','rank', 'gang_id','gang_title','gang_master_nick', 'fc_gang_total','area_id');
		$this->lang_title = 'gang_totem_toplist';
		return $this->display();
	}

	//全服充值排行榜
	public function GlobalVoucherToplist()
	{
		$this->tpl_query = 'GlobalToplist.query.html';
		$this->tpl_data = 'GlobalToplist.data.html';
		$this->query_date_config = array();
		$this->query_user_type = false;
		$this->titles = array('rank', 'roleId','pid','roleName', 'unique_key','level', 'fight_capacity', 'global_toplist_score', 'server');
		$this->fields = array('rank', 'cid','player_id','ch_nick', 'unique_key','level', 'fc', 'score', 'area_id');
		$this->lang_title = 'global_toplist_voucher';
		return $this->display();
	}

	//全服消费排行榜
	public function GlobalConsumeToplist()
	{
		$this->tpl_query = 'GlobalToplist.query.html';
		$this->tpl_data = 'GlobalToplist.data.html';
		$this->query_date_config = array();
		$this->query_user_type = false;
		$this->titles = array('rank', 'roleId','pid','roleName', 'unique_key','level', 'fight_capacity', 'global_toplist_score', 'server');
		$this->fields = array('rank', 'cid','player_id','ch_nick', 'unique_key','level', 'fc', 'score', 'area_id');
		$this->lang_title = 'global_toplist_consume';
		return $this->display();
	}

	//豆蔓日志
	public function StatBabel()
	{
		$this->titles =  array('roleId', 'StatBabel_babel_id', 'level', 'prof', 'fight_capacity','StatBabel_state','StatBabel_pass_time','created', 'updated');
		$this->fields = array('character_id','babel_id', 'level','prof','fight_capacity','state','pass_time','created', 'updated');
		$this->lang_title = 'StatBabel_title';
		return $this->display();
	}

	//竞技场查询
	public function ArenaPk()
	{
		$this->titles =  array('roleId','roleName', 'rank',  'fight_capacity', 'ArenaPk_passive_pk_cid', 'ArenaPk_passive_pk_nick', 'ArenaPk_passive_pk_rank', 'ArenaPk_passive_fight_capacity','ArenaPk_is_uprank','created');
		$this->fields = array('cid', 'nick', 'rank',  'fight_capacity', 'passive_pk_cid', 'passive_pk_nick', 'passive_pk_rank', 'passive_fight_capacity','is_uprank','created');
		$this->lang_title = 'ArenaPk_title';
		return $this->display();
	}
}	

