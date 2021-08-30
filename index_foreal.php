<?PHP //set login of user

session_start();

if(isset($_POST["login"]))
{

   $serverName = "OnFire"; //serverName\instanceName
   $connectionInfo = array( "Database"=>"OnFire_Prod", "UID"=>"OnFire", "PWD"=>"OnFire");
   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
   }

   $sql = "exec onfire.getloginid '".$_POST["login"]."'";
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $_SESSION["login"]=$row['id'];
   }

   sqlsrv_free_stmt( $stmt);
}

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/onfirestyle.css">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
</head>
<body>

<div id="logo"><img src="/images/firemanco-logo-transparent-white.png"></div>

<div id="verticalgap"></div>

<form action="index_foreal.php" method="post">
<input type="text" name="question"><br><br>
<input type="Submit" value="Ready">
</form>

<div id="verticalgap"></div>

<?PHP

require 'd:/composer/vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->build();

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

$params = [
    'index' => 'onfire',
    'body'  => [
        'query' => [
            'match' => [
                 'question' => [
                     'query' => $questionset,
                     'fuzziness' => 2,
                     'prefix_length' => 1
                ]
            ]
        ]
    ]
];

$results = $client->search($params);

$hits = $results['hits']['total']['value'];

if ($hits != "[ ]")
{

//$hits = $results['hits']['total']['value'];
$id = $results['hits']['hits'][0]['_id'];
$question = $results['hits']['hits'][0]['_source']['question'];
$answertypeid = $results['hits']['hits'][0]['_source']['answertypeid'];
$singleanswer = $results['hits']['hits'][0]['_source']['singleanswer'];
$sqlquery = $results['hits']['hits'][0]['_source']['sqlquery'];
$columnnumber = $results['hits']['hits'][0]['_source']['columnnumber'];
//$questionchild = $results['hits']['hits'][0]['_source']['questionchild'];

/*remove all of this eventually
print_r($hits);
echo "<br>";
print_r($id);
echo "<br>";
print_r($question);
echo "<br>";
print_r($answertypeid);
echo "<br>";
print_r($singleanswer);
echo "<br>";
print_r($sqlquery);
echo "<br>";
print_r($columnnumber);
echo "<br>";*/

//get information for the primary question
$serverName = "OnFire"; //serverName\instanceName
$connectionInfo = array( "Database"=>"OnFire_Prod", "UID"=>"OnFire", "PWD"=>"OnFire");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn === false) {
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

$sql = "onfire.getquestionanswerinformation $id";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
$questionanswerinformation=$row['information'];
}

sqlsrv_free_stmt( $stmt);

if($answertypeid == 2)
{

   echo "<div id=questiontext>";
   echo "You asked: ".$questionset;
   echo "</div>";

   echo "<div id=questiontext2>";
   echo "Question: $question";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   echo "<div id=questiontext>";
   echo "<th>$singleanswer</th>";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   echo '<form action="onfirequestioninformation.php" method="post"><input type="hidden" name="question" value="'.$question.'"><input type="hidden" name="information" value="'.$questionanswerinformation.'"><input type="Submit" value="Information"></form>';

} //end of if($answertypeid == 2)

elseif($answertypeid == 4)
{

   echo "<div id=questiontext>";
   echo "You asked: ".$questionset;
   echo "</div>";

   echo "<div id=questiontext2>";
   echo "Question: $question";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   echo "<div id=imageanswer>";
   echo "<img src=/images/MyAccountsReceivable.jpg></div>";

   echo "<div id=verticalgap></div>";

   echo '<form action="onfirequestioninformation.php" method="post"><input type="hidden" name="question" value="'.$question.'"><input type="hidden" name="information" value="'.$questionanswerinformation.'"><input type="Submit" value="Information"></form>';

} //end of if($answertypeid == 4)

