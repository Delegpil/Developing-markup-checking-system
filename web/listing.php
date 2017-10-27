<?php
require_once 'login/dbconnect.php';
if(isset($_POST['count']))
{
	$co= $_POST['count'];
	$var =$_POST['varint'];
	$list= "abcdefghijklmnopqrstuvwxyz";
	$arr1 = str_split($list);
	//echo  $arr1[2];
	echo '<table style="width: 90%">
<thead>
  <tr> <th style="width: 10%">#</th> ';
    for ($i=0; $i <$var ; $i++) { 
    	echo ' <th style="width: 10%">'.$arr1[$i].'</th> ';
    }
 echo '</tr> </thead>';
	for ($i=1; $i <=$co ; $i++)
	 { 
		echo '<tr>
			    <td>Асуулт-'.$i.'</td>';
		for ($j=1; $j <=$var ; $j++) 
		{ 
			echo '<td id="vote">
			        &nbsp;<input type="radio" name="group'.$i.'" value='.$arr1[$j-1].' />&nbsp;
			        </td>';
		}
		echo '</td>   
			    </tr>';
		
	}
echo '</table';
}
if(isset($_POST['soril'])){
	//echo $_POST['soril'];
	if(isset($_POST['ciph']))
	{
		//echo $_POST['ciph'];
		if(isset($_POST['img']))
		{
		//	echo $_POST['img'];
			$soril = $_POST['soril'];
			$cipher = $_POST['ciph'];
			$image = $_POST['img'];
			$query =  $DBcon->query("UPDATE `students` SET `cipher`= '$cipher', `soril`= '$soril' WHERE image_path='$image'") or die("aldaa");
			if($query){
				echo "Good";
			}
			else{
				$DBcon->errno();
			}
			

		}
	}
}
?>
						