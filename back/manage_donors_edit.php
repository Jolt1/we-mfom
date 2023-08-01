<?php
session_cache_expire(time()+3600);
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");
if(isset($_SESSION['cred']) && $_SESSION['cred'] == md5($config['apw'])){
}else{header("location: logout.php");die();}
if(!isset($_GET['uid'])){header("Location: logout.php"); die();}
include("../inc/func.php");
db_open();
qu("SET NAMES 'utf8'");
$db = 'donors';
$page = 'Manage People : Edit';
if(isset($_SESSION['alert']) && $_SESSION['alert'] != ''){$alert = $_SESSION['alert']; unset($_SESSION['alert']);}

$uid = mysql_prep($_GET['uid']);
$did = $uid;
if(isset($_POST['add_usr'])){
	foreach($_POST as $namex => $valx){if(!is_array($valx)){ $$namex = mysql_prep($valx); }}
    
 
		qu("update `{$db}` set  
        `name` = '{$name}', `lname` = '{$lname}',  `loc` = '{$loc}', `vis` = '{$vis}',  `bio` = '{$bio}' ,
       
		where id = '{$uid}' limit 1;
		");
		$mid = mysqli_insert_id($mysqlilink);	
			
	 
	

	$alert = "Updated!";
}

if( isset($_FILES['pic']['tmp_name']) && $_FILES['pic']['tmp_name'] != '' ){
$tmp_name = $_FILES['pic']['tmp_name'];
$filei =  getimagesize($tmp_name);
if($filei['mime'] != "image/jpeg" && $filei['mime'] != 0){echo "Wrong Image Type! - JPG only!"; die;}else{
$rand1 = rand(1111, 9999);
		$time = date('m-d');
		$name1 = "img-".$time."-".$rand1.".jpg";
		move_uploaded_file($tmp_name, "../inc/donor_photos/".$name1);	
	$img = $name1;
qu("update `{$db}` set   `img` = '{$img}' 
where id = '{$uid}' limit 1
");
 
 $alert = 'Updated Photo!';

}}

 

$din = dbinfo("donors",$uid);
if(isset($_GET['delphoto']) && $din['img'] != ''  ){
	 
	qu("update `{$db}` set   `img` = '' where id = '{$uid}' limit 1");
	$_SESSION['alert'] = 'Photo Deleted';
	header("Location: manage_donors_edit.php?uid=".$uid); die();
	$din['img'] = '';
	
	} 
$din = dbinfo("donors",$uid);
 
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title><?php echo $config['title'].' - '.$page?></title>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="be.css"/>
 
</head>

<body>
<div id="content">
<div id="logo"> &nbsp;</div>
<div id="nav"><?php nav($c_nav); ?></div>
<?php if(isset($alert)){echo '<div id="alert">'. $alert.'</div>';}?>
<div id="welcome" >

    <p class="title"><?php echo $page;?></p>
    <form id="form1" name="form1" method="post" action="">
      <table width="1000" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td width="168"><strong>First Name:</strong></td>
          <td width="820"> 
          <input name="name" type="text" id="name"  style="width:300px;" value="<?=$din['name']?>"/></td>
        </tr>
        <tr>
          <td><strong>Last Name:</strong></td>
          <td><input type="text" name="lname" id="lname"  style="width:300px;" value="<?=$din['lname']?>"/></td>
        </tr>
        <tr style="display: none">
          <td><strong>Location:</strong></td>
          <td><select name="loc" id="loc">
          <?php
          $flocs = qu("select * from donor_loc where showbe = 1 order by id desc");
		  while($loc = fa($flocs)){
		echo '<option value="'.$loc['id'].'"'; 
		if($din['loc'] == $loc['id']){echo ' selected ';}
		echo '>'.$loc['title'].'</option>';
			}
		  ?>
          </select></td>
        </tr>
		  
        <tr>
          <td><strong>Visible?:</strong></td>
          <td><select name="vis" id="vis">
            <option value="1" <? if($din['vis'] == '1'){echo ' selected ';} ?>>Yes</option>
            <option value="0"  <? if($din['vis'] == '0'){echo ' selected ';} ?>>No</option>
          </select></td>
        </tr>
		 	    <tr  >
          <td valign="top">Bio:</td>
            <td> 
            <textarea name="bio" id="bio" style="width: 500px; height: 350px;"><?=$din['bio']?></textarea></td>
        </tr> 
        <tr >
          <td valign="top"><strong>Picture: </strong></td>
          <td><?php
          if($din['img'] != ''){
			  echo '<img src="../inc/donor_photos/'.$din['img'].'" style="max-width:300px;">
			  
			  
			  <br />
          <a href="manage_donors_edit.php?uid='.$did.'&delphoto=1" class="jolt">Delete Photo</a>
			  ';
			  }
		  ?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td> <input name="add_usr" type="submit" value="Update Donor" /></td>
        </tr>
      </table>
    </form>
    <form id="form2" name="form2" enctype="multipart/form-data" method="post" action="" style="  padding:10px;
    margin:10px; border:1px solid #ccc;">
      Upload Replacement Photo:
      <input type="file" name="pic" id="pic" />
      <input type="submit" name="up_replace" id="up_replace" value="Upload Photo" />
    </form>
    <p>&nbsp;</p>
</div>
<div id="creds" class="jolt"><a href="http://www.jolt1.com" class="jolt">Powered by Jolt Design - 732-807-5658</a></div>
	<script src="./js/toggle_contributor_relevant_fields.js"></script>
	<script src="./js/toggle_specialgifts_sub.js"></script>
</div>
</body>
</html>