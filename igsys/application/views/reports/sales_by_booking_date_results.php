<!-- Bookings by date sales report results view -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<div>
<?= $results; ?>
<?=form_open('reports/sales_by_booking_date_input');?>

<p align="center"><input type="submit" value="Back" /></p>
</form>
</div>