<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/onfirestyle.css">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
</head>
<body>

<div id="logo"><img src="/images/firemanco-logo-transparent-white.png"></div>


<div id="verticalgap"></div>

<form action="index.php" method="post">
<input type="text" name="question"><br><br>
<input type="Submit" value="Ready">
</form>

<div id="verticalgap"></div>

<?PHP


if(isset($_POST["question"]))
{
  $questionset=$_POST["question"];
}
elseif(isset($_GET["question2"]))
{
  $questionset=$_GET["question2"];
}

if(isset($questionset))
{

if(strtolower($questionset) == "clients opened since last month")
{

echo "<div id=questiontext>";
echo "You asked: ".$questionset;
echo "</div>";

echo "<div id=questiontext2>";
echo "Question: What are our new clients since last month";
echo "</div>";

echo "<div id=verticalgap></div>";

echo "<table class=center>";
echo "<tr>";
echo "<th>Client ID</th><th>Client Name</th><th>Open Date</th>";
echo "</tr>";

$serverName = "OnFire"; //serverName\instanceName
$connectionInfo = array( "Database"=>"OnFire", "UID"=>"OnFire", "PWD"=>"OnFire");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn === false) {
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

$sql = "select client_id, client_name, convert(varchar, convert(date, open_date)) open_date from finance.client order by open_date";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      echo "<tr><td>".$row['client_id']."</td><td>".$row['client_name']."</td><td>".$row['open_date']."</td></tr>";
}

sqlsrv_free_stmt( $stmt);

echo "</table>";

echo "<div id=verticalgap></div>";

echo "<table id=tabledidyou class=center>";
echo "<tr>";
echo "<th>Did you mean?</th>";
echo "</tr>";
echo "<tr><td>Clients opened yesterday</td</tr>";
echo "<tr><td>Clients opened since last week</td</tr>";
echo "<tr><td>Clients opened this year</td</tr>";

echo "</table>";

}

elseif(strtolower($questionset) == strtolower("My Accounts Receivable"))
{

echo "<div id=questiontext>";
echo "You asked: ".$questionset;
echo "</div>";

echo "<div id=questiontext2>";
echo "Question: What is my current AR";
echo "</div>";

echo "<div id=verticalgap></div>";

echo "<div id=imageanswer>";
echo "<img src=/images/BOAAccountsReceivable.jpg></div>";

echo "<div id=verticalgap></div>";

echo "<table id=tabledidyou class=center>";
echo "<tr>";
echo "<th>Did you mean?</th>";
echo "</tr>";
echo "<tr><td>What is the AR for my practice</td</tr>";
echo "<tr><td>What is the AR for Matter 0004578.000078</td</tr>";
echo "<tr><td><a href=http://157.56.177.187:81/?question2=ar+for+bank+of+america>What is the AR for Bank of America Matters</a></td</tr>";

echo "</table>";

}

elseif(strtolower($questionset) == strtolower("AR for bank of america"))
{

echo "<div id=questiontext>";
echo "You asked: ".$questionset;
echo "</div>";

echo "<div id=questiontext2>";
echo "Question: What is the AR for Bank of America Matters";
echo "</div>";

echo "<div id=verticalgap></div>";

echo "<div id=imageanswer>";
echo "<img src=/images/MyAccountsReceivable.jpg></div>";

echo "<div id=verticalgap></div>";

echo "<table id=tabledidyou class=center>";
echo "<tr>";
echo "<th>Did you mean?</th>";
echo "</tr>";
echo "<tr><td><a href=http://157.56.177.187:81/?question2=my+accounts+receivable>What is my current AR</a></td</tr>";
echo "<tr><td>What is the AR for my practice</td</tr>";
echo "<tr><td>What is the AR for Matter 0004578.000078</td</tr>";


echo "</table>";

}

elseif(strtolower($questionset) == strtolower("My Billed Time"))
{

echo "<div id=questiontext>";
echo "You asked: ".$questionset;
echo "</div>";

echo "<div id=questiontext2>";
echo "Question: What is my billed time";
echo "</div>";

echo "<div id=verticalgap></div>";

echo "<div id=imageanswer>";
echo "<img src=/images/TimeBilled.jpg></div>";

echo "<div id=verticalgap></div>";

echo "<table id=tabledidyou class=center>";
echo "<tr>";
echo "<th>Did you mean?</th>";
echo "</tr>";
echo "<tr><td>What is my billed time for last year</td</tr>";
echo "<tr><td>What is my billed time compared to last year</td</tr>";
echo "<tr><td>What is my billed time for Wells Fargo</td</tr>";

echo "</table>";

}


if(strtolower($questionset) == strtolower("matters with judge Margaret Thinson"))
{

echo "<div id=questiontext>";
echo "You asked: ".$questionset;
echo "</div>";

echo "<div id=questiontext2>";
echo "Question: Who has worked matters with judge Margaret Thinson";
echo "</div>";

echo "<div id=verticalgap></div>";

echo "<table class=center>";
echo "<tr>";
echo "<th>Name</th><th>Title</th><th>Email</th><th>Phone</th>";
echo "</tr>";

$serverName = "OnFire"; //serverName\instanceName
$connectionInfo = array( "Database"=>"OnFire", "UID"=>"OnFire", "PWD"=>"OnFire");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn === false) {
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

$sql = "select name, title, email, phone from judge order by name";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      echo "<tr><td>".$row['name']."</td><td>".$row['title']."</td><td>".$row['email']."</td><td>".$row['phone']."</td></tr>";
}

sqlsrv_free_stmt( $stmt);

echo "</table>";

echo "<div id=verticalgap></div>";

echo "<table id=tabledidyou class=center>";
echo "<tr>";
echo "<th>Did you mean?</th>";
echo "</tr>";
echo "<tr><td>matter outcomes with judge Margaret Thinson</td</tr>";
echo "<tr><td>information on judge Margaret Thinson</td</tr>";

echo "</table>";

}

elseif(strtolower($questionset) == strtolower("WestLaw"))
{

echo "<div id=questiontext>";
echo "You asked: ".$questionset;
echo "</div>";

echo "<div id=questiontext2>";
echo "Question: Take me to WestLaw";
echo "</div>";

echo "<div id=verticalgap></div>";

echo "<div id=questiontext>";
echo "<th>Go To <a target=_blank href=https://legal.thomsonreuters.com/en/products/westlaw>Westlaw</a></th>";
echo "</div>";

echo "<div id=verticalgap></div>";

echo "<table id=tabledidyou class=center>";
echo "<tr>";
echo "<th>Did you mean?</th>";
echo "</tr>";
echo "<tr><td>Documentation for Westlaw</td</tr>";
echo "<tr><td>How do I get access to Westlaw</td</tr>";
echo "<tr><td>Do we have any other services like Westlaw</td</tr>";

echo "</table>";

}

}



?>


</body>

