<?php
session_start();
require_once 'login/dbconnect.php';
/*
$id=1;
$check_email = $DBcon->query("SELECT * FROM account WHERE user_id='$id'") or die("Alfdaa");
while($check=$check_email->fetch_assoc()){
    echo $check['email'];
}
*/
if (isset($_SESSION['userSession'])=="") 
{
  

    header("Location: login/login.php");
    exit;
}
   $id=$_SESSION['userSession'];
   $query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id = '$id'");
   $user = $query->fetch_array();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Онлайн шалгалтын материал засах</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/plugins/morris.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Онлайн тест засагч програм</a>
            </div>
           
            <ul class="nav navbar-right top-nav">
                <!--
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>-->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>&nbsp;<?php echo $user['username']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                          <a href="bootstrap-elements.php"><i class="fa fa-fw fa-user"></i>Профайл</a>
                        </li>
                        <!--
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>-->
                        <li class="divider"></li>
                        <li>
                            <a href="login/logout.php?logout"><i class="fa fa-fw fa-power-off"></i>Гарах</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                     <li class="active">
                        <a href="index.php"><i class="fa fa-home"></i> Эхлэх</a>
                    </li>
                    <li>
                        <a href="bootstrap-elements.php"><i class="fa fa-user"></i> Миний профайл</a>
                    </li>
                    <li>
                        <a href="forms.php"><i class="fa fa-fw fa-edit"></i> Шалгалт хүснэгт</a>
                    </li>
                    <li>
                        <a href="tables.php"><i class="fa fa-pencil"></i> Шалгалт засах</a>
                    </li>
                    
                    <li>
                        <a href="charts.php"><i class="fa fa-fw fa-bar-chart-o"></i> Шалгалт анализ</a>
                    </li>               
                  
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>    

        <div id="page-wrapper">

            <div class="container-fluid">
   
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Оюутны материал
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Эхлэх</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Шалгалт засах
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Оюутны материал
                            </li>
                            
                        </ol>
                    </div>
                </div>
               
               
                  <div class="row">
                    <div class="col-lg-6">
                        <div class="table-responsive">
                           <table class="table table-bordered">
                                <thead  class="thead-inverse">
                                    <tr>
                                        <th>Асуултын дугаар</th>
                                        <th>Шалгалтын хариу</th>
                                        <th>Оюутны хариу</th>
                                        <th>Оюутны шифр</th>                                 
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if(isset($_GET['lesid']))
                                    {
                                    
                                        $lesid= $_GET['lesid'];
                                        echo "<h2>$lesid</h2>";
                                        $soril= $_GET['soril'];
                                        $cipher = $_GET['cipher'];
                                        $image = $_GET['image'];
                                      //  $que= $DBcon->query("SELECT * FROM `students` Where hicheel_code='$lesid' and soril='$soril' ORDER BY `hicheel_code` ASC") or die($DBcon->connect_error);
                                        $que = $DBcon->query("SELECT stu.cipher,   stu.asuult_hariu, hich.answer, stu.image_name, hich.question FROM `student_answer` as stu inner join `hicheel_info` as hich on stu.hicheel_code=hich.hicheel_code where stu.soril='$soril' and stu.asuult_id=hich.question and hich.hicheel_code='$lesid' and stu.cipher='$cipher' and stu.image_name='$image'");
        
/*
        $ijil = $DBcon->query("SELECT stu.cipher,   stu.asuult_hariu, hich.answer, hich.question FROM `student_answer` as stu inner join `hicheel_info` as hich on stu.hicheel_code=hich.hicheel_code where stu.soril='$soril' and stu.asuult_id=hich.question and hich.hicheel_code='$lesid' and stu.cipher='$cipher' and stu.image_name='$image' and stu.asuult_hariu=hich.answer");

                   */                    //  $ijil = $query4->fetch_array();
                                        
                                       





                                        /*while ($row = $ijil->fetch_assoc()) 
                                        {
                                              */   
                                                
                                       
                                                    while ($rows = $que->fetch_assoc()) 
                                                    {       

                                                                    //echo "a".$row['question']."a";
                                                                    //echo $rows['question'];
                                                                   

                                                                    if ($rows['answer'] == $rows['asuult_hariu'])
                                                                    {
                                                                        echo '
                                                                          
                                                                                <tr  class="success">                                
                                                                                    <td>'.$rows['question'].'</td>
                                                                                    <td>'.$rows['answer'].'</td>
                                                                                    <td>'.$rows['asuult_hariu'].'</td>
                                                                                    <td>'.$rows['cipher'].'</td>
                                                                                </tr>               
                                                                            ';
                                                                    }
                                                                    else
                                                                    {
                                                              
                                                                        echo '      
                                                                            <tr class = "danger" >
                                                                                <td>'.$rows['question'].'</td>
                                                                                <td>'.$rows['answer'].'</td>
                                                                                <td>'.$rows['asuult_hariu'].'</td>
                                                                                <td>'.$rows['cipher'].'</td>
                                                                            </tr> 
                                                                      
                                                                            ';
                                                                    }
                                                          
                                                    /* }
*/
                                         }
                                        
                                    }
                                    else
                                    {
                                        echo "<h2>Шалгалтыг засаагүй байна</h2>";
                                    }

                                        ?>

                                </tbody>

                            </table>

                            <?php
                                if(isset($_GET['image']))
                                {
                                    $image = $_GET['image'];
                                    echo "<br />\n";
                                    $path = 'upload/zassan/'.$image;

                                    echo "<h2>Оюутны шалгалтын зураг</h2>";
                                    echo '<img src='.$path.' border=0>';
                                }
                                else
                                {
                                    echo "<h2>Оюутны шалгалтын зураг ороогүй байна</h2>";
                                }


                            ?>
                        </div>
                    </div>
                    

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
