<?php
/**
 * Global - For getting and setting system vars
 * 
 * @package Ireland at Home 2009
 * @author 
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Global extends Controller
{

/*	INDEX */
    function index()
    {
		$data['heading'] = 'Current special offers';
    }

/*	CONSTRUCTOR */
    function Global()
    {
        parent::Controller();
        $this->load->database();
        $this->public_db = $this->load->database('public', true);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('validation');
        $this->load->model('global_model');
        $this->load->model('specials_model');
        $this->load->model('property_model');
        $this->global_model->is_logged_in();
    }
    
    function list_special_offers()
    {
	    $data['heading'] = 'Current special offers';
	    $data['propertyCombo'] = $this->property_model->get_property_combo('');
	    $data['results'] = $this->specials_model->get_special_offers();
	    $headerView = $this->global_model->get_standard_header_view();
	    $this->load->view('specials/special_offers_list_controlbar_view');
	    $this->load->view('specials/list_special_offers_view', $data);
	    $this->load->view('footer_view');
    }

/*	SAVE SEASONAL DATES */
	function set_holiday_dates()
	{
		$inputData = array(
		'easterFrom' => $this->input->post('propertyCode'),
		'fromDate' => $this->input->post('offerFromDate'),
		'toDate' => $this->input->post('offerToDate'),
		'rangeType' => $this->input->post('rangeType'),
		'offerPrice' => $this->input->post('offerPrice'),
		'offerDescription' => $this->input->post('offerDescription'),
		'offerDate' => date('Y-m-d')
		);
		$this->specials_model->add_special_offer($inputData);
		$this->list_special_offers();
	}

	/*	DELETE A SPECIAL OFFER */
		function delete_special_offer($offerId)
		{
			$this->specials_model->delete_special_offer($offerId);
			$this->list_special_offers();
		}



    function get_holiday_data()
    {
    	// Gets holidays and dates from db
        $data['heading'] = 'Holidays';
        $data['results'] = $this->global_model->get_holiday_data();
        $headerView = $this->global_model->get_standard_header_view();
        $this->load->view('global/holiday_list_view', $data);
        $this->load->view('footer_view');
    }
    
    
    

}

/* End of file global.php */
/* Location: ./system/controllers/global.php */