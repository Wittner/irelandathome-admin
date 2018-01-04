<?php
class Availability extends Controller
{

  function Availability()
  {
    parent::Controller();
    // $this->output->enable_profiler(TRUE);
    $this->load->database();
    $this->public_db = $this->load->database('public', true);
    $this->load->helper('url');
    $this->load->helper('form');
    $this->load->library('validation');
    $this->load->model('availability_model');
    $this->load->model('booking_model');
    $this->load->model('function_model');
    $this->load->model('property_model');
    $this->load->model('sales_model');
    $this->load->model('company_model');
    $this->load->model('global_model');
    $this->global_model->is_logged_in();
  }


  function index()
  {
    $townId = 37;
    $calendarDate = date('Y-m-d');
    $data['rooms']='any';
    $data['sleeps'] = 'any';
    $data['code'] = 'any';
    $data['heading'] = 'Availability check';
    $data['townsDropDown'] = $this->availability_model->make_towns_combo($townId);
    $data['monthCombo'] = $this->availability_model->make_month_combo($calendarDate);
    $data['filter'] = 'All';
    $headerView = $this->global_model->get_standard_header_view();
    $this->load->view('availability/availability_view', $data);
    $this->load->view('availability/availability_controlbar_view', $data);
    $this->load->view('footer_view');
  }

  function view_availability($townId = 'not_set', $filter = 'not_set', $calendarDate = 'not_set', $rooms = 'not_set', $sleeps = 'not_set', $code = 'not_set')
  {
    if($townId == 'not_set'){
      $townId = $this->input->post('townId');
    }

    if($calendarDate == 'not_set') {
      $calendarDate = $this->input->post('calendarDate');
    }
    if($rooms == 'not_set') {
      $rooms = $this->input->post('rooms');
    }
    if($sleeps == 'not_set') {
      $sleeps = $this->input->post('sleeps');
    }
    if($code == 'not_set') {
      $code = $this->input->post('code');
    }
    if($filter == 'not_set') {
      $filter = $this->input->post('filter');
    }
    $data['filter'] = $this->input->post('filter');
    $data['heading'] = 'Availability check';
    $data['townsDropDown'] = $this->availability_model->make_towns_combo($townId);
    $data['managed'] = $this->input->post('managed');
    $data['monthCombo'] = $this->availability_model->make_month_combo($calendarDate);
    $data['roomSelect'] = '<option value="' . $rooms . '" selected>' . $rooms . '</option>';
    $data['sleepSelect'] = '<option value="' . $sleeps . '" selected>' . $sleeps . '</option>';
    $data['codeSelect'] = '<option value="' . $code . '" selected>' . $code . '</option>';
    $data['calendar'] = $this->availability_model->getLatestAvailability($townId, $filter, $calendarDate, $rooms, $sleeps, $code);
    $data['rooms'] = $this->input->post('rooms');
    $data['sleeps'] = $this->input->post('sleeps');
    $data['code'] = $this->input->post('code');
    $data['townId'] = $this->input->post('townId');
    $data['calendarDate'] = $this->input->post('calendarDate');
    $headerView = $this->global_model->get_standard_header_view();
    $this->load->view('availability/availability_view', $data);
    $this->load->view('availability/availability_controlbar_view', $data);
    $this->load->view('availability/availability_list_view', $data);
    $this->load->view('footer_view');
  }

  function view_selected_availability($townId,$filter,$calendarDate,$rooms,$sleeps,$code)
  {
    $filter = $this->input->post('filter');
    $data['filter'] = $this->input->post('filter');
    $data['heading'] = 'Availability check';
    $data['townsDropDown'] = $this->availability_model->make_towns_combo($townId);
    $data['monthCombo'] = $this->availability_model->make_month_combo($calendarDate);
    $data['roomSelect'] = '<option value="' . $rooms . '" selected>' . $rooms . '</option>';
    $data['sleepSelect'] = '<option value="' . $sleeps . '" selected>' . $sleeps . '</option>';
    $data['codeSelect'] = '<option value="' . $code . '" selected>' . $code . '</option>';
    $data['filter'] = $this->input->post($filter);
    $data['calendar'] = $this->availability_model->getLatestAvailability($townId,$filter,$calendarDate,$rooms,$sleeps,$code);
    $data['rooms'] = $this->input->post('rooms');
    $data['sleeps'] = $this->input->post('sleeps');
    $data['code'] = $this->input->post('code');
    $data['townId'] = $this->input->post('townId');
    $data['calendarDate'] = $this->input->post('calendarDate');
    $headerView = $this->global_model->get_standard_header_view();
    $this->load->view('availability/availability_view', $data);
    $this->load->view('availability/availability_controlbar_view', $data);
    $this->load->view('availability/availability_list_view', $data);
    $this->load->view('footer_view');
  }

