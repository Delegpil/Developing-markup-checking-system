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
    <link href="assets/css/style.css" rel="stylesheet" media="screen" />
    <link href="css/plugins/morris.css" rel="stylesheet">
    <script type="text/javascript" src="assets/js/jquery.js"></script> 
</head>

<body>

    <div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
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
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>&nbsp;<?php echo $user['username']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="bootstrap-elements.php"><i class="fa fa-fw fa-user"></i>Профайл</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="login/logout.php?logout"><i class="fa fa-fw fa-power-off"></i>Гарах</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                   <li class="active">
                        <a href="index.php"><i class="fa fa-home"></i> Эхлэх</a>
                    </li>
                    <li>
                        <a href="bootstrap-elements.php"><i class="fa fa-user"></i>  Миний профайл</a>
                    </li>
                    <li>
                        <a href="forms.php"><i class="fa fa-fw fa-edit"></i> Шалгалт хүснэгт</a>
                    </li>
               <!--      <li>
                        <a href="tables.php"><i class="fa fa-pencil"></i> Шалгалт засах</a>
                    </li>
                     -->
                    <li>
                        <a href="charts.php"><i class="fa fa-fw fa-bar-chart-o"></i> Хичээлийн статистик</a>
                    </li>
        
                </ul>
            </div>
        </nav>    
        <div id="page-wrapper">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">               
                                <?php 
                                            if(isset($_GET['lesid']))
                                            {
                                                echo $_GET['lesid'];  
                                            }
                                    ?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Эхлэх</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-bar-chart-o"></i> Шалгалт анализ
                            </li>
                        </ol>
                    </div>
                </div>
            
                
                     <div class="col-xs-6">
                     <h2 style="color:#069"> Оюутан тус бүрийн онооны хүснэгт</h2>
                            <div class="sec-box">
                                <a class="closethis">Close</a>
                                <header>
                                
                                </header>
                                <div class="contents boxpadding">
                                    <a class="togglethis">Toggle</a>
                                    <div class="charts-box">
                                      <script type="text/javascript" src="assets/js/raphael-2.1.0.min.js"></script>
                                      <script type="text/javascript" src="assets/js/morris-0.4.1.min.js"></script>
                                    

                                        <?php  
                                        //pie chart heseg ############################################
                                         $connect = mysqli_connect("localhost", "root", "", "hicheel");  
                                           if(isset($_GET['lesid']))
                                            {
                                                 $hicheel_code = $_GET['lesid'];
                                                 $hicheel_soril = $_GET['cipher'];
                                            } 
                                         $query = "SELECT awsan_onoo, count(*) as number FROM `students`  WHERE  hicheel_code = '".$hicheel_code."' and soril = '".$hicheel_soril."'  group by awsan_onoo"; 

                                         $resulta = mysqli_query($connect, $query);  
                                         ?>  
                                       <script type="text/javascript" src="js/google.js"></script>  
                                       <script type="text/javascript">  
                                       google.charts.load('current', {'packages':['corechart']});  
                                       google.charts.setOnLoadCallback(drawChart);  
                                       function drawChart()  
                                       {  
                                            var data = google.visualization.arrayToDataTable([  
                                                      ['awsan_onoo', 'Number'],  
                                                      <?php  
                                                      while($row = mysqli_fetch_array($resulta))  
                                                      {  
                                                           echo "['".$row["awsan_onoo"]."', ".$row["number"]."],";  
                                                      }  
                                                      ?>  
                                                 ]);  
                                            var options = {  
                                                  title: 'Шалгалтын авсан оноог хувиар илэрхийлсэн байдал',  

                                                  //is3D:true,  
                                                  pieHole: 0.5  
                                                 };  
                                            var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
                                            chart.draw(data, options);  
                                       //########################################################################
                                       }  

                                       </script> 


                                          <br />     <br />     <br />  
                                        <div id="displaydigonalbar"></div>
                                        <script>
                                            var day_data = 
                                            
                                            [
                                          <?php
                                
                                            if(isset($_GET['lesid']))
                                            {
                                                 $hicheel_code = $_GET['lesid'];
                                                 $hicheel_soril = $_GET['cipher'];
                                            }
                                            $get_cats = "SELECT `cipher`, `awsan_onoo` FROM `students` WHERE hicheel_code = '".$hicheel_code."' and soril = '".$hicheel_soril."' "; 
                                            $i = 0;
                                            $run_cats = $DBcon->query($get_cats);
                                 
                                            while($row_counter = mysqli_fetch_array($run_cats)){
                                                $counter_date = $row_counter['cipher'];
                                                $counter = $row_counter['awsan_onoo'];
                                                $niit++;
                                                echo "{'period': '$counter_date', 'awsan_onoo': $counter,},";
                                      
                                        }

                                            ?>
                                 
                                            ];
                                            Morris.Bar
                                            ({
                                              element: 'displaydigonalbar',
                                              data: day_data,
                                              xkey: 'period',
                                              ykeys: ['awsan_onoo'],
                                              labels: ['awsan_onoo'],
                                              xLabelAngle: 60
                                            });
                                        </script>

                                    
                                    </div>
                                </div>
                            </div>

                    </div>
                
                     <div class="row">
                     <div class="col-lg-5">       
                     <div id="piechart" style="width: 1000px; height: 600px;"></div>  
                    </div>
                
             
        </div>

    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/flot-data.js"></script>

</body>

</html>
