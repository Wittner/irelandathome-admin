<?php
/**
 * Owners
 * 
 * @package Ireland at Home 2009
 * @author 
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Owners extends Controller
{

    function Owners()
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
		$this->load->model('enquiries_model');
		$this->global_model->is_logged_in();
    }

    function index()
    {
        $data['heading'] = 'Queries';
		$this->load->view('ajax_header_view', $data);
        $this->load->view('owners/jquerypage', $data);
        $this->load->view('footer_view');
    }

/*	AJAX OWNERS LIST TEST */
	function ajax_owners_list()
	{
		$this->load->view('sample_view');
	}

/*	AJAX TEST */
	function ajax_test()
	{
		echo 'Got here!';
	}

    function ajax_list_queries()
    {
		$data['results'] = $this->enquiries_model->ajax_get_latest_queries();
        $this->load->view('enquiries/ajax_enquiries_list_view', $data);
    }

/*	LIST OWNERS */    
    function list_owners()
    {
		$data['heading'] = 'Owners: ';
		$data['results'] = $this->owner_model->list_owners();
		$headerView = $this->global_model->get_standard_header_view();
		// $this->load->view('owners/owners_list_controlbar_view',$data);
		$this->load->view('owners/owners_list_view',$data);
		$this->load->view('footer_view');
    }

/*  ADD OWNER INPUT */
	function add_owner_input()
    {
        $data['heading'] = 'Add a new owner';
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('owners/add_owner_input',$data);
		$this->load->view('footer_view');
    }

/*	ADD AN OWNER */
	function add_owner()
	{
		$inputData = array(
		'contact_fname' => $this->input->post('contact_fname'),
		'contact_sname' => $this->input->post('contact_sname'),
		'address' => $this->input->post('address'),
		'phone1' => $this->input->post('phone1'),
		'phone2' => $this->input->post('phone2'),
		'mobile' => $this->input->post('mobile'),
		'email' => $this->input->post('email'),
		'status' => 'LVE',
		'owner_username' => $this->input->post('owner_username'),
		'owner_pass' => $this->input->post('owner_pass')
		);
		$this->owner_model->add_owner($inputData);
		$this->list_owners();
	}

/*	EDIT OWNER */    
	function edit_owner($ownerId)
	{
		$data['heading'] = 'Edit Owner';
		$data['query'] = $this->owner_model->get_owner_by_id($ownerId);
		$data['companyData'] = $this->global_model->get_company_data();
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('owners/owners_list_controlbar_view',$data);
		$this->load->view('owners/owner_edit_controlbar_view',$data);
		$this->load->view('owners/owner_edit_view',$data);
		$this->load->view('footer_view');		
	}

/*	UPDATE OWNER */
	function update_owner()
	{
		$ownerId = $this->input->post('owner_id');
		$inputData = array(
		'contact_fname' => $this->input->post('contact_fname'),
		'contact_sname' => $this->input->post('contact_sname'),
		'address' => $this->input->post('address'),
		'phone1' => $this->input->post('phone1'),
		'phone2' => $this->input->post('phone2'),
		'mobile' => $this->input->post('mobile'),
		'email' => $this->input->post('email')
		);	
	$this->owner_model->update_owner($ownerId,$inputData);
	$this->edit_owner($ownerId);	
	}    

/*	DELETE OWNER */
	function delete_owner($ownerId)
	{
		$inputData = array(
		'status' => 'DEL'
		);
	$this->owner_model->update_owner($ownerId,$inputData);
	$this->list_owners();
	}

/*	OWNER AUTOCOMPLETE LIST */
    function owner_autocomplete($q)
    {
		$ownerAutoCompleteData = $this->owner_model->get_owner_autocomplete($q);
		echo $ownerAutoCompleteData;
		
    }

/*	LIST PROPERTIES BY OWNER */
	function list_properties_by_owner($ownerId)
	{
		$data['heading'] = 'List owner properties';
		$data['results'] = $this->property_model->list_properties_by_owner($ownerId);
		$data['query'] = $this->owner_model->get_owner_by_id($ownerId);
		//$data['companyData'] = $this->global_model->get_company_data();
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('owners/owners_list_controlbar_view',$data);
		$this->load->view('owners/owner_property_list_controlbar_view',$data);
		$this->load->view('owners/owners_property_list_view',$data);
		$this->load->view('footer_view');	
	}
}

?>
