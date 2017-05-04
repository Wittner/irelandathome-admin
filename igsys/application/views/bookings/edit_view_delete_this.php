<div id="delivery">

<?
if($payments != ''){
$paymentsOutput ="
{$payments}
";	
}else
{$paymentsOutput = '';}

if($charges != ''){
$chargesOutput ="
{$charges}
";	
}else
{$paymentsOutput = '';}

?>

<?php foreach($query->result() as $row): ?>
<?
/* SET THE OWNER PAID DATE */

if($row->ownerPaidDate == '0000-00-00')
{
	$displayOwnerPaidDate = date('Y-m-d');
}
else
{
	$displayOwnerPaidDate = $row->ownerPaidDate;
}

$displayArrivalDate = $this->global_model->toDisplayDate($row->fromDate);
$displayDepartureDate = $this->global_model->toDisplayDate($row->toDate);

?>

<!-- Booking record start -->

<table border="0" width="100%" align="center" cellpadding="2" cellspacing="0" bgcolor="#E6F7FF">

<!-- Add new payment -->
<tr><td class="avail_mainhead" colspan="6"><strong>Payments:</strong></td></tr>

<tr>
<?=form_open('booking/add_payment');?>
<input type="hidden" name="bookingNumber" value="<?=$row->bookingNumber;?>" />
<td colspan="6">
	<table border="0" align="left" width="100%">
	<tr>
	<td>
	Payment type:<br />
	<select name="paymentMethod">
	 <option value="Credit card">Credit card</option>
	 <option value="Laser card">Laser</option>
	 <option value="Bank Lodgement">Bank Lodgement</option>
	 <option value="PayPal">PayPal</option>
	</select>
	</td>
	<td>
	Purpose:<br />
	<select name="paymentPurpose">
	 <option value="Deposit">Deposit</option>
	 <option value="Final payment">Final</option>
	 <option value="Accommodation">Accommodation</option>
	 <option value="Refund (Cancellation)">Refund (Cancellation)</option>
	 <option value="Utilities">Utilities</option>
	 <option value="Security Deposit">Security Deposit</option>
	 <option value="Interim Payment">Interim Payment</option>
	 <option value="Refund (Complaint)">Refund (Complaint)</option>
	 <option value="Refund (Over payment)">Refund (Over payment)</option>
	 <option value="Refund (Availability)">Refund (Availability)</option>
	 <option value="Adjustment">Adjustment</option>
	</select>
	</td>
	<td>
	Payment amount:<br />
	&euro;<input type="text" size="8" name="paymentAmount" value="" />
	</td>
	<td>
	Payment ref.:<?php echo @$this->validation->paymentRef_error;?><br />
	<input type="text" name="paymentRef" size="25" />
	</td>
	<td align="right"><input type="submit" name="trans" value="Add payment" /></td>
	</tr>
	</table>
</td>
</form>
</tr>

<!-- Add a new charge -->
<tr><td class="avail_mainhead" colspan="6"><strong>Charges:</strong></td></tr>

<tr>
<?=form_open('booking/add_charge');?>
<input type="hidden" name="bookingNumber" value="<?=$row->bookingNumber;?>" />
<input type="hidden" name="accommCost" value="<?=$row->accommCost;?>" />
<input type="hidden" name="bookingFee" value="<?=$row->bookingFee;?>" />
<input type="hidden" name="customerTotalCharges" value="<?=$row->customerTotalCharges;?>" />
<input type="hidden" name="bookingDiscount" value="<?=$row->bookingDiscount;?>" />
<input type="hidden" name="customerTotalPaid" value="<?=$row->customerTotalPaid;?>" />
<input type="hidden" name="commissionPercentage" value="<?=$row->commissionPercentage;?>" />

<td colspan="6">
	<table border="0" align="left" width="100%">
	<tr>
	<td>
	Charge purpose:<br />
	<select name="chargePurpose">
	<option value="Electricity">Electricity</option>
	<option value="Gas">Gas</option>
	<option value="Heating">Heating</option>
	<option value="Fuel">Fuel</option>
	<option value="">High Chair</option>
	<option value="Cot">Cot</option>
	<option value="Parking">Parking</option>
	<option value="Internet">Internet</option>
	<option value="Shopping">Shopping</option>
	<option value="Extra Night">Extra Night</option>
	<option value="Taxi">Taxi</option>
	<option value="Cleaning">Cleaning</option>
	<option value="Extra Bed">Extra Bed</option>
	<option value="Babysitter">Babysitter</option>
	<option value="">Miscellaneous</option>
	</select>
	</td>
	<td>
	Charge amount:<br />
	&euro;<input type="text" size="8" name="chargeAmount" value="" />
	</td>
	<td align="right"><input type="submit" name="trans" value="Add charge" /></td>
	</tr>
	</table>
