<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_cache_expire(time()+3600);
session_start();
include("config.php");
if(isset($_SESSION['cred']) && $_SESSION['cred'] == md5($config['apw'])){
}else{header("location: logout.php");}
$alert = $config['welcome'];

include("../inc/func.php");
db_open();

$fset = qu("select *  from settings");
while($set = fas($fset)){
    $st[$set['id']] = $set['value'];
}

//print_r($_POST);
if(isset($_POST['update']) && isset($_POST['settings'][1])){
    $newval =mysql_prep($_POST['settings'][1]);
qu("update settings set value = '{$newval}' where id = '1' limit 1" );    
}


$fset = qu("select *  from settings");
while($set = fas($fset)){  $st[$set['id']] = $set['value'];  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $config['title']?></title>
<link rel="stylesheet" type="text/css" href="be.css"/> 
</head>

<body>
<div id="content">
<div id="logo"> &nbsp;</div>
<?php if(isset($alert)){echo '<div id="alert">'. $alert.'</div>';}?>
<div id="welcome" style="min-height:500px; padding-left:15px;">

    <p class="title">Please Choose From The Menu Below.</p>
  
    <p>
      <?php
foreach($c_nav as $linkt => $linkv){
	echo '<a href="'.$linkv.'" class="lnk_btn" title="'.$linkt.'">'.$linkt.'</a>';
	}
?>
    </p>
    
     
</div>
<div id="creds" class="jolt"><a href="http://www.jolt1.com" class="jolt">Powered by Jolt Design - 732-807-5658</a></div>

</div>
</body>
</html>