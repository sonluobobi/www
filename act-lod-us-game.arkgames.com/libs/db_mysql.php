<?php
/**
 * MySQL 数据库操作类
 *
 * @author H.R.M <heizes@21cn.com>
 * @package jeboo.com
 * @copyright jeboo.com
 */
error_reporting(7);

class db_MySQL {
        /**
         * 服务器名或 ip 地址
         * 
         * @var string 
         */
        var $server = "localhost";
        /**
         * 数据库名
         * 
         * @var string 
         */
        var $database = "xiao";
        /**
         * 用户名
         * 
         * @var string 
         */
        var $user = "root";
        /**
         * 用户密码
         * 
         * @var string 
         */
        var $password = "i18n";

        /**
         * 是否使用持续连接
         * 
         * @var bool 
         */
        var $usepconnect = false;

        /**
         * 是否打开 debug 模式
         * 
         * @var bool 
         */
        var $debug = false;
        /**
         * MySQL link identifier
         * 
         * @var resource 
         */
        var $id;
        /**
         * SQL query 次数
         * 
         * @var integer 
         */
        var $querycount = 0;
        /**
         * 运行 SQL 请求后返回的结果集
         * 
         * @var resource 
         */
        var $result;
        /**
         * 
         * @var array 
         */
        var $record = array();

        var $rows;

        /**
         * 最后一次 INSERT 操作所返回的自增 ID
         * 
         * @var integar 
         */
        var $insertid;

        /**
         * 当出错时, 是否停止运行?
         *
         * @var bool 1: 停止, 2: 继续运行
         */
        var $halt = 1;

        /**
         * 错误号
         * 
         * @var integer
         */
        var $errno;

        /**
         * 错误提示
         * 
         * @var string 
         */
        var $error;

        /**
         * SQL运行记录
         * 
         * @var array 
         */
        var $querylog = array();

        /**
         * 初始化
         */
        function db_MySQL() {
                // 初始化
        } 

        /**
         * 获取错误描述
         * 
         * @access private
         * @return string 
         */
        function geterrdesc() {
                $this->error = mysql_error($this->id);
                return $this->error;
        } 

        /**
         * 获取错误号
         * 
         * @access private 
         * @return integer 
         */
        function geterrno() {
                $this->errno = mysql_errno($this->id);
                return $this->errno;
        } 

        /**
         * 连接数据库
         * 
         * @access public 
         * @return resource Returns a MySQL link identifier
         */
        function connect() {
                if ($this->usepconnect) {
                        if (!$this->id = mysql_pconnect($this->server, $this->user, $this->password)) {
                                $this->halt("数据库链接失败");
                        } 
                } else {
                        if (!$this->id = mysql_connect($this->server, $this->user, $this->password)) {
                                $this->halt("数据库链接失败");
                        } 
                } 
                $this->selectdb();
                return $this->id;
        } 

        /**
         * 选择数据库
         * 
         * @access public 
         */
        function selectdb() {
                if (!mysql_select_db($this->database, $this->id)) {
                        $this->halt("选择数据库失败");
                } 
        } 

        /**
         * 运行 SQL 语句并返回结果集
         * 
         * @access public 
         * @param  $query_string string
         * @return resource |false
         */
        function query($query_string) {
                //$this->result = mysql_query($query_string, $this->id);
                $this->result = mysql_db_query($this->database, $query_string, $this->id);

                if (!$this->result) {
                        $this->halt("SQL 语句无效: " . $query_string. '<p>出错原因:'. mysql_error());
                } 
                $this->querycount++;

                return $this->result;
        } 

        /**
         * Fetch a result row as an associative array, a numeric array, or both.
         * 
         * @access public 
         * @param  $result , $result_type
         * @see mysql_fetch_array
         * @return array |false
         */
        function fetch_array($result, $result_type = MYSQL_ASSOC) {
                if (!$result) {
                        $this->halt("resource result 无效:" . $result);
                } 
                $this->record = mysql_fetch_array($result, $result_type);
                return $this->record;
        } 
        
