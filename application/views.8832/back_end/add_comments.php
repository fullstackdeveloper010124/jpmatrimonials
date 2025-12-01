<?php $dna = $this->common_model->data_not_availabel; 
$hidd_user_id = '';
if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] !='')
{
	$hidd_user_id = $_REQUEST['user_id'];
}

$user_data = array();
if($hidd_user_id !='')
{
	$user_data = $this->common_model->get_count_data_manual('ticket_table',array('id'=>$hidd_user_id),1,'* ','',0,'',0);
}
//print_r($user_data);
if(isset($user_data) && $user_data !='' && is_array($user_data) && count($user_data) > 0)
{
?>
<script src="<?php echo $base_url; ?>assets/back_end/vendor/ckeditor/ckeditor.js"></script>
<div id="reponse_message_comm"></div>
<form id="add_comment_form" name="add_comment_form" action="<?php echo $this->common_model->base_url_admin; ?>Ticket_management/save_comment" method="post">
<div id="add_detail">
	
	<div class="row">
        <div class="col-lg-2 col-xs-2 col-sm-2 col-md-2">
        </div>
        <div class="col-lg-10 col-xs-10 col-sm-10 col-md-10">
        	<p>Ticket Number :&nbsp;&nbsp;<?php if(isset($user_data['ticket_number']) && $user_data['ticket_number'] !=''){ echo $user_data['ticket_number'];} else{ echo $dna;}  ?></p>
        
        </div>
    </div>   
    <div class="clearfix"><br/></div>    
    <div class="row form-horizontal">
    	<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
        	<div class="form-group ">
              <label class="col-sm-12 col-lg-12 control-label text-bold">Enter your comment</label>
              <div class="col-sm-12 col-lg-12">
                <textarea rows="5" class="form-control" name="member_comment" id="member_comment" placeholder="Enter your comment"></textarea>
              </div>
            </div>
        </div>
    </div>
    <div class="clearfix"><br/></div>
    <div class="row form-horizontal">
    	<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 text-center">
    		<button type="button" class="btn btn-success mr10" onclick="save_comment_members()">Save Comment</button>
            <button type="button" onclick="close_payment_pop()" class="btn btn-default" data-dismiss="myModal_common">Close</button>           
			<button type="button" class="btn btn-warning mr10" onclick="return display_comments(<?php echo $hidd_user_id;?>)">View  Comment</button>
        </div>
    </div>
    
</div>
<input type="hidden" id="hash_tocken_id" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<input type="hidden" id="hidd_user_id" name="hidd_user_id" value="<?php echo $hidd_user_id;?>" />
</form>
<script type="text/javascript">
	CKEDITOR.replace( 'member_comment', {
	toolbar: [
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
	{ name: 'links', items: [ 'Link', 'Unlink', ] },
	{ name: 'insert', items: [  'Table', 'HorizontalRule' ] },
	{ name: 'styles', items: [ 'Styles', 'Format' ] },
	{ name: 'tools', items: [ 'Maximize' ] },	
	]
});
	//CKEDITOR.replace( 'member_comment' );
</script>
<?php
}
?>