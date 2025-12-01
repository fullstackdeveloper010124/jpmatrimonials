var base_url = $('#base_url').val();
var get_member_list_url = base_url+'custom_chat/get_online_users';
var create_conversation = base_url+'custom_chat/create_conversation';
var get_conversation_message = base_url+'custom_chat/getConversationMessage';
var android_app_link = $('#android_app_link').val();
var is_mobile = false;

$(document).ready(function(){
    setTimeout(function (event) {
        // $( "#boxopen" ).trigger( "click" );
    }, 10);
    setTimeout(function (event) {
        // console.clear();
    }, 4000);
    getOnlineUsers();

    setTimeout(function (event) {
        is_mobile = checkIsMobile(); 
        if(is_mobile == true){
            changeChatLink();
        }
    }, 2000);
    
    // Search Online User :
    var timer;
    $('#custom_chat_search').keyup(function () {
        clearTimeout(timer);
        timer = setTimeout(function (event) {
            $('#custom_chat_online_user').html('');
            $('#custom_chat_online_user').text('Searching users...');
            $('#custom_chat_match_user').html('');
            $('#custom_chat_match_user').text('Searching users...');
            getOnlineUsers();
        }, 2000);
    });
    
    // Chat List Min : 
    $(".toggler-minmz").click(function() {
        $(this).toggleClass("rot");
        $('.chat-sidebar').toggleClass('chat-sidebar-min');
        $('.chat-sidebar').find('.chat-header').toggleClass('chat-header-margin');
        $('body').find('.container').toggleClass('container-minimizer');
    });

    $('#conversation_chat_box').on('click','.fa-minus',function(){
        $(this).closest('.chatbox').toggleClass('chatbox-min');
    });
    $('.fa-times').click(function() {
        $(this).closest('.chatbox').hide();
    });

    // Create Conversation : Date : 16-11-2021
    $('#member-chat-list').on('click','.createConversation',function(){
        var formData = new FormData();
        var conversation_id = $(this).attr('data-conversation_id');
        // Check Only 3 Chat box open at a time : 
        if($('#conversation_chat_box').find('.chatbox').length >= 3){
            alert("You can't chat with more then 3 users at a time.Please close chat one of them.");
            return false;
        }
        if($('#conversation-chatbox-'+conversation_id).length == 0 && $(this).attr('data-is_chat') == 'Yes'){
            formData.append('member1_id',$(this).attr('data-current_member_id'));
            formData.append('member1_matri_id',$(this).attr('data-current_member_matri_id'));
            formData.append('member2_id',$(this).attr('data-member_id'));
            formData.append('member2_matri_id',$(this).attr('data-matri_id'));
            formData.append('conversation_id',conversation_id);
            formData.append('csrf_new_matrimonial',$("#hash_tocken_id").val());
            var url = create_conversation;
            ajaxRequest($(this),formData,url,'createConversationResponse');
        }else{
            $('#conversation-chatbox-'+conversation_id).find('.chat-input').focus();
        }
    });

    // Send Message : Date : 16-11-2021
    $('#conversation_chat_box').on('click','.message-send',function(){
        var conversation_id = $(this).attr('data-conversation_id');
        if($('#chat-member-block'+conversation_id).val() == 0){
            if($('#conversation-message'+conversation_id).val() != ''){
                var formData = new FormData($('#sendMessageFrom'+conversation_id)[0]);
                formData.append('csrf_new_matrimonial',$("#hash_tocken_id").val());
                var url = $('#sendMessageFrom'+conversation_id).attr('action');
                ajaxRequest('#conversation-chatbox-'+conversation_id,formData,url,'sendMessageResponse');
            }else{
                $('#conversation-message'+conversation_id).focus();
                alert('Please type message.');
            }
        }else{
            alert('You blocked this user, Please unblock to send message!');
            $('#conversation-message'+conversation_id).val('');
        }
    });

    // Remove Conversation Chat Boc : Date : 16-11-2021
    $('#conversation_chat_box').on('click','.removeChatBox',function(){
        $('#conversation-chatbox-'+$(this).data('id')).remove();
    });

    // Block Unblock Chat Member : Date : 30-06-2022
    $('#conversation_chat_box').on('click','.blockChatMember',function(){
        var formData = new FormData();
        formData.append('csrf_new_matrimonial',$("#hash_tocken_id").val());
        formData.append('conversation_id',$(this).attr('data-conversation_id'));
        formData.append('action',$(this).attr('data-action'));
        var url = base_url+'custom_chat/blockChatMember';
        ajaxRequest($(this),formData,url,'blockChatMemberResponse');
    });


});

