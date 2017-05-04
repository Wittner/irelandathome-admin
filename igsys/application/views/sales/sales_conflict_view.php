<div id="delivery">
<div id="warning">WARNING: -> Existing customer data on file</div>
		
<p><strong>Existing data in database</strong></p>
<?php foreach($query->result() as $row): ?>
<table border="0">
<tr>
<td class="mainhead">Item</td>
<td class="mainhead">Data</td>
</tr>
<tr>
<td class="normal">Customer number</td>
<td class="normal"><?=$row->customer_number; ?></td>
</tr>
<tr>
<td class="normal">Email</td>
<td class="normal"><?=$row->customer_email; ?></td>
</tr>
<tr>
<td class="normal">Name</td>
<td class="normal"><?=$row->customer_name; ?> <?=$row->customer_surname; ?></td>
</tr>
<tr>
<td class="normal">Landphone</td>
<td class="normal"><?=$row->customer_landphone; ?></td>
</tr>
<tr>
<td class="normal">Mobile</td>
<td class="normal"><?=$row->customer_mobile; ?></td>
</tr>
<tr>
<td class="normal">Address</td>
<td class="normal"><?=$row->customer_address; ?></td>
</tr>
</table>


<p><strong>New data supplied by customer</strong></p>
<table border="0">
<tr>
<?=form_open('sales/customer_conflict');?>
<br /><br />
<!-- Hidden fields with existing customer data -->
<input type="hidden" name="customerName" value="<?=$row->customer_name; ?>" />
<input type="hidden" name="customerSurname" value="<?=$row->customer_surname; ?>" />
<input type="hidden" name="customerEmail" value="<?=$row->customer_email; ?>" />
<input type="hidden" name="customerCountry" value="<?=$row->customer_country; ?>" />
<input type="hidden" name="customerAddress" value="<?=$row->customer_address; ?>" />
<input type="hidden" name="customerLandphone" value="<?=$row->customer_landphone; ?>" />
<input type="hidden" name="customerMobile" value="<?=$row->customer_mobile; ?>" />
<input type="hidden" name="customerCompanyId" value="<?=$customerCompanyId; ?>" />
<input type="hidden" name="customerReferral" value="<?= $row->customer_referral; ?>" />
<input type="hidden" name="customerNumber" value="<?=$row->customer_number; ?>" />

<!-- Hidden fields with new customer data -->
<input type="hidden" name="newCustomerName" value="<?= $newCustomerName; ?>" />
<input type="hidden" name="newCustomerSurname" value="<?= $newCustomerSurname; ?>" />
<input type="hidden" name="newCustomerCountry" value="<?= $newCustomerCountry; ?>" />
<input type="hidden" name="newCustomerAddress" value="<?= $newCustomerAddress; ?>" />
<input type="hidden" name="newCustomerLandphone" value="<?= $newCustomerLandphone; ?>" />
<input type="hidden" name="newCustomerMobile" value="<?= $newCustomerMobile; ?>" />

<!-- Hidden field with sales data -->
<input type="hidden" name="propertyCode" value="<?= $propertyCode; ?>" />
<input type="hidden" name="fromDate" value="<?= $fromDate; ?>" />
<input type="hidden" name="fromTime" value="<?= $fromTime; ?>" />
<input type="hidden" name="toDate" value="<?= $toDate; ?>" />
<input type="hidden" name="toTime" value="<?= $toTime; ?>" />
<input type="hidden" name="adults" value="<?= $adults; ?>" />
<input type="hidden" name="children" value="<?= $children; ?>" />
<input type="hidden" name="infants" value="<?= $infants; ?>" />
<input type="hidden" name="customerSpecials" value="<?= $specials; ?>" />
<input type="hidden" name="propertyList" value="<?= $propertyList; ?>" />
<input type="hidden" name="referral" value="<?= $newCustomerReferral; ?>" />
<input type="hidden" name="customerNights" value="<?= $customerNights; ?>" />
<input type="hidden" name="cot" value="<?= $cot; ?>" />
<input type="hidden" name="highchair" value="<?= $highchair; ?>" />
<input type="hidden" name="saleDate" value="<?= $saleDate; ?>" />
<input type="hidden" name="saleStatus" value="<?= $saleStatus; ?>" />
<input type="hidden" name="enquiryId" value="<?= $enquiryId; ?>" />


<td class="mainhead">Item</td><td class="mainhead" />Data</td>
<td class="mainhead">Action</td>
</tr>

<tr>
<td class="normal" colspan="2" /> (changing email address will automatically create a new customer record)</td>
</tr>

<tr>
<td class="normal">Email</td>
<td class="normal"><?=$newCustomerEmail; ?></td><td><input type="text" name="newCustomerEmail" value="<?=$newCustomerEmail; ?>" size="50" /></td>
</tr>

<tr>
<td class="normal">Name</td><td class="normal"><?=$newCustomerName; ?> <?=$newCustomerSurname; ?></td>
<td class="normal"> |No action<input type="radio" name="replace_customer_name" value="no" checked>|Replace<input type="radio" name="replace_customer_name" value="yes" />|</td>
</tr>

<tr>
<td class="normal">Landphone</td>
<td class="normal"><?=$newCustomerLandphone; ?></td><td class="normal">|No action<input type="radio" name="replace_customer_landphone" value="no" checked>|Replace<input type="radio" name="replace_customer_landphone" value="yes" />|</td>
</tr>

<tr>
<td class="normal">Mobile</td>
<td class="normal"><?=$newCustomerMobile; ?></td><td class="normal">|No action<input type="radio" name="replace_customer_mobile" value="no" checked>|Replace<input type="radio" name="replace_customer_mobile" value="yes" />|</td>
</tr>

<tr>
<td class="normal">Address</td>
<td class="normal"><?=$newCustomerAddress; ?></td><td class="normal">|No action<input type="radio" name="replace_customer_address" value="no" checked>|Replace<input type="radio" name="replace_customer_address" value="yes" />|</td>
</tr>

<tr>
<td align="right" class="normal">&nbsp;</td>
<td align="right" class="normal"><input type="submit" value="Continue with sale with changes" /></form></td>
</tr>
</table>
<?php endforeach; ?>
</div>

