<?php
/**
 * Search
 * 
 * @package Ireland at Home 2009
 * @author 
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Search extends Controller
{

/*	INDEX */
    function index()
    {
        $data['heading'] = 'Latest Queries';
        //$data['results'] = $this->enquiries_model->get_latest_queries();
        $headerView = $this->global_model->get_standard_header_view();
        $this->load->view('enquiries/enquiries_list_view', $data);
        $this->load->view('footer_view');
    }

/*	CONSTRUCTOR */
    function Search()
    {
        parent::Controller();
        //$this->output->enable_profiler(TRUE);
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('validation');
        $this->load->model('customer_model');
        $this->load->model('property_model');
        $this->load->model('search_model');
        $this->load->model('sales_model');
        $this->load->model('booking_model');
        $this->load->model('global_model');
        $this->global_model->is_logged_in();
    }
    
/* CUSTOMER SEARCH INPUT */
	function customer_search_input()
	{
		$data['heading'] = 'Customer search';
        $headerView = $this->global_model->get_standard_header_view();
        $this->load->view('search/customer_search_input_view', $data);
        $this->load->view('footer_view');
	}

/* FIND CUSTOMER */
	function find_customer()
	{
		$fieldName = $this->input->post('fieldName');
		$keyWord = $this->input->post('keyWord');
		$data['heading'] = 'Customer search results';
        $headerView = $this->global_model->get_standard_header_view();
        $data['results'] = $this->search_model->search_customers($fieldName,$keyWord);
        $this->load->view('search/customer_search_list_view', $data);
        $this->load->view('footer_view');		
	}

/*	FIND SALES/BOOKINGS BY CUSTOMER */
	function customer_sales()
	{
		$customerNumber = $this->uri->segment(3);
		$data['heading'] = 'Customer transactions';
        $headerView = $this->global_model->get_standard_header_view();
        $data['salesResults']  = $this->sales_model->get_sales_by_customerid($customerNumber);
        $data['bookingResults'] = $this->booking_model->get_bookings_by_customerid($customerNumber);
        $this->load->view('search/customer_transactions_list_view', $data);
        $this->load->view('footer_view');
	}	

/*	FIND SALES/BOOKINGS */
	function sales_search_input()
	{
		$data['heading'] = 'Sales search';
		$data['propertyCombo'] = $this->property_model->get_property_combo('');
		$data['referallCombo'] = $this->global_model->get_referral_combo('');
        $headerView = $this->global_model->get_standard_header_view();
        $this->load->view('search/sales_search_input_view', $data);
        $this->load->view('footer_view');
	}

/*	FIND SALES/BOOKINGS BY CUSTOMER */
	function find_sales()
	{
		$searchBy = $this->input->post('searchBy');
		$kwd = $this->input->post('kwd');
		$data['heading'] = 'Bookings and sales search';
        $headerView = $this->global_model->get_standard_header_view();
        $data['salesResults']  = $this->sales_model->find_sales($searchBy,$kwd);
        $data['bookingResults'] = $this->booking_model->find_bookings($searchBy,$kwd);
        $this->load->view('search/customer_transactions_list_view', $data);
        $this->load->view('footer_view');
	}



/*	EDIT CUSTOMER */
	function edit_customer()
	{
		$fieldName = $this->input->post('fieldName');
		$keyWord = $this->input->post('keyWord');
		$data['heading'] = 'Customer search results';
        $headerView = $this->global_model->get_standard_header_view();
        $data['results'] = $this->search_model->search_customers($fieldName,$keyWord);
        $this->load->view('search/customer_search_list_view', $data);
        $this->load->view('footer_view');		
	}
	    
}
?>