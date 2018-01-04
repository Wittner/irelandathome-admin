<?php include_once("fckeditor/fckeditor.php") ; ?>

<?php foreach ($query->result() as $row): ?>
<?php
$property_type_combo = $this->property_model->get_property_type_combo($row->property_type);
$ownerCombo = $this->owner_model->get_owner_combo($row->property_owner_id);
$townCombo = $this->town_model->get_town_combo($row->property_town_id);
if($row->hiSeasonStart == NULL)
{
	$hiSeasonStart = date('Y-m-d');
}
else
{
	$hiSeasonStart = $row->hiSeasonStart;
}

if($row->hiSeasonEnd == NULL)
{
	$hiSeasonEnd = date('Y-m-d');
}
else
{
	$hiSeasonEnd = $row->hiSeasonEnd;
}


?>

<script src="//cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
<div id="delivery">
<div align="center">

<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>

<table width="100%" align="center" border="1" cellpadding="4" cellspacing="4">
<?php $attributes=array('name' => 'property_edit', 'style' => 'display:inline;'); ?>
<?=form_open('properties/update_property',$attributes);?>
<input type="hidden" name="property_id" value="<?=$row->property_id;?>">
<input type="hidden" name="property_code" value="<?=$row->property_code;?>">

<tr>
	<td class="normal" colspan="2" align="center"><strong>BACKGROUND INFORMATION</strong></td>
</tr>

<tr>
	<td class="normal" align="right"><b>Property Name:</b></td>
	<td class="normal" align="left"><?=$row->property_name;?></td>
</tr>

<tr>
	<td class="normal" align="right"><b>Type:</b></td>
	<td class="normal" align="left">
	<select name="property_type">
		<?=$property_type_combo;?>
	</select>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Availability management</b></td>
	<td class="normal" align="left">
		<input type="checkbox" name="iah_availability"<?php if($row->iah_availability == 'on'){echo ' checked';}?>> IAH managed
	</td>
</tr>

<tr>
<td class="normal" align="right"><b>Property Code:</b></td>
<td class="normal" align="left"><?=$row->property_code;?></td>
</tr>

<tr>
	<td class="normal" align="right"><b>Owner</b></td>
	<td class="normal" align="left"><?= $row->contact_fname; ?> <?=$row->contact_sname;?></td>
</tr>

<tr>
	<td class="normal" align="right"><b>Caretaker name:</b></td>
	<td class="normal" align="left"><input type="text" name="caretaker_name" size="25" maxlength="50" value="<?=$row->caretaker_name;?>"></td>
</tr>

<tr>
	<td class="normal" align="right"><b>Caretaker number:</b></td>
	<td class="normal" align="left"><input type="text" name="caretaker_number" size="25" maxlength="50" value="<?=$row->caretaker_number;?>"></td>
</tr>

<tr>
	<td class="normal" align="right"><b>Caretaker email:</b></td>
	<td class="normal" align="left"><input type="text" name="caretaker_email" size="25" maxlength="50" value="<?=$row->caretaker_email;?>"></td>
</tr>

<tr>
	<td class="normal" align="right"><b>Annual fee customer?:</b></td>
	<td class="normal" align="left">
	<select name="annual_fee">
		<option value="NO"<?php if($row->annual_fee == 'NO'){echo ' selected';}?>>No</option>
		<option value="YES"<?php if($row->annual_fee == 'YES'){echo ' selected';}?>>Yes</option>
	</select>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Live booking?:</b></td>
	<td class="normal" align="left">
	<select name="livebook">
		<option value="NO"<?php if($row->livebook == 'NO'){echo ' selected';}?>>No</option>
		<option value="YES"<?php if($row->livebook == 'YES'){echo ' selected';}?>>Yes</option>
	</select>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Allocation:</b></td>
	<td class="normal" align="left"><input type="text" name="property_units" size="5" maxlength="50" value="<?=$row->property_units;?>"></td>
</tr>

<tr>
	<td class="normal" align="right"><b>Fee amount (if 'Yes' above):</b></td>
	<td class="normal" align="left"><input type="text" name="annual_fee_amount" size="25" maxlength="25" value="<?=$row->annual_fee_amount;?>"></td>
</tr>