  function start_booking()
  {
    $filter = $this->input->post('filter');
    $data['filter'] = $this->input->post('filter');
    $propertyCode = $this->input->post('propertyCode');
    $propertyName = $this->input->post('propertyName');
    $currentCalendarDate  = $this->input->post('defaultCalendarDate');
    $fromDate = $this->input->post('fromDate');
    $fromTime = $this->input->post('fromTime');
    $customerNights = $this->input->post('customerNights');
    $numberNights = $this->input->post('customerNights');
    $toTime = $this->input->post('toTime');
    $action = $this->input->post('action');
    $townId = $this->input->post('bookingTownId');
    $enquiryDate = date('Y-m-d');
    $bookingDate = date('Y-m-d');
    $bookingStatus = 'OPEN';
    $adminInit = 'MB';
    $sourceCode = 'ADMIN';
    $customerDate = date('Y-m-d');
    $bookingCalendarDate = $this->input->post('bookingCalendarDate');
    $townId = $this->input->post('townId');
    $calendarDate = $this->input->post('calendarDate');
    $rooms = $this->input->post('rooms');
    $sleeps = $this->input->post('sleeps');
    $code = $this->input->post('code');

    switch ($this->input->post('action')) {
      case "book":
      // Add new availability
      $data['heading'] = 'New admin booking';
      $data['calendarDate'] = $currentCalendarDate;
      $data['fromDate'] = $fromDate;
      $data['toDate'] = $this->global_model->get_to_date($fromDate,$numberNights);
      $data['adminInit'] = $adminInit;
      // Set booking data
      $data['customerNights'] = $numberNights;
      $data['propertyCode'] = $propertyCode;
      $data['propertyInput'] = $this->property_model->get_property_by_code($propertyCode);
      $data['companyCombo'] = $this->company_model->get_company_combo('');
      // Load add booking view
      $headerView = $this->global_model->get_standard_header_view();
      $this->load->view('bookings/add_booking_view', $data);
      $this->load->view('footer_view');
      break;

      case "release":
      $numberNights = $this->input->post('numberNights');
      $type = $this->input->post('type');
      $data['townId'] = $this->input->post('availTownId');
      $data['calendarDate'] = $this->input->post('availCalendarDate');
      // echo $propertyCode . '|' . $fromDate . '|' . $numberNights;
      $data['status'] = $this->availability_model->release_availability($propertyCode,$fromDate,$numberNights);
      //echo  '|' . $townId . '|' . $calendarDate . '|' . $rooms . '|' . $sleeps . '|' . $code . '|';
      $this->view_availability($townId,$filter,$currentCalendarDate,$rooms,$sleeps,$code);
      break;

      case "releaseSingle":
      $type = $this->input->post('type');
      $data['townId'] = $this->input->post('availTownId');
      $data['calendarDate'] = $this->input->post('availCalendarDate');
      $data['status'] = $this->availability_model->release_availability_single($propertyCode,$fromDate,$numberNights);
      //echo $townId . '|'. $currentCalendarDate . '|'. $rooms . '|'. $sleeps . '|'. $code;
      // $this->view_selected_availability($townId,$filter,$currentCalendarDate,$rooms,$sleeps,$code);
      $this->view_availability($townId,$filter,$currentCalendarDate,$rooms,$sleeps,$code);
      // Working!
      break;

      case "releaseAll":
      $type = $this->input->post('type');
      $data['townId'] = $this->input->post('availTownId');
      $data['calendarDate'] = $this->input->post('availCalendarDate');
      $data['status'] = $this->availability_model->release_availability_all($propertyCode,$fromDate,$numberNights);
      //echo  '|' . $townId . '|' . $calendarDate . '|' . $rooms . '|' . $sleeps . '|' . $code . '|';
      $this->view_selected_availability($townId,$filter,$currentCalendarDate,$rooms,$sleeps,$code);
      break;

      case "closeSingle":
      // Add new availability
      $data['status'] = $this->availability_model->add_availability($propertyCode,$fromDate,$numberNights);
      // echo $townId . '|' . $filter . '|' . $currentCalendarDate . '|' . $rooms . '|' . $sleeps . '|' . $code;
      // $this->view_selected_availability($townId,$filter,$currentCalendarDate,$rooms,$sleeps,$code);
      $this->view_availability($townId,$filter,$currentCalendarDate,$rooms,$sleeps,$code);
      break;

      case "closeAll":
      // Add new availability
      $data['status'] = $this->availability_model->add_availability_all($propertyCode,$fromDate,$customerNights);
      $this->view_selected_availability($townId,$filter,$currentCalendarDate,$rooms,$sleeps,$code);
      break;

      case "close":
      echo "you chose Close";
      break;
      default:
      echo "you chose nuffink!";
    }
    $this->load->view('footer_view');

  }// End of start_booking()