elseif($answertypeid == 5)
{

   echo "<div id=questiontext>";
   echo "You asked: ".$questionset;
   echo "</div>";

   echo "<div id=questiontext2>";
   echo "Question: $question";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   echo "<div id=questiontext2>";
   echo "Client History and Information";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   $id=16;
   $sqlquery="exec bd.getclientinformation '000090'";
   $columnnumber=3;

   echo "<table class=center>";
   echo "<tr>";

   $serverName = "OnFire"; //serverName\instanceName
   $connectionInfo = array( "Database"=>"OnFire_Prod", "UID"=>"OnFire", "PWD"=>"OnFire");
   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
   }

   $sql = "exec onfire.getquestionanswercolumns $id";
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   echo "<th>".$row['columnheader']."</th>";
   ${'column'.$row['columnorder']} = $row['columnname']; //dynamic variable name generation
   }

   //sqlsrv_free_stmt( $stmt);

   echo "</tr>";


   $sql = "$sqlquery"; //from elasticsearch index
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

      $rowgenerate = 1;

      echo "<tr>";

      while ($rowgenerate < $columnnumber+1)
      {
         echo "<td>";
         echo $row[${'column'.$rowgenerate}]; //uses dynamic variable value of column name from query
         echo "</td>";
         $rowgenerate++;
      }
   
      echo "</tr>";
   }

   sqlsrv_free_stmt( $stmt);
   echo "</table>";

   echo "<div id=verticalgap></div>";

   echo "<div id=questiontext2>";
   echo "Financial Snapshot";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   $id=18;
   $sqlquery="exec bd.getclientfinancialsnapshot '000090'";
   $columnnumber=7;

   echo "<table class=center>";
   echo "<tr>";

   $serverName = "OnFire"; //serverName\instanceName
   $connectionInfo = array( "Database"=>"OnFire_Prod", "UID"=>"OnFire", "PWD"=>"OnFire");
   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
   }

   $sql = "exec onfire.getquestionanswercolumns $id";
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   echo "<th>".$row['columnheader']."</th>";
   ${'column'.$row['columnorder']} = $row['columnname']; //dynamic variable name generation
   }

   //sqlsrv_free_stmt( $stmt);

   echo "</tr>";


   $sql = "$sqlquery"; //from elasticsearch index
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

      $rowgenerate = 1;

      echo "<tr>";

      while ($rowgenerate < $columnnumber+1)
      {
         echo "<td>";
         echo $row[${'column'.$rowgenerate}]; //uses dynamic variable value of column name from query
         echo "</td>";
         $rowgenerate++;
      }
   
      echo "</tr>";
   }

   sqlsrv_free_stmt( $stmt);
   echo "</table>";

   echo "<div id=verticalgap></div>";

   echo "<div id=questiontext2>";
   echo "Top Attorneys By Hours Worked";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   $id=19;
   $sqlquery="exec bd.getclienttopattorneyhoursworkedyearly '000090'";
   $columnnumber=6;

   echo "<table class=center>";
   echo "<tr>";

   $serverName = "OnFire"; //serverName\instanceName
   $connectionInfo = array( "Database"=>"OnFire_Prod", "UID"=>"OnFire", "PWD"=>"OnFire");
   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
   }

   $sql = "exec onfire.getquestionanswercolumns $id";
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   echo "<th>".$row['columnheader']."</th>";
   ${'column'.$row['columnorder']} = $row['columnname']; //dynamic variable name generation
   }

   //sqlsrv_free_stmt( $stmt);

   echo "</tr>";


   $sql = "$sqlquery"; //from elasticsearch index
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

      $rowgenerate = 1;

      echo "<tr>";

      while ($rowgenerate < $columnnumber+1)
      {
         echo "<td>";
         echo $row[${'column'.$rowgenerate}]; //uses dynamic variable value of column name from query
         echo "</td>";
         $rowgenerate++;
      }
   
      echo "</tr>";
   }

   sqlsrv_free_stmt( $stmt);
   echo "</table>";

   echo "<div id=verticalgap></div>";

   echo "<div id=questiontext2>";
   echo "Recently Opened Matters";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   $id=23;
   $sqlquery="exec bd.getclientrecentlyopenedmatters '000090'";
   $columnnumber=9;

   echo "<table class=center>";
   echo "<tr>";

   $serverName = "OnFire"; //serverName\instanceName
   $connectionInfo = array( "Database"=>"OnFire_Prod", "UID"=>"OnFire", "PWD"=>"OnFire");
   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
   }

   $sql = "exec onfire.getquestionanswercolumns $id";
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   echo "<th>".$row['columnheader']."</th>";
   ${'column'.$row['columnorder']} = $row['columnname']; //dynamic variable name generation
   }

   //sqlsrv_free_stmt( $stmt);

   echo "</tr>";


   $sql = "$sqlquery"; //from elasticsearch index
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

      $rowgenerate = 1;

      echo "<tr>";

      while ($rowgenerate < $columnnumber+1)
      {
         echo "<td>";
         echo $row[${'column'.$rowgenerate}]; //uses dynamic variable value of column name from query
         echo "</td>";
         $rowgenerate++;
      }
   
      echo "</tr>";
   }

   sqlsrv_free_stmt( $stmt);
   echo "</table>";

   echo "<div id=verticalgap></div>";

   echo "<div id=questiontext2>";
   echo "Accounts Receivable";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   echo "<div id=imageanswer>";
   echo "<img src=/images/MyAccountsReceivable.jpg></div>";

   echo "<div id=verticalgap></div>";

   //echo '<form action="onfirequestioninformation.php" method="post"><input type="hidden" name="question" value="'.$question.'"><input type="hidden" name="information" value="'.$questionanswerinformation.'"><input type="Submit" value="Information"></form>';

} //end of if($answertypeid == 5)

