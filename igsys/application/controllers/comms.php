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
class Comms extends Controller
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
    function Comms()
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
        $this->global_model->is_logged_in();
    }

/* CUSTOMER NOTIFICATION EMAILS */
    function send_customer_notification()
    {
		$status = $this->input->post('status');
		$bookingNumber = $this->input->post('bookingNumber');
		$fromAddress = $this->input->post('fromAddress');
		$toAddress = $this->input->post('toAddress');
		$subject = $this->input->post('subject');

		$message = $this->comms_model->get_email_opener();
		$message .= $this->comms_model->get_email_header();
		$message .= '<strong>' . $this->input->post('subject') . '</strong>';
		$message .= $this->input->post('introOutput');
		$message .= $this->input->post('bookingDataOutput');
		$message .= $this->input->post('mainBodyOutput');
		$message .= '<p>' . $this->input->post('notes') . '</p>';
		$message .= $this->input->post('signoffOutput');
		$message .= $this->input->post('emailFooter');

    // $this->exchange->sendExchangeMail($toAddress, $subject, $message);
    $userMessage = $this->comms_model->send_email("sales@irelandathome.com",$toAddress, $subject, $message);

    // Then when we're back from sendExchangeMail, we can continue
		$this->booking_model->change_customer_booking_email_status($bookingNumber,$status);
		$data['heading'] = '<strong>Result from customer notification email</strong>';
		$data['message'] = $userMessage;
		$data['successUrl'] = 'index.php/booking/list_bookings/'.$status;
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('message_view',$data);
		$this->load->view('footer_view');
    }

/* OWNER NOTIFICATION EMAILS */
    function send_owner_notification()
    {
		$status = $this->input->post('status');
		$caretakerNotify = $this->input->post('caretakerNotify');
		$bookingNumber = $this->input->post('bookingNumber');
		$fromAddress = $this->input->post('fromAddress');
		$toAddress = $this->input->post('toAddress');
		$subject = $this->input->post('subject');
		$message = $this->comms_model->get_email_opener();
		$message .= $this->comms_model->get_email_header();
		$message .= '<strong>' . $this->input->post('subject') . '</strong>';
		$message .= $this->input->post('introOutput');
		$message .= $this->input->post('bookingDataOutput');
		$message .= $this->input->post('mainBodyOutput');
		$message .= '<p>' . $this->input->post('notes') . '</p>';
		$message .= $this->input->post('messageSignoff');
		$message .= $this->input->post('messageFooter');
    $userMessage = '';
    $caretakerMessage = '';

		// Send the email
		// $mailResult = $this->exchange->sendExchangeMail($toAddress, $subject, $message);
    $userMessage = $this->comms_model->send_email("sales@irelandathome.com",$toAddress, $subject, $message);

		// Send caretaker email if applicable
		if($caretakerNotify == 'yes')
		{
			$companyData = $this->global_model->get_company_data();
			$caretakerAddress = $this->input->post('caretakerAddress');
			$caretakerIntroOutput = $this->input->post('caretakerIntroOutput');
			$caretakerBookingDataOutput = $this->input->post('caretakerBookingDataOutput');
			$to = $caretakerAddress;
			$to .= ', ' . "sales@irelandathome.com";
			$message = $this->comms_model->get_email_opener();
			$message .= $this->comms_model->get_email_header();
			$message .= $caretakerIntroOutput;
			$message .= $caretakerBookingDataOutput;
			$message .= '<p>' . $this->input->post('notes') . '</p>';
			$message .= $this->input->post('messageSignoff');
			$message .= $this->input->post('messageFooter');

			// Send the email
			// $mailResult .= '<br>' . $this->exchange->sendExchangeMail($to, $subject, $message);
      $caretakerMessage = $this->comms_model->send_email("sales@irelandathome.com",$to, $subject, $message);
		}


		$this->booking_model->change_owner_booking_email_status($bookingNumber,$status);
		$data['heading'] = '<strong>Result from owner notification email</strong>';
		$data['message'] = $userMessage . $caretakerMessage;
		$data['successUrl'] = 'index.php/booking/list_bookings/'.$status;
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('message_view',$data);
		$this->load->view('footer_view');
    }

