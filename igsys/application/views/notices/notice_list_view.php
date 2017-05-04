<!-- Properties listing view -->
<div>
<?= $results; ?>
<form action="<?php echo site_url();?>/notices/add_notice" method="post">
<textarea name="notice_message" cols="50"></textarea><br />
<input type="submit" value="Add notice"/>
</form>
</div>