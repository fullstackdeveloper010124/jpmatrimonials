(function(factory){
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else {
        factory(jQuery);
    }
}(function($){
        
function BoxLayout(obj){
        this.x = obj.offset().left;
        this.y = obj.offset().top;
        this.width = obj.width(); 
        this.height = obj.height();
        this.left = obj.position().left;
        this.top = obj.position().top;
    }
    var vmousedown = "mousedown",
        vmousemove = "mousemove", 
        vmouseup = "mouseup";
    if("ontouchend" in document){
        vmousedown = "touchstart";
        vmousemove = "touchmove";
        vmouseup = "touchend";
    }  
	
    $.CanvasCrop = function(options){
        var opts = $.extend({},
		{
                limitOver: 1,
                isMoveOver: true
            },options),
            el = $(options.cropBox)||$(".cropBox"),
            rot = 0,
            ratio = 1,
            innerRatio = 1,
            warpBox = new BoxLayout(el),
            thumb = options.thumbBox? $(options.thumbBox) : el.find(".thumbBox"),
            thumbBox = new BoxLayout(thumb),
            ImgSrc = options.imgSrc,
            img = new Image(),
            drawArgument = {},
            clipArgument = {
                dx : thumbBox.x - warpBox.x,
                dy : thumbBox.y - warpBox.y,
            },
            visbleCanvas,visbleContext,
            visbleCanvasBox = {
                left: 0,
                top: 0
            },
            CanvasCropInit = function(){
                if(ImgSrc){
                    canvasInit();
                    img.src = ImgSrc;
                    //thumbBoxInit();
                    
                    el.off(".CropDown").on(vmousedown+".CropDown",backgroudMove);
                }else{
                    throw "image src is not defined";
                }
                
            },
            canvasInit = function(){
                img.onload = function(){
                    visbleCanvas = document.createElement("canvas");
                    limitOver();
                    getScale();
                    visbleCanvas.id="visbleCanvas";
                    visbleCanvas.style.position = "absolute";
                    visbleContext = visbleCanvas.getContext("2d");
                    drawImage();
                    setPosition({x:(warpBox.width-visbleCanvas.width)/2,y:(warpBox.height-visbleCanvas.height)/2});
                    el.find("#visbleCanvas").remove();
                    el.prepend(visbleCanvas);
                    img.onload = img.onerror = null;
                }
                img.onerror = function(){
                    //alert("An error ocurred");
                }
            },
            limitOver = function(){
                var w = img.width,
                    h = img.height,
                    imgRatio = w/h;
                if(imgRatio<1){
                    if(opts.limitOver == 1){
                        h = warpBox.height;
                    }else if(opts.limitOver == 2){
                        w = thumbBox.width;
                        h = w/imgRatio;
                    }
                }else{
                    if(opts.limitOver == 1){
                        w = warpBox.width;
                        h = w/imgRatio;
                    }else if(opts.limitOver == 2){
                        h = thumbBox.height;
                    }
                }
                innerRatio = h/img.height;
            },
            thumbBoxInit = function(){
                var thumb = el.find(".thumbBox");
                var pointList = "<div class='cropPoint' style='left:-4px;top:-4px;' id='leftTopPoint'></div>"+
                                "<div class='cropPoint' style='right:-4px;top:-4px;' id='rightTopPoint'></div>"+
                                "<div class='cropPoint' style='left:-4px;bottom:-4px;' id='leftBottomPoint'></div>"+
                                "<div class='cropPoint' style='right:-4px;bottom:-4px;' id='rightBottomPoint'></div>";                
								thumb.append(pointList);
            },
            backgroudMove = function(e){
                e.preventDefault();
                if(!visbleCanvas){
                    return false;
                }
                var oldBox = new BoxLayout($(visbleCanvas)),
                    pagesite =  getPagePos(e),
                    oldPointer = {
                        x: pagesite.pageX,
                        y: pagesite.pageY
                    };
                this.onselectstart = function(){
                    return false;
                }
                $(document).on(vmousemove+".CropMove",function(e){
                    e.preventDefault();
                    var pagesite =  getPagePos(e),
                        disX = pagesite.pageX - oldPointer.x,
                        disY = pagesite.pageY - oldPointer.y;
                        imgDis = {
                            x: oldBox.left + disX,
                            y: oldBox.top + disY
                        };
                    setPosition(imgDis);

                });
                $(document).on(vmouseup+".CropLeave",function(e){
                    e.preventDefault();
                    $(document).off(".CropMove").off(".CropLeave");
                });
            },
            getPagePos = function(evt){
                return {
                    pageX : hasTouch()? evt.originalEvent.touches[0].pageX : evt.pageX,
                    pageY : hasTouch()? evt.originalEvent.touches[0].pageY : evt.pageY
                }
            }
            innerRotate = function(){
                var w = visbleCanvas.width,
                    h = visbleCanvas.height,
                    rotation = Math.PI * rot / 180,
                    c = Math.round(Math.cos(rotation) * 1000) / 1000,
                    s = Math.round(Math.sin(rotation) * 1000) / 1000;
                visbleCanvas.height = Math.abs(c*h) + Math.abs(s*w);
                visbleCanvas.width = Math.abs(c*w) + Math.abs(s*h);
                if (rotation <= Math.PI/2) {
                    visbleContext.translate(s*h,0);
                } else if (rotation <= Math.PI) {
                    visbleContext.translate(visbleCanvas.width,-c*h);
                } else if (rotation <= 1.5*Math.PI) {
                    visbleContext.translate(-c*w,visbleCanvas.height);
                } else {
                    visbleContext.translate(0,-s*w);
                }
                visbleContext.rotate(rotation);
                
            },
            hasTouch = function(){
                return "ontouchend" in document;
            }
            getScale = function(){
                drawArgument.w = visbleCanvas.width = img.width*innerRatio*ratio;
                drawArgument.h = visbleCanvas.height = img.height*innerRatio*ratio;
            },
            drawImage = function(){
                visbleContext.clearRect(0,0,visbleCanvas.width,visbleCanvas.height);
                visbleContext.drawImage(img, 0, 0, drawArgument.w, drawArgument.h);
            },
            getPosition = function(oldWidth,oldHeight){
                return {
                    x: visbleCanvasBox.left + (oldWidth-visbleCanvas.width)/2,
                    y: visbleCanvasBox.top + (oldHeight-visbleCanvas.height)/2
                }
            },
            setPosition = function(imgDis){
                var thumbBoxPos = {
                    left: thumbBox.x-warpBox.x,
                    top: thumbBox.y-warpBox.y,
                    right: thumbBox.x-warpBox.x + thumbBox.width,
                    bottom: thumbBox.y-warpBox.y + thumbBox.height
                }
                if(opts.isMoveOver){
                    if(thumbBoxPos.left-imgDis.x<0){
                        imgDis.x = thumbBoxPos.left;
                    }else if(thumbBoxPos.right > imgDis.x + visbleCanvas.width){
                        imgDis.x = thumbBoxPos.right - visbleCanvas.width;
                    }
                    if(thumbBoxPos.top-imgDis.y<0){
                        imgDis.y = thumbBoxPos.top;
                    }else if(thumbBoxPos.bottom > imgDis.y + visbleCanvas.height){
                        imgDis.y = thumbBoxPos.bottom - visbleCanvas.height;
                    }
                }

                $(visbleCanvas).css({
                    left: imgDis.x,
                    top: imgDis.y
                });
                visbleCanvasBox = { 
                    left: imgDis.x,
                    top: imgDis.y
                };
                clipArgument = {
                    dx: imgDis.x - thumbBoxPos.left,
                    dy: imgDis.y - thumbBoxPos.top
                };                  
            },
            canvasTransform = function(options){
                if(!visbleCanvas){
                    return false;
                }
                var oldWidth = visbleCanvas.width,
                    oldHeight = visbleCanvas.height;
                
                ratio = typeof options.ratio === "undefined"? ratio : options.ratio;
                rot = typeof options.rot === "undefined"? rot : options.rot;
                
                visbleContext.save();
                getScale(); 
                innerRotate();
                drawImage();
                visbleContext.restore();                
                var pos = getPosition(oldWidth,oldHeight);
                setPosition(pos);
            };
	        var returnObj = {
            rotate : function(deg){
                canvasTransform({
                    rot: deg
                });
            },
            scale: function(ratio){
                canvasTransform({
                    ratio: ratio
                });
            },
            getDataURL: function(type){
                var type = type||"png",
                    width = thumbBox.width,
                    height = thumbBox.height,
                    hiddenCanvas = document.createElement("canvas"),
                    hiddenContext = hiddenCanvas.getContext("2d");
                
                hiddenCanvas.width = width;
                hiddenCanvas.height = height;
                //hiddenContext.drawImage(visbleCanvas, clipArgument.sx, clipArgument.sy, width, height, 0, 0, width, height);
                hiddenContext.drawImage(visbleCanvas, clipArgument.dx, clipArgument.dy, visbleCanvas.width,visbleCanvas.height);
                return hiddenCanvas.toDataURL('image/'+type);
            }
        }
        CanvasCropInit();
        return returnObj;
    }
}));

