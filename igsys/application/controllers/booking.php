<?php
/**
 * Booking
 *
 * @package Ireland at Home 2009
 * @author
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Booking extends Controller
{

/*	INDEX */
	function index()
	{
		date_default_timezone_set('UTC');
	    $data['heading'] = 'Latest Queries';
	    $data['results'] = $this->enquiries_model->get_latest_queries();
	    $headerView = $this->global_model->get_standard_header_view();
	    $this->load->view('enquiries/enquiries_list_view', $data);
	    $this->load->view('footer_view');
	}

/* FOR TESTING */
	function getvatrate() {
		$vatRate = $this->global_model->get_current_vat_rate();
		echo $vatRate;
	}


/*	CONSTRUCTOR */
    function Booking()
	{
        parent::Controller();
        // $this->output->enable_profiler(TRUE);
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('validation');
        $this->load->model('booking_model');
        $this->load->model('payment_model');
        $this->load->model('charges_model');
        $this->load->model('customer_model');
        $this->load->model('property_model');
        $this->load->model('company_model');
        $this->load->model('owner_model');
        $this->load->model('availability_model');
        $this->load->model('comms_model');
        $this->load->model('global_model');
        $this->global_model->is_logged_in();
    }

/*	MAKE A BOOKING */
    function make_booking()
    {

		// Form validation
		$rules['paymentRef']	= "required";
		$rules['customerName']	= "required";
		$rules['customerSurname']	= "required";
		$rules['customerEmail']	= "required|valid_email";
		$rules['adults']	= "required|numeric";
		$rules['children']	= "numeric";
		$rules['infants']	= "numeric";
		$rules['accommCost']	= "required|numeric";
		$rules['bookingFee']	= "numeric";
		$rules['paymentAmount'] = "required|numeric";
		$this->validation->set_rules($rules);
		$this->validation->set_message('required', '*Required*');
		$this->validation->set_message('valid_email', '*This email is not valid*');
		$this->validation->set_message('numeric', '*Numeric data only please*');
		$this->validation->set_error_delimiters('<SPAN STYLE="color: #ff0000; font-weight: bold;">', '</SPAN>');
		$data['payment_ref']	= $this->input->post('payment_ref');
		$data['customerNumber'] = $this->input->post('customerNumber');
		$data['customerName'] = $this->input->post('customerName');
		$data['customerSurname'] = $this->input->post('customerSurname');
		$data['customerEmail'] = $this->input->post('customerEmail');
		$data['customerCompanyId'] = $this->input->post('customerCompanyId');
		$data['customerAddress'] = $this->input->post('customerAddress');
		$data['customerCountry'] = $this->input->post('customerCountry');
		$data['customerLandphone'] = $this->input->post('customerLandphone');
		$data['customerMobile'] = $this->input->post('customerMobile');
		$data['customerReferral'] = $this->input->post('customerReferral');
		$data['customerDate'] = date('Y-m-d');
		$data['propertyCode'] = $this->input->post('propertyCode');
		$data['propertyList'] = $this->input->post('propertyList');
		$data['customerNights'] = $this->input->post('customerNights');
		$data['fromDate'] = $this->input->post('fromDate');
		$data['toDate'] = $this->input->post('toDate');
		$data['fromTime'] = $this->input->post('fromTime');
		$data['toTime'] = $this->input->post('toTime');
		$data['adults'] = $this->input->post('adults');
		$data['children'] = $this->input->post('children');
		$data['infants'] = $this->input->post('infants');
		$data['cot'] = $this->input->post('cot');
		$data['highchair'] = $this->input->post('highchair');
		$data['specials'] = $this->input->post('specials');
		$data['accommCost'] = $this->input->post('accommCost');
		$data['bookingFee'] = $this->input->post('bookingFee');
		$data['bookingDiscount'] = $this->input->post('bookingDiscount');
		$data['bookingExtrasDescription'] = $this->input->post('bookingExtrasDescription');
		$data['subTotal'] = '300';
		$data['propertyName'] = $this->input->post('propertyName');
		$data['enquiryDate'] = date('Y-m-d');
		$data['bookingDate'] = date('Y-m-d');
		$data['adminInit'] = 'MB';
		$data['sourceCode'] = 'ADM';
		$data['bookingStatus'] = 'PAYMNT';
		$data['companyCombo'] = $this->company_model->get_company_combo('');
		$data['propertyInput'] = $this->property_model->get_property_by_code($data['propertyCode']);
		$this->validation->set_fields($data);

		// Data from form
		$customerNumber = $this->input->post('customerNumber');
		$customerName = $this->input->post('customerName');
		$customerSurname = $this->input->post('customerSurname');
		$customerEmail = $this->input->post('customerEmail');
		$customerAddress = $this->input->post('customerAddress');
		$customerCompanyId = $this->input->post('customerCompanyId');
		$customerCountry = $this->input->post('customerCountry');
		$customerLandphone = $this->input->post('customerLandphone');
		$customerMobile = $this->input->post('customerMobile');
		$customerReferral = $this->input->post('customerReferral');
		$customerDate = date('Y-m-d');
		$propertyCode = $this->input->post('propertyCode');
		$propertyList = $this->input->post('propertyList');
		$customerNights = $this->input->post('customerNights');
		$fromDate = $this->input->post('fromDate');
		$toDate = $this->input->post('toDate');
		$fromTime = $this->input->post('fromTime');
		$toTime = $this->input->post('toTime');
		$adults = $this->input->post('adults');
		$children = $this->input->post('children');
		$infants = $this->input->post('infants');
		$cot = $this->input->post('cot');
		$highchair = $this->input->post('highchair');
		$customerSpecials = $this->input->post('specials');
		$accommCost = $this->input->post('accommCost');
		$bookingFee = $this->input->post('bookingFee');
		$bookingDiscount = $this->input->post('bookingDiscount');
		$propertyName = $this->input->post('propertyName');
		$paymentMethod = $this->input->post('paymentMethod');
		$paymentPurpose = $this->input->post('paymentPurpose');
		$paymentAmount = $this->input->post('paymentAmount');
		$paymentRef = strtoupper($this->input->post('paymentRef'));
		$chargeAmount = $this->input->post('chargeAmount');
		$chargePurpose = $this->input->post('chargePurpose');
		$commissionPercentage = $this->input->post('commissionPercentage');
		$enquiryDate = date('Y-m-d');
		$bookingDate = date('Y-m-d');
		$adminInit = 'MB';
		$sourceCode = 'ADM';
		$bookingStatus = 'PAYMNT';





		if ($this->validation->run() == FALSE)
		{
			// Reload add booking view
			$headerView = $this->global_model->get_standard_header_view();
			$this->load->view('bookings/add_booking_view', $data);
			$this->load->view('footer_view');
		}
		else
		{
        // Check if we have a customer number - if not, see if customer already in db. If yes then resolve conflict. If no create new customer record. Continue to booking
        if($customerNumber=='')
        {
        	$checkCustomerNumber = $this->customer_model->customer_exist($customerEmail);
			if($checkCustomerNumber != '')
			{
				// Customer exists, so we fire the new and existing customer and booking info to the conflict booking method in the booking model
				// Set new customer data
				$data['newCustomerName'] = $customerName;
				$data['newCustomerSurname'] = $customerSurname;
				$data['newCustomerLandphone'] = $customerLandphone;
				$data['newCustomerMobile'] = $customerMobile;
				$data['newCustomerEmail'] = $customerEmail;
				$data['newCustomerCountry'] = $customerCountry;
				$data['newCustomerAddress'] = $customerAddress;
				$data['newCustomerReferral'] = $customerReferral;

				// Booking data
				$data['customerCompanyId'] = $customerCompanyId;
				$data['adults'] = $adults;
				$data['propertyCode'] = $propertyCode;
				$data['propertyList'] = $propertyList;
				$data['customerNights'] = $customerNights;
				$data['fromDate'] = $fromDate;
				$data['toDate'] = $toDate;
				$data['fromTime'] = $fromTime;
				$data['toTime'] = $toTime;
				$data['adults'] = $adults;
				$data['children'] = $children;
				$data['infants'] = $infants;
				$data['cot'] = $cot;
				$data['highchair'] = $highchair;
				$data['specials'] = $customerSpecials;
				$data['accommCost'] = $accommCost;
				$data['bookingFee'] = $bookingFee;
				$data['propertyName'] = $propertyName;
				$data['paymentMethod'] = $paymentMethod;
				$data['paymentPurpose'] = $paymentPurpose;
				$data['paymentAmount'] = $paymentAmount;
				$data['paymentRef'] = $paymentRef;
				$data['bookingFee'] = $bookingFee;
				$data['bookingDiscount'] = $bookingDiscount;
				$data['chargePurpose'] = $chargePurpose;
				$data['chargeAmount'] = $chargeAmount;
				$data['commissionPercentage'] = $commissionPercentage;

				// Set existing customer data
				$data['query'] = $this->customer_model->get_customer_by_number($checkCustomerNumber);

				// Load conflict view
				$headerView = $this->global_model->get_standard_header_view();
				$this->load->view('bookings/conflict_view',$data);
				$this->load->view('footer_view');
			}
			else
			{
				// Customer is new - add customer, then add booking
				$customerNumber = $this->customer_model->add_customer($customerName,$customerSurname,$customerLandphone,$customerMobile,$customerEmail,$customerCountry,$customerAddress,$customerReferral,$customerDate,$customerCompanyId);

				// Add availability, booking, payment, initial charges if any
				$data['heading'] = 'Edit Booking';
				$data['status'] = $this->availability_model->add_availability($propertyCode,$fromDate,$customerNights);
				$bookingNumber = $this->booking_model->create_new_booking($enquiryDate,$bookingDate,$customerNights,$customerNumber,$customerReferral,$propertyList,$fromDate,$fromTime,$adults,$children,$infants,$cot,$highchair,$toDate,$toTime,$propertyCode,$customerSpecials,$accommCost,$bookingFee,$chargeAmount,$bookingDiscount,$commissionPercentage,$bookingStatus,$adminInit,$sourceCode,$paymentMethod,$paymentPurpose,$paymentAmount,$paymentRef);
				$paymentId = $this->payment_model->add_payment($bookingNumber,$paymentPurpose,$paymentMethod,$paymentAmount,$paymentRef);
				if($chargePurpose !='')
				{
					$chargeId = $this->charges_model->add_charge($bookingNumber,$chargePurpose,$chargeAmount);
				}
				$data['query'] = $this->booking_model->get_booking_by_booking_number($bookingNumber);
				$data['payments'] = $this->payment_model->get_payments_by_booking_number($bookingNumber);
				$data['charges'] = $this->charges_model->get_charges_by_booking_number($bookingNumber);
				$data['totPayments'] = $this->payment_model->get_total_payments_for_booking($bookingNumber);
				$data['totCharges'] = $this->charges_model->get_total_charges_for_booking($bookingNumber);
				$headerView = $this->global_model->get_standard_header_view();
				$this->load->view('bookings/edit_booking_controlbar_view',$data);
				$this->load->view('bookings/edit_view',$data);
				$this->load->view('footer_view');
			}
    	}
    }// end of validation else
	}

