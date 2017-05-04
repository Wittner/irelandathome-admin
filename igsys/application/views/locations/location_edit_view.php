<?php include_once("fckeditor/fckeditor.php") ; ?>
<?php foreach ($query->result() as $row): ?>
<div id="delivery">

	<table width="100%" align="center" border="1" cellpadding="2" cellspacing="2">
	<?=form_open('locations/update_location');?>
	<input type="hidden" name="townId" value="<?=$row->town_id;?>">
	<tr>
		<td width="100" class="normal" align="right"><b>Town Name:</b></td>
		<td class="normal"><input type="text" name="town_name" size="25" maxlength="25" value="<?=$row->town_name;?>"></td>
	</tr>
	
	<tr>
		<td class="normal" align="right" valign="top"><b>Amenities:</b></td>
		<td class="normal">
		<?php
		$oFCKeditor = new FCKeditor('amenities') ;
		$oFCKeditor->ToolbarSet = 'Basic';
		$oFCKeditor->BasePath = 'fckeditor/' ;
		$oFCKeditor->Value = $row->amenities ;
		$oFCKeditor->Height = '450' ;
		$oFCKeditor->Create() ;
		?>

		</td>
	</tr>
	<tr>
		<td class="normal" align="center" colspan="2"><input type="submit" name="enter" value="Update"></td>
	</tr>

	</form>
	</table>
</div>
<?php endforeach; ?>