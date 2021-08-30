<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/onfirestyle.css">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
</head>
<body>

<div id="logo"><img src="/images/firemanco-logo-transparent-white.png"></div>

<div id="verticalgap"></div>

<div id=questiontext>
Motion Details
</div>

<div id=verticalgap></div>


<?PHP

   $jkey4=$_GET['jkey4'];
   $jkey6=$_GET['jkey6'];

   $serverName = "OnFire"; //serverName\instanceName
   $connectionInfo = array( "Database"=>"TRLitigation", "UID"=>"OnFire", "PWD"=>"OnFire");
   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
   }

   $sql = "exec trlitigation.getdocketmotionsviewinfo $jkey4, $jkey6";
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   $sql2 = "exec trlitigation.getdocketmotionsdecidingjudgeinfo $jkey4, $jkey6";
   $stmt2 = sqlsrv_query( $conn, $sql2 );
   if( $stmt2 === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   $sql3 = "exec trlitigation.getdocketmotionsjudgeinfo $jkey4, $jkey6";
   $stmt3 = sqlsrv_query( $conn, $sql3 );
   if( $stmt3 === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);

   $motiontypes2 = str_replace("Not Further Classified", "", $row['motiontypes2']);

   echo "<table class=center><tr><td><b>Title</b></td><td>".$row['title']."</td></tr>
         <tr><td><b>Docket Number</b></td><td>".$row['docketnumber']."</td></tr>
         <tr><td><b>Motion Type</b></td><td>".$row['motiontype']."</td></tr>
         <tr><td><b>Motion Type 2</b></td><td>".$motiontypes2."</td></tr>
         <tr><td><b>Case Type(s)</b></td><td>".$row['casetypes']."</td></tr>
         <tr><td><b>Court</b></td><td>".$row['court']."</td></tr>";

   $judgenumber = 1;

   while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {

       echo "<tr><td><b>Deciding Judge ".$judgenumber."</b></td><td><b>Name</b>: ".$row2['name']."   <b>Title</b>: ".$row2['title']."</td></tr>";
       
       $judgenumber++;

    }

   $judgenumber = 1;

   while( $row3 = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_ASSOC) ) {

       echo "<tr><td><b>Judge ".$judgenumber."</b></td><td><b>Name</b>: ".$row3['name']."   <b>Title</b>: ".$row3['title']."</td></tr>";
       
       $judgenumber++;

    }
         
    echo "<tr><td><b>Decision</b></td><td>".$row['decision']."</td></tr>
         <tr><td><b>Filing Date</b></td><td>".$row['filingdate']."</td></tr>
         <tr><td><b>Decision Date</b></td><td>".$row['decisiondate']."</td></tr>
         <tr><td><b>Days To Rule</b></td><td>".$row['timetorule']."</td></tr>";

   
   echo "</table>";
   sqlsrv_free_stmt( $stmt);
   


?>
