<?php
session_cache_expire(time()+3600);
session_start();
include("config.php");
if(isset($_SESSION['cred']) && $_SESSION['cred'] == md5($config['apw'])){
}else{header("location: logout.php");die();}
include("../inc/func.php");
db_open();
qu("SET NAMES 'utf8'");
$db = 'donors';
$page = 'Manage People';
if(isset($_GET['delfor'])){
$did = $_GET['id'];	
if(qu("Delete from {$db} where id = '{$did}' limit 1")){
header("Location: manage_donors.php?del=1");
} }
 if(isset($_GET['del'])){	$alert = '*** Deleted!';}
 
if(isset($_GET['delalldonors'])){
	 
$date      = date("m-d-Y--Gi");
$filename  = "donor_list(".$date.")";		/// Name of the file ///
$floc = qu("SELECT * FROM `donor_loc` ");
while($it = fa($floc)){$loc[$it['id']] = $it['title'];}
$csvdata = 'fname,lname,loc'.PHP_EOL;
$fdonors = qu("Select * from donors  ");
while($dn = fa($fdonors)){
$csvdata .= '"'.$dn['name'].'","'.$dn['lname'].'","'.$loc[$dn['loc']].'"'.PHP_EOL;}
if(file_put_contents('donorbk/'.$filename.'.csv' , $csvdata)){qu("delete from donors where loc = 1 ");}
header("Location: manage_donors.php");die();

}

//Upload Donors
if(isset($_POST['upl_donors'])){
//Backup//*********************************
$date      = date("m-d-Y--Gi");
$filename  = "donor_list(".$date.")";		/// Name of the file ///
$floc = qu("SELECT * FROM `donor_loc` ");
while($it = fa($floc)){$loc[$it['id']] = $it['title']; $loci[$it['title']] = $it['id'];}
$csvdata = 'fname,lname,amount,loc'.PHP_EOL;
$fdonors = qu("Select * from donors   ");
while($dn = fa($fdonors)){
$csvdata .= '"'.$dn['name'].'","'.$dn['lname'].'","'.$dn['amount'].'","'.$dn['loc'].'"'.PHP_EOL;}
if(file_put_contents('donorbk/'.$filename.'.csv' , $csvdata)){}
//*********************************

//IMPORT
$file = $_FILES['upl_donors']['tmp_name'];
file_put_contents('donorbk/'.$filename.'-uploaded.csv' , file_get_contents($file));
$handle = fopen($file, "r");
$headershould = array("First Name","Last Name","Date","Visible","Gifts In Kind","Partner","Workplace Giving","Bequest Intent","Realized Bequest","Location", "Special Gifts Type");
$count = 1;
$insert = "Insert into donors  (`name`, `lname`,`date`,`vis`, `gifts_in_kind`, `partner`, `workplace_giving`, `bequest_intent`, `realized_bequest`, `loc`, `special_gifts_type`) values ";
while (($data = fgetcsv($handle, 5000, ",")) !== FALSE ) {
if($data != $headershould  && $count == 1){
echo 'Correct Format: <br />';	
foreach($headershould as $kx => $vx){echo "'$vx', ";}	
echo '<hr> Your Format:<br />';
foreach($data as $kx => $vx){echo "'$vx', ";}
 die("<hr />Invalid Format!");
 
 }
 
 if($count > 1){
	foreach($data as $k => $dv){
		$dt[$k] = mysql_prep($dv);
	}
	
	if($dt['0'] == '' && $dt['1'] == ''){continue;}
	
	if($count > 2){$insert .= ",  " ;}

	$visible_backend = ($dt['3'] == "Yes") ? 1 : 0;
	$gifts_in_kind_backend = ($dt['4'] == "Yes") ? 1 : 0;
	$partner_backend = ($dt['5'] == "Yes") ? 1 : 0;
	$workplace_giving_backend = ($dt['6'] == "Yes") ? 1 : 0;
	$bequest_intent_backend = ($dt['7'] == "Yes") ? 1 : 0;
	$realized_bequest_backend = ($dt['8'] == "Yes") ? 1 : 0;
	
	$donor_location = qu("SELECT * FROM `donor_loc` where title = '{$dt['9']}';");
	$matching_donor_location = fas($donor_location);
	 
	$loc_backend = $matching_donor_location['id'];

	$insert .= "( '{$dt['0']}' , '{$dt['1']}' , '{$dt['2']}' , '{$visible_backend}' , '{$gifts_in_kind_backend}' ,  '{$partner_backend}', '{$workplace_giving_backend}' , '{$bequest_intent_backend}' , '{$realized_bequest_backend}' , '{$loc_backend}' , '{$dt['10']}')";
	 } 
	 
	 $count ++;

}
	
qu($insert);
//*********************************


}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title><?php echo $config['title'].' - '.$page?></title>
<link rel="stylesheet" type="text/css" href="be.css"/>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>

