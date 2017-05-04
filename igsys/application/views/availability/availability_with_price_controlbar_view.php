

<!-- Availability control bar view -->
<div id="availControlBar">

<!-- Control bar for availability view -->


<?php
$attributes = array('class' => 'toolbarForm', 'id' => 'searchForm1');
echo form_open('availability/view_availability_with_price', $attributes);
?>

<label class="alignTop" for="fromDate"><strong>From:</strong></label>&nbsp;
<script>DateInput('fromDate', true, 'YYYY-MM-DD')</script>
<label class="alignTop" for="fromDate"><strong>To:</strong></label>&nbsp;
<script>DateInput('toDate', true, 'YYYY-MM-DD')</script>

<label class="alignTop" for="townID"><strong>Town:</strong></label>&nbsp;
<select name="town">
	<?php echo $townsDropDown; ?>
</select>

<label class="alignTop" for="rooms"><strong>Rooms:</strong></label>&nbsp;
<select name="rooms">
	<option value="any">any</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
  	<option value="4">4</option>
  	<option value="5">5</option>
  	<option value="6">6</option>
  	<option value="7">7</option>
  	<option value="8">8</option>
  	<option value="9">9</option>
  	<option value="10">10</option>

</select>

<label class="alignTop" for="sleeps"><strong>Sleeps:</strong></label>&nbsp;
<select name="sleeps">
	<option value="any">any</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
  	<option value="4">4</option>
  	<option value="5">5</option>
  	<option value="6">6</option>
  	<option value="7">7</option>
  	<option value="8">8</option>
  	<option value="9">9</option>
  	<option value="10">10</option>
  	<option value="11">11</option>
  	<option value="12">12</option>
  	<option value="13">13</option>
  	<option value="14">14</option>
  	<option value="15">15</option>
  	<option value="16">16</option>
  	<option value="17">17</option>
  	<option value="18">18</option>
  	<option value="19">19</option>
  	<option value="20">20</option>
</select>

<label for="">Specials?: </label>
<select name="interest" style="width: 104px;" class="searchSelect" title="interest" size="1">
   <option value="any"<?php if($interest=='any'){echo ' selected';}?> >Any</option>
   <option value="pets"<?php if($interest=='pets'){echo ' selected';}?>>Pet friendly</option>
   <option value="couples"<?php if($interest=='couples'){echo ' selected';}?>>Couples</option>
   <option value="surfing"<?php if($interest=='surfing'){echo ' selected';}?>>Surfing</option>
   <option value="groups"<?php if($interest=='groups'){echo ' selected';}?>>Groups</option>
   <option value="internet"<?php if($interest=='internet'){echo ' selected';}?>>Internet</option>
   <option value="beach"<?php if($interest=='beach'){echo ' selected';}?>>Beach</option>
   <option value="apt"<?php if($interest=='apt'){echo ' selected';}?>>Apartotel</option>
   <option value="accessible"<?php if($interest=='accessible'){echo ' selected';}?>>Accessibility</option>
   <option value="golf"<?php if($interest=='golf'){echo ' selected';}?>>Golf</option>
   <option value="fishing"<?php if($interest=='fishing'){echo ' selected';}?>>Fishing</option>
  </select>

<input type="submit" value="Go!" class="button"/>
<?= form_close();?>


</div>
<!-- controlbar end -->
