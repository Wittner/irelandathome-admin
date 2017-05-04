<?php foreach ($ownerQuery->result() as $row): ?>
<div id="delivery">
<table width="830" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
<td>
<table width="830" align="center" border="0" cellpadding="0" cellspacing="0">

<td class="normal">&nbsp;</td></tr>
<tr>
<td class="normal">
	<table width="380" align="center" border="1" cellpadding="2" cellspacing="2">
	<tr>
		<td class="normal" align="center" colspan="2"><strong>Owner details</strong></td>
	</tr>
	<tr>
		<td class="normal" align="right"><b>Name:</b></td>
		<td class="normal"><?=$row->contact_fname;?> <?=$row->contact_sname;?></td>
	</tr>
	
	<tr>
		<td class="normal" align="right"><b>Address:</b></td>
		<td class="normal"><?=$row->address;?></td>
	</tr>
	
	<tr>
		<td class="normal" align="right"><b>Phone 1:</b></td>
		<td class="normal"><?=$row->phone1;?></td>
	</tr>
	
	<tr>
		<td class="normal" align="right"><b>Phone 2:</b></td>
		<td class="normal"><?=$row->phone2;?></td>
	</tr>
	
	<tr>
		<td class="normal" align="right"><b>Mobile:</b></td>
		<td class="normal"><?=$row->mobile;?></td>
	</tr>
	
	<tr>
		<td class="normal" align="right"><b>email</b></td>
		<td class="normal"><?=$row->email;?></td>
	</tr>
	</table>
</td>
</tr>
						<tr><td bgcolor="#ffffff">&nbsp;</td></tr>
	</table>
</tr>

</table>





</div>
<?php endforeach; ?>