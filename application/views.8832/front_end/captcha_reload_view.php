<?php
if(isset($captcha_session) && $captcha_session !=''){?>
<img src="<?php echo $base_url; ?>captcha.php?captch_code_front=yes&captch_code=<?php echo $this->session->userdata[$captcha_session]; ?>" style="border-radius: 6px;"/>
<?php }?>