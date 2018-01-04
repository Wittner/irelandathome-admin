<?php
/**
 * Properties
 *
 * @package Ireland at Home 2009
 * @author
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Properties extends Controller
{

    function Properties()
    {
        parent::Controller();
        $this->load->database();
        $this->public_db = $this->load->database('public', true);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('property_model');
        $this->load->model('booking_model');
        $this->load->model('global_model');
        $this->load->model('owner_model');
        $this->load->model('town_model');
        $this->load->model('rates_model');
        $this->global_model->is_logged_in();
    }

    function index()
    {
        $data['heading'] = 'Latest Queries';
        $data['results'] = $this->enquiries_model->get_latest_queries();
        $headerView = $this->global_model->get_standard_header_view();
        $this->load->view('enquiries/enquiries_list_view', $data);
        $this->load->view('footer_view');
    }

/*	LIST PROPERTIES */
    function list_properties($filter = 'live')
    {
    	switch ($filter) {
    	    case 'live':
    	        $searchFilter = 'LVE';
    	        break;
    	    case 'not':
    	        $searchFilter = 'OFF';
    	        break;
    	    case 'all':
    	        $searchFilter = 'all';
    	        break;
    	}
		$data['heading'] = 'Select a property to edit: ';
    $data['results'] = $this->property_model->list_properties($searchFilter);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('controlbar_view',$data);
    $this->load->view('properties/properties_list_view',$data);
		$this->load->view('footer_view');
    }

/*	PROPERTY AUTOCOMPLETE LIST */
    function property_autocomplete($q)
    {
		$propertyAutoCompleteData = $this->property_model->get_property_autocomplete($q);
		echo $propertyAutoCompleteData;
    }

/*  ADD PROPERTY */
	function add_property_input()
	{
		$data['heading'] = 'Add Property';
		$data['ownerCombo'] = $this->owner_model->get_owner_combo('');
		$data['townCombo'] = $this->town_model->get_town_combo('');
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('controlbar_view',$data);
		$this->load->view('properties/add_property_view',$data);
		$this->load->view('footer_view');
	}
	function add_property()
	{
		$inputData = array(
		'property_name' => $this->input->post('property_name'),
		'property_code' => $this->input->post('property_code'),
		'property_owner_id' => $this->input->post('property_owner_id'),
		'caretaker_name' => $this->input->post('caretaker_name'),
		'caretaker_number' => $this->input->post('caretaker_number'),
		'property_address' => $this->input->post('property_address'),
		'property_directions' => $this->input->post('property_directions'),
		'country_id' => $this->input->post('country_id'),
		'property_town_id' => $this->input->post('property_town_id'),
		'property_status' => $this->input->post('property_status'),
		'property_standard' => $this->input->post('property_standard'),
		'property_capacity' => $this->input->post('property_capacity'),
		'property_bedrooms' => $this->input->post('property_bedrooms')
		);
		$propertyId = $this->property_model->add_property($inputData);
		$propertyCode = $this->property_model->get_property_code_by_id($propertyId);
		$this->edit_property($propertyCode);
	}

/*	EDIT PROPERTY */
	function edit_property($propertyCode)
	{
		$data['heading'] = 'Edit Property';
		$data['query'] = $this->property_model->get_property_by_code($propertyCode);
		$data['companyData'] = $this->global_model->get_company_data();
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('properties/property_edit_controlbar_view',$data);
		$this->load->view('properties/property_edit_view',$data);
		$this->load->view('footer_view');
	}

