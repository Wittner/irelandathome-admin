<!-- Bookings listing view -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<p align="center" class="xsmall"><strong>Unpaid owners report</strong></p>

<p align="center" class="xsmall">Please choose a date range and owner for your report</p>

<table align="center" border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
      <td class="normal" valign="top">

        <p class="caption">Report from date:</p>
      </td>
      <td class="normal" valign="top">
	  <?=form_open('reports/unpaid_owners');?>
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

<td class="normal"><p class="caption">Owner:</p></td>
<td class="normal">
<select name="owner_id">
<option value="any" selected>Any</option>
<?=$ownerCombo;?>
</select>

</td>
</tr>

<tr>
<td class="normal"><p class="caption">Property:</p></td>
<td class="normal">
<select name="property_code">
<option value="any" selected>Any</option>
<?=$propertyCombo;?>
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