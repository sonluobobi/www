<?php
define('KL_SSO_TOKEN_DOMAIN','kunlun.com');		//SSO 域
define('KL_SSO_TOKEN_NAME','KL_SSO');			//SSO COOKIE令牌名
define('KL_PERSON_TOKEN_NAME','KL_PERSON');	//个人信息令牌名
define('KL_SSO_EXPIRE',172800);	//SSO 有效期，默认为48小时，超过48小时，即使COOKIE还存在，也判定为失败，并清除COOKIE

/**
 * 本类主要用于官方各游戏及官网  解密登录用户信息，判断用户是否登录
 *
 * @author hangjun.mao@kunlun-inc.com
 * @version 1.0
 * @example 
 * 
 * <pre>
 * $klsc = new KLSsoClient();
 * if($klsc->isLogin())
 * {
 * 	echo $klsc->getUname().' already logged.';
 * }
 * else 
 * {
 *  echo 'Not logged in.';
 * }
 * </pre>
 */
class KLSsoClient {
	/**
	 * 用户ID(8个字节)
	 *
	 * @var bigint
	 */
	private $uid = '';

	/**
     * 用户ip
     *
     * @var string
     */
	private $ipv4 = '';

	/**
     * 用户身份证md5值(32个字节)
     * 
     * @var string
     */
	private $idcard = '';

	/**
	 * 防沉迷状态(2个字节)
	 *
	 * @var int
	 */
	private $indulge = 0;

	/**
	 * 用户等级(2个字节)
	 *
	 * @var int
	 */
	private $ulevel = 0;

	/**
	 * 标识
	 *
	 * @var int
	 */
	private $mark = 0;
	
	/**
	 * 标识2(4个字节)
	 *
	 * @var int
	 */
	private $mark2 = 0;
	
	/**
	 * 用户名
	 *
	 * @var string
	 */
	private $uname = '';
	
	/**
	 * 充值地址
	 *
	 * @var string
	 */
	private $payurl = '';
	
	/**
	 * 口令的MD5值
	 *
	 * @var string
	 */
	private $passinfo = '';
	
	/**
	 * 联运方配置信息
	 *
	 * @var string
	 */
	private $oemdata = '';
			
	/**
     * 登录时间
     *
     * @var string
     */
	private $timestamp = '';

	/**
     * 用于对称加密的KEY
     *
     * @var string
     */
	private $key = '';

	/**
     * 用户令牌
     *
     * @var string
     */
	private $ssotoken = '';
	
	/**
	 * 个人密码检验串
	 *
	 * @var string
	 */
	private $persontoken='';
	
	/**
	 * 指合作方ID 用于联运
	 *
	 * @var int
	 */
	private $oemmark;
	
	/**
	 * 指游戏ID 用于联运
	 *
	 * @var int
	 */
	private $gamemark;
	
	/**
	 * 构造
	 *
	 * @param int $oemmark 指合作方ID 用于联运 如果是官方游戏则为0
	 * @param int $gamemark 指游戏ID 用于联运 如果是官方游戏则为0
	 */
	public function __construct($oemmark=0,$gamemark=0){
		if(!function_exists('kl_parseToken')) throw new Exception('Function kl_parseToken not found.',0);
		
		$this->oemmark = $oemmark;
		$this->gamemark = $gamemark;
		
		$this->parseSsoToken();
		$this->parsePersonToken();
	}
	public function __destruct(){}
	
	/**
	 * 判断是否登录
	 *
	 * @return boolean
	 */
	public function isLogin()
	{
		if(empty($this->uid))
		{
			return false;
		}
		
		if($this->oemmark != $this->getOemMark())
		{
			return false;
		}
		
		if($this->gamemark != $this->getGameMark())
		{
			return false;
		}
		
		if((time()-strtotime($this->getTimestamp()))>KL_SSO_EXPIRE)
		{
			$this->logout();
			return false;
		}
		
		return true;
	}
	
	/**
	 * 取用户ID
	 *
	 * @return bigint
	 */
	public function getUid()
	{
		return $this->uid;
	}

	/**
	 * 取登录IP
	 *
	 * @return string
	 */
	public function getIpv4()
	{
		return $this->ipv4;
	}

	/**
	 * 取用户身份证md5值
	 *
	 * @return string
	 */
	public function getIdCard()
	{
		return $this->idcard;
	}

	/**
	 * 取用户防沉迷状态
	 *
	 * @return int
	 */
	public function getIndulge()
	{
		return $this->indulge;
	}

	/**
	 * 取用户等级
	 *
	 * @return int
	 */
	public function getUlevel()
	{
		return $this->ulevel;
	}

	/**
	 * 取OEM MARK ，指合作方ID
	 * 
	 * @return int
	 */
	public function getOemMark()
	{
		return intval($this->mark / 100000);
	}
	
