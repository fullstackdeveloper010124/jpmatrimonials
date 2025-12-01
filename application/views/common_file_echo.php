<?php
if(isset($data) && $data !='')
{
	if(is_array($data))
	{
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
	else
	{
		echo $data;
	}
}
if(isset($data_javascript) && $data_javascript !='')
{
?>
<script type="text/javascript">
<?php echo $data_javascript; ?>
</script>
<?php
}
?>