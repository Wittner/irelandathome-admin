<?php
/**
 * Reports
 *
 * @package Ireland at Home 2009
 * @author
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Reports extends Controller
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
    function Reports()
    {
        parent::Controller();
        $this->load->database();
        $this->public_db = $this->load->database('public', true);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('validation');
        $this->load->model('booking_model');
        $this->load->model('payment_model');
        $this->load->model('charges_model');
        $this->load->model('customer_model');
        $this->load->model('property_model');
        $this->load->model('company_model');
        $this->load->model('owner_model');
        $this->load->model('availability_model');
        $this->load->model('reports_model');
        $this->load->model('comms_model');
        $this->load->model('global_model');
        $this->global_model->is_logged_in();
    }

/*	*******************************************/
/*	********* SALES BY ARRIVAL DATE ***********/
/*	*******************************************/

/*	SALES BY ARRIVAL DATE INPUT */
	function sales_by_arrival_date_input()
	{
		$data['heading'] = 'Sales report by arrival date';
		$data['ownerCombo'] = $this->owner_model->get_owner_combo('');
		$data['propertyCombo'] = $this->property_model->get_property_combo('');
		$data['countryCombo'] = $this->global_model->get_country_combo('');
		$data['referallCombo'] = $this->global_model->get_referral_combo('');
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('reports/sales_by_arrival_date_input',$data);
		$this->load->view('footer_view');
	}

/*	SALES BY ARRIVAL DATE REPORT */
	function sales_report_by_arrival_date()
	{
		//$pass = $this->input->post('pass');
		//if($pass == 'rhapsody')
		//{
			$fromDate = $this->input->post('fromDate');
			$toDate = $this->input->post('toDate');
			$owner_id = $this->input->post('owner_id');
			$property_code = $this->input->post('property_code');
			$customer_email = $this->input->post('customer_email');
			$customer_country = $this->input->post('country_name');
			$source_code = $this->input->post('source_code');
			$referrer = $this->input->post('referrer');
			if($referrer == 'None selected'){
				$referrer = 'any';
			}
			$data['heading'] = 'Sales report by arrival date';
			$data['companyData'] = $this->global_model->get_company_data();
			$data['results'] = $this->reports_model->sales_report_by_arrival_date($fromDate,$toDate,$owner_id,$property_code,$customer_email,$customer_country,$source_code,$referrer);
			$headerView = $this->global_model->get_standard_header_view();
			$this->load->view('reports/sales_by_arrival_date_results',$data);
			$this->load->view('footer_view');
		//}
		//else
		//{
			//$this->sales_by_booking_date_input();
		//}
	}

/*	SALES BY ARRIVAL DATE CSV REPORT */
	function excel_sales_report_by_arrival_date()
	{
			$fromDate = $this->input->post('fromDate');
			$toDate = $this->input->post('toDate');
			$owner_id = $this->input->post('owner_id');
			$property_code = $this->input->post('property_code');
      $referrer = $this->input->post('referrer');
			if($referrer == 'None selected'){
				$referrer = 'any';
			}
			$customer_country = $this->input->post('customer_country');
			$source_code = $this->input->post('source_code');
			$data['heading'] = 'Sales report by booking date';
			$data['reportName'] = 'SalesReportByArrivalDate-';
			$data['results'] = $this->reports_model->csv_sales_report_by_arrival_date($fromDate,$toDate,$owner_id,$property_code,$customer_country,$source_code,$referrer);
			$this->load->view('filemaker/create_excel_file',$data);
	}


/*	*******************************************/
/*	********* SALES BY BOOKING DATE ***********/
/*	*******************************************/

/*	SALES BY BOOKING DATE INPUT */
	function sales_by_booking_date_input()
	{
		$data['heading'] = 'Sales report by booking date';
		$data['ownerCombo'] = $this->owner_model->get_owner_combo('');
		$data['propertyCombo'] = $this->property_model->get_property_combo('');
    $data['referallCombo'] = $this->global_model->get_referral_combo('');
		$data['countryCombo'] = $this->global_model->get_country_combo('');
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('reports/sales_by_booking_date_input',$data);
		$this->load->view('footer_view');
	}

