<!-- Bookings listing view -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<div>
<p align="center"><strong>Sales Report by booking date</strong></p>
<p align="center" class="xsmall">Please choose a booking date range and owner for your report</p>

<table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
      <td class="normal" valign="top">

        <p class="caption">Report from date:</p>
      </td>
      <td class="normal" valign="top">
	  <?=form_open('reports/sales_report_by_booking_date');?>
      <p><script>DateInput('fromDate', true, 'YYYY-MM-DD')</script></p>
      </td>
    </tr>
    <tr>

      <td class="normal" valign="top">
        <p class="caption">Report to date:</p>
      </td>
      <td class="normal" valign="top">
	  <p><script>DateInput('toDate', true, 'YYYY-MM-DD')</script></p>
      </td>
    </tr>

<tr>

<td class="normal"><p class="caption">Filter by owner:</p></td>
<td class="normal">
<select name="owner_id">
<option value="any" selected>Any</option>
<?=$ownerCombo; ?>
</select>
</td>
</tr>

<tr>
<td class="normal"><p class="caption">Filter by property:</p></td>
<td class="normal">
<select name="property_code">
<option value="any" selected>Any</option>
<?=$propertyCombo;?>
</select>
</td>
</tr>

<tr>
<td class="normal"><p class="caption">Filter by customer country:</p></td>
<td class="normal">
<select name="country_name">
	<option value="any">Any</option>
	<?php echo $countryCombo; ?>
</select>
</td>
</tr>

<tr>
<td class="normal"><p class="caption">Filter by referrer:</p></td>
<td class="normal">
<select name="referrer">
<option value="any" selected>Any</option>
<?=$referallCombo;?>
</select>
</td>
</tr>

<tr>
<td class="normal"><p class="caption">Filter by source:</p></td>
<td class="normal">
<select name="source_code">
<option value="any" selected>Any</option>
<option value="IAH">Ireland at Home</option>
<option value="CHH">Cork Holiday Homes</option>
<option value="KHH">Kerry at Home</option>

<option value="GHH">Galway at Home</option>
<option value="CLHH">Clare at Home</option>
<option value="WHH">Wexford at Home</option>
<option value="DHH">Donegal at Home</option>
</select>
</td>
</tr>

<tr>
<td class="normal"><p class="caption">For admins only, enter password:</p></td>
<td class="normal">
<input type ="password" name="pass" />
</td>
</tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Create report"></form>
</td></tr>

</table>
</div>
