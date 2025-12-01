<?php //$code=rand(100000,999999);
//setcookie('captcha_code', $code, time() + (86400 * 1));
$heigh_cap = 46;
$heigh_cap_top = 15;
if(isset($_REQUEST['captch_code']) && $_REQUEST['captch_code'] !='')
{
	if(isset($_REQUEST['captch_code_front']) && $_REQUEST['captch_code_front'] !='')
	{
		$heigh_cap = 44;
		$heigh_cap_top = 13;
	}
	$code = $_REQUEST['captch_code'];
	$im = imagecreatetruecolor(100, $heigh_cap);
	$bg = imagecolorallocate($im, 94, 184, 50); //background color blue
	$fg = imagecolorallocate($im, 255, 255, 255);//text color white
	imagefill($im, 0, 0, $bg);
	imagestring($im, 13, 26, $heigh_cap_top,  $code, $fg);
	//$font = 'assets/front_end_new/css/font/Poppins-Medium.ttf';
	//imagettftext($im, 30, 0, 10, 40,$fg,$font,$code);
	header("Cache-Control: no-cache, must-revalidate");
	header('Content-type: image/png');
	imagepng($im);
	imagedestroy($im);
}
?>