/*	MAKE A CUSTOMER CONFLICT BOOKING */
	function customer_conflict()
	{
		// Booking has come in from 'customer conflict' view

		// New info
		$newCustomerName = $this->input->post('newCustomerName');
		$newCustomerSurname = $this->input->post('newCustomerSurname');
		$newCustomerCountry = $this->input->post('newCustomerCountry');
		$newCustomerAddress = $this->input->post('newCustomerAddress');
		$newCustomerLandphone = $this->input->post('newCustomerLandphone');
		$newCustomerMobile = $this->input->post('newCustomerMobile');
		$newCustomerEmail = $this->input->post('newCustomerEmail');
		$newCustomerReferral = $this->input->post('newCustomerReferral');
		$newCustomerAlternatives = $this->input->post('newCustomerAlternatives');

		// Existing info
		$customerNumber = $this->input->post('customerNumber');
		$customerName = $this->input->post('customerName');
		$customerSurname = $this->input->post('customerSurname');
		$customerCompanyId = $this->input->post('customerCompanyId');
		$customerCountry = $this->input->post('customerCountry');
		$customerAddress = $this->input->post('customerAddress');
		$customerLandphone = $this->input->post('customerLandphone');
		$customerMobile = $this->input->post('customerMobile');
		$customerEmail = $this->input->post('customerEmail');
		$customerReferral = $this->input->post('customerReferral');
		$specials = $this->input->post('specials');
		$customerAlternatives = $this->input->post('customerAlternatives');
		$customerDate = date('Y-m-d');
		$adminInit = "MB";

		// Booking data
		$propertyCode = $this->input->post('propertyCode');
		$fromDate = $this->input->post('fromDate');
		$fromTime = $this->input->post('fromTime');
		$toDate = $this->input->post('toDate');
		$toTime = $this->input->post('toTime');
		$adults = $this->input->post('adults');
		$children = $this->input->post('children');
		$infants = $this->input->post('infants');
		$cot = $this->input->post('cot');
		$highchair = $this->input->post('highchair');
		$newCustomerReferral = $this->input->post('newCustomerReferral');
		$customerNights = $this->input->post('customerNights');
		$customerSpecials = $this->input->post('customerSpecials');
		$propertyList = $this->input->post('propertyList');
		$accommCost = $this->input->post('accommCost');
		$bookingFee = $this->input->post('bookingFee');
		$subTotal = $this->input->post('subTotal');
		$bookingDiscount = $this->input->post('bookingDiscount');
		$paymentMethod = $this->input->post('paymentMethod');
		$paymentPurpose = $this->input->post('paymentPurpose');
		$paymentAmount = $this->input->post('paymentAmount');
		$paymentRef = $this->input->post('paymentRef');
		$chargeAmount = $this->input->post('chargeAmount');
		$chargePurpose = $this->input->post('chargePurpose');
		$commissionPercentage = $this->input->post('commissionPercentage');

		// General booking data
        $enquiryDate = date('Y-m-d');
        $bookingDate = date('Y-m-d');
        $bookingStatus = 'PAYMNT';
		$adminInit = 'MB';
		$sourceCode = 'ADMIN';

		// Control info from conflict view
		$replace_customer_name = $this->input->post('replace_customer_name');
		$replace_customer_landphone = $this->input->post('replace_customer_landphone');
		$replace_customer_mobile = $this->input->post('replace_customer_mobile');
		$replace_customer_address = $this->input->post('replace_customer_address');

		// Sort out which fields have to be updated
		// If email has changed then forget all that and just add a new customer with new data

		if($newCustomerEmail == $customerEmail)
		{
			if($replace_customer_name == 'yes')
			{
				$customerName=$newCustomerName;
				$customerSurname=$newCustomerSurname;
			}
			if($replace_customer_landphone == 'yes')
			{
				$customerLandphone=$newCustomerLandphone;
			}
			if($replace_customer_mobile == 'yes')
			{
				$customerMobile=$newCustomerMobile;
			}
			if($replace_customer_address == 'yes')
			{
				$customerAddress=$newCustomerAddress;
			}
			// Update customer
			$customerNumber = $this->customer_model->update_customer($customerNumber,$customerName,$customerSurname,$customerCompanyId,$customerLandphone,$customerMobile,$customerEmail,$customerCountry,$customerAddress,$customerReferral,$customerDate);
		}
		else
		{
			$customerNumber = $this->customer_model->add_customer($customerName,$customerSurname,$customerLandphone,$customerMobile,$customerEmail,$customerCountry,$customerAddress,$customerReferral,$customerDate);
		}
			// Add availability, booking, payment, Initial charges
			$data['heading'] = 'Edit Booking';
			$data['status'] = $this->availability_model->add_availability($propertyCode,$fromDate,$customerNights);
			$bookingNumber = $this->booking_model->create_new_booking($enquiryDate,$bookingDate,$customerNights,$customerNumber,$customerReferral,$propertyList,$fromDate,$fromTime,$adults,$children,$infants,$cot,$highchair,$toDate,$toTime,$propertyCode,$customerSpecials,$accommCost,$bookingFee,$chargeAmount,$bookingDiscount,$commissionPercentage,$bookingStatus,$adminInit,$sourceCode,$paymentMethod,$paymentPurpose,$paymentAmount,$paymentRef);
			if($chargePurpose !='')
			{
				$chargeId = $this->charges_model->add_charge($bookingNumber,$chargePurpose,$chargeAmount);
			}
			$paymentId = $this->payment_model->add_payment($bookingNumber,$paymentPurpose,$paymentMethod,$paymentAmount,$paymentRef);
			$data['query'] = $this->booking_model->get_booking_by_booking_number($bookingNumber);
			$data['payments'] = $this->payment_model->get_payments_by_booking_number($bookingNumber);
			$data['charges'] = $this->charges_model->get_charges_by_booking_number($bookingNumber);
			$data['totPayments'] = $this->payment_model->get_total_payments_for_booking($bookingNumber);
			$data['totCharges'] = $this->charges_model->get_total_charges_for_booking($bookingNumber);
			$headerView = $this->global_model->get_standard_header_view();
			$this->load->view('bookings/edit_booking_controlbar_view',$data);
			$this->load->view('bookings/edit_view',$data);
			$this->load->view('footer_view');
	}

