<?php foreach($query->result() as $row): ?>

<?php
$companyCombo  = $this->company_model->get_company_combo($row->customerCompanyId);
$countryCombo = $this->global_model->get_country_combo($row->customer_country);
$referralCombo = $this->global_model->get_referral_combo($row->customer_referral);
?>

<div id="delivery">
<? echo $row->customer_number;?>
<table border="0" width="100%" align="center" cellpadding="2" cellspacing="0" bgcolor="#E6F7FF">
<tr>

<? $attributes = array('name' => 'create_manual_sale_view', 'id' => 'create_manual_sale_view');?>
<?= form_open('customers/update_customer',$attributes);?>
<?= form_hidden('customerNumber', $row->customer_number );?>
<td class="avail_mainhead" valign="top" colspan="6">Section 1 -&nbsp;Personal Data</td>
</tr>

<tr>
<td class="normal" valign="top" colspan="2">
Name<br />
<input type="text" size="10" name="customerName" value="<?=$row->customer_name;?>" size="20" /><input type="text" size="25" name="customerSurname" size="35" value="<?= $row->customer_surname;?>" /><br />
Company<br />
<select name="customerCompanyId">
<option value="0">n/a</option>
<?=$companyCombo;?>
<select>

</td>
<td class="normal" valign="top" colspan="2">
Phone<br /><input type="text" size="15" name="customerLandphone" value="<?=$row->customer_landphone;?>" /><br />
Mobile<br /><input type="text" size="15" name="customerMobile" value="<?=$row->customer_mobile;?>" />
</td>
<td class="normal" valign="top" colspan="2"><a href="mailto:<?=$row->customer_email;?>"><u>Email</u></a><br />
<input type="text" size="35" name="customerEmail" value="<?=$row->customer_email;?>" />
</td>
</tr>

<tr>
<td class="normal" valign="top" colspan="2">Address<br /><textarea name="customerAddress" rows="6" cols="35"><?=$row->customer_address;?></textarea></td>
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
<input type="submit" name="proceed" value="Update" />
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
<?php endforeach; ?>