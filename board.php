<?php
include("inc/func.php");
db_open();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
foreach($_GET as $namex => $value){$$namex = mysql_prep($value);  }

 


if(!isset($loc) && !isset($pid)){$loc = 3;
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
<html><head>
<meta charset="utf-8">
<title>Methodist Foundation of Mississippi</title>
  <META http-equiv="refresh" content="6000;URL=index.php">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
  <script src="https://code.jquery.com/jquery-migrate-3.4.0.min.js"></script>
      
  <script type="text/javascript" src="inc/scroll/js/uncompressed/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="inc/scroll/jquery.mCustomScrollbar.concat.min.js"></script>
<link rel="stylesheet" type="text/css" href="inc/scroll/jquery.mCustomScrollbar.css"/>
      
      <script>
      
      $(document).ready(function() {
   
     
		$(".mscrollbar").mCustomScrollbar({
						axis:"x",
					theme:"light-3",
					advanced:{autoExpandHorizontalScroll:true}
				});  
		
        });
      </script>
      
  <link href="inc/main.css?rel=<?=date('ymdhi')?>" rel="stylesheet" type="text/css">
</head>
<body>
<div id="main_out" style="background-image: url('inc/img/main_bg.jpg');"> 
<div class="cont_top mscrollbar"> 
<div class="board_card_holder  ">
<?php 
    $fbrd = qu("select *  from donors where loc = '{$pid}'");
    while($br = fas($fbrd)) {    
    ?>
<div class="board_card" onClick="window.location.href='board_profile.php?p=<?=$br['id']?>'">
<div class="board_card_pic"><?php
     
    if(isset($br['img']) && $br['img'] != '' && file_exists("inc/donor_photos/".$br['img'])){
        echo '<img src="inc/donor_photos/'.$br['img'].'" style="width:100%;">';
    }
    ?></div>
<p class="board_card_name">
 <?=$br['name']?> <?=$br['lname']?><br>
<span  class="board_card_name_pos"><?=$br['position']?></span>
    </p>    
</div>    
 <? } ?>   
    
</div>    
    
    
    
</div>    
 <div class="cont_nav">
 
 
 <div class="cont_nav_left"
      style="  padding-left: 400px;   "
      >
<?php
 $floc = qu("select *  from locations where  col = '{$loc}' ");    
 while($p = fas($floc)){
     
     $link = 'board.php?pid='.$p['id'];
     if($p['id'] == 9){ $link = 'board_profile.php?p=1';}
     ?>
     
 <a href="<?=$link?>" class="nav_left <? 
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