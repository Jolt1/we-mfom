<?php
include("inc/func.php");
db_open();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
foreach($_GET as $namex => $value){$$namex = mysql_prep($value);  }
$loc = 3; 
     

?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Methodist Foundation of Mississippi</title>
  <META http-equiv="refresh" content="600;URL=index.php">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
  <script src="https://code.jquery.com/jquery-migrate-3.4.0.min.js"></script>
  <link href="inc/main.css?rel=<?=date('ymdhi')?>" rel="stylesheet" type="text/css">
</head>
<body>
<div id="main_out" style="background-image: url('inc/img/main_bg.jpg')"> 
<div class="cont_top"> 
    
    
    
    
</div>    
 <div class="cont_nav">
 <div class="cont_nav_left"   >

      
 </div>   
 <div class="cont_nav_right">  
    <?php
 $floc = qu("select *  from locations_loc  ");    
 while($l = fas($floc)){ ?>
 <a href="content.php?loc=<?=$l['id']?>" class="nav_right <? 
     if($loc == $l['id']){echo 'navselected';}?>"
    style=" <?php if($l['id'] == 3){echo 'line-height:40px; padding-top: 60px; ';} ?> "
    ><?=$l['title']?></a>     
     
<?  }   ?> 
  
     </div>
 </div>    
     <div class="bot_mainnav">
 <a href="#" class="backbtn" onClick="window.history.back();">&nbsp;</a>   
 <a href="index.php" class="homebtn">&nbsp;</a>   
 <a href="#" class="srchbtn"  onClick="keyboardtoggle(); return false;">&nbsp;</a>   
   
 </div>  
</div>

<?php
 include("keybaord.php");   
 ?>
    
</body>
</html>