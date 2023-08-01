<?php
session_cache_expire(time()+3600);
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");
if(isset($_SESSION['cred']) && $_SESSION['cred'] == md5($config['apw'])){
}else{header("location: logout.php");die();}

include("../inc/func.php");
db_open();
qu("SET NAMES 'utf8'");
$db = 'donors';
$page = 'Manage People : New';

if(isset($_POST['add_usr'])){
foreach($_POST as $namex => $valx){if(!is_array($valx)){ $$namex = mysql_prep($valx); }}

$img = '';
if( isset($_FILES['pic']['tmp_name']) && $_FILES['pic']['tmp_name'] != '' ){
$tmp_name = $_FILES['pic']['tmp_name'];
$filei =  getimagesize($tmp_name);
if($filei['mime'] != "image/jpeg" && $filei['mime'] != 0){echo "Wrong Image Type! - JPG only!"; die;}else{
$rand1 = rand(1111, 9999);
		$time = date('m-d');
		$name1 = "img-".$time."-".$rand1.".jpg";
		move_uploaded_file($tmp_name, "../screen/inc/donor_photos/".$name1);	
	$img = $name1;

}
} 
		qu("Insert into `{$db}` (`name`, `lname`,   `loc`, `vis`, `img`, `bio` ) 
        values ('{$name}', '{$lname}',  '{$loc}', '{$vis}', '{$img}', '{$bio}' )");
		$mid = mysqli_insert_id($mysqlilink);
	 
	


header("Location: manage_donors_edit.php?uid={$mid}"); die();

}
 
 
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
    <form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
      <table class="form" width="1000" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td width="168"><strong>First Name:</strong></td>
          <td width="820"> 
            <strong>
            <input type="text" name="name" id="name"  style="width:300px;"/>
          </strong></td>
        </tr>
        <tr>
          <td><strong>Last Name:</strong></td>
          <td><strong>
            <input type="text" name="lname" id="lname"  style="width:300px;"/>
          </strong></td>
        </tr>
        <tr style="display: none;">
          <td><strong>Location:</strong></td>
          <td><strong>
            <select name="loc" id="loc">
              <?php
          $flocs = qu("select * from donor_loc where showbe = 1  order by id desc");
		  while($loc = fa($flocs)){
		echo '<option value="'.$loc['id'].'">'.$loc['title'].'</option>';
			}
		  ?>
            </select>
          </strong></td>
        </tr>
		  
            <td><strong>Visible?:</strong></td>
          <td><strong>
            <select name="vis" id="vis">
              <option value="0">No</option>
              <option value="1" selected>Yes</option>
            </select>
          </strong></td>
        </tr>
		  
        <tr  >
          <td valign="top"><strong>Bio:</strong></td>
            <td> 
              <strong>
              <textarea name="bio" id="bio" style="width: 500px; height: 350px;"></textarea>
            </strong></td>
        </tr>
        <tr >
          <td><strong>Picture: </strong></td>
          <td><p>
            <strong>
            <input type="file" name="pic" id="pic" />
            <br />
            Picture size : 400px wide x 600px tall</strong></p></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td> <strong>
            <input name="add_usr" type="submit" value="Add" />
          </strong></td>
        </tr>
      </table>
    </form>
    <p>&nbsp;</p>
</div>
	<div id="creds" class="jolt"><a href="http://www.jolt1.com" class="jolt">Powered by Jolt Design - 732-807-5658</a></div>
	<script src="./js/toggle_contributor_relevant_fields.js"></script>
	<script src="./js/toggle_specialgifts_sub.js"></script>
</div>
</body>
</html>