var _URL = window.URL || window.webkitURL;
$(function(){
	var rot = 0,ratio = 1;
	var CanvasCrop = $.CanvasCrop({
		cropBox : ".imageBox",
		imgSrc : "images/avatar.jpg",
		limitOver : 0
	});
	var _URL = window.URL || window.webkitURL;
	$('#upload_file').on('change', function(e){
		$("#croped_img").html(" ");
		$("#croped_base64").val("");
		var file, img;
		var img_error = 0;
		var temp_this = this;
		if ((file = this.files[0]))
		{
			img = new Image();
			img.onload = function()
			{
				var reader = new FileReader();
				var size = temp_this.files[0].size;
				var name = temp_this.files[0].name;
				var siez_mb = size/(1024*1024);
				if(siez_mb > 3.1)
				{
					alert("Please Upload max file upload upto 3MB");
					cancel_photo();					
					return false;
				}
				reader.onload = function(e) {
					CanvasCrop = $.CanvasCrop({
						cropBox : ".imageBox",
						imgSrc : e.target.result,
						limitOver : 0
					});
					$("#orig_base64").val(e.target.result);
					rot =0 ;
					ratio = 1;
				}
				
				reader.readAsDataURL(temp_this.files[0]);
				//this.files = [];
				$('#upload_btn').show();
				$(".show_btn").show();
				$(".imageBox").show();
				$("#croped_base64").val('');
				$('#response_message').html('');
			};
			img.onerror = function()
			{
				img_error = 1;
				alert( "Please upload Valid image file only allow.");
				cancel_photo();
				return false;
			};
			img.src = _URL.createObjectURL(file);
		}
	});

	$('#profil_photo').on('change', function(e){
		$("#croped_img").html(" ");
		$("#croped_base64").val("");
		var file, img;
		var img_error = 0;
		var temp_this = this;
		if ((file = this.files[0]))
		{
			img = new Image();
			img.onload = function()
			{
				var reader = new FileReader();
				var size = temp_this.files[0].size;
				var name = temp_this.files[0].name;
				var siez_mb = size/(1024*1024);
				if(siez_mb > 3.1)
				{
					alert("Please Upload max file upload upto 3MB");
					cancel_photo();					
					return false;
				}
				reader.onload = function(e) {
					CanvasCrop = $.CanvasCrop({
						cropBox : ".imageBox",
						imgSrc : e.target.result,
						limitOver : 0
					});
					$("#orig_base64").val(e.target.result);
					rot =0 ;
					ratio = 1;
				}
				
				reader.readAsDataURL(temp_this.files[0]);
				//this.files = [];
				$('#upload_btn').show();
				$(".show_btn").show();
				$(".imageBox").show();
				$("#croped_base64").val('');
				$('#response_message').html('');
			};
			img.onerror = function()
			{
				img_error = 1;
				alert( "Please upload Valid image file only allow.");
				cancel_photo();
				return false;
			};
			img.src = _URL.createObjectURL(file);
		}
	});
	
	$("#rotateLeft").on("click",function(){
		rot -= 90;
		rot = rot<0?270:rot;
		CanvasCrop.rotate(rot);
	});
	$("#rotateRight").on("click",function(){
		rot += 90;
		rot = rot>360?90:rot;
		CanvasCrop.rotate(rot);
	});
	$("#zoomIn").on("click",function(){
		
		var img = document.getElementById('visbleCanvas'); 
		var width = img.clientWidth;
		var height = img.clientHeight;
		//alert(height+'***'+width);
		if(width > 300 && height > 350){
			ratio =ratio*0.9;
			CanvasCrop.scale(ratio);
		}
	});
	$("#zoomOut").on("click",function(){
		ratio =ratio*1.1;
		CanvasCrop.scale(ratio);
	});
	$("#alertInfo").on("click",function(){
		var canvas = document.getElementById("visbleCanvas");
		var context = canvas.getContext("2d");
		context.clearRect(0,0,canvas.width,canvas.height);
	});
	
	$("#crop").on("click",function(){
		var src = CanvasCrop.getDataURL("png");
		//alert(src);
		//$("body").append("<div style='word-break: break-all;'>"+src+"</div>");		
		// $("#croped_img").html("<img src='"+src+"' />");
		$("#croped_base64").val(src);
		update_photo();
	});

	$("#crop_register").on("click",function(){
		var src = CanvasCrop.getDataURL("png");
		//alert(src);
		//$("body").append("<div style='word-break: break-all;'>"+src+"</div>");		
		// $("#croped_img").html("<img src='"+src+"' />");
		$("#croped_base64").val(src);
		update_photo1();
		if(src){
			setTimeout(function() {
				$("#response_message").addClass('alert alert-success');
				$('#response_message').html('');
			}, 5000);
			// $("#response_message").addClass('alert alert-success');
			$("#myModal_pic .close").click()
		}
	});
	console.log("ontouchend" in document);
})

