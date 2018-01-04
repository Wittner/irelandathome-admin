<?php

/*
This file 2010-availReport.php belongs on the IAH admin server. it checks for anomalies
in the properties table and email admin if there is a problem. It specifically
checks to see if any property availability is showing as *less* than it shows
in the availability table. Runs once a day.
*/

include("../app_global.php");


// TEMPORARY REPORT ON THE AVAILABILITY TABLE
$availReport = '
<table border="1">
<tr><th>Property code</th><th>Date</th><th>Avail alloc.</th><th>Units</th><th>Property</th></tr>';
$sql="select availPropertyCode, availAlloc, availDate, property_name, property_units
from availability
left join properties
on properties.property_code = availability.availPropertyCode
where availAlloc > property_units";
$result=mysql_query($sql,$connection)or die(mysql_error());
while ($row =mysql_fetch_array($result))
{
	$availReport .= '<tr><td>' . $row['availPropertyCode'] . '</td><td>' . $row['availDate'] . '</td><td>' . $availAlloc . '</td><td>' . $property_units . '</td><td>' . $property_name . '</td></tr>';
}
$availReport .='</table>';

// MAKE UP A MAIL MESSAGE
$message = '<strong>SYSTEM AVAILABILITY ANOMILY CHECK</strong><br />';
$message .= $availReport;
$message .= '<br /><strong>END OF MESSAGE</strong>';

// SEND MESSAGE TO ADMIN
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: IT department <mike@irelandathome.com>\r\n";

$to="mike@irelandathome.com";
$subject="Availability anomily check";

mail($to, $subject, $message, $headers);


?>
<html>

<head>
  <title></title>
</head>

<body>

<?php

echo $message;

?>

</body>

</html>
