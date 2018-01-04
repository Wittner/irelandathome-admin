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
class Sales extends Controller
{

/*	INDEX */
    function index()
    {
		list_queries();
    }

/*	CONSTRUCTOR */
    function Sales()
    {
        parent::Controller();
        $this->load->database();
        $this->public_db = $this->load->database('public', true);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('validation');
        $this->load->library('pagination');
        $this->load->model('sales_model');
        $this->load->model('booking_model');
        $this->load->model('payment_model');
        $this->load->model('charges_model');
        $this->load->model('customer_model');
        $this->load->model('property_model');
        $this->load->model('company_model');
        $this->load->model('availability_model');
        $this->load->model('offer_model');
        $this->load->model('enquiries_model');
        $this->load->model('global_model');
        $this->load->model('comms_model');
        $this->global_model->is_logged_in();
    }

/* SHOW QUERIES */
    function list_queries()
    {
        $config['base_url'] = base_url().'index.php/';
	    $config['total_rows'] = $this->sales_model->count_current_queries();
	    $config['per_page'] = '20';
	    $config['full_tag_open'] = '<div>';
	    $config['full_tag_close'] = '</div>';
	    $this->pagination->initialize($config);
	    $data['results'] = $this->enquiries_model->get_latest_queries($config['per_page'],$this->uri->segment(3));
		$data['heading'] = 'Latest Queries';
        $headerView = $this->global_model->get_standard_header_view();
        $this->load->view('enquiries/enquiries_list_view', $data);
        $this->load->view('footer_view');
    }


/*	START A SALE */
    function create_sale()
    {
		// Data from form
		$enquiryId = $this->input->post('enquiryId');
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
		$fromDate = $this->global_model->toSqlDate($fromDate);
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
		$paymentRef = $this->input->post('paymentRef');
		$chargeAmount = $this->input->post('chargeAmount');
		$chargePurpose = $this->input->post('chargePurpose');
		$enquiryDate = $this->input->post('enquiryDate');
		$saleDate = date('Y-m-d');
		$adminInit = 'MB';
		$sourceCode = 'ADM';
		$saleStatus = 'OPEN';

        // Check if we have a customer number - if not, see if customer already in db. If yes then resolve conflict. If no create new customer record. Continue to sale
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
				$data['saleDate'] = $saleDate;
				$data['saleStatus'] = $saleStatus;
				$data['enquiryId'] = $enquiryId;

				// Set existing customer data
				$data['query'] = $this->customer_model->get_customer_by_number($checkCustomerNumber);

				// Load conflict view
				$headerView = $this->global_model->get_standard_header_view();
				$this->load->view('sales/sales_conflict_view',$data);
				$this->load->view('footer_view');
			}
			else
			{
				// Customer is new - add customer, then add sale

				// Add customer
				$customerNumber = $this->customer_model->add_customer($customerName,$customerSurname,$customerLandphone,$customerMobile,$customerEmail,$customerCountry,$customerAddress,$customerReferral,$customerDate,$customerCompanyId);

				// Add sale
				$data['heading'] = 'Edit Sale';
				$saleId = $this->sales_model->create_new_sale($enquiryDate,$saleDate,$saleStatus,$customerNights,$customerNumber,$customerReferral,$propertyList,$fromDate,$fromTime,$adults,$children,$infants,$cot,$highchair,$toDate,$toTime,$propertyCode,$customerSpecials,$sourceCode,$adminInit);
				$this->edit_sale($saleId);
				if($saleId != '')
				{
					$this->enquiries_model->delete_enquiry_by_id($enquiryId);
				}
			}
    	}
	}

/*	MAKE A NEW SALE WITH CUSTOMER CONFLICT */
	function customer_conflict()
	{
		// Sale will have come in from 'sales customer conflict' view

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
		$saleDate = $this->input->post('saleDate');
		$saleStatus = $this->input->post('saleStatus');
		$enquiryId = $this->input->post('enquiryId');

		// General booking data
        $enquiryDate = date('Y-m-d');
        $bookingDate = date('Y-m-d');
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

			// Add sale
			$data['heading'] = 'Edit Sale';
			$saleId = $this->sales_model->create_new_sale($enquiryDate,$saleDate,$saleStatus,$customerNights,$customerNumber,$customerReferral,$propertyList,$fromDate,$fromTime,$adults,$children,$infants,$cot,$highchair,$toDate,$toTime,$propertyCode,$customerSpecials,$sourceCode,$adminInit);
			if($saleId != '')
			{
				$this->enquiries_model->delete_enquiry_by_id($enquiryId);
			}
			$this->edit_sale($saleId,$propertyCode);
	}


