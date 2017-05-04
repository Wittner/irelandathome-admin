<?php
class Global_model extends Model
{

    function Global_model()
    {
        parent::Model();
        $this->load->database();
    }

    function validate()
    {
        $this->db->where('user_username', $this->input->post('username'));
        $this->db->where('user_password', sha1($this->input->post('password')));
        $query = $this->db->get('admins');

        if($query->num_rows == 1)
        {
            foreach ($query->result() as $item)
            {
                $admin_array = array(
                    'admin_name' => $item->realname,
                    'admin_init' => $item->user_init,
                    'admin_level' => $item->user_level,
                    'is_logged_in' => true
                );
            }
            return $admin_array;
        }
        else
        {
            return false;
        }
    }

    function is_logged_in() // checks if user is logged in or not
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if(!isset($is_logged_in) || $is_logged_in != true)
        {
            redirect('login');
        }
    }

    function toLongDate($sqlDate)
    {
        // Convert sql format dates to long display date (e.g. 2007-06-05 passed in, 5th June 2007 passed out)
        $date_elements = explode("-", $sqlDate);
        // date("M-d-Y", mktime(0, 0, 0, 12, 32, 1997));
        $display_date = date("D, M jS, Y", mktime(0,0,0, $date_elements[1], $date_elements[2], $date_elements[0]));
        return $display_date;
    }

    function toDisplayDate($sqlDate)
    {
        // Convert sql format dates to display date (e.g. 2007-06-05 passed in, 05-06-2007 passed out)
        $date_elements = explode("-", $sqlDate);
        $display_date = $date_elements[2] . "-" . $date_elements[1] . "-" . $date_elements[0];
        return $display_date;
    }

    function toSqlDate($shortDate)
    {
        // Convert short date to sql format date (e.g. 05-06-2007 passed in, 2007-06-05 passed out)
        $date_elements = explode("-", $shortDate);
        $display_date = $date_elements[2] . "-" . $date_elements[1] . "-" . $date_elements[0];
        return $display_date;
    }

    function toSqlDateFromSlashes($shortDate)
    {
        // Convert short date with slashes to sql format date (e.g. 05/06/2007 passed in, 2007-06-05 passed out)
        // *nb* with short year i.e. 08, 09 etc. This only good to 22nd century. Fix it before then ;-)
        $date_elements = explode("/", $shortDate);
        $display_date = $date_elements[2] . "-" . $date_elements[1] . "-" . $date_elements[0];
        return $display_date;
    }

    function daysDifference($beginDate, $endDate)
    {
        // Takes arrival and departure day and works out how many days (nights staying) are in between
        //explode the date by "-" and storing to array
        $date_parts1 = explode("-", $beginDate);
        $date_parts2 = explode("-", $endDate);
        //gregoriantojd() Converts a Gregorian date to Julian Day Count
        $start_date = gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
        $end_date = gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
        return $end_date - $start_date;
    }

    function getMonthNameFromNumber($monthNumber)
    {
        $year = date('Y');
        $checkDate = date("M", mktime(0,0,0, $monthNumber, 1, $year));
        return $checkDate;
    }

    function get_latest_booking_fee()
    {
        // Get latest booking fee amount from db
        $query = $this->db->query("select booking_fee from seeds");
        foreach ($query->result_array() as $row)
        {
            $bookingFee = $row['booking_fee'];
        }
        return $bookingFee;
    }

    function get_latest_booking_number()
    {
        // Get latest booking number from db
        $query = $this->db->query("select booking_seed from seeds");
        foreach ($query->result_array() as $row)
        {
            $bookingNumber = $row['booking_seed'];
            $newBookingNumber = $bookingNumber +1;
        }
        // Increment booking seed by one
        $query = $this->db->query("update seeds set booking_seed='$newBookingNumber'");
        return $bookingNumber;
    }

    function get_latest_customer_number()
    {
        // Get latest customer number amount from db
        $query = $this->db->query("select customer_seed from seeds");
        foreach ($query->result_array() as $row)
        {
            $customerNumber = $row['customer_seed'];
            $newCustomerNumber = $customerNumber + 1;
        }
        // Increment customer seed by one
        $query = $this->db->query("update seeds set customer_seed='$newCustomerNumber'");
        return $customerNumber;
    }

    function data_transfer_bookings()
    // This method takes the old bookings table and transfers the payment data to the new payments table
    {
        $query = $this->db->query("select
                                    booking_number,
                                    deposit_amount,
                                    payment1_method,
                                    payment1_due_date,
                                    payment1_date,
                                    payment1_amount,
                                    payment1_purpose,
                                    payment1_ref,

                                    payment2_ref,
                                    payment2_method,
                                    payment2_due_date,
                                    payment2_date,
                                    payment2_amount,
                                    payment2_purpose,
                                    payment2_ref,

                                    payment3_ref,
                                    payment3_method,
                                    payment3_due_date,
                                    payment3_date,
                                    payment3_amount,
                                    payment3_purpose,
                                    payment3_ref,

                                    payment4_ref,
                                    payment4_method,
                                    payment4_due_date,
                                    payment4_date,
                                    payment4_amount,
                                    payment4_purpose,
                                    payment4_ref,
                                    final_payment_amount

                                    from bookings
                                    where (deposit_amount > 0 || final_payment_amount >0)
                                    and (payment1_amount <> 0 || payment2_amount <> 0 || payment3_amount <> 0 || payment4_amount <> 0)



                                    ");
        return $query;
    }


    function data_transfer_action($bookingNumber,$paymentPurpose,$paymentDate,$paymentDueDate,$paymentPaidDate,$paymentMethod,$paymentAmount,$paymentRef)
    {
        $data = array(
                'paymentId'             => '',
                'paymentBookingNumber'  => $bookingNumber,
                'paymentPurpose'        => $paymentPurpose,
                'paymentDate'           => $paymentDate,
                'paymentDueDate'        => $paymentDueDate,
                'paymentPaidDate'       => $paymentPaidDate,
                'paymentMethod'         => $paymentMethod,
                'paymentAmount'         => $paymentAmount,
                'paymentRef'            => $paymentRef);

        $this->db->insert('payments', $data);

        return $bookingNumber;
    }

    function get_to_date($fromDate,$nights)
    // From a given 'from date' and a number of nights, this method returns the 'to date' and returns it in mysql form Y-m-d
    {
        $explodedFromDate = explode('-',$fromDate);
        $toDate = date("Y-m-d", mktime(0,0,0,$explodedFromDate[1],$explodedFromDate[2]+$nights,$explodedFromDate[0]));
        return $toDate;
    }

    function get_company_data()
    {
        $APP_companyDetails['name'] = 'Ireland at Home';
        $APP_companyDetails['phone1'] = '+353 404 64608/14/61';
        $APP_companyDetails['emailSales'] = 'sales@irelandathome.com';
        $APP_companyDetails['emailSalesFrom'] = 'Ireland at Home <sales@irelandathome.com>';
        $APP_companyDetails['baseurl'] = 'http://www.ckghosting.com/iahadmin/';
        $APP_companyDetails['imageurl'] = 'http://www.irelandathome.com/images';
        $APP_companyDetails['infodocsurl'] = 'http://www.irelandathome.com/infodocs/';
        $APP_companyDetails['imageurl'] = 'https://www.ckghosting.com/';
        $APP_companyDetails['signoff'] = '
        <p>
        Contact Ireland at Home<br />
        From Ireland: 0404 64608/14/61<br />
        International: +353 404 64608/14/61<br />
        <a href="http://www.irelandathome.com">Ireland at Home</a><br />
        <a href="http://www.dublinathome.com">Dublin at Home</a><br />
        Have an eye for a bargain? For very special offers ONLY available on our social network,<br />
        follow us on <a href="http://www.facebook.com/pages/Ireland-At-Home/355348271299">Facebook</a> or <a href="http://www.twitter.com/irelandathome">Twitter</a>
        </p>
        ';
        $APP_companyDetails['currency'] = 'Euro';

        return $APP_companyDetails;
    }

/* GET A COUNTRY DROP DOWN */
    // Get a list of live properties for a combo box display
    function get_country_combo($countryCode)
    {
        $output = '';
        $query =    $this->db->query('select * from country_dd');
        foreach($query->result() as $row)
        {
            $output .= '<option value="' . $row->id . '"';
            if($row->id==$countryCode){
                $output .= ' selected';
            }
            $output .= '>' . $row->name . '</option>';
        }
        return $output;
    }

/* GET A COUNTY DROP DOWN */
    // Get a list of live counties for a combo box display
    function get_county_combo($countyCode)
    {
        $output = '';
        $query =    $this->db->query('select * from county order by county_name');
        foreach($query->result() as $row)
        {
            $output .= '<option value="' . $row->county_id . '"';
            if($row->county_id==$countyCode){
                $output .= ' selected';
            }
            $output .= '>' . $row->county_name . '</option>';
        }
        return $output;
    }

/*  GET COUNTRY BY ID */
    function get_country_by_id($countryId)
    {
        $this->public_db->select('name');
        $this->public_db->from('country_dd');
        $this->public_db->where("id = '$countryId'");
        $query = $this->public_db->get();
        if ($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
                $result = $row->name;
            }

        } else {
            $result = '';
        }
        return $result;
    }

