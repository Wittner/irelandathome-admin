<!-- Accommodation listing -->
<?php $imagePath = 'http://www.irelandathome.com/images/'; ?> 
<p>&nbsp;</p>
<p>&nbsp;</p>
<hr />
<h3>Prices and availability<br>
	From: <?=$displayFromDate;?><br>
	To: <?=$displayToDate;?><br>
	Number of nights: <?=$nights;?></h3>
<hr />

<style type="text/css">
.mainBox{
	float: left;

	border-top: 1px solid;
	border-bottom: 1px solid;
	margin-bottom: 8px;
	margin-top: 8px;
}

.listPhoto{
	width: 999px;
	height: 108px;
	margin-bottom: 4px;
}

.listPhoto img{
	margin: 4px;
}

.listBoxIcons{

}
</style>

<?php if (gettype($propertyList) === 'array'): ?>

<?php foreach($propertyList as $item): ?>
<div class="mainBox">

<div class="listBoxHeading" style="font-weight: bold; font-size: 14px;">
	<span style="font-size: 18px;"><?php echo $item->property_name; ?></span> | Rooms: <?php echo $item->property_bedrooms; ?>&nbsp;&nbsp;Sleeps: <?php echo $item->property_capacity; ?>&nbsp;&nbsp;Rating: <?php echo $item->property_standard; ?> | <span style="color: #c00000;">&euro; Price for this stay: <?php echo $item->cost; ?>
</div>

<div class="listBox">
	<div class="listPhoto" id="listPhoto<?php echo $item->property_code; ?>">
		<div>
			<img class="listPic" src="<?php echo $imagePath; ?><?php echo $item->pic1; ?>" width="150" height="100" border="0" align="left" alt="Photo of holiday home" />
			<img class="listPic" src="<?php echo $imagePath; ?><?php echo $item->pic2; ?>" width="150" height="100" border="0" align="left" alt="Photo of holiday home" />
			<img class="listPic" src="<?php echo $imagePath; ?><?php echo $item->pic3 ?>" width="150" height="100" border="0" align="left" alt="Photo of holiday home" />
			<img class="listPic" src="<?php echo $imagePath; ?><?php echo $item->pic4; ?>" width="150" height="100" border="0" align="left" alt="Photo of holiday home" />
		</div>
	</div>
	<div class="listBoxDetails" id="listBoxDetails<?php echo $item->property_code; ?>">
		<?php echo $item->property_intro; ?>
	</div>
</div>

<div class="listBoxIcons">
	<div class="listBoxLayout">ROOM LAYOUT<br />
		<?php if($item->layout_1 != 'na'){$layoutPath_1 = $imagePath . 'icons/' . $item->layout_1;}else{$layoutPath_1 = $imagePath . 'icons/bed_blank.gif';}?>
		<?php if($item->layout_2 != 'na'){$layoutPath_2 = $imagePath . 'icons/' . $item->layout_2;}else{$layoutPath_2 = $imagePath . 'icons/bed_blank.gif';}?>
		<?php if($item->layout_3 != 'na'){$layoutPath_3 = $imagePath . 'icons/' . $item->layout_3;}else{$layoutPath_3 = $imagePath . 'icons/bed_blank.gif';}?>
		<?php if($item->layout_4 != 'na'){$layoutPath_4 = $imagePath . 'icons/' . $item->layout_4;}else{$layoutPath_4 = $imagePath . 'icons/bed_blank.gif';}?>
		<?php if($item->layout_5 != 'na'){$layoutPath_5 = $imagePath . 'icons/' . $item->layout_5;}else{$layoutPath_5 = $imagePath . 'icons/bed_blank.gif';}?>
		<?php if($item->layout_6 != 'na'){$layoutPath_6 = $imagePath . 'icons/' . $item->layout_6;}else{$layoutPath_6 = $imagePath . 'icons/bed_blank.gif';}?>
		
		<table border="1" cellspacing="0" cellpadding="0">
		<tr>
			<td><img class="room" src="<?php echo $layoutPath_1;?>" width="29" height="29" border="0" align="left" alt="Beds in Room 1" /></td>
			<td><img class="room"  style="margin-left: 1px; margin-right: 1px" src="<?php echo $layoutPath_2;?>" width="29" height="29" border="0" align="left" alt="Beds in Room 2" /></td>
			<td><img class="room" src="<?php echo $layoutPath_3;?>" width="29" height="29" border="0" align="left" alt="Beds in Room 3" /><br clear="left" /></td>
		</tr>
		<tr>
			<td><img class="room" src="<?php echo $layoutPath_4;?>" width="29" height="29" border="0" align="left" alt="Beds in Room 4" /></td>
			<td><img class="room"  style="margin-left: 1px; margin-right: 1px;" src="<?php echo $layoutPath_5;?>" width="29" height="29" border="0" align="left" alt="Beds in Room 5" /></td>
			<td><img class="room" src="<?php echo $layoutPath_6;?>" width="29" height="29" border="0" align="left" alt="Beds in Room 6" /></td>
		</tr>
		</table>
	</div>
