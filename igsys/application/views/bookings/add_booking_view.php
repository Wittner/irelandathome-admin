<?
// Fix up dates for display
$displayFromDate = $this->global_model->toDisplayDate($fromDate);
$displayToDate = $this->global_model->toDisplayDate($toDate);
?>

<div id="delivery">

<table border="0" width="100%" align="center" cellpadding="2" cellspacing="0" bgcolor="#E6F7FF">
<tr>
<? $attributes = array('name' => 'new_booking_form', 'id' => 'new_booking_form');?>
<?=form_open('booking/make_booking',$attributes);?>
<input type="hidden" name="propertyCode" value="<?=$propertyCode;?>" />
<input type="hidden" name="fromDate" value="<?=$fromDate;?>" />
<input type="hidden" name="toDate" value="<?=$toDate;?>" />
<td class="avail_mainhead" valign="top" colspan="6">Section 1 -&nbsp;Personal Data</td>
</tr>

<tr>
<td class="normal" valign="top" colspan="2">
Name<?php echo @$this->validation->customerName_error;?><?php echo @$this->validation->customerSurname_error;?><br />
<input type="text" size="10" name="customerName" value="<?php echo @$this->validation->customerName;?>" size="20" /><input type="text" size="25" name="customerSurname" size="35" value="<?php echo @$this->validation->customerSurname;?>" /><br />
Company<br />
<select name="customerCompanyId">
	<option value="none" <?=$this->validation->set_select('companyId', '$row->companyId');?>>n/a</option>
<?=$companyCombo;?>
<select>

</td>
<td class="normal" valign="top" colspan="2">
Phone<br /><input type="text" size="15" name="customerLandphone" value="<?php echo @$this->validation->customerLandphone;?>" /><br />
Mobile<br /><input type="text" size="15" name="customerMobile" value="<?php echo @$this->validation->customerMobile;?>" />
</td>
<td class="normal" valign="top" colspan="2">Email<?php echo @$this->validation->customerEmail_error;?><br />
<input type="text" size="35" name="customerEmail" value="<?php echo @$this->validation->customerEmail;?>" />
</td>
</tr>

