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

	function clef_validation()
	{
		$this->input->get('lang', TRUE);
	}// Function end

	function clef_validationOLK($code, $state)
	{
		$app_id = '7411ab15c63d68602f56fecd141773c7';
		$app_secret = '1f8ddb11100d25f773f2c393e495d25f';

		$code = $_GET["code"];
		$state = $_GET["state"];

		assert_state_is_valid($state);

		$postdata = http_build_query(
		    array(
		        'code' => $code,
		        'app_id' => $app_id,
		        'app_secret' => $app_secret
		    )
		);

		$opts = array('http' =>
		    array(
		        'method'  => 'POST',
		        'header'  => 'Content-type: application/x-www-form-urlencoded',
		        'content' => $postdata
		    )
		);

		$url = 'https://clef.io/api/v1/authorize';


		$context  = stream_context_create($opts);
		$response = file_get_contents($url, false, $context);
		$response = json_decode($response, true);

		if ($response && $response['success']) {
		    $access_token = $response['access_token'];
		    $admin_array = array(
				    'admin_name' => 'Admin',
					'admin_init' => 'AU',
					'admin_level' => 1,
					'is_logged_in' => true
				);
		    $this->session->set_userdata($admin_array);
		    redirect('enquiries');
		} else {
		    echo $response['error'];
		}
	}// Function end

}

?>