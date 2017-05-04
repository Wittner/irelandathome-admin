<?php
/**
 * Notices
 * 
 * @package Ireland at Home 2009
 * @author 
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Notices extends Controller
{

    function Notices()
    {
        parent::Controller();
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('validation');
        $this->load->model('notice_model');
        $this->load->model('global_model');
  		$this->global_model->is_logged_in();
    }

    function index()
    {
        $data['heading'] = 'Notices';
        $data['results'] = $this->enquiries_model->get_latest_queries();
        $headerView = $this->global_model->get_standard_header_view();
        $this->load->view('enquiries/enquiries_list_view', $data);
        $this->load->view('footer_view');
    }

/*	LIST NOTICES */
    function list_notifications()
    {
        $data['heading'] = 'Add a new location';
		$data['results'] = $this->notice_model->list_notices();
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('controlbar_view',$data);
		$this->load->view('notices/notice_list_view',$data);
		$this->load->view('footer_view');
    }

/*  ADD NOTICE */
	function add_notice_input()
    {
        $data['heading'] = 'Add a new location';
		$data['countyCombo'] = $this->global_model->get_county_combo('');
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('controlbar_view',$data);
		$this->load->view('notices/add_notice_input',$data);
		$this->load->view('footer_view');
    }
	function add_notice()
	{
		$inputData = array(
		'notice_id' => (''),
		'notice_date' => date('Y-m-d'),
		'notice_author' => $this->session->userdata('admin_name'),
		'notice_message' => $this->input->post('notice_message')
		);
		$this->notice_model->add_notice($inputData);
		$this->list_notifications();
	}

/*	EDIT NOTICE */
	function edit_notice($noticeId)
	{
		$data['heading'] = 'Edit Notice';
		$data['query'] = $this->notice_model->get_notice_by_id($noticeId);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('controlbar_view',$data);
		$this->load->view('notices/edit_notice_view',$data);
		$this->load->view('footer_view');
	}


/*	UPDATE NOTICE */
	function update_notice()
	{
		$noticeId = $this->input->post('notice_id');
		$inputData = array(
		'notice_id' => $this->input->post('notice_id'),
		'notice_date' => date('Y-m-d'),
		'notice_author' => $this->session->userdata('admin_name'),
		'notice_message' => $this->input->post('notice_message')
		);
	$this->notice_model->update_notice($noticeId,$inputData);
	$this->list_notifications();
	}

/*	DELETE LOCATION */
	function delete_notice($noticeId)
	{
		$this->notice_model->delete_notice($noticeId);
		$this->list_notifications();
	}

}

?>
