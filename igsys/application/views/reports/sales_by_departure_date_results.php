<!-- Bookings by date sales report results view -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<div>
<?= $results; ?>
<?=form_open('reports/sales_by_departure_date_input');?>

<p align="center"><input type="submit" value="Back" /></p>
</form>
</div>
