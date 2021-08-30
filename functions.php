<?php

function adminsqlconnectioninfo()
{

   global $adminserver, $admindatabase, $adminlogin, $adminpassword;  

   $lines = file('http://157.56.177.187:81/connections/admin.txt');
   $server = str_replace(array("\n", "\r"), '', $lines[0]);
   $database = str_replace(array("\n", "\r"), '', $lines[1]);
   $login = str_replace(array("\n", "\r"), '', $lines[2]);
   $password = str_replace(array("\n", "\r"), '', $lines[3]);

}

function sqlconnection()
{

   global $server, $database, $login, $password;  
   $serverName = $server; //serverName\instanceName
   $connectionInfo = array( "Database"=>$database, "UID"=>$login, "PWD"=>$password);
   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
   }

   $sql = "{call user_login(?, ?, ?, ? )}"; 
   $networkid=$_POST["login"];
   $password=$_POST["password"];
   $returnval=0;
   $returnval2=0;
   $params = array(
                   array($networkid, SQLSRV_PARAM_IN),
                   array($password, SQLSRV_PARAM_IN),
                   array(&$returnval, SQLSRV_PARAM_OUT),
                   array(&$returnval2, SQLSRV_PARAM_OUT)
                  );
   $stmt = sqlsrv_query( $conn, $sql, $params );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   if ($returnval==2)
   {
      $_SESSION["badlogin"]="Y"; 

      header("Location: login.php");
      exit;
   }

   $_SESSION["login"]=$returnval2;

   sqlsrv_free_stmt( $stmt);
 
}

?>
