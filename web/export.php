<?php


 if(isset($_POST['export']))
   {

        $hicheel_code = $_POST['code'];
        $soril = $_POST['soril'];
        include 'db.php';
        mysql_query("SET NAMES 'utf8'");
        mysql_query("SET CHARACTER SET utf8");
        mysql_query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
        //$que= $DBcon->query("SELECT * FROM `students` Where hicheel_code='$student_hichel_code' and soril='$student_soril' ORDER BY `hicheel_code` ASC") or die($DBcon->connect_error);
      //  $SQL = "SELECT * FROM `students` Where hicheel_code='".$hicheel_code."' and soril='". $soril."' ORDER BY `hicheel_code` ASC";
        $SQL = "SELECT `cipher` as 'Oyutnii_cipher', `hicheel_code` as 'Hicheel code', `image_path` as 'Shablon_zurag', `zassan` as 'Zassan_eseh', `soril` as 'Soril' , `awsan_onoo` as 'Awsan onoo'FROM `students` Where hicheel_code='{$hicheel_code}' and soril='{$soril}' ORDER BY `hicheel_code` ASC";
        $header = '';
        $result ='';
       
        $exportData = mysql_query ($SQL ) or die ( "Sql error : " . mysql_error( ) );

        $fields = mysql_num_fields ( $exportData );
         
        for ( $i = 0; $i < $fields; $i++ )
        {
            $header .= mysql_field_name( $exportData , $i ) . "\t\t";
        }
         
        while( $row = mysql_fetch_row( $exportData ) )
        {
            $line = '';
            foreach( $row as $value )
            {         

                if ( ( !isset( $value ) ) || ( $value == "" ) )
                {
                    $value = "\t\t";
                }
                else
                {
                    $value = str_replace( '"' , '""' , $value );
                    $value = '"' . $value . '"' . "\t\t";
                }
                $line .= $value;
            }
            $result .= trim( $line ) . "\n";
        }
        $result = str_replace( "\r" , "" , $result );
         
        if ( $result == "" )
        {
            $result = "\nNo Record(s) Found!\n";                        
        }
         
    /*     header("Content-Type: text/html; charset=utf-8");
    */  header("Content-type: text/csv; charset=utf-8; encoding=UTF-8");
        header("Content-Disposition: attachment; filename=export.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$header\n$result";
    }
 
?>