<?php
/**
 * Locations
 * 
 * @package Ireland at Home 2009
 * @author 
 * @copyright 2008
 * @version $Id$
 * @access public
 */
 
class Locations extends Controller
{

    function Locations()
    {
        parent::Controller();
        $this->load->database();
        $this->public_db = $this->load->database('public', true);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('property_model');
        $this->load->model('locations_model');
        $this->load->model('booking_model');
        $this->load->model('global_model');
        $this->load->model('owner_model');
        $this->load->model('town_model');
        $this->global_model->is_logged_in();
    }

    function index()
    {
		echo 'Index page';
    }

/*	LIST LOCATIONS */
    function list_locations()
    {
		$data['heading'] = 'Select a location to edit: ';
		$data['results'] = $this->locations_model->list_locations();
		$headerView = $this->global_model->get_standard_header_view();
		// $this->load->view('locations/location_list_controlbar_view',$data);
		$this->load->view('locations/locations_list_view',$data);
		$this->load->view('footer_view');
    }

/*	LIST PROPERTIES BY LOCATION */
	function list_properties_by_town($townId)
	{
		$data['heading'] = 'List location properties';
		$data['results'] = $this->property_model->list_properties_by_town($townId);
		$data['query'] = $this->locations_model->get_location_by_id($townId);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('locations/location_list_controlbar_view',$data);
		$this->load->view('locations/locations_property_list_controlbar_view',$data);
		$this->load->view('properties/properties_list_view',$data);
		$this->load->view('footer_view');
	}

/*	LOCATIONS AUTOCOMPLETE LIST */
    function location_autocomplete($q)
    {
		$locationAutoCompleteData = $this->locations_model->get_location_autocomplete($q);
		echo $locationAutoCompleteData;
		
    }


/*  ADD LOCATION INPUT */
	function add_location_input()
    {
        $data['heading'] = 'Add a new location';
		$data['countyCombo'] = $this->global_model->get_county_combo('');
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('controlbar_view',$data);
		$this->load->view('locations/add_location_input',$data);
		$this->load->view('footer_view');
    }

	function add_location()
	{
		$inputData = array(
		'town_name' => $this->input->post('town_name'),
		'county_id' => $this->input->post('county_id'),
		'amenities' => $this->input->post('amenities')
		);
		$this->locations_model->add_location($inputData);
		$this->list_locations();
	}

/*	EDIT LOCATION */
	function edit_location($townId)
	{
		$data['heading'] = 'Edit Location';
		$data['query'] = $this->locations_model->get_location_by_id($townId);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('locations/location_list_controlbar_view',$data);
		$this->load->view('locations/location_edit_controlbar_view',$data);
		$this->load->view('locations/location_edit_view',$data);
		$this->load->view('footer_view');		
	}

/*	UPDATE LOCATION */
	function update_location()
	{
		$townId = $this->input->post('townId');
		$inputData = array(
		'town_name' => $this->input->post('town_name'),
		'amenities' => $this->input->post('amenities')
		);
	$this->locations_model->update_location($townId,$inputData);
	$this->edit_location($townId);
	}    

/*	DELETE LOCATION */
	function delete_location($townId)
	{
		$inputData = array(
		'status' => 'DEL'
		);
	$this->locations_model->update_location($townId,$inputData);
	$this->list_locations();
	}
}

?>