// Get Online Users : Date : 15-11-2021
function getOnlineUsers(){
    var formData = new FormData();
    // Search Keyword : 
    if($('#custom_chat_search').val() !=''){
        formData.append('searchKeyword',$('#custom_chat_search').val());
    }
    formData.append('csrf_new_matrimonial',$("#hash_tocken_id").val());
    var url = get_member_list_url;
    ajaxRequest('#custom_chat_online_user',formData,url,'getOnlineUsersResponse');
}

// Check Is Mobile : Date : 02-03-2022
function checkIsMobile(){
// device detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
        return true;
    }
    return false;
}

// Change Chat Link : Date : 02-03-2022
function changeChatLink(){
    // Change Link For Match User : 
    $('#custom_chat_match_user').find('.createConversation').each(function(i, _this) {
        if(is_mobile == true){
            $(_this).removeClass('createConversation');
            var old_html = $(_this).html();
            $(_this).html('');
            $(_this).append('<a style="display: flex;" href="'+android_app_link+'" ></a>');
            $(_this).find('a').append(old_html);
        }else{
            $(_this).addClass('createConversation');
        }
    });
    // Change Link For Online User : 
    $('#custom_chat_online_user').find('.createConversation').each(function(i, _this) {
        if(is_mobile == true){
            $(_this).removeClass('createConversation');
            var old_html = $(_this).html();
            $(_this).html('');
            $(_this).append('<a style="display: flex;" href="'+android_app_link+'" target="_blank"></a>');
            $(_this).find('a').append(old_html);
        }else{
            $(_this).addClass('createConversation');
        }
    });
}

// Get Online Users Response : Date : 15-11-2021
function getOnlineUsersResponse(_this,response){
    if(response.status == 'success'){
        $(_this).html(response.html);
        $('#custom_chat_match_user').html(response.matchHtml);
        changeChatLink();
        $('#onlineCount').html('<span><i class="fas fa-circle"></i></span>'+response.data.online_member_count);
    }
    update_tocken(response.tocken);
}

// Create Conversation Response : Date : 16-11-2021
function createConversationResponse(_this,response){
    if(response.status == 'success'){
        $('#conversation_chat_box').append(response.html);
        var member_id = $(_this).attr('data-member_id');
        $('#match-user-list-'+member_id).attr('data-conversation_id',response.data.id);
        $('#online-user-list-'+member_id).attr('data-conversation_id',response.data.id);
        $('#match-user-list-'+member_id).find('.new-msg').remove();
        $('#match-user-list-'+member_id).find('.last-message-tag').removeClass('unread-msg-show');
        $('#online-user-list-'+member_id).find('.new-msg').remove();
        $('#online-user-list-'+member_id).find('.last-message-tag').removeClass('unread-msg-show');
        scrollDownChat('#conversation-chatbox-'+response.data.id);
    }else{
        alert(response.msg);
    }
    update_tocken(response.tocken);
}

