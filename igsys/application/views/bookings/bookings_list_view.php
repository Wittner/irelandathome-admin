<!-- Bookings listing view -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>


<?php if($status == 'deposit_paid' || $status == 'owner_paid' || $status == 'instructions_sent')
{

echo '
<div id="controlBar">
<!-- ' . $sqlCode . '-->
 <form name="filter" action="index.php/booking/list_bookings/' . $status . '" method="post" >
 <strong>Filter arrival date by Month:</strong>
	<select name="month">
	'   . $selectedMonth .'
		<option value="01">Jan</option>
		<option value="02">Feb</option>
		<option value="03">Mar</option>
		<option value="04">Apr</option>
		<option value="05">May</option>
		<option value="06">Jun</option>
		<option value="07">Jul</option>
		<option value="08">Aug</option>
		<option value="09">Sep</option>
		<option value="10">Oct</option>
		<option value="11">Nov</option>
		<option value="12">Dec</option>
	</select>
  Year:
    <select name="year">
    '   . $yearCombo . '
	</select>
   <input type="submit" name="submit" value="Apply filter" />
 </form>
	</div>
';
}
?>

<div>
<?= $results; ?>
</div>