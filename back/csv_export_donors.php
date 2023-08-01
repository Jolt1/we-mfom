<?php
session_cache_expire(time()+3600);
session_start();
include("config.php");
if(isset($_SESSION['cred']) && $_SESSION['cred'] == md5($config['apw'])){
}else{header("location: logout.php");die();}
include("../inc/func.php");
db_open();
$db = 'board';
$date      = date("m-d-Y--Gi");
$filename  = "donor_list(".$date.")";		/// Name of the file ///
header("Content-type: application/octet-stream");  
header("Content-Disposition: attachment; filename=$filename.csv");
header("Pragma: no-cache"); 
header("Expires: 0"); 


$csvdata = 'First Name,Last Name,Date,Visible,Gifts In Kind,Partner,Workplace Giving,Bequest Intent,Realized Bequest,Location,Special Gifts Type'.PHP_EOL;
$fdonors = qu("SELECT * FROM donors LEFT JOIN donor_loc ON donors.loc = donor_loc.id;");

while($dn = fa($fdonors)){

$visible_text = ($dn['vis'] == 1) ? "Yes" : "No";
$gifts_in_kind_text = ($dn['gifts_in_kind'] == 1) ? "Yes" : "No";
$partner_text = ($dn['partner'] == 1) ? "Yes" : "No";
$workplace_giving_text = ($dn['workplace_giving'] == 1) ? "Yes" : "No";
$bequest_intent_text = ($dn['bequest_intent'] == 1) ? "Yes" : "No";
$realized_bequest_text = ($dn['realized_bequest'] == 1) ? "Yes" : "No";

	
$csvdata .= '"'.$dn['name'].'","'.$dn['lname'].'","' . $dn['date'] . '","' . $visible_text . '","' . $gifts_in_kind_text  . '","'  . $partner_text . '","'  . $workplace_giving_text . '","' . $bequest_intent_text . '","'  . $realized_bequest_text .  '","' . $dn['title'] . '","' . $dn['special_gifts_type'] .'"'.PHP_EOL;}
if(file_put_contents('donorbk/'.$filename.'.csv' , $csvdata)){}

echo $csvdata;
 ?>