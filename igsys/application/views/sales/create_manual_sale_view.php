<?
// Fix up dates for display
$companyCombo = $this->company_model->get_company_combo('');
$countryCombo = $this->global_model->get_country_combo('');
$propertyCombo = $this->property_model->get_property_combo('');
$referralCombo = $this->global_model->get_referral_combo('');
?>

<div id="delivery">

<table border="0" width="100%" align="center" cellpadding="2" cellspacing="0" bgcolor="#E6F7FF">
<tr>

<? $attributes = array('name' => 'create_manual_sale_view', 'id' => 'create_manual_sale_view');?>
<?= form_open('sales/create_sale',$attributes);?>
<td class="avail_mainhead" valign="top" colspan="6">Section 1 -&nbsp;Personal Data</td>
</tr>

<tr>
<td class="normal" valign="top" colspan="2">
Name<br />
<input type="text" size="10" name="customerName" value="" size="20" /><input type="text" size="25" name="customerSurname" size="35" value="<?php echo @$this->validation->customerSurname;?>" /><br />
Company<br />
<select name="customerCompanyId">
<option value="0">n/a</option>
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
		<?=$countryCombo;?>
	</select>
<br />
Referral<br />
<select name="customerReferral">
<option value="none">No referral selected</option>
<?=$referralCombo;?>
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
<td class="normal" valign="top"><script>DateInput('fromDate', true, 'DD-MM-YYYY')</script></td>
<td class="normal" valign="top">Arr.Time</td>
<td class="normal" valign="top"><input type="text" size="15" name="fromTime" value="2pm" /></td>
<td class="normal" valign="top">Adults<?php echo @$this->validation->adults_error;?></td>
<td class="normal" valign="top"><input type="text" size="15" name="adults" /></td>
</tr>

<tr>
<td class="normal" valign="top">Nights</td>
<td class="normal" valign="top"><input type="text" size="15" name="customerNights" /></td>
<td class="normal" valign="top">Dep.Time</td>
<td class="normal" valign="top"><input type="text" size="15" name="toTime" value="11am" /></td>
<td class="normal" valign="top">Children<?php echo @$this->validation->children_error;?></td>
<td class="normal" valign="top"><input type="text" size="15" name="children" /></td>
</tr>

<tr>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" colspan="2">&nbsp;</td>
<td class="normal" valign="top">Infants<?php echo @$this->validation->infants_error;?></td>
<td class="normal" valign="top"><input type="text" size="15" name="infants" /></td>
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
<td class="normal" valign="top">Cot?<br />No<input type="radio" name="cot" value="no" <?php echo @$this->validation->set_radio('cot', 'no'); ?> />Yes<input type="radio" name="cot" value="yes" <?php echo @$this->validation->set_radio('cot', 'yes'); ?> /></td>
<td class="normal" valign="top">High chair?<br />No<input type="radio" name="highchair" value="no" <?php echo @$this->validation->set_radio('highchair', 'no'); ?>/>Yes<input type="radio" name="highchair" value="yes"  <?php echo @$this->validation->set_radio('highchair', 'yes'); ?>/></td>
</tr>

<tr>
<td class="normal" valign="top">Notes</td>
<td class="normal" colspan="2" valign="top"><textarea name="specials" rows="6" cols="35"><?php echo @$this->validation->specials;?></textarea></td>
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
<input type="submit" name="proceed" value="Cancel" />
</form>
</td>

</tr>



<tr>
<td class="wtback" valign="top" colspan="6">&nbsp;</td>
</tr>

</table>
</div>