// Send Message Response : Date : 16-11-2021
function sendMessageResponse(_this,response){
    if(response.status == 'success'){
        $(_this).find('.chat-messages').append(response.html);
        $(_this).find('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);
        $(_this).find('.chat-input').val('');

        // Replace Last Message To sidebar user list :
        var receiver_member_id = response.data.receiver_member_id;
        var new_message = response.data.message;
        if(new_message.length > 30){
            new_message = new_message.substring(0,30)+'..';
        }
        $('#online-user-list-'+receiver_member_id).find('.last-message-tag').text(new_message);
        $('#match-user-list-'+receiver_member_id).find('.last-message-tag').text(new_message);
    }else{
        alert(response.msg);
    }
    update_tocken(response.tocken);
}

// Chat Member Block Response : Date : 16-11-2021
function blockChatMemberResponse(_this,response){
    if(response.status == 'success'){
        var conversation_id = $(_this).attr('data-conversation_id');
        if(response.data.action == 1){
            $(_this).text('Unblock');
            $(_this).attr('data-action',0);
            $('#chat-member-block'+conversation_id).val(1);
        }else{
            $(_this).text('Block');
            $(_this).attr('data-action',1);
            $('#chat-member-block'+conversation_id).val(0);
        }
        alert(response.msg);
    }else{
        alert(response.msg);
    }
    update_tocken(response.tocken);
}

// get More Message Response : Date : 18-11-2021
function getMoreMessageResponse(_this,response){
    if(response.status == 'success'){
        var page = parseInt($(_this).attr('data-page'));
        $(_this).attr('data-page',page+1);
        $(_this).prepend(response.html);
    }else if(response.status == 'no_message'){
        $(_this).attr('data-is-more','0');
    }else{
        alert(response.msg);
    }
    update_tocken(response.tocken);
}

// Scroll Down Chat to last Message : 
function scrollDownChat(_this){
    if(typeof $(_this).find('.chat-messages .message-box-holder:last-child').position() !== "undefined"){
        $(_this).find('.chat-messages ').animate({
            scrollTop: $(_this).find('.chat-messages .message-box-holder:last-child').position().top
        }, 'slow');
    }
}

// Append Received Message To Chat :
function appendNewMessageReceiver(notificationData){
    if(notificationData){
        // Check Chat Box Is Opened Or Not 
        var conversation_id = notificationData.conversation_id;
        var sender_member_id = notificationData.sender_member_id;
        if($('#conversation-chatbox-'+conversation_id).length > 0){
            var chatboxHtml = '<div class="message-box-holder receiver">'+
                                '<div class="message-sender">'+
                                    '<a target="_blank" href="'+base_url+'search/view-profile/'+notificationData.sender_member_matri_id+'"><img src="'+notificationData.sender_member_photo_url+'" alt=""></a>'+
                                '</div>'+
                                '<div class="message-box message-partner">'+
                                    notificationData.message                
                                '</div>'+
                            '</div>';
            $('#conversation-chatbox-'+conversation_id).find('.chat-messages').append(chatboxHtml);
            $('#conversation-chatbox-'+conversation_id).find('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);

            // Side Bar Replace last Message : 
            var new_message = notificationData.message;
            if(new_message.length > 30){
                new_message = new_message.substring(0,30)+'..';
            }
            $('#online-user-list-'+sender_member_id).find('.last-message-tag').text(new_message);
            $('#match-user-list-'+sender_member_id).find('.last-message-tag').text(new_message);
        }else{
            var new_message = notificationData.message;
            if(new_message.length > 30){
                new_message = new_message.substring(0,30)+'..';
            }
            $('#online-user-list-'+sender_member_id).find('.last-message-tag').addClass('unread-msg-show').text(new_message);
            if($('#online-user-list-'+sender_member_id).find('.new-msg').length > 0){
                var current_count = parseInt($('#online-user-list-'+sender_member_id).find('.new-msg').text());
                var new_count = current_count + 1;
                $('#online-user-list-'+sender_member_id).find('.new-msg').remove();
            }else{
                var new_count = 1;
            }
            $('#online-user-list-'+sender_member_id).find('.user-name-chat').after('<div class="new-msg">'+new_count+'</div>');

            $('#match-user-list-'+sender_member_id).find('.last-message-tag').addClass('unread-msg-show').text(new_message);
            if($('#match-user-list-'+sender_member_id).find('.new-msg').length > 0){
                var current_count = parseInt($('#match-user-list-'+sender_member_id).find('.new-msg').text());
                var new_count = current_count + 1;
                $('#match-user-list-'+sender_member_id).find('.new-msg').remove();
            }else{
                var new_count = 1;
            }
            $('#match-user-list-'+sender_member_id).find('.user-name-chat').after('<div class="new-msg">'+new_count+'</div>');
        }
    }
}

// Common Ajax Request : Date : 15-11-2021
function ajaxRequest(element, formData, requestUrl, responseFunction='') {
    // console.log(...formData); // Form Data Console
    // $("#overlay").fadeIn(300);　
	formData.append('isPost',1);
    $.ajax({
        url: requestUrl,
        type: 'POST',
        processData: false,
        contentType: false,
        data: formData,

        success: function(data) {
			
            var response = JSON.parse(data);
			if (response.redirectUrl != '' && response.redirectUrl != undefined) {
				window.location.href = response.redirectUrl;
			}

			// Call Back Function : 
			if (responseFunction !='') {
            	window[responseFunction](element, response);
			}
			
            setTimeout(function() {
                $("#overlay").fadeOut(300);
            }, 500);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(jqXHR.status + " " + errorThrown);
            setTimeout(function() {
                $("#overlay").fadeOut(300);
            }, 500);
        }
    });
}