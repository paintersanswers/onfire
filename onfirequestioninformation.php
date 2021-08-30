<?PHP //set login of user

session_start();

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/onfirestyle.css">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
</head>
<body>
<?PHP

   echo "<div id=verticalgap></div>";

   echo "<div id=questiontext2>";
   echo $_POST["question"];
   echo "</div>";

   echo "<div id=verticalgap></div>";

   echo "<div id=questiontext>";
   echo $_POST["information"];
   echo "</div>";

   echo "<div id=verticalgap></div>";

   echo '<form action="index_foreal.php" method="post">';
   echo '<input type="hidden" name="question" value="'.$_POST["question"].'">';
   echo '<input type="Submit" value="Back">';
   echo '</form>';


?>
</body>
</html>