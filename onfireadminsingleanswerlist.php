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
   echo "Single Answer Admin Tool";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   //grid here to show parent questions/answers in the system with single answer, be able to select to edit the question and add child questions
   //when saving child questions only save the question and generate an id, when moving this to elastic you'd get the other details from the parent


?>
</body>
</html>