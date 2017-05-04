<?php include_once("fckeditor/fckeditor.php") ; ?>
<?php foreach($query->result() as $row): ?>

<?php
$propertyCombo = $this->property_model->get_property_combo_with_selected($row->promotionPropertyCode);
?>

<div id="delivery">
<table border="0" width="100%" align="center" cellpadding="2" cellspacing="0" bgcolor="#E6F7FF">

<? $attributes = array('name' => 'edit_promotion_view', 'id' => 'edit_promotion_view');?>
<?= form_open('promotions/update_promotion',$attributes);?>
<?= form_hidden('promotionId', $row->promotionId);?>

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
		$oFCKeditor->Value = $row->promotionDescription ;
		$oFCKeditor->Height = '400' ;
		$oFCKeditor->Create() ;
		?>
</td>
</tr>

<tr>
<td class="normal" align="right">
<input type="submit" name="proceed" value="Update" />
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
<?php endforeach; ?>