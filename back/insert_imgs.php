<?php
 die();
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 600000); 
include("../inc/func.php");
db_open();

foreach(glob("../screen/inc/hist/70s_80shr/*.jpg") as $img){
	 echo $img.'<br>';
	   
		$rand1 = rand(1111, 9999);
		$time = date('m-d');
		$name1 = "img-".$time."-".$rand1.".jpg";
		copy($img, "../screen/inc/media_imgs/".$name1);
		$afterimg1 =  "../screen/inc/media_imgs/".$name1;
		if(strpos($img,'.png') !== false){
		$img = imagecreatefrompng( $afterimg1 );}else{
		$img = imagecreatefromjpeg( $afterimg1 );
		}
		
		$afterimg = $afterimg1 ;
 
		$width = imagesx( $img );
		$height = imagesy( $img );
		if($height > 2000){
 		$img = imagecreatefromjpeg( $afterimg );
		$width = imagesx( $img );
		$height = imagesy( $img );
		$new_height = "2000";
		  $new_width = floor( $width * ( $new_height / $height ) );
	 // create a new temporary image
		  $tmp_img = imagecreatetruecolor( $new_width, $new_height );
	  // copy and resize old image into new image
		   imagecopyresampled( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
	 // save thumbnail into a file
		  imagejpeg( $tmp_img, $afterimg ); 
		}
		
	 
		 
			
			

	$qw = qu("INSERT INTO `media` (      `col`, `src`   )
	 VALUES (    '2', '{$name1}'  )");
	 
	 
	  }
  

?>