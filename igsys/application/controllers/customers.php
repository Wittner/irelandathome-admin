<?php
/**
 * Customers
 * 
 * @package Ireland at Home 2009
 * @author 
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Customers extends Controller
{

/*	INDEX */
    function index()
    {
        $data['heading'] = 'Latest Queries';
        $data['results'] = $this->enquiries_model->get_latest_queries();
        $headerView = $this->global_model->get_standard_header_view();
        $this->load->view('enquiries/enquiries_list_view', $data);
        $this->load->view('footer_view');
    }

/*	CONSTRUCTOR */
    function Customers()
    {
        parent::Controller();
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
        $this->load->model('availability_model');
        $this->load->model('comms_model');
        $this->load->model('global_model');
        $this->global_model->is_logged_in();
    }

/*	NEW CUSTOMER INPUT */
	function add_customer_input()
	{
		$data['heading'] = 'Add customer';
		$data['companyCombo']  = $this->company_model->get_company_combo('');
		$data['countryCombo'] = $this->global_model->get_country_combo('');
		$data['propertyCombo'] = $this->property_model->get_property_combo('');
		$data['referralCombo'] = $this->global_model->get_referral_combo('');
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('controlbar_view',$data);
		$this->load->view('customers/create_customer_input_view',$data);
		$this->load->view('footer_view');
	}
    
/* 	CREATE CUSTOMER */
	function create_customer()
	{
		$customerName = $this->input->post('customerName');
		$customerSurname = $this->input->post('customerSurname');
		$customerLandphone = $this->input->post('customerLandphone');
		$customerMobile = $this->input->post('customerMobile');
		$customerEmail = $this->input->post('customerEmail');
		$customerCountry = $this->input->post('customerCountry');
		$customerAddress = $this->input->post('customerAddress');
		$customerReferral = $this->input->post('customerReferral');
		$customerDate = date('Y-m-d');
		$customerCompanyId = $this->input->post('customerCompanyId');				
		$customerNumber = $this->customer_model->add_customer($customerName,$customerSurname,$customerLandphone,$customerMobile,$customerEmail,$customerCountry,$customerAddress,$customerReferral,$customerDate,$customerCompanyId);
		$this->read_customer($customerNumber);		
	}

/* 	READ CUSTOMER */
	function edit_customer($customerNumber)
	{
		$data['heading'] = 'Edit Customer';
		$data['query'] = $this->customer_model->get_customer_by_number($customerNumber);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('controlbar_view',$data);
		$this->load->view('customers/customer_edit_view',$data);
		$this->load->view('footer_view');
	}

/* 	UPDATE CUSTOMER */
	function update_customer()
	{
		$customerNumber = $this->input->post('customerNumber');
		$customerName = $this->input->post('customerName');
		$customerSurname = $this->input->post('customerSurname');
		$customerCompanyId = $this->input->post('customerCompanyId');
		$customerLandphone = $this->input->post('customerLandphone');
		$customerMobile = $this->input->post('customerMobile');
		$customerEmail = $this->input->post('customerEmail');
		$customerCountry = $this->input->post('customerCountry');
		$customerAddress = $this->input->post('customerAddress');
		$customerReferral = $this->input->post('customerReferral');
		$customerDate = $this->input->post('customerDate');
		$customerNumber = $this->customer_model->update_customer($customerNumber,$customerName,$customerSurname,$customerCompanyId,$customerLandphone,$customerMobile,$customerEmail,$customerCountry,$customerAddress,$customerReferral,$customerDate);
		$this->edit_customer($customerNumber);
	}

/* 	DELETE CUSTOMER */
	function delete_customer($customerNumber)
	{
		$this->edit_customer($customerNumber);
	}

/*	LIST CUSTOMERS */
	function list_customers()
	{
		$data['results'] = $this->customer_model->list_customers();
		$data['heading'] = 'List Customers';
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('controlbar_view',$data);
		$this->load->view('customers/customers_list_view',$data);
		$this->load->view('footer_view');
	}

/*  GET CUSTOMER DETAIL BY CUSTOMER CODE */
	function get_customer_detail($customerCode,$field)
	{
		$this->public_db->select($field);
		$this->public_db->from('customers');
		$this->public_db->where("customer_code = '$customerCode'");
		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
		{
           	foreach($query->result() as $row)
           	{
           		$result = $row->$field;
           	}

        } else {
        	$result = '';
        }
		return $result;
	}
    
}// End of Class
?>