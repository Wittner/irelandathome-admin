<?php
class Booking_model extends Model
{

/*  CONSTRUCTOR */
    function Booking_model()
    {
        parent::Model();
        $this->load->model('global_model');
        $this->load->model('customer_model');
    }

/*  UPDATE BOOKING -> OWNER BALANCE */
    function update_owner_balance($bookingNumber,$ownerBalance){
        $this->db->query("update bookings set ownerBalance = '$ownerBalance' where bookingNumber = '$bookingNumber'");
    }

/*  CREATE NEW BOOKING */
    function create_new_booking($enquiryDate,$bookingDate,$customerNights,$customerNumber,$customerReferral,$propertyList,$fromDate,$fromTime,$adults,$children,$infants,$cot,$highchair,$toDate,$toTime,$propertyCode,$customerSpecials,$accommCost,$bookingFee,$chargeAmount,$bookingDiscount,$commissionPercentage,$bookingStatus,$adminInit,$sourceCode,$paymentMethod,$paymentPurpose,$paymentAmount,$paymentRef)
    {
        $bookingNumber = $this->global_model->get_latest_booking_number();
        $vatRate = $this->global_model->get_current_vat_rate();
		// Set opening customer prices and balances
        $customerPrice = $accommCost + $bookingFee + $chargeAmount - $bookingDiscount;
        $customerBalance = $customerPrice - $paymentAmount;
        $commissionableCost = $accommCost - $bookingDiscount +  $chargeAmount;
        $commissionAmount = ($commissionableCost * $commissionPercentage)/100;
        $vatAmount = ($commissionAmount * $vatRate)/100;
        $agentFee = $bookingFee + $commissionAmount;
        $ownerBalance = $commissionableCost - $vatAmount - $commissionAmount;

        $data = array(
				'bookingId'		 		=> '',
				'enquiryDate' 			=> $enquiryDate,
            	'bookingNumber' 		=> $bookingNumber,
				'bookingDate' 			=> $bookingDate,
            	'customerNights' 		=> $customerNights,
				'customerNumber' 		=> $customerNumber,
            	'customerReferral' 		=> $customerReferral,
				'propertyList' 			=> $propertyList,
            	'fromDate' 				=> $fromDate,
				'fromTime' 				=> $fromTime,
				'adults' 				=> $adults,
				'children'			 	=> $children,
				'infants'				=> $infants,
				'cot'					=> $cot,
				'highchair'				=> $highchair,
            	'toDate' 				=> $toDate,
				'toTime' 				=> $toTime,
            	'propertyCode' 			=> $propertyCode,
            	'customerSpecials' 		=> $customerSpecials,
            	'accommCost'			=> $accommCost,

				'customerTotalPaid'		=> $paymentAmount,
            	'bookingDiscount'		=> $bookingDiscount,
            	'bookingFee'			=> $bookingFee,
            	'customerPrice'			=> $customerPrice,
            	'customerTotalCharges'	=> $chargeAmount,
            	'customerTotalPaid'		=> $paymentAmount,
            	'customerBalance'		=> $customerBalance,

            	'commissionableCost'	=> $commissionableCost,
            	'commissionPercentage'	=> $commissionPercentage,
            	'commissionAmount'		=> $commissionAmount,
            	'agentFee'				=> $agentFee,
                'vatPercentage'         => $vatRate,
                'vatAmount'             => $vatAmount,
            	'ownerBalance'			=> $ownerBalance,

				'bookingStatus' 	=> $bookingStatus,
				'adminInit' 		=> $adminInit,
				'sourceCode' 		=> $sourceCode);

        // Add the new booking
		$this->db->insert('bookings', $data);
        $bookingId = $this->db->insert_id();
		$query = $this->db->query("select bookingNumber from bookings where bookingId = $bookingId");
    	foreach ($query->result_array() as $row)
		{
			$bookingNumber = $row['bookingNumber'];
		}
	return $bookingNumber;
    }

/*	GET BOOKING BY ID */
    function get_booking_number_by_id($bookingId)
    {
    	$query = $this->db->query("select booking_number from bookings where booking_id = $bookingId");
    	foreach ($query->result_array() as $row)
		{
			$bookingNumber = $row['booking_number'];
		}
	return $bookingNumber;
    }

/*	GET BOOKING BY CUSTOMER ID */
	function get_bookings_by_customerid($customerNumber)
	{
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        $output = '<table width="100%" border="0"><tr><th>Arrival</th><th>Departure</th><th>Name</th><th>Sale/Booking no.</th><th>Email</th><th>Status</th><th colspan="3">Action</th></tr>';
		$this->db->select('*');
		$this->db->from('bookings');
		$this->db->join('customers','customers.customer_number = bookings.customerNumber');
		$this->db->where('customerNumber',$customerNumber);
		$this->db->order_by('bookingId','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
            foreach ($query->result() as $item)
			{
				$cusEmailImageSrc = 'images/app/sendmail.gif';
				$cusEmailMessage = 'Send customer notification';
				$ownEmailImageSrc = 'images/app/sendmail.gif';
				$ownEmailMessage = 'Send owner notification';
				$customerEmailStatus = explode("|", $item->customerNotificationStatus);
				$ownerEmailStatus = explode("|", $item->ownerNotificationStatus);

	    		if($item->bookingStatus == 'PAYMNT' and $item->customerBalance >= '1'){$status = 'Deposit paid';}
   		 		if($item->bookingStatus == 'PAYMNT' and $item->customerBalance == '0' and $item->ownerReference == ''){$status = 'Paid in full';}
				if($item->bookingStatus == 'PAYMNT' and $item->customerBalance == '0' and $item->ownerReference != '' and ($customerEmailStatus[2] == 'CRN' OR $ownerEmailStatus[2] == 'ORN' and $item->ownerPaid == 'no')){$status = 'Reference obtained';}
				if($item->bookingStatus == 'PAYMNT' and $item->customerBalance == '0' and $item->ownerReference != '' and ($customerEmailStatus[2] == 'CRS' and $ownerEmailStatus[2] == 'ORS' and $item->ownerPaid == 'no')){$status = 'Instructions sent';}
				if($item->bookingStatus == 'PAYMNT' and $item->customerBalance == '0' and $item->ownerReference != '' and $customerEmailStatus[2] == 'CRS' and $item->ownerPaid == 'yes'){$status = 'Owner paid';}
				if($item->bookingStatus == 'CANCELLED'){$status = 'Cancelled';}

				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);

				$i = $i + 1;
            	$col = ($i % 2) ? 'hilite' : 'lowlite';
            	$output
				.='<tr>'
				. '<td class="' . $col . '">' . $displayFromDate . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $displayToDate . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->customer_name. ' ' . $item->customer_surname . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->bookingNumber . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->customer_email . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $status . '&nbsp;</td>';



				if($item->bookingStatus == 'CANCELLED')
				{
					$output
					.= '<td width="15"><a href="index.php/booking/view_booking/' . $item->bookingNumber .'"><img src="images/app/view.gif" border="0" width="20" height="20" title="View this record"/></a></td>'
					.  '<td width="45">&nbsp;</td>';
				}
				else
				{
					$output
					.= '<td width="15"><a href="index.php/booking/view_booking/' . $item->bookingNumber .'"><img src="images/app/view.gif" border="0" width="20" height="20" title="View this record"/></a></td>'
					.  '<td width="15"><a href="index.php/booking/edit_booking/' . $item->bookingNumber .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>';
				}
        	}
        }
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    $output .= '</table>';
    return $output;
	}


