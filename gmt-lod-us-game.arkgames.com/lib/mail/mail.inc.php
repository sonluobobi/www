<?php

require("class.phpmailer.php");

class MyMailer extends PHPMailer {

	var $From     = "test_sg@tom.com";
    var $FromName = "ÀîÖ¾ÁÁ";
    var $Host     = "pop.tom.com";
    var $Mailer   = "smtp";                         // Alternative to IsSMTP()
    var $SMTPAuth = true;     // turn on SMTP authentication
	var $CharSet = "GB2312";
    var $Username = "test_sg@tom.com";  // SMTP username
    var $Password = "test123"; // SMTP password
	var $WordWrap = 75;
	var $ContentType   = "text/html";
	
	function AddAttachment($path, $name = "", $disposition="attachment", $encoding = "base64", $type = "application/octet-stream")
	{
		
        if(!@is_file($path))
        {
            $this->SetError($this->Lang("file_access") . $path);
            return false;
        }

        $filename = basename($path);
        if($name == "")
            $name = $filename;

        $cur = count($this->attachment);
        $this->attachment[$cur][0] = $path;
        $this->attachment[$cur][1] = $filename;
        $this->attachment[$cur][2] = $name;
        $this->attachment[$cur][3] = $encoding;
        $this->attachment[$cur][4] = $type;
        $this->attachment[$cur][5] = false; // isStringAttachment
        $this->attachment[$cur][6] = ($disposition=='attachment') ? 'attachment' : 'inline' ;
        $this->attachment[$cur][7] = $cur;

        return true;
	}
}

?>