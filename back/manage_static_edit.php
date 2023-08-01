<?php
session_cache_expire(time()+3600);
session_start();
include("config.php");
if(isset($_SESSION['cred']) && $_SESSION['cred'] == md5($config['apw'])){
}else{header("location: logout.php");die();}
include("../inc/func.php");
db_open();
qu("SET NAMES 'utf8'");
$db = 'staticpages';
$page = 'Edit Static Page';

 	if(isset($_GET['cid'])){$cid = $_GET['cid'];}else{header("Location: manage_static.php");}
if(isset($_POST['button']) ){
foreach($_POST as $name => $value){$$name = mysql_prep($value); } 

// set each staticpage's content
$content = $_POST['content'];

$qw = null;
foreach($content as $static_page_id=>$static_page_content) {
	$static_page_content_prepared = mysql_prep($static_page_content);
	$qw = qu("UPDATE `staticpages` set  `content` = '{$static_page_content_prepared}'  where id = '{$static_page_id}'");
}
	
if($qw){$alert = 'Page Updated! - <a href="manage_static.php" class="lnk_btn">Back</a>';}
}

//$cin = dbinfo($db,$cid);

$cin = qu("SELECT *, sp.id AS sp_id, sl.id AS sl_id FROM staticpage_loc sl
		  JOIN staticpages sp ON sl.id = sp.rel
		  WHERE sl.id = '{$cid}'
		  ORDER BY sp.ord ASC;");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $config['title'].' - '.$page?></title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="be.css"/>

<link rel="stylesheet" type="text/css" href="js/jquery-ui-1.7.2.custom.css"/>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="js/jquery.richtextarea.css"/>
<script type="text/javascript" src="js/jquery.richtextarea.min.js"></script>


<script>
$(document).ready(function(){$(".content2").richtextarea();});
</script>
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
		  
		  <?php
		  	foreach($cin as $static_page_content) {
				echo '<tr>';
				
				echo '<td width="150" align="right" valign="top" class="col_title">Title:</td>';
				echo "<td>{$static_page_content['title']}</td>";
				
				echo "</tr>";
				
				
				if($static_page_content['type'] === 'text') {
						echo "<tr>";
					
						echo '
          <td align="right" valign="top" class="col_title">Content:</td>
          <td><textarea name="content[' . $static_page_content['sp_id'] .']" class="content2" style="
          width:800px; height:500px;">' . $static_page_content['content'] . '</textarea>
           </td>';
					
						echo "</tr>";
					
				}
			}
		  ?>
        <tr>
          <td align="right" class="col_title">&nbsp;</td>
          <td><input name="button" type="submit" class="lnk_btn" id="button" value="Update Page" />
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