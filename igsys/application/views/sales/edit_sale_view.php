<?php foreach($query->result() as $row): ?>
<?
$offerSentDate = $row->offerSentDate;
if($offerSentDate != '' && $offerSentDate != '0000-00-00'){$displayOfferSentDate = $this->global_model->toDisplayDate($offerSentDate);}
$customerName = $row->customer_name;
$customerSurname = $row->customer_surname;
$customerAddress = $row->customer_address;
$customerLandphone = $row->customer_landphone;
$customerMobile = $row->customer_mobile;
$customerEmail = $row->customer_email;
$propertyList = $row->propertyList;
$adults = $row->adults;
$customerNights = $row->customerNights;
$customerSpecials = $row->customerSpecials;
$accommCost = $row->accommCost;
$bookingFee = $row->bookingFee;
$customerTotalPaid = $row->customerTotalPaid;
$rx_reference = $row->rx_reference;
?>

<div id="delivery">

<table border="0" width="100%" align="center" cellpadding="2" cellspacing="0" bgcolor="#E6F7FF">

<tr>
	<td colspan="6" class="avail_mainhead">GENERATE AN EMAIL OFFER <?php if($offerSentDate != '' && $offerSentDate != '0000-00-00'){echo '(Last offer sent ' . $displayOfferSentDate . ')';};?></td>
</tr>

<tr>
	<td colspan="6">
	<table width="100%">
	<?= form_open('sales/add_offer');?>
	<input type="hidden" name="offerSaleId" value="<?=$saleId;?>" />
	<tr>
		<th>Property:<?=$row->adults;?></th>
		<th>From:</th>
		<th>To:</th>
		<th>Qty:</th>
		<th>Price:</th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><select name="offerPropertyCode"><?=$unselectedPropertyCombo;?></select></td>
		<td><script>DateInput('offerFromDate', true, 'YYYY-MM-DD')</script></td>
		<td><script>DateInput('offerToDate', true, 'YYYY-MM-DD')</script></td>
		<td><select name="quantity">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
			</select></td>
		<td><input name="offerPrice" type="text" /></td>
		<td><input name="submit" type="submit" value="Add to offer" /></td>
	</tr>
	</table>
	</td>
</tr>

<tr>
	<td colspan="6">
	<?php if($offerList != ''){echo $offerList;}?>
	</td>
</tr>
</form>

<tr>
	<td colspan="6" align="right">
	<?= form_open('sales/send_offer');?>
	<input type="hidden" name="saleId" value="<?=$saleId;?>" />
	<input type="submit" name="submit" value="Send this offer now" />
	</form>
	</td>
</tr>

<tr>
	<? $attributes = array('name' => 'edit_enquiry_view', 'id' => 'edit_enquiry_view');?>
	<?= form_open('sales/update_sale',$attributes);?>
	<input type="hidden" name="saleId" value="<?=$saleId;?>" />
	<input type="hidden" name="customerNumber" value="<?=$row->customerNumber;?>" />
	<td class="avail_mainhead" valign="top" colspan="6">Section 1 -&nbsp;Personal Data</td>
</tr>

<tr>
<td class="normal" valign="top" colspan="2">
Name<br />
<input type="text" size="10" name="customerName" value="<?=$row->customer_name ;?>" size="20" /><input type="text" size="25" name="customerSurname" size="35" value="<?=$row->customer_surname;?>" /><br />
Company<br />
<select name="customerCompanyId">
<option value="0">N/A</option>
<?= $companyCombo; ?>
</select>
</td>
<td class="normal" valign="top" colspan="2">
Phone<br /><input type="text" size="15" name="customerLandphone" value="<?=$row->customer_landphone; ?><?php echo @$this->validation->customerLandphone;?>" /><br />
Mobile<br /><input type="text" size="15" name="customerMobile" value="<?=$row->customer_mobile;?><?php echo @$this->validation->customerMobile;?>" />
</td>
<td class="normal" valign="top" colspan="2"><a href="mailto:<?=$row->customer_email;?>"><u>Email</u></a><?php echo @$this->validation->customerEmail_error;?><br />
<input type="text" size="35" name="customerEmail" value="<?=$row->customer_email ;?><?php echo @$this->validation->customerEmail;?>" />
</td>
</tr>

<tr>
<td class="normal" valign="top" colspan="2">Address<br /><textarea name="customerAddress" rows="6" cols="35"><?=$row->customer_address;?></textarea></td>
<td class="normal" valign="top" colspan="2">Country<br />
<select name="customerCountry">
<?=$countryCombo;?>
</select>
<br />
Referral<br />
<select name="customerReferral">
<?=$referralCombo;?>
</select>
</td>
<td class="normal" valign="top" colspan="2">Properties<br /><textarea name="propertyList" rows="6" cols="30"><?=$row->propertyList;?><?php echo @$this->validation->propertyList;?></textarea></td>
</tr>

<tr>
<td class="wtback" valign="top" colspan="6">&nbsp;</td>
</tr>

<tr>
<td class="avail_mainhead" valign="top" colspan="6">Section 2 - Property and Arrival</td>
</tr>

<tr>
<td class="normal" valign="top">Arr.Date</td>
<td class="normal" valign="top"><script>DateInput('fromDate', true, 'YYYY-MM-DD', '<?=$row->fromDate;?>')</script></td>
<td class="normal" valign="top">Arr.Time</td>
<td class="normal" valign="top"><input class="timepicker" type="text" size="15" name="fromTime" value="<?=$row->fromTime;?>" style="width: 100px;" /></td>
<td class="normal" valign="top">Adults<?php echo @$this->validation->adults_error;?></td>
<td class="normal" valign="top"><input type="text" size="15" name="adults" value="<?=$row->adults;?>" /></td>
</tr>

