<?php
 
    require_once "../../sql_connect.php";
    session_start();
    if( !isset($_SESSION["username"]) || !isset($_SESSION["usertype"]) || $_SESSION["usertype"]!= "faculty" )
    {
        header("Location: ../../index.php");
    }


    extract($_POST);
   
    $SQL = "SELECT usn, marks FROM quiz_student WHERE quiz_id=" . $quiz_id;
    $header = '';
    $result ='';
    $exportData = mysql_query ($SQL ) or die ( "Sql error : " . mysql_error( ) ); 
    $fields = mysql_num_fields ( $exportData );
 
    for ( $i = 0; $i < $fields; $i++ )
    {
        $header .= mysql_field_name( $exportData , $i ) . "\t";
    }
     
    while( $row = mysql_fetch_row( $exportData ) )
    {
        $line = '';
        foreach( $row as $value )
        {                                            
            if ( ( !isset( $value ) ) || ( $value == "" ) )
            {
                $value = "\t";
            }
            else
            {
                $value = str_replace( '"' , '""' , $value );
                $value = '"' . $value . '"' . "\t";
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
    header("Content-type: application/vnd.ms-excel; name='excel'");
    header("Content-Disposition: attachment; filename=". $_POST["quiz_name"]);
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n$result";

?>