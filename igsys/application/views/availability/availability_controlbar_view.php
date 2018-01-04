

<!-- Availability control bar view -->
<div id="controlBar">

	<!-- Control bar for availability view -->
	<?=form_open('availability/view_availability');?>

	<label class="alignTop"><strong>FILTERS-></strong>&nbsp;&nbsp;&nbsp;|</label>

	<label class="alignTop" for="townID"><strong>Property type:</strong></label>&nbsp;
	<select name="filter">
		<option value="All">All properties</option>
		<option value="iah" <?php if($filter === 'iah'){ echo ' selected';} ?>>IAH Managed</option>
	</select>

	<label class="alignTop" for="townID"><strong>Town:</strong></label>&nbsp;
	<select name="townId">
		<?php echo $townsDropDown; ?>
	</select>

	<label class="alignTop" for="incomingDate"><strong>Date:</strong></label>&nbsp;
	<select name="calendarDate">
		<?php echo $monthCombo; ?>
	</select>

	<label class="alignTop" for="rooms"><strong>Rooms:</strong></label>&nbsp;
	<select name="rooms">
		<option value="any" <?php if($rooms === 'any'){ echo ' selected';} ?>>any</option>
		<option value="1" <?php if($rooms === '1'){ echo ' selected';} ?>>1</option>
		<option value="2" <?php if($rooms === '2'){ echo ' selected';} ?>>2</option>
		<option value="3" <?php if($rooms === '3'){ echo ' selected';} ?>>3</option>
		<option value="4" <?php if($rooms === '4'){ echo ' selected';} ?>>4</option>
		<option value="5" <?php if($rooms === '5'){ echo ' selected';} ?>>5</option>
		<option value="6" <?php if($rooms === '6'){ echo ' selected';} ?>>6</option>
		<option value="7" <?php if($rooms === '7'){ echo ' selected';} ?>>7</option>
		<option value="8" <?php if($rooms === '8'){ echo ' selected';} ?>>8</option>
		<option value="9" <?php if($rooms === '9'){ echo ' selected';} ?>>9</option>
		<option value="10" <?php if($rooms === '10'){ echo ' selected';} ?>>10</option>

	</select>

	<label class="alignTop" for="sleeps"><strong>Sleeps:</strong></label>&nbsp;
	<select name="sleeps">
		<option value="any" <?php if($sleeps === 'any'){ echo ' selected';} ?>>any</option>
		<option value="1" <?php if($sleeps === '1'){ echo ' selected';} ?>>1</option>
		<option value="2" <?php if($sleeps === '2'){ echo ' selected';} ?>>2</option>
		<option value="3" <?php if($sleeps === '3'){ echo ' selected';} ?>>3</option>
		<option value="4" <?php if($sleeps === '4'){ echo ' selected';} ?>>4</option>
		<option value="5" <?php if($sleeps === '5'){ echo ' selected';} ?>>5</option>
		<option value="6" <?php if($sleeps === '6'){ echo ' selected';} ?>>6</option>
		<option value="7" <?php if($sleeps === '7'){ echo ' selected';} ?>>7</option>
		<option value="8" <?php if($sleeps === '8'){ echo ' selected';} ?>>8</option>
		<option value="9" <?php if($sleeps === '9'){ echo ' selected';} ?>>9</option>
		<option value="10" <?php if($sleeps === '10'){ echo ' selected';} ?>>10</option>
		<option value="11" <?php if($sleeps === '11'){ echo ' selected';} ?>>11</option>
		<option value="12" <?php if($sleeps === '12'){ echo ' selected';} ?>>12</option>
		<option value="13" <?php if($sleeps === '13'){ echo ' selected';} ?>>13</option>
		<option value="14" <?php if($sleeps === '14'){ echo ' selected';} ?>>14</option>
		<option value="15" <?php if($sleeps === '15'){ echo ' selected';} ?>>15</option>
		<option value="16" <?php if($sleeps === '16'){ echo ' selected';} ?>>16</option>
		<option value="17" <?php if($sleeps === '17'){ echo ' selected';} ?>>17</option>
		<option value="18" <?php if($sleeps === '18'){ echo ' selected';} ?>>18</option>
		<option value="19" <?php if($sleeps === '19'){ echo ' selected';} ?>>19</option>
		<option value="20" <?php if($sleeps === '20'){ echo ' selected';} ?>>20</option>
	</select>

	<label class="alignTop" for="code"><strong>Code:</strong></label>&nbsp;
	<select name="code">
		<option value="any">any</option>
		<option value="KY0">KY0</option>
		<option value="KY1">KY1</option>
		<option value="DB3G">DB3G</option>
	</select>
	<input type="submit" value="Go!" class="button"/>
	<?= form_close();?>


</div>
<!-- controlbar end -->
