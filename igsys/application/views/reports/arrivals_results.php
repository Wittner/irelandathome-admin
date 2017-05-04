<!-- Bookings by date sales report results view -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<div>
<?php $emailResult = base64_encode($results);?>
<?= $results; ?>
<?=form_open('reports/arrivals_input');?>
<p align="center"><input type="submit" value="Back" /></p>
</form>
</div>