<tr>
<td class="normal" align="right"><b>Standard commission %</b></td>
	<td align="left">
	  	<select name="commission_percent" onChange="totValues();">
		  <option value="0"<?php if($row->commission_percent == '0'){echo ' selected';}?>>0</option>
		  <option value="5"<?php if($row->commission_percent == '5'){echo ' selected';}?>>5</option>
		  <option value="7.5"<?php if($row->commission_percent == '7.5'){echo ' selected';}?>>7.5</option>
		  <option value="10"<?php if($row->commission_percent == '10'){echo ' selected';}?>>10</option>
		  <option value="12"<?php if($row->commission_percent == '12'){echo ' selected';}?>>12</option>
		  <option value="12.5"<?php if($row->commission_percent == '12.5'){echo ' selected';}?>>12.5</option>
		  <option value="15"<?php if($row->commission_percent == '15'){echo ' selected';}?>>15</option>
		  <option value="17.5"<?php if($row->commission_percent == '17.5'){echo ' selected';}?>>17.5</option>
		  <option value="20"<?php if($row->commission_percent == '20'){echo ' selected';}?>>20</option>
		  <option value="25"<?php if($row->commission_percent == '25'){echo ' selected';}?>>25</option>
	  	</select>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Lifestyle sector</b></td>
	<td class="normal" align="left">
		<input type="checkbox" name="golf"<?php if($row->golf == 'on'){echo ' checked';}?>> Golf
		<input type="checkbox" name="surfing"<?php if($row->surfing == 'on'){echo ' checked';}?>> Surfing
		<input type="checkbox" name="fishing"<?php if($row->fishing == 'on'){echo ' checked';}?>> Fishing
		<input type="checkbox" name="beach"<?php if($row->beach == 'on'){echo ' checked';}?>> Beach
		<input type="checkbox" name="apt"<?php if($row->apt == 'on'){echo ' checked';}?>> Apart
		<input type="checkbox" name="pets"<?php if($row->pets == 'on'){echo ' checked';}?>> Pets
		<input type="checkbox" name="accessible"<?php if($row->accessible == 'on'){echo ' checked';}?>> Accessible
		<input type="checkbox" name="couples"<?php if($row->couples == 'on'){echo ' checked';}?>> Couples
		<input type="checkbox" name="groups"<?php if($row->groups == 'on'){echo ' checked';}?>> Groups
		<input type="checkbox" name="internet"<?php if($row->internet == 'on'){echo ' checked';}?>> Internet
	</td>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>Property Address:</b></td>
	<td class="normal" align="left"><textarea cols="25" rows="4" name="property_address"><?=$row->property_address;?></textarea></td>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>Property map reference:</b></td>
	<td class="normal" align="left">
		<input type="text" name="lat" value="<?=$row->lat;?>">
		<input type="text" name="lng" value="<?=$row->lng;?>">
	</td>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>Nightly rate:</b></td>
	<td class="normal" align="left"><input type="text" name="nightly_rate" value="<?=$row->nightly_rate;?>"></td>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>Security deposit:</b></td>
	<td class="normal" align="left"><input type="text" name="security_deposit" value="<?=$row->security_deposit;?>"></td>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>Cleaning fee:</b></td>
	<td class="normal" align="left"><input type="text" name="cleaning_fee" value="<?=$row->cleaning_fee;?>"></td>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>Utilities:</b></td>
	<td class="normal" align="left"><input type="text" name="utilities" value="<?=$row->utilities;?>"></td>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>Check in time (XX:XX):</b></td>
	<td class="normal" align="left"><input type="text" name="check_in" value="<?=$row->check_in;?>"></td>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>Check out time (XX:XX):</b></td>
	<td class="normal" align="left"><input type="text" name="check_out" value="<?=$row->check_out;?>"></td>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>Directions:</b></td>
	<td class="normal" align="left">
		<textarea name="property_directions" id="property_directions" rows="10" cols="80" class="admin-edit-field"><?= $row->property_directions; ?></textarea>
		<script>
			CKEDITOR.replace('property_directions');
		</script>
	</td>

</tr>

<tr>
	<td class="normal" align="right"><b>Town:</b></td>
	<td class="normal" align="left">
		<select name="property_town_id">
			<?= $townCombo; ?>
		</select>
	</td>
</tr>

