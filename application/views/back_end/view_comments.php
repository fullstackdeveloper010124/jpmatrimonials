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
    	<div class="col-lg-2 col-xs-2 col-sm-2 col-md-2">
        </div>
        <div class="col-lg-10 col-xs-10 col-sm-10 col-md-10">
        	<p>Ticket Number&nbsp;&nbsp;<?php if(isset($user_data['ticket_number']) && $user_data['ticket_number'] !=''){ echo $user_data['ticket_number'];} else{ echo $dna;}  ?></p>
           <!--  <p><span class="fa fa-envelope"></span>&nbsp;&nbsp;<?php if(isset($user_data['project_name']) && $user_data['project_name'] !=''){ echo $user_data['project_name'];} else{ echo $dna;}  ?></p>
            <p class="text-bold"><span class="fa fa-user"></span>&nbsp;&nbsp;<?php 
			if(isset($user_data['full_name']) && $user_data['full_name'] !=''){echo $user_data['full_name'];} else{ echo $dna;} 
			if(isset($user_data['company_name']) && $user_data['company_name'] !=''){echo " (".$user_data['company_name'].")";}?></p>
            <p><span class="fa fa-envelope"></span>&nbsp;&nbsp;<?php if(isset($user_data['website_url']) && $user_data['website_url'] !=''){ echo '<a href="'.$user_data['website_url'].'" target="_blank">'.$user_data['website_url'].'</a>';} else{ echo $dna;}  ?></p>
            <p><span class="fa fa-envelope"></span>&nbsp;&nbsp;<?php if(isset($user_data['email']) && $user_data['email'] !=''){ echo $user_data['email'];} else{ echo $dna;}  ?></p>
            <p><span class="fa fa-phone"></span>&nbsp;&nbsp;
			<?php if(isset($user_data['mobile']) && $user_data['mobile'] !=''){ echo $user_data['mobile'];} else{ echo $dna;} ?>
            </p> -->
        </div>
    </div>   
    <div class="clearfix"><br/></div>    
    
    <?php
	}
	$ticket_number = '';
	if(isset($user_data['ticket_number']) && $user_data['ticket_number'] !='')
	{
		$ticket_number = $user_data['ticket_number'];
	}
	if($ticket_number !='')
	{ 
		$comment_data = $this->common_model->get_count_data_manual('ticket_history_reply',array('ticket_number'=>$ticket_number),2,'*','created_on desc',$page_number,$limit_per_page,0);
		$comment_data_count = $this->common_model->get_count_data_manual('ticket_history_reply',array('ticket_number'=>$ticket_number),0,'*','created_on desc ','','',0);
	}
	if(isset($comment_data) && $comment_data !='' && is_array($comment_data) && count($comment_data) > 0)
	{
		if(!isset($_REQUEST['is_ajax']) || $_REQUEST['is_ajax'] != 1)
		{
	?>
		<div style="margin-left:70px;"><h4>Total Comment(<?php echo $comment_data_count; ?>)</h4><br/></div>
	<?php }?>
	 <div id="view_comment_scroll">
        <div id="comment_scroll" style="max-height:470px; overflow: auto;">
		<?php
		foreach($comment_data as $comment_data_val)
		{
			
			
			 $user_type = $comment_data_val['user_type'];

			//$posted_by = $comment_data_val['user_id'];
			$user_posted_name = 'Narjis Developer';
			if($user_type == 'S' or $user_type == 'A')
			{
		//	echo "<pre>";
		//	print_r($comment_data);
		//	exit;
				//$user_type = 'S';
			
				// if(isset($user_data_name['S']))
				// {
				// 	$user_posted_name = $user_data_name['S'].' ( Staff )';
				// }
				// else
				// {
				// 	$user_posted_name = $user_data_name['A'].' ( Administrator )';
				// }
				
			}
			else if($user_type == 'C')
			{
					$user_posted_name ='Client';
			}
			
	?>
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
				<?php
					echo $this->common_model->displayDate($comment_data_val['created_on'],'h:i A, d, M Y');
				?>
			</p>
          </div>
        </article>
      </section>
    <?php
		}
		?>
		</div>
		<?php
		if(isset($comment_data_count) && $comment_data_count !='' && $comment_data_count > 0)
		{
		?>
        	<div class="clearfix"></br></div>
            <div class="pull-right">
                <?php
                    echo $this->common_model->rander_pagination_front('control-panel/ticket_management/view_comment/',$comment_data_count,$limit_per_page);
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
    			<button type="button" class="btn btn-primary mr10" onclick="display_add_comments(<?php echo $hidd_user_id;?>)">Add Comment</button>
                <button type="button" onclick="close_payment_pop()" class="btn btn-default" data-dismiss="myModal_common">Close</button>
        </div>
    </div>
</div>
<input type="hidden" id="hash_tocken_id_temp" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<input type="hidden" id="hash_tocken_id" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
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
			var	hash_tocken_id = $("#hash_tocken_id").val();
			
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