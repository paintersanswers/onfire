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
$id = $results['hits']['hits'][0]['_id'];
$question = $results['hits']['hits'][0]['_source']['question'];
$answertypeid = $results['hits']['hits'][0]['_source']['answertypeid'];
$singleanswer = $results['hits']['hits'][0]['_source']['singleanswer'];
$sqlquery = $results['hits']['hits'][0]['_source']['sqlquery'];
$columnnumber = $results['hits']['hits'][0]['_source']['columnnumber'];

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

   echo "<table id=tabledidyou class=center>";
   echo "<tr>";
   echo "<th>Did you mean?</th>";
   echo "</tr>";

   $tablegenerate = 1;

   while($tablegenerate < $hits) {

      $question=$results['hits']['hits'][$tablegenerate]['_source']['question'];
      $questionurl=str_replace(' ', '+', $question);

      echo "<tr><td><a href=http://157.56.177.187:81/index_foreal.php?question2=$questionurl>$question</a></td</tr>";
      $tablegenerate++;

   }

   echo "</table>";

} //end of if($answertypeid == 2)

} //end of if(isset($questionset))

?>

</body>

