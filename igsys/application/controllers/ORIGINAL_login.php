<?php

/**
 * @author Mike Brady
 * @copyright 2009
 */

class Login extends Controller
{

	function login()
	{
    	parent::Controller();
 		$this->load->database();
 		$this->load->helper('form');
 		$this->load->helper('url');
		$this->load->model('global_model');
	}
	
	function index()
	{
		//$array_items = array('admin_name' => '', 'admin_init' => '', 'admin_level' => '', 'is_logged_in' => '');
		//$this->session->unset_userdata($array_items);
		$this->session->sess_destroy();
        $data['heading'] = 'Please log in';
		$this->load->view('vanilla_header', $data);
        $this->load->view('login/login_view', $data);
        $this->load->view('footer_view');
	}

	function validate_credentials()
	{
		$query = $this->global_model->validate();
		if($query) // If the user validates
		{
			$this->session->set_userdata($query);
			redirect('enquiries');
		}
		else
		{
			$this->index();
		}
	}

}

?>