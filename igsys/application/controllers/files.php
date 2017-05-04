<?php
/**
 * Files
 * 
 * @package Ireland at Home 2009
 * @author 
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Files extends Controller
{

/*	INDEX */
    function index()
    {
        $data['heading'] = 'Latest Queries';
        $data['results'] = $this->enquiries_model->get_latest_queries();
        $headerView = $this->global_model->get_standard_header_view();
        $this->load->view('enquiries/enquiries_list_view', $data);
        $this->load->view('footer_view');
    }

/*	CONSTRUCTOR */
    function Files()
    {
        parent::Controller();
        $this->load->plugin('to_excel');
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->library('validation');
        $this->load->model('global_model');
        $this->load->model('booking_model');
        $this->load->model('sales_model');
        $this->load->model('comms_model');
        $this->global_model->is_logged_in();
    }
/*	CREATE A REPORT FOR EXCEL */

	function to_excel($table,$query,$filename)
	{
		$this->load->view('filemaker/create_excel_file',$data);
	}

		
}// End of class

?>
