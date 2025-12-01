function openModal()
{
  document.getElementById('myModal_new').style.display = 'block';
  document.getElementById('a3').style.display = 'none';
  document.getElementById('photo1_id').style.display = 'none';
}
function closeModal()
{
  document.getElementById('myModal_new').style.display = 'none';
  document.getElementById('a3').style.display = 'block';
  document.getElementById('photo1_id').style.display = 'block';
}

var slideIndex = 1;
//showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName('mySlides');
  //var dots = document.getElementsByClassName('demo');
  var captionText = document.getElementById('caption');
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
	  slides[i].style.display = 'none';
  }
 // for (i = 0; i < dots.length; i++) {
//	  dots[i].className = dots[i].className.replace(' active', '');
 // }
  slides[slideIndex-1].style.display = 'block';
  //dots[slideIndex-1].className += ' active';
 // captionText.innerHTML = dots[slideIndex-1].alt;
}

function addstyle(requester_id,receiver_id)
{
	if(check_popup_request_accept(receiver_id,requester_id))
	{
		document.getElementById("a1").style.display = "none";
		document.getElementById("a2").style.display = "block";
		document.getElementById("a3").style.display = "none";
		$('#requester_id').val(requester_id);
		$('#receiver_id').val(receiver_id);
		$('#user_id').val(receiver_id);
		$('#my_id').val(requester_id);
	}
	else
	{
		document.getElementById("a1").style.display = "block";
		document.getElementById("a2").style.display = "none";
		document.getElementById("a3").style.display = "none";
		$('#requester_id').val(requester_id);
		$('#receiver_id').val(receiver_id);
		$('#user_id').val(receiver_id);
		$('#my_id').val(requester_id);
	}
}
function send_password_request()
{
	var requester_id = $('#requester_id').val();
	var receiver_id = $('#receiver_id').val();
	if(requester_id == '')
	{
		alert('Please login first..');
		return false;
	}
	if(receiver_id == '')
	{
		alert('Please try again..');
		return false;
	}
	var interest_message = $('input[name=interest_message]:checked').val();
	
	if(interest_message == ''){
		alert('Please try again..');
		return false;
	}
			
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'search/send-photo-password-request';
	show_comm_mask();
		$.ajax({
			url: url,
			type: 'POST',
			data: {'csrf_new_matrimonial':hash_tocken_id,'requester_id':requester_id,'receiver_id':receiver_id,'interest_message':interest_message },
			dataType:'json',
			success: function(data)
			{
				$('#Photo_message').html(data.errmessage);
				$('#Photo_message').slideDown();
				if(data.status == 'success')
				{
					$('#Photo_message').addClass('alert alert-success');
					$('#user_id').val(receiver_id);
					$('#my_id').val(requester_id);
				}else{
					$('#Photo_message').addClass('alert alert-danger');
				}
				setTimeout(function() {
					$('#Photo_message').fadeOut('fast');
				}, 5000);
				update_tocken(data.tocken);
				hide_comm_mask();
			}
		});
	return false;
}

