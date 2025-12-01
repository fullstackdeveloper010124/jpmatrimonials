<?php 
$brother = (isset($_REQUEST['count_brother']) && $_REQUEST['count_brother']!='')? $_REQUEST['count_brother']:'';
$sister = (isset($_REQUEST['count_sister']) && $_REQUEST['count_sister']!='')? $_REQUEST['count_sister']:'';
$member_id = $this->common_front_model->get_session_data('id');
$row_data = $this->common_model->get_count_data_manual('register_view',array('id'=>$member_id,'is_deleted'=>'No'),1,'no_of_married_brother,no_of_married_sister');

if(isset($brother) && $brother!='')
{
?>
<option value="">Select no of married brother</option>

<?php
    $k=0;
    $data_array = $this->common_model->get_list_ddr('no_marri_brother');
    if(isset($data_array) && $data_array!='' && is_array($data_array) && ($data_array)>0){
        foreach ($data_array as $key => $value) {
            $bro_marri[$k] = $data_array[$key];
            $k++;
        }
    }
    for($i = 0; $i<=$brother;$i++)
    {
        ?>
        <option value="<?php echo $bro_marri[$i];?>" <?php if(isset($row_data['no_of_married_brother']) && $row_data['no_of_married_brother']==$bro_marri[$i]){ echo 'selected';}?>><?php echo $bro_marri[$i];?></option>
        <?php
    }
}
elseif(isset($sister) && $sister!='')
{
    ?>   
    <option value="">Select no of married sister</option>
    
<?php
    $u=0;
    $sis_data_array = $this->common_model->get_list_ddr('no_marri_sister');
    if(isset($sis_data_array) && $sis_data_array!='' && is_array($sis_data_array) && ($sis_data_array)>0){
        foreach ($sis_data_array as $key => $value) {
            $sis_marri[$u] = $sis_data_array[$key];
            $u++;
        }
    }
    for($si = 0; $si<=$sister;$si++)
    {
        ?>
        <option value="<?php echo $sis_marri[$si];?>" <?php if(isset($row_data['no_of_married_sister']) && $row_data['no_of_married_sister']==$sis_marri[$si]){ echo 'selected';}?>><?php echo $sis_marri[$si];?></option>
        <?php
    }
}?>