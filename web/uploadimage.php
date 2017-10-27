<?php
if($_SERVER['REQUEST_METHOD']=='POST')
 {
	 
	 if(isset($_POST['ImageName']))
		{
			
			$cipher = $_POST["cipher"];
			$soril = $_POST["soril"];
			$hiceel_code = $_POST["hicheel_code"];
			$imgname = $_POST['ImageName'];		
			$imsrc = base64_decode($_POST['image']);
			$fp = fopen('upload/'.$imgname, 'w');
			fwrite($fp, $imsrc);
				if(fclose($fp))
				{
					
				}else
				{

				}
				require_once('dbConnect.php'); 
			
				$sql = "INSERT INTO `students` (`id`,`cipher`, `hicheel_code`, `image_path`, `zassan`, `soril`) VALUES (NULL, '".$cipher."', '".$hiceel_code."','".$imgname."' , 'null', '".$soril."');";
				if(!mysqli_query($con, $sql))
				{
					echo '{"message":"Unable to save the data to the database."}';
				}
				else
				{
					echo $hiceel_code;
					echo $cipher;
					echo $soril;
				}
		}
 }
 else
 {
	echo "Error";
 }

?>

 




