<?php
if(!isset($_POST['searchTerm'])){

    //$fetchData = $DatabaseCo->dbLink->query("select id,city_name from city where status='APPROVED' order by city_name limit 10");
    $fetchData = $this->common_model->get_count_data_manual('city_master',array('status'=>'APPROVED','is_deleted'=>'No'),2,'id,city_name','city_name ASC',1,10);
}else{
	$search = $_POST['searchTerm'];
	
   // $fetchData = $DatabaseCo->dbLink->query("select city_id,city_name from city where status='APPROVED' and city_name like '%".$search."%' limit 10");
    $fetchData = $this->common_model->get_count_data_manual('city_master',array('status'=>'APPROVED','is_deleted'=>'No',"city_name like '%$search%'"),2,'id,city_name','city_name ASC',1,10);
}

	foreach ($fetchData as $row) {
        $data[] = array("id"=>$row['city_name'], "text"=>$row['city_name']);
    }

echo json_encode($data);
?>