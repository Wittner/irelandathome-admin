<?php
class Comms_model extends Model
{

    function Comms_model()
    {
        parent::Model();
        $this->load->library('email');
        $this->load->model('global_model');
    }


/* SEND AN SMS */

  function send_neon_sms($url)
  {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $url
    ));
    $curlResult = curl_exec($curl);
    curl_close($curl);
    return $curlResult;
  }

/*	SEND AN EMAIL */
	function send_email($from,$to,$subject,$message)
	{
    $to = str_replace(" ", "", $to);
    $userMessage = '';

    $toArray = explode(",", $to);

    foreach ($toArray as $key => $value) {
			if (!filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
				$userMessage .= $value . " is a valid email address, mail sent<br>";
			} else {
				$userMessage .= $value . " is not a valid email address, changing to sales@irelandathome.com :-), mail sent<br>";
				$toArray[$key] = "sales@irelandathome.com";
			}
		}

    $to = implode(", ",$toArray);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, 'api:key-cf0cb806d66d88ba216999920c61297a');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_URL,
                'https://api.mailgun.net/v3/mg.irelandathome.com/messages');
    curl_setopt($ch, CURLOPT_POSTFIELDS,
                  array('from' => 'Ireland At Home sales <sales@irelandathome.com>',
                        'to' => $to,
                        'subject' => $subject,
                        'text' => 'It appears your email does not support html. Please contact Ireland At Home about your recent sale.',
                        'html' => $message));
    $result = curl_exec($ch);
    curl_close($ch);

    $userMessage .= $result;
    return $userMessage;
	}

/*	GET EMAIL OPENER */
	function get_email_opener()
	{
		$emailOpener ='<html><body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" bgcolor="#99CC00" >';
		return $emailOpener;
	}


