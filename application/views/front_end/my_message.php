<?php 
$message_type = 'inbox';
if($this->input->post('message_type'))
{
	$message_type_p = $this->input->post('message_type');
	if($message_type_p !='')
	{
		$message_type = $message_type_p;
	}
}
?>
<style> .user { padding: 5px; margin-bottom: 5px; text-align: center; } 


</style>
<!------------------<container>----End------------------------------------>
    <div class="clearfix"></div>
    <div class="container margin-top-20 padding-lr-zero-xs">
        <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-0-5-xs">
            <div class="">
                <img src="<?php echo $base_url; ?>assets/front_end/images/icon/register-header-female.jpg" class="ful-width img-thumbnail" alt="" style="width:100%;" /> 
            </div>
        </div>
        <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-320 padding-lr-zero-480 padding-20-5-xs" style="padding:20px 20px;">
            <div class="xxl-4 xl-4 s-16 m-16 l-4 xs-16 ne_inbox_left_pan padding-lr-zero-320 padding-lr-zero-480 padding-lr-zero-xs hidden-xs">
                <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                    <a href="<?php echo $base_url; ?>message/compose-msg" class="btn-compose-new-msg xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne-cursor" onClick="cmpchkmsg();">
                        <i class="fa fa-plus ne_mrg_ri8_10"></i>Compose New
                    </a>
                </div>
                
                <ul class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 bg-border margin-top-10px padding-lr-zero border-top">
                    <li class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                        <a href="<?php echo $base_url; ?>message/inbox" class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-999 ">
                            <div class="bold xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">
                                <i class="fa fa-inbox ne_mrg_ri8_10"></i>Inbox
                            </div>
                            <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4">
                                <span class="ne-counter pull-right ">0</span>
                            </div>
                        </a>
                    </li>
                    
                    <li class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                        <a href="<?php echo $base_url; ?>message/sent-msg" class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-999 ">
                            <div class="bold xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">
                                <i class="fa fa-paper-plane ne_mrg_ri8_10"></i>Sent
                            </div>
                            <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4">
                                <span class="ne-counter pull-right ">0</span>
                            </div>
                        </a>
                    </li>
                    
                    <li class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                        <a href="<?php echo $base_url; ?>message/draft-msg" class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-999 ">
                            <div class="bold xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">
                                <i class="fa fa-envelope ne_mrg_ri8_10"></i>Draft
                            </div>
                            <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4">
                                <span class="ne-counter pull-right ">0</span>
                            </div>
                        </a>
                    </li>
                    
                    <li class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                        <a href="<?php echo $base_url; ?>message/important-msg" class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-999 ">
                            <div class="bold xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">
                                <i class="fa fa-star-o ne_mrg_ri8_10"></i>Important
                            </div>
                            <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4">
                                <span class="ne-counter pull-right ">0</span>
                            </div>
                        </a>
                    </li>
                    
                    <li class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
                        <a href="<?php echo $base_url; ?>message/trash-msg" class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-999 ">
                            <div class="bold xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">
                                <i class="fa fa-trash-o ne_mrg_ri8_10"></i>Trash
                            </div>
                            <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4">
                                <span class="ne-counter pull-right ">0</span>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <div class="xxl-12 xl-12 l-12 xs-16 m-16 s-16 ne_inbox_right_pan padding-lr-zero-320 margin-top-10px-320px padding-lr-zero-480 margin-top-10px-480px  ne-mrg-top-10-768 bg-border border-top padding-20-5-xs">
                <h3 class="upgrade-heading margin-top-0px font-18 text-white text-center" style="padding:5px;">
                    <i class="fa fa-inbox ne_mrg_ri8_10"></i>
                   <?php echo ucfirst($message_type); ?>
                </h3>
                
                <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 bg-offwhite ne-bdr-tpstrip-inbox ne_pad_tp_5px" style="background-image:-webkit-gradient(linear,left top,left bottom,from(#f5f5f5),to(#cfd1cf));border-radius:3px;border:1px solid #ddd;">
                    <div class="xxl-8 xl-8 xs-16 s-16 m-16 l-9 margin-top-5-xs">
                        <div class="row">
                            <span  class="ne_mrg_ri8_10" >
                                <div class="checkbox checkbox-success margin-top-10px margin-bottom-0px margin-left-5" style="display:inline-block;float:left;">
                                    <input type="checkbox" name="checkbox" id="checkbox-c1" value="c1" class="styled">
                                    <label for="checkbox-c1" class="control-label"></label>
                                </div>
                            </span>
                            
                            <div class="dropdown ne_disply-inline-blk">
                                <a class="dropdown-toggle  btn btn-default ne_msg_tp_strip" data-toggle="dropdown" style="border:1px solid #ccc;">
                                    <i class="fa fa-angle-down text-darkgrey"></i>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a >All</a></li>
                                    <li><a >Read</a></li>
                                    <li><a >Unread</a></li>
                                </ul>
                            </div>
                            
                            <a class="ne_msg_tp_strip btn btn-danger text-white" data-toggle="modal" data-target="#myModal_delete" title="Trash" >
                                <i class="fa fa-trash"></i>
                            </a>
                            <a class="btn btn-warning ne_msg_tp_strip text-white" data-toggle="tooltip" data-placement="top" title="Important" >
                                <i class="fa fa-star-o"></i>
                            </a>
                            <a class="btn btn-primary ne_msg_tp_strip text-white" data-toggle="tooltip" data-placement="top" title="Refresh" >
                                <i class="fa fa-refresh"></i>
                            </a>
                            <a class="btn btn-danger ne_msg_tp_strip text-white" data-toggle="tooltip" data-placement="top" title="" data-original-title="Reply">
                                <i class="fa fa-reply"></i>
                            </a>
                            <a class="btn btn-success ne_msg_tp_strip text-white" data-toggle="tooltip" data-placement="top" title="Forward" >
                                <i class="fa fa-share"></i>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        
                        <div id="myModal_delete" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"><img src="<?php echo $base_url; ?>assets/front_end/images/icon/alert.png" alt="" class="" /> Delete This Saved Profile</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="xxl-16 xl-16 l-16 m-16 xs-16 s-16">
                                            <div class="alert alert-danger" style="overflow:hidden;box-shadow:4px 4px 0 0 #ccc;">
                                                <div class="xxl-2 xl-2 l-2 m-16 xs-16 s-16">
                                                    <img src="<?php echo $base_url; ?>assets/front_end/images/icon/delete.png" alt="" class="margin-right-10 margin-top-10" />
                                                </div>
                                                <div class="xxl-13 xl-13 l-13 m-16 xs-16 s-16 xxl-margin-left-1 xl-margin-left-1 margin-top-10">
                                                    <strong>Are you sure want to Delete this Records?</strong><br />
                                                    <span class="small">This Records will be Deleted Permanently from your Entire Records.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="modal-footer margin-top-10">
                                        <a class="btn btn-sm btn-success"><i class="fa fa-check"></i> Yes</a>
                                        <a class="btn btn-sm btn-danger margin-left-0-xs margin-top-10-xs" data-dismiss="modal"><i class="fa fa-close"></i> No</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="xxl-8 xl-8 m-16 xs-16 s-16 l-7 margin-top-10px-320px margin-top-10px-480px">
                        <div class="row">
                            <div class="xxl-5 xxl-margin-left-1 xs-6 s-6"></div>
                            <div class="xxl-10 xs-16 s-16 pull-right padding-lr-zero margin-top-10-xs">
                                <div class="xxl-16 padding-lr-zero">
                                    <div class="inner-addon right-addon">
                                        <i class="glyphicon glyphicon-search"></i>
                                        <input type="text" class="form-control search" placeholder="Search" style="padding:6px 10px;margin-bottom:5px;" />				
                                        <input type="text" name="message_type" id="message_type" value="<?php echo $message_type; ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix margin-top-20px"></div>
                
                <form method="post" id="msg_data_form">
                    <ul class="xxl-16 xl-16 s-16 l-16 m-16 xs-16 bg-white margin-top-10px ne_inbox_msg_section padding-lr-zero list" style="border:1px solid #ddd;">
                        <li class="ne_inbox_msg xxl-16 xl-16 s-16 xs-16 m-16 l-16">
                            <div class="xxl-12 xl-16 xs-16 s-16 m-16 padding-lr-zero">
                                <div class="ne_font_16 xxl-6 xl-6 xs-16 s-16 m-16 padding-lr-zero">
                                    <div class="checkbox checkbox-success margin-top-0px margin-bottom-0px margin-left-10" style="display:inline-block;float:left;">
                                        <input type="checkbox" name="checkbox" id="checkbox-0" value="1" class="styled">
                                        <label for="checkbox-0" class="control-label"></label>
                                    </div>
                                    <a class="ne_inbox_msg_imp pull-left ne_mrg_ri8_5" onclick="importantfun(16,'No');">
                                        <i class="fa fa-star ne_inbox_msg_imp_active" style="margin-left:5px;"></i>
                                    </a>

                                    <a href="#" class="ne_font_18 pull-left" data-toggle="tooltip" data-placement="top" title="">
                                        <div class="padding-lr-zero ne_inbox_msg_id ne_inbox_msg_id_unreaded ne_font_11 name"></div>
                                    </a>
                                </div>
                                <a href="#" class="xxl-10 xl-10 xs-16 s-16 m-16 ne_inbox_msg_content padding-lr-zero-320 margin-top-5px-320 hidden-xs">
                                    <b class="ne_mrg_ri8_5 font-13 name">(&nbsp;this is a test message by siddharth&nbsp;) &nbsp;</b>
                                </a>

                                <a href="#" class="xxl-10 xs-16 s-16 m-16 ne_inbox_msg_content padding-lr-zero-320 margin-top-5px-320 visible-xs">
                                    <b class="ne_mrg_ri8_5 name1">(&nbsp;this is a test message by siddharth&nbsp;) &nbsp;</b>
                                </a>
                            </div>

                            <div class="xxl-4 xl-16 xs-16 ne_font_12 right-text ne_pad_tp_3px margin-top-5px-320 name2">
                                <i class="fa fa-clock-o ne_mrg_ri8_5"></i>13 Jun 2017 ,16:23 PM
                            </div>
                        </li>
                        <li class="ne_inbox_msg xxl-16 xl-16 s-16 xs-16 m-16 l-16">
                            <div class="xxl-12 xl-16 xs-16 s-16 m-16 padding-lr-zero">
                                <div class="ne_font_16 xxl-6 xl-6 xs-16 s-16 m-16 padding-lr-zero">
                                    <div class="checkbox checkbox-success margin-top-0px margin-bottom-0px margin-left-10" style="display:inline-block;float:left;">
                                        <input type="checkbox" name="checkbox" id="checkbox-1" value="2" class="">
                                        <label for="checkbox-1" class="control-label"></label>
                                    </div>
                                    
                                    <a class="ne_inbox_msg_imp pull-left ne_mrg_ri8_5" onclick="importantfun(15,'Yes');">
                                        <i class="fa fa-star" style="margin-left:5px;"></i>
                                    </a>
                                    <a href="inbox_main_msg.php?msg_id=15&amp;inb=1" class="ne_font_18 pull-left" data-toggle="tooltip" data-placement="top" title="">
                                        <div class="padding-lr-zero ne_inbox_msg_id ne_inbox_msg_id_unreaded ne_font_11 name"></div>
                                    </a>
                                </div>

                                <a href="inbox_main_msg.php?msg_id=15&amp;inb=1" class="xxl-10 xl-10 xs-16 s-16 m-16 ne_inbox_msg_content padding-lr-zero-320 margin-top-5px-320 hidden-xs">
                                    <b class="ne_mrg_ri8_5 font-13 name">(&nbsp;this is a test message by siddharth&nbsp;) &nbsp;</b>
                                </a>
                                <a href="inbox_main_msg.php?msg_id=15&amp;inb=1" class="xxl-10 xs-16 s-16 m-16 ne_inbox_msg_content padding-lr-zero-320 margin-top-5px-320 visible-xs">
                                    <b class="ne_mrg_ri8_5 name1">(&nbsp;this is a test message by siddharth&nbsp;) &nbsp;</b>
                                </a>
                            </div>
                            <div class="xxl-4 xl-16 xs-16 ne_font_12 right-text ne_pad_tp_3px margin-top-5px-320 name2">
                                <i class="fa fa-clock-o ne_mrg_ri8_5"></i>13 Jun 2017 ,16:15 PM
                            </div>
                        </li>
                        
                        <li class="ne_inbox_msg xxl-16 xl-16 s-16 xs-16 m-16 l-16">
                            <div class="xxl-12 xl-16 xs-16 s-16 m-16 padding-lr-zero">
                                <div class="ne_font_16 xxl-6 xl-6 xs-16 s-16 m-16 padding-lr-zero">
                                    <div class="checkbox checkbox-success margin-top-0px margin-bottom-0px margin-left-10" style="display:inline-block;float:left;">
                                        <input type="checkbox" name="checkbox" id="checkbox-2" value="3" class="">
                                        <label for="checkbox-2" class="control-label"></label>
                                    </div>
                                    <a class="ne_inbox_msg_imp pull-left ne_mrg_ri8_5" onclick="importantfun(15,'Yes');">
                                        <i class="fa fa-star" style="margin-left:5px;"></i>
                                    </a>
                                    <a href="inbox_main_msg.php?msg_id=15&amp;inb=1" class="ne_font_18 pull-left" data-toggle="tooltip" data-placement="top" title="">

                                        <div class="padding-lr-zero ne_inbox_msg_id ne_inbox_msg_id_unreaded ne_font_11 name">
                                         </div>
                                    </a>
                                </div>

                                <a href="inbox_main_msg.php?msg_id=15&amp;inb=1" class="xxl-10 xl-10 xs-16 s-16 m-16 ne_inbox_msg_content padding-lr-zero-320 margin-top-5px-320 hidden-xs">
                                    <b class="ne_mrg_ri8_5 font-13 name">(&nbsp;this is a test message by siddharth&nbsp;) &nbsp;</b>
                                </a>
                                <a href="inbox_main_msg.php?msg_id=15&amp;inb=1" class="xxl-10 xs-16 s-16 m-16 ne_inbox_msg_content padding-lr-zero-320 margin-top-5px-320 visible-xs">
                                    <b class="ne_mrg_ri8_5 name1">(&nbsp;this is a test message by siddharth&nbsp;) &nbsp;</b>
                                </a>
                            </div>
                            <div class="xxl-4 xl-16 xs-16 ne_font_12 right-text ne_pad_tp_3px margin-top-5px-320 name2">
                                <i class="fa fa-clock-o ne_mrg_ri8_5"></i>13 Jun 2017 ,16:15 PM
                            </div>
                        </li>
                        
                        <li class="ne_inbox_msg xxl-16 xl-16 s-16 xs-16 m-16 l-16">
                            <div class="xxl-12 xl-16 xs-16 s-16 m-16 padding-lr-zero">
                                <div class="ne_font_16 xxl-6 xl-6 xs-16 s-16 m-16 padding-lr-zero">
                                    <div class="checkbox checkbox-success margin-top-0px margin-bottom-0px margin-left-10" style="display:inline-block;float:left;">
                                        <input type="checkbox" name="checkbox" id="checkbox-3" value="4" class="">
                                        <label for="checkbox-3" class="control-label"></label>
                                    </div>
                                    <a class="ne_inbox_msg_imp pull-left ne_mrg_ri8_5" onclick="importantfun(15,'Yes');">
                                        <i class="fa fa-star" style="margin-left:5px;"></i>
                                    </a>
                                    <a href="inbox_main_msg.php?msg_id=15&amp;inb=1" class="ne_font_18 pull-left" data-toggle="tooltip" data-placement="top" title="">
                                        <div class="padding-lr-zero ne_inbox_msg_id ne_inbox_msg_id_unreaded ne_font_11 name"></div>
                                    </a>
                                </div>

                                <a href="inbox_main_msg.php?msg_id=15&amp;inb=1" class="xxl-10 xl-10 xs-16 s-16 m-16 ne_inbox_msg_content padding-lr-zero-320 margin-top-5px-320 hidden-xs">
                                    <b class="ne_mrg_ri8_5 font-13 name">(&nbsp;this is a test message by siddharth&nbsp;) &nbsp;</b>
                                </a>
                                <a href="inbox_main_msg.php?msg_id=15&amp;inb=1" class="xxl-10 xs-16 s-16 m-16 ne_inbox_msg_content padding-lr-zero-320 margin-top-5px-320 visible-xs">
                                    <b class="ne_mrg_ri8_5 name1">(&nbsp;this is a test message by siddharth&nbsp;) &nbsp;</b>
                                </a>
                            </div>
                            <div class="xxl-4 xl-16 xs-16 ne_font_12 right-text ne_pad_tp_3px margin-top-5px-320 name2">
                                <i class="fa fa-clock-o ne_mrg_ri8_5"></i>13 Jun 2017 ,16:15 PM
                            </div>
                        </li>
                        
                        <li class="ne_inbox_msg xxl-16 xl-16 s-16 xs-16 m-16 l-16">
                            <div class="xxl-12 xl-16 xs-16 s-16 m-16 padding-lr-zero">
                                <div class="ne_font_16 xxl-6 xl-6 xs-16 s-16 m-16 padding-lr-zero">
                                    <div class="checkbox checkbox-success margin-top-0px margin-bottom-0px margin-left-10" style="display:inline-block;float:left;">
                                        <input type="checkbox" name="checkbox" id="checkbox-4" value="5" class="">
                                        <label for="checkbox-4" class="control-label"></label>
                                    </div>
                                    <a class="ne_inbox_msg_imp pull-left ne_mrg_ri8_5" onclick="importantfun(15,'Yes');">
                                        <i class="fa fa-star" style="margin-left:5px;"></i>
                                    </a>
                                    <a href="inbox_main_msg.php?msg_id=15&amp;inb=1" class="ne_font_18 pull-left" data-toggle="tooltip" data-placement="top" title="">
                                        <div class="padding-lr-zero ne_inbox_msg_id ne_inbox_msg_id_unreaded ne_font_11 name"></div>
                                    </a>
                                 </div>

                                <a href="inbox_main_msg.php?msg_id=15&amp;inb=1" class="xxl-10 xl-10 xs-16 s-16 m-16 ne_inbox_msg_content padding-lr-zero-320 margin-top-5px-320 hidden-xs">
                                    <b class="ne_mrg_ri8_5 font-13 name">(&nbsp;this is a test message by siddharth&nbsp;) &nbsp;</b>
                                </a>
                                <a href="inbox_main_msg.php?msg_id=15&amp;inb=1" class="xxl-10 xs-16 s-16 m-16 ne_inbox_msg_content padding-lr-zero-320 margin-top-5px-320 visible-xs">
                                    <b class="ne_mrg_ri8_5 name1">(&nbsp;this is a test message by siddharth&nbsp;) &nbsp;</b>
                                </a>
                            </div>
                            <div class="xxl-4 xl-16 xs-16 ne_font_12 right-text ne_pad_tp_3px margin-top-5px-320 name2">
                                <i class="fa fa-clock-o ne_mrg_ri8_5"></i>13 Jun 2017 ,16:15 PM
                            </div>
                        </li>
                    </ul>
                </form>
                
                <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 bg-offwhite ne-bdr-tpstrip-inbox ne_pad_tp_5px" style="background-image:-webkit-gradient(linear,left top,left bottom,from(#f5f5f5),to(#cfd1cf));border-radius:3px;border:1px solid #ddd;">
                    <div class="xxl-8 xl-8 xs-16 s-16 m-16 l-9 margin-top-5-xs">
                        <div class="row">
                            <span  class="ne_mrg_ri8_10" >
                                <div class="checkbox checkbox-success margin-top-10px margin-bottom-0px margin-left-5" style="display:inline-block;float:left;">
                                    <input type="checkbox" name="checkbox" id="checkbox-c2" value="c2" class="styled">
                                    <label for="checkbox-c2" class="control-label"></label>
                                </div>
                            </span>
                            
                            <div class="dropdown ne_disply-inline-blk">
                                <a class="dropdown-toggle  btn btn-default ne_msg_tp_strip" data-toggle="dropdown" style="border:1px solid #ccc;">
                                    <i class="fa fa-angle-down text-darkgrey"></i>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a >All</a></li>
                                    <li><a >Read</a></li>
                                    <li><a >Unread</a></li>
                                </ul>
                            </div>
                            
                            <a class="ne_msg_tp_strip btn btn-danger text-white" data-toggle="modal" data-target="#myModal_delete" title="Trash" >
                                <i class="fa fa-trash"></i>
                            </a>
                            <a class="btn btn-warning ne_msg_tp_strip text-white" data-toggle="tooltip" data-placement="top" title="Important" >
                                <i class="fa fa-star-o"></i>
                            </a>
                            <a class="btn btn-primary ne_msg_tp_strip text-white" data-toggle="tooltip" data-placement="top" title="Refresh" >
                                <i class="fa fa-refresh"></i>
                            </a>
                            <a class="btn btn-danger ne_msg_tp_strip text-white" data-toggle="tooltip" data-placement="top" title="Reply" >
                                <i class="fa fa-reply"></i>
                            </a>
                            <a class="btn btn-success ne_msg_tp_strip text-white" data-toggle="tooltip" data-placement="top" title="Forward" >
                                <i class="fa fa-share"></i>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <div id="myModal_delete" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"><img src="<?php echo $base_url; ?>assets/front_end/images/icon/alert.png" alt="" class="" /> Delete This Saved Profile</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="xxl-16 xl-16 l-16 m-16 xs-16 s-16">
                                            <div class="alert alert-danger" style="overflow:hidden;box-shadow:4px 4px 0 0 #ccc;">
                                                <div class="xxl-2 xl-2 l-2 m-16 xs-16 s-16">
                                                    <img src="<?php echo $base_url; ?>assets/front_end/images/icon/delete.png" alt="" class="margin-right-10 margin-top-10" />
                                                </div>
                                                <div class="xxl-13 xl-13 l-13 m-16 xs-16 s-16 xxl-margin-left-1 xl-margin-left-1 margin-top-10">
                                                    <strong>Are you sure want to Delete this Records?</strong><br />
                                                    <span class="small">This Records will be Deleted Permanently from your Entire Records.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="modal-footer margin-top-10">
                                        <a class="btn btn-sm btn-success"><i class="fa fa-check"></i> Yes</a>
                                        <a class="btn btn-sm btn-danger margin-left-0-xs margin-top-10-xs" data-dismiss="modal"><i class="fa fa-close"></i> No</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="xxl-8 xl-8 m-16 xs-16 s-16 l-7 margin-top-10px-320px margin-top-10px-480px">
                        <div class="row">
                            <div class="xxl-5 xxl-margin-left-1 xs-6 s-6"></div>
                            <div class="xxl-10 xs-16 s-16 pull-right padding-lr-zero margin-top-10-xs">
                                <div class="xxl-16 padding-lr-zero">
                                    <div class="inner-addon right-addon">
                                        <i class="glyphicon glyphicon-search"></i>
                                        <input type="text" class="form-control search" placeholder="Search" style="padding:6px 10px;margin-bottom:5px;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="test" class="hidden-lg hidden-md hidden-sm" style="padding-left:0px;width:-315px !important;">
        <div class="user margin-top-20">
            <h3 href="#" target="_blank" class="navbar-link text-shadow-black">Browse Message Category</h3>
        </div>

        <div class="list-group margin-top-10" style="box-shadow:none;" id="main_content_ajax">
            <div class="xxl-16 xl-16 l-16 m-16 xs-16 s-16">
                <a href="<?php echo $base_url; ?>messages/compose_msg" class="text-shadow-black btn-compose-new-msg xxl-16 xl-16 l-16 m-16 s-16 xs-16 ne-cursor margin-bottom-10" onClick="cmpchkmsg();" style="box-shadow:0 0px 4px rgba(43,59,93,0.29);">
                    <i class="fa fa-plus ne_mrg_ri8_10"></i>Compose New
                </a>
            </div>
            <a href="<?php echo $base_url; ?>messages/inbox" class="list-group-item">
                <div class="bold xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">
                    <i class="fa fa-inbox ne_mrg_ri8_10"></i> Inbox
                </div>
                <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4 text-shadow-black">
                    <span class="ne-counter pull-right ">0</span>
                </div>
            </a>
            <a href="<?php echo $base_url; ?>messages/sent-msg" class="list-group-item">
                <div class="bold xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">
                    <i class="fa fa-paper-plane ne_mrg_ri8_10"></i>Sent
                </div>
                <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4 text-shadow-black">
                    <span class="ne-counter pull-right ">0</span>
                </div>
            </a>

            <a href="<?php echo $base_url; ?>messages/draft-msg" class="list-group-item">
                <div class="bold xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">
                    <i class="fa fa-envelope ne_mrg_ri8_10"></i>Draft
                </div>
                <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4 text-shadow-black">
                    <span class="ne-counter pull-right ">0</span>
                </div>
            </a>				
            <a href="<?php echo $base_url; ?>messages/important-msg" class="list-group-item">
                <div class="bold xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">
                    <i class="fa fa-star-o ne_mrg_ri8_10"></i>Important
                </div>
                <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4 text-shadow-black">
                    <span class="ne-counter pull-right ">0</span>
                </div>
            </a>
            <a href="<?php echo $base_url; ?>messages/trash-msg" class="list-group-item">
                <div class="bold xxl-10 xl-10 s-10 m-10 xs-12 l-12 ne_font_14 ne_pad_tp_3px">
                    <i class="fa fa-trash-o ne_mrg_ri8_10"></i>Trash
                </div>
                <div class="xxl-6 xl-6 s-6 m-6 xs-4 l-4 text-shadow-black">
                    <span class="ne-counter pull-right ">0</span>
                </div>
            </a>
        </div>
        <div class="clearfix margin-top-10"></div>
    </div>
    <div class="margin-top-30"></div>
   <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />	
<?php
	$this->common_model->js_extra_code_fr.="
	$(document).ready(function(){
		$(".'"'."[data-toggle='tooltip']".'"'.").tooltip();
		$('#test').BootSideMenu({
			side: 'left',
			pushBody:false,
			width: '250px'
		});
	});
	
	function display_messageType(type,page_number=1)
	{
		show_comm_mask();
		var hash_tocken_id = $('#hash_tocken_id').val();
		var datastring = datastring + '".$this->security->get_csrf_token_name()."='+hash_tocken_id;
		$.ajax({
			url : '".$base_url."my-message/display_messsageType',
			type: 'post',
			data: {'".$this->security->get_csrf_token_name()."':hash_tocken_id,'message_type':type,'page_number':page_number},
			success: function(data)
			{
				$('#main_content_ajax').html(data);
				$('#hash_tocken_id').val($('#hash_tocken_id_temp').val());
				$('#hash_tocken_id_temp').remove();
				//scroll_to_div('success_message');
				hide_comm_mask();
			}
		});
	}
	";
?>