<tr>
<td class="normal" align="right"><b>Status (Live/Not Live):</b></td>
	<td class="normal" align="left">
		<select name="property_status">
			<option value="LVE"<?php if($row->property_status == 'LVE'){echo ' selected';}?>>Live</option>
			<option value="OFF"<?php if($row->property_status == 'OFF'){echo ' selected';}?>>Not Live</option>
		</select>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Standard</b></td>
	<td class="normal" align="left">
		<select name="property_standard">
			<option value="0"<?php if($row->property_standard == '0'){echo ' selected';}?>>No star</option>
			<option value="1"<?php if($row->property_standard == '1'){echo ' selected';}?>>1 Star</option>
			<option value="2"<?php if($row->property_standard == '2'){echo ' selected';}?>>2 Stars</option>
			<option value="3"<?php if($row->property_standard == '3'){echo ' selected';}?>>3 Stars</option>
			<option value="4"<?php if($row->property_standard == '4'){echo ' selected';}?>>4 Stars</option>
			<option value="5"<?php if($row->property_standard == '5'){echo ' selected';}?>>5 Stars</option>
		</select>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Weighting:</b></td>
	<td class="normal" align="left"><input type="text" name="weight" value="<?=$row->weight;?>"></td>
</tr>

<tr>
	<td class="normal" align="right"><b>Strap line:</b></td>
	<td class="normal" align="left"><input class="strap" style="font-family: monospace;" type="text" name="strapline" size=50 value="<?=$row->strapline;?>">[<span class="char-count"></span>]</td>
</tr>



<tr>
	<td class="normal" align="right"><b>Capacity:</b></td>
	<td class="normal" align="left"><input type="text" name="property_capacity" value="<?=$row->property_capacity;?>"></td>
</tr>


<tr>
	<td class="normal" align="right"><b>Bedrooms:</b></td>
	<td class="normal" align="left"><input type="text" name="property_bedrooms" value="<?=$row->property_bedrooms;?>"></td>
</tr>