/*	UPDATE A BOOKING*/
	function update_booking()
	{
		// First check to see if booking is being cancelled
		$bookingStatus = $this->input->post('bookingStatus');
		$cancelStatus = $this->input->post('cancelStatus');
		if($cancelStatus == 'CANCELLED')
		{
			$bookingStatus = $cancelStatus;
		}
		// Customer data to update customer file
		$customerNumber = $this->input->post('customerNumber');
		$customerName = $this->input->post('customerName');
		$customerSurname = $this->input->post('customerSurname');
		$customerEmail = $this->input->post('customerEmail');
		$customerAddress = $this->input->post('customerAddress');
		$customerCompanyId = $this->input->post('customerCompanyId');
		$customerCountry = $this->input->post('customerCountry');
		$customerLandphone = $this->input->post('customerLandphone');
		$customerMobile = $this->input->post('customerMobile');
		$customerReferral = $this->input->post('customerReferral');
		$customerDate = date('Y-m-d');

		// Booking data to update booking file
		$bookingNumber = $this->input->post('bookingNumber');
		$customerReferral = $this->input->post('customerReferral');
		$propertyList = $this->input->post('propertyList');
		$fromTime = $this->input->post('fromTime');
		$adults = $this->input->post('adults');
		$children = $this->input->post('children');
		$infants = $this->input->post('infants');
		$toTime = $this->input->post('toTime');
		$cot = $this->input->post('cot');
		$highchair = $this->input->post('highchair');
		$bookingNotes = $this->input->post('customerSpecials');
		$customerSpecials = $this->input->post('customerSpecials');


		// Incoming fields for math
		$accommCost = $this->input->post('accommCost');
		$bookingFee = $this->input->post('bookingFee');
		$customerTotalCharges = $this->input->post('customerTotalCharges');
		$iahTotalCharges = $this->input->post('iahTotalCharges');
		$ownerTotalCharges = $this->input->post('ownerTotalCharges');
		$totalCharges = $iahTotalCharges + $ownerTotalCharges;
		$bookingDiscount = $this->input->post('bookingDiscount');
		$customerTotalPaid = $this->input->post('customerTotalPaid');
		$commissionPercentage = $this->input->post('commissionPercentage');
		$vatPercentage = $this->input->post('vatPercentage');
		// Re-do the math if we are cancelling
		if($cancelStatus == 'CANCELLED') {
			$accommCost = 0;
			$bookingDiscount = 0;
		}

		// Start the math
		$customerPrice = $accommCost + $bookingFee + $customerTotalCharges - $bookingDiscount;
		$customerBalance = $customerPrice - $customerTotalPaid;
		$commissionableCost = $accommCost - $bookingDiscount;
		$commissionAmount = ($commissionableCost * $commissionPercentage)/100;
		$vatAmount = ($commissionAmount * $vatPercentage)/100;
		$agentFee = $bookingFee + $commissionAmount;
		$ownerBalance = $commissionableCost - $commissionAmount - $vatAmount + $ownerTotalCharges;

		$ownerPaid = $this->input->post('ownerPaid');
		$ownerPaidDate = $this->input->post('ownerPaidDate');
		$ownerReference = $this->input->post('ownerReference');
		$ownerPaymentMethod = $this->input->post('ownerPaymentMethod');
		$repeatBusiness = $this->input->post('repeatBusiness');

		$this->customer_model->update_customer($customerNumber,$customerName,$customerSurname,$customerCompanyId,$customerLandphone,$customerMobile,$customerEmail,$customerCountry,$customerAddress,$customerReferral,$customerDate);

		$result = $this->booking_model->update_booking($bookingNumber,$customerReferral,$propertyList,$customerSpecials,$fromTime,$adults,$children,$infants,$toTime,$cot,$highchair,$bookingNotes,$bookingFee,$accommCost,$customerPrice,$customerBalance,$commissionableCost,$commissionPercentage,$commissionAmount,$vatAmount,$agentFee,$ownerBalance,$ownerPaid,$ownerPaidDate,$ownerReference,$ownerPaymentMethod,$repeatBusiness,$bookingStatus);

		$data['query'] = $this->booking_model->get_booking_by_booking_number($bookingNumber);
		$data['payments'] = $this->payment_model->get_payments_by_booking_number($bookingNumber);
		$data['charges'] = $this->charges_model->get_charges_by_booking_number($bookingNumber);
		$data['totPayments'] = $this->payment_model->get_total_payments_for_booking($bookingNumber);
		$data['totCharges'] = $this->charges_model->get_total_charges_for_booking($bookingNumber);
		// if booking is cancelled show booking view otherwise show edit view
		if($bookingStatus == 'CANCELLED')
		{
			redirect('/booking/view_booking/' . $bookingNumber, 'refresh');
		}
		else
		{
			redirect('/booking/edit_booking/' . $bookingNumber, 'refresh');
		}
	}