<body>
<div id="content">
<div id="logo"> &nbsp;</div>
<div id="nav"><?php nav($c_nav); ?></div>
<?php if(isset($alert)){echo '<div class="alert">'. $alert.'</div>';}?>
<div id="welcome" >

    <p class="title"><?php echo $page;?></p>
 <p>   <a href="manage_donors_new.php" class="lnk_btn">+ Add New</a> </p>
 <form id="form1" name="form1" method="post" action="">
  <p>SEARCH:  
   <input type="text" name="searchtext" id="searchtext" />
   <input type="submit" name="submit" id="submit" value="SEARCH" />
 </p>

 </form>
 <p>&nbsp; </p>
    <table width="980" border="0" cellpadding="3" cellspacing="0" style="font-size: 12px; ">
    <tr >
          <td height="30" colspan="2" align="left" valign="bottom"><a href="manage_donors_new.php" class="lnk_btn">+ Add New</a> 
         <!-- <a href="csv_export_donors.php" class="lnk_btn">Export</a>
          
          <span class="lnk_btn" onclick="impdon(); ">Import</span>--> <br />
         <!-- <br />
          <a href="?delalldonors=1" class="lnk_btn" style="background-color:#F30F13;" onclick="return confirm('Are You Sure?');">
          Delete Annual Giving Donors</a>-->
        <br /></td>
          
      </tr> 
        <tr class="wt_title">
       <td  height="17" align="left" bgcolor="#666666" >ID</td>
          
          <td  height="17" align="left" bgcolor="#666666" >Name</td>
          <td  "  align="left" bgcolor="#666666">Location</td> 
           <td width="190" align="center" bgcolor="#666666">&nbsp;</td>
        
        </tr>
        <?php 
		$result = qu("select donors.*, donor_loc.betitle from donors 
		join donor_loc on donor_loc.id = donors.loc
		order by donor_loc.betitle asc, name asc
		");
		if(isset($_POST['searchtext'])){
			$searchtext = mysql_prep($_POST['searchtext']);
	$result = qu("select donors.*, donor_loc.betitle from donors 
		join donor_loc on donor_loc.id = donors.loc
		where donors.name like '%{$searchtext}%' or donors.lname like '%{$searchtext}%'
		order by donor_loc.betitle asc, name asc
		");
			}
		while($usr =  fa($result) ){
			echo '<tr style="font-size:13px;" class="lineunder">			
          <td align="left" >'.$usr['id'].'</td>
		  
		  <td align="left" >'.$usr['name'].' '.$usr['lname'].'</td>
		  <td align="left">'.$usr['betitle'].'</td>     
		       
          <td align="center">';
		  
		  echo '<a href="manage_donors_edit.php?uid='.$usr['id'].'" class="lnk_btn2">Edit</a>  
		   <a href="?delfor=events&id='.$usr['id'].'" onclick="return confirm(\'Are you sure you want to delete this?\');" class="lnk_btn2">Delete</a>';
		   echo'</td></tr> ';
		}
		?>
       
      </table>
</div>
<div id="creds" class="jolt"><a href="http://www.jolt1.com" class="jolt">Powered by Jolt Design - 732-807-5658</a></div>

</div>
  <div id="ajaxload"  ></div>
<div id="shaddow" onclick="hide_add();" >&nbsp;</div>
<script>
 $("#ajaxload").html('');
		$("#ajaxload").hide();
		$("#shaddow").hide();

function hide_add(){
		$("#ajaxload").html('');
		$("#ajaxload").hide();
		$("#shaddow").hide();
	
		}
		function centerme(itemname){
	var wht = $(window).height();
	var wwh = $(window).width();
	console.log("Window: W"+wwh+" H:"+wht);
	var thht = $(itemname).height();
	var thwh = $(itemname).width();
	var nlft = (wwh - thwh) /2;
	var ntop = (wht  - thht)/2;
	
	$(itemname).css({
		"top": ntop,
		"left":nlft,
		"position": "fixed"});
	if(thht > (wht - 100)){
		$(itemname).css({
		"top": "50px",
		"left":nlft,
		"position": "absolute"});
		}
		
	
	
}
function impdon(){
 $("#ajaxload").show();
 $("#shaddow").show();
 $("#ajaxload").load("ajax_upload_donors.php");
	centerme("#ajaxload");
	}
</script>
</body>
</html>