	/**
	 * 取GAME MARK ，指游戏ID
	 *
	 * @return int
	 */
	public function getGameMark()
	{
		return $this->mark % 100000;
	}
	
	/**
	 * 取标识2
	 *
	 * @return int
	 */
	public function getMark2()
	{
		return $this->mark2;
	}

	/**
	 * 取登录时间
	 *
	 * @return string
	 */
	public function getTimestamp()
	{
		return $this->timestamp;
	}

	/**
	 * 取用户名
	 *
	 * @return string
	 */
	public function getUname()
	{
		return $this->uname;
	}

	/**
	 * 取充值地址
	 *
	 * @param int $pid 产品ID
	 * @param int $rid 大区ID OR 游戏ID
	 * @param int $uid 用户ID
	 * @return string
	 */
	public function getPayUrl($pid=0,$rid=0,$uid=0)
	{
		if(!empty($pid)) $this->payurl = str_replace('{pid}',$pid,$this->payurl);
		if(!empty($rid)) $this->payurl = str_replace('{rid}',$rid,$this->payurl);
		if(!empty($uid)) $this->payurl = str_replace('{uid}',$uid,$this->payurl);
		return $this->payurl;
	}

	/**
	 * 取口令的MD5值
	 *
	 * @return string
	 */
	public function getPassInfo()
	{
		return $this->passinfo;
	}

	/**
	 * 取联运方配置信息
	 *
	 * @return string
	 */
	public function getOemData()
	{
		return $this->oemdata;
	}

	/**
     * 注销COOKIE
     *
     */
	public function logout()
	{
		$this->deleteTokenCookie(KL_SSO_TOKEN_NAME,KL_SSO_TOKEN_DOMAIN);
		$this->deleteTokenCookie(KL_PERSON_TOKEN_NAME,KL_SSO_TOKEN_DOMAIN);
		
		//以下为了兼容旧平台
		$this->deleteTokenCookie('_KLUTOKEN',KL_SSO_TOKEN_DOMAIN);
		$this->deleteTokenCookie('_KLSTOKEN',KL_SSO_TOKEN_DOMAIN);
		$this->deleteTokenCookie('_KLPTOKEN',KL_SSO_TOKEN_DOMAIN);
		$this->deleteTokenCookie('_KLPAYWAY',KL_SSO_TOKEN_DOMAIN);
	}
	
	/**
     * 解密用户SSO信息
     *
 	 * @access private
     */
	private function parseSsoToken() {
		$this->ssotoken = $this->getSsoCookieToken();
		
		if(empty($this->ssotoken))
		{
			return;
		}

		$tokeninfo = kl_parseToken($this->ssotoken);
		if(empty($tokeninfo) || !is_array($tokeninfo))
			return;

		$this->uid =$tokeninfo['uid'];
		$this->ipv4 = $tokeninfo['ipv4'];
		$this->idcard = $tokeninfo['idcard'];
		$this->indulge = $tokeninfo['indulge'];
		$this->ulevel = $tokeninfo['ulevel'];
		$this->mark = $tokeninfo['mark'];
		$this->timestamp = $tokeninfo['timestamp'];
		$this->key = $tokeninfo['key'];
	}

	/**
     * 解密用户个人信息
     *
 	 * @access private
     */
	private function parsePersonToken() {
		$this->persontoken = $this->getPersonCookieToken();
		
		if(empty($this->persontoken))
		{
			return;
		}

		$personinfo = kl_decrypt($this->persontoken, $this->key);
		$personinfo = json_decode($personinfo,true);
		if(empty($personinfo) || !is_array($personinfo))
			return;

		$this->uname = $personinfo['uname'];
		$this->payurl = $personinfo['payurl'];
		$this->passinfo = $personinfo['passinfo'];
		$this->oemdata = $personinfo['oemdata'];
	}
	
	/**
	 * 获取单点登录TOKEN串
	 *
	 * @return string
 	 * @access private
     */
	private function getSsoCookieToken()
	{
		if(empty($this->ssotoken))
		{
			$this->ssotoken = @$_COOKIE[KL_SSO_TOKEN_NAME]==NULL?'':$_COOKIE[KL_SSO_TOKEN_NAME];
		}

		return $this->ssotoken;
	}
	
	/**
	 * 获取个人信息TOKEN串
	 *
	 * @return string
 	 * @access private
     */
	private function getPersonCookieToken()
	{
		if(empty($this->persontoken))
		{
			$this->persontoken = @$_COOKIE[KL_PERSON_TOKEN_NAME]==NULL?'':$_COOKIE[KL_PERSON_TOKEN_NAME];
		}
		return $this->persontoken;
	}
	
	/**
     * 删除COOKIE
     *
 	 * @param string $name COOKIE名
 	 * @param string $domain COOKIE域
 	 * @access private
     */
	private function deleteTokenCookie($name,$domain)
	{
		setcookie($name,'',time()-3600,'/',$domain,0);
	}
}
?>
