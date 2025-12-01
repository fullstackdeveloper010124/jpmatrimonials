<?php $inbox = 0;
$sent = 0;
$draft = 0;
$trash = 0;
$message_count = $this->message_model->get_message_count();
if(isset($message_count['inbox']) && $message_count['inbox'] !=''){
    $inbox = $message_count['inbox'];
}
if(isset($message_count['sent']) && $message_count['sent'] !=''){
    $sent = $message_count['sent'];
}
if(isset($message_count['draft']) && $message_count['draft'] !=''){
    $draft = $message_count['draft'];
}
if(isset($message_count['trash']) && $message_count['trash'] !=''){
    $trash = $message_count['trash'];
}
$active = 'Poppins-Semi-Bold color-d';
$not_active = 'Poppins-Medium color-38';
?>
<div class="col-md-3 col-sm-12 col-xs-12 pr-0 hidden-lg hidden-md mt-4 padding-zero">
    <button class="btn btn-lg btn-primary-k b-m-mobile" data-toggle="collapse" data-target="#demo"> <i class="fas fa-envelope  fr-slider-mobile pull-left"></i> Message <i class="fas fa-chevron-down pull-right"></i></button>
    <div id="demo" class="collapse">
        <div class="col-3-main">
            <div class="list-group">
                <!--<a class="list-group-item google-plus" href="#compose-new-msg" data-toggle="modal">-->
                <a data-toggle="modal" onclick="compose_new()" href="javascript:void(0)" class="list-group-item google-plus">
                    <p class="Poppins-Semi-Bold f-17 color-d dashbrd_1">
                        <i class="fas fa-plus dashbrd_user_icon"></i> Compose New
                    </p>
                </a>
                <a class="list-group-item visitor" href="javascript:void(0);" onClick="message_system_st('inbox')">
                    <p class="<?php if($message_type == 'inbox'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_3">
                        Inbox
                    </p>
                    <span class="<?php if($message_type == 'inbox'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_4"><?php echo $inbox; ?></span>
                </a>
                <a class="list-group-item visitor" href="javascript:void(0);" onClick="message_system_st('sent')">
                    <p class="<?php if($message_type == 'sent'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_3">
                        Sent
                    </p>
                    <span class="<?php if($message_type == 'sent'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_4"><?php echo $sent; ?></span>
                </a>
                <a class="list-group-item visitor" href="javascript:void(0);" onClick="message_system_st('draft')">
                    <p class="<?php if($message_type == 'draft'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_3">
                        Draft
                    </p>
                    <span class="<?php if($message_type == 'draft'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_4"><?php echo $draft; ?></span>
                </a>
                <a class="list-group-item visitor" href="javascript:void(0);" onClick="message_system_st('trash')">
                    <p class="<?php if($message_type == 'trash'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_3">
                        Trash
                    </p>
                    <span class="<?php if($message_type == 'trash'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_4"><?php echo $trash; ?></span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="col-md-3 col-sm-3 col-xs-12 pr-0 hidden-sm hidden-xs">
    <div class="col-3-main">
        <div class="list-group">
            <a class="list-group-item google-plus" onclick="compose_new()" href="javascript:void(0)" data-toggle="modal">
                <p class="Poppins-Semi-Bold f-17 color-d dashbrd_1">
                    <i class="fas fa-plus dashbrd_user_icon"></i> Compose New
                </p>
            </a>
            <a class="list-group-item visitor" href="javascript:void(0);" onClick="message_system_st('inbox')">
                <p class="<?php if($message_type == 'inbox'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_3">
                    Inbox
                </p>
                <span class="<?php if($message_type == 'inbox'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_4"><?php echo $inbox; ?></span>
            </a>
            <a class="list-group-item visitor" href="javascript:void(0);" onClick="message_system_st('sent')">
                <p class="<?php if($message_type == 'sent'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_3">
                    Sent
                </p>
                <span class="<?php if($message_type == 'sent'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_4"><?php echo $sent; ?></span>
            </a>
            <a class="list-group-item visitor" href="javascript:void(0);" onClick="message_system_st('draft')">
                <p class="<?php if($message_type == 'draft'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_3">
                    Draft
                </p>
                <span class="<?php if($message_type == 'draft'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_4"><?php echo $draft; ?></span>
            </a>
            <a class="list-group-item visitor" href="javascript:void(0);" onClick="message_system_st('trash')">
                <p class="<?php if($message_type == 'trash'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_3">
                    Trash
                </p>
                <span class="<?php if($message_type == 'trash'){echo $active;}else{ echo $not_active;}?> f-16 dashbrd_4"><?php echo $trash; ?></span>
            </a>
        </div>
    </div>
</div>