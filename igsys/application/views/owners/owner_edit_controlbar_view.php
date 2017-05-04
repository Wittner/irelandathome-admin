<?php foreach ($query->result() as $row): ?>
<div id="headerBar">
<!-- Control bar for general views  -->
<?= $heading ?>: <?=$row->contact_sname ;?> <?= $row->contact_fname ;?>
</div>
<div>
<!-- Control bar for property edit view with  -->
<table border="1">
<tr>
<td align="center"><a href="index.php/owners/edit_owner/<?=$row->owner_id;?>"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>
<td align="center"><a href="index.php/owners/list_properties_by_owner/<?=$row->owner_id;?>"><img src="images/app/see_more.gif" border="0" width="20" height="20" title="Show owner's properties"/></a></td>
<td align="center"><a href="index.php/owners/delete_owner/<?=$row->owner_id;?>"><img src="images/app/delete.gif" border="0" width="20" height="20" title="Delete this owner"/></a></td>
</tr>
</table>
</div>
<?php endforeach; ?>