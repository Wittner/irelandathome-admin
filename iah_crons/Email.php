<?php

/* Email library for Exchange server using PEAR */
require_once "Mail.php";
require_once "Mail/mime.php";

	function send_exchange_email($toAddress, $subject, $message, $key)
	{
		if($key === '3389871987418974889798:!}Oii') {
			
			// Set recipient info
			$from = "Sales <sales@irelandathome.com>";
			$to = $toAddress;
			$subject = $subject;
					
			// Set email content
			$textBody = "This email contains HTML. Your system cannot show HTML. Please contact the sender for further details";
			$htmlBody = $message;
			$crlf = "\n";
			
			
			// Set sever info
			$host = "smtp.office365.com";
			$port = "587";
			$username = "sales@irelandathome.com";
			$password = "selfcaterL1v3:";
			$headers = array (
				'From' => $from,
				'To' => $to,
				'Subject' => $subject
				);
	
			// Send the mail
			$mime = new Mail_mime(array('eol' => $crlf));
	
			$mime->setTXTBody($textBody);
			$mime->setHTMLBody($htmlBody);
	
			$body = $mime->get();
			$headers = $mime->headers($headers);
	
			$smtp = Mail::factory('smtp',
				array (
					'host' => $host,
					'port' => $port,
					'auth' => true,
					'username' => $username,
					'password' => $password
					)
				);
			$mail = $smtp->send($to, $headers, $body);
	
			if (PEAR::isError($mail)) {
				$userMessage = "<p>" . $mail->getMessage() . "</p>";
			} else {
				$userMessage = 'Email message successfully sent to: ' . $toAddress;
			}
			return $userMessage;
		}else{
			die('Invalid');
		}
	}




