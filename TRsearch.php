<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/onfirestyle.css">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
</head>
<body>

<div id="logo"><img src="/images/firemanco-logo-transparent-white.png"></div>


<div id="verticalgap"></div>

<form action="TRsearch.php" method="post">
<input type="text" name="question"><br><br>
<input type="Submit" value="Search">
</form>

<?PHP

if(isset($_POST["question"]))
{
    
   $questionset=$_POST["question"];   

   echo "<div id=verticalgap></div>";
   
   echo "<table class=center>";
   echo "<tr><th>Docket Number</th><th>Title</th><th>Date Filed</th><th>Judge</th></tr>";

   $serverName = "OnFire"; //serverName\instanceName
   $connectionInfo = array( "Database"=>"TRLitigation", "UID"=>"OnFire", "PWD"=>"OnFire");
   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
   }

   $sql = "exec trlitigation.search '$questionset'";
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   echo "<tr>";

   echo "<td>".$row['docketnumber']."</td><td>".$row['title']."</td><td>".$row['filingdate']."</td><td>".$row['name']."</td><td><a href=TRview.php?jkey4=".$row['jkey4'].">view</a></td>";

   echo "</tr>";
   }

   sqlsrv_free_stmt( $stmt);
   echo "</table>";

}

?>