/*	ADD A PAYMENT */
	function add_payment()
	{
		$bookingNumber = $this->input->post('bookingNumber');
		$paymentPurpose = $this->input->post('paymentPurpose');
		$paymentMethod = $this->input->post('paymentMethod');
		$paymentAmount = $this->input->post('paymentAmount');
		$paymentRef = strtoupper($this->input->post('paymentRef'));
		$this->payment_model->add_payment($bookingNumber,$paymentPurpose,$paymentMethod,$paymentAmount,$paymentRef);
		$this->booking_model->add_payment($bookingNumber,$paymentAmount);
		redirect('/booking/edit_booking/' . $bookingNumber, 'refresh');
	}

/*	ADD A CHARGE*/
	function add_charge()
	{
		// Charge details
		$bookingNumber = $this->input->post('bookingNumber');
		$chargePurpose = $this->input->post('chargePurpose');
		$chargeAmount = $this->input->post('chargeAmount');
		$chargeAllocation = $this->input->post('chargeAllocation');
		$vatPercentage = $this->input->post('vatPercentage');

		// Incoming fields for math
		$accommCost = $this->input->post('accommCost');
		$bookingFee = $this->input->post('bookingFee');
		$customerTotalCharges = $this->input->post('customerTotalCharges') + $chargeAmount;
		$ownerTotalCharges = $this->input->post('ownerTotalCharges');
		if($chargeAllocation == 'owner') {
			$ownerTotalCharges = $ownerTotalCharges + $chargeAmount;
		}
		$bookingDiscount = $this->input->post('bookingDiscount');
		$customerTotalPaid = $this->input->post('customerTotalPaid');
		$commissionPercentage = $this->input->post('commissionPercentage');

		// Start the math
		$customerPrice = $accommCost + $bookingFee + $customerTotalCharges - $bookingDiscount;
		$customerBalance = $customerPrice - $customerTotalPaid;
		$commissionableCost = $accommCost - $bookingDiscount;
		$commissionAmount = ($commissionableCost * $commissionPercentage)/100;
		$agentFee = $bookingFee + $commissionAmount;
		$vatAmount = ($commissionAmount * $vatPercentage)/100;
		$ownerBalance = $commissionableCost - $commissionAmount - $vatAmount  + $ownerTotalCharges;

		$data['paymentId'] = $this->charges_model->add_charge($bookingNumber,$chargePurpose,$chargeAmount,$chargeAllocation);
		$this->booking_model->add_charge($bookingNumber,$customerPrice,$customerTotalCharges,$customerBalance,$commissionableCost,$commissionAmount,$vatAmount,$agentFee,$ownerBalance);
		redirect('/booking/edit_booking/' . $bookingNumber, 'refresh');
	}

