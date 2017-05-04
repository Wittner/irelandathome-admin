<?php

/**
 * @author Mike Brady
 * @copyright 2010
 */

class Tester extends Controller {
	
	function index()
	{	
		$this->load->helper('url');
		$server_url = site_url('xmlrpc_server');
		$this->load->library('xmlrpc');
		$this->xmlrpc->server($server_url,'80');
		$this->xmlrpc->method('Greetings');
		
		$request = array('How is it going?');
		$this->xmlrpc->request($request);
        echo $request[0];
		if ( ! $this->xmlrpc->send_request())
		{
			echo $this->xmlrpc->display_error();
		}
		else
		{
			echo '<pre>';
			print_r($this->xmlrpc->display_response());
			echo '</pre>';
		}
	}
}

/* End of file tester.php */
/* Location: ./system/application/controllers/tester.php */