elseif($answertypeid == 3)
{

   echo "<div id=questiontext>";
   echo "You asked: ".$questionset;
   echo "</div>";

   echo "<div id=questiontext2>";
   echo "Question: $question";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   echo "<table class=center>";
   echo "<tr>";

   $serverName = "OnFire"; //serverName\instanceName
   $connectionInfo = array( "Database"=>"OnFire_Prod", "UID"=>"OnFire", "PWD"=>"OnFire");
   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
   }

   $sql = "exec onfire.getquestionanswercolumns $id";
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   echo "<th>".$row['columnheader']."</th>";
   ${'column'.$row['columnorder']} = $row['columnname']; //dynamic variable name generation
   }

   //sqlsrv_free_stmt( $stmt);

   echo "</tr>";


   $sql = "$sqlquery"; //from elasticsearch index
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

      $rowgenerate = 1;

      echo "<tr>";

      while ($rowgenerate < $columnnumber+1)
      {
         echo "<td>";
         echo $row[${'column'.$rowgenerate}]; //uses dynamic variable value of column name from query
         echo "</td>";
         $rowgenerate++;
      }
   
      echo "</tr>";
   }

   sqlsrv_free_stmt( $stmt);
   echo "</table>";

   echo "<div id=verticalgap></div>";

   echo '<form action="onfirequestioninformation.php" method="post"><input type="hidden" name="question" value="'.$question.'"><input type="hidden" name="information" value="'.$questionanswerinformation.'"><input type="Submit" value="Information"></form>';


   
} //end of elseif($answertypeid == 3)





//did you mean section

echo "<div id=verticalgap></div>";

echo "<table id=tabledidyou class=center>";
echo "<tr>";
echo "<th>Did you mean?</th>";
echo "</tr>";

$tablegenerate = 1;

if($hits>10)
{
  $hits2=10;
}
else
{
  $hits2=$hits;
}

while($tablegenerate < $hits2) {

   $question=$results['hits']['hits'][$tablegenerate]['_source']['question'];
   $questionurl=str_replace(' ', '+', $question);

   echo "<tr><td><a href=http://157.56.177.187:81/index_foreal.php?question2=$questionurl>$question</a></td</tr>";
   $tablegenerate++;

}

echo "</table>";

//end of did you mean section

//insert question asked and top hit into history

$serverName = "OnFire"; //serverName\instanceName
   $connectionInfo = array( "Database"=>"OnFire_Prod", "UID"=>"OnFire", "PWD"=>"OnFire");
   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
   }

   $questionsetproc = str_replace("'", "''", $questionset); //replace single ticks with two ticks for SQL insert

   $sql = "exec onfire.questionaskedhistory '$questionsetproc', $id, ".$_SESSION["login"];
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   sqlsrv_free_stmt( $stmt);

//end of insert question asked

} //end of if ($hits != "[ ]")
else
{
   echo "<div id=questiontext>";
   echo "No results found for your question '$questionset'";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   echo "<div id=questiontext2>";
   echo "Some example questions in the system";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   echo "<table class=center>";
   echo "<tr><th>Example Questions</th></tr>";

   $serverName = "OnFire"; //serverName\instanceName
   $connectionInfo = array( "Database"=>"OnFire_Prod", "UID"=>"OnFire", "PWD"=>"OnFire");
   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
   }

   $sql = "exec onfire.questionanswerrandom";
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $questionurl=str_replace(' ', '+', $row['question']);
      echo "<tr><td><a href=http://157.56.177.187:81/index_foreal.php?question2=$questionurl>".$row['question']."</a></td></th></tr>";
   }

   sqlsrv_free_stmt( $stmt);

   echo "</table>";

   $serverName = "OnFire"; //serverName\instanceName
   $connectionInfo = array( "Database"=>"OnFire_Prod", "UID"=>"OnFire", "PWD"=>"OnFire");
   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
   }

   $questionsetproc = str_replace("'", "''", $questionset); //replace single ticks with two ticks for SQL insert

   $sql = "exec onfire.questionaskedhistory '$questionsetproc', 0, ".$_SESSION["login"];
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true));
   }

   sqlsrv_free_stmt( $stmt);


} //end of else from if ($hits != "[ ]")

} //end of if(isset($questionset))

?>

</body>

