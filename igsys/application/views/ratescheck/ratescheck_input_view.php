<div id="delivery">
<?php
$attributes = array('style' => 'margin-bottom: 0' , 'name' => 'inputForm');
?>
<?=
form_open('ratescheck/get_rates',$attributes);
?>
<br />
Property:<br />
<select name="propertyCode">
<?=$propertyCombo;?>
</select>
<p></p>

<table>
<tr>
<td>From date:</td>

<td>
<input type="text" name="fromDate" id="fromDate" onclick="pushDate(this.id)" />
					<script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'inputForm',
						// input name
						'controlname': 'fromDate'
					});
					</script>
</td>
</tr>

<tr>
<td>To date:</td>
<td>
<input type="text" name="toDate" id="toDate" />
					<script language="JavaScript">
					new tcal ({
						// form name
						'formname': 'inputForm',
						// input name
						'controlname': 'toDate'
					});

					</script>
</td>
</tr>
</table>
<input type="submit" name="submit" value="Go" />
</form>
</div>