function remove(id)
{
	if(id==1)
	{
		document.getElementById("a1").style.display = "none";
		
		document.getElementById("a2").style.display = "block";
	}
	else if(id==2)
	{
		document.getElementById("a1").style.display = "block";
		document.getElementById("a2").style.display = "none";
	}
}
function check_popup_request_accept(member_id,my_id)
{

	if(my_id == '')
	{
		alert('Please login first..');
		return false;
	}
	//alert(user_id);
	show_comm_mask();
    var hash_tocken_id = $("#hash_tocken_id").val();
	
    var base_url = $("#base_url").val();
    var url = base_url+"search/check_photo_request";
	
	$("#message_succ").hide();
	$("#message_err").hide();
	
    $.ajax({
       url: url,
       type: "post",
       data: {'csrf_new_matrimonial':hash_tocken_id,'is_post':0,'member_id':member_id,'my_id':my_id },
       dataType:"json",
       success:function(data)
       {
            if(data.status == 'success')
            {
				$("#message_succ").html(data.errmessage);
                $("#message_succ").slideDown();
				setTimeout(function()
				{
					$('#message_succ').fadeOut('fast');
				}, 1000);
				
				//$('#photo_pswd').val('');
				document.getElementById("a1").style.display = "none";
				document.getElementById("a2").style.display = "none";
				document.getElementById("a3").style.display = "block";
				$('#phtos_of_id').text(member_id);
				profile_pic(member_id);
            }
			else
			{
                $("#message_err").html(data.errmessage);
								$("#message_err").slideDown();
								//document.getElementById("a1").style.display = "none";
            }
			$("#hash_tocken_id").val(data.token);
            hide_comm_mask();
    	}
    });
    return false;
}	
// $("#password_form").validate({
// 	submitHandler: function(form) 
// 	{
// 		check_request_accept();
// 	}
// });
function check_request_accept()
{
    var photo_pswd = $("#photo_pswd").val();
	// var member_id = $("#member_id").val();
	var member_id = $('#user_id').val();
	var my_id = $('#my_id').val();

	if(my_id == '')
	{
		alert('Please login first..');
		return false;
	}
	//alert(user_id);
	show_comm_mask();
    var hash_tocken_id = $("#hash_tocken_id").val();
	
    var base_url = $("#base_url").val();
    var url = base_url+"search/check_photo_request";
	
	$("#message_succ").hide();
	$("#message_err").hide();
	
    $.ajax({
       url: url,
       type: "post",
       data: {'csrf_new_matrimonial':hash_tocken_id,'is_post':0,'member_id':member_id,'my_id':my_id },
       dataType:"json",
       success:function(data)
       {
            if(data.status == 'success')
            {
				$("#message_succ").html(data.errmessage);
                $("#message_succ").slideDown();
				setTimeout(function()
				{
					$('#message_succ').fadeOut('fast');
				}, 1000);
				
				//$('#photo_pswd').val('');
				document.getElementById("a1").style.display = "none";
				document.getElementById("a2").style.display = "none";
				document.getElementById("a3").style.display = "block";
				$('#phtos_of_id').text(member_id);
				profile_pic(member_id);
            }
			else
			{
                $("#message_err").html(data.errmessage);
								$("#message_err").slideDown();
								//document.getElementById("a1").style.display = "none";
            }
			$("#hash_tocken_id").val(data.token);
            hide_comm_mask();
    	}
    });
    return false;
}
function check_validation()
{
    var photo_pswd = $("#photo_pswd").val();
	// var member_id = $("#member_id").val();
	var member_id = $('#user_id').val();
	var my_id = $('#my_id').val();

	if(my_id == '')
	{
		alert('Please login first..');
		return false;
	}
	//alert(user_id);
	show_comm_mask();
    var hash_tocken_id = $("#hash_tocken_id").val();
	
    var base_url = $("#base_url").val();
    var url = base_url+"search/check_photo_password";
	
	$("#message_succ").hide();
	$("#message_err").hide();
	
    $.ajax({
       url: url,
       type: "post",
       data: {'photo_pswd':photo_pswd,'csrf_new_matrimonial':hash_tocken_id,'is_post':0,'member_id':member_id },
       dataType:"json",
       success:function(data)
       {
            if(data.status == 'success')
            {
				$("#message_succ").html(data.errmessage);
                $("#message_succ").slideDown();
				setTimeout(function()
				{
					$('#message_succ').fadeOut('fast');
				}, 1000);
				
				$('#photo_pswd').val('');
				document.getElementById("a2").style.display = "none";
				document.getElementById("a3").style.display = "block";
				$('#phtos_of_id').text(member_id);
				profile_pic(member_id);
            }
			else
			{
                $("#message_err").html(data.errmessage);
                $("#message_err").slideDown();
            }
			$("#hash_tocken_id").val(data.token);
            hide_comm_mask();
    	}
    });
    return false;
}
function profile_pic(member_id)
{
	var hash_tocken_id = $("#hash_tocken_id").val();
	var base_url = $("#base_url").val();
	var url = base_url+"search/view_photos";

	$.ajax({
		url: url,
		type: "post",
		data: {'csrf_new_matrimonial':hash_tocken_id,'member_id':member_id},
		dataType:"json",
		success:function(data)
		{
		   $('#content').html(data.content);
		   $('#slider').html(data.slider);
		   showSlides(1);
		}
	});
	return false;
}