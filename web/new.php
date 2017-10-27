<?php
 function renderForm($user, $rank, $position, $error)
 {
?>
 <?php 
 if ($error != '')
 {
 echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
 }
 ?> 
<form action="" method="post">
  <div class="form-group">
    <label for="username">Оюутны шифр</label>
    <input id="username" class="form-control" type="text" name="user" placeholder="Оюутны шифр" value="<?php echo $user; ?>" />
  </div>

  <div class="form-group">
    <label for="position">Явцын сорил</label>
    <input id="position" class="form-control" type="text" name="position" placeholder="Явцын сорил" value="<?php echo $position; ?>" />
  </div>
   <div class="modal-footer">
    <button type="submit" class="btn btn-primary" name="save" value="Submit">Хадгалах</button>
     <input type="submit" class="btn btn-default" name="" data-dismiss="modal" value="Буцах"/>
  </div>
</form>
<?php 
}


 if (isset($_POST['submit']))
 { 

 $user = mysql_real_escape_string(htmlspecialchars($_POST['user']));
 $rank = mysql_real_escape_string(htmlspecialchars($_POST['rank']));
 $position = mysql_real_escape_string(htmlspecialchars($_POST['position']));
 $date = mysql_real_escape_string(htmlspecialchars($_POST['date']));
 $tag = mysql_real_escape_string(htmlspecialchars($_POST['tag']));
 $ait = mysql_real_escape_string(htmlspecialchars($_POST['ait']));
 $ss = mysql_real_escape_string(htmlspecialchars($_POST['ss']));
 $notes = mysql_real_escape_string(htmlspecialchars($_POST['notes']));

 if ($user == '' || $rank == '' || $date == '' || $tag == '')
 {
 $error = '<center>ERROR: Please fill in all required fields!</center>';

 @renderForm($user, $rank, $position, $error);
 }
 else
 {
 mysql_query("INSERT players SET user='$user', rank='$rank', position='$position', date='$date', tag='$tag', ait='$ait', ss='$ss', notes='$notes'")
 or die(mysql_error()); 

 }
 }
 else

 {
 @renderForm('','','');
 }?>