/*	UPDATE / CONVERT A SALE*/
	function update_sale()
	{
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
		$commissionPercentage = $this->input->post('commissionPercentage');
		$propertyName = $this->input->post('propertyName');
		$paymentMethod = $this->input->post('paymentMethod');
		$paymentPurpose = $this->input->post('paymentPurpose');
		$paymentAmount = $this->input->post('paymentAmount');
		$paymentRef = strtoupper($this->input->post('paymentRef'));
		$chargeAmount = $this->input->post('chargeAmount');
		$chargePurpose = $this->input->post('chargePurpose');
		$saleId = $this->input->post('saleId');

		// Update customer and sales data
		$this->customer_model->update_customer($customerNumber,$customerName,$customerSurname,$customerCompanyId,$customerLandphone,$customerMobile,$customerEmail,$customerCountry,$customerAddress,$customerReferral,$customerDate);
		$this->sales_model->update_sale($saleId,$customerNights,$customerNumber,$customerReferral,$propertyList,$fromDate,$fromTime,$adults,$children,$infants,$cot,$highchair,$toDate,$toTime,$propertyCode,$customerSpecials);
		$action = $this->input->post('update');
		if($action == 'Update sale')
		{
			$this->edit_sale($saleId);
		}
		else
		{
			// Convert to booking
			$rules['paymentRef']	= "required";
			$this->validation->set_rules($rules);
			$this->validation->set_message('required', '*Required*');
			$this->validation->set_error_delimiters('<SPAN STYLE="color: #ff0000; font-weight: bold;">', '</SPAN>');
			$data['payment_ref']	= strtoupper($this->input->post('payment_ref'));
			$this->validation->set_fields($data);
			if ($this->validation->run() == FALSE)
			{
				// Reload add booking view to correct validation errors
				$this->edit_sale($saleId);
			}
			else
			{
				// Add booking, payment, initial charges if any
				$data['heading'] = 'Edit Booking';
				$query = $this->sales_model->get_sale_by_id($saleId);

				foreach($query->result() as $row)
				{
				$enquiryDate = $row->enquiryDate;
				}

				$bookingDate = date('Y-m-d');
				$bookingStatus = 'PAYMNT';
				$adminInit = 'MB';
				$sourceCode = 'MAN';
				$toDate = $this->global_model->get_to_date($fromDate,$customerNights);

				$bookingNumber = $this->booking_model->create_new_booking($enquiryDate,$bookingDate,$customerNights,$customerNumber,$customerReferral,$propertyList,$fromDate,$fromTime,$adults,$children,$infants,$cot,$highchair,$toDate,$toTime,$propertyCode,$customerSpecials,$accommCost,$bookingFee,$chargeAmount,$bookingDiscount,$commissionPercentage,$bookingStatus,$adminInit,$sourceCode,$paymentMethod,$paymentPurpose,$paymentAmount,$paymentRef);
				if($bookingNumber !='')
				{
					$this->sales_model->change_sale_status($saleId,'delete');
					$this->offer_model->delete_offers_by_sale($saleId);
				}
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
				$data['referralCombo'] = $this->global_model->get_referral_combo($customerReferral);
				$headerView = $this->global_model->get_standard_header_view();
				redirect('/booking/edit_booking/' . $bookingNumber, 'refresh');
			}
		}

	}

/* 	CREATE MANUAL SALE */
	function create_manual_sale()
	{
		$data['heading'] = 'Create new manual sale. ** For existing customers, simply enter their email address **';
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('sales/new_sale_controlbar_view',$data);
		$this->load->view('sales/create_manual_sale_view',$data);
		$this->load->view('footer_view');
	}

/* 	CREATE SALE WITH CUSTOMER */
	function create_customer_sale($customerNumber)
	{
		$data['heading'] = 'Create new sale with existing customer';
		$data['query'] = $this->customer_model->get_customer_by_number($customerNumber);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('sales/new_sale_controlbar_view',$data);
		$this->load->view('sales/create_customer_sale_view',$data);
		$this->load->view('footer_view');
	}

