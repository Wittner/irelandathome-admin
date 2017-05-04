<?php
/**
 * Rates check
 * 
 * @package Ireland at Home 2009
 * @author 
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Ratescheck extends Controller
{

/*	CONSTRUCTOR */
    function Ratescheck()
    {
        parent::Controller();
        $this->load->database();
        $this->public_db = $this->load->database('public', true);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->library('validation');
        $this->load->model('global_model');
        $this->load->model('booking_model');
        $this->load->model('property_model');
        $this->load->model('sales_model');
        $this->load->model('comms_model');
        $this->load->model('ratescheck_model');
        $this->global_model->is_logged_in();
    }

/*	INDEX */
    function index()
    {
        $headerView = $this->global_model->get_standard_header_view();
        $data['propertyCombo'] = $this->property_model->get_bookable_properties_combo('JAIA01');
		$this->load->view('ratescheck/ratescheck_input_view',$data);
		$this->load->view('footer_view');
	}

/* 	TESTING RATES */    
    function get_rates()
    {
		$fromDate = $this->global_model->toSqlDate($this->input->post('fromDate'));
		$toDate = $this->global_model->toSqlDate($this->input->post('toDate'));
		$propertyCode = $this->input->post('propertyCode');
		$nights = $this->global_model->daysDifference($fromDate,$toDate);
		$data['heading'] = 'Rates';
		$data['results'] = $this->ratescheck_model->get_rates($propertyCode,$fromDate,$toDate,$nights);
		$data['fromDate'] = $fromDate;
		$data['toDate'] = $toDate;
		$data['nights'] = $nights;
		$data['propertyName'] = $this->property_model->get_property_name_by_code($propertyCode);
		$data['ratesTable'] = $this->ratescheck_model->list_rates($propertyCode);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('ratescheck/ratescheck_view',$data);
		$this->load->view('footer_view');	
    }


		
}// End of class

?>
