<?php
session_start();
if (isset($_SESSION['userSession'])!="") {
	header("Location: /index.php");
}
require_once 'dbconnect.php';

if(isset($_POST['btn-signup'])) {
	
	$uname = strip_tags($_POST['username']);
	$email = strip_tags($_POST['email']);
	$upass = strip_tags($_POST['password']);
	$repass = strip_tags($_POST['repassword']); 
	
	$uname = $DBcon->real_escape_string($uname);
	$email = $DBcon->real_escape_string($email);
	$upass = $DBcon->real_escape_string($upass);
	
	$hashed_password = md5($upass); 
	
	$check_email = $DBcon->query("SELECT email FROM tbl_users WHERE email='$email'");
	$count=$check_email->num_rows;
	
	if ($count==0) 
	{

		if($upass==$repass)
		{


		
		$query = "INSERT INTO tbl_users(username,email,password) VALUES('$uname','$email','$hashed_password')";

		if ($DBcon->query($query)) {
			$msg = "<div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Та амжилттай бүртгэгдлээ !
					</div>";
		}

		else {
			$msg = "<div class='alert alert-danger'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Бүртгэх явцад алдаа гарлаа !
					</div>";
		}

	}
	else{
		$msg = "<div class='alert alert-danger'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Нууц үгээ зөв бичнэ  үү !
					</div>";
		
	}

	
		
	}
	 else {
		
		
		$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Уучлаарай мэйл хаяг давхацаж байна !
				</div>";
			
	}
	
	$DBcon->close();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Бүртгэх хуудас</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css'>
<link rel="stylesheet" href="css1/style.css">
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
     
        
       <form class="form-signin" method="post" id="register-form">
      
        <h2 class="form-signin-heading">Бүртгэлийн хуудас</h2><hr />
        
        <?php
		if (isset($msg)) {
			echo $msg;
		}
		?>
          
       <div class="wrapper">
   	   <form class="form-signin" action="register.php" method="post">       
      
	   <input type="text" class="form-control" name="username" placeholder="Нэвтрэх нэр" required="" autofocus="" />
       <input type="text" class="form-control" name="email" placeholder="Имэйл хаяг" required="" autofocus="" />
       <input type="text" class="form-control" name="password" placeholder="Нууц үг" required=""/>      
	   <input type="text" class="form-control" name="repassword" placeholder="Баталгаажуулах нууц үг" required="" autofocus="" />
	  </br>
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="btn-signup">Бүртгэх</button>  
	  <button class="btn btn-lg btn-primary btn-block" type="submit" onClick="location.href='login.php'">Буцах</button>  
      </form>
  	 </div>
      
      </form>

    </div>
    
</div>

</body>
</html>