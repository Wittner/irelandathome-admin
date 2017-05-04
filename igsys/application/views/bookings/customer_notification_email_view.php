<?php foreach($query->result() as $row): ?>
<?

$property_name = $this->property_model->get_property_name_by_code($row->propertyCode);
$caretaker_name = $this->property_model->get_caretaker_detail($row->propertyCode,'caretaker_name');
$caretaker_number = $this->property_model->get_caretaker_detail($row->propertyCode,'caretaker_number');
$caretaker_email = $this->property_model->get_caretaker_detail($row->propertyCode,'caretaker_email');

$displayFromDate = $this->global_model->toDisplayDate($row->fromDate);
$displayToDate = $this->global_model->toDisplayDate($row->toDate);

switch ($status){
	case 'deposit_paid':
	// CUSTOMER DEPOSIT NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'];
		$emailToName = $row->customer_name . ' ' . $row->customer_surname;
		$emailSubject = 'Booking notification from ' . $APP_companyDetails['name'];
	
		// Set email intro
		$introOutput  = '<p>Dear ' . $row->customer_name . ',</p>';
		$introOutput .= '<p>I am writing to confirm the following booking: </p>';
	
		// Set email header
		$bookingDataOutput  = '<strong>Booking reference number:</strong> ' . $row->bookingNumber . '<br />';
		$bookingDataOutput .='<strong>Location:</strong> ' . $property_name . '<br />';
		$bookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
		$bookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
		$bookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
		$bookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
		$bookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
		$bookingDataOutput .='<strong>Price:</strong> ' . $row->customerPrice . ' (Euro)<br />';
		$bookingDataOutput .='<strong>Paid:</strong> ' . $row->customerTotalPaid . ' (Euro)<br />';
		$bookingDataOutput .='<strong>Balance:</strong> ' . $row->customerBalance . ' (Euro)<br />';
		if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
		{
			$bookingDataOutput .='<strong>Extras:<br />';
			if($row->bookingsCot=="yes")
			{
				$bookingDataOutput .= '* A cot is on order<br />';
			}
			if($row->bookingsHighchair=="yes")
			{
				$bookingDataOutput .= '* A highchair is on order<br />';
			}
		}
	
		// Set email main body
		$mainBodyOutput = '
		<p>Please confirm the above details are correct.</p>
		<p><strong>Please note the following:</strong></p>
		<p>Check-in details will be issued when the appropriate payments in respect of your stay have been made and when the booking details above have been verified by you. Please check the details carefully and confirm by e-mail that they are correct.</p>
		<p>If you do not reply to this e-mail it will be assumed that all details as noted above are correct.</p>
		<p>Any balance owing on your reservation is payable 42 days prior to your arrival date, unless otherwise specified. An e-mail reminder will be issued requesting payment. Failure to pay on time may result in cancellation of your reservation without further notice.</p>
		<p>Ireland at Home are delighted to partner with the CarTrawler car hire booking engine. CarTrawler search up to 450 car hire companies to bring you the cheapest and best value car hire prices in seconds. Please <a href="http://www.irelandathome.com/carhire">click here</a> for great rates on car hire, direct from our site!</p> 
 		';
	
		$signoffOutput = '<p>Thank you for booking with ' . $APP_companyDetails['name']. '.</p>';
	break;

	case 'paid_in_full':
	// PAID IN FULL NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'];
		$emailToName = $row->customer_name . ' ' . $row->customer_surname;
		$emailSubject = 'Booking notification from ' . $APP_companyDetails['name'];
	
		// Set email intro
		$introOutput  = '<p>Dear ' . $row->customer_name . ',</p>';
		$introOutput .= '<p>I am writing to confirm the following booking: </p>';
	
		// Set email header
		$bookingDataOutput  = '<strong>Booking reference number:</strong> ' . $row->bookingNumber . '<br />';
		$bookingDataOutput .='<strong>Location:</strong> ' . $property_name . '<br />';
		$bookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
		$bookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
		$bookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
		$bookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
		$bookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
		$bookingDataOutput .='<strong>Price:</strong> ' . $row->customerPrice . ' (Euro)<br />';
		$bookingDataOutput .='<strong>Paid:</strong> ' . $row->customerTotalPaid . ' (Euro)<br />';
		$bookingDataOutput .='<strong>Balance:</strong> ' . $row->customerBalance . ' (Euro)<br />';
		if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
		{
			$bookingDataOutput .='<strong>Extras:<br />';
			if($row->bookingsCot=="yes")
			{
				$bookingDataOutput .= '* A cot is on order<br />';
			}
			if($row->bookingsHighchair=="yes")
			{
				$bookingDataOutput .= '* A highchair is on order<br />';
			}
		}	
		// Set email main body
		$mainBodyOutput = '
		<p>Please confirm the above details are correct.</p>
		<p><strong>Please note the following:</strong></p>
		<p>Check-in details will be issued when the appropriate payments in respect of your stay have been made and when the booking details above have been verified by you. Please check the details carefully and confirm by e-mail that they are correct.</p>
		<p>If you do not reply to this e-mail it will be assumed that all details as noted above are correct.</p>
		<p>Ireland at Home are delighted to partner with the CarTrawler car hire booking engine. CarTrawler search up to 450 car hire companies to bring you the cheapest and best value car hire prices in seconds. Please <a href="http://www.irelandathome.com/carhire">click here</a> for great rates on car hire, direct from our site!</p> 
 		';
	
		$signoffOutput = '<p>Thank you for booking with ' . $APP_companyDetails['name']. '.</p>';
	break;

	case 'reference_obtained':
	// REFERENCE OBTAINED NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'];
		$emailToName = $row->customer_name . ' ' . $row->customer_surname;
		$emailSubject = 'Check-in details from ' . $APP_companyDetails['name'];
	
		// Set email intro
		$introOutput  = '<p>Dear ' . $row->customer_name . ',</p>';
		$introOutput .= '<p>Please click <a href="' . $APP_companyDetails['infodocsurl'] . $row->propertyCode . '.doc">here</a> for directions & check-in information</p>';
		$introOutput .= '<p>If you have given us your mobile/cell phone number you can <a href="http://www.irelandathome.com/send_sms_reminder.php?bnumber=' . $row->bookingNumber . '&email=' . $row->customer_email .'">click here</a> to receive an SMS message with caretaker details.</p>';		
		$introOutput .= '<p>Please phone ';
		if($caretaker_name !=''){
			$introOutput .= $caretaker_name . ' ';
		}
		if($caretaker_number !=''){
			$introOutput .=  'on ' . $caretaker_number .', ';
		}
		
		$introOutput .= '<strong>at least 3 Days before arrival date</strong> to discuss arrival time and check-in</p>';
		$introOutput .= '<p>Note: **Failure to phone in advance as above <strong>may result in a delay in checking in</strong>**</p>';		
						
		// Set email header
		$bookingDataOutput  = '<strong>Booking reference number:</strong> ' . $row->bookingNumber . '<br />';
		$bookingDataOutput .='<strong>Location:</strong> ' . $property_name . '<br />';
		$bookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
		$bookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
		$bookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
		$bookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
		$bookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
		$bookingDataOutput .='<strong>Price:</strong> ' . $row->customerPrice . ' (Euro)<br />';
		$bookingDataOutput .='<strong>Paid:</strong> ' . $row->customerTotalPaid . ' (Euro)<br />';
		$bookingDataOutput .='<strong>Balance:</strong> ' . $row->customerBalance . ' (Euro)<br />';
		if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
		{
			$bookingDataOutput .='<strong>Extras:<br />';
			if($row->bookingsCot=="yes")
			{
				$bookingDataOutput .= '* A cot is on order<br />';
			}
			if($row->bookingsHighchair=="yes")
			{
				$bookingDataOutput .= '* A highchair is on order<br />';
			}
		}		
	
		// Set email main body
		$mainBodyOutput = '
		<p>(Please inform us immediately if any of your details are incorrect)</p>
		<p>Ireland at Home are delighted to partner with the CarTrawler car hire booking engine. CarTrawler search up to 450 car hire companies to bring you the cheapest and best value car hire prices in seconds. Please <a href="http://www.irelandathome.com/carhire">click here</a> for great rates on car hire, direct from our site!</p> 
 		';
	
		$signoffOutput = '<p>Thank you for booking with ' . $APP_companyDetails['name']. '.</p>';
	break;

	case 'instructions_sent':
	// INSTRUCTIONS SENT NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'];
		$emailToName = $row->customer_name . ' ' . $row->customer_surname;
		$emailSubject = 'Check-in details from ' . $APP_companyDetails['name'];
	
		// Set email intro
		$introOutput  = '<p>Dear ' . $row->customer_name . ',</p>';
		$introOutput .= '<p>Below are your directions and check-in information: </p>';
		$introOutput .= '<p>Please click <a href="' . $APP_companyDetails['infodocsurl'] . $row->propertyCode . '.doc">here</a> for directions & check-in information</p>';
		$introOutput .= '<p>If you have given us your mobile/cell phone number you can <a href="http://www.irelandathome.com/send_sms_reminder.php?bnumber=' . $row->bookingNumber . '&email=' . $row->customer_email .'">click here</a> to receive an SMS message with caretaker details.</p>';
		$introOutput .= '<p>Please phone ';
		if($caretaker_name !=''){
			$introOutput .= $caretaker_name . ' ';
		}
		if($caretaker_number !=''){
			$introOutput .=  'on ' . $caretaker_number .', ';
		}
		
		$introOutput .= '<strong>at least 3 Days before arrival date</strong> to discuss arrival time and check-in</p>';
		$introOutput .= '<p>Note: **Failure to phone in advance as above <strong>may result in a delay in checking in</strong>**</p>';		
						
		// Set email header
		$bookingDataOutput  = '<strong>Booking reference number:</strong> ' . $row->bookingNumber . '<br />';
		$bookingDataOutput .='<strong>Location:</strong> ' . $property_name . '<br />';
		$bookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
		$bookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
		$bookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
		$bookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
		$bookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
		$bookingDataOutput .='<strong>Price:</strong> ' . $row->customerPrice . ' (Euro)<br />';
		$bookingDataOutput .='<strong>Paid:</strong> ' . $row->customerTotalPaid . ' (Euro)<br />';
		$bookingDataOutput .='<strong>Balance:</strong> ' . $row->customerBalance . ' (Euro)<br />';
		if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
		{
			$bookingDataOutput .='<strong>Extras:<br />';
			if($row->bookingsCot=="yes")
			{
				$bookingDataOutput .= '* A cot is on order<br />';
			}
			if($row->bookingsHighchair=="yes")
			{
				$bookingDataOutput .= '* A highchair is on order<br />';
			}
		}
	
		// Set email main body
		$mainBodyOutput = '
		<p>(Please inform us immediately if any of your details are incorrect)</p>
		<p>Ireland at Home are delighted to partner with the CarTrawler car hire booking engine. CarTrawler search up to 450 car hire companies to bring you the cheapest and best value car hire prices in seconds. Please <a href="http://www.irelandathome.com/carhire">click here</a> for great rates on car hire, direct from our site!</p> 
 		';
	
		$signoffOutput = '<p>Thank you for booking with ' . $APP_companyDetails['name']. '.</p>';
	break;

	case 'owner_paid':
	// OWNER PAID NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'];
		$emailToName = $row->customer_name . ' ' . $row->customer_surname;
		$emailSubject = 'Check-in details from ' . $APP_companyDetails['name'];
	
		// Set email intro
		$introOutput  = '<p>Dear ' . $row->customer_name . ',</p>';
		$introOutput .= '<p>Below are your directions and check-in information: </p>';
		
		$introOutput .= '<p>If you have given us your mobile/cell phone number you can <a href="http://www.irelandathome.com/send_sms_reminder.php?bnumber=$_POST[booking_number]$amp;email=$_POST[customer_email]">click here</a> to receive an SMS message with caretaker details.</p>';
		$introOutput .= '<p>Please phone ';
		if($caretaker_name !=''){
			$introOutput .= $caretaker_name . ' ';
		}
		if($caretaker_number !=''){
			$introOutput .=  'on ' . $caretaker_number .', ';
		}
		
		$introOutput .= '<strong>at least 3 Days before arrival date</strong> to discuss arrival time and check-in</p>';
		$introOutput .= '<p>Note: **Failure to phone in advance as above <strong>may result in a delay in checking in</strong>**</p>';		
						
		// Set email header
		$bookingDataOutput  = '<strong>Booking reference number:</strong> ' . $row->bookingNumber . '<br />';
		$bookingDataOutput .='<strong>Location:</strong> ' . $property_name . '<br />';
		$bookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
		$bookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
		$bookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
		$bookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
		$bookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
		$bookingDataOutput .='<strong>Price:</strong> ' . $row->customerPrice . ' (Euro)<br />';
		$bookingDataOutput .='<strong>Paid:</strong> ' . $row->customerTotalPaid . ' (Euro)<br />';
		$bookingDataOutput .='<strong>Balance:</strong> ' . $row->customerBalance . ' (Euro)<br />';
		if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
		{
			$bookingDataOutput .='<strong>Extras:<br />';
			if($row->bookingsCot=="yes")
			{
				$bookingDataOutput .= '* A cot is on order<br />';
			}
			if($row->bookingsHighchair=="yes")
			{
				$bookingDataOutput .= '* A highchair is on order<br />';
			}
		}
	
		// Set email main body
		$mainBodyOutput = '
		<p>(Please inform us immediately if any of your details are incorrect)</p>
		<p>Ireland at Home are delighted to partner with the CarTrawler car hire booking engine. CarTrawler search up to 450 car hire companies to bring you the cheapest and best value car hire prices in seconds. Please <a href="http://www.irelandathome.com/carhire">click here</a> for great rates on car hire, direct from our site!</p>';
	
		$signoffOutput = '<p>Thank you for booking with ' . $APP_companyDetails['name']. '.</p>';
	break;		
	
	default:
	break;
		case 'owner_paid':
	// REFERENCE PENDING NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'];
		$emailToName = $row->customer_name . ' ' . $row->customer_surname;
		$emailSubject = 'Check-in details from ' . $APP_companyDetails['name'];
	
		// Set email intro
		$introOutput  = '<p>Dear ' . $row->customer_name . ',</p>';
		$introOutput .= '<p>Below are your directions and check-in information: </p>';
		
		$introOutput .= '<p>If you have given us your mobile/cell phone number you can <a href="http://www.irelandathome.com/send_sms_reminder.php?bnumber=$_POST[booking_number]$amp;email=$_POST[customer_email]">click here</a> to receive an SMS message with caretaker details.</p>';
		$introOutput .= '<p>Please phone ';
		if($caretaker_name !=''){
			$introOutput .= $caretaker_name . ' ';
		}
		if($caretaker_number !=''){
			$introOutput .=  'on ' . $caretaker_number .', ';
		}
		
		$introOutput .= '<strong>at least 3 Days before arrival date</strong> to discuss arrival time and check-in</p>';
		$introOutput .= '<p>Note: **Failure to phone in advance as above <strong>may result in a delay in checking in</strong>**</p>';		
						
		// Set email header
		$bookingDataOutput  = '<strong>Booking reference number:</strong> ' . $row->bookingNumber . '<br />';
		$bookingDataOutput .='<strong>Location:</strong> ' . $property_name . '<br />';
		$bookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
		$bookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
		$bookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
		$bookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
		$bookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
		$bookingDataOutput .='<strong>Price:</strong> ' . $row->customerPrice . ' (Euro)<br />';
		$bookingDataOutput .='<strong>Paid:</strong> ' . $row->customerTotalPaid . ' (Euro)<br />';
		$bookingDataOutput .='<strong>Balance:</strong> ' . $row->customerBalance . ' (Euro)<br />';
		if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
		{
			$bookingDataOutput .='<strong>Extras:<br />';
			if($row->bookingsCot=="yes")
			{
				$bookingDataOutput .= '* A cot is on order<br />';
			}
			if($row->bookingsHighchair=="yes")
			{
				$bookingDataOutput .= '* A highchair is on order<br />';
			}
		}
	
		// Set email main body
		$mainBodyOutput = '
		<p>(Please inform us immediately if any of your details are incorrect)</p>
		<p>Ireland at Home are delighted to partner with the CarTrawler car hire booking engine. CarTrawler search up to 450 car hire companies to bring you the cheapest and best value car hire prices in seconds. Please <a href="http://www.irelandathome.com/carhire">click here</a> for great rates on car hire, direct from our site!</p>';
	
		$signoffOutput = '<p>Thank you for booking with ' . $APP_companyDetails['name']. '.</p>';
	break;		
	
	default:
	break;
}

