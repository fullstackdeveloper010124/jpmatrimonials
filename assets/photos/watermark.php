<?php // loads a png, jpeg or gif image from the given file name
  function imagecreatefromfile($image_path) 
  {
    // retrieve the type of the provided image file
    list($width, $height, $image_type) = getimagesize($image_path);
    // select the appropriate imagecreatefrom* function based on the determined
    // image type
    switch ($image_type)
    {
      case IMAGETYPE_GIF: return imagecreatefromgif($image_path); break;
      case IMAGETYPE_JPEG: return imagecreatefromjpeg($image_path); break;
      case IMAGETYPE_PNG: return imagecreatefrompng($image_path); break;
      default: return ''; break;
    }
  }
  // load source image to memory
  // no_image.jpg
  
  $image_display = '';
  $watermark_img = '../watermark.png';
  $display_water_mark = 'Yes';
  if(isset($_REQUEST['image']) && $_REQUEST['image'] !='')
  {
	$image_display = $_REQUEST['image'];
	if(strpos($image_display,'nowatermark') === false)
	{
	}
	else
	{
		$display_water_mark = 'No';
		$image_display = str_replace('nowatermark','',$image_display);
	}
	if(!file_exists($image_display))
	{
		$image_display = '';
	}
  }
  if($image_display =='')
  {
	$image_display = '../no_image.jpg';
	$display_water_mark = 'No';
  }
  $image = imagecreatefromfile($image_display);  
  
  if (!$image) die('Unable to open image');
  // load watermark to memory
  if (!$image) die('Unable to open watermark');
  // calculate the position of the watermark in the output image (the
  // watermark shall be placed in the lower right corner)  
  // merge the source image and the watermark
  if($display_water_mark == 'Yes' && $watermark_img !='' && file_exists($watermark_img))
  {
		$watermark = imagecreatefromfile($watermark_img);
		$watermark_pos_x = imagesx($image) - imagesx($watermark) - 0;
		$watermark_pos_y = imagesy($image) - imagesy($watermark) + 0;
		
		imagecopy($image, $watermark,  $watermark_pos_x, $watermark_pos_y, 0, 0,  imagesx($watermark), imagesy($watermark));
  }
  // output watermarked image to browser
  header('Content-Type: image/jpeg');
  imagejpeg($image,NULL, 100);  // use best image quality (100)
  // remove the images from memory
  imagedestroy($image);
  imagedestroy($watermark);
?>