/*	UPDATE PROPERTIES */
	function update_property()
	{
		$propertyCode = $this->input->post('property_code');
        if($propertyCode == ''){
            $this->list_properties();
        }
		$inputData = array(
		'property_type' => $this->input->post('property_type'),
    'iah_availability' => $this->input->post('iah_availability'),
		'caretaker_name' => $this->input->post('caretaker_name'),
		'caretaker_number' => $this->input->post('caretaker_number'),
		'caretaker_email' => $this->input->post('caretaker_email'),
		'annual_fee' => $this->input->post('annual_fee'),
		'livebook' => $this->input->post('livebook'),
		'property_units' => $this->input->post('property_units'),
		'annual_fee_amount' => $this->input->post('annual_fee_amount'),
		'commission_percent' => $this->input->post('commission_percent'),
		'golf' => $this->input->post('golf'),
		'surfing' => $this->input->post('surfing'),
		'fishing' => $this->input->post('fishing'),
		'beach' => $this->input->post('beach'),
		'apt' => $this->input->post('apt'),
		'pets' => $this->input->post('pets'),
		'accessible' => $this->input->post('accessible'),
		'couples' => $this->input->post('couples'),
		'groups' => $this->input->post('groups'),
		'internet' => $this->input->post('internet'),
		'property_address' => $this->input->post('property_address'),
		'lat' => $this->input->post('lat'),
		'lng' => $this->input->post('lng'),
		'nightly_rate' => $this->input->post('nightly_rate'),
		'security_deposit' => $this->input->post('security_deposit'),
		'cleaning_fee' => $this->input->post('cleaning_fee'),
		'utilities' => $this->input->post('utilities'),
		'check_in' => $this->input->post('check_in'),
		'check_out' => $this->input->post('check_out'),
		'area_description' => $this->input->post('area_description'),
		'property_directions' => $this->input->post('property_directions'),
		'property_town_id' => $this->input->post('property_town_id'),
		'property_status' => $this->input->post('property_status'),
		'property_standard' => $this->input->post('property_standard'),
		'weight' => $this->input->post('weight'),
		'strapline' => $this->input->post('strapline'),
		'property_capacity' => $this->input->post('property_capacity'),
		'property_bedrooms' => $this->input->post('property_bedrooms'),
		'property_bathrooms' => $this->input->post('property_bathrooms'),
		'layout_1' => $this->input->post('layout_1'),
		'layout_2' => $this->input->post('layout_2'),
		'layout_3' => $this->input->post('layout_3'),
		'layout_4' => $this->input->post('layout_4'),
		'layout_5' => $this->input->post('layout_5'),
		'layout_6' => $this->input->post('layout_6'),
		'property_intro' => $this->input->post('property_intro'),
    'property_intro_corporate' => $this->input->post('property_intro_corporate'),
		'property_description' => $this->input->post('property_description'),

		'pic1' => $this->input->post('pic1'),
		'pic1_descrip' => $this->input->post('pic1_descrip'),
		'pic2' => $this->input->post('pic2'),
		'pic2_descrip' => $this->input->post('pic2_descrip'),
		'pic3' => $this->input->post('pic3'),
		'pic3_descrip' => $this->input->post('pic3_descrip'),
		'pic4' => $this->input->post('pic4'),
		'pic4_descrip' => $this->input->post('pic4_descrip'),

		'hiSeasonStart' => $this->input->post('hiSeasonStart'),
		'hiSeasonEnd' => $this->input->post('hiSeasonEnd'),

		'rate_period1' => $this->input->post('rate_period1'),
		'period1_cost' => $this->input->post('period1_cost'),

		'rate_period2' => $this->input->post('rate_period2'),
		'period2_cost' => $this->input->post('period2_cost'),

		'rate_period3' => $this->input->post('rate_period3'),
		'period3_cost' => $this->input->post('period3_cost'),

		'rate_period4' => $this->input->post('rate_period4'),
		'period4_cost' => $this->input->post('period4_cost'),

		'rate_period5' => $this->input->post('rate_period5'),
		'period5_cost' => $this->input->post('period5_cost'),

		'rate_period6' => $this->input->post('rate_period6'),
		'period6_cost' => $this->input->post('period6_cost'),

		'rate_period7' => $this->input->post('rate_period7'),
		'period7_cost' => $this->input->post('period7_cost'),

		'rate_period8' => $this->input->post('rate_period8'),
		'period8_cost' => $this->input->post('period8_cost'),

		'rate_period9' => $this->input->post('rate_period9'),
		'period9_cost' => $this->input->post('period9_cost'),

		'rate_period10' => $this->input->post('rate_period10'),
		'period10_cost' => $this->input->post('period10_cost'),

		'rate_period11' => $this->input->post('rate_period11'),
		'period11_cost' => $this->input->post('period11_cost'),

		'rate_period12' => $this->input->post('rate_period12'),
		'period12_cost' => $this->input->post('period12_cost'),

		'rate_period13' => $this->input->post('rate_period13'),
		'period13_cost' => $this->input->post('period13_cost'),

		'rate_period14' => $this->input->post('rate_period14'),
		'period14_cost' => $this->input->post('period14_cost'),

		'rate_period15' => $this->input->post('rate_period15'),
		'period15_cost' => $this->input->post('period15_cost'),

		'rate_period16' => $this->input->post('rate_period16'),
		'period16_cost' => $this->input->post('period16_cost'),

		'rate_period17' => $this->input->post('rate_period17'),
		'period17_cost' => $this->input->post('period17_cost'),

		'rate_period18' => $this->input->post('rate_period18'),
		'period18_cost' => $this->input->post('period18_cost'),

		'rate_period19' => $this->input->post('rate_period19'),
		'period19_cost' => $this->input->post('period19_cost'),

		'rate_period20' => $this->input->post('rate_period20'),
		'period20_cost' => $this->input->post('period20_cost'),

		'rate_comment' => $this->input->post('rate_comment'),
		'rates_status' => $this->input->post('rates_status'),
		'offer_descrip' => $this->input->post('offer_descrip'),
		'valid_for' => $this->input->post('valid_for'),
		'offer_price' => $this->input->post('offer_price'),
		'live_offer' => $this->input->post('live_offer'),
		'front_page' => $this->input->post('front_page'),
		'live_promo' => $this->input->post('live_promo'),
		'cooker' => $this->input->post('cooker'),
		'washer' => $this->input->post('washer'),
		'tumbler' => $this->input->post('tumbler'),
		'dishwasher' => $this->input->post('dishwasher'),
		'micro' => $this->input->post('micro'),
		'fridge' => $this->input->post('fridge'),
		'cheating' => $this->input->post('cheating'),
		'fire' => $this->input->post('fire'),
		'tv' => $this->input->post('tv'),
		'vid' => $this->input->post('vid'),
		'dvd' => $this->input->post('dvd'),
		'ensuite' => $this->input->post('ensuite'),
		'bath' => $this->input->post('bath'),
		'shower' => $this->input->post('shower'),
		'cot' => $this->input->post('cot'),
		'highchair' => $this->input->post('highchair'),
		'linen' => $this->input->post('linen'),
		'towels' => $this->input->post('towels'),
		'baby' => $this->input->post('baby'),
		'iron' => $this->input->post('iron'),
		'bf' => $this->input->post('bf'),
		'terms' => $this->input->post('terms'),
		'disclaimer' => $this->input->post('disclaimer')
		);
	$this->property_model->update_property($propertyCode,$inputData);
	$this->edit_property($propertyCode);
	}