<tr>
<td class="normal" valign="top">Nights</td>
<td class="normal" valign="top"><input type="text" size="15" name="customerNights" value="<?=$row->customerNights;?>" /></td>
<td class="normal" valign="top">Dep.Time</td>
<td class="normal" valign="top"><input class="timepicker" type="text" size="15" name="toTime" value="<?=$row->toTime;?>" style="width: 100px;" /></td>
<td class="normal" valign="top">Children</td>
<td class="normal" valign="top"><input type="text" size="15" name="children" value="<?=$row->children ; ?>" /></td>
</tr>

<tr>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" colspan="2">&nbsp;</td>
<td class="normal" valign="top">Infants<?php echo @$this->validation->infants_error;?></td>
<td class="normal" valign="top"><input type="text" size="15" name="infants" value="<?=$row->infants;?><?php echo @$this->validation->infants;?>" /></td>
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
<select name="propertyCode">
<?= $propertyCombo; ?>
</select>
</td>
<td class="normal">&nbsp;</td>
<td class="normal" valign="top">
Cot?<br />
No<input type="radio" name="cot" value="no" <?php if($row->salesCot!='yes'){echo 'checked';} ?> />
Yes<input type="radio" name="cot" value="yes" <?php if($row->salesCot=='yes'){echo 'checked';} ?> /></td>
<td class="normal" valign="top">
High chair?<br />
No<input type="radio" name="highchair" value="no" <?php if($row->salesHighchair!='yes'){echo 'checked';} ?>/>
Yes<input type="radio" name="highchair" value="yes"  <?php if($row->salesHighchair=='yes'){echo 'checked';} ?>/></td>
</tr>

<tr>
<td class="normal" valign="top">Notes</td>
<td class="normal" colspan="2" valign="top"><textarea name="specials" rows="6" cols="35"><?=$customerSpecials;?></textarea></td>
<td class="normal" colspan="3" valign="top">&nbsp;</td>
</tr>

<tr>

<td class="avail_mainhead" valign="top" colspan="6">Section 3 - Price</td>
</tr>

<tr>
<td class="normal" colspan="6" align="right">
<table border="0">
<tr>
 <td align="right">Accommodation Charge:<?php echo @$this->validation->cost_error;?></td>
 <td>&euro;<input type="text" size="8" name="accommCost" value="<?=$accommCost;?><?php echo @$this->validation->accommCost;?>" /></td>
</tr>
<tr>
 <td align="right">Booking fee:</td>
 <td>&euro;<input type="text" size="8" name="bookingFee" value="<?=$bookingFee;?><?php echo @$this->validation->bookingFee;?>" /></td>
</tr>
<tr>
 <td align="right">Owner Commission:</td>
 <td>
  <select name="commissionPercentage">
	  <option value="<?=$row->commissionPercentage; ?>" selected="yes"><?=$row->commissionPercentage; ?></option>
		<?=$commissionCombo;?>
  </select>
 </td>
</tr>
<tr>
 <td align="right">Discount<b></b><?php echo @$this->validation->bookingDiscount;?></td>
 <td>&euro;<input type="text" size="8" name="bookingDiscount" value="" /></td>
</tr>
<tr>
 <td align="right">Extras (description)<b></b></td>
 <td><input type="text" size="25" name="chargePurpose" value="<?php echo @$this->validation->bookingExtras;?>" /></td>
</tr>
<tr>
 <td align="right">Extras (amount)<b></b></td>
 <td>&euro;<input type="text" size="8" name="chargeAmount" value="" /></td>
</tr>
<tr>
<input type="hidden" name="paymentPurpose" value="Booking payment" />
 <td align="right">Initial payment method:</td>
 <td><select name="paymentMethod">
	<option value="Credit card">Credit card</option>
	<option value="Laser card">Laser</option>
	<option value="Cheque">Cheque</option>
	<option value="Cash">Cash</option>
	<option value="PayPal">PayPal</option>
	</select>
 </td>
</tr>

<tr>
 <td align="right">Initial payment amount:<?php echo @$this->validation->paymentAmount_error;?></td>
 <td>&euro;<input type="text" size="8" name="paymentAmount" value="<?=$customerTotalPaid;?>" /></td>
</tr>
<tr>
 <td align="right">Payment reference:<?php echo @$this->validation->paymentRef_error;?></td>
 <td><input type="text" name="paymentRef" size="25" value="<?=$rx_reference;?>"/></td>
</tr>
<tr>
 <td>&nbsp;</td>
 <td><input type="submit" name="update" value="Update sale" />
	 <input type="submit" name="update" value="Convert to Booking" />
	 </form>
 </td>
</tr>
	</table>
</td>
</tr>

<tr>
<td class="wtback" valign="top" colspan="6">&nbsp;</td>
</tr>

</table>
<?php endforeach; ?>
<script type="text/javascript">
$('.timepicker').timepicker({
	timeFormat: 'H:mm',
	interval: 30,
	minTime: '01:00',
	maxTime: '23:00pm',
	startTime: '01:00',
	dynamic: false,
	dropdown: true,
	scrollbar: true
});
</script>
</div>
