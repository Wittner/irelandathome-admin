<?php foreach ($query->result() as $row): ?>
<table border="1" width="680" align="left">
<form name="notices" action="<?php echo site_url();?>/notices/update_notice" method="post">
<input type="hidden" name="notice_id" value="<? echo $row->notice_id;?>">

<tr>
<td valign="top"><strong>Message:</strong></td>
<td valign="top"><textarea name="notice_message" cols="50" rows="8"><?echo $row->notice_message; ?></textarea></td>
</tr>

<tr>
<td colspan="2" align="center" valign="top"><input type="submit" name="submit" value="Update notice"</td>
</tr>

</form>

</table>
<?php endforeach; ?>