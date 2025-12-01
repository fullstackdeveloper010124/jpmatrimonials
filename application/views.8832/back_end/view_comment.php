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
	$user_data = $this->common_model->get_count_data_manual('register',array('id'=>$hidd_user_id),1,' username, email, mobile, photo1, matri_id, adminrole_id, franchised_by ','',0,'',0);
}
//print_r($user_data);
if(isset($user_data) && $user_data !='' && count($user_data) > 0)
{
	if(!isset($_REQUEST['is_ajax']) || $_REQUEST['is_ajax'] != 1)
	{
?>
<style type="text/css">
.comment { overflow: hidden; padding: 0 0 1em; border-bottom: 1px solid #ddd; margin: 0 0 1em; *zoom: 1; }
.comment-img { float: left;  margin-right: 33px; border-radius: 5px; overflow: hidden; }
.comment-img img { display: block; }
.comment-body { overflow: hidden; }
.comment .text { padding: 10px; border: 1px solid #e5e5e5; border-radius: 5px; background: #fff; }
.comment .text p:last-child {  margin: 0;}
.comment .attribution { margin: 0.5em 0 0; font-size: 14px; color: #666; }
.comments, .comment { position: relative; }
.comments:before, .comment:before, .comment .text:before { content: ""; position: absolute; top: 0; left: 65px; }
.comments:before { width: 3px; top: -20px; bottom: -20px; background: rgba(0,0,0,0.1);}
.comment:before { width: 9px; height: 9px; border: 3px solid #fff; border-radius: 100px; margin: 16px 0 0 -6px; box-shadow: 0 1px 1px rgba(0,0,0,0.2), inset 0 1px 1px rgba(0,0,0,0.1); background: #ccc; }
.comment:hover:before { background: orange; }
.comment .text:before { top: 18px; left: 78px; width: 9px; height: 9px; border-width: 0 0 1px 1px; border-style: solid;border-color: #e5e5e5; background: #fff;  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);}​
</style>
<div id="view_comment_detail">
	<div class="row">
    	<div class="col-lg-5 col-xs-12 col-sm-12 col-md-5 imgPaddingRightZero" align="center">
        	<?php
				$avatar = $this->common_model->photo_avtar;
				if(isset($user_data['photo1']) && $user_data['photo1'] !='')
				{
					$temp_img = $user_data['photo1'];
					if(file_exists($path_img.$temp_img))
					{
						$avatar = $path_img.$temp_img;
					}
				}
			?>
            <img data-src="<?php echo $base_url.$avatar; ?>" title="<?php echo $user_data['username']; ?>" alt="<?php echo $user_data['username']; ?>" class=" img-responsive lazyload">
        </div>
        <div class="col-lg-5 col-xs-12 col-sm-12 col-md-5">
        	<p class="text-bold"><span class="fa fa-user"></span>&nbsp;&nbsp;<?php 
			if(isset($user_data['username']) && $user_data['username'] !=''){echo $user_data['username'];} else{ echo $dna;} 
			if(isset($user_data['matri_id']) && $user_data['matri_id'] !=''){echo " (".$user_data['matri_id'].")";}?></p>
            <p><span class="fa fa-envelope"></span>&nbsp;&nbsp;<?php if(isset($user_data['email']) && $user_data['email'] !=''){if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1){ echo $this->common_model->disable_in_demo_text; } else{ echo $user_data['email'];}} else{ echo $dna;}  ?></p>
            <p><span class="fa fa-phone"></span>&nbsp;&nbsp;
			<?php if(isset($user_data['mobile']) && $user_data['mobile'] !=''){if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1){ echo $this->common_model->disable_in_demo_text; } else{ echo $user_data['mobile'];}} else{ echo $dna;} ?>
            </p>
        </div>
    </div>   
    <div class="clearfix"><br/></div>    
    <?php
	}
	$comment_data = $this->common_model->get_count_data_manual('comment_master',array('index_id'=>$hidd_user_id),2,'*','created_on desc',$page_number,$limit_per_page,0);
	$comment_data_count = $this->common_model->get_count_data_manual('comment_master',array('index_id'=>$hidd_user_id),0,'*','created_on desc ','','',0);
	if(isset($comment_data) && $comment_data !='' && count($comment_data) > 0)
	{
		if(!isset($_REQUEST['is_ajax']) || $_REQUEST['is_ajax'] != 1)
		{?>
		<div style="margin-left:70px;"><h4>Total Comment(<?php echo $comment_data_count; ?>)</h4><br/></div>
	<?php }?>
	 <div id="view_comment_scroll">
        <div id="comment_scroll" style="max-height:470px; overflow: auto;">
		<?php
		foreach($comment_data as $comment_data_val)
		{
			$user_type = $comment_data_val['posted_user_type'];
			$posted_by = $comment_data_val['posted_by'];
			$user_posted_name = 'Administrator';
			if($user_type != 'admin')
			{
				$user_data_name = $this->common_model->get_count_data_manual($user_type,array('id'=>$posted_by),1,' username ');
				if(isset($user_data_name['username']) && $user_data_name['username'] !='')
				{
					$user_posted_name = $user_data_name['username'].' ('.ucwords($user_type).')';
				}
				else
				{
					$user_posted_name = ucwords($user_type);
				}
			}?>
		<section class="comments">
			<article class="comment">
				<a class="comment-img" href="javascript:;">
					<img src="" alt="" width="50" height="50">
				</a>
				<div class="comment-body">
				<div class="text">
					<?php if(isset($comment_data_val['comment']) && $comment_data_val['comment'] !=''){
						echo $comment_data_val['comment'];
					}?>
				</div>
				<p class="attribution text-bold">By <a href="javascript:;"><?php echo $user_posted_name; ?></a> <i class="fa fa-clock-o"></i>
					<?php echo $this->common_model->displayDate($comment_data_val['created_on'],'h:i A, d, M Y');?>
				</p>
				<p class="attribution text-bold">Next follow-up date: <?php echo $this->common_model->displayDate($comment_data_val['next_followup_date'],'d, M Y');?></p>
				</div>
			</article>
		</section>
		<?php }?>
		</div>
		<?php
		if(isset($comment_data_count) && $comment_data_count !='' && $comment_data_count > 0)
		{?>
        	<div class="clearfix"></br></div>
            <div class="pull-right">
                <?php
                    echo $this->common_model->rander_pagination_front('control-panel/member/view_comment/',$comment_data_count,$limit_per_page);
                ?>
            </div>
        <?php
		}
	}
	else
	{
	?>
    <div class="alert alert-danger">No Comment Posted yet.</div>
    <?php
	}
	?>
    <div class="clearfix"><br/></div>
    <div class="row form-horizontal">
    	<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 text-center">
        	<?php
				$access_perm_viewcomm = $this->common_model->check_permission('add_comment');
				$u_id = $this->common_model->get_session_data('id');
				$user_type = $this->common_model->get_session_user_type();
				if($access_perm_viewcomm !='No')
				{
					$view_comm_flag = 1;
					if($access_perm_viewcomm =='Own Members')
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
					<button type="button" class="btn btn-primary mr10" onclick="display_add_comment(<?php echo $hidd_user_id;?>)">Add Comment</button>
					<?php
					}
				}
			?>
            <button type="button" onclick="close_payment_pop()" class="btn btn-default" data-dismiss="myModal_common">Close</button>
        </div>
    </div>
</div>
<input type="hidden" id="hash_tocken_id_temp" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

<input type="hidden" id="hidd_user_id" name="hidd_user_id" value="<?php echo $hidd_user_id;?>" />
<?php
}
if(!isset($_REQUEST['is_ajax']) || $_REQUEST['is_ajax'] != 1)
{
?>
<script type="text/javascript">
$(function()
{
	load_pagination_code_comm('view_comment_scroll');
});
function load_pagination_code_comm(common_displ_div)
{	
   $("#ajax_pagin_ul li a").click(function()
   {
		var page_number = $(this).attr("data-ci-pagination-page");
		var url = $(this).attr("href");
		var hidd_user_id = $("#hidd_user_id").val();

		if(page_number == 1 || page_number == 'undefined')
		{
			url = url + '/1';
		}
		page_number = typeof page_number !== 'undefined' ? page_number : 0;
		if(page_number == 0)
		{
			return false;
		}
		if(url != undefined && url !='' && page_number != undefined && page_number !='' && page_number != 0)
		{
			show_comm_mask();
			var hash_tocken_id = $("#hash_tocken_id").val();
			$.ajax({
			   url: url,
			   type: "post",
			   data: {'csrf_new_matrimonial':hash_tocken_id,'is_ajax':1,'user_id':hidd_user_id},
			   success:function(data)
			   {
					$("#"+common_displ_div).html(data);
					hide_comm_mask();
					load_pagination_code_comm(common_displ_div);
					update_tocken($("#hash_tocken_id_temp").val());
					$("#hash_tocken_id_temp").remove();
					$('#myModal_common').animate({ scrollTop: 330 }, 'slow');
					//scroll_to_div(common_displ_div);
				}
			});
		}
		return false;
	});
}
</script>
<?php }?>