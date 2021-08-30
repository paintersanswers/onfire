<table>
<?PHP
$serverName = "OnFire"; //serverName\instanceName
$connectionInfo = array( "Database"=>"OnFire", "UID"=>"OnFire", "PWD"=>"OnFire");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn === false) {
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

$sql = "select client_id, client_name, convert(varchar, convert(date, open_date)) open_date from finance.client";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      echo "<tr><td>".$row['client_id']."</td><td>".$row['client_name']."</td><td>".$row['open_date']."</td</tr>";
}

sqlsrv_free_stmt( $stmt);

?>