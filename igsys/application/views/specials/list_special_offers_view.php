<script>
	$(function() {
	
		$('.infoLink').click(function(e) {
		    e.preventDefault();
		    //do other stuff when a click happens
		});
		
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

<?php $startDate = date("d-m-Y"); ?>
<div id="delivery">
<?php echo form_open('specials/add_special_offer');?>
<table name="offers_table" class="list" style="width: 800px;">
	<tr><th>Property</th><th>Season</th><th>From</th><th>To</th><th>Type</th><th>Price</th></tr>
	<tr>
	<td class="standard" style="width: 200px;">
		<select name="propertyCode">
			<?php echo $propertyCombo; ?>
		</select>
	</td>
	<td>
		<select name="holiday" id="holiday">
			<?php echo $holidayDropDown; ?>
		</select>
	</td>
	<td class="standard">
		<input type="text" id="offerFromDate" name="offerFromDate" class="datePickerDate" value="<?php echo $startDate; ?>"/>
	</td>
	<td class="standard">
		<input type="text" id="offerToDate" name="offerToDate" class="datePickerDate" value="<?php echo $startDate; ?>" />
	</td>
	<td class="standard">
		<select name="rangeType" id="rangeType">
			<option value="Defined">Defined</option>
			<option value="Loose">Loose</option>
		</select>
	</td>
	<td class="standard">
		<input name="offerPrice" id="offerPrice" style="width: 80px" />
	</td>

	</tr>
	<tr>
	<td class="standard" colspan="4">
		<textarea name="offerDescription" id="offerDescription" style="width: 806px; height: 80px" /></textarea>
	</td>
	<td class="standard">
		<input type="submit" name="submit" id="submit" value="Add offer" />
	</td>
	</tr>
</table>
</form>

<br />
	<hr />
<br />

<?php echo $results; ?>

</div><!-- delivery end -->