/*	EDIT SALE */
	function edit_sale($saleId)
	{
		$data['heading'] = 'Edit Sale';
		$data['query'] = $this->sales_model->get_sale_by_id($saleId);
		foreach($data['query']->result() as $row)
		{
			$propertyCode = $row->propertyCode;
			$companyId = $row->customerCompanyId;
			$countryId = $row->customer_country;
			$referral = $row->customerReferral;
			$data['sourceCode'] = $row->sourceCode;
		}
		$data['offerList'] = $this->offer_model->list_offers($saleId);
		$data['unselectedPropertyCombo'] = $this->property_model->get_property_combo('');// Unselected property combo is for the 'add an offer' form at top of sale view
		$data['propertyCombo'] = $this->property_model->get_property_combo($propertyCode);
		$data['companyCombo'] = $this->company_model->get_company_combo($companyId);
		$data['commissionCombo'] = $this->global_model->get_commission_combo();
		$data['countryCombo'] = $this->global_model->get_country_combo($countryId);
		$data['referralCombo'] = $this->global_model->get_referral_combo($referral);
		$data['saleId'] = $saleId;
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('sales/edit_sales_controlbar_view',$data);
		$this->load->view('sales/edit_sale_view',$data);
		$this->load->view('footer_view');
	}

/*	LIST SALES */
	function list_sales()
	{
	    $config['base_url'] = base_url().'index.php/sales/list_sales';
	    $config['total_rows'] = $this->sales_model->count_current_sales();
	    $config['per_page'] = '20';
	    $config['full_tag_open'] = '<div>';
	    $config['full_tag_close'] = '</div>';
	    $this->pagination->initialize($config);

		$data['results'] = $this->sales_model->list_sales($config['per_page'],$this->uri->segment(3));
		$data['heading'] = 'Latest sales';
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('sales/sales_list_view',$data);
		$this->load->view('footer_view');
	}

/*	LIST SALES */
	function list_all_sales()
	{
		$config['total_rows'] = $this->sales_model->count_current_sales();
		$data['results'] = $this->sales_model->list_sales($config['total_rows'],$this->uri->segment(3));
		$data['heading'] = 'Latest sales';
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('sales/all_sales_list_view',$data);
		$this->load->view('footer_view');
	}

/*	ADD OFFER TO A SALE */
    function add_offer()
    {
    	$saleId = $this->input->post('offerSaleId');
    	$propertyCode = $this->input->post('offerPropertyCode');
    	$fromDate = $this->input->post('offerFromDate');
    	$toDate = $this->input->post('offerToDate');
    	$offerPrice = $this->input->post('offerPrice');

    	$adminUsername = 'Mikeb';
    	$offerQty = $this->input->post('quantity');
    	// echo '|'. $saleId.'|'.$propertyCode.'|'.$fromDate.'|'.$toDate.'|'.$offerPrice.'|'.$adminUsername.'|'.$offerQty.'|';
		$offer = $this->offer_model->add_offer($saleId,$propertyCode,$fromDate,$toDate,$offerPrice,$adminUsername,$offerQty);
    	$this->edit_sale($saleId);
    }

/*	SEND A SALE OFFER */
	function send_offer()
	{
	$saleId = $this->input->post('saleId');
	$data['query'] = $this->sales_model->get_sale_by_id($saleId);
	$data['offerList'] = $this->offer_model->get_offers_for_email($saleId);
	$data['heading'] = 'Offer email preview';
	$data['emailOpener'] = $this->comms_model->get_email_opener();
	$data['emailHeader'] = $this->comms_model->get_email_header();
	$data['emailFooter'] = $this->comms_model->get_email_footer();
	$data['emailCloser'] = $this->comms_model->get_email_closer();
	$data['saleId'] = $saleId;
	$headerView = $this->global_model->get_standard_header_view();
	$this->load->view('offers/offer_email_view',$data);
	$this->load->view('footer_view');
	}

/*	DELETE AN OFFER */
	function remove_offer($saleId,$offerId)
	{
		$this->offer_model->delete_offer($offerId);
		$this->edit_sale($saleId);
	}

}// End of class

?>