<!-- Bedroom Layouts -->
<tr>
	<td class="normal" align="right"><b>Layout, room 1</b></td>
	<td class="normal" align="left">
		<select name="layout_1">
			<option value="na" >N/A</option>
			<option value="beds_db.gif"<?php if($row->layout_1 == 'beds_db.gif'){echo ' selected';};?>>Double</option>
			<option value="beds_db2.gif"<?php if($row->layout_1 == 'beds_db2.gif'){echo ' selected';};?>>Twin Double</option>
			<option value="beds_dbs.gif"<?php if($row->layout_1 == 'beds_dbs.gif'){echo ' selected';};?>>Double with single</option>
			<option value="beds_s.gif"<?php if($row->layout_1 == 'beds_s.gif'){echo ' selected';};?>>Single</option>
			<option value="beds_ss.gif"<?php if($row->layout_1 == 'beds_ss.gif'){echo ' selected';};?>>Single X 2</option>
			<option value="beds_sss.gif"<?php if($row->layout_1 == 'beds_sss.gif'){echo ' selected';};?>>Single X 3</option>
			<option value="beds_ssss.gif"<?php if($row->layout_1 == 'beds_ssss.gif'){echo ' selected';};?>>Single X 4</option>
		</select>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Layout, room 2</b></td>
	<td class="normal" align="left">
		<select name="layout_2">
			<option value="na" >N/A</option>
			<option value="beds_db.gif"<?php if($row->layout_2 == 'beds_db.gif'){echo ' selected';};?>>Double</option>
			<option value="beds_db2.gif"<?php if($row->layout_2 == 'beds_db2.gif'){echo ' selected';};?>>Twin Double</option>
			<option value="beds_dbs.gif"<?php if($row->layout_2 == 'beds_dbs.gif'){echo ' selected';};?>>Double with single</option>
			<option value="beds_s.gif"<?php if($row->layout_2 == 'beds_s.gif'){echo ' selected';};?>>Single</option>
			<option value="beds_ss.gif"<?php if($row->layout_2 == 'beds_ss.gif'){echo ' selected';};?>>Single X 2</option>
			<option value="beds_sss.gif"<?php if($row->layout_2 == 'beds_sss.gif'){echo ' selected';};?>>Single X 3</option>
			<option value="beds_ssss.gif"<?php if($row->layout_2 == 'beds_ssss.gif'){echo ' selected';};?>>Single X 4</option>
		</select>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Layout, room 3</b></td>
	<td class="normal" align="left">
		<select name="layout_3">
			<option value="na" >N/A</option>
			<option value="beds_db.gif"<?php if($row->layout_3 == 'beds_db.gif'){echo ' selected';};?>>Double</option>
			<option value="beds_db2.gif"<?php if($row->layout_3 == 'beds_db2.gif'){echo ' selected';};?>>Twin Double</option>
			<option value="beds_dbs.gif"<?php if($row->layout_3 == 'beds_dbs.gif'){echo ' selected';};?>>Double with single</option>
			<option value="beds_s.gif"<?php if($row->layout_3 == 'beds_s.gif'){echo ' selected';};?>>Single</option>
			<option value="beds_ss.gif"<?php if($row->layout_3 == 'beds_ss.gif'){echo ' selected';};?>>Single X 2</option>
			<option value="beds_sss.gif"<?php if($row->layout_3 == 'beds_sss.gif'){echo ' selected';};?>>Single X 3</option>
			<option value="beds_ssss.gif"<?php if($row->layout_3 == 'beds_ssss.gif'){echo ' selected';};?>>Single X 4</option>
		</select>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Layout, room 4</b></td>
	<td class="normal" align="left">
		<select name="layout_4">
			<option value="na" >N/A</option>
			<option value="beds_db.gif"<?php if($row->layout_4 == 'beds_db.gif'){echo ' selected';};?>>Double</option>
			<option value="beds_db2.gif"<?php if($row->layout_4 == 'beds_db2.gif'){echo ' selected';};?>>Twin Double</option>
			<option value="beds_dbs.gif"<?php if($row->layout_4 == 'beds_dbs.gif'){echo ' selected';};?>>Double with single</option>
			<option value="beds_s.gif"<?php if($row->layout_4 == 'beds_s.gif'){echo ' selected';};?>>Single</option>
			<option value="beds_ss.gif"<?php if($row->layout_4 == 'beds_ss.gif'){echo ' selected';};?>>Single X 2</option>
			<option value="beds_sss.gif"<?php if($row->layout_4 == 'beds_sss.gif'){echo ' selected';};?>>Single X 3</option>
			<option value="beds_ssss.gif"<?php if($row->layout_4 == 'beds_ssss.gif'){echo ' selected';};?>>Single X 4</option>
		</select>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Layout, room 5</b></td>
	<td class="normal" align="left">
		<select name="layout_5">
			<option value="na" >N/A</option>
			<option value="beds_db.gif"<?php if($row->layout_5 == 'beds_db.gif'){echo ' selected';};?>>Double</option>
			<option value="beds_db2.gif"<?php if($row->layout_5 == 'beds_db2.gif'){echo ' selected';};?>>Twin Double</option>
			<option value="beds_dbs.gif"<?php if($row->layout_5 == 'beds_dbs.gif'){echo ' selected';};?>>Double with single</option>
			<option value="beds_s.gif"<?php if($row->layout_5 == 'beds_s.gif'){echo ' selected';};?>>Single</option>
			<option value="beds_ss.gif"<?php if($row->layout_5 == 'beds_ss.gif'){echo ' selected';};?>>Single X 2</option>
			<option value="beds_sss.gif"<?php if($row->layout_5 == 'beds_sss.gif'){echo ' selected';};?>>Single X 3</option>
			<option value="beds_ssss.gif"<?php if($row->layout_5 == 'beds_ssss.gif'){echo ' selected';};?>>Single X 4</option>
		</select>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Layout, room 6</b></td>
	<td class="normal" align="left">
		<select name="layout_6">
			<option value="na" >N/A</option>
			<option value="beds_db.gif"<?php if($row->layout_6 == 'beds_db.gif'){echo ' selected';};?>>Double</option>
			<option value="beds_db2.gif"<?php if($row->layout_6 == 'beds_db2.gif'){echo ' selected';};?>>Twin Double</option>
			<option value="beds_dbs.gif"<?php if($row->layout_6 == 'beds_dbs.gif'){echo ' selected';};?>>Double with single</option>
			<option value="beds_s.gif"<?php if($row->layout_6 == 'beds_s.gif'){echo ' selected';};?>>Single</option>
			<option value="beds_ss.gif"<?php if($row->layout_6 == 'beds_ss.gif'){echo ' selected';};?>>Single X 2</option>
			<option value="beds_sss.gif"<?php if($row->layout_6 == 'beds_sss.gif'){echo ' selected';};?>>Single X 3</option>
			<option value="beds_ssss.gif"<?php if($row->layout_6 == 'beds_ssss.gif'){echo ' selected';};?>>Single X 4</option>
		</select>
	</td>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>This Property (Leisure):</b></td>
	<td class="normal" align="left">
		<textarea name="property_intro" id="property_intro" rows="10" cols="80"><?= $row->property_intro; ?></textarea>
		<script>
			CKEDITOR.replace('property_intro');
		</script>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>This Property (Corporate):</b></td>
	<td class="normal" align="left">
		<textarea name="property_intro_corporate" id="property_intro_corporate" rows="10" cols="80"><?= $row->property_intro_corporate; ?></textarea>
		<script>
			CKEDITOR.replace('property_intro_corporate');
		</script>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>Accommodation:</b></td>
	<td class="normal" align="left">
		<textarea name="property_description" id="property_description" rows="10" cols="80" class="admin-edit-field"><?= $row->property_description; ?></textarea>
		<script>
			CKEDITOR.replace('property_description');
		</script>
	</td>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>Close To Home:</b></td>
	<td class="normal" align="left">
		<textarea name="area_description" id="area_description" rows="10" cols="80" class="admin-edit-field"><?= $row->area_description; ?></textarea>
		<script>
			CKEDITOR.replace('area_description');
		</script>
	</td>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>House Rules:</b></td>
	<td class="normal" align="left">
		<textarea name="rate_comment" id="rate_comment" rows="10" cols="80" class="admin-edit-field"><?= $row->rate_comment; ?></textarea>
		<script>
			CKEDITOR.replace('rate_comment');
		</script>
	</td>
