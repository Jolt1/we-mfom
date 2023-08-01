<?php
session_cache_expire(time()+3600);
session_start();
include("config.php");
if(isset($_SESSION['cred']) && $_SESSION['cred'] == md5($config['apw'])){
}else{header("location: logout.php");die();}
include("../inc/func.php");
db_open();
$db = 'staticpages';
$page = 'Static Pages';

// Delete Category
if(isset($_GET['delfor']) && $_GET['delfor'] == 'cats'){
$did = $_GET['id'];	
if(qu("Delete from {$db} where id = '{$did}' limit 1")){
header("Location: manage_static.php?del=1"); } }
if(isset($_GET['del'])){	$alert = '*** Deleted!';}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $config['title'].' - '.$page?></title>

<link rel="stylesheet" type="text/css" href="be.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript" ></script>


</head>
<body><div id="content">
<div id="logo"> &nbsp;</div>
<div id="nav"><?php nav($c_nav); ?></div>
<?php if(isset($alert)){echo '<div id="alert">'. $alert.'</div>';}?>
<div id="welcome" >

    <p class="title"><?php echo $page;?></p>
    <br />
    <table width="975" border="0" cellpadding="3" cellspacing="0">
      <tr>
        <td height="30" colspan="3" align="left"><!--<a href="manage_static_new.php" class="lnk_btn">+ Add New</a>--></td>
      </tr>
      <tr class="wt_title">
         
        <td  align="left" bgcolor="#666666">Page  Title</td> 
        
        <td width="125" align="center" bgcolor="#666666">&nbsp;</td>
      </tr>
      <?php 
		$result = qu("select * from staticpage_loc order by title asc ");
		$count = 0;
		while($dbitem =  fa($result) ){
			$count ++;
			if($odd = $count%2){$bg = '#F4F4F4';}else{$bg = '#cccccc';}
			 
			echo '<tr bgcolor="'.$bg.'">
			 
          <td align="left">'.$dbitem['title'].'</td> 
		 
          <td align="center">';
		   echo '<a href="manage_static_edit.php?cid='.$dbitem['id'].'" title="Edit '.$dbitem['title'].'" class="lnk_btn2">Edit </a> 
		    ';
		 
		   		   echo'</td>
        </tr> '	;
			}
		?>
    </table>
    <p>&nbsp;</p>
</div>
<div id="creds" class="jolt"><a href="http://www.jolt1.com" class="jolt">Powered by Jolt Design - 732-807-5658</a></div>

</div>
</body>
</html>