
 <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="add" class="modal fade" style="display: none;">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                          <h4 class="modal-title">Add account</h4>

                                      </div>
                                      <div class="modal-body">

                                          <form action="" method="post" role="form" class="form-horizontal"><!--  FROM action -->
                                              <div class="form-group">
                                                  <label class="col-lg-2 control-label" >И-мэйл</label>
                                                  <div class="col-lg-10">
                                                      <input type="email" placeholder="" name="email" class="form-control">
                                                  </div>
                                              </div>

                                              <div class="form-group">
                                                  <label class="col-lg-2 control-label">Нууц үг</label>
                                                  <div class="col-lg-10">
                                                      <input type="password" placeholder="" name="password" class="form-control">
                                                  </div>
                                              </div>

                                               
                                          

                                              <div class="form-group">
                                                  <div class="col-lg-offset-2 col-lg-10">
                                                      
                                                      <button class="btn btn-send" type="submit" name="add">Нэмэх</button>
                                                  </div>
                                              </div>
                                          </form>
    
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->
<?php
if (!isset($_SESSION['userSession'])) {
  header("Location: login.php");
}

set_time_limit(4000); 
 require_once 'dbconnect.php';


 if (isset($_POST['add'])){
 $mail =strip_tags($_POST['email']);
 $pass=strip_tags($_POST['password']);
 $mail = $DBcon->real_escape_string($mail);
 $pass = $DBcon->real_escape_string($pass);


$imapPath = '{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX';
$username = $mail;
$password = $pass;

//$inbox = imap_open($imapPath,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
/*
$connect_to = '{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX';
$user1 = $mail;
$password1 = $pass;
*/
if($inbox = imap_open($imapPath,$username,$password)){
  $id=$_SESSION['userSession'];
  $check_email = $DBcon->query("SELECT email FROM account WHERE user_id =$id and email='$mail'");
  $count=$check_email->num_rows;
  
  if ($count==0) {
    

    //$query = "INSERT INTO account1 (email, password) VALUES ('aaaa','aaaaa')";
    $query = "INSERT INTO account (email, password, user_id) VALUES ('$username', '$password', '$id')";
      //$DBcon->query($query);
      if ($DBcon->query($query)) {

      $msg = "<div class='alert alert-success'>
            <span class='glyphicon glyphicon-info-sign'></span> &nbsp; <b>".$mail."</b> гэсэн И-мэйл хаяг аккаунтын жагсаалтанд бүртгэгдлээ !
          </div>";

         // echo $msg;
       //  header("Location: /mbox/index.php");
        //  echo '<script language="javascript">';
       //   echo 'alert("Та амжилттай бүртгэгдлээ !")';
         // echo '</script>';
          
             }

            
      else {
        //printf("Errormessage: %s\n", $DBcon->error);
        //echo $DBcon->error;
        $msg = "<div class='alert alert-danger'>
                  <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Бүртгэх явцад алдаа гарлаа !
                </div>";
        //echo "Бүртгэх явцад алдаа гарлаа!";
       //  header("Location: /mbox/index.php");
        // echo '<script language="javascript">';
         // echo 'alert("Бүртгэх явцад алдаа гарлаа!!")';
         // echo '</script>';
              
       // header("Location: index.php");
            
       }  

   }
       else{

            //  echo " Уучлаарай мэйл хаяг давхацаж байна !";
              //header("Location: index.php");
        // header("Location: /mbox/index.php");
         // echo '<script language="javascript">';
         // echo 'alert("Уучлаарай мэйл хаяг давхацаж байна !")';
          //echo '</script>';
        $msg = "<div class='alert alert-danger'>
                  <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Уучлаарай мэйл хаяг давхацаж байна !
                </div>";
          
       }



}

else{
  //echo('Cannot connect to Gmail: ' . imap_last_error());
  // header("Location: /mbox/index.php");
    $msg = "<div class='alert alert-danger'>
                  <span class='glyphicon glyphicon-info-sign'></span> &nbsp;И-мэйл эсвэл нууц үг буруу байна !
                </div>";
    //  echo "И-мэйл эсвэл нууц үг буруу байна !";
    //// echo '<script language="javascript">';
    //      echo 'alert("И-мэйл эсвэл нууц үг буруу байна !")';
     //     echo '</script>';
     //     

}

//imap_expunge($inbox);
imap_close($inbox);
//$DBcon->close();
// header("Location: /mbox/index.php");
}
?>