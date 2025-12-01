<?php

if(isset($_POST['keyword']))
{
	$keyword=$_POST['keyword'];
}
else
{
	$keyword='';
}
if(isset($_POST['search_page_nm']))
{
	$search_page_nm=$_POST['search_page_nm'];	
}
else
{
	$search_page_nm='';
}
echo $keyword;

echo "Your search preferences saved successfully.";
 ?>