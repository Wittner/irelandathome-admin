<?php foreach ($query->result() as $row): ?>
<div id="headerBar">
<!-- Control bar for general views  -->
<?= $heading ?>: <?= $row->property_name ;?>
</div>
<div>
<!-- Control bar for property edit view with  -->
<table border="1">
<tr>
<td align="center"><a href="index.php/properties/edit_property/<?=$row->property_code;?>"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>
<td align="center"><a href="index.php/owners/edit_owner/<?=$row->property_owner_id;?>"><img src="images/app/showowner.gif" border="0" width="20" height="20" title="Edit owner"/></a></td>
<td align="center"><a href="index.php/properties/show_rates/<?=$row->property_code;?>"><img src="images/app/showrates.gif" border="0" width="20" height="20" title="Edit rates"/></a></td>
</tr>
</table>
</div>
<?php endforeach; ?>