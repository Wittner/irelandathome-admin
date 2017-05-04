<!-- Rates result view -->
<div id="headerBar">Now viewing: <?= $heading ;?> for <?=$propertyName;?></div>

<div>
<?=$ratesTable;?><br />
<b>From:</b> <?=$fromDate;?><br />
<b>To:</b> <?=$toDate;?><br />
<b>Nights:</b> <?=$nights;?><br />


<table border="1">
<tr><th>Rate Id</th><th>From period</th><th>To period</th><th>Weeks</th><th>Nights</th><th>Price</th><th>Running total</th></tr>
<?= $results; ?>
</table>
<a href="index.php/ratescheck">BACK</a>
</div>