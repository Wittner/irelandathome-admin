<?php
/**
 * Enquiries
 * 
 * @package Ireland at Home 2009
 * @author 
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Enquiries extends Controller
{

    function Enquiries()
    {
        parent::Controller();
        $this->load->database();
		$this->public_db = $this->load->database('public', true);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('validation');
		$this->load->model('sales_model');
        $this->load->model('enquiries_model');
        $this->load->model('company_model');
        $this->load->model('property_model');
        $this->load->model('global_model');
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
    
    function view_enquiry($enquiryId)
    {
        $data['heading'] = 'View Enquiry';
        $data['query'] = $this->enquiries_model->get_enquiry_by_id($enquiryId);
        $headerView = $this->global_model->get_standard_header_view();
        $this->load->view('enquiries/enquiry_view', $data);
        $this->load->view('footer_view');    	
    }
    
    function edit_enquiry($enquiryId)
    {
    	$data['heading'] = 'View Enquiry';
        $data['query'] = $this->enquiries_model->get_enquiry_by_id($enquiryId);
        $headerView = $this->global_model->get_standard_header_view();
        $this->load->view('enquiries/edit_enquiry_view', $data);
        $this->load->view('footer_view');
    }

    function delete_enquiry($enquiryId)
    {
    	$data['heading'] = 'Latest Queries';
        $data['query'] = $this->enquiries_model->delete_enquiry_by_id($enquiryId);
        $data['results'] = $this->enquiries_model->get_latest_queries();
        $headerView = $this->global_model->get_standard_header_view();
        $this->load->view('enquiries/enquiries_list_view', $data);
        $this->load->view('footer_view');
    }

	function update_note()
	{
		$enquiryId = $this->input->post('enquiryId');
		$admin_note = $this->input->post('admin_note');
		$this->enquiries_model->update_note($enquiryId,$admin_note);
		$this->index();
	}

    function ajax_list_queries()
    {
        echo 'got here!';
		//$data['results'] = $this->enquiries_model->get_latest_queries();
        //$this->load->view('enquiries/ajax_enquiries_list_view', $data);
        //$this->load->view('footer_view');
    }
    

}

?>
