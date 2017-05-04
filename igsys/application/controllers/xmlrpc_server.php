<?php

/**
 * @author Mike Brady
 * @copyright 2010
 */

class Xmlrpc_server extends Controller {

	function index()
	{
		$this->load->library('xmlrpc');
		$this->load->library('xmlrpcs');
		
		$config['functions']['Greetings'] = array('function' => 'Xmlrpc_server.process');
		
		$this->xmlrpcs->initialize($config);
		$this->xmlrpcs->serve();
	}
	
	
	function process($request)
	{
		$parameters = $request->output_parameters();
		
		$response = array(
							array(
									'you_said'  => $parameters['0'],
									'i_respond' => 'Not bad at all.'),
							'struct');
						
		return $this->xmlrpc->send_response($response);
	}
}

/* End of file xmlrpc_server.php */
/* Location: ./system/application/controllers/xmlrpc_server.php */