function update_photo()
{
	var croped_base64 = $("#croped_base64").val();
	var orig_base64 = $("#orig_base64").val();

	if(croped_base64 =='' || orig_base64 =='')
	{
		alert("Please select image and crop first");
		return false;
	}
	//$('#response_message').removeClass('alert alert-success alert-danger alert-warning');
	$('#response_message').html('');
	var base_url = $("#base_url").val();
	var photo_number = $("#photo_number").val();
	//var profi_phot = 'profile_photo'+photo_number+'_crop';
	//var profi_org = 'profile_photo'+photo_number+'_org';
	var url_load = base_url+ 'modify_photo/upload_photo_new';
	var hash_tocken_id = $("#hash_tocken_id").val();
	//var orig_base64 = $("#orig_base64").val();
	
	var fd = new FormData();
	
	var block = croped_base64.split(";");
	var contentType = block[0].split(":")[1];// In this case "image/gif"
	// get the real base64 content of the file
  	var realData = block[1].split(",")[1];// In this case "iVBORw0KGg...."
	// Convert to blob
  	var blob1= b64toBlob(realData, contentType);
	// for gennerate image from base64
	file_name = 'cropped_image.png';
	img_file_name = 'profile_photo'+photo_number+'_crop';
	
	fd.append(img_file_name, blob1,file_name);
	
	
	var block = orig_base64.split(";");
	var contentType = block[0].split(":")[1];// In this case "image/gif"
	// get the real base64 content of the file
  	var realData = block[1].split(",")[1];// In this case "iVBORw0KGg...."
	// Convert to blob
  	var blob1= b64toBlob(realData, contentType);
	// for gennerate image from base64
	file_name = 'original_image.png';
	img_file_name = 'profile_photo'+photo_number+'_org';
	
	fd.append(img_file_name, blob1,file_name);	
	
	
	fd.append("csrf_new_matrimonial", hash_tocken_id);
	fd.append("is_ajax", "1");
	fd.append("photo_number", photo_number);
	
	show_comm_mask();
		$.ajax({
		   url: url_load,
		   type: "post",
		   dataType:"json",
		   data: fd,
		   contentType:false,
		   processData:false,
		   cache:false,
		   success:function(data)
		   {
			    $("#response_message").html(data.errmessage);
				$("#response_message").slideDown();
				if(data.status =='success')
				{
					if(croped_base64 !='')
					{
						$("#member_photo_"+photo_number).attr('src',croped_base64);
					}
					$(".show_btn").hide();
					$(".imageBox").hide();
					$("#upload_btn").hide();
					$("#croped_img").html("");
					$("#response_message").addClass('alert alert-success');
					$("#photo_delete_btn_"+photo_number).show();
					$("#photo_profile_btn_"+photo_number).show();
				}
				else
				{
					$("#response_message").addClass('alert alert-danger');
				}
				setTimeout(function() {
                    $('#response_message').removeClass('alert alert-success alert alert-danger');
                    $('#response_message').html('');
				}, 5000);
				update_tocken(data.tocken);
				hide_comm_mask();
		   }
		});
}

