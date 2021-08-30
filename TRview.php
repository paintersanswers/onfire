<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/onfirestyle.css">
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
</head>
<body>

<div id="logo"><img src="/images/firemanco-logo-transparent-white.png"></div>

<div id="verticalgap"></div>

<div id=questiontext>
Details
</div>

<div id=verticalgap></div>


<?PHP

   $jkey4=$_GET['jkey4'];

   $serverName = "OnFire"; //serverName\instanceName
   $connectionInfo = array( "Database"=>"TRLitigation", "UID"=>"OnFire", "PWD"=>"OnFire");
   $conn = sqlsrv_connect( $serverName, $connectionInfo);

   if( $conn === false) {
        echo "Connection could not be established.<br />";
        die( print_r( sqlsrv_errors(), true));
   }

   $sql = "exec trlitigation.getdocketinfo $jkey4";
   $stmt = sqlsrv_query( $conn, $sql );
   if( $stmt === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   $sql2 = "exec trlitigation.getdocketjudgeinfo $jkey4";
   $stmt2 = sqlsrv_query( $conn, $sql2 );
   if( $stmt2 === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   $sql3 = "exec trlitigation.getdocketawardeddamagesinfo $jkey4";
   $stmt3 = sqlsrv_query( $conn, $sql3 );
   if( $stmt3 === false) {
       die( print_r( sqlsrv_errors(), true) );
   }

   $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
   echo "<table class=center><tr><td><b>Title</b></td><td>".$row['title']."</td></tr>
         <tr><td><b>Docket Number</b></td><td>".$row['docketnumber']."</td></tr>
         <tr><td><b>Case Type(s)</b></td><td>".$row['casetypes']."</td></tr>
         <tr><td><b>Is Class Action</b></td><td>".$row['classaction']."</td></tr>
         <tr><td><b>Court Type</b></td><td>".$row['courttype']."</td></tr>
         <tr><td><b>Federal Flag</b></td><td>".$row['federalflag']."</td></tr>";

   $judgenumber = 1;

   while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {

       echo "<tr><td><b>Judge ".$judgenumber."</b></td><td><b>Name</b>: ".$row2['name']."   <b>Title</b>: ".$row2['title']."</td></tr>";
       
       $judgenumber++;

    }

         echo "<tr><td><b>Filing Date</b></td><td>".$row['filingdate']."</td></tr>
         <tr><td><b>TR Link</b></td><td><a href=".$row['link']." target=_blank>Link</a></td></tr>
         <tr><td><b>Jurisdiction State</b></td><td>".$row['jurisdictionstate']."</td></tr>
         <tr><td><b>Last Updated</b></td><td>".$row['lastupdateddate']."</td></tr>
         <tr><td><b>Total Awarded Damages</b></td><td>".$row['totalawardeddamagesamount']."</td></tr>";
    
    
    $damagesnumber = 1;     

    while( $row3 = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_ASSOC) ) {

       echo "<tr><td><b>Awarded Damages Detail ".$damagesnumber."</b></td><td><b>Amount</b>: ".$row3['amount']."   <b>Type</b>: ".$row3['type']."</td></tr>";
       
       $damagesnumber++;

    }

    echo "</table>";

    echo "<div id=verticalgap></div>";

   echo "<div id=questiontext>";
   echo "Motions";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   $sql4 = "exec trlitigation.getdocketmotionsinfo $jkey4";
   $stmt4 = sqlsrv_query( $conn, $sql4 );
   if( $stmt4 === false) {
       die( print_r( sqlsrv_errors(), true) );
   }
    

   echo "<table class=center>";
   echo "<tr><th>Title</th><th>Type</th><th>Court</th><th>Decision</th><th>Date Filed</th><th>Decision Date</th><th>Days To Rule</th><th>Details</th></tr>";

   while( $row4 = sqlsrv_fetch_array( $stmt4, SQLSRV_FETCH_ASSOC) ) {
   echo "<tr>";

   echo "<td>".$row4['title']."</td><td>".$row4['motiontype']."</td><td>".$row4['court']."</td><td>".$row4['decision']."</td><td>".$row4['filingdate']."</td><td>".$row4['decisiondate']."</td><td>".$row4['timetorule']."</td><td><a href=TRviewmotion.php?jkey4=".$row4['jkey4']."&jkey6=".$row4['jkey6'].">view</a></td>";

   echo "</tr>";
   }

   echo "</table>";





   echo "<div id=verticalgap></div>";

   echo "<div id=questiontext>";
   echo "Outcomes";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   $sql5 = "exec trlitigation.getdocketoutcomesinfo $jkey4";
   $stmt5 = sqlsrv_query( $conn, $sql5 );
   if( $stmt5 === false) {
       die( print_r( sqlsrv_errors(), true) );
   }
    

   echo "<table class=center>";
   echo "<tr><th>Outcome Type</th><th>Outcome Date</th><th>Days to Outcomes</th><th>Label 1</th><th>Label 2</th></tr>";

   while( $row5 = sqlsrv_fetch_array( $stmt5, SQLSRV_FETCH_ASSOC) ) {
   echo "<tr>";

   echo "<td>".$row5['outcometype']."</td><td>".$row5['outcomedate']."</td><td>".$row5['timetooutcome']."</td><td>".$row5['label1']."</td><td>".$row5['label2']."</td>";

   echo "</tr>";
   }

   echo "</table>";



   echo "<div id=verticalgap></div>";

   echo "<div id=questiontext>";
   echo "Participants";
   echo "</div>";

   echo "<div id=verticalgap></div>";

   $sql6 = "exec trlitigation.getdocketparticipantsinfo $jkey4";
   $stmt6 = sqlsrv_query( $conn, $sql6 );
   if( $stmt6 === false) {
       die( print_r( sqlsrv_errors(), true) );
   }
    

   echo "<table class=center>";
   echo "<tr><th>Participant Name</th><th>Participant Role</th><th>Attorney Name</th><th>Attorney Title</th><th>Law Firm</th></tr>";

   while( $row6 = sqlsrv_fetch_array( $stmt6, SQLSRV_FETCH_ASSOC) ) {
   echo "<tr>";

   echo "<td>".$row6['namep']."</td><td>".$row6['role']."</td><td>".$row6['namea']."</td><td>".$row6['title']."</td><td>".$row6['mainname']."</td>";

   echo "</tr>";
   }

   echo "</table>";

   sqlsrv_free_stmt( $stmt);
   


?>