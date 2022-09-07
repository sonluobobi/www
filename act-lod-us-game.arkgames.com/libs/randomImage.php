<?php
ob_clean();
header("Content-type: image/jpeg");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
error_reporting(E_ALL);
// Fix for removed Session functions
function fix_session_register()
{
    function session_register(){
        $args = func_get_args();
        foreach ($args as $key){
            $_SESSION[$key]=$GLOBALS[$key];
        }
    }
    function session_is_registered($key){
        return isset($_SESSION[$key]);
    }
    function session_unregister($key){
        unset($_SESSION[$key]);
    }
}
function ImageAuthentic() {

        $imgRndNum= rand(1001,9999);
        //session_register('imgRndNum');
        session_start();
        $_SESSION['imgRndNum']= $imgRndNum;
        $font = rand(4,5);                                          // 字号
        $width = 70;                                                // 图片大小宽
        $height = 20;                                               // 图片大小长
        $left = rand(0,10);                                         // 坐标x
        $top = rand(0,6);                                           // 坐标y
        $fill_red = rand(240,255);                                  // 填充色R
        $fill_green = rand(240,255);                                // 填充色G
        $fill_blue = rand(240,255);                                 // 填充色B

        $font_red = rand(0,127);                                    // 字体颜色R
        $font_green = rand(0,127);                                  // 字体颜色G
        $font_blue = rand(0,127);                                   // 字体颜色B

        $line_red = rand(128,239);                                  // 字体颜色R
        $line_green = rand(128,239);                                // 字体颜色G
        $line_blue = rand(128,239);
        $lineh1= rand(0,$height);
        $lineh2 = rand(0,$height);


        $img = ImageCreate($width,$height);

        $bgcolor = ImageColorAllocate($img, $fill_red,$fill_green,$fill_blue);
        $ftcolor = ImageColorAllocate($img,$font_red,$font_green,$font_blue);
        $linecolor = ImageColorAllocate($img,$line_red,$line_green,$line_blue);

        ImageFilledRectangle($img,0,0,$width,$height,$bgcolor);
        ImageString($img,$font,$left,$top,$imgRndNum,$ftcolor);
        ImagePNG($img);

        ImageDestroy($img);

        return $imgRndNum;
}

try {
	ImageAuthentic();
}catch (Exception $e) {
	var_dump($e->getMessage());
}

?> 
