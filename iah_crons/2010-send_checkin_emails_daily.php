<?
/*
This script (2010-check_send_checkin.php) sits on the IAH admin server
and checks for anyone who needs to have their checking details sent
to them. It sends a mail to anyone who is arriving within 7 days and
id fully paid up.
Runs once per day
*/

require_once "Email.php";

// Functions
   function toDisplayDate($date) // 2009-05-28 to 28-May-2009
   {
       $date_elements = explode("-", $date);
       $display_date = $date_elements[2] . "-" . $date_elements[1] . "-" . $date_elements[0];
       return $display_date;
   }

// DB setup
$glob_host="mysql359int.cp.blacknight.com";
$db_name="db1036209_iah_admin";
$glob_user="u1036209_iah";
$glob_pass="j8wQwLrjd.4eb.Xh";
$baseref="http://www.corporaterentalseurope.com/";
$filepath="/srv/wwwroot/websites/iah/";

// SEND CURRENT CHECK-IN EMAILS

// Admin message header
$admin_message="
<p><strong>The following customers have been sent check-in reminders</strong></p>
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

// Work out 7 days from now
$set_date  = mktime(0, 0, 0, date("m"), date("d")+4, date("Y"));
$today=date("Y-m-d");
$display_reminder_sent=date("d-m-Y");

$chk_date= date("Y-m-d","$set_date");

/// Set up database and connection
$connection=mysql_connect("$glob_host", "$glob_user", "$glob_pass")or die(mysql_error());
$db=mysql_select_db($db_name, $connection)or die(mysql_error());

$sql="
select *, bookings.highchair as bookingChair, bookings.cot as bookingCot
from bookings
left join customers
	on customers.customer_number = bookings.customerNumber
left join properties
	on properties.property_code = bookings.propertyCode
where bookingStatus = 'PAYMNT'
and customerBalance = '0'
and ownerReference != ''
and customerNotificationStatus like '%CRS%'
and ownerNotificationStatus like '%ORS%'
and fromDate between '$today' and '$chk_date'
and checkinSent='0000-00-00'
order by fromDate";

$result=mysql_query($sql,$connection)or die(mysql_error());
$num_recs = mysql_num_rows($result);

while ($row =mysql_fetch_array($result)){

	//Booking stuff
	$bookingId=$row['bookingIdd'];
	$bookingNumber=$row['bookingNumber'];
	$adults=$row['adults'];
	$children=$row['children'];
	$infants=$row['infants'];
	$customerPrice=$row['customerPrice'];
	$customerTotalPaid=$row['customerTotalPaid'];
	$balanceDue=$row['balanceDue'];
	$highchair=$row['bookingChair'];
	$extras='';
	if($highchair != '')
	{
		$extras = '<strong>Extras:</strong>';
	}
	$cot=$row['bookingCot'];
	if($cot != '')
	{
		$extras = '<strong>Extras:</strong>';
	}
	
	$customer_surname=$row['customer_surname'];
	$customer_name=$row['customer_name'];
	
	// Set up arrival date for display as YYYY-MM-DD
	$fromDate = toDisplayDate($row['fromDate']);
	
	// Set up departure date for display as YYYY-MM-DD
	$toDate = toDisplayDate($row['toDate']);
	
	$customer_email=$row['customer_email'];
	$notification=$row['notification'];
	$booking_status=$row['booking_status'];
	
	//Property stuff
	$property_code=$row['property_code'];
	$property_name=$row['property_name'];
	$ctaker_name=$row['caretaker_name'];
	$caretaker_name="The Caretaker, ".$row['caretaker_name'];
	if($ctaker_name==""){$caretaker_name="The Caretaker";}
	$caretaker_number=$row['caretaker_number'];
	
	$admin_message.="
	<tr>
	<td nowrap class=\"listing\">$fromDate</a></td>
	<td nowrap class=\"listing\">$customer_surname $customer_name</td>
	<td nowrap class=\"listing\"><a href=\"mailto:$customer_email\">$customer_email</td>
	<td nowrap>$bookingNumber</td>
	<td nowrap>$property_name</td>
	<td nowrap>$display_reminder_sent</td>
	<td nowrap>$balanceDue</td>
	</tr>";
	
	$customer_message="
	Dear $customer_name,
	<br /><br />
	
	You should by now have received all of the information you need for your check-in on $sql_arrival_date. If you have not done so already, you need to call <strong>$caretaker_name $caretaker_number</strong> to make suitable check-in arrangements.<br />
	(Failure to do so may result in a delay in checking in)
	<br /><br />
	
	Please click <a href=\"http://www.irelandathome.com/infodocs/$property_code.doc?email=$customer_email\">here</a> for directions &amp; check-in information
	<br /><br />
	
	<strong>YOUR DETAILS:</strong><br />
	<strong>Booking reference:</strong> $bookingNumber<br />
	<strong>Location:</strong> $property_name<br />
	<strong>Arrival Date:</strong> $fromDate <br />
	<strong>Departure Date:</strong> $toDate<br />
	<strong>Group details:</strong><br />
	<strong>- Adults:</strong> $adults<br />
	<strong>- Children:</strong> $children<br />
	<strong>- Infants:</strong> $infants<br />
	<strong>Price:</strong> &euro;$customerPrice Euro<br />
	<strong>Received with thanks:</strong> &euro;$customerTotalPaid Euro<br />
	$extras<br />
	";
	
	if($cot=="yes")
		{
			$customer_message.="- A cot has been ordered<br />";
		}
	
	if($highchair=="yes")
		{
	   	$customer_message.="- A high chair has been ordered<br />";
	   }
	
	$customer_message.="
	<br />
	(Please inform us immediately if any of your details are incorrect)
	<br /><br />
	
	Ireland at Home are delighted to partner with the CarTrawler&reg; car hire booking engine.<br>
	
	CarTrawler&reg; search up to 450 car hire companies to bring you the cheapest and best value car hire prices in seconds.<br>
	Please click <a href=\"http://www.irelandathome.com/car-hire.php\">here</a> for great rates on car hire, direct from our site!
	<br /><br />
	
	
	We wish you a very pleasant stay and look forward to welcoming you to one of our properties again.
	<br><br>
	
	Regards,<br /><br />
	
	Ireland at Home administration
	";
	
	
	// Send mail to customer
	$customer_to  = "{$customer_name} {$customer_surname} <{$customer_email}>";
	$customer_subject = "Ireland at Home check-in reminder";
	send_exchange_email($customer_to, $customer_subject, $customer_message, '3389871987418974889798:!}Oii');
	echo $admin_message."<br /><br />";
	echo $customer_subject."<br />";
	echo $customer_to."<br />";
	echo $customer_message."<br /><br />";
	
	
	//Set payment_status to reminder sent
	$cus_sql="update bookings set checkinSent='$today' where bookingNumber='$bookingNumber'";
	$cus_result=mysql_query($cus_sql,$connection)or die(mysql_error());
}

if($num_recs=='0'){$admin_message.="<tr><td colspan=\"6\">There are no check-in reminders to be sent today</td></tr>";}
$admin_message.="</table>";


// Send mail to admin
echo 'sending email to admin';
$to  = "mike@irelandathome.com, sales@irelandathome.com";
// subject
$subject = "Check-in reminders sent";

send_exchange_email($to, $subject, $admin_message, '3389871987418974889798:!}Oii');

?>