/*	GET EMAIL HEADER */
	function get_email_header()
	{
		$APP_companyDetails = $this->global_model->get_company_data();
		$emailHeader='
		<style>
 		.headerTop { background-color:#FFCC66; border-top:0px solid #000000; border-bottom:1px solid #FFFFFF; text-align:left; }
 		.adminText { font-size:10px; color:#996600; line-height:200%; font-family:verdana; text-decoration:none; }
 		.headerBar { background-color:#FFFFFF; border-top:0px solid #333333; border-bottom:10px solid #FFFFFF; }
 		.title { font-size:20px; font-weight:bold; color:#CC6600; font-family:arial; line-height:110%; }
 		.subTitle { font-size:11px; font-weight:normal; color:#666666; font-style:italic; font-family:arial; }
 		.defaultText { font-size:12px; color:#000000; line-height:150%; font-family:trebuchet ms; }
 		.footerRow { background-color:#FFFFCC; border-top:10px solid #FFFFFF; }
 		.footerText { font-size:10px; color:#996600; line-height:100%; font-family:verdana; }
 		a { color:#FF6600; color:#FF6600; color:#FF6600; }
		</style>



		<table width="100%" cellpadding="10" cellspacing="0" class="backgroundTable" bgcolor="#95ca34" >
		<tr>
		<td valign="top" align="center">


		<table width="550" cellpadding="0" cellspacing="0">

		<tr>

		<td style="background-color:#a2e6fc;border-top:0px solid #000000;border-bottom:1px solid #FFFFFF;text-align:center;" align="center"><span style="font-size:10px;color:#27545a;line-height:200%;font-family:verdana;text-decoration:none;">
		<!-- Email not displaying correctly? <a href="*|ARCHIVE|*" style="font-size:10px;color:#996600;line-height:200%;font-family:verdana;text-decoration:none;">View it in your browser.</a></span>-->
		If you cannot view this email correctly, please contact us immediately for clarification.
		</td>
		</tr>

		<tr>
		<td style="background-color:#FFFFFF;border-top:0px solid #333333;border-bottom:10px solid #FFFFFF;"><center><a href=""><IMG id=companylogo SRC="' . $APP_companyDetails['imageurl'] . 'emaillogo.gif" BORDER="0" title="' . $APP_companyDetails['name']. ' logo"  alt="' . $APP_companyDetails['name'] . ' logo" align="center"></a></center></td>
		</tr>
		</table>


		<table width="550" cellpadding="20" cellspacing="0" bgcolor="#FFFFFF">
		<tr>
		<td bgcolor="#FFFFFF" valign="top" style="font-size:12px;color:#000000;line-height:150%;font-family:trebuchet ms;" align="left">
		';
		return $emailHeader;
	}
/*	GET EMAIL FOOTER */
	function get_email_footer()
	{
		$APP_companyDetails = $this->global_model->get_company_data();
		$emailFooter='
		</td>
		</tr>

		<tr>
		<td style="background-color:#a2e6fc;border-top:10px solid #FFFFFF;" valign="top" align="center">
		<span style="font-size:10px;color:#27545a;line-height:100%;font-family:verdana;">
		Copyright (C) 2009  ' . $APP_companyDetails['name'] . ' All rights reserved.<br />
		</span>
		</td>
		</tr>

		</table>
		</td>
		</tr>
		</table>
		';
		return $emailFooter;
	}
/*	GET EMAIL CLOSER */
	function get_email_closer()
	{
		$emailCloser='</body></html>';
		return $emailCloser;
	}

/*  GET EMAIL HEADER */
  function iah_get_email_header() {
    $iah_email_header = '<!DOCTYPE html>
      <html lang="en">
      <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="x-apple-disable-message-reformatting">
          <title></title>

          <!-- Web Font / @font-face : BEGIN -->
          <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->

          <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
          <!--[if mso]>
              <style>
                  * {
                      font-family: sans-serif !important;
                  }
              </style>
          <![endif]-->

          <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
          <!--[if !mso]><!-->
              <!-- insert web font reference, eg: <link href="https://fonts.googleapis.com/css?family=Roboto:400,700 rel="stylesheet" type="text/css"> -->
          <!--<![endif]-->

          <!-- Web Font / @font-face : END -->

          <!-- CSS Reset -->
          <style>

              /* What it does: Remove spaces around the email design added by some email clients. */
              /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
              html,
              body {
                  margin: 0 auto !important;
                  padding: 0 !important;
                  height: 100% !important;
                  width: 100% !important;
              }

              /* What it does: Stops email clients resizing small text. */
              * {
                  -ms-text-size-adjust: 100%;
                  -webkit-text-size-adjust: 100%;
              }

              /* What it does: Centers email on Android 4.4 */
              div[style*="margin: 16px 0"] {
                  margin:0 !important;
              }

              /* What it does: Stops Outlook from adding extra spacing to tables. */
              table,
              td {
                  mso-table-lspace: 0pt !important;
                  mso-table-rspace: 0pt !important;
              }

              /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
              table {
                  border-spacing: 0 !important;
                  border-collapse: collapse !important;
                  table-layout: fixed !important;
                  margin: 0 auto !important;
              }
              table table table {
                  table-layout: auto;
              }

              /* What it does: Uses a better rendering method when resizing images in IE. */
              img {
                  -ms-interpolation-mode:bicubic;
              }

              /* What it does: A work-around for iOS meddling in triggered links. */
              *[x-apple-data-detectors] {
                  color: inherit !important;
                  text-decoration: none !important;
              }

              /* What it does: A work-around for Gmail meddling in triggered links. */
              .x-gmail-data-detectors,
              .x-gmail-data-detectors *,
              .aBn {
                  border-bottom: 0 !important;
                  cursor: default !important;
              }

              /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
              .a6S {
      	        display: none !important;
      	        opacity: 0.01 !important;
              }
              /* If the above doesnt work, add a .g-img class to any image in question. */
              img.g-img + div {
      	        display:none !important;
      	   	}

              /* What it does: Prevents underlining the button text in Windows 10 */
              .button-link {
                  text-decoration: none !important;
              }

              /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
              /* Create one of these media queries for each additional viewport size youd like to fix */
              /* Thanks to Eric Lepetit @ericlepetitsf) for help troubleshooting */
              @media only screen and (min-device-width: 375px) and (max-device-width: 413px) { /* iPhone 6 and 6+ */
                  .email-container {
                      min-width: 375px !important;
                  }
              }

          </style>

          <!-- Progressive Enhancements -->
          <style>

              /* What it does: Hover styles for buttons */
              .button-td,
              .button-a {
                  transition: all 100ms ease-in;
              }
              .button-td:hover,
              .button-a:hover {
                  background: #555555 !important;
                  border-color: #555555 !important;
              }

              /* Media Queries */
              @media screen and (max-width: 480px) {

                  /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
                  .fluid {
                      width: 100% !important;
                      max-width: 100% !important;
                      height: auto !important;
                      margin-left: auto !important;
                      margin-right: auto !important;
                  }

                  /* What it does: Forces table cells into full-width rows. */
                  .stack-column,
                  .stack-column-center {
                      display: block !important;
                      width: 100% !important;
                      max-width: 100% !important;
                      direction: ltr !important;
                  }
                  /* And center justify these ones. */
                  .stack-column-center {
                      text-align: center !important;
                  }

                  /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
                  .center-on-narrow {
                      text-align: center !important;
                      display: block !important;
                      margin-left: auto !important;
                      margin-right: auto !important;
                      float: none !important;
                  }
                  table.center-on-narrow {
                      display: inline-block !important;
                  }
              }

          </style>

      </head>
      <body width="100%" bgcolor="#e6f7fe" style="margin: 0; mso-line-height-rule: exactly;">
          <center style="width: 100%; background: #e6f7fe; text-align: left;">

              <!-- Visually Hidden Preheader Text : BEGIN -->
              <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">
                  Your requested offer from Ireland At Home
              </div>
              <!-- Visually Hidden Preheader Text : END -->

              <!--
                  Set the email width. Defined in two places:
                  1. max-width for all clients except Desktop Windows Outlook, allowing the email to squish on narrow but never go wider than 680px.
                  2. MSO tags for Desktop Windows Outlook enforce a 680px width.
                  Note: The Fluid and Responsive templates have a different width (600px). The hybrid grid is more "fragile", and Ive found that 680px is a good width. Change with caution.
              -->
              <div style="max-width: 680px; margin: auto; padding-top: 40px;" class="email-container">
                  <!--[if mso]>
                  <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" width="680" align="center">
                  <tr>
                  <td>
                  <![endif]-->

                  <!-- IAH Logo box -->
                  <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="20" border="0" align="center" width="100%" style="max-width: 680px; margin-bottom: 20px;">
                      <!-- 1 Column Text + Button : BEGIN -->
                      <tr>
                          <td bgcolor="#ffffff" text-align="center" style="text-align:center;">
                              <img src="https://irelandathome.com/images/email_logo.jpg" aria-hidden="true" width="263" height="41" alt="Ireland at Home booking attempt" border="0">
                          </td>
                      </tr>
                  </table>
                  <br>
                  ';
      return $iah_email_header;
  }

  function iah_get_offers_body($recipient, $saleId, $notes) {
    $offers_body = '<!-- Email Body : BEGIN -->
      <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px;">
          <!-- 1 Column Text + Button : BEGIN -->
          <tr>
              <td bgcolor="#ffffff">
                  <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <!-- Admin intro message -->
                    <tr>
                        <td style="padding-top: 10px; padding-left: 40px; padding-right: 40px; padding-bottom: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #888888;">
                        <p>Hi ' . $recipient . ',</p>

                        <p>Many thanks for your enquiry.</p>

                        <p>Please <a href="https://irelandathome.com/offer/' . $saleId . '">click here for information and quote on your selected property</a>.</p>

                        <p>' . $notes . '</p>

                        <p>If your chosen property is not available we have selected some alternatives which we think may suit as alternatives.</p>
                        <p> If any of the alternatives offered are not to your liking please don\'t hesitate to get back to us for more suggestions.</p>
                        <p>If you are open to suggestions you can reply to this email outlining some of your specific requirements and based on this information we will respond with a list of options to interest you.</p>

                        <!-- <p>We appreciate the importance of value for money in these difficult times. We generally have a selection of properties on Special Offer. If you are flexible on where you would like to go we can provide some additional quotes for you. We are happy to provide suggestions!</p> -->

                        <p>If your dates are flexible please reply with potential dates for your holiday (plus possible destinations). We can guide you towards accommodation that will interest you.</p>

                        <p>Please get in touch by phone or email if we can help in any way with your holiday plans.</p>

                        <p>Please note: Prices and availability shown are correct at the time of sending. The prices quoted are the lowest available for the property type or destination shown and may vary depending on the dates and duration of your stay.  Space is not held without payment. Please double check the \'House Rules\'" section on the property listing for information pertinent to your booking.</p>

                        </td>
                    </tr>
                  </table>
              </td>
          </tr>

          <!-- Thumbnail Right, Text Left : BEGIN -->
          <tr>
              <!-- dir=rtl is where the magic happens. This can be changed to dir=ltr to swap the alignment on wide while maintaining stack order on narrow. -->
              <td dir="rtl" bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%" style="padding: 10px 0; padding-right: 31px; padding-left: 25px;">
                  <!--[if mso]>
                  <table role="presentation" aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="660">
                  <tr>
                  <td align="center" valign="top" width="660">
                  <![endif]-->
                  <table role="presentation" aria-hidden="true" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:680px;">
                      <tr>
                          <td align="center" valign="top" style="font-size:0; padding: 10px 0;">
                              <!--[if mso]>
                              <table role="presentation" aria-hidden="true" border="0" cellspacing="0" cellpadding="0" align="center" width="660">
                              <tr>
                              <td align="left" valign="top" width="220">
                              <![endif]-->
                              <!--[if mso]>
                              </td>
                              <td align="left" valign="top" width="440">
                              <![endif]-->
                              <!--[if mso]>
                              </td>
                              </tr>
                              </table>
                              <![endif]-->
                          </td>
                      </tr>
                  </table>
                  <!--[if mso]>
                  </td>
                  </tr>
                  </table>
                  <![endif]-->
              </td>
          </tr>
          <!-- Thumbnail Right, Text Left : END -->

          <!-- Clear Spacer : BEGIN -->
          <tr>
              <td height="40" style="font-size: 0; line-height: 0;">
                  &nbsp;
              </td>
          </tr>
          <!-- Clear Spacer : END -->

      </table>
      <!-- Email Body : END -->';
      return $offers_body;
  }

  function iah_get_offers_footer() {
    $offers_footer = '<!-- Email Footer : BEGIN -->
                  <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px;">
                      <tr>
                          <td align="left" style="padding: 40px 10px; padding-top: 10px; width: 100%;font-size: 15px; font-family: sans-serif; line-height:18px; text-align: center; color: #888888;" class="x-gmail-data-detectors">
                          <p style="text-align: left;">Kind Regards,</p>

                          <p style="text-align: left;">Ireland At Home Reservations<br>
                          +353 404 64608
                          </p>

                          <p style="text-align: left;">Contact Ireland at Home<br>
                          From Ireland: 0404 64608/14/61<br>
                          International: +353 404 64608/14/61<br>
                          Ireland at Home<br>
                          Dublin at Home<br>
                          </p>
                          <p>
                          Have an eye for a bargain? For very special offers ONLY available on our social network,<br>
                          follow us on Facebook or Twitter <br>
                          </p>
                          </td>
                      </tr>
                  </table>
                  <!-- Email Footer : END -->

                  <!--[if mso]>
                  </td>
                  </tr>
                  </table>
                  <![endif]-->
              </div>
          </center>
      </body>
      </html>';
    return $offers_footer;
  }

}// End of Class
?>
