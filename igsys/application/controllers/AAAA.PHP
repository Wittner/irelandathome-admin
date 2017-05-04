$config['mailtype'] = 'html';
    $this->email->initialize($config);

		$saleId = $this->input->post('saleId');
		$fromAddress = $this->input->post('fromAddress');
		$toAddress = $this->input->post('toAddress');
		$subject = $this->input->post('subject');

		//$message = $this->comms_model->get_email_opener();
		//$message .= $this->comms_model->get_email_header();
		//$message .= $this->input->post('messageIntro');
		//$message .= $this->input->post('bookingDataOutput');
		//$message .= '<strong>' . $this->input->post('subject') . '</strong>';
		//$message .= $this->input->post('mainBodyOutput');
		//$message .= '<p>' . $this->input->post('notes') . '</p>';
		//$message .= $this->input->post('messageSignoff');
		//$message .= $this->input->post('messageFooter');

		$message  = $this->input->post('message');
		$message .=$this->input->post('notes');

		$this->email->from($fromAddress,'Ireland at Home');
		$this->email->to($toAddress);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();

		// Send the SMS
		$sendSMS = $this->input->post('sendSMS');
		//echo $sendSMS;
      if($sendSMS == 'yes') {
        // Send sms mail
        $this->email->clear();
        $config['mailtype'] = 'text';
        $this->email->initialize($config);
        $to  = "sms@messaging.clickatell.com";
        $fromAddress = 'mike@irelandathome.com';
        $to  = "sms@messaging.clickatell.com";
        $sms_number = $this->input->post('mobileNumber');
        // $sms_number = '353876869146';
        $subject = "Ireland At Home";
        $message ="
        api_id:1790050
        user:mikeb
        password:vN6Z4arl
        from:Irl at Home
        reply:mike@irelandathome.com
        to:".$sms_number."
        text:Please check your
        text:e-mail for information
        text:on your
        text:accommodation enquiry.
        text:If not at your PC call us,
        text:0404 64608
        text:(Int +353 404 64608)
        text:to discuss.
        callback:3";
        $this->email->from($fromAddress);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->send();
      }

      $this->sales_model->set_sale_offer_sent_date($saleId);
      $data['heading'] = 'Success!';
      $data['message'] = 'Offer sent!';
      $data['successUrl'] = 'index.php/sales/list_sales/';
      $headerView = $this->global_model->get_standard_header_view();
      $this->load->view('message_view',$data);
      $this->load->view('footer_view');