/* GET A REFERRALS DROP DOWN */
    // Get a list of live properties for a combo box display
    function get_referral_combo($referral)
    {
        $output = '';
        if($referral == ''){
            $output .= '<option value="None selected" selected>Select Referral</option>';
        }
        $query =    $this->db->query('select * from referrals order by referral_name');
        foreach($query->result() as $row)
        {
            $output .= '<option value="' . $row->referral_name . '"';
            if($row->referral_name == $referral){
                $output .= ' selected';
            }
            $output .= '>' . $row->referral_name . '</option>';
        }
        return $output;
    }

/* GET A OWNER COMMISSION DROP DOWN */
    // Get a list of commission amounts for a combo box display
    function get_commission_combo()
    {
        $output = '';
        $query =    $this->db->query('select * from commissions order by commissionPercent');
        foreach($query->result() as $row)
        {
            $output .= '<option value="' . $row->commissionPercent . '"';
            $output .= '>' . $row->commissionPercent . '</option>';
        }
        return $output;
    }

/* GET YEAR COMBO
    Can take params of:
    $startYear: Start year for combo. Defaults to current year if not supplied
    $years: Amount of years for combo from start year. Defaults to 10 if not supplied
    $selected: Which combo option year will be selected. Defaults to current year if not supplied
    */
    function get_year_combo($startYear = 0, $years = 10, $selected = 0)
    {
        date_default_timezone_set('UTC');
        $yearCombo = '';

        // Check start year
        if($startYear <= 0) {
            $initialDate = date('Y');
        }else{
            $initialDate = $startYear;
        }

        // Check amount of years out
        if($years <= 0) {
            $years = 10;
        }

        // Check 'selected' value for combo
        if($selected <= 0) {
            $selected = $initialDate;
        }

        // Create the combo
        $endDate = $initialDate + $years;

        for($i=$initialDate; $i <= $endDate; $i++) {
            if($i == $selected){
                $yearCombo .= '<option value="' . $i . '" selected>' .$i. '</option>' . "\n";
            }else{
                $yearCombo .= '<option value="' . $i . '">' .$i. '</option>' . "\n";
            }
        }
        return $yearCombo;
    }

