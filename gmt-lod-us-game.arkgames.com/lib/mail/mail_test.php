<?php

require("mail.inc.php");

$handle = fopen("maillist.dat","rb");

$handle_ok = fopen("maillist_ok.dat", "wb");
$handle_no = fopen("maillist_no.dat", "wb");

if (!$handle) {
    echo '���ܴ� maillist.dat , ��ʽΪһ��һ���ʼ���ַ';
	die();
}


while (!feof($handle))
{
	// Instantiate your new class
	$mail = new MyMailer;
	$mailaddr = fgets($handle, 4096);
	$mailaddr = trim($mailaddr);

	// Now you only need to add the necessary stuff
	//$mail->AddAddress("i_liule@126.com", "����1");
	$mail->AddAddress($mailaddr, $mailaddr);

	// ����
	$mail->Subject = "�ʼ�����";

	// ����
$mail->Body= '
<HTML><HEAD>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<STYLE></STYLE>
</HEAD>
<BODY bgColor=#ffffff>
<img src=cid:0 width=200 height=130>
<DIV><FONT size=2></FONT>&nbsp;</DIV></BODY></HTML>
';

	// �����ͼƬ / ����
	//$mail->AddAttachment("D:/tmp/d09.jpg","d09.jpg",'attachment');  // optional name
	$mail->AddAttachment("D:/tmp/d09.jpg","mm.jpg",'inline');  // optional name

	$mail->IsHTML(true);  // false ��ʾ�ı��ʼ�����

	if(!$mail->Send())
	{
		echo "����ʧ��" . $mail->ErrorInfo ."\n";
		fwrite($handle_no, $mailaddr."\n");

	} else {

		echo "���ͳɹ� \n";
		
		fwrite($handle_ok, $mailaddr."\n");

	}
}

fclose($handle);
fclose($handle_ok);
fclose($handle_no);
?>