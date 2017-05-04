<?php
/**
 * Rates
 * 
 * @package Ireland at Home 2009
 * @author 
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Rates extends Controller
{

/*	CONSTRUCTOR */
    function Rates()
    {
        parent::Controller();
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->library('validation');
        $this->load->model('global_model');
        $this->load->model('booking_model');
        $this->load->model('sales_model');
        $this->load->model('comms_model');
        $this->global_model->is_logged_in();
    }

/*	INDEX */
    function index()
    {
        $headerView = $this->global_model->get_standard_header_view();
		$data['ratesTable'] = $this->ratescheck_model->list_rates();
		$this->load->view('ratescheck/ratescheck_input_view',$data);
		$this->load->view('footer_view');
	}

/* 	TESTING RATES */    
    function get_rates()
    {
		$fromDate = $this->input->post('fromDate');
		$toDate = $this->input->post('toDate');
		$nights = $this->global_model->daysDifference($fromDate,$toDate);
		$data['heading'] = 'Rates';
		$data['results'] = $this->ratescheck_model->get_rates($fromDate,$toDate,$nights);
		$data['fromDate'] = $fromDate;
		$data['toDate'] = $toDate;
		$data['nights'] = $nights;
		$data['ratesTable'] = $this->ratescheck_model->list_rates();
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('ratescheck/ratescheck_view',$data);
		$this->load->view('footer_view');	
    }
		
}// End of class

?>
