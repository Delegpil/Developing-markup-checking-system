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


   if(isset($_POST['ustgah']))
   {
        $students_id = $_POST['id'];
        $student_image = $_POST['image'];
        $student_cipher = $_POST['cipher'];
        $student_soril =  $_POST['soril'];
       /* $sql = 'DELETE FROM students
        WHERE id=".$students_id."';
       */ 
        $retval = $DBcon->query("DELETE FROM students WHERE id=".$students_id."");

        $retval1 = $DBcon->query("DELETE FROM student_answer WHERE image_name='".$student_image."' and cipher='".$student_cipher."' and soril='".$student_soril."'");
        
        if(! $retval )
        {
          die('Could not delete data: ' . mysql_error());
        }
        echo  '<div class="alert alert-success">
                        <strong>&nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbsp&nbsp &nbsp &nbspАмжилттай устгагдлаа!!! </strong> </div>';
        //echo "Deleted data successfully\n";
        mysql_close($DBcon);
   }
   else
   {
    /*echo "a";*/
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  
    <script type="text/javascript">
    setInterval(function() {
    $.get('update.php', function() {
      //do something with the data
    /*  alert('Load was performed.');*/
    });
      }, 1000);


    </script>


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
                 <!--    <li>
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
                            Шалгалт засах
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Эхлэх</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-table"></i> Шалгалт засах
                            </li>
                        </ol>
                    </div>
                </div>
               
                 <form action="export.php" method="post" >
                  <?php
                   if(isset($_GET['act'])){
                                            $act  =$_GET['act'];
                                            $lesid = $_GET['lesid'];
                                        } 
                  ?>
                     <input type="hidden" name="code" value="<?php echo $lesid; ?>">  
                    <input type="hidden" name="soril" value="<?php echo $act; ?>"> 
               <div>
                <button type="submit" id="export" name="export" class="btn btn-info button-loading" data-loading-text="Loading...">Шалгалтын материал татах</button>
                           <?php                 
                               echo  "<a type='button' class='btn btn-success' href='charts.php?lesid=".$lesid."&cipher=".$act."'>Шалгалтын статистик</a>";
                 
                           ?>
                                          
               </div>
                </form> 
             
                <div class="row">
                    <div class="col-lg-8">
                     
                        <div class="table-responsive">

                            <table >
                                <thead>
                                    <tr>
                                        <th>Оюутны шифр</th>
                                        <th>Авах оноо</th>
                                        <th>Авсан оноо</th>
                                        <th>Явцын сорил</th>
                                        <th>Шалгалтыг зассан/засаагүй</th>
                                        <th>Сурагчийн тестийн зураг</th>
                                        <th>Материал шалгах</th>
                                        <th>Оюутан мэдээлэл</th>
                                   
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if(isset($_GET['lesid']))
                                    {
                                       
                                        $lesid= $_GET['lesid'];
                                        echo "<h2>$lesid</h2>";
                                        $soril= $_GET['act'];
                                  
                                        $que= $DBcon->query("SELECT * FROM `students` Where hicheel_code='$lesid' and soril='$soril' ORDER BY `hicheel_code` ASC") or die($DBcon->connect_error);
                                        $query12 = $DBcon->query("SELECT onoo FROM `hicheel_info` Where `hicheel_code`='$lesid' and action='$soril'");
                                         $onoo = $query12->fetch_array();

                                        while ($rows = $que->fetch_assoc()) 
                                        {
                                    
                                                                                  
                                        ?>
                                        <tr>
                                        <?php 
                                        if(isset($_GET['act'])){
                                            $act  =$_GET['act'];
                                        }
                                        ?>
                                           <form action="" method="post">
                                                
                                                <td id="<?php echo $rows['id'] ?>_point"><?php echo $rows['cipher'];?></td>
                                                <td ><?php echo $onoo['onoo'];?></td>
                                                <td ><?php echo $rows['awsan_onoo'];?></td>
                                                <td id="<?php echo $rows['id'] ?>_soril"><?php echo $rows['soril'];?></td>
                                                <td><?php echo $rows['zassan'] ?></td>    

                                                <td id="<?php echo $rows['id'] ?>_image"><?php echo $rows['image_path'];?></td>

                                                <input type="hidden" name="hicheel_code" value="<?php echo $lesid; ?>">  
                                                <input type="hidden" name="soril" value="<?php echo $act; ?>"> 
                                                <input type="hidden" name="image" value="<?php echo $rows['image_path'] ?>"> 
                                                <input type="hidden" name="cipher" value="<?php echo $rows['cipher'];?>">
                                                <input type="hidden" name="awsan_onoo" value="<?php echo $rows['awsan_onoo'];?>">
                                                <input type="hidden" name="id" value="<?php echo $rows['id'];?>">
                                                 
                                                     <?php 
                                                echo "<td><center><a href='oyutan.php?lesid=".$rows['hicheel_code']."&cipher=".$rows['cipher']."&soril=".$rows['soril']."&image=".$rows['image_path']."'>Үзэх </a></center></td>";
                                                    ?>
                                          
            
                                               <td style="width: 150">
                                  
                                               <center>
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" onclick="wtf(<?php echo $rows['id'] ?>)" data-target="#myModal"><span class="glyphicon glyphicon-pencil"></span></button>
                                                <button onclick="return deleletconfig()" class="btn btn-sm btn-danger" data-title="Delete" name="ustgah" data-target="#myModal" ><span class="glyphicon glyphicon-trash"></span></button>
                                                </center>
                                             </td>
                                        </tr>
                                        </form>
                                        <!-- Modal -->
                                          <div class="modal fade" id="myModal" role="dialog">
                                         
                                            <div class="modal-dialog">
                                          
                                              <!-- Modal content-->
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  <h3 class="modal-title">Засах хэсэг</h3>
                                                </div>

                                            <form action="tables.php?lesid=<?php echo $lesid ?>&act=<?php echo $act ?>" method="GET">
                                                <div class="modal-body">

                                                    <h4>Оюутны шифр</h4>    
                                                      <input Class="form-control" id="ciph" name="ciph" value="" placeholder="Шинэчлэх оюутны шифр">
                                                </div>
                                                 <div class="modal-body">
                                                   <h4>Явцын сорил</h4>
                                                      <input class="form-control"  id="editcipher" name="sori" value=""  placeholder="Явцын сорил">
                                                </div>
                                                  <div class="modal-body">      
                                                      <input type ="hidden" id="image" name="image" value="">
                                                  </div>
                  
                                                <div class="modal-footer">
                                                 <input type="button" name="save_data" class="btn btn-primary" onclick="dandar();"  value="Хадгалах"/>
                                          <!--      <a href='tables.php?lesid=<?php echo $lesid ?>&act=<?php echo $act ?>'>засах</a> 
                                           -->        <input type="button" class="btn btn-default"  data-dismiss="modal" value="Буцах"/>                   
                                                </div>
                                            </form>

                                              </div>
                                              
                                            </div>
                                          
                                            </div>
                                          </div>
  
                                        
                                       <?php  
                                            }
                                        }
                                        ?>                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>

    </div>

    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
<script type="text/javascript">
    function wtf(id) 
    {
        var sda = document.getElementById(id+'_point').innerHTML;
        var sda1 = document.getElementById(id+'_soril').innerHTML;
        var sda2=document.getElementById(id+'_image').innerHTML;
        document.getElementById("editcipher").value=sda1;
        document.getElementById("ciph").value=sda;

        document.getElementById("image").value=sda2;
        
    }
    function dandar(){
      var d=document.getElementById("editcipher").value;
      var as=document.getElementById("ciph").value;
      var img = document.getElementById("image").value;
      $.post("listing.php",
        {
            soril:d,
            ciph:as,
            img:img
        },
        function(data)
        {
           /* alert(data);
*/
            location.reload();
        }
      )
    }
</script>
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


<script>
function deleletconfig(){

var del=confirm("Та устгахдаа итгэлтэй байна уу?");

return del;
}
</script>
