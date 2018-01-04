<?php 

require_once "Email.php";

$emailArray = array('mike@irelandathome.com', 'mike@corkholidayhomes.com', 'ian@irelandathome.com', 'sales@irelandathome.com', 'design@onamansfield.com');

foreach ($emailArray as $emailEntry) {
	$result = send_exchange_email($emailEntry, 'Tester', 'Testing multiple send with Exchange. Ignore these emails for now :-) .....', '3389871987418974889798:!}Oii');
	echo $result . '<br>';
}