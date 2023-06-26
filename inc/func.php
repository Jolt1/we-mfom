<?php
function db_open(){
//constants
define("DB_SERVER","localhost");
define("DB_USER","mfom");
define("DB_PASS","mF01msql19$.aS");
define("DB_NAME","mfom");
global $mysqlilink;
$mysqlilink = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
 
 
 
}



//*************************************************
// Pulls DB info for item
//*************************************************
	

function dbinfo($db,$id, $fld = 'id'){
global $mysqlilink;
$query = "Select * from {$db} where `{$fld}` = {$id}";
$result_set =   mysqli_query($mysqlilink, $query);
if($pritem = mysqli_fetch_array($result_set,MYSQLI_BOTH)){
return $pritem;}else {return NULL;}
	
	

}

//*************************************************
// Confirms MySQL querry
//*************************************************
function confirm_query($result_set){
global $mysqlilink;
if(!$result_set){
die(mysqli_error($mysqlilink));	
}
}

//*************************************************
// preps entry for DB
//*************************************************
function mysql_prep($value) {
	global $mysqlilink;
	 $value = strip_tags($value);
	$value = mysqli_real_escape_string( $mysqlilink, $value );
		 
		return $value;
	}
function mysql_prepn( $value ) {
	global $mysqlilink;
		 $value = mysqli_real_escape_string( $mysqlilink, $value );
		 
		if (is_numeric($value) || $value == "") {
			$value = $value;
			}else{echo 'not numeric'; die();}
		
		return $value;
	}
	
 
//************************************
// quick qu	
//************************************
function qu($query){
	global $mysqlilink;
	$result =  mysqli_query($mysqlilink, $query);
	confirm_query($result);
	return $result;
	}

//************************************
//quick fetch
//************************************
function fa($value){
$result = mysqli_fetch_array($value, MYSQLI_BOTH);
return $result;

	
	}

function fas($value){
$result = mysqli_fetch_assoc($value);
return $result;

	
	}
//************************************
//max id
//************************************
function maxid($dbn)	{
$q2 = "select max(id) from `{$dbn}` ";
$result_set = mysql_query($q2);
confirm_query($result_set);
if($pritem = mysql_fetch_array($result_set)){
return $pritem[0]; }}


//************************************
//count rows
//************************************
function rowc($qw){
	$count = mysqli_num_rows ($qw);
	return $count;
	}
 
//************************************
// Return  Cropped Thumbnail
//************************************
function CroppedThumbnail($imgSrc,$thumbnail_width,$thumbnail_height) { //$imgSrc is a FILE - Returns an image resource.
    //getting the image dimensions  
    list($width_orig, $height_orig) = getimagesize($imgSrc);   
    $myImage = imagecreatefromjpeg($imgSrc);
    $ratio_orig = $width_orig/$height_orig;
    
    if ($thumbnail_width/$thumbnail_height > $ratio_orig) {
       $new_height = $thumbnail_width/$ratio_orig;
       $new_width = $thumbnail_width;
    } else {
       $new_width = $thumbnail_height*$ratio_orig;
       $new_height = $thumbnail_height;
    }
    
    $x_mid = $new_width/2;  //horizontal middle
    $y_mid = $new_height/2; //vertical middle
    
    $process = imagecreatetruecolor(round($new_width), round($new_height)); 
    
    imagecopyresampled($process, $myImage, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
    $thumb = imagecreatetruecolor($thumbnail_width, $thumbnail_height); 
    imagecopyresampled($thumb, $process, 0, 0, ($x_mid-($thumbnail_width/2)), ($y_mid-($thumbnail_height/2)), $thumbnail_width, $thumbnail_height, $thumbnail_width, $thumbnail_height);

    imagedestroy($process);
    imagedestroy($myImage);
    return $thumb;
}
	
//************************************
//Navigation Echo
//************************************
function nav($c_nav){
	foreach($c_nav as $linkt => $linkv){	echo '<a href="'.$linkv.'" class="lnk_btn" title="'.$linkt.'">'.$linkt.'</a>'; }
	}
	//************************************
//format date to insert even if null
//************************************
function prep_insert_date($date){
if($date != ''){
$date = "'".date("Y-m-d", strtotime($date))."'";
}else{
$date ="NULL";
}
return $date;

}
	//************************************
//format date even if null
//************************************
function prep_view_date($date){
if($date != ''){
$time = strtotime($date);
$myFormatForView = date("m/d/y", $time);
return $myFormatForView;
}else{
return $date;
}
}
function removeNonAlphabeticChars($string) {
    // Remove all non-alphabetic characters using regular expression
    $cleanString = preg_replace('/[^a-zA-Z]/', '', $string);
    $cleanString = strtolower($cleanString);
    return $cleanString;
}
?>