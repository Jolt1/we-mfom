<?php
session_cache_expire(time()+3600);
session_start();
include("config.php");
if(isset($_POST['login']) &&  isset($_POST['pw'])){
	if($_POST['pw'] == $config['apw']){
		
		$_SESSION['cred'] = md5($config['apw']);
		header("location: main.php");
		}else{$alert = 'Password is incorect!';}
	
	}
	if(isset($_GET['lo']) && $_GET['lo'] == 1){$alert = 'You have been logged out.';}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $config['title']?></title>
<link rel="stylesheet" type="text/css" href="be.css"/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>

<body>
<div id="content">
<div id="logo"> &nbsp;</div>
<?php if(isset($alert)){echo '<div id="alert">'. $alert.'</div>';}?>
<div id="login" style="height:500px; padding-left:15px;">
  <form id="form1" name="form1" method="post" action="">
    <p class="title">Please Login:</p>
    <p>
      <label for="pass">Password</label>
      <input name="pw" type="password" id="pw" value="" size="45" />
    </p>
    <p>
      <input type="submit" name="login" id="login" value="Login" />
    </p>
  </form>
</div>
<div id="creds" class="jolt"><a href="http://www.jolt1.com" class="jolt">Powered by Jolt Design - 732-807-5658</a></div>

</div>
<script>
$("#pw").focus();
</script>
</body>
</html>