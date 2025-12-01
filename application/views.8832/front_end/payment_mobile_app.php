<html>
	<body>
		<form method="post" name="redirect" action="<?php echo $action; ?>">
		<?php 
			if(isset($_POST) && $_POST !='' && is_array($_POST) > 0)
			{
				foreach ($_POST as $key => $value)
				{
		 ?>
				<input type="hidden" name="<?php echo $key;?>" value="<?php echo $value;?>">
		<?php 	
				} 
			}
		?>
		</form>        
		<script language='javascript'>document.redirect.submit()</script>
	</body>
</html>