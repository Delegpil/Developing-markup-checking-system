<?php
error_reporting(0);
require "init.php";
 
$name = $_POST["email"];
$password = $_POST["password"];
$hash = md5($password);


//$name = "pppp";
//$password = "123";
//$hash = md5($password);
//$myfile = fopen("name.txt", "w+") or die("Unable to open file!");
//fwrite($myfile, $name);
//fclose($myfile);
$sql = "SELECT * FROM `tbl_users` WHERE `username`='".$name."' AND `password`='".$hash."';";
 
$result = mysqli_query($con, $sql);
 
$response = array();
 
while($row = mysqli_fetch_array($result)){
    $response = array("id"=>$row[0],"name"=>$row[1],"password"=>$row[3],"email"=>$row[2]);
	
}

echo json_encode(array("user_data"=>$response));
 
?>