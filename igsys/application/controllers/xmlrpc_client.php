<?php

/**
 * @author Mike Brady
 * @copyright 2010
 */

class Xmlrpc_client extends Controller {
	
	function index()
	{	
		$this->load->helper('url');
		$server_url = site_url('xmlrpc_server');
	
		$this->load->library('xmlrpc');
		
		$this->xmlrpc->server($server_url, 80);
		$this->xmlrpc->method('Greetings');
		
		$request = array('How is it going?');
		$this->xmlrpc->request($request);	
		
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

/* End of file xmlrpc_client.php */
/* Location: ./system/application/controllers/xmlrpc_client.php */