/*	SALES BY BOOKING DATE REPORT */
	function sales_report_by_booking_date()
	{
	   // $this->output->enable_profiler(TRUE);
		//$pass = $this->input->post('pass');
		//if($pass == 'rhapsody')
		//{
			$fromDate = $this->input->post('fromDate');
			$toDate = $this->input->post('toDate');
			$owner_id = $this->input->post('owner_id');
			$property_code = $this->input->post('property_code');
      $referrer = $this->input->post('referrer');
      if($referrer == 'None selected'){
				$referrer = 'any';
			}
			$customer_country = $this->input->post('country_name');
			$source_code = $this->input->post('source_code');
			$data['heading'] = 'Sales report by booking date';
			$data['results'] = $this->reports_model->sales_report_by_booking_date($fromDate,$toDate,$owner_id,$property_code,$customer_country,$source_code,$referrer);
			$headerView = $this->global_model->get_standard_header_view();
			$this->load->view('reports/sales_by_booking_date_results',$data);
			$this->load->view('footer_view');
		//}
		//else
		//{
		//	$this->sales_by_booking_date_input();
		//}
	}

/*	SALES BY BOOKING DATE EXCEL REPORT */
	function excel_sales_report_by_booking_date()
	{
			$fromDate = $this->input->post('fromDate');
			$toDate = $this->input->post('toDate');
			$owner_id = $this->input->post('owner_id');
			$property_code = $this->input->post('property_code');
      $referrer = $this->input->post('referrer');
      if($referrer == 'None selected'){
				$referrer = 'any';
			}
			$customer_country = $this->input->post('customer_country');
			$source_code = $this->input->post('source_code');
			$data['heading'] = 'Sales report by booking date';
			$data['reportName'] = 'SalesReportByBookingDate-';
			$data['results'] = $this->reports_model->csv_sales_report_by_booking_date($fromDate,$toDate,$owner_id,$property_code,$customer_country,$source_code,$referrer);
			$this->load->view('filemaker/create_excel_file',$data);
	}

/*	ARRIVALS REPORT INPUT */
	function arrivals_input()
	{
		$data['heading'] = 'Arrvials report';
		$data['ownerCombo'] = $this->owner_model->get_owner_combo('');
		$data['propertyCombo'] = $this->property_model->get_property_combo('');
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('reports/arrivals_input',$data);
		$this->load->view('footer_view');
	}

/*	ARRIVALS REPORT */
	function arrivals()
	{
		$fromDate = $this->input->post('fromDate');
		$toDate = $this->input->post('toDate');
		$owner_id = $this->input->post('owner_id');
		$prop_code = $this->input->post('prop_code');
		$data['heading'] = 'Arrivals';
		$data['results'] = $this->reports_model->arrivals_report($fromDate,$toDate,$owner_id,$prop_code);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('reports/arrivals_results',$data);
		$this->load->view('footer_view');
	}

/*	CANCELLED SALES BY ARRIVAL DATE REPORT INPUT */
	function cancelled_sales_input()
	{
		$data['heading'] = 'Cancelled sales by arrival date';
		$data['ownerCombo'] = $this->owner_model->get_owner_combo('');
		$data['propertyCombo'] = $this->property_model->get_property_combo('');
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('reports/cancelled_sales_input',$data);
		$this->load->view('footer_view');
	}

/*  CANCELLED SALES BY ARRIVAL DATE REPORT */
	function cancelled_sales_report()
	{
		$fromDate = $this->input->post('fromDate');
		$toDate = $this->input->post('toDate');
		$owner_id = $this->input->post('owner_id');
		$prop_code = $this->input->post('prop_code');
		$date['reportType'] = 'arrival';
		$data['heading'] = 'Cancelled sales';
		$data['results'] = $this->reports_model->cancelled_sales_report($fromDate,$toDate,$owner_id,$prop_code);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('reports/arrivals_results',$data);
		$this->load->view('footer_view');
	}

/*	CANCELLED SALES BY ARRIVAL DATE CSV REPORT */
	function excel_cancelled_sales_report()
	{
		$fromDate = $this->input->post('fromDate');
		$toDate = $this->input->post('toDate');
		$owner_id = $this->input->post('owner_id');
		$property_code = $this->input->post('property_code');
		$data['heading'] = 'Cancelled sales';
		$data['reportName'] = 'Cancelled sales-';
		$data['results'] = $this->reports_model->csv_cancelled_sales_report($fromDate,$toDate,$owner_id,$property_code);
		$this->load->view('filemaker/create_excel_file',$data);
	}

/*	CANCELLED SALES BY BOOKING DATE REPORT INPUT */
	function cancelled_sales_booking_input()
	{
		$data['heading'] = 'Cancelled sales by booking date';
		$data['ownerCombo'] = $this->owner_model->get_owner_combo('');
		$data['propertyCombo'] = $this->property_model->get_property_combo('');
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('reports/cancelled_sales_booking_input',$data);
		$this->load->view('footer_view');
	}

