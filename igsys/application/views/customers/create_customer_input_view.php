<div id="delivery">

<table border="0" width="100%" align="center" cellpadding="2" cellspacing="0" bgcolor="#E6F7FF">
<tr>

<? $attributes = array('name' => 'create_manual_sale_view', 'id' => 'create_manual_sale_view');?>
<?= form_open('customers/create_customer',$attributes);?>
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
<td class="normal" valign="top" colspan="2">
Country<br />
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
<td class="normal" valign="top" colspan="2">&nbsp;</td>
</tr>

<tr>
<td class="wtback" valign="top" colspan="6">&nbsp;</td>
</tr>


<tr>
<td class="avail_mainhead" valign="top" colspan="6">Section 3 - Action</td>
</tr>

<tr>
<td class="normal" colspan="5" align="right">
<input type="submit" name="proceed" value="Proceed" />
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