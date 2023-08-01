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
$filename  = "people_list(".$date.")";		/// Name of the file ///
header("Content-type: application/octet-stream");  
header("Content-Disposition: attachment; filename=$filename.csv");
header("Pragma: no-cache"); 
header("Expires: 0"); 
 
$csvdata = 'fname,lname,desc,loc'.PHP_EOL;
$fdonors = qu("Select * from people   ");
while($dn = fa($fdonors)){
$csvdata .= '"'.$dn['name'].'","'.$dn['lname'].'","'.$dn['desc'].'","'.$dn['loc'].'"'.PHP_EOL;}
if(file_put_contents('donorbk/'.$filename.'.csv' , $csvdata)){}

echo $csvdata;
 ?>