</tr>

<tr>
	<td class="normal" align="right" valign="top">
		<b>Picture 1:</b>
	</td>
	<td class="normal" align="left" valign="top">
		<input type="text" name="pic1" value="<?=$row->pic1;?>" size="50" /><br />
		<img src="<?php echo $companyData['imageurl'];?>/<?=$row->pic1;?>" border="0" width="150" height="100"/>
	</td>
</tr>
<tr>
	<td class="normal" align="right" valign="top"><b>Description:</b></td>
	<td class="normal" align="left"><input type="text" name="pic1_descrip" value="<?=$row->pic1_descrip;?>"></td>
</tr>

<tr>
	<td class="normal" align="right" valign="top">
		<b>Picture 2:</b>
	</td>
	<td class="normal" align="left" valign="top">
		<input type="text" name="pic2" value="<?=$row->pic2;?>" size="50" /><br />
		<img src="<?php echo $companyData['imageurl'];?>/<?=$row->pic2;?>" border="0" width="150" height="100"/>
	</td>
</tr>
<tr>
	<td class="normal" align="right" valign="top"><b>Description:</b></td>
	<td class="normal" align="left"><input type="text" name="pic2_descrip" value="<?=$row->pic2_descrip;?>"></td>
</tr>

<tr>
	<td class="normal" align="right" valign="top">
		<b>Picture 3:</b>
	</td>
	<td class="normal" align="left" valign="top">
		<input type="text" name="pic3" value="<?=$row->pic3;?>" size="50" /><br />
		<img src="<?php echo $companyData['imageurl'];?>/<?=$row->pic3;?>" border="0" width="150" height="100"/>
	</td>
</tr>
<tr>
	<td class="normal" align="right" valign="top"><b>Description:</b></td>
	<td class="normal" align="left"><input type="text" name="pic3_descrip" value="<?=$row->pic3_descrip;?>"></td>
</tr>

<tr>
	<td class="normal" align="right" valign="top">
		<b>Picture 4:</b>
	</td>
	<td class="normal" align="left" valign="top">
		<input type="text" name="pic4" value="<?=$row->pic4;?>" size="50" /><br />
		<img src="<?php echo $companyData['imageurl'];?>/<?=$row->pic4;?>" border="0" width="150" height="100"/>
	</td>
</tr>
<tr>
	<td class="normal" align="right" valign="top"><b>Description:</b></td>
	<td class="normal" align="left"><input type="text" name="pic4_descrip" value="<?=$row->pic4_descrip;?>"></td>
</tr>

<tr>
	<td class="normal" align="right" colspan="2" bgcolor="White">&nbsp;</td>
</tr>

<!-- Periods and costs -->
<tr><td class="normal" align="center" colspan="2"><strong>PERIODS AND COSTS</strong></td></tr>

<tr>
<td class="normal" align="center" colspan="2">
<table>
<tr>
<td><strong>High season start date: </strong><script>DateInput('hiSeasonStart', true, 'YYYY-MM-DD', '<?=$hiSeasonStart;?>')</script></td>
<td><strong>High season end date: </strong> <script>DateInput('hiSeasonEnd', true, 'YYYY-MM-DD', '<?=$hiSeasonEnd;?>')</script></td>
</tr>
</table>
</td>
</tr>

