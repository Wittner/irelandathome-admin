<html>

<head>
  <title></title>
</head>

<body>

<?
/*
This file (2010-reminder_44_day.php) sits on the IAH admin server
It sends out reminder emails to customers who's arrival is within
44 days from now, who have not paid in full! (naughty customers!!!!)
*/

// DB setup
$glob_host="mysql359int.cp.blacknight.com";
$db_name="db1036209_iah_admin";
$glob_user="u1036209_iah";
$glob_pass="j8wQwLrjd.4eb.Xh";
$baseref="http://www.corporaterentalseurope.com/";
$filepath="/srv/wwwroot/websites/iah/";

$connection=mysql_connect("$glob_host", "$glob_user", "$glob_pass")or die(mysql_error());
$db=mysql_select_db($db_name, $connection)or die(mysql_error());

// Functions
	 // Sql date changer
    function toSqlDate($shortDate)
    {
        // Convert short date to sql format date (e.g. 05-06-2007 passed in, 2007-06-05 passed out)
        $date_elements = explode("-", $shortDate);
        $display_date = $date_elements[2] . "-" . $date_elements[1] . "-" . $date_elements[0];
        return $display_date;
    }

	function toVerboseDate($sqlDate)
	{
        // Convert sql format dates to long display date (e.g. 2007-06-05 passed in, 5th June 2007 passed out)
        $date_elements = explode("-", $sqlDate);
        // date("M-d-Y", mktime(0, 0, 0, 12, 32, 1997));
        $display_date = date("l, M jS, Y", mktime(0,0,0, $date_elements[1], $date_elements[2], $date_elements[0]));
        return $display_date;
	}
   function toDisplayDate($sqlDate)
   {
       // Convert sql format dates to display date (e.g. 2007-06-05 passed in, 05-06-2007 passed out)
       $date_elements = explode("-", $sqlDate);
       $display_date = $date_elements[2] . "-" . $date_elements[1] . "-" . $date_elements[0];
       return $display_date;
   }

/*  GET PROPERTY DETAIL BY PROPERTY CODE */
	function get_property_detail($propertyCode,$field)
{
		$glob_host="mysql359int.cp.blacknight.com";
		$db_name="db1036209_iah_admin";
		$glob_user="u1036209_iah";
		$glob_pass="j8wQwLrjd.4eb.Xh";
		$baseref="http://www.irelandathome.com/";
		$filepath="/srv/wwwroot/websites/iah/";

		$connection=mysql_connect("$glob_host", "$glob_user", "$glob_pass")or die(mysql_error());
		$db=mysql_select_db($db_name, $connection)or die(mysql_error());

      $sql="select $field from properties where property_code = '$propertyCode'";
   	$result=mysql_query($sql,$connection)or die(mysql_error());
    	while ($row = mysql_fetch_array($result))
 		{
     		$fieldResult = $row[$field];
		}
 		return $fieldResult;
}

// End Functions


// Admin message header
$admin_message="
<p><strong>The following customers have been sent reminders</strong><br />This is now on an auto cron script - Mike</p>
<table width=\"350\" cellpadding=\"2\" cellspacing=\"0\" border=\"1\">
<tr>
<td nowrap><strong>Arrival Date</strong></td>
<td nowrap><strong>Name</strong></td>
<td nowrap><strong>Email</strong></td>
<td nowrap><strong>Booking ref.</strong></td>
<td nowrap><strong>Property</strong></td>
<td nowrap><strong>Reminder sent</td>
<td nowrap><strong>Amount due</strong></td>
</tr>

";

// Work out 44 days from now
$set_date  = mktime(0, 0, 0, date("m"), date("d")+46, date("Y"));
$today=date("Y-m-d");
$chk_date= date("Y-m-d","$set_date");
$display_reminder_sent=date("d-m-Y");

/// Set up database and connection
$connection=mysql_connect("$glob_host", "$glob_user", "$glob_pass")or die(mysql_error());
$db=mysql_select_db($db_name, $connection)or die(mysql_error());

$sql="
select *
from bookings
left join customers
on bookings.customerNumber=customers.customer_number
where bookings.bookingStatus = 'PAYMNT'
and customerBalance > '0'
and fromDate between '$today' and '$chk_date'
and reminderSent='0000-00-00'
order by fromDate";

$result=mysql_query($sql,$connection)or die(mysql_error());
$num_recs = mysql_num_rows($result);

