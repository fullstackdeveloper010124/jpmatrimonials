<html>
	<body>
	<?php include('Crypto.php');?>
	<?php 
		
		$ccavenue = $this->common_model->get_count_data_manual('payment_method'," name = 'CCAvenue' ",1,'*','','','',"");
		if(isset($ccavenue) && $ccavenue !='' && is_array($ccavenue) && count($ccavenue) > 0)
		{
		// testing code set
		//$merchant_data='';
		//$working_key='8B2159997F4C12FA4F962D2042C6797D';//Shared by CCAVENUES
		//$access_code='AVON66DG25CC77NOCC';//Shared by CCAVENUES
		
		$merchant_data='';
		$working_key=$ccavenue['key'];//Shared by CCAVENUES
		$access_code=$ccavenue['salt_access_code'];//Shared by CCAVENUES
        
		foreach ($_POST as $key => $value)
        {
			$merchant_data.=$key.'='.urlencode($value).'&';
        }
		$merchant_data.='amount='.$plan_data['total_pay'];	 
        
		$encrypted_data=encrypt($merchant_data,$working_key);
		if(base_url()=='http://192.168.1.111/mega_matrimony/original_script/v2.0/'){?>
			<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
		<?php }else{?>
			<form method="post" name="redirect" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
        <?php }?>
			<?php
				echo "<input type=hidden name=encRequest value=$encrypted_data>";
				echo "<input type=hidden name=access_code value=$access_code>";
			?>
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
		</form>
        
		<script language='javascript'>document.redirect.submit()</script>
        <?php
		}
		else
		{
		?>
        <div class="alert alert-danger">Please try again</div>
        <?php
		}
		?>
	</body>
</html>