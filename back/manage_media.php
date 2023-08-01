<?php
session_cache_expire(time()+3600);
session_start();
include("config.php");
if(isset($_SESSION['cred']) && $_SESSION['cred'] == md5($config['apw'])){
}else{header("location: logout.php");die();}
include("../inc/func.php");
db_open();

  		 
$db = 'media';
$page = 'Home Images';

if(isset($_GET['delfor']) && $_GET['delfor'] == 'media'){
	$did = $_GET['id'];	
	$din = dbinfo('media', $did);
	if(is_file("../inc/media_imgs/" .$din['src'])){unlink("../inc/media_imgs/" .$din['src']);}
	if(is_file("../inc/media_imgs/" ."tn/".$din['src'])){unlink("images/" ."tn/".$din['src']);}
	if(qu("Delete from {$db} where id = '{$did}' limit 1")){
	header("Location: manage_media.php?del=1&tid=".$tid); } }
	
	if(isset($_GET['del'])){	$alert = '*** Deleted!';}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $config['title'].' - '.$page?></title>

<link rel="stylesheet" type="text/css" href="be.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript" ></script>

<style>
.image_tb{
	display:none;}
</style>
<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
</head>
<body><div id="content">
<div id="logo"> &nbsp;</div>
<div id="nav"><?php nav($c_nav); ?></div>
<?php if(isset($alert)){echo '<div id="alert">'. $alert.'</div>';}?>
<div id="welcome" >

    <p class="title"><?php echo $page;?></p>
    <?php
    	
	 $result = qu("select m.*, l.title as loct from media m 
join media_loc l on l.id = m.col
 order by m.`col` , ord desc ");
		
		 ?>
                 
         
<?php $numrows  = rowc($result);
		 echo $numrows.' Results'
	?>
    <table width="975" border="0" cellpadding="0" cellspacing="0">
<tr>
          <td height="30" colspan="3" align="left"><a href="manage_media_new.php " class="lnk_btn">+ Add New</a>
          <a href="#" class="lnk_btn" onclick="$('.image_tb').toggle(); return false;">Show/ Hide Images</a> </td>
        </tr>
        <tr class="wt_title">
        <td width="110" bgcolor="#666666"  class="image_tb">&nbsp;</td>
        <td width="75" align="center" bgcolor="#666666">ID</td> 
         <td  align="left" bgcolor="#666666">Title</td>
         <td width="250" align="center" bgcolor="#666666">Location</td>
		<td width="75" align="center" bgcolor="#666666">Order</td>
		<td width="100" align="center" bgcolor="#666666">Visible</td>
        <td width="125" align="center" bgcolor="#666666">&nbsp;</td>
        </tr>
        <?php 

		$count = 0;
		while($dbitem =  fa($result) ){
			$count ++;
			if($odd = $count%2){$bg = '#F4F4F4';}else{$bg = '#cccccc';}
			 
			 
			echo '<tr bgcolor="'.$bg.'">
			<td class="image_tb"><img src="../inc/media_imgs/'.$dbitem['src'].'" width="100"  /></td>
			<td   align="center">'.$dbitem['id'].'</td>
			 
          <td align="left">'.$dbitem['title'].'</td>
		  <td align="center">'.$dbitem['loct'].'</td>
		    <td align="center">'.$dbitem['ord'].'</td>
          <td align="center" style="font-size:12px;">';
		  if($dbitem['vis'] == 1){echo 'Yes';}else{echo 'No';}
		  
		  echo '</td>
          <td align="center">';
		   echo '<a href="manage_media_edit.php?tid='.$dbitem['id'].'" class="lnk_btn2">Edit </a> 
		   <a href="manage_media.php?delfor='.$db.'&id='.$dbitem['id'].'&tid='.$dbitem['id'].'" onclick="return confirm(\'Are you sure you want to delete this?\');" class="lnk_btn2">Delete</a>';
		 
		   		   echo'</td>
        </tr> '	;
			}
		?>
       
    </table>
  
  
    
  

</div>
<div id="creds" class="jolt"><a href="http://www.jolt1.com" class="jolt">Powered by Jolt Design - 732-807-5658</a></div>

</div>
</body>
</html>
 