/*	LIST BOOKINGS */
	function list_bookings($status)
	{
        if(isset($_POST['month'])) {
			$month = $this->input->post('month');
		}else{
            $month = date('m');
		}
        if(isset($_POST['year'])) {
			$year = $this->input->post('year');
		}else{
            $year = date('Y');
		}
		$monthName = $this->global_model->getMonthNameFromNumber($month);

		switch ($status) {
			case 'reference_pending':
	    		$searchCriteria="bookingStatus = 'PAYMNT' and ownerReference = ''";
	    		$heading = 'Bookings by reference pending';
	    		break;
			case 'deposit_paid':
	    		$searchCriteria="bookingStatus = 'PAYMNT' and customerBalance > '0' and month(fromDate) = '$month' and year(fromDate) = '$year'";
	    		$heading = 'Bookings by deposit paid for arrival date in ' . $monthName . ' ' . $year;
	    		break;
			case 'paid_in_full':
	    		$searchCriteria="bookingStatus = 'PAYMNT' and customerBalance = '0' and ownerReference = ''";
	    		$heading = 'Bookings by zero customer balance';
	    		break;
			case 'reference_obtained':
	    		$searchCriteria="bookingStatus = 'PAYMNT' and customerBalance = '0' and ownerReference != '' and (customerNotificationStatus like '%CRN%' OR ownerNotificationStatus like '%ORN%') and ownerPaid ='no'";
	    		$heading = 'Bookings by reference obtained';
	    		break;
			case 'instructions_sent':
				$searchCriteria="bookingStatus = 'PAYMNT' and customerBalance = '0' and ownerReference != '' and customerNotificationStatus like '%CRS%' and ownerNotificationStatus like '%ORS%' and ownerPaid = 'no' and month(fromDate) = '$month' and year(fromDate) = '$year'";
	    		$heading = 'Bookings by instructions sent for arrival date in ' . $monthName . '/' . $year;;
				break;
			case 'owner_paid':
				$searchCriteria="bookingStatus = 'PAYMNT' and ownerPaid = 'yes' and month(fromDate) = '$month' and year(fromDate) = '$year'";
	    		$heading = 'Bookings by owner paid for arrival date in ' . $monthName . '/' . $year;;
				break;
			case 'customer_credit':
				$searchCriteria="bookingStatus = 'PAYMNT' and customerBalance < '0'";
	    		$heading = 'Bookings by owner paid';
				break;
			case 'cancelled';
				$searchCriteria="bookingStatus = 'CANCELLED'";
	    		$heading = 'Cancelled bookings';
				break;
	    	default:
	    	    $heading = 'All sales';
	    		$searchCriteria="bookingStatus = 'PAYMNT'";
	    		break;
		}
		$data['results'] = $this->booking_model->list_bookings($searchCriteria,$status);
		$data['heading'] = $heading;
		$data['status'] = $status;
		$data['sqlCode'] = $searchCriteria;
		$data['selectedMonth'] = '<option value="' . $month . '">' . $monthName . '</option>';
		// Get two years ago
		$year = date("Y");
		$startYear = $year -2;
		$data['yearCombo'] = $this->global_model->get_year_combo($startYear, 10, $year);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('bookings/bookings_list_view',$data);
		$this->load->view('footer_view');
	}

