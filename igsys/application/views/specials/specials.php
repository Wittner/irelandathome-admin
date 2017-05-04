<?php
/**
 * Specials - Special offers controller
 * 
 * @package Ireland at Home 2009
 * @author 
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Specials extends Controller
{

/*	INDEX */
    function index()
    {
		$data['heading'] = 'Current special offers';
    }

/*	CONSTRUCTOR */
    function Specials()
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
        //$this->global_model->is_logged_in();
        // $this->output->enable_profiler(TRUE);
    }
    
    function list_special_offers()
    {
	    $data['heading'] = 'Current special offers';
	    $data['propertyCombo'] = $this->property_model->get_property_combo('');
	    $data['results'] = $this->specials_model->get_special_offers();
	    $data['holidayDropDown'] = $this->global_model->get_holiday_dropdown();
	    $headerView = $this->global_model->get_standard_header_view();
	    $this->load->view('specials/special_offers_list_controlbar_view');
	    $this->load->view('specials/list_special_offers_view', $data);
	    $this->load->view('footer_view');
    }

/*	GET SPECIAL OFFER */
	/* 	Take in a property code, a from and to date and see if we have any offers
		for that property. If we do, return back the html code for the offer
		otherwise return 'none'
	*/
	function get_special_offer_code($propertyCode = 'any', $fromDate = 'any', $toDate = 'any', $holiday = 'any')
	{
		$this->output->cache(5);
		$data['result'] = $this->specials_model->get_special_offer_code($propertyCode, $fromDate, $toDate, $holiday);
		$this->load->view('specials/render_special_offer_view', $data);
	}


/*	ADD A SPECIAL OFFER */
	function add_special_offer()
	{
		$holidayArray = explode('|', $this->input->post('holiday'));
		$holidayName = $holidayArray[1];
		$inputData = array(
		'propertyCode' => $this->input->post('propertyCode'),
		'holiday' => $holidayName,
		'fromDate' => $this->global_model->toSqlDAte($this->input->post('offerFromDate')),
		'toDate' => $this->global_model->toSqlDate($this->input->post('offerToDate')),
		'rangeType' => $this->input->post('rangeType'),
		'offerPrice' => $this->input->post('offerPrice'),
		'offerDescription' => $this->input->post('offerDescription'),
		'offerDate' => date('Y-m-d')
		);
		$this->specials_model->add_special_offer($inputData);
		$this->list_special_offers();
	}
	
/*	EDIT A SPECIAL OFFER */
	function edit_special_offer($offerId)
	{
		$data['specialsResult'] = $this->specials_model->edit_special_offer($offerId);
		$data['propertyCombo'] = $this->property_model->get_property_combo('');
		$data['holidayDropDown'] = $this->global_model->get_holiday_dropdown();
		$this->load->view('specials/edit_specials_input', $data);
	}

/*	DELETE A SPECIAL OFFER */
	function delete_special_offer($offerId)
	{
		$this->specials_model->delete_special_offer($offerId);
		$this->list_special_offers();
	}

}
?>