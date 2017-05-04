<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class CI_Exchange {

	/* Constructor */
	function CI_Exchange($config = array())
	{
		require_once "Mail.php";
		require_once "Mail/mime.php";
	}

	function sendExchangeMail($toAddress, $subject, $message) {
		// Set recipient info
		$from = "Sales <sales@irelandathome.com>";
		$subject = $subject;
		$userMessage = "";

		// Set email content
		$textBody = "This email contains HTML. Your system cannot show HTML. Please contact the sender for further details";
		$htmlBody = $message;
		$crlf = "\n";

		$toArray = explode(", ", $toAddress);

		print_r($toArray);
		echo "<br>";

		foreach ($toArray as $key => $value) {
			if (!filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
				$userMessage .= $value . " is a valid email address<br>";
			} else {
				$userMessage .= $value . " is not a valid email address, changing to sales@irelandathome.com :-)<br>";
				$toArray[$key] = "mike@irelandathome.com";
			}
		}

		$to = implode(", ",$toArray);
		echo $to . "<br>";

  		// Do email
			// Set server info
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

			if (!$smtp->email->send()) {
    			echo 'Your e-mail could not be sent!';
				}else {
    			echo 'Your e-mail has been sent!';
			}
			return;
	}
}
// End of CI_Exchange