/*	SEND CUSTOMER BOOKING NOTIFICATIONS */
	function customer_notification($status,$bookingNumber)
	{
	$data['heading'] = 'Email preview';
	$data['status'] = $status;
	$data['APP_companyDetails'] = $this->global_model->get_company_data();
	$data['emailOpener'] = $this->comms_model->get_email_opener();
	$data['emailHeader'] = $this->comms_model->get_email_header();
	$data['emailFooter'] = $this->comms_model->get_email_footer();
	$data['emailCloser'] = $this->comms_model->get_email_closer();
	$data['query'] = $this->booking_model->get_booking_by_booking_number($bookingNumber);
	$headerView = $this->global_model->get_standard_header_view();
	$this->load->view('bookings/customer_notification_email_view',$data);
	$this->load->view('footer_view');
	}

/*	SEND OWNER BOOKING NOTIFICATIONS */
	function owner_notification($status,$bookingNumber)
	{
	$data['heading'] = 'Email preview';
	$data['status'] = $status;
	$data['APP_companyDetails'] = $this->global_model->get_company_data();
	$data['ownerChargesTable'] = $this->charges_model->get_owner_charges_by_booking_number($bookingNumber);
	$data['ownerTotalCharges'] = $this->charges_model->get_owner_total_charges_for_booking($bookingNumber);
	$data['emailOpener'] = $this->comms_model->get_email_opener();
	$data['emailHeader'] = $this->comms_model->get_email_header();
	$data['emailFooter'] = $this->comms_model->get_email_footer();
	$data['emailCloser'] = $this->comms_model->get_email_closer();
	$data['query'] = $this->booking_model->get_booking_by_booking_number($bookingNumber);
	$headerView = $this->global_model->get_standard_header_view();
	$this->load->view('bookings/owner_notification_email_view',$data);
	$this->load->view('footer_view');
	}


