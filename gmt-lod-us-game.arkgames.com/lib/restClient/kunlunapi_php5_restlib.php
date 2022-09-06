<?php
/**
 * Kunlun API PHP5 REST Client 1.0
 * 
 * @author hangjun.mao@kunlun-inc.com
 * @version 1.0
 */
class KunlunRestClient {
	private $version='1.0';
	private $use_curl_if_available=true;
	
	private $api_token;
	private $server_addr;

	public function __construct($api_token, $server_addr) {
		$this->api_token    = $api_token;
		$this->server_addr  = $server_addr;
	}
	
	public function __destruct()
	{
		$this->api_token    = '';
		$this->server_addr  = '';
	}

	public function &call_method($method, $params = array()) {
		$data = $this->post_request($method, $params);
		$result = json_decode($data, true);
		//echo '<pre>';print_r($data);exit;
		if(empty($result) || !is_array($result) )
		{
		    //$result = array('retcode'=>-1,'retmsg'=>'Server communication failure','data'=>$data);
		    $result = array('retcode'=>-1,'retmsg'=>empty($data) ? 'Server communication failure' : $data,'data'=>$data);
		}
		return $result;
	}
	
	private function finalize_params($method, $params) {
		list($get, $post) = $this->add_standard_params($method, $params);
		return array($get, $post);
	}

	private function add_standard_params($method, $params) {
		$post = $params;
		$get = array();

		$get['act'] = $method;
		//$get['v'] = $this->version;
		//$get['port'] = $params['port'];
		
		//添加密钥
		$t = time();
		$get['t'] = $t;
		$get['s'] = md5($method.$t.$this->api_token);
		
		//$post['api_token'] = $this->api_token;
		return array($get, $post);
	}

	private function create_url_string($params) {
	    return http_build_query($params);
	}

	private function post_request($method, $params) {
		list($get, $post) = $this->finalize_params($method, $params);
		$post_string = $this->create_url_string($post);
		$get_string = $this->create_url_string($get);
		$url_with_get = $this->server_addr . '?' . $get_string;
		//var_dump($url_with_get);
		if ($this->use_curl_if_available && function_exists('curl_init')) {
			$useragent = 'Kunlun API PHP5 REST Client 1.0 (curl) ' . phpversion();
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url_with_get);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
			
			if (defined('DEBUG_MODE') and DEBUG_MODE)
			{
				$cookie = "ZDEDebuggerPresent=php,phtml,php3; ZendDebuggerCookie=10.4.1.75:10000:0||08C|77742D65|0";
				curl_setopt($ch, CURLOPT_COOKIE, $cookie);
			}
			
			curl_setopt($ch, CURLOPT_TIMEOUT, 300);
			$result = curl_exec($ch);
			curl_close($ch);
			//die(var_dump($result));
		} else {
			$content_type = 'application/x-www-form-urlencoded';
			$content = $post_string;
			$result = $this->run_http_post_transaction(
															$content_type,
															$content,
															$url_with_get
													  );
		}
		return $result;
	}

	private function run_http_post_transaction($content_type, $content, $server_addr) {

		$user_agent = 'Kunlun API PHP5 REST Client 1.0 (non-curl) ' . phpversion();
		$content_length = strlen($content);
		$context = array(
			'http' => array(
					'method' => 'POST',
					'user_agent' => $user_agent,
					'header' => 'Content-Type: ' . $content_type . "\r\n" .
					'Content-Length: ' . $content_length,
					'content' => $content,
					'timeout' => 10,
				)
		);
		$context_id = stream_context_create($context);
		$sock = fopen($server_addr, 'r', false, $context_id);

		$result = '';
		if ($sock) {
			while (!feof($sock)) {
				$result .= fgets($sock, 4096);
			}
			fclose($sock);
		}
		return $result;
	}
}