while ($row =mysql_fetch_array($result))
{
	//Booking stuff
	$booking_id=$row['bookingId'];
	$balance_due=$row['customerBalance'];
	$booking_number=$row['bookingNumber'];
	$propertyCode = $row['propertyCode'];
	$party=$row['adults'];
	$children=$row['children'];
	$infants=$row['infants'];
	$cot=$row['cot'];
	$highchair=$row['highchair'];
	$sub_total=$row['customerPrice'];
	$deposit_amount=$row['customerTotalPaid'];
	$balance_due=$row['customerBalance'];

	$customer_surname=$row['customer_surname'];
	$customer_name=$row['customer_name'];

	// Set up arrival date for display as YYYY-MM-DD
	$arrival_date= toDisplayDate($row['fromDate']);

	// Set up departure date for display as YYYY-MM-DD
	$depart_date = toDisplayDate($row['toDate']);

	$customer_email=$row['customer_email'];

	//Property stuff
	$property_name=get_property_detail($propertyCode,"property_name");

	$admin_message.="
	<tr>
	<td nowrap class=\"listing\">$arrival_date</a></td>
	<td nowrap class=\"listing\">$customer_surname $customer_name</td>
	<td nowrap class=\"listing\"><a href=\"mailto:$customer_email\">$customer_email</td>
	<td nowrap>$booking_number</td>
	<td nowrap>$property_name</td>
	<td nowrap>$display_reminder_sent</td>
	<td nowrap>$balance_due</td>
	</tr>";

	$customer_message="
	<font face=\"verdana\" size=\"2\">

	To: $customer_name $customer_surname<br /><br />

	Dear $customer_name,<br /><br />

	Please note that the balance of &euro; {$balance_due} (Euro) in respect of the following booking is now due for payment If you have already made your final payment and this email is in error please accept our apologies and ignore this email.
	<br /><br />

	<strong>Booking reference number:</strong> $booking_number<br />
	<strong>Location:</strong> $property_name<br />
	<strong>Arrival Date:</strong> $arrival_date<br />
	<strong>Departure Date:</strong> $depart_date<br />
	<strong>Group details:</strong><br />
	<strong>- Adults:</strong> $party<br />
	<strong>- Children:</strong> $children<br />
	<strong>- Infants:</strong> $infants<br />
	";

	if($cot=="yes"){$customer_message.="<strong>Extras: </strong>A cot has been ordered<br />";}
	if($highchair=="yes"){$customer_message.="<strong>Extras: </strong>A high chair has been ordered<br />";}

	$customer_message.="

	<strong>Price:</strong> &euro;$sub_total (Euro)<br />
	<strong>Total paid:</strong>  &euro;$deposit_amount; (Euro), received with thanks<br />
	<strong>Balance:</strong> &euro;$balance_due (Euro)<br />
	<strong>Balance due date: 44 days before arrival date </strong>
	<br /><br />

	Payment can be made by one of the following methods. Please choose your preferred option
	<br /><br />

	<strong>* By Credit Card:</strong><br />
	Click <a href=\"https://www.irelandathome.com/balance/$booking_number\">HERE</a> to go to our online payment system
	<br /><br />

	<strong>* By Cheque using the following details:</strong><br />
	Ireland At Home (Payee)<br />
	Swallows Rest<br />
	Ballynerrin Lower<br />
	Wicklow Town
	<br /><br />

	<strong>* By Lodgement to our account:</strong><br />
	Bank: AIB<br />
	Account Number: 52081085<br />
	Sort Code: 933619<br />
	(Please quote booking reference: {$booking_number})<br />
   IBAN<br />
   IBAN: IE32AIBK93361952081085<br />
	Swift: AIBKIE2D<br />
	Account Name: Ireland At Home<br />
	Bank: AIB, Abbey Street, Wicklow<br />
	<br /><br />

	<p align=\"left\">
	Regards,
	<br /><br />

	Ireland at Home<br />
	Telephone +353 404 64608<br />
	====================<br />
	<a href=\"http://www.irelandathome.com\">Ireland at Home</a><br />
	<a href=\"http://www.corkholidayhomes.com\">Cork Holiday Homes</a></p>
	</font>
	";

	// Send mail to customer
	$customer_to  = "{$customer_name} {$customer_surname} <{$customer_email}>";
	$customer_subject = "Ireland at Home reminder";
	$customer_headers  = "MIME-Version: 1.0\r\n";
	$customer_headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$customer_headers .= "From: Ireland at Home reminders <sales@irelandathome.com>\r\n";
	$customer_headers .= "Reply-To: Ireland at Home reminders <sales@irelandathome.com>\r\n";

	mail($customer_to, $customer_subject, $customer_message, $customer_headers);
	// echo $customer_message . '<br />';

	// Set payment_status to reminder sent
	$cus_sql = "update bookings set reminderSent='$today' where bookingNumber='$booking_number'";
	$cus_result=mysql_query($cus_sql,$connection)or die(mysql_error());
}

// Send mail to admin
$to  = "mike@irelandathome.com, sales@irelandathome.com";

// In case of no reminders
if($num_recs=='0'){$admin_message.="<tr><td colspan=\"6\">There are no reminders to be sent today</td></tr>";}
$admin_message.="</table>";

// subject
$subject = "Reminders sent";
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: Ireland at Home Reminders <sales@irelandathome.com>\r\n";
$headers .= "Reply-To: Ireland at Home reminders <sales@irelandathome.com>\r\n";

mail($to, $subject, $admin_message, $headers);
// echo $admin_message . '<br /><br />';

?>

<!--
	rx_full_payment.php?id=1234&src=ckg">here</a> to pay automatically using our secure online payment system
-->
</body>

</html>
