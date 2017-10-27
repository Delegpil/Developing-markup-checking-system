
<?php 
 //download.php page code
 //THIS PROGRAM WILL FETCH THE RESULT OF SQL QUERY AND WILL DOWNLOAD IT. (IF YOU HAVE ANY QUERY CONTACT:rahulpatel541@gmail.com)
//include the database file connection
include_once('database.php');
//will work if the link is set in the indx.php page
if(isset($_GET['name']))
{
    $name=$_GET['name']; //to rename the file
    header('Content-Disposition: attachment; filename='.$name.'.xls'); 
    header('Cache-Control: no-cache, no-store, must-revalidate, post-check=0, pre-check=0');
    header('Pragma: no-cache');
    header('Content-Type: application/x-msexcel; charset=windows-1251; format=attachment;');
    $msg="";
    $var="";
    //write your query      
    $sql="select * from tablename";
    $res = mysql_query($sql);
    $numcolumn = mysql_num_fields($res); //will fetch number of field in table
    $msg="<table><tr><td>Sl No</td>";
    for ( $i = 0; $i < $numcolumn; $i++ ) {
        $msg.="<td>";
        $msg.= mysql_field_name($res, $i);  //will store column name of the table to msg variable
        $msg.="</td>";

    }
    $msg.="</tr>";
    $i=0;
    $count=1; //used to print sl.no
    while($row=mysql_fetch_array($res))  //fetch all the row as array
    {

        $msg.="<tr><td>".$count."</td>";
        for($i=0;$i< $numcolumn;$i++)
        {
            $var=$row[$i]; //will store all the values of row 
            $msg.="<td>".$var."</td>";
        }
        $count=$count+1;
        $msg.="</tr>";
    }

    $msg.="</table>";
    echo $msg;  //will print the content in the exel page
}
?>

<?php
          
            //index.php page
            $name="any file name";
            echo "<a href='download.php?name=".$name."'>Click tto download</a>"; //link to download file
?>