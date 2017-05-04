<!-- Customer search input  view -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<div>

<p align="center"><strong>Ireland at Home search page - Sales</strong></p>

<p align="center" class="xsmall">Search sales by...</p>

<table align="center" width="580" border="0" cellspacing="0" cellpadding="0">
<tr>
<?=form_open('search/find_sales');?>
<?=form_hidden('searchBy', 'name');?>
<td><strong>Name:</strong></td>
<td><input type="text" name="kwd"> (Enter customer first name)</td>

<td><input type="submit" value="Go"></td>
</form>
</tr>

<tr>
<?=form_open('search/find_sales');?>
<?=form_hidden('searchBy', 'surname');?>
<td><strong>Surname:</strong></td>
<td><input type="text" name="kwd"> (Enter customer surname)</td>
<td><input type="submit" value="Go"></td>
</form>
</tr>

<tr>

<?=form_open('search/find_sales');?>
<?=form_hidden('searchBy', 'cusno');?>
<td><strong>Customer number:</strong></td>
<td><input type="text" name="kwd"> (Enter customer number)</td>
<td><input type="submit" value="Go"></td>
</form>
</tr>

<tr>
<?=form_open('search/find_sales');?>
<?=form_hidden('searchBy', 'bookno');?>
<td><strong>Booking number:</strong></td>
<td><input type="text" name="kwd"> (Enter booking number)</td>

<td><input type="submit" value="Go"></td>
</form>
</tr>


<tr>
<?=form_open('search/find_sales');?>
<?=form_hidden('searchBy', 'cusref');?>
<td><strong>Owner reference:</strong></td>
<td><input type="text" name="kwd"> (Enter owner reference)</td>
<td><input type="submit" value="Go"></td>
</form>
</tr>

<tr>
<?=form_open('search/find_sales');?>
<?=form_hidden('searchBy', 'book_id');?>
<td><strong>Sales/Booking id:</strong></td>
<td><input type="text" name="kwd"> (Enter booking id)</td>
<td><input type="submit" value="Go"></td>
</form>
</tr>

<tr>
<?=form_open('search/find_sales');?>
<?=form_hidden('searchBy', 'rx_trans_id');?>
<td><strong>Realex Number:</strong></td>
<td><input type="text" name="kwd"> (Realex No.)</td>
<td><input type="submit" value="Go"></td>
</form>

</tr>

<tr>
<?=form_open('search/find_sales');?>
<?=form_hidden('searchBy', 'referrer');?>
<td><strong>Referrer:</strong></td>
<td>
<select name="kwd">
<option value="">Any</option>
<?=$referallCombo;?>
</select>
</td>
<td><input type="submit" value="Go"></td>

</form>
</tr>

<tr>
<?=form_open('search/find_sales');?>
<?=form_hidden('searchBy', 'property');?>
<td><strong>Property:</strong></td>
<td>
<select name="kwd">
<option value="">Any</option>
<?=$propertyCombo;?>
</select></td>

<td><input type="submit" value="Go"></td>
</form>
</tr>

</table>

</div>