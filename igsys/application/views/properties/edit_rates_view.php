<!-- Properties edit rates view -->
<?php foreach ($propertyQuery->result() as $row): ?>
<?php $propertyCode = $row->property_code;?>

<?php endforeach; ?>
<?php $startDate = date("Y-m-d"); ?>
<div>
<!-- Header section -->
<table width="100%" border="1">
<tr>
	<th>From</th>
	<th>To</th>
	<th>1 night</th>
	<th>2 nights</th>
	<th>3 nights</th>
	<th>4 nights</th>
	<th>5 nights</th>
	<th>6 nights</th>
	<th>1 week</th>
	<th>Xtra night</th>
	<th colspan="2">Action</th>
</tr>
<!-- Output section -->
<?php foreach ($ratesQuery->result() as $item):
$attributes = array('style' => 'margin-bottom: 0' , 'name' => "Mike" . $item->standardRateId);
?>
<tr>
<?php
echo form_open('properties/update_single_rate',$attributes);
?>

<input type="hidden" name="rateId" value="<?=$item->standardRateId;?>" />
<input type="hidden" name="propertyCode" value="<?=$item->propertyCode;?>" />
	<td width="169"><script>DateInput('fromDate<?=$item->standardRateId;?>', false, 'YYYY-MM-DD', '<?=$item->fromDate;?>')</script></td>
	<td width="169"><script>DateInput('toDate<?=$item->standardRateId;?>', false, 'YYYY-MM-DD', '<?=$item->toDate;?>')</script></td>
	<td align="center"><input type="text" name="rateOne" value="<?=$item->rateOne;?>" size="4" /></td>
	<td align="center"><input type="text" name="rateTwo" value="<?=$item->rateTwo;?>" size="4" /></td>
	<td align="center"><input type="text" name="rateThree" value="<?=$item->rateThree;?>" size="4" /></td>
	<td align="center"><input type="text" name="rateFour" value="<?=$item->rateFour;?>" size="4" /></td>
	<td align="center"><input type="text" name="rateFive" value="<?=$item->rateFive;?>" size="4" /></td>
	<td align="center"><input type="text" name="rateSix" value="<?=$item->rateSix;?>" size="4" /></td>
	<td align="center"><input type="text" name="rateSeven" value="<?=$item->rateSeven;?>" size="4" /></td>
	<td align="center"><input type="text" name="xtraNight" value="<?=$item->xtraNight;?>" size="4" /></td>
	<td align="center"><input type="submit" name="submit" value="Update" /></td>
	<td align="center"><a href="index.php/properties/delete_single_rate/<?=$item->propertyCode;?>/<?=$item->standardRateId;?>"><img src="images/app/delete.gif" border="0" width="20" height="20" title="Delete this record"/></a></td>
</form>
<!-- Get 'next' date for date calendar -->
<?php
$date_parts_toDate = explode("-",$item->toDate);
$startDate = date("Y-m-d", mktime(0,0,0, $date_parts_toDate[1], $date_parts_toDate[2]+1, $date_parts_toDate[0]));
?>
</tr>
<?php endforeach; ?>
<!-- Input section -->
<?php $attributes = array('style' => 'margin-bottom: 0');?>
<tr>
<?=form_open('properties/add_single_rate',$attributes);?>
<input type="hidden" name="propertyCode" value="<?=$propertyCode;?>" />
	<td width="169"><script>DateInput('fromDate', false, 'YYYY-MM-DD','<?=$startDate;?>')</script></td>
	<td width="169"><script>DateInput('toDate', false, 'YYYY-MM-DD','<?=$startDate;?>')</script></td>
	<td align="center"><input name="rateOne" value="" size="4" /></td>
	<td align="center"><input name="rateTwo" value="" size="4" /></td>
	<td align="center"><input name="rateThree" value="" size="4" /></td>
	<td align="center"><input name="rateFour" value="" size="4" /></td>
	<td align="center"><input name="rateFive" value="" size="4" /></td>
	<td align="center"><input name="rateSix" value="" size="4" /></td>
	<td align="center"><input name="rateSeven" value="" size="4" /></td>
	<td align="center"><input name="xtraNight" value="" size="4" /></td>
	<td align="center"><input type="submit" name="submit" value="Add new rates" /></td>
</form>
</tr>
</table>

<table>
<tr>

<td>Copy rates <b>from:</b> </td>
<?php
$hidden = array('propertyCodeTarget' => $row->property_code);
$attributes = array('style' => 'margin-bottom: 0' , 'name' => "copyRates");
echo form_open('properties/copy_rates', $attributes, $hidden);
?>
<td>
	<select name="propertyCodeSource">
		<?=$unselectedPropertyCombo;?>
	</select>
</td>
<td><input type="submit" name="submit" value="Copy rates" /> <b>To:</b> <?=$row->property_name;?></td>
</tr>
<tr>
<td colspan="2"><b>**Warning! This will replace any current rates</b></td>
</tr>
</table>

</div>