<tr>
<td class="normal" valign="top" colspan="2">Address<br /><textarea name="customerAddress" rows="6" cols="35"><?php echo @$this->validation->customerAddress;?></textarea></td>
<td class="normal" valign="top" colspan="2">Country<br />
	<select name="customerCountry">
	<option value="" <?php echo @$this->validation->set_select('customerCountry', ''); ?>>Pick a country</option>
	<option value="1" <?php echo @$this->validation->set_select('customerCountry', '1'); ?>>Ireland</option>

	<option value="2" <?php echo @$this->validation->set_select('customerCountry', '2'); ?>>The United Kingdom</option>
	<option value="3" <?php echo @$this->validation->set_select('customerCountry', '3'); ?>>The USA</option>
	<option value="67" <?php echo @$this->validation->set_select('customerCountry', '67'); ?>>Africa</option>
	<option value="31" <?php echo @$this->validation->set_select('customerCountry', '31'); ?>>Argentina</option>
	<option value="5" <?php echo @$this->validation->set_select('customerCountry', '5'); ?>>Australia</option>
	<option value="17" <?php echo @$this->validation->set_select('customerCountry', '17'); ?>>Austria</option>
	<option value="48" <?php echo @$this->validation->set_select('customerCountry', '48'); ?>>Austrialia</option>
	<option value="4" <?php echo @$this->validation->set_select('customerCountry', '4'); ?>>Benelux</option>
	<option value="61" <?php echo @$this->validation->set_select('customerCountry', '61'); ?>>Bolivia</option>

	<option value="58" <?php echo @$this->validation->set_select('customerCountry', '58'); ?>>Brazil</option>
	<option value="62" <?php echo @$this->validation->set_select('customerCountry', '62'); ?>>Bulgaria</option>
	<option value="7" <?php echo @$this->validation->set_select('customerCountry', '7'); ?>>Canada</option>
	<option value="34" <?php echo @$this->validation->set_select('customerCountry', '34'); ?>>Caribbean</option>
	<option value="65" <?php echo @$this->validation->set_select('customerCountry', '65'); ?>>China</option>
	<option value="40" <?php echo @$this->validation->set_select('customerCountry', '40'); ?>>Denmark</option>
	<option value="10" <?php echo @$this->validation->set_select('customerCountry', '10'); ?>>Europe</option>
	<option value="14" <?php echo @$this->validation->set_select('customerCountry', '14'); ?>>Finland</option>
	<option value="8" <?php echo @$this->validation->set_select('customerCountry', '8'); ?>>France</option>

	<option value="6" <?php echo @$this->validation->set_select('customerCountry', '6'); ?>>Germany</option>
	<option value="59" <?php echo @$this->validation->set_select('customerCountry', '59'); ?>>Greece</option>
	<option value="51" <?php echo @$this->validation->set_select('customerCountry', '51'); ?>>Holland</option>
	<option value="20" <?php echo @$this->validation->set_select('customerCountry', '20'); ?>>Hongkong</option>
	<option value="44" <?php echo @$this->validation->set_select('customerCountry', '44'); ?>>India</option>
	<option value="37" <?php echo @$this->validation->set_select('customerCountry', '37'); ?>>Indonesia</option>
	<option value="35" <?php echo @$this->validation->set_select('customerCountry', '35'); ?>>Israel</option>
	<option value="23" <?php echo @$this->validation->set_select('customerCountry', '23'); ?>>Italy</option>
	<option value="21" <?php echo @$this->validation->set_select('customerCountry', '21'); ?>>Japan</option>

	<option value="57" <?php echo @$this->validation->set_select('customerCountry', '57'); ?>>Korea</option>
	<option value="64" <?php echo @$this->validation->set_select('customerCountry', '64'); ?>>Latam</option>
	<option value="63" <?php echo @$this->validation->set_select('customerCountry', '63'); ?>>Latvija</option>
	<option value="30" <?php echo @$this->validation->set_select('customerCountry', '30'); ?>>Luxembourg</option>
	<option value="9" <?php echo @$this->validation->set_select('customerCountry', '9'); ?>>Malaysia</option>
	<option value="38" <?php echo @$this->validation->set_select('customerCountry', '38'); ?>>Mexico</option>
	<option value="56" <?php echo @$this->validation->set_select('customerCountry', '56'); ?>>Middleeast</option>
	<option value="22" <?php echo @$this->validation->set_select('customerCountry', '22'); ?>>New York</option>
	<option value="11" <?php echo @$this->validation->set_select('customerCountry', '11'); ?>>New Zealand</option>

	<option value="36" <?php echo @$this->validation->set_select('customerCountry', '36'); ?>>Norge</option>
	<option value="66" <?php echo @$this->validation->set_select('customerCountry', '66'); ?>>North Africa</option>
	<option value="52" <?php echo @$this->validation->set_select('customerCountry', '52'); ?>>Philippines</option>
	<option value="42" <?php echo @$this->validation->set_select('customerCountry', '42'); ?>>Poland</option>
	<option value="41" <?php echo @$this->validation->set_select('customerCountry', '41'); ?>>Russia</option>
	<option value="27" <?php echo @$this->validation->set_select('customerCountry', '27'); ?>>Saudi Arabia</option>
	<option value="32" <?php echo @$this->validation->set_select('customerCountry', '32'); ?>>Scotland</option>
	<option value="45" <?php echo @$this->validation->set_select('customerCountry', '45'); ?>>Slovakia</option>
	<option value="26" <?php echo @$this->validation->set_select('customerCountry', '26'); ?>>Sngapore</option>

	<option value="12" <?php echo @$this->validation->set_select('customerCountry', '12'); ?>>Southafrica</option>
	<option value="28" <?php echo @$this->validation->set_select('customerCountry', '28'); ?>>Spain</option>
	<option value="19" <?php echo @$this->validation->set_select('customerCountry', '19'); ?>>Sweden</option>
	<option value="13" <?php echo @$this->validation->set_select('customerCountry', '13'); ?>>Switzerland</option>
	<option value="60" <?php echo @$this->validation->set_select('customerCountry', '60'); ?>>Taiwan</option>
	<option value="39" <?php echo @$this->validation->set_select('customerCountry', '39'); ?>>Tenerife</option>
	<option value="50" <?php echo @$this->validation->set_select('customerCountry', '50'); ?>>Thailand</option>
	<option value="24" <?php echo @$this->validation->set_select('customerCountry', '24'); ?>>The Netherlands</option>
	<option value="33" <?php echo @$this->validation->set_select('customerCountry', '33'); ?>>The Ukraine</option>

	<option value="55" <?php echo @$this->validation->set_select('customerCountry', '55'); ?>>Turky</option>
	<option value="29" <?php echo @$this->validation->set_select('customerCountry', '29'); ?>>UAE</option>
	<option value="53" <?php echo @$this->validation->set_select('customerCountry', '53'); ?>>Venezuela</option>
	<option value="47" <?php echo @$this->validation->set_select('customerCountry', '47'); ?>>Vietnam</option>