<tr>
<td class="normal" align="right">&nbsp;</td>
<td class="normal" align="left"><b>Period name / Cost:</b></td>
</tr>

<tr>
	<td align="right"><b>Period 1</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period1" value="<?=$row->rate_period1;?>">/<input type="text" size="4" name="period1_cost" value="<?=$row->period1_cost;?>">
	</td>
</tr>

<tr>
	<td align="right"><b>Period 2</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period2" value="<?=$row->rate_period2;?>">/<input type="text" size="4" name="period2_cost" value="<?=$row->period2_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 3</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period3" value="<?=$row->rate_period3;?>">/<input type="text" size="4" name="period3_cost" value="<?=$row->period3_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 4</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period4" value="<?=$row->rate_period4;?>">/<input type="text" size="4" name="period4_cost" value="<?=$row->period4_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 5</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period5" value="<?=$row->rate_period5;?>">/<input type="text" size="4" name="period5_cost" value="<?=$row->period5_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 6</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period6" value="<?=$row->rate_period6;?>">/<input type="text" size="4" name="period6_cost" value="<?=$row->period6_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 7</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period7" value="<?=$row->rate_period7;?>">/<input type="text" size="4" name="period7_cost" value="<?=$row->period7_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 8</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period8" value="<?=$row->rate_period8;?>">/<input type="text" size="4" name="period8_cost" value="<?=$row->period8_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 9</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period9" value="<?=$row->rate_period9;?>">/<input type="text" size="4" name="period9_cost" value="<?=$row->period9_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 10</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period10" value="<?=$row->rate_period10;?>">/<input type="text" size="4" name="period10_cost" value="<?=$row->period10_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 11</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period11" value="<?=$row->rate_period11;?>">/<input type="text" size="4" name="period11_cost" value="<?=$row->period11_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 12</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period12" value="<?=$row->rate_period12;?>">/<input type="text" size="4" name="period12_cost" value="<?=$row->period12_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 13</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period13" value="<?=$row->rate_period13;?>">/<input type="text" size="4" name="period13_cost" value="<?=$row->period13_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 14</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period14" value="<?=$row->rate_period14;?>">/<input type="text" size="4" name="period14_cost" value="<?=$row->period14_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 15</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period15" value="<?=$row->rate_period15;?>">/<input type="text" size="4" name="period15_cost" value="<?=$row->period15_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 16</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period16" value="<?=$row->rate_period16;?>">/<input type="text" size="4" name="period16_cost" value="<?=$row->period16_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 17</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period17" value="<?=$row->rate_period17;?>">/<input type="text" size="4" name="period17_cost" value="<?=$row->period17_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 18</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period18" value="<?=$row->rate_period18;?>">/<input type="text" size="4" name="period18_cost" value="<?=$row->period18_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 19</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period19" value="<?=$row->rate_period19;?>">/<input type="text" size="4" name="period19_cost" value="<?=$row->period19_cost;?>"></td>
</tr>

<tr>
	<td align="right"><b>Period 20</b></td>
	<td class="normal" align="left"><input type="text" size="25" name="rate_period20" value="<?=$row->rate_period20;?>">/<input type="text" size="4" name="period20_cost" value="<?=$row->period20_cost;?>"></td>
</tr>

<tr>
	<td class="normal" align="right"><b>Rates Live (YES/NO):</b></td>
	<td class="normal" align="left">
        <select name="rates_status">
	        <option value="YES"<?php if($row->rates_status == 'YES'){echo ' selected';};?>>YES</option>
	        <option value="NO"<?php if($row->rates_status == 'NO'){echo ' selected';};?>>NO</option>
        </select>
	</td>
</tr>

<tr>
	<td class="normal" align="right" colspan="2" bgcolor="White">&nbsp;</td>
</tr>

<!-- Offers -->
<tr>
	<td class="normal" align="center" colspan="2"><strong>SPECIAL OFFER/PROMOTIONS</strong></td>
</tr>

<tr>
	<td class="normal" align="right" valign="top"><b>Description</b></td>
	<td class="normal" align="left">
		<textarea name="offer_descrip" id="offer_descrip" rows="10" cols="80" class="admin-edit-field"><?= $row->offer_descrip; ?></textarea>
		<script>
			CKEDITOR.replace('offer_descrip');
		</script>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Qualifer</b></td>
	<td class="normal" align="left"><input type="text" name="valid_for" value="<?=$row->valid_for;?>"></td>
