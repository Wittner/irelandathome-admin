<?php include_once("fckeditor/fckeditor.php") ; ?>

<?php
$propertyCombo = $this->property_model->get_property_combo('');
?>

<div id="delivery">
<table border="0" width="100%" align="center" cellpadding="2" cellspacing="0" bgcolor="#E6F7FF">

<?= form_open('promotions/add_promotion');?>

<tr>
<td class="normal" valign="top">
Property<br />
	<select name="promotionPropertyCode">
		<?=$propertyCombo;?>
	</select>
</td>
</tr>

<tr>
<td class="wtback" valign="top">Description<br />
		<?php
		$oFCKeditor = new FCKeditor('promotionDescription') ;
		$oFCKeditor->ToolbarSet = 'Basic';
		$oFCKeditor->BasePath = 'fckeditor/' ;
		$oFCKeditor->Height = '400' ;
		$oFCKeditor->Create() ;
		?>
</td>
</tr>

<tr>
<td class="normal" align="right">
<input type="submit" name="proceed" value="Add this promotion" />
</td>
</form>
</td>
</tr>

<tr>
<td align="right">
<? $attributes = array('name' => 'goBack', 'id' => 'goBack', 'style' => 'display:inline;');?>
<?= form_open('promotions/list_promotions',$attributes);?>
<input type="submit" name="proceed" value="Cancel" />
</form>
</td>
</tr>


<tr>
<td class="wtback" valign="top">&nbsp;</td>
</tr>

</table>
</div>