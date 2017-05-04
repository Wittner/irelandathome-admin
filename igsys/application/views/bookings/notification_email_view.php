<?php foreach($query->result() as $row): ?>
<?

switch ($type){
	case 'customer_deposit':
	// CUSTOMER DEPOSIT NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'];
		$emailToName = $row->customer_name . ' ' . $row->customer_surname;
		$emailSubject = 'Deposit payment notification from ' . $APP_companyDetails['name'];
	
		// Set email intro
		$introOutput  = '<p>Dear ' . $row->customer_name . ',</p>';
		$introOutput .= '<p>I am writing to confirm the following booking: </p>';
	
		// Set email header
		$bookingDataOutput  = '<strong>Booking reference number:</strong>' . $row->bookingNumber . '<br />';
		$bookingDataOutput .='<strong>Location:</strong>' . $row->property_name . '<br />';
		$bookingDataOutput .='<strong>Arrive:</strong>' . $row->fromDate . '<br />';
		$bookingDataOutput .='<strong>Depart:</strong>' . $row->toDate . '<br />';
		$bookingDataOutput .='<strong>Adults:</strong>' . $row->adults . '<br />';
		$bookingDataOutput .='<strong>Children:</strong>' . $row->children . '<br />';
		$bookingDataOutput .='<strong>Infants:</strong>' . $row->infants . '<br />';
		$bookingDataOutput .='<strong>Price:</strong>' . $row->customerTotalCharges . '<br />';
		$bookingDataOutput .='<strong>Paid:</strong>' . $row->customerTotalPaid . '<br />';
		$bookingDataOutput .='<strong>Balance:</strong>' . $row->customerBalance . '<br />';
	
		// Set email main body
		$mainBodyOutput = '
		<p>Please confirm the above details are correct.</p>
		<p><strong>Please note the following:</strong></p>
		<p>Check-in details will be issued when the appropriate payments in respect of your stay have been made and when the booking details above have been verified by you. Please check the details carefully and confirm by e-mail that they are correct.</p>
		<p>If you do not reply to this e-mail it will be assumed that all details as noted above are correct.</p>
		<p>Ireland at Home are delighted to partner with the CarTrawler® car hire booking engine. CarTrawler® search up to 450 car hire companies to bring you the cheapest and best value car hire prices in seconds. Please <a href="http://www.irelandathome.com/carhire">click here</a> for great rates on car hire, direct from our site!</p> 
 		';
	
		$signoffOutput = 'Thank you for booking with ' . $APP_companyDetails['name']. '.<br />' . 'Ian Jarrett<br />' . $APP_companyDetails['phone1'];
	break;
	
	case 'customer_paid_in_full':
	// Blah
	break;
	
	default:
	break;
}

?>

<!-- Notification email viewer -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<div id="email_header">
<strong>From:</strong> <?=$emailFrom;?><br />
<strong>To:</strong> <?=$emailToName;?><br />
<strong>Subject:</strong> <?=$emailSubject;?><br />
</div>

<div id="email">
<?=$introOutput;?>
<?=$bookingDataOutput;?>
<?=$mainBodyOutput;?>
<form name="sendEmail">
<!-- Put hidden fields here with email stuff -->
<STRONG>NOTES</STRONG><br>
<textarea name="notes" cols="80" rows="8" scrollbars="auto"></textarea><br />
<?=$signoffOutput;?><br /><br />
<input type="submit" value="Send mail" />
</form>
</div>

<?php endforeach; ?>