</tr>

<tr>
	<td class="normal" align="right"><b>Price</b></td>
	<td class="normal" align="left"><input type="text" name="offer_price" value="<?=$row->offer_price;?>"></td>
</tr>

<tr>
	<td class="normal" align="right"><b>Offer Live? (YES/NO):</b></td>
	<td class="normal" align="left">
	    <select name="live_offer">
			<option value="NO"<?php if($row->live_offer == 'NO'){echo ' selected';};?>>NO</option>
			<option value="YES"<?php if($row->live_offer == 'YES'){echo ' selected';};?>>YES</option>
		</select>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Margin? (YES/NO):</b></td>
	<td class="normal" align="left">
		<select name="front_page">
			<option value="NO"<?php if($row->front_page == 'NO'){echo ' selected';};?>>NO</option>
			<option value="YES"<?php if($row->front_page == 'YES'){echo ' selected';};?>>YES</option>
		</select>
	</td>
</tr>

<tr>
<td class="normal" align="right" colspan="2">&nbsp;</td>
</tr>

<!-- Promotions -->
<tr>
	<td class="normal" align="right"><b>Part of promotion? (YES/NO):</b></td>
	<td class="normal" align="left">
		<select name="live_promo">
			<option value="NO"<?php if($row->live_promo == 'NO'){echo ' selected';};?>>NO</option>
			<option value="YES"<?php if($row->live_promo == 'YES'){echo ' selected';};?>>YES</option>
		</select>
	</td>
</tr>

<tr>
<td class="normal" align="right" colspan="2">&nbsp;</td>
</tr>

<!-- Facilities -->
<tr>
	<td colspan="2" class="normal" align="center"><strong>FACILITIES</strong></td>
</tr>

