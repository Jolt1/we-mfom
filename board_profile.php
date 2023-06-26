<?php
include("inc/func.php");
db_open();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
foreach($_GET as $namex => $value){$$namex = mysql_prep($value);  }

 
$loc = 3;
$prf = dbinfo('donors', $p); 
$pid =   $prf['loc'];   

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
   
     $(".mscrollbar").mCustomScrollbar({ 	});  
		 
		
        });
      </script>
      
  <link href="inc/main.css?rel=<?=date('ymdhi')?>" rel="stylesheet" type="text/css">
</head>
<body>
<div id="main_out" style="background-image: url('inc/img/main_bg.jpg')"> 
<div class="cont_top  "> 
 <div class="name_prof_list mscrollbar">
<div>
   <?php
    $fbrd = qu("select *  from donors  where loc = '{$pid}'");
        $allids = [];
    while($br = fas($fbrd)) {  ?> 
    <a href="board_profile.php?p=<?=$br['id']?>" <?php if($p == $br['id']){
        echo 'class="activepg"';
        
    }?>> <?=$br['name']?> <?=$br['lname']?></a><br>
    <?
                            
                            
                            
               $allids[] = $br['id'];             
               $allbrd[$br['id']] = $br;             
                            } 
    
    
            
      end($allids); // Move the internal pointer to the last element
     $lastKey = key($allids);
       
      $curkey = array_search($p, $allids);       
         
          if( $curkey == 0 ){$prev = $allids[$lastKey];
                             $next = $allids[1]; }
            elseif($curkey == $lastKey){
                
                            $prev = $allids[($curkey-1)];
                             $next = $allids[0];} else{
                
                $prev = $allids[($curkey-1)];
                             $next = $allids[($curkey+1)];
            }
    
    
    ?>
     
</div>    
    
    
    
</div> 
    
    
<div class="name_prof_pic"></div>    
<div class="name_prof_text">
<h2><?=$prf['name']?> <?=$prf['lname']?> - <span style="font-weight: normal; font-size:30px;"><?=$prf['position']?></span></h2>    
    <p><?=$prf['desc']?></p>
    
</div>
    <div class="nxtbtn"> <a href="board_profile.php?p=<?=$next?>"><?=$allbrd[$next]['name']?> <?=$allbrd[$next]['lname']?> > </a> </div>
    <br clear="all" >   
</div>    
 <div class="cont_nav">
 
 
 <div class="cont_nav_left"
      style="  padding-left: 400px;   "
      >
<?php
 $floc = qu("select *  from locations where  col = '{$loc}' ");    
 while($p = fas($floc)){ ?>
 <a href="board.php?pid=<?=$p['id']?>" class="nav_left <? 
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