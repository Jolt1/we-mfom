<?php

session_cache_expire(time()+3600);
session_start();
include("config.php");

if(isset($_SESSION['cred']) && $_SESSION['cred'] == md5($config['apw'])){
}else{header("location: logout.php");die();}
include("../inc/func.php");
db_open();
$db = 'media';
$page = 'Image - Edit';
if(isset($_GET['tid'])){$tid = $_GET['tid'];}else{header("Location: manage_media.php");}
$ts = dbinfo($db, $tid);
if(isset($_POST['button'])){
	foreach($_POST as $name => $value){$$name = mysql_prep($value); }
	
	if(isset($_FILES['jpg1']['tmp_name']) && $_FILES['jpg1']['tmp_name'] != '' )	
		{
		
		$tmp_name = $_FILES['jpg1']['tmp_name'];
		
		$filei =  getimagesize($tmp_name);
		if($filei['mime'] != "image/jpeg" && $filei['mime'] != 0){echo "Wrong Image Type! - JPG only!"; die;}else{
		
	
		$tmp_name = $_FILES['jpg1']['tmp_name'];
		$rand1 = rand(1111, 9999);
		$time = date('m-d');
		$name1 = "img-".$time."-".$rand1.".jpg";
	
		move_uploaded_file($tmp_name, "../inc/media_imgs/".$name1);

			
		$afterimg1 =  "../inc/media_imgs/".$name1;
		$img = null;
			
		if(strpos($_FILES['jpg1']['name'],'.png') !== false || strpos($_FILES['jpg1']['name'],'.PNG') !== false){
		$img = imagecreatefrompng( $afterimg1 );}
			
		else {
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
		
			
			
		$qw = qu("Update `{$db}` set  `title` = '{$title}', `ord` = '{$ord}', `vis` = '{$vis}' , `col` = '{$loc}',
	`date` = '{$date}', `src` = '{$name1}'
	  where id = '{$tid}' limit 1");
	if($qw){
		 
		$alert = 'Updated! - <a href="manage_media.php?tid='.$ts['col'].'" class="lnk_btn">Back</a>';
		}
		}
		
		
		}
	
	}
$ts = dbinfo($db, $tid);?>
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
    <form id="form1" name="form1" method="post" enctype="multipart/form-data" action="">
      <table width="800" border="0">
        <tr>
          <td width="100" align="right" valign="top" class="col_title">Description:</td>
          <td><label for="title"></label>
            <input name="title" type="text" id="title" value="<?php echo $ts['title']?>" size="50" /></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="col_title">Date:</td>
          <td><label for="title2"></label>
            <input name="date" type="date" id="title2" value="<?php echo $ts['title']?>"size="50"  /></td>
        </tr>
        <tr>
          <td align="right"><strong>Location:</strong></td>
          <td><select name="loc" id="loc">
            <?php
          $flocs = qu("select * from media_loc order by title asc");
		  while($loc = fa($flocs)){
		echo '<option value="'.$loc['id'].'"'; 
		if($ts['col'] == $loc['id']){echo ' selected ';}
		echo '>'.$loc['title'].'</option>';
			}
		  ?>
          </select></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="col_title">Order:</td>
          <td><input name="ord" type="text" id="ord" value="<?php echo $ts['ord']?>" size="10" /></td>
        </tr>
        <tr>
  
          <td align="right" class="col_title">Visible:</td>
          <td><select name="vis" id="vis">
            <option value="1" <?php if($ts['vis'] == 1){echo 'selected';}?>>Yes</option>
            <option value="2" <?php if($ts['vis'] == 2){echo 'selected';}?>>No</option>
          </select></td>
        </tr>
		  
		  <tr>
          <td align="right" class="col_title">JPG or PNG Image:</td>
          <td><label for="jpg1"></label>
          <input type="file" name="jpg1" id="jpg1" /></td>
        </tr>
          
		  <tr>
		  
			  <td><br></td>
		  </tr>
		  
        <tr>
          <td align="right" class="col_title">&nbsp;</td>
          <td><input name="button" type="submit" class="lnk_btn" id="button" value="Update " />
           <a href="manage_media.php?tid=<?=$ts['col']?>" class="lnk_btn">Cancel</a></td>
		  </tr>
        <tr>
          <td height="23" align="right" class="col_title"> </td>
          <td><p><img src="../inc/media_imgs/<?php echo  $ts['src'];?>"  style="max-width: 700px; max-height: 700px;" /></p></td>
        </tr>
        
      </table>
    </form>
    <p class="title">&nbsp;</p>
</div>
<div id="creds" class="jolt"><a href="http://www.jolt1.com" class="jolt">Powered by Jolt Design - 732-807-5658</a></div>

</div>
</body>
</html>