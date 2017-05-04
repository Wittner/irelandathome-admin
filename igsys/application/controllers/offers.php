<?php
/**
 * Offers
 * 
 * @package Ireland at Home 2009
 * @author Mike Brady
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Offers extends Controller
{

    function Offers()
    {
        parent::Controller();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('offer_model');
        $this->load->model('global_model');
        $this->load->model('property_model');
        $this->load->controller('sales');
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
    
}

?>
