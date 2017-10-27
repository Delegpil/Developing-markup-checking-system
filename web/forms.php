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
   $query1 = $DBcon->query("SELECT * FROM lesson") or die("lesson aldaaa");
   
   if(isset($_POST['save']))
   {
         $asuult = $_POST['count'];
         $hicheel_name = $_POST['hicheel_name'];
         $hicheel_code = $_POST['hicheel_code'];
         $hicheel_soril = $_POST['soril'];
         $dawhar = "SELECT * FROM `hicheel_info` WHERE `hicheel_code`='{$hicheel_code}' and `action`='{$hicheel_soril}'";
        $result =$DBcon->query($dawhar);
            if ($result->num_rows < 1) 
             {   
                 $numbers = array();
                $hariult = array();
                for($i=1; $i<=$asuult; $i++)
                {
                    $numbers[i] = "group$i";
                    $hariult[i] = $_POST[$numbers[i]];   
                    $DBcon->query("INSERT INTO `hicheel`.`hicheel_info` (`id`, `hicheel_ner`, `question`,`hicheel_code`,`answer`, `onoo`, `bagsh_id`, `action`) VALUES (NULL, '{$hicheel_name}','{$i}','{$hicheel_code}', '{$hariult[i]}', '{$asuult}', '$id', '{$hicheel_soril}');");            
                }
                      echo 
             '  
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong></strong> <a href="http://startbootstrap.com/template-overviews/sb-admin-2" class="alert-link">&nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbspАмжилттай хадгалагдлаа!!!</a>
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
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
                <!--     <li>
                        <a href="tables.php"><i class="fa fa-pencil"></i> Шалгалт засах</a>
                    </li> -->
                    
                    <li>
                        <a href="charts.php"><i class="fa fa-fw fa-bar-chart-o"></i> Хичээлийн статистик</a>
                    </li>
                  
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
                          Шалгалт авах хичээл
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Эхлэх</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-edit"></i> Шалгалт хүснэгт
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-6">
                    
                        <form role="form" action="forms.php" method="post">
                            <div class="form-group">
                                <label><h4>Хичээлийн нэр</h4></label>
                                <select class="form-control" name="hicheel_name" id="lesson" onchange="table1()" >
                                    <?php 
                                        $query  = $DBcon->query("SELECT * FROM lesson WHERE bagsh_id = '$id'") or die("lesson aldaaa");
                                        while($row = $query->fetch_assoc()){
                                            echo "<option value='".$row['hicheel_code']."'>".$row['hicheel_name']."</option>";
                                        }
                                    ?>
                                </select> 
                             
                            </div>

                            <div class="form-group">
                                <label><h4>Хичээлийн код</h4></label>
                                <input class="form-control" name="hicheel_code" value="" id="code" placeholder="Хичээлийн код">
                            </div>
                             <div class="form-group">
                                <label><h4>Шалгалтын асуултын утга</h4></label> <br>
                                <label><h5>Асуултын хариултын тоо</h5></label>
                                <select id="varint" id="count" class="form-control">
                                    <option value="2">2
                                    <option value="3">3
                                    <option value="4">4
                                    <option value="5">5
                                </select>
                                <label><h5>Шалгалт авах асуултын тоо</h5></label>
                                <select onchange="table()" name="count" id="count" class="form-control">
                                    <option value="5">5
                                     <option value="10">10
                                    <option value="15">15
                                    <option value="30">30
                                </select>
                                <label><h5>Шалгалтын сорил</h5></label>  
                                <select name="soril" id="soril" class="form-control">
                                    <option value="1">сорил-1                            
                                    <option value="2">сорил-2
                                    <option value=" 3">сорил-3  
                                </select>
                                
                            </div>

                           <div id="page-wrap">
                
                                <center>
                                    <label><h3>Асуултын хариулт сонгох</h3></label>
                                             <div id="table">  
                                    </div>
                                </center>
                        
                                 </div>
                            <button type="submit" class="btn btn-primary" name = "save">Хадгалах</button>
                            <button type="reset" class="btn btn-primary">Шинэчлэх</button>
                        </form>
                                           
                      </div>
               


                    <div class="col-lg-6">
                    <h2>Үүссэн шалгалтын хүснэгт</h2
                    <div class="table-responsive">
                    <?php
                       
                        #$sql = "SELECT hicheel_ner, hicheel_code, action, bagsh_id FROM hicheel_info";
                        #$sql1 = "SELECT hicheel_ner, hicheel_code, action, bagsh_id FROM `hicheel_info` group by `hicheel_ner`, `hicheel_code`, `action`, `bagsh_id`";
                          $sql1 ="SELECT l.hicheel_name as hicheel_ner, h.hicheel_code,  h.action, h.bagsh_id FROM `hicheel_info`  as h left join lesson as l on  l.hicheel_code=h.hicheel_code
group by l.hicheel_name, h.hicheel_code,  h.action, h.bagsh_id";
                        $result =$DBcon->query($sql1) or die("aldaa");
                        $mur_count = $result->num_rows;
                                
                                 if ($result->num_rows > 0) 
                                 {
                                      echo "<table ><tr><th>Хичээлийн дугаар</th><th>Хичээл нэр</th><th>Хичээл код</th><th>Сорил</th><th>Засах</th></tr>";
                                      // output data of each row
                                      $a=0;
                                      while($row = $result->fetch_assoc()) 
                                      {
                                         $a = $a+1;
                                         
                                         if($row['bagsh_id'] == $id)
                                          {  
                                            if($row["action"])
                                             echo "<tr><td>" . $a. "</td><td>" . $row["hicheel_ner"]. "</td><td>" . $row["hicheel_code"]. "</td><td>".$row["action"]."</td><td><a href='tables.php?lesid=".$row["hicheel_code"]."&act=".$row["action"]."'>Засах хэсэг</td></tr>" ;
                                            
                                          }

                                      }
                                      echo "</table>";
                                 } 
                                 else 
                                 {  
                                      echo "Ямар нэгэн шалгалт үүсгээгүй байна.";
                                 }

                        $DBcon->close();
                        ?>   
                        </div>
                    </div>
                <!-- /.row -->
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    
</body>

</html>
<script>
function table1() 
  {
       var x = document.getElementById("lesson").value;
       document.getElementById("code").value = x;
  }
  function table() 
  {
 
    var count =document.getElementById('count').value;
    var varint = document.getElementById('varint').value;
    $.post("listing.php",
        {
            count:count,
            varint:varint
        },
        function(data)
        {
            document.getElementById("table").innerHTML=data;
        }
    )
    
 }
 </script>
