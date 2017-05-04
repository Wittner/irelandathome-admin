<div class="Notice">
<?= $status; ?>
<?=form_open('availability/');?>
<input type="hidden" name="townId" value="<?=$townId;?>" />
<input type="hidden" name="incomingDate" value="<?=$calendarDate;?>" />
<?= form_submit('mysubmit', 'Ok!');?>
<?=form_close();?>
</div>