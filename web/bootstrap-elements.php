<?php
session_start();
require_once 'login/dbconnect.php';

if (isset($_SESSION['userSession'])=="") 
{
  

    header("Location: login/login.php");
    exit;
}
   $id=$_SESSION['userSession'];
   $query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id = '$id'");
   $user = $query->fetch_array();


    //<?php echo $user['username'];
if(isset($_POST['hicheel_add']))
   {
            $hicheel_name = $_POST['hicheel_name'];
            $hicheel_code = $_POST['hicheel_code'];
            $id=$_SESSION['userSession'];
            $sql = "SELECT * FROM `lesson` WHERE `hicheel_code`='{$hicheel_code}'";
            $result =$DBcon->query($sql);
            if ($result->num_rows < 1) 
             {   
                 $DBcon->query("INSERT INTO `hicheel`.`lesson` (`id`, `hicheel_name`, `hicheel_code`, `bagsh_id`) VALUES (NULL, '$hicheel_name', '$hicheel_code', '$id');") or die("aldaa");
                  echo 
             '  
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong></strong> <a href="http://startbootstrap.com/template-overviews/sb-admin-2" class="alert-link">&nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbspАмжилттай бүртгэгдлээ!!!</a>
                        </div>
                    </div>
                </div>
             ';
             } 
             else
             {   
                        echo 
             '  
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong></strong> <a href="http://startbootstrap.com/template-overviews/sb-admin-2" class="alert-link">&nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbspХичээл давхцаж байна!!!</a>
                        </div>
                    </div>
                </div>
             ';
             }      
   }

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
                        <a href="bootstrap-elements.php"><i class="fa fa-user"></i>    Миний профайл</a>
                    </li>
                    <li>
                        <a href="forms.php"><i class="fa fa-fw fa-edit"></i> Шалгалт хүснэгт</a>
                    </li>
            <!--         <li>
                        <a href="tables.php"><i class="fa fa-pencil"></i> Шалгалт засах</a>
                    </li> -->
                    
                    <li>
                        <a href="charts.php"><i class="fa fa-fw fa-bar-chart-o"></i> Хичээлийн статистик</a>
                    </li>
                              
                  <!-- <li>
                        <a href="bootstrap-grid.php"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>
                    </li>-->
              
                  
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Миний профайл
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Эхлэх</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-desktop"></i> Миний профайл
                            </li>
                        </ol>
                    </div>
                </div>
             
                <div class="container-fluid well span6">
                    <div class="row-fluid">
                        <div class="span2" >
                            <img src="user.png" class="img-circle" height="160" width="160">
                        </div>
                        
                        <div class="span8">
                           <ul class="container details">
                            <li><p><span class="glyphicon glyphicon-user" style="width: 20px;"></span><?php echo "Хэрэглэгчийн нэр: ".$user['username']; ?></p></li>
                            <li><p><span class="glyphicon glyphicon-envelope one" style="width:20px;"></span><?php echo "Хэрэглэгчийн и-мэйл: ".$user['email']; ?></p></li>
                            <li><p><span class="glyphicon glyphicon-new-window one" style="width:20px;"></span ><a href="#">idree.com</p></a>
                          </ul>

                        </div>
                         
                    </div>
                </div>

      
                <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">
                            Заах хичээл нэмэх
                        </h2>
                    </div>
                </div>
                <div class="container-fluid well span6">
                    <div class="row">
                    <div class="col-lg-6">
                    
                        <form action="bootstrap-elements.php" method="post">
                            <div class="form-group">
                                <label><h4>Хичээлийн нэр</h4></label>
                                <input class="form-control" name="hicheel_name"  placeholder="Хичээлийн нэрээ оруулна уу?">   
                            </div>

                            <div class="form-group">
                                <label><h4>Хичээлийн код</h4></label>
                                <input class="form-control" name="hicheel_code" placeholder="Хичээлийн кодоо оруулна уу?">
                            </div>
                            
                            <button type="submit" class="btn btn-primary" name = "hicheel_add">Нэмэх</button>
                        </form>
                    </div>
                    </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">
                          Заадаг хичээлүүд
                        </h2>
                                                
                        <?php
                       
                        $sql = "SELECT id, hicheel_name, hicheel_code, bagsh_id FROM lesson";
                        $result =$DBcon->query($sql);
                        $mur_count = $result->num_rows;
                                
                                 if ($result->num_rows > 0) 
                                 {
                                      echo "<table><tr><th>Хичээлийн дугаар</th><th>Хичээл нэр</th><th>Хичээл код</th></tr>";
                                      // output data of each row
                                      $a=0;
                                      while($row = $result->fetch_assoc()) 
                                      {
                                         $a = $a+1;
                                         if($row['bagsh_id'] == $id)
                                          {  
                                             echo "<tr><td>" . $a. "</td><td>" . $row["hicheel_name"]. "</td><td>" . $row["hicheel_code"]. "</td></tr>";
                                             if($a == $mur_count)
                                             {
                                                break;
                                             }
                                          }

                                      }
                                      echo "</table>";
                                 } 
                                 else 
                                 {  
                                      echo "Хичээлийн утга алга";
                                 }

                        $DBcon->close();
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
