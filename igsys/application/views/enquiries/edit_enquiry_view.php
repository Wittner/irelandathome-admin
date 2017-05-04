<?php foreach($query->result() as $row): ?>
<?
// Fix up dates for display
$displayFromDate = $this->global_model->toDisplayDate($row->customer_from);
$displayToDate = $this->global_model->toDisplayDate($row->depart_date);
$displayEnquiryDate = $row->detail_date;
$customerName = $row->customer_name;
$customerLandphone = $row->customer_landphone;
$customerMobile = $row->customer_mobile;
$customerEmail = $row->customer_email;
$propertyList = $row->property_list;
$adults = $row->customer_group;
$customerNights = $row->customer_nights;
$companyCombo = $this->company_model->get_company_combo('');
$countryCombo = $this->global_model->get_country_combo($row->customer_country);
$propertyCombo = $this->property_model->get_property_combo('');
$referralCombo = $this->global_model->get_referral_combo($row->customer_referral);
?>

<div id="delivery">

<table border="0" width="100%" align="center" cellpadding="2" cellspacing="0" bgcolor="#E6F7FF">
<tr>

<? $attributes = array('name' => 'edit_enquiry_view', 'id' => 'edit_enquiry_view');?>
<?= form_open('sales/create_sale',$attributes);?>
<input type="hidden" name="enquiryId" value="<?=$row->detail_id;?>" />
<input type="hidden" name="fromDate" value="<?=$row->customer_from;?>" />
<input type="hidden" name="enquiryDate" value="<?=$displayEnquiryDate;?>" />
<td class="avail_mainhead" valign="top" colspan="6">Section 1 -&nbsp;Personal Data</td>
</tr>

<tr>
<td class="normal" valign="top" colspan="2">
Name<br />
<input type="text" size="10" name="customerName" value="<?=$customerName ;?>" size="20" /><input type="text" size="25" name="customerSurname" size="35" value="<?php echo @$this->validation->customerSurname;?>" /><br />
Company<br />
<select name="customerCompanyId">
<option value="0">n/a</option>
<?=$companyCombo;?>
<select>

</td>
<td class="normal" valign="top" colspan="2">
Phone<br /><input type="text" size="15" name="customerLandphone" value="<?=$customerLandphone; ?><?php echo @$this->validation->customerLandphone;?>" /><br />
Mobile<br /><input type="text" size="15" name="customerMobile" value="<?=$customerMobile;?><?php echo @$this->validation->customerMobile;?>" />
</td>
<td class="normal" valign="top" colspan="2"><a href="mailto:<?=$customerEmail;?>"><u>Email</u></a><?php echo @$this->validation->customerEmail_error;?><br />
<input type="text" size="35" name="customerEmail" value="<?=$customerEmail ;?><?php echo @$this->validation->customerEmail;?>" />
</td>
</tr>

<tr>
<td class="normal" valign="top" colspan="2">Address<br /><textarea name="customerAddress" rows="6" cols="35"><?php echo @$this->validation->customerAddress;?></textarea></td>
<td class="normal" valign="top" colspan="2">Country<br />
	<select name="customerCountry">
		<?=$countryCombo;?>
	</select>
<br />
Referral<br />
<select name="customerReferral">
<option value="none">No referral selected</option>
<?=$referralCombo;?>
</select>
</td>
<td class="normal" valign="top" colspan="2">Properties<br /><textarea name="propertyList" rows="10" cols="40"><?=$propertyList;?><?php echo @$this->validation->propertyList;?></textarea></td>
</tr>

<tr>
<td class="wtback" valign="top" colspan="6">&nbsp;</td>
</tr>

<tr>
<td class="avail_mainhead" valign="top" colspan="6">Section 2 - Property and Arrival</td>
</tr>

<tr>
<td class="normal" valign="top">Arr.Date</td>
<td class="normal" valign="top"><input type="text" name="fromDate" readonly="true" value="<?=$displayFromDate?>" /></td>
<td class="normal" valign="top">Arr.Time</td>
<td class="normal" valign="top"><input type="text" size="15" name="fromTime" value="2pm" /></td>
<td class="normal" valign="top">Adults<?php echo @$this->validation->adults_error;?></td>
<td class="normal" valign="top"><input type="text" size="15" name="adults" value="<?=$adults;?>" /></td>
</tr>

<tr>
<td class="normal" valign="top">Nights</td>
<td class="normal" valign="top"><input type="text" size="15" name="customerNights" readonly="true" value="<?=$customerNights;?>" /></td>
<td class="normal" valign="top">Dep.Time</td>
<td class="normal" valign="top"><input type="text" size="15" name="toTime" value="11am" /></td>
<td class="normal" valign="top">Children<?php echo @$this->validation->children_error;?></td>
<td class="normal" valign="top"><input type="text" size="15" name="children" value="<?=$row->customer_children;?>" /></td>
</tr>

<tr>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" colspan="2">&nbsp;</td>
<td class="normal" valign="top">Infants<?php echo @$this->validation->infants_error;?></td>
<td class="normal" valign="top"><input type="text" size="15" name="infants" value="<?=$row->customer_infants;?>" /></td>
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
<td class="normal" valign="top">Cot?<br />No<input type="radio" name="cot" value="no" <?php if($row->cot == 'no'){ echo ' checked';};?><?php echo @$this->validation->set_radio('cot', 'no'); ?> />Yes<input type="radio" name="cot" value="yes" <?php if($row->cot == 'yes'){ echo ' checked';};?> <?php echo @$this->validation->set_radio('cot', 'yes'); ?> /></td>
<td class="normal" valign="top">High chair?<br />No<input type="radio" name="highchair" value="no" <?php echo @$this->validation->set_radio('highchair', 'no'); ?>/>Yes<input type="radio" name="highchair" value="yes"  <?php echo @$this->validation->set_radio('highchair', 'yes'); ?>/></td>
</tr>

<tr>
<td class="normal" valign="top">Notes</td>
<td class="normal" colspan="2" valign="top"><textarea name="specials" rows="6" cols="35"><?=$row->customer_specials;?></textarea></td>
<td class="normal" colspan="3" valign="top">&nbsp;</td>
</tr>

<tr>

<td class="avail_mainhead" valign="top" colspan="6">Section 3 - Action</td>
</tr>

<tr>
<td class="normal" colspan="5" align="right">
<input type="submit" name="proceed" value="Create sale" />
</td>
</form>
<? $attributes = array('name' => 'goBack', 'id' => 'goBack', 'style' => 'display:inline;');?>
<?= form_open('index.php',$attributes);?>
<td class="normal" colspan="5" align="right">
<input type="hidden" name="specials" value="<?=$row->customer_specials;?>"/>
<input type="submit" name="proceed" value="Return to list" />
</form>
</td>

</tr>



<tr>
<td class="wtback" valign="top" colspan="6">&nbsp;</td>
</tr>

</table>
<?php endforeach; ?>
</div>