  // GET AVAILABILITY WITH PRICE (quick reference for admins selling on phone)
  // Using the new IAH Json RPC server
  function get_availability_with_price_input()
  {
    $calendarDate = date('Y-m-d');
    $data['rooms']='any';
    $data['sleeps'] = 'any';
    $data['interest'] = 'any';
    $data['code'] = 'any';
    $data['heading'] = 'Availability and price check';
    // Get a towns dropdown from the IAHAPI tools method
    $data['townsDropDown'] = $this->global_model->iah_api_fetch('tools_get_town_combo_by_name_full');
    $data['monthCombo'] = $this->availability_model->make_month_combo($calendarDate);
    $headerView = $this->global_model->get_standard_header_view();
    $this->load->view('availability/availability_view', $data);
    $this->load->view('availability/availability_with_price_controlbar_view', $data);
    $this->load->view('footer_view');
  }

  function view_availability_with_price()
  {
    // Get posted data
    $fromDate = $this->input->post('fromDate');
    $toDate = $this->input->post('toDate');
    $numberRooms = $this->input->post('rooms');
    $county = 'any';

    $town = $this->input->post('town');
    $calendarDate = $this->input->post('calendarDate');
    $rooms = $this->input->post('rooms');
    $sleeps = $this->input->post('sleeps');
    $interest = $this->input->post('interest');
    $code = $this->input->post('code');

    // Get availability list from IAH RPC server
    $method = 'list_available_properties_with_price/' . $fromDate . '/' . $toDate . '/' . $numberRooms . '/' . $county . '/' . $town . '/' . $interest;
    $jsonResult = $this->global_model->iah_api_fetch($method);
    $arrayResult = json_decode($jsonResult); // re-encode the json data as an array (of objects i.e. without the , 'true' option)

    // Deal with the results status back from the IAH server
    $statusCode = $arrayResult['0']->statusCode;
    $statusMessage = $arrayResult['0']->statusMessage;
    $propertyArray = $arrayResult['1'];

    // Load on-page variables
    // Get a towns dropdown from the IAHAPI tools method
    $data['townsDropDown'] = $this->global_model->iah_api_fetch('tools_get_town_combo_by_name_full');
    $data['heading'] = 'Availability check';
    $data['roomSelect'] = '<option value="' . $rooms . '" selected>' . $rooms . '</option>';
    $data['sleepSelect'] = '<option value="' . $sleeps . '" selected>' . $sleeps . '</option>';
    $data['codeSelect'] = '<option value="' . $code . '" selected>' . $code . '</option>';
    $data['interest'] = '<option value="' . $interest . '" selected>' . $interest . '</option>';
    $data['nights'] = $this->global_model->daysDifference($fromDate, $toDate);
    $data['displayFromDate'] = $this->global_model->toDisplayDate($fromDate);
    $data['displayToDate'] = $this->global_model->toDisplayDate($toDate);
    // Error check to see if we have good data before we echo out the property list
    if($statusCode == '1000')
    {
      $data['propertyList'] = $propertyArray;
    }
    else
    {
      $data['propertyList'] = $statusMessage;
    }

    // Load views
    $headerView = $this->global_model->get_standard_header_view();
    $this->load->view('availability/availability_view', $data);
    $this->load->view('availability/availability_with_price_controlbar_view', $data);
    $this->load->view('availability/availability_with_price_list_view', $data);
    $this->load->view('footer_view');
  }

}

?>
