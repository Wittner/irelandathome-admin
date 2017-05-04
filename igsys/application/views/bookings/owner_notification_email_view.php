<?php foreach($query->result() as $row): ?>
<?

$property_name = $this->property_model->get_property_name_by_code($row->propertyCode);
$caretaker_name = $this->property_model->get_caretaker_detail($row->propertyCode,'caretaker_name');
$caretaker_number = $this->property_model->get_caretaker_detail($row->propertyCode,'caretaker_number');
$caretaker_email = $this->property_model->get_caretaker_detail($row->propertyCode,'caretaker_email');

$contact_fname = $this->property_model->get_owner_detail($row->propertyCode,'contact_fname');
$contact_sname = $this->property_model->get_owner_detail($row->propertyCode,'contact_sname');
$email = $this->property_model->get_owner_detail($row->propertyCode,'email');

$displayFromDate = $this->global_model->toDisplayDate($row->fromDate);
$displayToDate = $this->global_model->toDisplayDate($row->toDate);
$caretakerNotify = 'no';
$caretakerIntroOutput  = ''; // initialise the var
$caretakerBookingDataOutput = '';
$caretakerAddress = $caretaker_email;

switch ($status){
	case 'reference_pending':
	// OWNER REFERENCE PENDING NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'] . ' administration';
		$emailToName = $contact_fname . ' ' . $contact_sname;
		$emailSubject = 'Booking Reminder - ' . $property_name . ' - ' . $displayFromDate;

		// Set email intro
		$introOutput  = '<p><strong>For the attention of:</strong> ' . $contact_fname . ' ' . $contact_sname . '</p>';
		$introOutput .= '<p>Please confirm the booking below by responding with a booking reference.<br />This booking has already been notified to you by e-mail but we have still not received your reference.</p>';
	
		// Set email header
		$bookingDataOutput  = '<strong>Our reference number:</strong> ' . $row->bookingNumber . '<br />';
		$bookingDataOutput .= '<strong>Sales:</strong> ' . $row->adminInit . '<br />';
		$bookingDataOutput .= '<strong>Customer name:</strong> ' . $row->customer_name . ' ' . $row->customer_surname . '<br />';
		$bookingDataOutput .= '<strong>Customer cell phone:</strong> ' . $row->customer_mobile . '<br />';
		$bookingDataOutput .='<strong>Location:</strong> ' . $this->property_model->get_property_name_by_code($row->propertyCode) . '<br />';
		$bookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
		$bookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
		$bookingDataOutput .= '<strong>Nights:</strong> ' . $row->customerNights . '<br />';
		$bookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
		$bookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
		$bookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
		if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
		{
			$bookingDataOutput .='<strong>Extras:<br />';
			if($row->bookingsCot=="yes")
			{
				$bookingDataOutput .= '* The customer needs a cot<br />';
			}
			if($row->bookingsHighchair=="yes")
			{
				$bookingDataOutput .= '* The customer needs a highchair<br />';
			}
		}
	
		// Set email main body
		$mainBodyOutput = '';
	
		$signoffOutput = '<p>' . $APP_companyDetails['name']. ' automated booking system (c)2009</p>';
	break;

	case 'deposit_paid':
	// OWNER DEPOSIT NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'] . ' administration';
		$emailToName = $contact_fname . ' ' . $contact_sname;
		$emailSubject = 'Booking Notification - ' . $property_name . ' - ' . $displayFromDate;
		
		// Set caretaker stuff
		if($caretakerAddress != '')
		{ 
			$caretakerIntroOutput  = '<p>For the attention of: ' . $caretaker_name . '</p>';
			$caretakerIntroOutput .= '<p>The following booking has been accepted by ' . $APP_companyDetails['name'];
			$caretakerIntroOutput .= '<br />Please acknowledge and confirm the details below:</p>';
			$caretakerBookingDataOutput  = '<strong>Our reference number:</strong> ' . $row->bookingNumber . '<br>';
			$caretakerBookingDataOutput .= '<strong>Sales:</strong> ' . $row->adminInit . '<br />';
			$caretakerBookingDataOutput .= '<strong>Customer name:</strong> ' . $row->customer_name . ' ' . $row->customer_surname . '<br />';
			$caretakerBookingDataOutput .= '<strong>Customer cell phone:</strong> ' . $row->customer_mobile . '<br />';
			$caretakerBookingDataOutput .='<strong>Location:</strong> ' . $this->property_model->get_property_name_by_code($row->propertyCode) . '<br />';
			$caretakerBookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
			$caretakerBookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
			$caretakerBookingDataOutput .= '<strong>Nights:</strong> ' . $row->customerNights . '<br />';
			$caretakerBookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
			$caretakerBookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
			$caretakerBookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
			if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
			{
				$caretakerBookingDataOutput .='<strong>Extras:<br />';
				if($row->bookingsCot=="yes")
				{
					$caretakerBookingDataOutput .= '* Please supply a cot for this customer<br />';
				}
				if($row->bookingsHighchair=="yes")
				{
					$caretakerBookingDataOutput .= '* Please supply a highchair for this customer<br />';
				}
			}
		$caretakerNotify = 'yes';
		}
		
		// Set email intro
		$introOutput  = '<p><strong>For the attention of:</strong> ' . $contact_fname . ' ' . $contact_sname . '</p>';
		$introOutput .= '<p>The following booking has been accepted on your behalf by ' . $APP_companyDetails['name'] . '.<br />Please acknowledge and confirm the details below:</p>';
		
		// Set email header
		$bookingDataOutput  = '<strong>Our reference number:</strong> ' . $row->bookingNumber . '<br />';
		$bookingDataOutput .= '<strong>Your reference:</strong> ';
		if($row->ownerReference == '')
		{
			$bookingDataOutput .= '<strong>*Please supply a reference for this sale*</strong><br />';
		}
		else
		{
			$bookingDataOutput .= $row->ownerReference . '<br />';
		}
		$bookingDataOutput .= '<strong>Sales:</strong> ' . $row->adminInit . '<br />';
		$bookingDataOutput .= '<strong>Customer name:</strong> ' . $row->customer_name . ' ' . $row->customer_surname . '<br />';
		$bookingDataOutput .= '<strong>Customer cell phone:</strong> ' . $row->customer_mobile . '<br />';
		$bookingDataOutput .= '<strong>Location:</strong> ' . $this->property_model->get_property_name_by_code($row->propertyCode) . '<br />';
		$bookingDataOutput .= '<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
		$bookingDataOutput .= '<strong>Depart:</strong> ' . $displayToDate . '<br />';
		$bookingDataOutput .= '<strong>Nights:</strong> ' . $row->customerNights . '<br />';
		$bookingDataOutput .= '<strong>Adults:</strong> ' . $row->adults . '<br />';
		$bookingDataOutput .= '<strong>Children:</strong> ' . $row->children . '<br />';
		$bookingDataOutput .= '<strong>Infants:</strong> ' . $row->infants . '<br />';
		$bookingDataOutput .= '<strong>Gross rate:</strong> ' . $row->commissionableCost . '<br />';
		$bookingDataOutput .= '<strong>IAH Commission:</strong> ' . $row->commissionAmount . '<br />';
		$bookingDataOutput .= '<strong>Vat @' . $row->vatPercentage . '%: </strong> ' . $row->vatAmount . '<br />';
		if($ownerTotalCharges != 1) {
			$bookingDataOutput .= '------------------------------------------------------';
			$bookingDataOutput .= $ownerChargesTable . '<br><strong>Total charges collected:</strong> ' . $ownerTotalCharges . '<br>';
			$bookingDataOutput .= '------------------------------------------------------<br>';
		}
		$bookingDataOutput .='<strong>Nett rate:</strong> ' . $row->ownerBalance . '<br />';

		if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
		{
			$bookingDataOutput .='<strong>Extras:<br />';
			if($row->bookingsCot=="yes")
			{
				$bookingDataOutput .= '* The customer needs a cot<br />';
			}
			if($row->bookingsHighchair=="yes")
			{
				$bookingDataOutput .= '* The customer needs a highchair<br />';
			}
		}
	
		// Set email main body
		$mainBodyOutput = '';
	
		$signoffOutput = '<p>' . $APP_companyDetails['name']. ' automated booking system (c)2009</p>';
	break;

	case 'paid_in_full':
	// OWNER PAID IN FULL NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'] . ' administration';
		$emailToName = $contact_fname . ' ' . $contact_sname;
		$emailSubject = 'Booking notification - ' . $property_name . ' - ' . $displayFromDate;

		// Set email intro
		$introOutput  = '<p><strong>For the attention of:</strong> ' . $contact_fname . ' ' . $contact_sname . '</p>';
		$introOutput .= '<p>The following booking has been accepted on your behalf by ' . $APP_companyDetails['name'] . '.<br />Please acknowledge and confirm the details below:</p>';
		
		// Set caretaker stuff
		if($caretakerAddress != '')
		{ 
			$caretakerIntroOutput  = '<p>For the attention of: ' . $caretaker_name . '</p>';
			$caretakerIntroOutput .= '<p>The following booking has been accepted by ' . $APP_companyDetails['name'];
			$caretakerIntroOutput .= '<p>Please acknowledge and confirm the details below:</p>';
			$caretakerBookingDataOutput  = '<strong>Our reference number:</strong> ' . $row->bookingNumber . '<br>';
			$caretakerBookingDataOutput .= '<strong>Sales:</strong> ' . $row->adminInit . '<br />';
			$caretakerBookingDataOutput .= '<strong>Customer name:</strong> ' . $row->customer_name . ' ' . $row->customer_surname . '<br />';
			$caretakerBookingDataOutput .= '<strong>Customer cell phone:</strong> ' . $row->customer_mobile . '<br />';
			$caretakerBookingDataOutput .='<strong>Location:</strong> ' . $this->property_model->get_property_name_by_code($row->propertyCode) . '<br />';
			$caretakerBookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
			$caretakerBookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
			$caretakerBookingDataOutput .= '<strong>Nights:</strong> ' . $row->customerNights . '<br />';
			$caretakerBookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
			$caretakerBookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
			$caretakerBookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
			if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
			{
				$caretakerBookingDataOutput .='<strong>Extras:<br />';
				if($row->bookingsCot=="yes")
				{
					$caretakerBookingDataOutput .= '* Please supply a cot for this customer<br />';
				}
				if($row->bookingsHighchair=="yes")
				{
					$caretakerBookingDataOutput .= '* Please supply a highchair for this customer<br />';
				}
			}
		$caretakerNotify = 'yes';
		}
	
		// Set email header
		$bookingDataOutput  = '<strong>Our reference number:</strong> ' . $row->bookingNumber . '<br />';
		$bookingDataOutput .= '<strong>Your reference:</strong> ';
		if($row->ownerReference == '')
		{
			$bookingDataOutput .= '<strong>*Please supply a reference for this sale*</strong><br />';
		}
		else
		{
			$bookingDataOutput .= $row->ownerReference . '<br />';
		}
		$bookingDataOutput .= '<strong>Sales:</strong> ' . $row->adminInit . '<br />';
		$bookingDataOutput .= '<strong>Customer name:</strong> ' . $row->customer_name . ' ' . $row->customer_surname . '<br />';
		$bookingDataOutput .= '<strong>Customer cell phone:</strong> ' . $row->customer_mobile . '<br />';
		$bookingDataOutput .='<strong>Location:</strong> ' . $this->property_model->get_property_name_by_code($row->propertyCode) . '<br />';
		$bookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
		$bookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
		$bookingDataOutput .= '<strong>Nights:</strong> ' . $row->customerNights . '<br />';
		$bookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
		$bookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
		$bookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
		$bookingDataOutput .= '<strong>Gross rate:</strong> ' . $row->commissionableCost . '<br />';
		$bookingDataOutput .= '<strong>IAH Commission:</strong> ' . $row->commissionAmount . '<br />';
		$bookingDataOutput .= '<strong>Vat @' . $row->vatPercentage . '%: </strong> ' . $row->vatAmount . '<br />';
		if($ownerTotalCharges != 1) {
			$bookingDataOutput .= '------------------------------------------------------';
			$bookingDataOutput .= $ownerChargesTable . '<br><strong>Total charges collected:</strong> ' . $ownerTotalCharges . '<br>';
			$bookingDataOutput .= '------------------------------------------------------<br>';
		}
		$bookingDataOutput .='<strong>Nett rate:</strong> ' . $row->ownerBalance . '<br />';
		if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
		{
			$bookingDataOutput .='<strong>Extras:<br />';
			if($row->bookingsCot=="yes")
			{
				$bookingDataOutput .= '* The customer needs a cot<br />';
			}
			if($row->bookingsHighchair=="yes")
			{
				$bookingDataOutput .= '* The customer needs a highchair<br />';
			}
		}
	
		// Set email main body
		$mainBodyOutput = '';
	
		$signoffOutput = '<p>' . $APP_companyDetails['name']. ' automated booking system (c)2009</p>';
	break;

	case 'reference_obtained':
	// OWNER REFERENCE OBTAINED NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'] . ' administration';
		$emailToName = $contact_fname . ' ' . $contact_sname;
		$emailSubject = 'Booking Reminder - ' . $property_name . ' - ' . $displayFromDate;

		// Set email intro
		$introOutput  = '<p><strong>For the attention of:</strong> ' . $contact_fname . ' ' . $contact_sname . '</p>';
		$introOutput .= '<p>FOR INFORMATION PURPOSES ONLY<br />Please note that the customer has been asked to contact you/caretaker as appropriate to arrange the check-in. We advise guests to make contact 3 days prior to arrival date to confirm expected arrival time.</p>';
		$introOutput .= '<p>Payment for this booking will be processed in the normal way.</p>';
			
		// Set email header
		$bookingDataOutput  = '<strong>Our reference number:</strong> ' . $row->bookingNumber . '<br />';
		$bookingDataOutput .= '<strong>Your reference:</strong> ';
		if($row->ownerReference == '')
		{
			$bookingDataOutput .= '<strong>*Please supply a reference for this sale*</strong><br />';
		}
		else
		{
			$bookingDataOutput .= $row->ownerReference . '<br />';
		}
		$bookingDataOutput .= '<strong>Sales:</strong> ' . $row->adminInit . '<br />';
		$bookingDataOutput .= '<strong>Customer name:</strong> ' . $row->customer_name . ' ' . $row->customer_surname . '<br />';
		$bookingDataOutput .= '<strong>Customer cell phone:</strong> ' . $row->customer_mobile . '<br />';
		$bookingDataOutput .='<strong>Location:</strong> ' . $this->property_model->get_property_name_by_code($row->propertyCode) . '<br />';
		$bookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
		$bookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
		$bookingDataOutput .= '<strong>Nights:</strong> ' . $row->customerNights . '<br />';
		$bookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
		$bookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
		$bookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
		if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
		{
			$bookingDataOutput .='<strong>Extras:<br />';
			if($row->bookingsCot=="yes")
			{
				$bookingDataOutput .= '* The customer needs a cot<br />';
			}
			if($row->bookingsHighchair=="yes")
			{
				$bookingDataOutput .= '* The customer needs a highchair<br />';
			}
		}
	
		// Set email main body
		$mainBodyOutput = '';
	
		$signoffOutput = '<p>' . $APP_companyDetails['name']. ' automated booking system (c)2009</p>';
	break;

	case 'instructions_sent':
	// OWNER INSTRUCTIONS SENT NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'] . ' administration';
		$emailToName = $contact_fname . ' ' . $contact_sname;
		$emailSubject = 'Booking Reminder - ' . $property_name . ' - ' . $displayFromDate;

		// Set email intro
		$introOutput  = '<p><strong>For the attention of:</strong> ' . $contact_fname . ' ' . $contact_sname . '</p>';
		$introOutput .= '<p>FOR INFORMATION PURPOSES ONLY<br />All matters attaching to this booking have been finalised with the customer.</p>';
		$introOutput .= '<p>Check-in information has been issued and the customer has been instructed to contact the local caretaker or reception at least 3 days before arrival date where appropriate.</p>';
		$introOutput .= '<p>Payment for this booking will be processed in the normal way.</p>';
					
		// Set email header
		$bookingDataOutput  = '<strong>Our reference number:</strong> ' . $row->bookingNumber . '<br />';
		$bookingDataOutput .= '<strong>Your reference:</strong> ';
		if($row->ownerReference == '')
		{
			$bookingDataOutput .= '<strong>*Please supply a reference for this sale*</strong><br />';
		}
		else
		{
			$bookingDataOutput .= $row->ownerReference . '<br />';
		}
		$bookingDataOutput .= '<strong>Sales:</strong> ' . $row->adminInit . '<br />';
		$bookingDataOutput .= '<strong>Customer name:</strong> ' . $row->customer_name . ' ' . $row->customer_surname . '<br />';
		$bookingDataOutput .= '<strong>Customer cell phone:</strong> ' . $row->customer_mobile . '<br />';
		$bookingDataOutput .='<strong>Location:</strong> ' . $this->property_model->get_property_name_by_code($row->propertyCode) . '<br />';
		$bookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
		$bookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
		$bookingDataOutput .= '<strong>Nights:</strong> ' . $row->customerNights . '<br />';
		$bookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
		$bookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
		$bookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
		if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
		{
			$bookingDataOutput .='<strong>Extras:<br />';
			if($row->bookingsCot=="yes")
			{
				$bookingDataOutput .= '* The customer needs a cot<br />';
			}
			if($row->bookingsHighchair=="yes")
			{
				$bookingDataOutput .= '* The customer needs a highchair<br />';
			}
		}
	
		// Set email main body
		$mainBodyOutput = '';
	
		$signoffOutput = '<p>' . $APP_companyDetails['name']. ' automated booking system (c)2009</p>';
	break;

	case 'owner_paid':
	// OWNER PAID NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'] . ' administration';
		$emailToName = $contact_fname . ' ' . $contact_sname;
		$emailSubject = 'Booking Reminder - ' . $property_name . ' - ' . $displayFromDate;

		// Set email intro
		$introOutput  = '<p><strong>For the attention of:</strong> ' . $contact_fname . ' ' . $contact_sname . '</p>';
		$introOutput .= '<p>FOR INFORMATION PURPOSES ONLY<br />All matters attaching to this booking have been finalised with the customer.</p>';
		$introOutput .= '<p>Check-in information has been issued and the customer has been instructed to contact the local caretaker or reception at least 3 days before arrival date where appropriate.</p>';
		$introOutput .= '<p>Payment for this booking will be processed in the normal way.</p>';
					
		// Set email header
		$bookingDataOutput  = '<strong>Our reference number:</strong> ' . $row->bookingNumber . '<br />';
		$bookingDataOutput .= '<strong>Your reference:</strong> ';
		if($row->ownerReference == '')
		{
			$bookingDataOutput .= '<strong>*Please supply a reference for this sale*</strong><br />';
		}
		else
		{
			$bookingDataOutput .= $row->ownerReference . '<br />';
		}
		$bookingDataOutput .= '<strong>Sales:</strong> ' . $row->adminInit . '<br />';
		$bookingDataOutput .= '<strong>Customer name:</strong> ' . $row->customer_name . ' ' . $row->customer_surname . '<br />';
		$bookingDataOutput .= '<strong>Customer cell phone:</strong> ' . $row->customer_mobile . '<br />';
		$bookingDataOutput .='<strong>Location:</strong> ' . $this->property_model->get_property_name_by_code($row->propertyCode) . '<br />';
		$bookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
		$bookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
		$bookingDataOutput .= '<strong>Nights:</strong> ' . $row->customerNights . '<br />';
		$bookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
		$bookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
		$bookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
		if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
		{
			$bookingDataOutput .='<strong>Extras:<br />';
			if($row->bookingsCot=="yes")
			{
				$bookingDataOutput .= '* The customer needs a cot<br />';
			}
			if($row->bookingsHighchair=="yes")
			{
				$bookingDataOutput .= '* The customer needs a highchair<br />';
			}
		}
	
		// Set email main body
		$mainBodyOutput = '';
	
		$signoffOutput = '<p>' . $APP_companyDetails['name']. ' automated booking system (c)2009</p>';
	break;		
	
	default:
	break;
		case 'owner_paid':
	// REFERENCE PENDING NOTIFICATION
	
		// Set email headers
		$emailFrom = $APP_companyDetails['name'] . ' administration';
		$emailToName = $contact_fname . ' ' . $contact_sname;
		$emailSubject = 'Booking Reminder - ' . $property_name . ' - ' . $displayFromDate;

		// Set email intro
		$introOutput  = '<p><strong>For the attention of:</strong> ' . $contact_fname . ' ' . $contact_sname . '</p>';
		$introOutput .= '<p>FOR INFORMATION PURPOSES ONLY<br />All matters attaching to this booking have been finalised with the customer.</p>';
		$introOutput .= '<p>Check-in information has been issued and the customer has been instructed to contact the local caretaker or reception at least 3 days before arrival date where appropriate.</p>';
		$introOutput .= '<p>Payment for this booking will be processed in the normal way.</p>';
					
		// Set email header
		$bookingDataOutput  = '<strong>Our reference number:</strong> ' . $row->bookingNumber . '<br />';
		$bookingDataOutput .= '<strong>Your reference:</strong> ';
		if($row->ownerReference == '')
		{
			$bookingDataOutput .= '<strong>*Please supply a reference for this sale*</strong><br />';
		}
		else
		{
			$bookingDataOutput .= $row->ownerReference . '<br />';
		}
		$bookingDataOutput .= '<strong>Sales:</strong> ' . $row->adminInit . '<br />';
		$bookingDataOutput .= '<strong>Customer name:</strong> ' . $row->customer_name . ' ' . $row->customer_surname . '<br />';
		$bookingDataOutput .= '<strong>Customer cell phone:</strong> ' . $row->customer_mobile . '<br />';
		$bookingDataOutput .='<strong>Location:</strong> ' . $this->property_model->get_property_name_by_code($row->propertyCode) . '<br />';
		$bookingDataOutput .='<strong>Arrive:</strong> ' . $displayFromDate . '<br />';
		$bookingDataOutput .='<strong>Depart:</strong> ' . $displayToDate . '<br />';
		$bookingDataOutput .= '<strong>Nights:</strong> ' . $row->customerNights . '<br />';
		$bookingDataOutput .='<strong>Adults:</strong> ' . $row->adults . '<br />';
		$bookingDataOutput .='<strong>Children:</strong> ' . $row->children . '<br />';
		$bookingDataOutput .='<strong>Infants:</strong> ' . $row->infants . '<br />';
		if($row->bookingsCot=="yes" || $row->bookingsHighchair=="yes")
		{
			$bookingDataOutput .='<strong>Extras:<br />';
			if($row->bookingsCot=="yes")
			{
				$bookingDataOutput .= '* The customer needs a cot<br />';
			}
			if($row->bookingsHighchair=="yes")
			{
				$bookingDataOutput .= '* The customer needs a highchair<br />';
			}
		}
	
		// Set email main body
		$mainBodyOutput = '';
	
		$signoffOutput = '<p>' . $APP_companyDetails['name']. ' automated booking system (c)2009</p>';
	break;		
	
	default:
	break;
}

// Set up global variables
$fromAddress = $APP_companyDetails['emailSales'];
$toAddress = $email .', ' . $fromAddress;
$subject = $emailSubject;
$message = $mainBodyOutput;
?>

<!-- Notification email viewer -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<div id="email_wrapper">
<!-- Put hidden fields here with email stuff -->
<?=form_open('comms/send_owner_notification');?>
<?=form_hidden('bookingNumber', $row->bookingNumber);?>
<?=form_hidden('status', $status);?>
<?=form_hidden('fromAddress', $fromAddress);?>
<?=form_hidden('toAddress', $toAddress);?>
<?=form_hidden('caretakerAddress', $caretakerAddress);?>
<?=form_hidden('subject', $subject);?>
<?=form_hidden('introOutput', $introOutput);?>
<?=form_hidden('caretakerNotify', $caretakerNotify);?>
<?=form_hidden('caretakerIntroOutput', $caretakerIntroOutput);?>
<?=form_hidden('caretakerBookingDataOutput', $caretakerBookingDataOutput);?>
<?=form_hidden('bookingDataOutput', $bookingDataOutput);?>
<?=form_hidden('mainBodyOutput', $mainBodyOutput);?>
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