</td>
</form>
</tr>


<!-- Personal data -->
<tr>
  <?=form_open('booking/update_booking');?>
  <input type="hidden" name="bookingNumber" value="<?=$row->bookingNumber;?>" />
  <input type="hidden" name="bookingStatus" value="<?=$row->bookingStatus;?>" />
  <input type="hidden" name="bookingDiscount" value="<?=$row->bookingDiscount;?>" />
  <input type="hidden" name="alternatives" value="<?=$row->alternatives;?>" />
  <input type="hidden" name="accommCost" value="<?=$row->accommCost;?>" />
  <input type="hidden" name="customerPrice" value="<?=$totPayments;?>" />
  <input type="hidden" name="customerTotalCharges" value="<?=$totCharges;?>" />
  <input type="hidden" name="customerTotalPaid" value="<?php echo $totPayments;?>" />
  <input type="hidden" name="customerBalance" value="<?=$row->customerBalance;?>" />
  <input type="hidden" name="customerNumber" value="<?= $row->customer_number;?>" />
  <input type="hidden" name="customerCountry" value="<?=$row->customer_country;?>" />
<td class="avail_mainhead" valign="top" colspan="6">Personal Data</td>
</tr>

<tr>
<td class="normal" valign="top" colspan="2">
Name<br />
<input type="text" size="10" name="customerName" value="<?=$row->customer_name ; ?>" /><input type="text" size="10" name="customerSurname" value="<?=$row->customer_surname ; ?>" /><br />
Company<br />
<input name="companyName" value="<?=$row->companyName;?>" size="25" readonly="true" />
</td>
<td class="normal" valign="top" colspan="2">
Phone<br />
<input type="text" size="15" name="customerLandphone" value="<?=$row->customer_landphone;?>" /><br />
Mobile<br />
<input type="text" size="15" name="customerMobile" value="<?=$row->customer_mobile;?>" />
</td>
<td class="normal" valign="top" colspan="2"><a href="mailto:<?= $row->customer_email;?>"><u>Email</u></a><br /><input type="text" size="35" name="customerEmail" value="<?=$row->customer_email;?>" />
</td>
</tr>

<tr>
<td class="normal" valign="top" colspan="2">Address<br /><textarea name="customerAddress" rows="6" cols="35"><?=$row->customer_address;?></textarea></td>
<td class="normal" valign="top" colspan="2">Notes<br /><textarea name="customerSpecials" rows="6" cols="35"><?=$row->customerSpecials;?></textarea></td>
<td class="normal" valign="top" colspan="2">Properties<br /><textarea name="propertyList" rows="6" cols="30"><?=$row->propertyList;?></textarea></td>
</tr>

<tr>
<td class="wtback" valign="top" colspan="6">&nbsp;</td>
</tr>

<!-- Property and arrival -->
<tr>
<td class="avail_mainhead" valign="top" colspan="6">Property and Arrival</td>
</tr>

<tr>
<td class="normal" valign="top">Arr.Date</td>
<td class="normal" valign="top"><input name="fromDate" value="<?=$displayArrivalDate?>" readonly="true" /></td>
<td class="normal" valign="top">Arr.Time</td>
<td class="normal" valign="top"><input type="text" size="15" name="fromTime" value="<?=$row->fromTime; ?>" /></td>
<td class="normal" valign="top">Adults</td>
<td class="normal" valign="top"><input type="text" size="15" name="adults" value="<?=$row->adults; ?>" /></td>
</tr>

<tr>
<td class="normal" valign="top">Dep.Date</td>
<td class="normal" valign="top"><input name="toDate" value="<?=$displayDepartureDate?>" readonly="true" />
</td>
<td class="normal" valign="top">Dep.Time</td>
<td class="normal" valign="top"><input type="text" size="15" name="toTime" value="<?=$row->toTime; ?>" /></td>
<td class="normal" valign="top">Children</td>
<td class="normal" valign="top"><input type="text" size="15" name="children" value="<?=$row->children;?>" /></td>
</tr>

