<?php foreach ($query->result() as $row): ?>
<div id="delivery">
<table width="830" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>
<table width="830" align="center" border="0" cellpadding="0" cellspacing="0">

<td class="normal">&nbsp;</td></tr>
<tr>
<td class="normal">
	<table width="380" align="center" border="0" cellpadding="0" cellspacing="0">
	<?=form_open('owners/update_owner');?>
	<input type="hidden" name="owner_id" value="<?=$row->owner_id;?>">
	<tr>
		<td class="normal" align="center" colspan="2"><strong>Please change owner details</strong></td>
	</tr>
	<tr>
		<td class="normal" align="right"><b>First Name:</b></td>
		<td class="normal"><input type="text" name="contact_fname" size="25" maxlength="25" value="<?=$row->contact_fname;?>"></td>
	</tr>
	
	<tr>
		<td class="normal" align="right"><b>Last Name:</b></td>
		<td class="normal"><input type="text" name="contact_sname" value="<?=$row->contact_sname;?>"></td>
	</tr>
	
	<tr>
		<td class="normal" align="right"><b>Address:</b></td>
		<td class="normal"><textarea cols="25" rows="4" name="address"><?=$row->address;?></textarea></td>
	</tr>
	
	<tr>
		<td class="normal" align="right"><b>Phone 1:</b></td>
		<td class="normal"><input type="text" name="phone1" value="<?=$row->phone1;?>"></td>
	</tr>
	
	<tr>
		<td class="normal" align="right"><b>Phone 2:</b></td>
		<td class="normal"><input type="text" name="phone2" value="<?=$row->phone2;?>"></td>
	</tr>
	
	<tr>
		<td class="normal" align="right"><b>Mobile:</b></td>
		<td class="normal"><input type="text" name="mobile" value="<?=$row->mobile;?>"></td>
	</tr>
	
	<tr>
		<td class="normal" align="right"><b>email</b></td>
		<td class="normal"><input type="text" name="email" value="<?=$row->email;?>" size="45"></td>
	</tr>
	
	<tr>
		<td class="normal" align="center" colspan="2"><input type="submit" name="enter" value="Update"></td>
	</tr>

	</form>
	</table>
</td>
</tr>
						<tr><td bgcolor="#ffffff">&nbsp;</td></tr>
	</table>
</tr>

</table>





</div>
<?php endforeach; ?>