/* GET NOTICES */
    function get_notices()
    {
        // Get notices
        $notices = '';
        $this->db->select('*');
        $this->db->from('notices');
        $this->db->order_by('notice_id','desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $item)
            {
                $notices .=
                    '<li>'  .
                        $item->notice_message .
                        '<br />' .
                        $item->notice_author . '. ' . $this->toLongDate($item->notice_date) .
                    '</li>';
            }
        }
        else
        {
            $notices = '<li>There are no notices</li>';
        }
        return $notices;
    }

/*  GET SALES MARQUEE */
    function get_sales_marquee()
    {
    $output  ='<strong> Payments -> </strong> ';
    $query =    $this->db->query("select * from sales left join customers on customers.customer_number=sales.customerNumber where saleStatus = 'PAID' order by fromDate");
    if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $item)
            {
                $displayBookingDate = $this->global_model->toDisplayDate($item->saleDate);
                $displayFromDate = $this->global_model->toDisplayDate($item->fromDate);

                $output .= '|<a href="index.php/sales/edit_sale/' . $item->salesId . '"> ' . $item->customer_name . ' ' . $item->customer_surname . ' ' . $displayBookingDate .'</a>| ';
            }
        }
        else
        {
            $output = '';
        }
    return $output;
    }

/*  LOAD STANDARD HEADER VIEW */
    function get_standard_header_view()
    {
        // First gather data for the standard header view
        $companyDetails = $this->get_company_data();
        $data['salesData'] = $this->get_sales_marquee();
        $data['companyName'] = $companyDetails['name'];
        $data['notices'] = $this->get_notices();
        $this->load->view('standard_header_view', $data);
        return $data;
    }

    function iah_api_fetch($method)
    {
        $remoteServerPath = 'http://www.irelandathome.com/rpc/iahapi/';
        //$remoteServerPath = 'http://localhost/~mikeb/iah-rpc/rpc/index.php/iahapi/';
        $requestPath = $remoteServerPath.$method;
        $rpc_request = curl_init($requestPath);
        curl_setopt($rpc_request, CURLOPT_RETURNTRANSFER, 1);
        $jsonResult = curl_exec($rpc_request);
        return $jsonResult;
    }

    function get_holiday_data()
    {
        // Get holiday dates and wrap in a table
        $result = '<table><tr><th>Title</th><th>Starts</th><th>Ends</th></tr>';
        $this->db->select('*');
        $this->db->from('holidays');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $item)
            {
                $result .=
                    '<tr>'  .
                    '<td>'  .
                        $item->holidayTitle .
                    '</td>' .
                    '<td>'  .
                        $item->holidayStartDate .
                    '</td>' .
                    '<td>'  .
                        $item->holidayEndDate .
                    '</td>' .
                    '</tr>';
            }
        }
        else
        {
            $result = '<tr><td>There are no dates set</td></tr>';
        }
        return $result;
    }

    function get_holiday_dropdown()
    {
        // Get holiday dates and wrap in a table
        $result = '
                    <option value="Undefined|none">Not seasonal</option>
                    <option value="Undefined|Christmas">Christmas</option>
                    <option value="Undefined|New Year">New Year</option>
                    <option value="Undefined|Valentine">Valentine</option>
                    <option value="Undefined|Mid term">Mid term</option>
                    <option value="Undefined|Paddys">Paddys</option>
                    <option value="Undefined|Mothers">Mothers</option>
                    <option value="Undefined|Easter">Easter</option>
                    <option value="Undefined|Summer specials">Summer Special</option>
                    <option value="Undefined|International Cork Day">International Cork Day</option>
                   ';
        $this->db->select('*');
        $this->db->from('holidays');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $item)
            {
                $result .=
                    '<option value="Defined|' . $item->holidayTitle . '|' . $this->toDisplayDate($item->holidayStartDate) . '|' . $this->toDisplayDate($item->holidayEndDate) . '">' . $item->holidayTitle . '</option>';
            }
        }
        else
        {
            $result = '<select name="holiday" id="holiday"><option>None</option></select>';
        }
        return $result;
    }

    function get_current_vat_rate() {
        $this->db->select('*');
        $this->db->from('seeds');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $item)
            {
                $vatRate = $item->vatPercentage;
            }
        }else{
            $vatRate = 24343.00;
        }
        return $vatRate;
    }

}// End of class
?>