/* SEND OFFER EMAIL */
    function send_customer_offer() {
      $config['mailtype'] = 'html';
      $this->email->initialize($config);
      $recipient = $this->input->post('recipient');
      $notes = $this->input->post('notes');
      $saleId = $this->input->post('saleId');
      $sendSMS = $this->input->post('sendSMS');
      $mobileNumber = $this->input->post('mobileNumber');
      $to = $this->input->post('toAddress');
      $to = $to . ', sales@irelandathome.com';
  		$from = 'sales@irelandathome.com';
  		$subject = 'Accommodation requirement response';
      $message = $this->comms_model->iah_get_email_header();
      $message .= $this->comms_model->iah_get_offers_body($recipient, $saleId, $notes);
  		$message .= $this->comms_model->iah_get_offers_footer();
      $offersMessage = $this->comms_model->send_email($from,$to,$subject,$message);
      echo "Email sent to ' . $to . '<br>";

      /*** SMS ***/
  		if($sendSMS == 'yes') {
        echo 'Sending sms<br><br>';
        //** NEON SMS SERVICE CODE
        $mobileNumber = $mobileNumber;
        $smsMessage	 =	"Ireland at Home";
        $smsMessage	.= "\n\r";
        $smsMessage	.=	"Please check your";
        $smsMessage	.= "\n\r";
        $smsMessage	.=	"e-mail for information";
        $smsMessage	.= "\n\r";
        $smsMessage	.=	"on your";
        $smsMessage	.= "\n\r";
        $smsMessage	.=	"accommodation enquiry.";
        $smsMessage	.= "\n\r";
        $smsMessage	.=	"If not at your PC call us,";
        $smsMessage	.= "\n\r";
        $smsMessage	.=	"0404 64608";
        $smsMessage	.= "\n\r";
        $smsMessage	.=	"(Int +353 404 64608)";
        $smsMessage	.= "\n\r";
        $smsMessage	.=	"to discuss.";
        $smsMessage = urlencode($smsMessage);

        $username="Wittner";
        $password="0cydlcsv7cxq";

        $baseurl="http://api.neonsolutions.ie";
        $url=$baseurl."/sms.php?user=$username&clipwd=$password&text=$smsMessage&to=$mobileNumber";

        $smssResult = $this->comms_model->send_neon_sms($url);
        $smsStatus = explode(":", $smssResult);
        if($smsStatus[0] == 'OK') {
          $msgid = trim($smsStatus[1]);
          $smsResultMessage = "<strong>SMS message id:</strong> " . $msgid . " successfully sent to <strong>" . $mobileNumber . "</strong><br>";
        }else{
          $error = trim($smsStatus[1]);
          $smsResultMessage = "There was an error sending the SMS message. " . $error . "<br>";
        }
        echo $smsResultMessage . "<br>";
      }

      echo $offersMessage;
      echo "Finished...<br>";
      echo '<a href="http://www.corporaterentalseurope.com/iahadmin/index.php/sales/edit_sale/' . $saleId . '">Return to sale</a>';
      // redirect('/sales/edit_sale/'.$saleId, 'location');
    }

/*	SEND AN EMAIL */
	function send_email($from,$to,$subject,$message)
	{
		$config['mailtype'] = 'html';
    $this->email->initialize($config);
		$this->email->from($fromAddress);
		$this->email->to($toAddress);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
	}

/*	POST AN EMAIL */
	function post_arrivals_email()
	{
		$fromAddress = $this->input->post('fromAddress');
		$toAddress = $this->input->post('toAddress');
		$subject = $this->input->post('subject');
		$message = base64_decode($this->input->post('message'));

		$config['mailtype'] = 'html';
    $this->email->initialize($config);
		$this->email->from($fromAddress);
		$this->email->to($toAddress);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
	}


/* SEND AN SMS */
	function send_sms()
	{
// Send sms mail
// recipient
// vN6Z4arl
$fromAddress = 'mike@irelandathome.com';
$to  = "sms@messaging.clickatell.com";
// $sms_number = '353876869146';
// $sms_number = '353861000277';
$sms_number = '353851769592';

// subject
$subject = "Ireland At Home";
// message
$message ="
api_id:1790050
user:mikeb
password:vN6Z4arl
from:Irl at Home
reply:mike@irelandathome.com
to:".$sms_number."
text:Ireland At Home
text:Accommodation rentals
text:===================
text:Check your email.
text:We have answered your
text:accommodation enquiry.
text:or call us on
text:+353 404 64608
callback:3";
$this->email->from($fromAddress);
$this->email->to($to);
$this->email->subject($subject);
$this->email->message($message);
$this->email->send();
}


}// End of class

?>