/*	EDIT BOOKING */
	function edit_booking($bookingNumber)
	{
		$data['heading'] = 'Edit Booking';
		$data['query'] = $this->booking_model->get_booking_by_booking_number($bookingNumber);
		$currentQuery = $data['query']->result();
		$data['payments'] = $this->payment_model->get_payments_by_booking_number($bookingNumber);
		$data['totPayments'] = $this->payment_model->get_total_payments_for_booking($bookingNumber);
		$data['iahChargesOutput'] = $this->charges_model->get_iah_charges_by_booking_number($bookingNumber);
		$data['ownerChargesOutput'] = $this->charges_model->get_owner_charges_by_booking_number($bookingNumber);
		$data['totCharges'] = $this->charges_model->get_total_charges_for_booking($bookingNumber);
		$data['iahTotCharges'] = $this->charges_model->get_iah_total_charges_for_booking($bookingNumber);
		$data['ownerTotCharges'] = $this->charges_model->get_owner_total_charges_for_booking($bookingNumber);
		$data['commissionCombo'] = $this->global_model->get_commission_combo();
		$referral = $currentQuery[0]->customer_referral;
		$data['referralCombo'] = $this->global_model->get_referral_combo($referral);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('bookings/edit_booking_controlbar_view',$data);
		$this->load->view('bookings/edit_view',$data);
		$this->load->view('footer_view');
	}

/*	VIEW BOOKING */
	function view_booking($bookingNumber)
	{
		$data['heading'] = 'View Booking';
		$data['query'] = $this->booking_model->get_booking_by_booking_number($bookingNumber);
		$currentQuery = $data['query']->result();
		$data['payments'] = $this->payment_model->get_payments_by_booking_number($bookingNumber);
		$data['totPayments'] = $this->payment_model->get_total_payments_for_booking($bookingNumber);
		$data['iahChargesOutput'] = $this->charges_model->get_iah_charges_by_booking_number($bookingNumber);
		$data['ownerChargesOutput'] = $this->charges_model->get_owner_charges_by_booking_number($bookingNumber);
		$data['totCharges'] = $this->charges_model->get_total_charges_for_booking($bookingNumber);
		$data['iahTotCharges'] = $this->charges_model->get_iah_total_charges_for_booking($bookingNumber);
		$data['ownerTotCharges'] = $this->charges_model->get_owner_total_charges_for_booking($bookingNumber);
		$data['commissionCombo'] = $this->global_model->get_commission_combo();
		$referral = $currentQuery[0]->customer_referral;
		$data['referralCombo'] = $this->global_model->get_referral_combo($referral);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('bookings/edit_booking_controlbar_view',$data);
		$this->load->view('bookings/booking_view',$data);
		$this->load->view('footer_view');
	}

/*	UPDATE A SALE*/
	function update_sale()
	{
		$bookingNumber = $this->input->post('bookingNumber');
		$customerReferral = $this->input->post('customerReferral');
		$propertyList = $this->input->post('propertyList');
		$fromTime = $this->input->post('fromTime');
		$adults = $this->input->post('adults');
		$children = $this->input->post('children');
		$infants = $this->input->post('infants');
		$toTime = $this->input->post('toTime');
		$cot = $this->input->post('cot');
		$highchair = $this->input->post('highchair');
		$bookingNotes = $this->input->post('customerSpecials');
		$customerSpecials = $this->input->post('customerSpecials');
		$accommCost = $this->input->post('accommCost');
		$bookingDiscount = $this->input->post('bookingDiscount');
		$bookingFee = $this->input->post('bookingFee');
		$customerPrice = $this->input->post('customerPrice');
		$customerTotalPaid = $this->input->post('customerTotalPaid');
		$customerTotalCharges = $this->input->post('customerTotalCharges');
		$customerBalance = $this->input->post('customerBalance');
		$commissionableCost = $this->input->post('commissionableCost');
		$commissionPercentage = $this->input->post('commissionPercentage');
		$commissionAmount = $this->input->post('commissionAmount');
		$agentFee = $this->input->post('agentFee');
		$ownerBalance = $this->input->post('ownerBalance');
		$ownerPaidDate = $this->input->post('ownerPaidDate');
		$ownerReference = $this->input->post('ownerReference');
		$ownerPaymentMethod = $this->input->post('ownerPaymentMethod');
		$balanceDue = $this->input->post('balanceDue');
		$ownerNotifiedDate = $this->input->post('ownerNotifiedDate');
		$reminderSent = $this->input->post('reminderSent');
		$checkinSent = $this->input->post('checkinSent');
		$ownerNotified = $this->input->post('ownerNotified');
		$repeatBusiness = $this->input->post('repeatBusiness');
		$rxTransId = $this->input->post('rxTransId');

		$result = $this->booking_model->update_sale_by_id($bookingId,$customerReferral,$propertyList,$fromTime,$adults,$children,$infants,$toTime,$cot,$highchair,$bookingNotes,$accommCost,$bookingDiscount,$bookingFee,$customerPrice,$customerTotalPaid,$customerTotalCharges,$customerBalance,$commissionableCost,$commissionPercentage,$commissionAmount,$agentFee,$ownerBalance,$ownerPaidDate,$ownerReference,$ownerPaymentMethod,$balanceDue,$ownerNotifiedDate,$reminderSent,$checkinSent,$ownerNotified,$repeatBusiness,$bookingStatus,$rxTransId);

		$data['query'] = $this->booking_model->get_sale_by_booking_id($bookingNumber);
		$this->edit_sale($bookingId);
	}


