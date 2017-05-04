<script>
	$(function() {
		$( "#offerFromDate" ).datepicker({
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true
		});
		$( "#offerToDate" ).datepicker({
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			altField: '#offerToDate'
		});
				
		$('#holiday').change(function() {
			var holidayVal = $("#holiday").val();
			var holidayArray = holidayVal.split('|');
			if (holidayArray[0] == "defined")
			  {
			  	$('#offerFromDate').val(holidayArray[2]);
			  	$('#offerToDate').val(holidayArray[3]);
			  }
		});

	});
</script>

<div>
<?php foreach($specialsResult->result() as $row): ?>
<?php
$displayFromDate = $this->global_model->toDisplayDate($row->fromDate);
$displayToDate = $this->global_model->toDisplayDate($row->toDate);
?>

<?php echo form_open('specials/update_special_offer');?>
<input type="hidden" name="offerId" value="<?php echo $row->offerId; ?>" />
<table name="offers_table" class="list" style="width: 100%;" border="1">
	<tr>
		<th colspan="2">Please edit the current offer</th>
	</tr>
	<tr>
		<td class="standard">
			Property<br />
			<select name="propertyCode">
				<option value="<?php echo $row->propertyCode; ?>" selected><?php echo $row->property_name; ?></option>
				<?php echo $propertyCombo; ?>
			</select>
		</td>
		<td class="standard">
			Season<br />
			<select name="holiday" id="holiday">
				<option value="<?php echo $row->rangeType.'|'.$row->holiday; ?>" selected><?php echo $row->holiday; ?></option>
				<?php echo $holidayDropDown;?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="standard">
			From Date<br />
			<input type="text" id="offerFromDate" name="offerFromDate" class="datePickerDate" value="<?php echo $displayFromDate; ?>" />
		</td>
		<td>
			To Date<br />
			<input type="text" id="offerToDate" name="offerToDate" class="datePickerDate" value="<?php echo $displayToDate; ?>" />
		</td>
	</tr>
	<tr>
		<td class="standard">
			Type<br />
			<select name="rangeType" id="rangeType">
				<option value="Defined"<?php if($row->rangeType == 'Definded'){echo ' selected';}?>>Defined</option>
				<option value="Loose"<?php if($row->rangeType == 'Loose'){echo ' selected';}?>>Loose</option>
			</select>
		</td>
		<td>
			Price<br />
			<input name="offerPrice" id="offerPrice" value="<?php echo $row->offerPrice; ?>" />
		</td>
	</tr>
	<tr>
		<td class="standard" colspan="2">
			Description<br />
			<textarea name="offerDescription" id="offerDescription" style="width: 806px; height: 80px" /><?php echo $row->offerDescription; ?></textarea>
		</td>
	</tr>
	<tr>
		<td class="standard" colspan="2" align="center">
			<input type="submit" value="Update" />
		</td>
	</tr>
</table>
</form>
<?php endforeach;?>
</div>