<tr>
<td class="normal" valign="top">Nights</td>
<td class="normal" valign="top"><input type="text" size="15" name="customerNights" value="<?=$row->customerNights;?>" /></td>
<td class="normal" colspan="2">&nbsp;</td>
<td class="normal" valign="top">Infants</td>
<td class="normal" valign="top"><input type="text" size="15" name="infants" value="<?=$row->infants;?>" /></td>
</tr>


<tr>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" valign="top">&nbsp;</td>
</tr>

<tr>
<td class="normal" valign="top">Property</td>
<td class="normal" valign="top">
<input type="text" name="Property" value="<?=$this->property_model->get_property_name_by_code($row->propertyCode);?>" size="45" readonly="true" />
</td>
<td class="normal">&nbsp;</td>
<td class="normal" valign="top">
	Cot?<br />
	No<input type="radio" name="cot" value="no" <? if ($row->bookingsCot=="no"){echo " checked";}?> />
	Yes<input type="radio" name="cot" value="yes" <? if ($row->bookingsCot=="yes"){echo " checked";}?> /></td>
<td class="normal" valign="top">
	High chair?<br />
	No <input type="radio" name="highchair" value="no" <? if ($row->bookingsHighchair=="no"){echo " checked";}?> />
	Yes<input type="radio" name="highchair" value="yes" <? if ($row->bookingsHighchair=="yes"){echo " checked";}?> />
</td>
</tr>

<tr>
<td class="wtback" valign="top" colspan="6">&nbsp;</td>
</tr>

<tr>
<td class="avail_mainhead" valign="top" colspan="6">Statement</td>
</tr>


<tr>
<td class="normal" valign="top" colspan="6"></td>
</tr>

<tr>
<td class="6" colspan="6"><hr class="dotted" width="100%" />
	<table border="0" width="100%">
	<tr>
	<td class="normal" valign="top">
		<strong>Accommodation breakdown</strong><br />
	</td>
	<td>Amount</td>
	</tr>
	<tr>
	<td class="hilite">
		<input type="hidden" size="15" name="cost" value="<?=$row->accommCost; ?>" />
		<input type="hidden" size="15" name="bookingDiscount" value="<?=$row->bookingDiscount; ?>" />
		<input type="hidden" size="8" name="bookingFee" value="<?=$row->bookingFee; ?>" />
		<input type="hidden" name="bookingSubTotal" value="<?=$row->customerPrice;?>" />
		&euro;<?=$row->accommCost; ?> <span style="font-size:large;">+</span> booking fee of &euro;<?=$row->bookingFee; ?> <span style="font-size:large;">&#8722;</span> discount of &euro;<?=$row->bookingDiscount;?>
		</td>  
	</td>
	<td class="hilite" valign="top" width="100" align="right">
		<?php printf("%.2f",$row->accommCost + $row->bookingFee - $row->bookingDiscount); ?>		
	</td>
	</tr>
	</table>
</td>
</tr>

<!-- Transactions output begin -->

<!-- Charges list -->
<tr>
<td colspan="6">
<?= $chargesOutput; ?>
</td>
</tr>

<!-- Payments list -->
<tr>
<td colspan="6">
<?= $paymentsOutput; ?>
</td>
</tr>

</td></tr>
<tr><td colspan="6"><hr class="dotted" width="100%" /></td></tr>
<!-- Transactions output end -->

<!-- Transactions total -->
<tr>
<td colspan="6">
<table align="right" border="0">
<tr><td align="right">Total customer price (accommodation + extras):</td><td class="hilite" align="right"><?php printf("%.2f",$row->customerPrice); ?></td></tr>
<tr><td align="right">Total paid:</td><td class="lowlite" width="100" align="right"><?=$row->customerTotalPaid;?></td></tr>
<tr><td align="right"><strong>Balance due:</strong></td><td class="hilite" width="100" align="right">&euro;<?php printf("%.2f",$row->customerBalance);?></td></tr>
<tr><td colspan="2" align="right"><hr class="dotted" width="100%" /></td></tr>
</table>
</td>
</tr>

<tr>
<td class="avail_mainhead" valign="top" colspan="6">Account Totals and comments</td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" class="normal" valign="top" colspan="2">Commissionable cost &nbsp;&nbsp; </td>
<td class="normal" valign="top"><input type="text" size="15" name="commissionableCost" value="<?php printf("%.2f",$row->commissionableCost);?>" readonly="true" /></td>
</tr>


