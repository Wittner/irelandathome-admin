<div id="delivery">

<?php foreach($query->result() as $row): ?>
<?

$displayArrivalDate = $this->global_model->toDisplayDate($row->arrival_date);
$displayDepartureDate = $this->global_model->toDisplayDate($row->depart_date);

?>

<!-- Booking record start -->

<table border="0" width="100%" align="center" cellpadding="2" cellspacing="0" bgcolor="#E6F7FF">


<!-- Personal data -->
<tr>

<td class="avail_mainhead" valign="top" colspan="3">Personal Data</td>
</tr>

<tr>
<td class="normal" valign="top">
<strong>Name</strong><br />
<?=$row->customer_name;?><br />
</td>
<td class="normal" valign="top">
<b>Phone</b><br />
<?=$row->customer_landphone;?><br />
<b>Mobile</b><br />
<?=$row->customer_mobile;?>
</td>
<td class="normal" valign="top">
<b>Email</b><br />
<?=$row->customer_email;?>
</td>
</tr>

<tr>

</tr>

<tr>
<td class="wtback" valign="top" colspan="6">&nbsp;</td>
</tr>

<tr>
<td class="avail_mainhead" valign="top" colspan="3">Property and Arrival</td>
</tr>


<tr>
	<td class="normal" valign="top">
		<b>Arr.Date</b><br />
		<?=$displayArrivalDate?>
		</td>
	<td class="normal" valign="top">
		<b>Arr.Time</b><br />
		<?=$row->arrival_time; ?>
		</td>
	<td class="normal" valign="top">
		<b>Adults</b><br />
		<?=$row->customer_group; ?>
		</td>
</tr>

<tr>
	<td class="normal" valign="top">
		<b>Dep.Date</b><br />
		<?=$displayDepartureDate?>
		</td>
	<td class="normal" valign="top">
		<b>Dep.Time</b><br />
		<?=$row->depart_time; ?>
		</td>
	<td class="normal" valign="top">
		<b>Children</b><br />
		<?=$row->customer_children;?>
		</td>
</tr>

<tr>
	<td class="normal" valign="top">
		<b>Properties</b><br />
		<?=$row->property_list;?>
		</td>
	<td class="normal" valign="top">
		<b>Nights</b><br />
		<?=$row->customer_nights;?>
		</td>
	<td class="normal" valign="top">
		<b>Infants</b><br />
		<?=$row->customer_infants;?>
		</td>
</tr>

<tr>
<td colspan="3"><a href="index.php">Return</a></td>
</tr>

</table>
<!-- Booking record end -->

<?php endforeach; ?>
</div>

