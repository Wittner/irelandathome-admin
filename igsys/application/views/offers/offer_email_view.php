<?php foreach($query->result() as $row): ?>

<?
$emailOpener = $this->comms_model->get_email_opener();
$emailHeader = $this->comms_model->get_email_header();
$emailFooter = $this->comms_model->get_email_footer();
$companyDetails = $this->global_model->get_company_data();

// SEND CUSTOMER OFFER VIEW
// Set email headers
$emailFrom = $companyDetails['name'];
$emailSubject = 'Accommodation requirement response';

// Set email intro
$introOutput  = '<p>Dear, ' . $row->customer_name . ' ' . $row->customer_surname . '</p>';
$introOutput .= '<p>Thank you for your enquiry.<br />We are delighted to be able to offer you the accommodation listed below. </p>';

// Set email header
$bookingDataOutput  = $offerList;

// Set email main body
$mainBodyOutput = '<p>(All rates quoted are per unit � if you require more than 1 unit please contact us for a revised quote)</p>';

$signoffOutput = '';


// Set up global variables
$fromAddress = $companyDetails['emailSalesFrom'];
$toAddress = $row->customer_email;
$subject = $emailSubject;

?>

<!-- Notification email viewer -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>
<div id="email_wrapper">
<style>
	p.email-para {
			margin-bottom: 12px;
			font-size: 14px;
			color: #808080;
	}
	#email_wrapper {
		width: 800px;
	}
</style>
<!--- ****** EMAIL ******** --->
<!-- IAH Logo box -->
<br><br>
<img src="https://irelandathome.com/images/email_logo.jpg">
<br><br>

<p class="email-para">Hi <?= $row->customer_name; ?>,</p>

<p class="email-para">Many thanks for your enquiry.</p>
<p class="email-para">Please <a href="https://www.irelandathome.com/offer/' . $saleId . '">click here for information and quote on your selected property</a>.</p>
<p class="email-para">If your chosen property is not available we have selected some alternatives which we think may suit as alternatives.</p>
<p class="email-para"> If any of the alternatives offered are not to your liking please don't hesitate to get back to us for more suggestions.</p>
<p class="email-para">If you are open to suggestions you can reply to this email outlining some of your specific requirements and based on this information we will respond with a list of options to interest you.</p>
<p class="email-para">If your dates are flexible please reply with potential dates for your holiday (plus possible destinations). We can guide you towards accommodation that will interest you.</p>

<p class="email-para">Please get in touch by phone or email if we can help in any way with your holiday plans.</p>

<p class="email-para">Please note: Prices and availability shown are correct at the time of sending. The prices quoted are the lowest available for the property type or destination shown and may vary depending on the dates and duration of your stay.  Space is not held without payment. Please double check the 'House Rules' section on the property listing for information pertinent to your booking.</p>

<p class="email-para">Kind Regards,</p>

<p class="email-para">Ireland At Home Reservations<br>
        +353 404 64608
        </p>
<p class="email-para">Contact Ireland at Home<br>
From Ireland: 0404 64608/14/61<br>
International: +353 404 64608/14/61<br>
Ireland at Home<br>
Dublin at Home<br>
</p>
<p class="email-para">
Have an eye for a bargain? For very special offers ONLY available on our social network,<br>
follow us on Facebook or Twitter <br>
</p>


<?=form_open('comms/send_customer_offer');?>
<?=form_hidden('fromAddress', $fromAddress);?>
<?=form_hidden('recipient', $row->customer_name);?>
<?=form_hidden('toAddress', $toAddress);?>
<?=form_hidden('subject', $subject);?>
<?=form_hidden('saleId', $saleId);?>
<?=form_hidden('bookingDataOutput', $bookingDataOutput);?>
<?=form_hidden('signoff', $signoffOutput.$companyDetails['signoff']);?>

<p class="email-para">
<STRONG>NOTES</STRONG><br>
<textarea name="notes" cols="100" rows="8" scrollbars="auto"></textarea><br />
</p>

<p>
Include SMS to: <input name="mobileNumber" type="text" value="<?=$row->customer_mobile;?>" />
	No:<input name="sendSMS" type="radio" value="no" checked />
	Yes:<input name="sendSMS" type="radio" value="yes" />

<input name="submit" type="submit" value="Send offer" />
</p>
<br><br><br><br><br><br><br>
</form>
</div>

<!--- ****** EMAIL ******** --->
<?php endforeach; ?>