/*	GET BOOKING BY BOOKING NUMBER */
    function get_booking_by_booking_number($bookingNumber)
    {
		$query  = 	$this->db->query("
									select *, bookings.cot as bookingsCot, bookings.highchair as bookingsHighchair
									from bookings
									left join customers
									on customers.customer_number = bookings.customerNumber
									left join companies
									on customers.customerCompanyId = companies.companyId
									where bookingNumber = $bookingNumber");
    	return $query;
    }

/*	UPDATE BOOKING BY BOOKING NUMBER */
    function update_booking($bookingNumber,$customerReferral,$propertyList,$customerSpecials,$fromTime,$adults,$children,$infants,$toTime,$cot,$highchair,$bookingNotes,$bookingFee,$accommCost,$customerPrice,$customerBalance,$commissionableCost,$commissionPercentage,$commissionAmount,$vatAmount,$agentFee,$ownerBalance,$ownerPaid,$ownerPaidDate,$ownerReference,$ownerPaymentMethod,$repeatBusiness,$bookingStatus)
    {
    // First, set the sale status

    /* Explanation of status codes
    PAYMNT 		= A payment was made by customer
    HLDING		= Booking is on hold for customer
    CANCEL		= Booking is cancelled

    // I might be dropping the below codes in favour of just checking the booking details at report time
    NOREF		= Owner reference not receieved
    REF			= Owner reference received
	ZEROBAL		= Customer does not owe us anything at present
	PLUSBAL 	= Customer owes us a balance
	MINUSBAL	= We owe the customer money
	CHK			= Checkin details sent to customer

    // Criteria for listings
	reference pending = no owner reference but some payment made					'PAYMNT-NOREF'
	deposit receieved = deposit paid + owner ref received							'PAYMNT-REF'
	PAID FULL - zero balance = zero balance + no owner ref							'ZEROBAL-NOREF'
	ref obtained = zero balance + owner ref received								'ZEROBAL-REF'
	ins sent = zero outstanding + owner ref received + check in details sent		'ZEROBAL-REF-CHK'
	FINAL owner paid = above line + owner paid										'ZEROBAL-REF-CHK-OWNER'
	Customer payback																'MINUSBAL'
	cancelled																		'CANCELLED'
	*/

	$data = array(
	'customerReferral'=>$customerReferral,
	'propertyList'=>$propertyList,
	'customerSpecials'=>$customerSpecials,
	'fromTime'=>$fromTime,
	'adults'=>$adults,
	'children'=>$children,
	'infants'=>$infants,
	'toTime'=>$toTime,
	'cot'=>$cot,
	'highchair'=>$highchair,
	'bookingNotes'=>$bookingNotes,
	'bookingFee'=>$bookingFee,
    'accommCost'=>$accommCost,
	'customerPrice'=>$customerPrice,
	'customerBalance'=>$customerBalance,
	'commissionableCost'=>$commissionableCost,
	'commissionPercentage'=>$commissionPercentage,
	'commissionAmount'=>$commissionAmount,
    'vatAmount' =>$vatAmount,
	'agentFee'=>$agentFee,
	'ownerBalance'=>$ownerBalance,
	'ownerPaid'=>$ownerPaid,
	'ownerPaidDate'=>$ownerPaidDate,
	'ownerReference'=>$ownerReference,
	'ownerPaymentMethod'=>$ownerPaymentMethod,
	'repeatBusiness'=>$repeatBusiness,
	'bookingStatus'=> $bookingStatus
    );

	$this->db->where('bookingNumber', $bookingNumber);
	$this->db->update('bookings', $data);
    return "done";
    }

/*	UPDATE SALE BY ID */
    function update_sale_by_id($bookingId,$customerReferral,$propertyList,$fromTime,$adults,$children,$infants,$toTime,$cot,$highchair,$bookingNotes,$accommCost,$bookingDiscount,$bookingFee,$customerPrice,$customerTotalPaid,$customerTotalCharges,$customerBalance,$commissionableCost,$commissionPercentage,$commissionAmount,$agentFee,$ownerBalance,$ownerPaidDate,$ownerReference,$ownerPaymentMethod,$balanceDue,$ownerNotifiedDate,$reminderSent,$checkinSent,$ownerNotified,$repeatBusiness,$bookingStatus,$rxTransId)
    {
    // First, set the sale status

	$data = array(
    'bookingNumber' => $bookingNumber,
	'customerReferral' => $customerReferral,
	'propertyList' => $propertyList,
	'fromTime' => $fromTime,
	'adults' => $adults,
	'children' => $children,
	'infants' => $infants,
	'toTime' => $toTime,
	'cot' => $cot,
	'highchair' => $highchair,
	'bookingNotes' => $bookingNotes,
	'accommCost' => $accommCost,
	'bookingDiscount' => $bookingDiscount,
	'bookingFee' => $bookingFee,
	'customerSpecials' => $bookingNotes,
	'customerPrice' => $customerPrice,
	'customerTotalCharges' => $customerTotalCharges,
	'customerTotalPaid' => $customerTotalPaid,
	'customerBalance' => $customerBalance,
	'commissionableCost' => $commissionableCost,
	'commissionPercentage' => $commissionPercentage,
	'commissionAmount' => $commissionAmount,
	'agentFee' => $agentFee,
	'ownerBalance' => $ownerBalance,
	'ownerPaidDate' => $ownerPaidDate,
	'ownerReference' => $ownerReference,
	'ownerPaymentMethod' => $ownerPaymentMethod,
	'balanceDue' => $balanceDue,
	'ownerNotifiedDate' => $ownerNotifiedDate,
	'reminderSent' => $reminderSent,
	'checkinSent' => $checkinSent,
	'ownerNotified' => $ownerNotified,
	'repeatBusiness' => $repeatBusiness,
	'bookingStatus' => $bookingStatus,
	'rxTransId' => $rxTransId
    );

	$this->db->where('bookingNumber', $bookingNumber);
	$this->db->update('bookings', $data);
    return "done";
    }


/*	LIST BOOKINGS */
	function list_bookings($criteria,$status)
	{
	$i=0;// Counter
	$output  ='<table width="100%" border="0">';
	$output .='<tr><th>Arrival</th><th>Booking no.</th><th>Customer</th><th>Referrer</th><th>email</th><th>Property</th><th colspan="3" align="center">Action</th>';
	$query =	$this->db->query("select fromDate, customerNotificationStatus, ownerNotificationStatus, bookingNumber, customer_name, customer_surname, customer_email, propertyCode, customerReferral from bookings left join customers on customers.customer_number=bookings.customerNumber where $criteria order by fromDate asc");

	if ($query->num_rows() > 0)
		{
        	foreach ($query->result() as $item)
			{
				$cusEmailImageSrc = 'images/app/sendmail.gif';
				$cusEmailMessage = 'Send customer notification';
				$ownEmailImageSrc = 'images/app/sendmail.gif';
				$ownEmailMessage = 'Send owner notification';
				$customerEmailStatus = explode("|", $item->customerNotificationStatus);
				$ownerEmailStatus = explode("|", $item->ownerNotificationStatus);
				if($status == 'reference_pending')
				{
					switch ($customerEmailStatus[0]){
						case 'CDS':
						$cusEmailImageSrc = 'images/app/sentmail.gif';
						$cusEmailMessage = 'Re-send customer notification';
						break;
					}
					switch ($ownerEmailStatus[0]){
						case 'ODS':
						$ownEmailImageSrc = 'images/app/sentmail.gif';
						$ownEmailMessage = 'Re-send owner notification';
						break;
					}
				}
				if($status == 'deposit_paid')
				{
					switch ($customerEmailStatus[0]){
						case 'CDS':
						$cusEmailImageSrc = 'images/app/sentmail.gif';
						$cusEmailMessage = 'Re-send customer notification';
						break;
					}
					switch ($ownerEmailStatus[0]){
						case 'ODS':
						$ownEmailImageSrc = 'images/app/sentmail.gif';
						$ownEmailMessage = 'Re-send owner notification';
						break;
					}
				}
				if($status == 'paid_in_full')
				{
					switch ($customerEmailStatus[1]){
						case 'CFS':
						$cusEmailImageSrc = 'images/app/sentmail.gif';
						$cusEmailMessage = 'Re-send customer notification';
						break;
					}
					switch ($ownerEmailStatus[1]){
						case 'OFS':
						$ownEmailImageSrc = 'images/app/sentmail.gif';
						$ownEmailMessage = 'Re-send owner notification';
						break;
					}
				}
				if($status == 'reference_obtained' || $status == 'instructions_sent')
				{
					switch ($customerEmailStatus[2]){
						case 'CRS':
						$cusEmailImageSrc = 'images/app/sentmail.gif';
						$cusEmailMessage = 'Re-send customer notification';
						break;
					}
					switch ($ownerEmailStatus[2]){
						case 'ORS':
						$ownEmailImageSrc = 'images/app/sentmail.gif';
						$ownEmailMessage = 'Re-send owner notification';
						break;
					}
				}

				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
        		$i = $i + 1;
            	$col = ($i % 2) ? 'hilite' : 'lowlite';
            	$output
				.='<tr>'
				. '<td class="' . $col . '">' . $displayFromDate . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->bookingNumber . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->customer_name . ' ' . $item->customer_surname . '&nbsp;</td>'
                . '<td class="' . $col . '">' . $item->customerReferral . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->customer_email . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $this->property_model->get_property_name_by_code($item->propertyCode) . '</td>';
				if($status == 'cancelled')
				{
					$output
					.= '<td width="15"><a href="index.php/booking/view_booking/' . $item->bookingNumber .'"><img src="images/app/view.gif" border="0" width="20" height="20" title="View this record"/></a></td>'
					.  '<td colspan="3" width="45">&nbsp;</td>';
				}
				elseif($status == 'reference_pending')
				{
					$output
					.= '<td width="15"><a href="index.php/booking/view_booking/' . $item->bookingNumber .'"><img src="images/app/view.gif" border="0" width="20" height="20" title="View this record"/></a></td>'
					.  '<td width="15"><a href="index.php/booking/owner_notification/' . $status . '/' . $item->bookingNumber . '"><img src="' . $ownEmailImageSrc . '" border="0" width="20" height="20" title="' . $ownEmailMessage . '"/></a></td>'
					.  '<td colspan="2" width="30">&nbsp;</td>';
				}
				else
				{
					$output
					.='<td width="15"><a href="index.php/booking/view_booking/' . $item->bookingNumber .'"><img src="images/app/view.gif" border="0" width="20" height="20" title="View this record"/></a></td>'
					. '<td width="15"><a href="index.php/booking/edit_booking/' . $item->bookingNumber .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>'
					. '<td width="15"><a href="index.php/booking/customer_notification/' . $status . '/' . $item->bookingNumber . '"><img src="' . $cusEmailImageSrc . '" border="0" width="20" height="20" title="' . $cusEmailMessage . '"/></a></td>'
					. '<td width="15"><a href="index.php/booking/owner_notification/' . $status . '/' . $item->bookingNumber . '"><img src="' . $ownEmailImageSrc . '" border="0" width="20" height="20" title="' . $ownEmailMessage . '"/></a></td>'
					. '</tr>';
				}
        	}
        }
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    $output .= '</table>';
    return $output;
	}

/* 	CHANGE CUSTOMER EMAIL STATUS ON BOOKING */
	/*
	Customer email notification codes in bookings table look like this CDN|CFN|CRN
	First element is customer deposit status, second is customer final status and third is customer reference obtained status
	*/
	function change_customer_booking_email_status($bookingNumber,$status)
	{
		$query = $this->db->query("select customerNotificationStatus from bookings where bookingNumber ='$bookingNumber'");
		foreach ($query->result() as $item)
		{
			$customerEmailStatus = explode("|", $item->customerNotificationStatus);
			switch($status)
			{
				case 'deposit_paid':
					$newStatus = array('CDS',$customerEmailStatus[1],$customerEmailStatus[2]);
				break;
				case 'paid_in_full':
					$newStatus = array($customerEmailStatus[0],'CFS',$customerEmailStatus[2]);
				break;
				case 'reference_obtained':
					$newStatus = array($customerEmailStatus[0],$customerEmailStatus[1],'CRS');
				break;
				default:
					$newStatus = array($customerEmailStatus[0],$customerEmailStatus[1],$customerEmailStatus[2]);
				break;

			}
		}
		$customerEmailStatus = implode('|',$newStatus);
		$query =	$this->db->query("update bookings set customerNotificationStatus = '$customerEmailStatus' where bookingNumber = '$bookingNumber'");
	}

/*	CHANGE OWNER NOTIFICATION STATUS */
	/*
	Customer email notification codes in bookings table look like this CDN|CFN|CRN
	There are two possible settings for each code - sent and not sent CDN|CFN|CRN / CDS|CFS|CRS and for owners ODN|OFN|ORN and ODS|OFS|ORS
	First element is customer deposit status, second is customer final status and third is customer reference obtained status
	*/
	function change_owner_booking_email_status($bookingNumber,$status)
	{
		$query = $this->db->query("select ownerNotificationStatus from bookings where bookingNumber ='$bookingNumber'");
		foreach ($query->result() as $item)
		{
			$ownerEmailStatus = explode("|", $item->ownerNotificationStatus);
			switch($status)
			{
				case 'reference_pending':
					$newStatus = array($ownerEmailStatus[0],$ownerEmailStatus[1],'ORS');
				break;
				case 'deposit_paid':
					$newStatus = array('ODS',$ownerEmailStatus[1],$ownerEmailStatus[2]);
				break;
				case 'paid_in_full':
					$newStatus = array($ownerEmailStatus[0],'OFS',$ownerEmailStatus[2]);
				break;
				case 'reference_obtained':
					$newStatus = array($ownerEmailStatus[0],$ownerEmailStatus[1],'ORS');
				break;
				default:
					$newStatus = array($ownerEmailStatus[0],$ownerEmailStatus[1],$ownerEmailStatus[2]);
				break;

			}
		}
		$ownerEmailStatus = implode('|',$newStatus);
		$query =	$this->db->query("update bookings set ownerNotificationStatus = '$ownerEmailStatus' where bookingNumber = '$bookingNumber'");
	}

/*	GET VALUE OF TOTAL PAYMENTS BOOKINGS TABLE */
	function get_total_payments($bookingNumber)
	{
		$query =	$this->db->query("select * from bookings where bookingNumber = $bookingNumber");
        foreach ($query->result() as $item)
		{
			$value = $item->customerTotalPaid;
		}
	}

/* 	UPDATE BOOKING WITH PAYMENT */
	function add_payment($bookingNumber,$paymentAmount)
	{
		$query = $this->db->query("update bookings set customerTotalPaid = customerTotalPaid + '$paymentAmount', customerBalance = customerBalance - '$paymentAmount' where bookingNumber = '$bookingNumber'");
	}

/* 	UPDATE BOOKING WITH CHARGE */
	function add_charge($bookingNumber,$customerPrice,$customerTotalCharges,$customerBalance,$commissionableCost,$commissionAmount,$vatAmount,$agentFee,$ownerBalance)
	{
		// echo '|' . $bookingNumber. '|' . $customerPrice. '|' .$customerTotalCharges. '|' .$customerBalance. '|' . $commissionableCost. '|' . $commissionAmount. '|' . $agentFee. '|' . $ownerBalance. '|';
		$query = $this->db->query("
		update bookings
		set
		customerPrice = $customerPrice,
		customerTotalCharges = $customerTotalCharges,
		customerBalance = $customerBalance,
		commissionableCost = $commissionableCost,
		commissionAmount = $commissionAmount,
        vatAmount = $vatAmount,
		agentFee = $agentFee,
		ownerBalance = $ownerBalance
		where bookingNumber = '$bookingNumber'");
	}

/*	RESET PAYMENTS */
	function put_payment($bookingNumber,$totalPayment)
	{
		$query = $this->db->query("update bookings set customerTotalPaid = '$totalPayment' where bookingNumber = '$bookingNumber'");
	}

/*	RESET CHARGES */
	function put_charge($bookingNumber,$totalCharge)
	{
		$query = $this->db->query("update bookings set customerTotalCharges = '$totalCharge' where bookingNumber = '$bookingNumber'");
		echo $bookingNumber . 'total Charges: ' . $totalCharge . '<br />';
	}

/*	CLEAN UP */
	function clean_up($bookingNumber,$customerPrice,$customerBalance,$commissionableCost,$commissionAmount,$agentFee,$ownerBalance)
	{
		$query = $this->db->query("
		update bookings
		set
		customerPrice = $customerPrice,
		customerBalance = $customerBalance,
		commissionableCost = $commissionableCost,
		commissionAmount = $commissionAmount,
		agentFee = $agentFee,
		ownerBalance = $ownerBalance
		where bookingNumber = '$bookingNumber'");
		echo $bookingNumber . '.... done! <br />';
	}

/*	CHANGE BOOKING STATUS */
	function update_booking_status($bookingNumber,$status)
	{
		$this->db->query("update bookings set bookingStatus = '$status' where bookingNumber = '$bookingNumber'");

	}

/*	FIND BOOKINGS */
	function find_bookings($searchBy,$kwd)
	{
		switch ($searchBy)
		{
			case "name":
			$query = $this->db->query("
			select *
			from bookings, customers
			where bookings.customerNumber = customers.customer_number
			and customer_name like '%$kwd%'
			and bookingStatus != 'DELETED'
			ORDER BY bookingId
			");
			break;

			case "surname":
			$query = $this->db->query("
			select *
			from bookings, customers
			where bookings.customerNumber = customers.customer_number
			and customer_surname like '%$kwd%'
			and bookingStatus != 'DELETED'
			ORDER BY bookingId
			");
			break;

			case "property":
			$query = $this->db->query("
			select *
			from bookings, customers
			where bookings.customerNumber = customers.customer_number
			and bookings.propertyCode = '$kwd'
			ORDER BY bookingId
			");
			break;

			case "bookno":
			$query = $this->db->query("
			select *
			from bookings, customers
			where bookings.customerNumber = customers.customer_number
			and bookingNumber like '%$kwd%'
			and bookingStatus != 'DELETED'
			ORDER BY bookingId
			");
			break;

			case "cusno":
			$query = $this->db->query("
			select *
			from bookings, customers
			where bookings.customerNumber = customers.customer_number
			and bookings.customerNumber like '%$kwd%'
			and bookingStatus != 'DELETED'
			ORDER BY bookingId
			");
			break;

			case "cusref":
			$query = $this->db->query("
			select *
			from bookings, customers
			where bookings.customerNumber = customers.customer_number
			and ownerReference like '%$kwd%'
			and bookingStatus != 'DELETED'
			ORDER BY bookingId
			");
			break;

			case "book_id":
			$query = $this->db->query("
			select *
			from bookings, customers
			where bookings.customerNumber = customers.customer_number
			and bookingId like '%$kwd%'
			ORDER BY bookingId
			");
			break;

			case "rx_trans_id":
			$query = $this->db->query("
			select *
			from payments
			left join bookings
			on payments.paymentBookingNumber = bookings.bookingNumber
			left join customers
			on bookings.customerNumber = customers.customer_number
			where paymentRef = '$kwd'
			group by bookingNumber
			");
			break;

			case "referrer":
			$query = $this->db->query("
			select *
			from bookings, customers
			where bookings.customerNumber = customers.customer_number
			and customerReferral = '$kwd'
			ORDER BY bookingId
			");
			break;
		}
		if ($query->num_rows() > 0)
		{
			$i = 0; // Odd/even counter for alternate coloured <td>'s
    	    $col = ''; // Color style name for alternate coloured <td>'s
        	$output = '<table width="100%" border="0"><tr><th width="80">Arrival</th><th width="80">Departure</th><th width="80">ID</th><th width="160">Name</th><th>Email</th><th>Status</th><th colspan="3">Action</th></tr>';
            foreach ($query->result() as $item)
			{
				$cusEmailImageSrc = 'images/app/sendmail.gif';
				$cusEmailMessage = 'Send customer notification';
				$ownEmailImageSrc = 'images/app/sendmail.gif';
				$ownEmailMessage = 'Send owner notification';
				$customerEmailStatus = explode("|", $item->customerNotificationStatus);
				$ownerEmailStatus = explode("|", $item->ownerNotificationStatus);

				$status = 'Unknown';

	    		if($item->bookingStatus == 'PAYMNT' and $item->customerBalance >= '1')
				{
					$status = 'Deposit paid';
				}


   		 		if($item->bookingStatus == 'PAYMNT' and $item->customerBalance == '0' and $item->ownerReference == '')
				{
					$status = 'Paid in full';
				}


				if
				(
					$item->bookingStatus == 'PAYMNT'
					and $item->customerBalance == '0'
					and $item->ownerReference != ''
					and ($customerEmailStatus[2] == 'CRN' OR $ownerEmailStatus[2] == 'ORN')
					and $item->ownerPaid == 'no'
				)
				{
					$status = 'Reference obtained';
				}


    			if
				(
					$item->bookingStatus == 'PAYMNT'
					and $item->customerBalance == '0'
					and $item->ownerReference != ''
					and $customerEmailStatus[2] == 'CRS'
					and $ownerEmailStatus[2] == 'ORS'
					and $item->ownerPaid == 'no'
				)
				{
					$status = 'Instructions sent';
				}

				if($item->bookingStatus == 'PAYMNT' and $item->customerBalance == '0' and $item->ownerReference != '' and $customerEmailStatus[2] == 'CRS' and $item->ownerPaid == 'yes')
				{
					$status = 'Owner paid';
				}



				if($item->bookingStatus == 'CANCELLED')
				{
					$status = 'Cancelled';
				}

				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);

				$i = $i + 1;
            	$col = ($i % 2) ? 'hilite' : 'lowlite';
            	$output
				.='<tr>'
				. '<td class="' . $col . '">' . $displayFromDate . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $displayToDate . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->bookingNumber . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->customer_name. ' ' . $item->customer_surname . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->customer_email . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $status . '&nbsp;</td>';



				if($item->bookingStatus == 'CANCELLED')
				{
					$output
					.= '<td width="15"><a href="index.php/booking/view_booking/' . $item->bookingNumber .'"><img src="images/app/view.gif" border="0" width="20" height="20" title="View this record"/></a></td>'
					.  '<td width="45">&nbsp;</td>';
				}
				else
				{
					$output
					.= '<td width="15"><a href="index.php/booking/view_booking/' . $item->bookingNumber .'"><img src="images/app/view.gif" border="0" width="20" height="20" title="View this record"/></a></td>'
					.  '<td width="15"><a href="index.php/booking/edit_booking/' . $item->bookingNumber .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>';
				}
        	}
        }
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    $output .= '</table>';
    return $output;
	}

} // End of class
?>
