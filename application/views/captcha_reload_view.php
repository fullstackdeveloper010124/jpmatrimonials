<?php
if(isset($captcha_session) && $captcha_session !='')
{
?>
<img src="<?php echo $base_url; ?>captcha.php?captch_code=<?php echo $this->session->userdata[$captcha_session]; ?>" />
<?php
}
?>