        function fetch_object($result) 
        {
                if (!$result) {
                        $this->halt("resource result 无效:" . $result);
                } 
                $this->record = mysql_fetch_object($result);
                return $this->record;
        } 
        
        
        /**
         * Get a result row as an enumerated array
         * 
         * @access public 
         * @param  $result 
         * @return array |false
         */
        function fetch_row($result) {
                if (!$result) {
                        $this->halt("resource result 无效:" . $result);
                } 
                $this->record = mysql_fetch_row($result);
                return $this->record;
        } 

        /**
         * 运行 SQL 并返回结果
         * 
         * @access public 
         * @return array 
         */
        function fetch_one_array($query, $result_type = MYSQL_ASSOC) {
                $this->result = $this->query($query);
                $this->record = $this->fetch_array($this->result, $result_type);
                return $this->record;
        }

        /**
         * 运行 SQL 并返回结果
         * 
         * @access public 
         * @param string $query_string , $result_type
         * @return array |false
         */
        function query_first($query_string, $result_type = MYSQL_ASSOC) {
                $this->result = $this->query($query_string);
                $this->record = $this->fetch_array($this->result, $result_type);
                return $this->record;
        }

        /**
         * Get number of rows in result
         * 
         * returns the number of rows in a result set. This command is only valid for SELECT statements.
         * 
         * @access public 
         * @param  $result 
         * @return integer 
         */
        function num_rows($result) {
                $this->rows = mysql_num_rows($result);
                return $this->rows;
        } 

        /**
         * Free result memory
         *
         * @access public
         * @param  $result 
         */
        function free_result($result) {
                if (!mysql_free_result($result)) {
                        $this->halt("释放结果集失败");
                } 
        } 

        /**
         * Get the ID generated from the previous INSERT operation
         * 
         * @access public 
         * @return integer 
         */
        function insert_id() {
                $this->insertid = mysql_insert_id($this->id);
                if (!$this->insertid) {
                        $this->halt("fail to get mysql_insert_id");
                } 
                return $this->insertid;
        }

        /**
         * Get number of affected rows in previous MySQL operation
         *
         * @return integer returns the number of rows affected by the last INSERT, UPDATE or DELETE query associated with link_identifier
         */
        function affected_rows() {
                $this->affected_rows = mysql_affected_rows($this->id);
                return $this->affected_rows;
        } 

        function date_seek($result, $i) {
                if (mysql_date_seek($result, $i)) {
                        return true;
                } else {
                        return false;
                } 
        } 

        /**
         * 关闭数据库连接
         * 
         * @access public
         */
        function close() {
                @mysql_close($this->id);
        } 

        /**
         * 建过 array 建立条件
         */
        function build_condition($condition = array(), $bool = " AND ") {
                if ($condition AND is_array($condition)) {
                        $conditions = " WHERE " . implode($bool, $condition);
                } 
                return $conditions;
        } 

        /**
         * 提示出错信息并中终程序
         *
         * @access private 
         * @param  $msg 提示信息
         */
        function halt($msg) {
         	$log = '';
                $log .= $msg . "\n";
                $log .= "______________________________________________________________________\n";
                $log .= "Date: " . date("Y-m-d H:i:s") . "\n";
                $log .= "mysql error description: " . $this->geterrdesc() . "\n";
                $log .= "mysql error number: " . $this->geterrno() . "\n";
                $log .= "Database: " . $this->database . "\n";
                $log .= "Linkid " . $this->id . "\n";
                $log .= "Script: " . getenv("REQUEST_URI") . "\n";
                $log .= "Referer: " . getenv("HTTP_REFERER") . "\n\n\n";

                @error_log($log, 3, '/var/log/db_error.log');
                exit("系统繁忙，请稍后再试！<br>".$msg);
                
                if ($this->halt) {
                	echo("<pre>$log</pre>");
                	exit;
                }
        }
}

?>
