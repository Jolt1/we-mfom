<?php
session_cache_expire(time()+3600);
session_start();
include("config.php");
if(isset($_SESSION['cred']) && $_SESSION['cred'] == md5($config['apw'])){
}else{header("location: logout.php");die();}
include("../inc/func.php");
db_open();
$db = 'staticpages';
$page = 'New Static Page';


if(isset($_POST['button']) ){
foreach($_POST as $name => $value){$$name = mysql_prep($value); }
 
$qw = qu("INSERT INTO `{$db}` ( `title`,`content`  )
VALUES ( '{$title}', '{$content}' )");
if($qw){$alert = 'Page Added! - <a href="manage_static.php" class="lnk_btn">Back</a>';}
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
    <form action="" method="post" name="form1" id="form1">
      <table width="1100" border="0">
        <tr>
          <td width="150" align="right" valign="top" class="col_title">Title:</td>
          <td><label for="title"></label>
            <input name="title" type="text" id="title" size="50" /></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="col_title">Content:</td>
          <td><textarea name="content" id="content2" style="
          width:800px; height:500px;"></textarea></td>
        </tr>
        <tr>
          <td align="right" class="col_title">&nbsp;</td>
          <td><input name="button" type="submit" class="lnk_btn" id="button" value="Add Page" />
            <a href="manage_static.php" class="lnk_btn">Cancel</a></td>
        </tr>
      </table>
    </form>
    <p class="title">&nbsp;</p>
</div>
<div id="creds" class="jolt"><a href="http://www.jolt1.com" class="jolt">Powered by Jolt Design - 732-807-5658</a></div>

</div>
</body>
</html>