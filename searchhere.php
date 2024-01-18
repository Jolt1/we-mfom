<?php
include("inc/func.php");
db_open();
 
if(isset($_POST['newval'])){$search  = mysql_prep($_POST['newval']);}else{die('---');}
 echo 'You Searched for: "'.$search.'"';

$fs = qu("SELECT 'donors' AS db,d.id , CONCAT(d.NAME,' ', d.lname) AS vname, l.betitle as `stitle`, page   FROM donors d 
JOIN donor_loc l ON l.id = d.loc
WHERE d.NAME LIKE '%{$search}%' OR d.lname LIKE '%{$search}%' OR CONCAT(d.NAME,' ', d.lname) LIKE '%{$search}%'
 
order by   stitle, vname

");

if(rowc($fs) == 0){echo '<p>No Results Found.</p>';}else{
while($n = fa($fs)){
	
echo '<p style="font-size:32px;"><strong>'.$n['vname'].' </strong> ('.$n['stitle'].') <a href="board_profile.php?p='.$n['id'].'" class="btnred">View</a></p>';	
	
}
	
}
?>

