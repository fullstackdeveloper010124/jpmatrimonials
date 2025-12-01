<?php $dna = $this->common_model->data_not_availabel; 
$hidd_user_id = '';
if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] !='')
{
	$hidd_user_id = $_REQUEST['user_id'];
}
$user_data = array();
$path_img = $this->common_model->path_photos;
if($hidd_user_id !='')
{
	$user_data = $this->common_model->get_count_data_manual('leads_generation_view',array('id'=>$hidd_user_id),1,' username, email,phone_no_1,adminrole_id,franchised_by','',0,'',0);
}
if(isset($user_data) && $user_data !='' && count($user_data) > 0)
{
?>
<script src="<?php echo $base_url; ?>assets/back_end/vendor/ckeditor/ckeditor.js"></script>
<div id="reponse_message_comm"></div>
<form id="add_comment_form" name="add_comment_form" action="<?php echo $base_url.$this->common_model->admin_path; ?>/lead_generation/save_comment" method="post">
<div id="add_detail">
	<div class="row">
        <div class="col-lg-5 col-xs-12 col-sm-12 col-md-5">
        	<p class="text-bold"><span class="fa fa-user"></span>&nbsp;&nbsp;<?php 
			if(isset($user_data['username']) && $user_data['username'] !=''){echo $user_data['username'];} else{ echo $dna;}			?></p>
            <p><span class="fa fa-envelope"></span>&nbsp;&nbsp;
			<?php 
			if(isset($user_data['email']) && $user_data['email'] !='')
			{
				if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1)
				{
					echo $this->common_model->disable_in_demo_text;
				}
				else
				{
					echo $user_data['email'];
				}
			} else{ echo $dna;}  ?></p>
            <p><span class="fa fa-phone"></span>&nbsp;&nbsp;
			<?php if(isset($user_data['phone_no_1']) && $user_data['phone_no_1'] !='')
			{
				if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1)
				{
					echo $this->common_model->disable_in_demo_text;
				}
				else
				{
					echo $user_data['phone_no_1'];
				}				
			} 
			else
			{ 
				echo $dna;
			} ?>
            </p>
        </div>
    </div>   
    <div class="clearfix"><br/></div>    
    <div class="row form-horizontal">
    	<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
        	<div class="form-group ">
              <label class="col-sm-12 col-lg-12 control-label text-bold">Enter your comment</label>
              <div class="col-sm-12 col-lg-12">
                <textarea rows="5" class="form-control" name="lead_comment" id="lead_comment" placeholder="Enter your comment"></textarea>
              </div>
            </div>
        </div>
    </div>
    <div class="clearfix"><br/></div>    
    <div class="row form-horizontal">
    	<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
        	<div class="form-group ">
              <label class="col-sm-4 col-lg-4 control-label text-bold">Next Followup Date</label>
              <div class="col-sm-8 col-lg-8">
              	<input class="form-control datepicker" name="next_followup_date" id="lead_next_followup_date" placeholder="Select Next Followup Date">
              </div>
            </div>
        </div>
    </div>
    <div class="clearfix"><br/></div>
    <div class="row form-horizontal">
    	<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 text-center">
    		<button type="button" class="btn btn-success mr10" onclick="save_comment_lead_generation()">Save Comment</button>
            <button type="button" onclick="close_payment_pop()" class="btn btn-default" data-dismiss="myModal_common">Close</button>
            <?php
				$access_perm_viewcomm = $this->common_model->check_permission('lead_generation_view_comment');
				$u_id = $this->common_model->get_session_data('id');
				$user_type = $this->common_model->get_session_user_type();
				if($access_perm_viewcomm != 'No')
				{
					$view_comm_flag = 1;
					if($access_perm_viewcomm == 'Own Members')
					{
						$field_check = 'adminrole_id';
						if($user_type =='franchise')
						{
							$field_check = 'franchised_by';
						}
						if($u_id != $user_data[$field_check])
						{
							$view_comm_flag = 0;
						}
					}
					if($view_comm_flag == 1)
					{
				?>
				<button type="button" class="btn btn-warning mr10" onclick="lead_generation_comment(<?php echo $hidd_user_id;?>)">View Comment</button>
				<?php
					}
				}
			?>
        </div>
    </div>
    
</div>
<input type="hidden" id="hash_tocken_id_temp" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<input type="hidden" id="hidd_user_id" name="hidd_user_id" value="<?php echo $hidd_user_id;?>" />
</form>
<script type="text/javascript">
	CKEDITOR.replace( 'lead_comment', {
	toolbar: [
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
	{ name: 'links', items: [ 'Link', 'Unlink', ] },
	{ name: 'insert', items: [  'Table', 'HorizontalRule' ] },
	{ name: 'styles', items: [ 'Styles', 'Format' ] },
	{ name: 'tools', items: [ 'Maximize' ] },	
	]
});
	var date = new Date();
	date.setDate(date.getDate());
	$('#lead_next_followup_date').datepicker({
		format: "yyyy-mm-dd",
		startDate: date
	});
</script>
<?php
}
?>