</div>

<div class="listBoxFacilities"><p style="padding: 0 0 0 10px; margin: 0;">FACILITIES</p>
	<div style="margin-bottom: 10px;">
	<?php if($item->cooker == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/cooker.gif" width="29" height="29" border="0" align="left" alt="cooker available" />';}?>
	<?php if($item->washer == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/washer.gif" width="29" height="29" border="0" align="left" alt="washer available" />';}?>
	<?php if($item->tumbler == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/tumbler.gif" width="29" height="29" border="0" align="left" alt="tumbler available" />';}?>
	<?php if($item->dishwasher == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/dishwasher.gif" width="29" height="29" border="0" align="left" alt="dishwasher available" />';}?>
	<?php if($item->micro == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/micro.gif" width="29" height="29" border="0" align="left" alt="microwave oven available" />';}?>
	<?php if($item->fridge == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/fridge.gif" width="29" height="29" border="0" align="left" alt="fridge available" />';}?>
	<?php if($item->cheating == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/cheating.gif" width="29" height="29" border="0" align="left" alt="central heating available" />';}?>
	<?php if($item->fire == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/fire.gif" width="29" height="29" border="0" align="left" alt="real fire available" />';}?>
	<?php if($item->tv == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/tv.gif" width="29" height="29" border="0" align="left" alt="tv available" />';}?>
	<?php if($item->vid == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/vid.gif" width="29" height="29" border="0" align="left" alt="dvd player available" />';}?>
	<?php if($item->dvd == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/dvd.gif" width="29" height="29" border="0" align="left" alt="cooker available" />';}?>
	<?php if($item->ensuite == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/ensuite.gif" width="29" height="29" border="0" align="left" alt="ensuite available" />';}?>
	<?php if($item->shower == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/shower.gif" width="29" height="29" border="0" align="left" alt="shower available" />';}?>
	<?php if($item->cot == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/cot.gif" width="29" height="29" border="0" align="left" alt="cot available" />';}?>
	<?php if($item->linen == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/towels.gif" width="29" height="29" border="0" align="left" alt="babysitting available" />';}?>
	<?php if($item->baby == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/baby.gif" width="29" height="29" border="0" align="left" alt="cooker available" />';}?>
	<?php if($item->iron == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/iron.gif" width="29" height="29" border="0" align="left" alt="iron available" />';}?>
	<?php if($item->bath == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/bath.gif" width="29" height="29" border="0" align="left" alt="bath available" />';}?>
	<?php if($item->towels == 'yes'){echo '<img class="facility" src="' . $imagePath . 'icons/towels.gif" width="29" height="29" border="0" align="left" alt="towels available" />';}?>
	</div>
</div>

</div>
<!-- box? -->

<?php endforeach; ?>
<?php else: ?>
	<h1>There are no results for these dates</h1>
<?php endif; ?>

<!-- /Accommodation listing -->
