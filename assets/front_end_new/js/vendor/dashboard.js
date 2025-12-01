$(document).ready(function() {
    $('select').select2();
    $('.js-example-basic-single').select2();

    $('.submitRegisterbtn').click(function(e){
        var formId = $(this).attr('data-formId');
        validat_function(formId);
    });

    function validat_function(form_id) {
        if($('#register_step'+form_id).length > 0) {
          $('#register_step'+form_id).validate({
              submitHandler: function(form) {
            
                  var form_data = $('#register_step'+form_id).serialize();
                  form_data = form_data+ '&is_post=0';
                  var action = $('#register_step'+form_id).attr('action');
                   $.ajax({
                        url: action,
                        type: 'post',
                        dataType:'json',
                        data: form_data,
                        success:function(data) {
                            update_tocken(data.tocken);

                            $('html, body').animate({ scrollTop: 0 }, 'slow');

                            $('.reponse_message').removeClass('alert alert-success alert-danger alert-warning');
                            $('.reponse_message').html(data.errmessage);
                            $('.reponse_message').slideDown();

                            if(data.status == 'success') {                            
                              $('.reponse_message').addClass('alert alert-success');
                                stoptimeout();
                                starttimeout('.reponse_message');
                            } else {
                              $('.reponse_message').addClass('alert alert-danger');
                            }
                            setTimeout(function(){
                               location.reload();
                            },3000);
                        }
                    });
                    return false;
              }  
          });
        }
    }

    // let imgArray = [];
    // $('.upload__inputfile').on('change', function (e) {
    //     const maxLength = parseInt($(this).data('max_length')); // Max allowed images
    //     const maxFileSize = 2 * 1024 * 1024; // 2MB
    //     const files = Array.from(e.target.files);
    //     const imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
    //     const existingImagesCount = imgWrap.find('.upload__img-box').length || 0;

    //     files.forEach(file => {
    //         if (!file.type.match('image.*')) return;
    //         if (maxLength < existingImagesCount + 1) {
    //             alert(`You can upload a maximum of ${maxLength} images. You already have ${existingImagesCount} uploaded.`);
    //             return;
    //         }
    //         if (file.size > maxFileSize) {
    //             alert(`Image "${file.name}" is too large. Max allowed size is 2MB.`);
    //             return;
    //         }
    //         imgArray.push(file);
    //         const reader = new FileReader();
    //         reader.onload = function (event) {
    //             const img = new Image();
    //             img.onload = function () {
    //                 const width = img.width;
    //                 const height = img.height;
    //                 // Optional: Validate image dimensions (uncomment if needed)
    //                 const isValidWidth = width >= 600 && width <= 900;
    //                 const isValidHeight = height >= 300 && height <= 500;
    //                 if (!(isValidWidth && isValidHeight)) {
    //                     alert(`Image must be between 600×300 and 900×500 pixels. Current size: ${width}×${height}.`);
    //                     return;
    //                 }
    //                 const html = `
    //                     <div class="upload__img-box" data-index="${imgArray.length - 1}">
    //                         <div class="img-bg" style="background-image: url('${event.target.result}')" data-file="${file.name}">
    //                             <div class="upload__img-close"></div>
    //                         </div>
    //                     </div>`;
    //                 imgWrap.append(html);
    //             };
    //             img.src = event.target.result;
    //         };
    //         reader.readAsDataURL(file);

    //     });
    // });

    // $('body').on('click', '.upload__img-close', function () {
    //     const $imgBox = $(this).closest('.upload__img-box');
    //     const imageUrl = $(this).data('id'); 
    //     if (!confirm("Are you sure you want to delete this image?")) {
    //         return;
    //     }
    //     // if (imageUrl) {
    //     //     const url = $('.upload__img-close').data('url');
    //     //     const formData = new FormData();
    //     //     const fileName = imageUrl.split('/').pop();
    //     //     let businessId = '';
    //     //     if ($('#business_id').length > 0 && $('#business_id').val() !== '') {
    //     //         businessId = $('#business_id').val();
    //     //         formData.append('business_id', businessId);
    //     //     }
    //     //     formData.append('file_name', fileName);     
    //     //     ajaxRequest($(this),formData,url,'responseUploadPhotos');
    //     // } else {    
    //         const fileName = $(this).siblings('.img-bg').data('file');
    //         imgArray = imgArray.filter(f => f.name !== fileName);
    //         $imgBox.remove();
    //         // sendNotification('success','Image deleted successfully.');
    //     // }
    // });

    // $(".upload-photo-btn").click(function(e) {
    //      e.preventDefault();

    //     const container = $(this).closest('.wedding-photos-upload');
    //     const action = container.data('url'); // e.g., data-url="upload_photos.php"
    //     const hash_tocken_id = $("#hash_tocken_id").val();
    //     const vendor_id = $("#vendor_id").val();
    
    //     // if (!imgArray || !imgArray.length) {
    //     //     alert('Please select at least one photo to upload.');
    //     //     return;
    //     // }        
    //     const formData = new FormData();
    //     formData.append('vendor_id', vendor_id);
    //     formData.append('csrf_new_matrimonial', hash_tocken_id);

    //     imgArray.forEach((file, index) => {
    //         formData.append('photos[]', file);
    //     });
    //     // show_comm_mask();
    //     $.ajax({
    //         url: action,
    //         type: 'POST',
    //         dataType: 'json',
    //         data: formData,
    //         processData: false, 
    //         contentType: false, 
    //         success: function(data) {
    //             update_tocken(data.tocken);

    //             if (data.status === 'success') {
    
    //             } else {
                    
    //             }
    //         },
    //         error: function(xhr) {                
    //             console.log('Something went wrong.')
    //         }
    //     });

    //     return false;
    // });
        


    let imgArray = [];
    $('.upload__inputfiless').on('change', function (e) {
        const maxLength = parseInt($(this).data('max_length')); // Max allowed images
        const maxFileSize = 2 * 1024 * 1024; // 2MB
        const files = Array.from(e.target.files);
        const imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
        const existingImagesCount = imgWrap.find('.upload__img-box').length || 0;

        files.forEach(file => {
            if (!file.type.match('image.*')) return;
            if (maxLength < existingImagesCount + 1) {
                alert(`You can upload a maximum of ${maxLength} images. You already have ${existingImagesCount} uploaded.`);
                return;
            }
            if (file.size > maxFileSize) {
                alert(`Image "${file.name}" is too large. Max allowed size is 2MB.`);
                return;
            }
            imgArray.push(file);
            const reader = new FileReader();
            reader.onload = function (event) {
                const img = new Image();
                img.onload = function () {
                    const width = img.width;
                    const height = img.height;
                    
                    const isValidWidth = width >= 600 && width <= 900;
                    const isValidHeight = height >= 300 && height <= 500;
                    if (!(isValidWidth && isValidHeight)) {
                        alert(`Image must be between 600×300 and 900×500 pixels. Current size: ${width}×${height}.`);
                        return;
                    }
                    const html = `
                        <div class="upload__img-box" data-index="${imgArray.length - 1}">
                            <div class="img-bg" style="background-image: url('${event.target.result}')" data-file="${file.name}">
                                <div class="upload__img-close"></div>
                            </div>
                        </div>`;
                    imgWrap.append(html);
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);

        });
    });
    

    $('.upload__inputfile').on('change', function (e) {
        const maxLength = parseInt($(this).data('max_length')) || 4;
        const file = e.target.files[0];
        const maxFileSize = 2 * 1024 * 1024; // 2MB
        const imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
        const existingImagesCount = imgWrap.find('.upload__img-box').length;

        if (!file || !file.type.match('image.*')) return;

        if (existingImagesCount >= maxLength) {
            alert(`You can upload a maximum of ${maxLength} images.`);
            return;
        }

        if (file.size > maxFileSize) {
            alert(`"${file.name}" is too large. Max size is 2MB.`);
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            const img = new Image();
            img.onload = function () {
                const html = `
                    <div class="upload__img-box uploading" data-filename="${file.name}">
                        <div class="img-bg" style="background-image: url('${event.target.result}')">
                            <div class="upload__img-close"></div>
                        </div>
                    </div>`;
                imgWrap.append(html);

                upload_photo(file, existingImagesCount); 
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    });

$(document).on('click', '.upload__img-close', function () {
    
    const imageUrl = $(this).data('id'); 
    if (!confirm("Are you sure you want to delete this image?")) {
        return;
    }
    if(imageUrl != '' && typeof imageUrl !== 'undefined') {   
        const keyName = $(this).data('key');   
        const filename = $(this).data('filename'); 
        const vendor_id = $("#vendor_id").val();
        const token = $("#hash_tocken_id").val();
        const url = $('.upload__img-close').data('url');
        const formData = new FormData();
        formData.append('key_name', keyName);    
        formData.append('file_name', filename);    
        formData.append('vendor_id', vendor_id);    
        formData.append('csrf_new_matrimonial', token);    

        remove_photos(formData,url)
    }else{        
        $imgBox.remove();
    }
});
 
    function remove_photos(formData,url)
    {
        show_comm_mask();
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data) {
                update_tocken(data.tocken);
                hide_comm_mask();
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                $('.reponse_message').removeClass('alert alert-success alert-danger alert-warning');
                $('.reponse_message').html(data.errmessage);
                $('.reponse_message').slideDown();
                
                if(data.status == 'success') {                            
                    $('.reponse_message').addClass('alert alert-success');
                    stoptimeout();
                    starttimeout('.reponse_message');
                } else {
                    $('.reponse_message').addClass('alert alert-danger');
                }
                setTimeout(function(){
                    location.reload();
                },3000);
            },
            error: function () {
                console.log('Something went wrong !.')
            }
        });


    }

    function upload_photo(file,index) {

        const uploadUrl = $('.wedding-photos-upload').data('url');
        const formData = new FormData();
        const imageKeys = ['image', 'image_2', 'image_3', 'image_4'];
        const fieldName = imageKeys[index] || 'image';

        const hash_tocken_id = $("#hash_tocken_id").val();
        const vendor_id = $("#vendor_id").val();

        formData.append('csrf_new_matrimonial', hash_tocken_id);
        formData.append('vendor_id', vendor_id);
        formData.append('key_name', fieldName);
        formData.append(fieldName, file); // Dynamic name
        show_comm_mask();
        $.ajax({
            url: uploadUrl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data) {
                update_tocken(data.tocken);
                hide_comm_mask();
                $('html, body').animate({ scrollTop: 0 }, 'slow');
                $('.reponse_message').removeClass('alert alert-success alert-danger alert-warning');
                $('.reponse_message').html(data.errmessage);
                $('.reponse_message').slideDown();
                
                if(data.status == 'success') {                            
                    $('.reponse_message').addClass('alert alert-success');
                    stoptimeout();
                    starttimeout('.reponse_message');
                } else {
                    $('.reponse_message').addClass('alert alert-danger');
                }
                setTimeout(function(){
                    location.reload();
                },3000);
            },
            error: function () {
                console.log('Something went wrong !.')
            }
        });
        
    }
});