function update_photo1()
{
	var croped_base64 = $("#croped_base64").val();
	var orig_base64 = $("#orig_base64").val();

	if(croped_base64 =='' || orig_base64 =='')
	{
		alert("Please select image and crop first");
		return false;
	}
	//$('#response_message').removeClass('alert alert-success alert-danger alert-warning');
	$('#response_message').html('');
	var base_url = $("#base_url").val();
	var photo_number = $("#photo_number").val();
	//var profi_phot = 'profile_photo'+photo_number+'_crop';
	//var profi_org = 'profile_photo'+photo_number+'_org';
	//var url_load = base_url+ 'modify_photo/upload_photo_new';
	var url_load = base_url+ 'register/save-register-step/step5';
	
	var hash_tocken_id = $("#hash_tocken_id").val();
	//var orig_base64 = $("#orig_base64").val();
	
	var fd = new FormData();
	
	var block = croped_base64.split(";");
	var contentType = block[0].split(":")[1];// In this case "image/gif"
	// get the real base64 content of the file
  	var realData = block[1].split(",")[1];// In this case "iVBORw0KGg...."
	// Convert to blob
  	var blob1= b64toBlob(realData, contentType);
	// for gennerate image from base64
	file_name = 'cropped_image.png';
	img_file_name = 'profil_photo';
	
	fd.append(img_file_name, blob1,file_name);
	
	var block = orig_base64.split(";");
	var contentType = block[0].split(":")[1];// In this case "image/gif"
	// get the real base64 content of the file
  	var realData = block[1].split(",")[1];// In this case "iVBORw0KGg...."
	// Convert to blob
  	var blob1= b64toBlob(realData, contentType);
	// for gennerate image from base64
	file_name = 'original_image.png';
	img_file_name = 'profile_photo_org';
	
	fd.append(img_file_name, blob1,file_name);	
	
	
	fd.append("csrf_new_matrimonial", hash_tocken_id);
	fd.append("is_ajax", "1");
	fd.append("photo_number", photo_number);
	
	show_comm_mask();
		$.ajax({
		   url: url_load,
		   type: "post",
		   dataType:"json",
		   data: fd,
		   contentType:false,
		   processData:false,
		   cache:false,
		   success:function(data)
		   {
			    $("#response_message").html(data.errmessage);
				$("#response_message").slideDown();
				if(data.status =='success')
				{
					if(croped_base64 !='')
					{
						$("#blah").attr('src',croped_base64);
						$(".blah2").text('');
					}
					$(".show_btn").hide();
					$(".imageBox").hide();
					$("#upload_btn").hide();
					$("#croped_img").html("");
					$("#response_message").addClass('alert alert-success');
					$("#photo_delete_btn_"+photo_number).show();
					$("#photo_profile_btn_"+photo_number).show();
				}
				else
				{
					$("#response_message").addClass('alert alert-danger');
				}
				setTimeout(function() {
                    $('#response_message').removeClass('alert alert-success alert alert-danger');
                    $('#response_message').html('');
				}, 5000);
				update_tocken(data.tocken);
				hide_comm_mask();
		   }
		});
}

