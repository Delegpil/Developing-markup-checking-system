<?php
session_start();
require_once 'dbconnect.php';
/*
$id=1;
$check_email = $DBcon->query("SELECT * FROM account WHERE user_id='$id'") or die("Alfdaa");
while($check=$check_email->fetch_assoc()){
	echo $check['email'];
}
*/
if (isset($_SESSION['userSession'])!="") {
	header("Location: /diplom2/index.php");
	exit;
}

if (isset($_POST['btn-login'])) 
{
	
	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);
	
	$email = $DBcon->real_escape_string($email);
	$password = $DBcon->real_escape_string($password);
	
	$query = $DBcon->query("SELECT user_id, email, password FROM tbl_users WHERE email='$email'");
	$row=$query->fetch_array();
	
	$count = $query->num_rows; // if email/password are correct returns must be 1 row
	
	if (md5($password)==$row['password'] && $count==1) 
	{
		$_SESSION['userSession'] = $row['user_id'];
		header("Location: /diplom2/index.php");
	} 
	else 
	{
		$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; И-мэйл эсвэл нууц үг буруу байна !
				</div>";
	}
	$DBcon->close();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Нэвтрэх хуудас</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css'>
<link rel="stylesheet" href="../css1/style.css">
<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #428BCA;
    padding: 12px 14px;
    text-align: center;

}

</style>
</head>
<body>

<ul>
<div>
	    <p><font size = "4" color="white">МОНГОЛ УЛСЫН ШИНЖЛЭХ УХААН ТЕХНОЛОГИЙН ИХ СУРГУУЛЬ</font></p>
</div>

</ul>
<div class="signin-form">
	<div class="container">     
       <form class="form-signin" method="post" id="login-form">
	        <h2 class="form-signin-heading">Нэвтрэх хуудас</h2>
	       	        <?php
				if(isset($msg))
				{
					echo $msg;
				}
			?>
	        <div class="wrapper">
	        <input type="email" class="form-control" placeholder="И-мэйл хаяг" name="email" required />
	        <span id="check-e"></span>
	        <input type="password" class="form-control" placeholder="Нууц үг" name="password" required />
	        <label class="checkbox">
	        <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Намайг сана
	         </label>
	        <button class="btn btn-lg btn-primary btn-block" type="submit" name="btn-login">Нэвтрэх</button>  
		    <button class="btn btn-lg btn-primary btn-block" type="button" onClick="location.href='register.php'">Бүртгүүлэх</button>
		  
      </form>

    </div>
    
</div>

</body>
</html>