<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" class="normal" valign="top" colspan="2">Commission % &nbsp;&nbsp; </td>
<td class="normal" valign="top">
  <select name="commissionPercentage">
  <option value="<?=$row->commissionPercentage; ?>" selected="yes"><?=$row->commissionPercentage; ?></option>
	<?=$commissionCombo;?>
  </select>
</td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" class="normal" valign="top" colspan="2">Commission Amount &nbsp;&nbsp; </td>
<td class="normal" valign="top"><input type="text" size="15" name="commissionAmount" value="<?php printf("%.2f",$row->commissionAmount);?>" readonly="true" /></td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" class="normal" valign="top" colspan="2">Booking Fee &nbsp;&nbsp; </td>
<td class="normal" valign="top"><input type="text" size="15" name="bookingFee" value="<?=$row->bookingFee; ?>" /></td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" valign="top" colspan="2">IAH due &nbsp;&nbsp; </td>
<td class="normal" valign="top"><input type="text" size="15" name="agentFee" value="<?php printf("%.2f",$row->agentFee);?>" readonly="true" /></td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" valign="top" colspan="2">Owner due &nbsp;&nbsp; </td>
<td class="normal" valign="top"><input type="text" size="15" name="ownerBalance" value="<?php printf("%.2f",$row->ownerBalance); ?>" readonly="true" /></td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" valign="top" colspan="2">Owner Paid? &nbsp;&nbsp; </td>
<td class="normal" valign="top">
No: <input type="radio" name="ownerPaid" value="no" <?php if($row->ownerPaid == 'no'){echo 'checked';} ?> />
Yes: <input type="radio" name="ownerPaid" value="yes" <?php if($row->ownerPaid == 'yes'){echo 'checked';} ?> />
</td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" class="normal" valign="top" colspan="2">Owner paid date &nbsp;&nbsp; </td>
<td class="normal" valign="top">
	<script>DateInput('ownerPaidDate', true, 'YYYY-MM-DD', '<?=$displayOwnerPaidDate;?>')</script>
</td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" valign="top" colspan="2">Booking Reference &nbsp;&nbsp; </td>
<td class="normal" valign="top"><input type="text" size="15" name="ownerReference" value="<?=$row->ownerReference; ?>"></td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" valign="top" colspan="2">Payment method &nbsp;&nbsp; </td>
<td class="normal" valign="top">
  <select name="ownerPaymentMethod">
  <option value="<?=$row->ownerPaymentMethod; ?>" selected="yes"><?=$row->ownerPaymentMethod; ?>
  <option value="Internet Banking">Internet Banking</option>
  <option value="Credit Card">Credit Card</option>
  <option value="Cheque">Cheque</option>
  <option value="Cash">Cash</option>
  <option value="PayPal">PayPal</option>
  </select>
</td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" valign="top" colspan="2">Referral &nbsp;&nbsp; </td>
<td class="normal" valign="top">
  <select name="customerReferral">
	<?=$referralCombo;?>
  </select>
</td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" class="normal" valign="top" colspan="2">Repeat Business? &nbsp;&nbsp; </td>
<td class="normal" valign="top">
  <select name="repeatBusiness">
  <option value="<?=$row->repeatBusiness; ?>" selected="yes"><?=$row->repeatBusiness; ?></option>
        <option value="no">No</option>
        <option value="yes">Yes</option>
  </select>
</td>
</tr>

<!-- Who belongs to sale? -->
<tr>
    <td class="normal" valign="top"></td>
    <td class="normal" valign="top"></td>
    <td class="normal" valign="top"></td>
    <td align="right" class="normal" class="normal" valign="top" colspan="2">Agent &nbsp;&nbsp; </td>
    <td class="normal" valign="top"><strong><?= $row->adminInit; ?></strong></td>
  </tr>

<!-- Cancellation button -->
  <tr>
    <td class="normal" valign="top"></td>
    <td class="normal" valign="top"></td>
    <td class="normal" valign="top"></td>
    <td align="right" class="normal" valign="top" colspan="2">CANCEL THIS SALE &nbsp;&nbsp;</td>
    <td class="normal" valign="top"><input type="checkbox" name="cancelStatus" value="CANCELLED" /></td>
  </tr>
<tr>
<td class="normal" valign="top" align="center" colspan="6">&nbsp;<input type="submit" name="sale_update" value="Update Booking" /><p>&nbsp;</p></td>
</form>

</tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<!-- Booking record end -->

<?php endforeach; ?>
</div>