</select>
<br />
Referral<br />
<select name="customerReferral">
	<option value="No Answer" <?php echo @$this->validation->set_select('customerReferral', 'No Answer'); ?>>No Answer</option>
	<option value = "Repeat customer" <?php echo @$this->validation->set_select('customerReferral', 'Repeat customer'); ?>>Repeat customer</option>
	<option value = "Google" <?php echo @$this->validation->set_select('customerReferral', 'Google'); ?>>Google</option>
	<option value = "Yahoo" <?php echo @$this->validation->set_select('customerReferral', 'Yahoo'); ?>>Yahoo</option>
	<option value = "MSN" <?php echo @$this->validation->set_select('customerReferral', 'MSN'); ?>>MSN</option>
	<option value = "Altavista" <?php echo @$this->validation->set_select('customerReferral', 'Altavista'); ?>>Alta Vista</option>
	<option value = "Overture" <?php echo @$this->validation->set_select('customerReferral', 'Overture'); ?>>Overture</option>
	<option value = "Other search engine" <?php echo @$this->validation->set_select('customerReferral', 'Other search engine'); ?>>Other search engine</option>
	<option value = "Word of mouth" <?php echo @$this->validation->set_select('customerReferral', 'Word of mouth'); ?>>Word of mouth</option>
	<option value = "Country Cottages Magazine" <?php echo @$this->validation->set_select('customerReferral', 'Country Cottages Magazine'); ?>>Country Cottages</option>
	<option value = "Flyer" <?php echo @$this->validation->set_select('customerReferral', 'Flyer'); ?>>TUI Ad</option>
	<option value = "MailFlyer" <?php echo @$this->validation->set_select('customerReferral', 'MailFlyer'); ?>>Mailing Flyer</option>
	<option value = "Advertisement" <?php echo @$this->validation->set_select('customerReferral', 'Advertisement'); ?>>Other Advertisement</option>
	<option value = "Iah" <?php echo @$this->validation->set_select('customerReferral', 'Iah'); ?>>Ireland at Home</option>
	<option value = "Chh" <?php echo @$this->validation->set_select('customerReferral', 'Chh'); ?>>Cork Holiday Homes site</option>
	<option value = "Club" <?php echo @$this->validation->set_select('customerReferral', 'Club'); ?>>Club</option>
	<option value = "Leaflet" <?php echo @$this->validation->set_select('customerReferral', 'Leaflet'); ?>>Leaflet</option>
	<option value = "Advert" <?php echo @$this->validation->set_select('customerReferral', 'Advert'); ?>>Advertisement</option>
	<option value = "Intranet" <?php echo @$this->validation->set_select('customerReferral', 'Intranet'); ?>>Intranet</option>
	<option value = "Other" <?php echo @$this->validation->set_select('customerReferral', 'Other'); ?>>Other</option></select>
</select>
</td>
<td class="normal" valign="top" colspan="2">Properties<br /><textarea name="propertyList" rows="6" cols="30"><?php echo @$this->validation->propertyList;?></textarea></td>
</tr>

<tr>
<td class="wtback" valign="top" colspan="6">&nbsp;</td>
</tr>

<tr>
<td class="avail_mainhead" valign="top" colspan="6">Section 2 - Property and Arrival</td>
</tr>

