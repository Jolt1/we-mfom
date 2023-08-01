<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_cache_expire(time()+3600);
session_start();
include("config.php");
if(isset($_SESSION['cred']) && $_SESSION['cred'] == md5($config['apw'])){
}else{header("location: logout.php");die();}
include("../inc/func.php");
db_open();

			 
			 
			$db = 'media';
			$page = 'New Image';

if(isset($_POST['add_img']) && isset($_FILES['jpg1']['tmp_name']) && $_FILES['jpg1']['tmp_name'] != '' )	
		{$tmp_name = $_FILES['jpg1']['tmp_name'];
			
		$filei =  getimagesize($tmp_name);
		if($filei['mime'] != "image/jpeg" && $filei['mime'] != 0){echo "Wrong Image Type! - JPG only!"; die;}else{
		foreach($_POST as $name => $value){$$name = mysql_prep($value); }
	
	$tmp_name = $_FILES['jpg1']['tmp_name'];
		$rand1 = rand(1111, 9999);
		$time = date('m-d');
		$name1 = "img-".$time."-".$rand1.".jpg";
		move_uploaded_file($tmp_name, "../inc/media_imgs/".$name1);
		$afterimg1 =  "../inc/media_imgs/".$name1;
		if(strpos($_FILES['jpg1']['name'],'.png') !== false || strpos($_FILES['jpg1']['name'],'.PNG') !== false){
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
		
	 
		 
			
			

	$qw = qu("INSERT INTO `{$db}` (   `ord`, `vis` ,`col`, `src` ,   `title` ,`date` )
	 VALUES (  '{$ord}', '{$vis}',  '{$loc}', '{$name1}',   '{$desc}', '{$date}'  )");
	if($qw){
	 
		$alert = 'Added! - <a href="manage_media.php " class="lnk_btn">Back</a>';
		$media_id = mysqli_insert_id($mysqlilink);
		header("Location: manage_media_edit.php?tid=" . $media_id);
		}
			}
		    	}
	
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $config['title'].' - '.$page?></title>
<link rel="stylesheet" type="text/css" href="be.css"/>

<style type="text/css">
.col_title {	font-weight: bold;
	font-size: 14px;
	color: #333;
}
</style>
</head>

<body>
<div id="content">
<div id="logo"> &nbsp;</div>
<div id="nav"><?php nav($c_nav); ?></div>
<?php if(isset($alert)){echo '<div id="alert">'. $alert.'</div>';}?>
<div id="welcome" >

    <p class="title"><?php echo $page;?></p>
    <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <table width="800" border="0">
        <tr>
          <td width="100" align="right" valign="top" class="col_title">Description:</td>
          <td><label for="title4"></label>
            <input name="desc" type="text" id="title4" value="" size="50" /></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="col_title">Date:</td>
          <td><label for="title2"></label>
            <input name="date" type="date" id="title2"   size="50" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><strong>Location:</strong></td>
          <td><select name="loc" id="loc">
            <?php
          $flocs = qu("select * from media_loc order by title asc");
		  while($loc = fa($flocs)){
		echo '<option value="'.$loc['id'].'">'.$loc['title'].'</option>';
			}
		  ?>
          </select></td>
        </tr>
         
        <tr>
          <td align="right" valign="top" class="col_title">Order:</td>
          <td><input name="ord" type="text" id="ord" value="100" size="10" /></td>
        </tr>
        <tr>
          <td align="right" class="col_title">Visible:</td>
          <td><select name="vis" id="vis">
            <option value="1">Yes</option>
            <option value="2">No</option>
          </select></td>
        </tr>
        <tr>
          <td align="right" class="col_title">JPG or PNG Image:</td>
          <td><label for="jpg1"></label>
          <input type="file" name="jpg1" id="jpg1" /></td>
        </tr>
        <tr>
          <td align="right" class="col_title">&nbsp;</td>
          <td><input name="add_img" type="submit" class="lnk_btn" id="add_img" value="Create" /> <a href="manage_media.php" class="lnk_btn">Cancel</a></td>
        </tr>
      </table>
    </form>
    <p class="title">&nbsp;</p>
</div>
<div id="creds" class="jolt"><a href="http://www.jolt1.com" class="jolt">Powered by Jolt Design - 732-807-5658</a></div>

</div>
</body>
</html>