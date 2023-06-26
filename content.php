<?php
include("inc/func.php");
db_open();

 
foreach($_GET as $namex => $value){$$namex = mysql_prep($value);  }

if(isset($loc) && $loc == 3){header("location: board.php"); die();}


if(!isset($loc) && !isset($pid)){$loc = 1;
                            $fp = qu("select *  from locations where  col = '{$loc}' limit 1");
                            $fp = fas( $fp );
                                $pid = $fp['id']; 
                                 $pin = dbinfo('locations', $pid);
}elseif(isset($pid)){
    
$pin = dbinfo('locations', $pid);
$loc =    $pin['col']; 
}elseif(isset($loc)){
    
  $fp = qu("select *  from locations where  col = '{$loc}' limit 1");
                            $fp = fas( $fp );
                             $pid = $fp['id'];   
    $pin = dbinfo('locations', $pid);
}


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
<?php
  $pin['content'] =   str_replace('~','<img src="inc/img/star.png" width="18" height="22" alt=""/>',$pin['content']);
    echo nl2br($pin['content']);
    ?>    
    
    
    
</div>    
 <div class="cont_nav">
 <div class="cont_nav_left"
      style="    <?php
    if($loc == '2'){echo 'padding-left: 400px;';}
             ?>  "
      >
<?php
 $floc = qu("select *  from locations where  col = '{$loc}' ");    
 while($p = fas($floc)){ ?>
 <a href="content.php?pid=<?=$p['id']?>" class="nav_left <? 
     if($pid == $p['id']){echo 'navselected';}  ?> "
    style="   <?php
     if($p['lh'] != '' && $p['lh'] >0){  echo ' margin-top:0px;'; }else{
         echo ' margin-top:0px;';
     } ?> "    
    >
     <div style="  display:inline-block; <?php
     if($p['lh'] != '' && $p['lh'] >0){echo 'line-height:'.$p['lh'].'px;  margin-top:10px; padding:5px;';}else{
         echo ' margn-top:-20px;';
     }                                                       
     ?>"><?=$p['title']?></div></a>     
     
<?  }   ?>     
     
      
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