<tr>
<td class="normal" valign="top">Arr.Date</td>
<td class="normal" valign="top"><input type="text" name="displayFromDate" readonly="true" value="<?=$displayFromDate?>" /></td>
<td class="normal" valign="top">Arr.Time</td>
<td class="normal" valign="top"><input type="text" size="15" name="fromTime" value="2pm" /></td>
<td class="normal" valign="top">Adults<?php echo @$this->validation->adults_error;?></td>
<td class="normal" valign="top"><input type="text" size="15" name="adults" value="<?php echo @$this->validation->party;?>" /></td>
</tr>

<tr>
<td class="normal" valign="top">Dep.Date</td>
<td class="normal" valign="top"><input type="text" name="displayToDate" readonly="true" value="<?=$displayToDate?>" /></td>
<td class="normal" valign="top">Dep.Time</td>
<td class="normal" valign="top"><input type="text" size="15" name="toTime" value="11am" /></td>
<td class="normal" valign="top">Children<?php echo @$this->validation->children_error;?></td>
<td class="normal" valign="top"><input type="text" size="15" name="children" value="<?php echo @$this->validation->children;?>" /></td>
</tr>

<tr>
<td class="normal" valign="top">Nights</td>
<td class="normal" valign="top"><input type="text" size="15" name="customerNights" readonly="true" value="<?=$customerNights;?>" /></td>
<td class="normal" colspan="2">&nbsp;</td>
<td class="normal" valign="top">Infants<?php echo @$this->validation->infants_error;?></td>
<td class="normal" valign="top"><input type="text" size="15" name="infants" value="<?php echo @$this->validation->infants;?>" /></td>
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
<?= $propertyInput; ?>
</td>
<td class="normal">&nbsp;</td>
<td class="normal" valign="top">Cot?<br />No<input type="radio" name="cot" value="no" <?php echo @$this->validation->set_radio('cot', 'no'); ?> />Yes<input type="radio" name="cot" value="yes" <?php echo @$this->validation->set_radio('cot', 'yes'); ?> /></td>
<td class="normal" valign="top">High chair?<br />No<input type="radio" name="highchair" value="no" <?php echo @$this->validation->set_radio('highchair', 'no'); ?>/>Yes<input type="radio" name="highchair" value="yes"  <?php echo @$this->validation->set_radio('highchair', 'yes'); ?>/></td>
</tr>

<tr>
<td class="normal" valign="top">Notes</td>
<td class="normal" colspan="2" valign="top"><textarea name="specials" rows="6" cols="35"><?php echo @$this->validation->specials;?></textarea></td>
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
 <td>&euro;<input type="text" size="8" name="accommCost" value="<?php echo @$this->validation->accommCost;?>" /></td>
</tr>
<tr>
 <td align="right">Booking fee:</td>
 <td>&euro;<input type="text" size="8" name="bookingFee" value="<?php echo @$this->validation->bookingFee;?>" /></td>
</tr>
<tr>
 <td align="right">Owner Commission:</td>
 <td>
  <select name="commissionPercentage">
	  <option value="0">0</option>
	  <option value="5">5</option>
	  <option value="7.5">7.5</option>
	  <option value="10">10</option>
	  <option value="12">12</option>
	  <option value="12.5">12.5</option>
	  <option value="15" selected>15</option>
	  <option value="17.5">17.5</option>
	  <option value="20">20</option>
	  <option value="25">25</option>
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
<input type="hidden" name="paymentPurpose" value="Deposit" />
 <td align="right">Initial payment method:</td>
 <td><select name="paymentMethod">
	<option value="Credit card">Credit card</option>
	<option value="Laser card">Laser</option>
	</select>
 </td>
</tr>

<tr>
 <td align="right">Initial payment amount:<?php echo @$this->validation->paymentAmount_error;?></td>
 <td>&euro;<input type="text" size="8" name="paymentAmount" value="150" /></td>
</tr>
<tr>
 <td align="right">Payment reference:<?php echo @$this->validation->paymentRef_error;?></td>
 <td><input type="text" name="paymentRef" size="25" /></td>
</tr>
<tr>
 <td>&nbsp;</td>
 <td><input type="submit" name="proceed" value="Next" /></td>
</form>
</tr>
	</table>
</td>
</tr>

<tr>
<td class="wtback" valign="top" colspan="6">&nbsp;</td>
</tr>

</table>
</div>