function set_photo_number(num)
{
	$('#photo_number').val(num);
	$('#upload_file').val('');
	$('#response_message').removeClass('alert alert-success alert-danger alert-warning');
	$('#response_message').html('');
	$(".show_btn").hide();
	$(".imageBox").hide();
	$("#croped_img").html("");
}
function set_photo_number_del(num)
{
	$('#photo_number').val(num);
	$("#delete_photo_alt").show();
	$("#delete_photo_message").hide();
	$("#delete_photo_message").html('');
	$("#delete_button").show();
	$("#delete_button_close").hide();
}
function delete_photo()
{
	$('#delete_photo_message').removeClass('alert alert-success alert-danger alert-warning');
	$('#delete_photo_message').html('');
	var photo_number = $('#photo_number').val();
	if(photo_number =='')
	{
		alert("Please try again");
		return false;
	}
	var base_url = $("#base_url").val();
	var url_load = base_url+ 'modify_photo/delete_photo';
	var hash_tocken_id = $("#hash_tocken_id").val();
	show_comm_mask();
	$.ajax({
	   url: url_load,
	   type: "post",
	   dataType:"json",
	   data: {'csrf_new_matrimonial':hash_tocken_id,'is_ajax':1,'photo_number':photo_number,'delete_photo':'delete'},
	   success:function(data)
	   {
			$("#delete_photo_message").html(data.errmessage);
			$("#delete_photo_message").slideDown();
			if(data.status =='success')
			{
				$("#delete_photo_message").addClass('alert alert-success');
				$("#member_photo_"+photo_number).attr('src',$("#defult_photo_url").val());
				$("#delete_photo_alt").hide();
				$("#delete_button_close").show();
				$("#delete_button").hide();
				$("#photo_delete_btn_"+photo_number).hide();
				$("#photo_profile_btn_"+photo_number).hide();
			}
			else
			{
				$("#delete_photo_message").addClass('alert alert-danger');
			}
			update_tocken(data.tocken);
			hide_comm_mask();
	   }
	});
}
function update_photo_status()
{
	var view_photo = $('#view_photo').val();
	if(view_photo =='')
	{
		alert("Please try again");
		return false;
	}
	var base_url = $("#base_url").val();
	var url_load = base_url+ 'modify_photo/update_photo_view_status';
	var hash_tocken_id = $("#hash_tocken_id").val();
	show_comm_mask();
	$.ajax({
	   url: url_load,
	   type: "post",
	   dataType:"json",
	   data: {'csrf_new_matrimonial':hash_tocken_id,'is_ajax':1,'photo_status':view_photo},
	   success:function(data)
	   {
		   	hide_comm_mask();
		   	alert(data.errmessage);
			update_tocken(data.tocken);
	   }
	});
}
function set_profile_pic(photo_number)
{
	if(photo_number =='')
	{
		alert("Please try again");
		return false;
	}
	var base_url = $("#base_url").val();
	var url_load = base_url+ 'modify_photo/set_profile_pic';
	var hash_tocken_id = $("#hash_tocken_id").val();
	show_comm_mask();
	$.ajax({
	   url: url_load,
	   type: "post",
	   dataType:"json",
	   data: {'csrf_new_matrimonial':hash_tocken_id,'is_ajax':1,'photo_number':photo_number,'set_profile':'set_profile'},
	   success:function(data)
	   {
		   	hide_comm_mask();
		   	alert(data.errmessage);
			update_tocken(data.tocken);
			if(data.status =='success')
			{
				var photo_1src = $("#member_photo_1").attr('src');
				var photo_2src = $("#member_photo_"+photo_number).attr('src');
				$("#member_photo_"+photo_number).attr('src',photo_1src);
				$("#member_photo_1").attr('src',photo_2src);
			}
	   }
	});
}

function b64toBlob(b64Data, contentType, sliceSize)
{
	contentType = contentType || '';
	sliceSize = sliceSize || 512;
	
	var byteCharacters = atob(b64Data);
	var byteArrays = [];
	
	for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
		var slice = byteCharacters.slice(offset, offset + sliceSize);
	
		var byteNumbers = new Array(slice.length);
		for (var i = 0; i < slice.length; i++) {
			byteNumbers[i] = slice.charCodeAt(i);
		}
	
		var byteArray = new Uint8Array(byteNumbers);
	
		byteArrays.push(byteArray);
	}
	var blob = new Blob(byteArrays, {type: contentType});
	return blob;
}
