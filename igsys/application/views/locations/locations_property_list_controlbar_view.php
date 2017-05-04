<?php foreach ($query->result() as $row): ?>
<div id="headerBar">
<!-- Control bar for general views  -->
<?= $heading ?>: <?=$row->town_name ;?>
</div>
<div>
<!-- Control bar for property edit view with  -->
<table border="1">
<tr>
<td align="center"><a href="index.php/locations/edit_location/<?=$row->town_id;?>"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this location"/></a></td>
</tr>
</table>
</div>
<?php endforeach; ?>