/*	RESET PAYMENTS */
	function reset_payments()
	{
		$query = $this->db->query("select * from bookings where bookingStatus='PAYMNT'");
	    foreach ($query->result() as $item)
		{
			$totalPayment = $this->payment_model->get_total_payments_for_booking($item->bookingNumber);
			$this->booking_model->put_payment($item->bookingNumber,$totalPayment);
		}
	}

/*	RESET CHARGES */
	function reset_charges()
	{
		$query = $this->db->query("select * from bookings where bookingStatus='PAYMNT'");
	    foreach ($query->result() as $item)
		{
			$totalCharge = $this->charges_model->get_total_charges_for_booking($item->bookingNumber);
			$this->booking_model->put_charge($item->bookingNumber,$totalCharge);
		}
	}

/*	TOT UP BOOKINGS */
	function clean_up()
	{
		$query = $this->db->query("select * from bookings where bookingStatus='PAYMNT'");
	    foreach ($query->result() as $item)
		{
			// Incoming fields for math
			$accommCost = $item->accommCost;
			$bookingFee = $item->bookingFee;
			$customerTotalCharges = $item->customerTotalCharges;
			$bookingDiscount = $item->bookingDiscount;
			$customerTotalPaid = $item->customerTotalPaid;
			$commissionPercentage = $item->commissionPercentage;

			// Start the math
			$customerPrice = $accommCost + $bookingFee + $customerTotalCharges - $bookingDiscount;
			$customerBalance = $customerPrice - $customerTotalPaid;
			$commissionableCost = $accommCost - $bookingDiscount +  $customerTotalCharges;
			$commissionAmount = ($commissionableCost * $commissionPercentage)/100;
			$agentFee = $bookingFee + $commissionAmount;
			$ownerBalance = $commissionableCost - $commissionAmount;

			$this->booking_model->clean_up($item->bookingNumber,$customerPrice,$customerBalance,$commissionableCost,$commissionAmount,$agentFee,$ownerBalance);

		}
	}

/*	CLEAN UP BOOKINGS STATUS FOR WHOLE TABLE */
	function update_all_status()
	{
		$query = $this->db->query("select * from bookings");
	    foreach ($query->result() as $item)
		{
			$this->update_booking_status($item->bookingNumber);
		}
	}

	function update_booking_status($bookingNumber)
	{
		$bookingStatus = '';
		$query = $this->booking_model->get_booking_by_booking_number($bookingNumber);
		foreach ($query->result() as $item)
		{
			$customerNotificationStatus = explode('|',$item->customerNotificationStatus);
			$ownerNotificationStatus = explode('|',$item->ownerNotificationStatus);


			if ($item->customerBalance >= '1' and $item->ownerReference == '')
			{
				$bookingStatus = 'BALANCE-NOREF'; // (deposit paid, no reference)
			}
			if ($item->customerBalance >= '1' and $item->ownerReference != '')
			{
				$bookingStatus = 'BALANCE'; // (deposit paid)
			}
			if ($item->customerBalance == '0' and $item->ownerReference == '')
			{
				$bookingStatus = 'ZEROBAL-NOREF'; // (paid in full)
			}

			if ($item->customerBalance == '0' and $item->ownerReference != '' and ($customerNotificationStatus[2] == 'CRN' OR $ownerNotificationStatus[2] == 'ORN' and $item->ownerPaid =='no'))
			{
				$bookingStatus = 'ZEROBAL-REF'; // (reference obtained)
			}

			if ($item->customerBalance == '0' and $item->ownerReference != '' and ($customerNotificationStatus[2] == 'CRS' and $ownerNotificationStatus[2] == 'ORS' and $item->ownerPaid =='no'))
			{
				$bookingStatus = 'ZEROBAL-REF-CHK'; // (instructions sent)
			}

			if ($item->customerBalance == '0' and $item->ownerReference != '' and $customerNotificationStatus[2] == 'CRS' and $item->ownerPaid == 'yes')
			{
				$bookingStatus = 'ZEROBAL-REF-CHK-OWNER'; // (owner paid)
			}

			if ($item->bookingStatus == 'CANCELLED')
			{
				$bookingStatus = 'CANCELLED'; // cancelled
			}

			$this->booking_model->update_booking_status($bookingNumber,$bookingStatus);

		}
	}

}// End of class

?>
