<div id="delivery">
<table border="0" width="100%" align="center" cellpadding="2" cellspacing="0" bgcolor="#E6F7FF">
<tr>

<? $attributes = array('name' => 'create_manual_sale_view', 'id' => 'create_manual_sale_view');?>
<?= form_open('properties/add_property',$attributes);?>

<td  class="normal">

<table border="0" width="826" align="center">
<form method="post" name="customer_submit" action="property_add_action.php">
<tr><td class="normal" align="center" colspan="2"><strong>BACKGROUND INFORMATION</strong></td></tr>
<tr><td align="right" class="normal"><b>Property Name:</b></td><td class="normal"><input type="text" name="property_name" size="45" maxlength="50"></td></tr>
<tr><td align="right" class="normal"><b>Property Code:</b></td><td class="normal"><input type="text" name="property_code" size="25" maxlength="25"></td></tr>
<tr><td align="right" class="normal"><b>Owner</b></td><td class="normal">

<select name="property_owner_id">
<?= $ownerCombo ;?>
</select></td></tr>

<tr><td align="right" class="normal" valign="top"><b>Caretaker name:</b></td><td class="normal"><input type="text" name="caretaker_name"></td></tr>
<tr><td align="right" class="normal" valign="top"><b>Caretaker number:</b></td><td class="normal"><input type="text" name="caretaker_number"></td></tr>


<tr><td align="right" class="normal" valign="top"><b>Property Address:</b></td><td class="normal"><textarea cols="25" rows="4" name="property_address"></textarea></td></tr>

<tr><td align="right" class="normal" valign="top"><b>Directions:</b></td><td class="normal"><textarea cols="25" rows="4" name="property_directions"></textarea></td></tr>
<tr><td align="right" class="normal"><b>Country</b></td><td class="normal">
<select name="country_id">
<option value="IRL" selected>Ireland</option>
<option value="ENG">England</option>
<option value="FRA">France</option>
<option value="GER">Germany</option>
<option value="HOL">Holland</option>
<option value="ITA">Italy</option>

<option value="POR">Portugal</option>
<option value="SCO">Scotland</option>
<option value="SPN">Spain</option>
<option value="WAL">Wales</option>
<option value="SA">South Africa</option>
</select>
</td>
</tr>
<tr><td align="right" class="normal"><b>Town:</b></td><td class="normal">
<select name="property_town_id">
<?= $townCombo; ?>
</select></td></tr>

<tr>
	<td align="right" class="normal"><b>Status (Live/Not Live):</b></td>
	<td class="normal">
    	<select name="property_status">
        	<option value="LVE">Live</option>
            <option value="OFF" selected>Not Live</option>
         </select>
     </td>
 </tr>

<tr>
<td align="right" class="normal"><b>Standard</b></td>
<td class="normal">
	<select name="property_standard">
	    <option value="0" selected>No star</option>
	    <option value="1">1 Star</option>
	    <option value="2">2 Stars</option>
	    <option value="3">3 Stars</option>
	    <option value="4">4 Stars</option>

	    <option value="5">5 Stars</option>
	</select>
</td>
</tr>

<tr>
	<td align="right" class="normal"><b>Capacity:</b></td class="normal">
	<td  class="normal"><input type="text" name="property_capacity"></td>
</tr>

<tr>
	<td align="right" class="normal"><b>Bedrooms:</b></td class="normal">
	<td  class="normal"><input type="text" name="property_bedrooms"></td>
</tr>

<tr>
	<td colspan="2" align="center"><input type="submit" name="enter" value="Enter property"></td>
</tr>

</form>
</table>
</td></tr>
<tr><td bgcolor="#ffffff">&nbsp;</td></tr>
</table>

</tr>

</table>




</td>
</tr>
</body>
</html>


</div>