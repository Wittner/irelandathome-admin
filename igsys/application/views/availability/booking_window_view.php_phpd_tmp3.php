<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title></title>
  
<link rel='stylesheet' type='text/css' media='all' href='iahAdminCss.css' />
<script language="JavaScript" src="calendarjs/calendar1.js"></script>
</head>
<body>
<div>
<form id="bookingForm" name="bookingForm" method="post" action="availability/makeBooking">
Booking form for: <strong><?php echo $propertyName; ?></strong>
<hr />
From:<strong><?php echo $availDate; ?></strong> 
To: - 
<input type="text" name="toDate" value="<?php echo $displayAvailDate; ?>" />
<a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Click Here to Pick up the date" /></a><br />
Purpose:
<select name="purpose">
<option value="book">Booking</option>
<option value="hold">Hold</option>
<option value="block">Block out</option>
</select>
<input id="submit" type="submit" value="Post" />
</form>
<script language="JavaScript">
  <!--
  // create calendar object(s) just after form tag closed
  // specify form element as the only parameter (document.forms['formname'].elements['inputname']);
  // note: you can have as many calendar objects as you need for your application
  var cal1 = new calendar1(document.forms['bookingForm'].elements['toDate']);
  cal1.year_scroll = true;
  cal1.time_comp = false;
  -->
</script>
</div>

</body>
</html>