<tr>
	<td class="normal" align="right"><b>Facilities<b></td>
	<td class="normal" align="left">Yes / No</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Cooker</b></td>
	<td class="normal" align="left">
		<input type="radio" name="cooker" value="yes"<?php if($row->cooker == 'yes'){echo ' checked';};?>>
		<input type="radio" name="cooker" value="no"<?php if($row->cooker == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Washer</b></td>
	<td class="normal" align="left">
		<input type="radio" name="washer" value="yes"<?php if($row->washer == 'yes'){echo ' checked';};?>>
		<input type="radio" name="washer" value="no"<?php if($row->washer == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Tumbler</b></td>
	<td class="normal" align="left">
		<input type="radio" name="tumbler" value="yes"<?php if($row->tumbler == 'yes'){echo ' checked';};?>>
		<input type="radio" name="tumbler" value="no"<?php if($row->tumbler == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Dishwasher</b></td>
	<td class="normal" align="left">
		<input type="radio" name="dishwasher" value="yes"<?php if($row->dishwasher == 'yes'){echo ' checked';};?>>
		<input type="radio" name="dishwasher" value="no"<?php if($row->dishwasher == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Microwave</b></td>
	<td class="normal" align="left">
		<input type="radio" name="micro" value="yes"<?php if($row->micro == 'yes'){echo ' checked';};?>>
		<input type="radio" name="micro" value="no"<?php if($row->micro == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Fridge</b></td>
	<td class="normal" align="left">
		<input type="radio" name="fridge" value="yes"<?php if($row->fridge == 'yes'){echo ' checked';};?>>
		<input type="radio" name="fridge" value="no"<?php if($row->fridge == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Cent. Heating</b></td>
	<td class="normal" align="left">
		<input type="radio" name="cheating" value="yes"<?php if($row->cheating == 'yes'){echo ' checked';};?>>
		<input type="radio" name="cheating" value="no"<?php if($row->cheating == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Open Fire</b></td>
	<td class="normal" align="left">
		<input type="radio" name="fire" value="yes"<?php if($row->fire == 'yes'){echo ' checked';};?>>
		<input type="radio" name="fire" value="no"<?php if($row->fire == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>TV</b></td>
	<td class="normal" align="left">
		<input type="radio" name="tv" value="yes"<?php if($row->tv == 'yes'){echo ' checked';};?>>
		<input type="radio" name="tv" value="no"<?php if($row->tv == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Video</b></td>
	<td class="normal" align="left">
		<input type="radio" name="vid" value="yes"<?php if($row->vid == 'yes'){echo ' checked';};?>>
		<input type="radio" name="vid" value="no"<?php if($row->vid == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>DVD</b></td>
	<td class="normal" align="left">
		<input type="radio" name="dvd" value="yes"<?php if($row->dvd == 'yes'){echo ' checked';};?>>
		<input type="radio" name="dvd" value="no"<?php if($row->dvd == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Ensuite</b></td>
	<td class="normal" align="left">
		<input type="radio" name="ensuite" value="yes"<?php if($row->ensuite == 'yes'){echo ' checked';};?>>
		<input type="radio" name="ensuite" value="no"<?php if($row->ensuite == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Bath</b></td>
	<td class="normal" align="left">
		<input type="radio" name="bath" value="yes"<?php if($row->bath == 'yes'){echo ' checked';};?>>
		<input type="radio" name="bath" value="no"<?php if($row->bath == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Shower</b></td>
	<td class="normal" align="left">
		<input type="radio" name="shower" value="yes"<?php if($row->shower == 'yes'){echo ' checked';};?>>
		<input type="radio" name="shower" value="no"<?php if($row->shower == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Cot</b></td>
	<td class="normal" align="left">
		<input type="radio" name="cot" value="yes"<?php if($row->cot == 'yes'){echo ' checked';};?>>
		<input type="radio" name="cot" value="no"<?php if($row->cot == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Highchair</b></td>
	<td class="normal" align="left">
		<input type="radio" name="highchair" value="yes"<?php if($row->highchair == 'yes'){echo ' checked';};?>>
		<input type="radio" name="highchair" value="no"<?php if($row->highchair == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Linen</b></td>
	<td class="normal" align="left">
		<input type="radio" name="linen" value="yes"<?php if($row->linen == 'yes'){echo ' checked';};?>>
		<input type="radio" name="linen" value="no"<?php if($row->linen == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Towels</b></td>
	<td class="normal" align="left">
		<input type="radio" name="towels" value="yes"<?php if($row->towels == 'yes'){echo ' checked';};?>>
		<input type="radio" name="towels" value="no"<?php if($row->towels == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Babysitting</b></td>
	<td class="normal" align="left">
		<input type="radio" name="baby" value="yes"<?php if($row->baby == 'yes'){echo ' checked';};?>>
		<input type="radio" name="baby" value="no"<?php if($row->baby == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Iron</b></td>
	<td class="normal" align="left">
		<input type="radio" name="iron" value="yes"<?php if($row->iron == 'yes'){echo ' checked';};?>>
		<input type="radio" name="iron" value="no"<?php if($row->iron == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right"><b>Bord Failte</b></td>
	<td class="normal" align="left">
		<input type="radio" name="bf" value="yes"<?php if($row->bf == 'yes'){echo ' checked';};?>>
		<input type="radio" name="bf" value="no"<?php if($row->bf == 'no'){echo ' checked';};?>>
	</td>
<tr>

<tr>
	<td class="normal" align="right" valign="top"><b>Terms</b></td>
	<td class="normal" align="left">
		<textarea name="terms" id="terms" rows="10" cols="80" class="admin-edit-field"><?= $row->terms; ?></textarea>
		<script>
			CKEDITOR.replace('terms');
		</script>
	</td>
</tr>

<tr>
	<td class="normal" align="right"><b>Disclaimer</b></td>
	<td class="normal" align="left">
		<textarea name="disclaimer" id="disclaimer" rows="10" cols="80" class="admin-edit-field"><?= $row->disclaimer; ?></textarea>
		<script>
			CKEDITOR.replace('disclaimer');
		</script>
	</td>
</tr>

<tr>
	<td class="normal" align="center" colspan="2"><input type="submit" name="submit" value="Update property" /><input type="submit" name="cancel" value="Cancel" /></td>
</tr>
</form>
</table>

</td>
</tr>
</table>




</div>
<?php endforeach; ?>

<!--
<td class="normal" align="left"><input class="strap" style="font-family: monospace;" type="text" name="strapline" size=50 value="<?=$row->strapline;?>">[<span class="char-count"></span>]</td>
-->

<script type="text/javascript">
	$( document ).ready(function() {
		var value = $('.strap').val();
		$('.char-count').html(value.length);

		$('.strap').live('input', function() {
			var value = $(this).val();
			$('.char-count').html(value.length);
			if(value.length >= 51) {
				$('.char-count').css({'color': 'red'});
			}else{
				$('.char-count').css({'color': 'black'});
			}
		});
	});
</script>
