

<!-- Availability listing view -->
<script type="text/javascript">
/* NB - Other part of this script is in the main header view (header_view.php) */
/* Height for these divs is set in the main header view (header_view.php) */

/* Set form vars for booking availability */
function setVars(calendarDate,townId,propertyCodeIn,propertyIn,fromDislplayDateIn,fromDateIn)
{
	animatedcollapse.hide('booknow');
	animatedcollapse.hide('releasenow');
	animatedcollapse.show('booknow');
	document.bookingForm.defaultCalendarDate.value=calendarDate;
	document.bookingForm.townId.value=townId;
	document.bookingForm.propertyCode.value=propertyCodeIn;
	document.bookingForm.propertyName.value=propertyIn;
	document.bookingForm.fromDisplayDate.value=fromDislplayDateIn;
	document.bookingForm.fromDate.value=fromDateIn;
}

/* Set form vars for releasing availability */
function setReleaseVars(calendarDate,townId,propertyCodeIn,propertyIn,fromDislplayDateIn,fromDateIn)
{
	animatedcollapse.hide('booknow');
	animatedcollapse.hide('releasenow');
	animatedcollapse.show('releasenow');
	document.releaseForm.defaultCalendarDate.value=calendarDate;
	document.releaseForm.townId.value=townId;
	document.releaseForm.propertyCode.value=propertyCodeIn;
	document.releaseForm.propertyName.value=propertyIn;
	document.releaseForm.fromDisplayDate.value=fromDislplayDateIn;
	document.releaseForm.fromDate.value=fromDateIn;
}
</script>


<!-- Make a booking, hold or close out (div hidden by default)-->
<div id="booknow">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<form action="index.php/availability/start_booking" method="post" name="bookingForm" >
	<input type="hidden" id="defaultCalendarDate" name="defaultCalendarDate"  value="<?=$calendarDate;?>" />
	<input type="hidden" id="defaultTownId" name="defaultTownId" value="<?=$townId;?>" />
	<input type="hidden" id="propertyCode" name="propertyCode" />
	<input type="hidden" id="townId" name="townId" />
	<input type="hidden" id="fromDate" name="fromDate" />
	<input type="hidden" id="rooms" name="rooms" value="<?=$rooms;?>" />
	<input type="hidden" id="sleeps" name="sleeps" value="<?=$sleeps;?>" />
	<input type="hidden" id="code" name="code" value="<?=$code;?>" />
	<input type="hidden" id="filter" name="filter" value="<?=$filter;?>" />
	<td>
		<strong>Action: </strong><br />
		<select name="action">
			<option value="closeSingle">Close single allocation</option>
			<option value="closeAll">Close all allocation</option>
			<option value="releaseSingle">Release single allocation</option>
			<option value="releaseAll">Release all allocation</option>
			<option value="book">Book</option>
			<option value="hold">Hold single allocation</option>
			<option value="close1">Close single</option>
			<option value="price">Fetch price</option>
		</select></td>
	<td>
		<strong>Property: </strong><br />
		<input id="propertyName" name="propertyName" value="" readonly="true" size="40" /></td>
	<td>
		<strong>From: </strong><br />
		<input id="fromDisplayDate" name="fromDisplayDate" readonly="true" /></td>
	<td>
		<strong>Nights: </strong><br />
		<input name="customerNights" type="text" value="1" size="4" /></td>

	<td><strong>Submit</strong><br />
		<?= form_submit('mysubmit', 'Proceed!');?>
	</td>
<?=form_close();?>
</tr>
</table>
</div>

<!-- Release a booking (div hidden by default)-->
<div id="releasenow">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<form action="index.php/availability/start_booking" method="post" name="releaseForm">
	<input type="hidden" id="defaultCalendarDate" name="defaultCalendarDate"  value="<?=$calendarDate;?>" />
	<input type="hidden" id="defaultTownId" name="defaultTownId" value="<?=$townId;?>" />
	<input type="hidden" id="propertyCode" name="propertyCode" />
	<input type="hidden" id="townId" name="townId" />
	<input type="hidden" id="fromDate" name="fromDate" />
	<input type="hidden" id="rooms" name="rooms" value="<?=$rooms;?>" />
	<input type="hidden" id="sleeps" name="sleeps" value="<?=$sleeps;?>" />
	<input type="hidden" id="code" name="code" value="<?=$code;?>" />
	<input type="hidden" id="filter" name="filter" value="<?=$filter;?>" />
	<td>
		<strong>Action: </strong><br />
		<input name="action" id="action" type="text" value="release" readonly="true" /></td>
	<td>
		<?=form_hidden('propertyCodeR', '');?>
		<strong>Property: </strong><br />
		<input id="propertyName" name="propertyName" readonly="true" size="55" /></td>
	<td>
		<strong>From: </strong><br />
		<input id="displayFromDate" name="fromDisplayDate" readonly="true" /></td>
	<td>
		<strong>Nights: </strong><br />
		<input name="numberNights" type="text" value="1" size="4" /></td>

	<td><strong>Submit</strong><br />
		<?= form_submit('mysubmit', 'Proceed!');?></td>
		<?=form_close();?>
</tr>
</table>
</div>

<div id="delivery">
<?= $calendar; ?>
</div>
