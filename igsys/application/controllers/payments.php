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
class Payments extends Controller
{

    function Payments()
    {
        parent::Controller();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('payments_model');
        $this->load->model('booking_model');
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
    
    function addPayment()
    {
    	$data['query'] = $this->global_model->data_transfer_bookings();
    	$this->load->view('bookings_transfer_view',$data);
    }
    

}

?>