/*  CANCELLED SALES BY BOOKING DATE REPORT */
	function cancelled_sales_booking_report()
	{
		$fromDate = $this->input->post('fromDate');
		$toDate = $this->input->post('toDate');
		$owner_id = $this->input->post('owner_id');
		$prop_code = $this->input->post('prop_code');
		$data['heading'] = 'Cancelled sales';
		$date['reportType'] = 'booking';
		$data['results'] = $this->reports_model->cancelled_sales_booking_report($fromDate,$toDate,$owner_id,$prop_code);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('reports/arrivals_results',$data);
		$this->load->view('footer_view');
	}

/*	CANCELLED SALES BY BOOKING DATE CSV REPORT */
	function excel_cancelled_sales_booking_report()
	{
		$fromDate = $this->input->post('fromDate');
		$toDate = $this->input->post('toDate');
		$owner_id = $this->input->post('owner_id');
		$property_code = $this->input->post('property_code');
		$data['heading'] = 'Cancelled sales';
		$data['reportName'] = 'Cancelled sales-';
		$data['results'] = $this->reports_model->csv_cancelled_sales_booking_report($fromDate,$toDate,$owner_id,$property_code);
		$this->load->view('filemaker/create_excel_file',$data);
	}

/*	UNPAID OWNERS REPORT INPUT */
	function unpaid_owners_input()
	{
		$data['heading'] = 'Arrvials report';
		$data['ownerCombo'] = $this->owner_model->get_owner_combo('');
		$data['propertyCombo'] = $this->property_model->get_property_combo('');
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('reports/unpaid_owners_input',$data);
		$this->load->view('footer_view');
	}

/*	UNPAID OWNERS REPORT */
	function unpaid_owners()
	{
	$pass = $this->input->post('pass');
    if($pass == 'rhapsody')
    	{
			$fromDate = $this->input->post('fromDate');
			$toDate = $this->input->post('toDate');
			$owner_id = $this->input->post('owner_id');
			$property_code = $this->input->post('property_code');
			$data['heading'] = 'Unpaid owners';
			$data['results'] = $this->reports_model->unpaid_owners($fromDate,$toDate,$owner_id,$property_code);
			$headerView = $this->global_model->get_standard_header_view();
			$this->load->view('reports/unpaid_owners_results',$data);
			$this->load->view('footer_view');
		}
		else
		{
			$this->unpaid_owners_input();
		}
	}

/*	UNPAID OWNERS CSV REPORT */
	function csv_unpaid_owners()
	{
		$fromDate = $this->input->post('fromDate');
		$toDate = $this->input->post('toDate');
		$owner_id = $this->input->post('owner_id');
		$property_code = $this->input->post('property_code');
		$data['heading'] = 'Unpaid owners';
		$data['reportName'] = 'UnpaidOwners-';
		$data['results'] = $this->reports_model->csv_unpaid_owners($fromDate,$toDate,$owner_id,$property_code);
		$this->load->view('filemaker/create_excel_file',$data);
	}

/*	OVERDUE BALANCES */
	function overdue_balances()
	{
		$data['heading'] = 'Overdue balances';
		$data['results'] = $this->reports_model->overdue_balances();
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('reports/overdue_balances_results',$data);
		$this->load->view('footer_view');
	}


/*  BOOKINGS BY ORIGIN INPUT */
	function bookings_by_origin_input()
	{
		$data['heading'] = 'Sales by origin';
		$data['ownerCombo'] = $this->owner_model->get_owner_combo('');
		$data['propertyCombo'] = $this->property_model->get_property_combo('');
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('reports/bookings_by_origin_input',$data);
		$this->load->view('footer_view');
	}

/*  BOOKINGS BY ORIGIN REPORT */
	function bookings_by_origin_report()
	{
		$fromDate = $this->input->post('fromDate');
		$toDate = $this->input->post('toDate');
		$origin = $this->input->post('origin');
		$owner_id = $this->input->post('owner_id');
		$prop_code = $this->input->post('prop_code');
		$data['heading'] = 'Cancelled sales';
		$date['reportType'] = 'booking';
		$data['results'] = $this->reports_model->bookings_by_origin_report($fromDate,$toDate,$origin,$owner_id,$prop_code);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('reports/arrivals_results',$data);
		$this->load->view('footer_view');
	}

}// End of class
?>