/*	EDIT RATES FOR SINGLE PROPERTY */
	function show_rates($propertyCode)
	{
		$data['heading'] = 'Edit Rates';
		$data['unselectedPropertyCombo'] = $this->property_model->get_property_combo('');
		$data['propertyQuery'] = $this->property_model->get_property_by_code($propertyCode);
		$data['ratesQuery'] = $this->property_model->get_property_rates_by_code($propertyCode);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('properties/property_rates_controlbar_view',$data);
		$this->load->view('properties/edit_rates_view',$data);
		$this->load->view('footer_view');
	}

/*	UPDATE A SINGLE RATE */
	function update_single_rate()
	{
		$rateId = $this->input->post('rateId');
		$propertyCode = $this->input->post('propertyCode');
		//echo $rateId;
		//echo '|' . $checkDate . '|';
		$inputData = array(
		'fromDate' => $this->input->post('fromDate'.$rateId),
		'toDate' => $this->input->post('toDate'.$rateId),
		'rateOne' => $this->input->post('rateOne'),
		'rateTwo' => $this->input->post('rateTwo'),
		'rateThree' => $this->input->post('rateThree'),
		'rateFour' => $this->input->post('rateFour'),
		'rateFive' => $this->input->post('rateFive'),
		'rateSix' => $this->input->post('rateSix'),
		'rateSeven' => $this->input->post('rateSeven'),
		'xtraNight' => $this->input->post('xtraNight')
		);
		$this->rates_model->update_single_rate($rateId,$inputData);
		$this->show_rates($propertyCode);
	}

/*	ADD A SINGLE RATE */
	function add_single_rate()
	{
		$propertyCode = $this->input->post('propertyCode');
		$inputData = array(
		'propertyCode' => $this->input->post('propertyCode'),
		'fromDate' => $this->input->post('fromDate'),
		'toDate' => $this->input->post('toDate'),
		'rateOne' => $this->input->post('rateOne'),
		'rateTwo' => $this->input->post('rateTwo'),
		'rateThree' => $this->input->post('rateThree'),
		'rateFour' => $this->input->post('rateFour'),
		'rateFive' => $this->input->post('rateFive'),
		'rateSix' => $this->input->post('rateSix'),
		'rateSeven' => $this->input->post('rateSeven'),
		'xtraNight' => $this->input->post('xtraNight')
		);
		$this->rates_model->add_single_rate($inputData);
		$this->show_rates($propertyCode);
	}

/*  COPY RATES FROM ONE PROPERTY TO ANOTHER */
	function copy_rates()
	{
		$propertyCodeSource = $this->input->post('propertyCodeSource');
		$propertyCodeTarget = $this->input->post('propertyCodeTarget');
		$this->rates_model->swap_rates($propertyCodeSource,$propertyCodeTarget);
		$this->show_rates($propertyCodeTarget);
	}

/*	DELETE A SINGLE RATE */
	function delete_single_rate($propertyCode,$rateId)
	{
		$this->rates_model->delete_single_rate($rateId);
		$this->show_rates($propertyCode);
	}

/*	SHOW OWNER */
	function show_owner($propertyCode)
	{
		$data['heading'] = 'Show owner';
		$ownerId = $this->property_model->get_property_detail($propertyCode,'property_owner_id');
		$data['ownerQuery'] = $this->owner_model->get_owner_by_id($ownerId);
		$data['query'] = $this->property_model->get_property_by_code($propertyCode);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('properties/property_list_controlbar_view.php');
		$this->load->view('properties/property_edit_controlbar_view',$data);
		$this->load->view('owners/owners_show_view',$data);
		$this->load->view('footer_view');
	}
}

?>