// Set up global variables
$fromAddress = $APP_companyDetails['emailSales'];
$toAddress = $row->customer_email .', ' . $fromAddress;
$subject = $emailSubject;
?>

<!-- Notification email viewer -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<div id="email_wrapper">
<!-- Put hidden fields here with email stuff -->
<?=form_open('comms/send_customer_notification');?>
<?=form_hidden('bookingNumber', $row->bookingNumber);?>
<?=form_hidden('status', $status);?>
<?=form_hidden('fromAddress', $fromAddress);?>
<?=form_hidden('toAddress', $toAddress);?>
<?=form_hidden('subject', $subject);?>
<?=form_hidden('introOutput', $introOutput);?>
<?=form_hidden('bookingDataOutput', $bookingDataOutput);?>
<?=form_hidden('mainBodyOutput', $mainBodyOutput);?>
<?=form_hidden('signoffOutput', $signoffOutput.$APP_companyDetails['signoff']);?>
<?=form_hidden('emailFooter', $emailFooter);?>

<!-- Output preview -->
<?=$emailHeader;?>
<strong><?=$emailSubject;?></strong>
<?=$introOutput;?>
<?=$bookingDataOutput;?>
<?=$mainBodyOutput; ?>
<STRONG>NOTES</STRONG><br>
<textarea name="notes" cols="50" rows="8" scrollbars="auto"></textarea><br />
<?=$signoffOutput.$APP_companyDetails['signoff'];?>
<?=$emailFooter;?>
<p align="center"><input type="submit" value="Send mail" /></p>
</form>
</div>

<?php endforeach; ?>