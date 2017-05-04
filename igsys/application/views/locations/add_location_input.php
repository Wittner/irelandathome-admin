<?php include_once("fckeditor/fckeditor.php") ; ?>
<div id="delivery">
<table width="830" align="center" border="0" cellpadding="0" cellspacing="0">

<tr><td class="normal">
<link rel=stylesheet href="iah_sales_admin.css">
<div align="center">
<table width="800" align="center" border="0" cellpadding="4" cellspacing="4">
<?= form_open('locations/add_location');?>

<tr>
<td align="right" class="normal">
	<strong>Location (town) name:</strong></strong>
</td>
<td align="left">
	<input name="town_name" size="35" />
</td>
</tr>
<tr>
<td align="right" class="normal">
	<b>County:</b>
</td>
<td align="left" class="normal">
	<select name="county_id">
	<?= $countyCombo; ?>
	</select>
</td>
</tr>
<tr>
<td colspan="2" align="left">
	<strong>Amenities</strong>
</td>
</tr>
<tr>
<td class="normal" align="left" colspan="2">
	<?php
	$oFCKeditor = new FCKeditor('amenities') ;
	$oFCKeditor->ToolbarSet = 'Basic';
	$oFCKeditor->BasePath = 'fckeditor/' ;
	$oFCKeditor->Value = '' ;
	$oFCKeditor->Height = '400' ; 
	$oFCKeditor->Create() ;
	?>
</td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" name="enter" value="Enter location"></td>
</tr>
</form>
</table>
</div>