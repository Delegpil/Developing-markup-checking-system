<?php
error_reporting(0);
require "init.php";
 
$name = $_POST["name"];
$password = $_POST["password"];
$email = $_POST["email"];
$hashed_password = md5($password); 
//$name = "sdf";
//$password = "sdf";
//$email = "sdf@r54";
 
$sql = "INSERT INTO `tbl_users` (`user_id`,`username`, `email`, `password`) VALUES (NULL, '".$name."', '".$email."', '".$hashed_password."');";
if(!mysqli_query($con, $sql)){
    echo '{"message":"Unable to save the data to the database."}';
}
 
?>	