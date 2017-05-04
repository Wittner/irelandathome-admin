<!-- Overdue balances report results view -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<div>
<?= $results; ?>
<?=form_open('reports/overdue_balances');?>

<p align="center"><input type="submit" value="Back" /></p>
</form>
</div>