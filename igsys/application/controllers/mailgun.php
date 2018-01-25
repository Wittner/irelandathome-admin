<?php
/**
 * Booking
 *
 * @package Ireland at Home 2009
 * @author
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Mailgun extends Controller
{

/*	INDEX */
    function index()
    {
        return "Mailgun notifications";
    }

/*	CONSTRUCTOR */
    function Mailgun()
    {
        parent::Controller();
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('exchange');
        $this->load->library('email');
        $this->load->library('validation');
        $this->load->model('global_model');
        $this->load->model('booking_model');
        $this->load->model('sales_model');
        $this->load->model('comms_model');
    }



/*	POST AN EMAIL */
	function post_mailgun_notification()
	{
		// $from = $this->input->post('mike@irelandathome.com');
		// $to = $this->input->post('mike@irelandathome.com');
		// $subject = $this->input->post('Mailgun notification');
		// $message = base64_decode($this->input->post('message'));
    $from = 'mike@irelandathome.com';
		$to = 'mike@irelandathome.com';
		$subject = 'Mailgun notification';
    $message = 'Mailgun notification test';

    return "all ok";

		// $mailgunMessage = $this->comms_model->send_email($from,$to,$subject,$message);
	}


}// End of class

?>
