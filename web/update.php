<?php
        session_start();
        require_once 'login/dbconnect.php';

          $zas_query = $DBcon->query("SELECT `cipher`, `hicheel_code`, `image_path`, `zassan`, `soril` FROM `students`") or die("error");

          while($row = $zas_query->fetch_assoc()) 
          {
                
                       if($row['zassan'] == "Zassan")
                        {  
                           echo "zasagdsan";
                        }
                        else 
                        {
                            $student_image = $row['image_path'];
                            echo "\n";
                            $soril = $row['soril'];
                            $student_cipher = $row['cipher'];
                         //   $student_image = "1504758998134.jpg";
                          //  $soril = "1";
                         //   $student_cipher="6-213-001";
                            echo $sql1['zuv'];
                            chdir("upload");
         //$page = shell_exec('python omr.py --input "'.$row['image_path'].'" --output zassan/"'.$row['image_path'].'"'); 
          $page = shell_exec('python omr.py --input "'.$student_image.'" --output zassan/"'.$student_image.'"'); 
                         #   $page = shell_exec('python main.py --input "'.$student_image.'"');
                           $sql = $DBcon->query("SELECT stu.cipher , count(*) as 'zuv' FROM `student_answer` as stu inner join `hicheel_info` as hich on stu.hicheel_code=hich.hicheel_code where stu.asuult_hariu=hich.answer and stu.soril=".$soril." and stu.asuult_id=hich.question  and stu.cipher='".$student_cipher."' group by stu.cipher" ) or die("aldaaa");
                             $sql1 = $sql->fetch_array();
                             $student_awsan_onoo = $sql1['zuv'];
                             $zassan = "Zassan";
                             $sql_db = $DBcon->query("UPDATE `students` SET `zassan`='Zassan', `awsan_onoo`=' $student_awsan_onoo' WHERE cipher='$student_cipher'");
                        }

        }


?>