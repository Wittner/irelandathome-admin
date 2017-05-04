<!-- Bookings listing view -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<div>
<p align="center"><strong>Cancelled sales by arrival date report</strong></p>
<p align="center" class="xsmall">Please choose the ranges for your report</p>

<table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
<tr>
      <td class="normal" valign="top">

        <p class="caption">Report from date:</p>
      </td>
      <td class="normal" valign="top">
	  <?=form_open('reports/cancelled_sales_report');?>
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
<select name="prop_code">
<option value="any" selected>Any</option>
<?=$propertyCombo;?>
</select>
</td>
</tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Create report"></form>
</td></tr>

</table>
</div>