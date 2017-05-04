<!-- Customer search input  view -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<div>

<script language="JavaScript" src="calendar1.js"></script>
<p align="center"><strong>Ireland at Home search page - Customers</strong></p>

<p align="center" class="xsmall">Search by...</p>

<table align="center" width="580" border="0" cellspacing="0" cellpadding="0">

<tr>
<?=form_open('search/find_customer');?>
<?=form_hidden('fieldName', 'customer_name');?>
<td><strong>Name:</strong></td>
<td><input type="text" name="keyWord"> (Enter customer first name)</td>

<td><input type="submit" value="Search"></td>
</form>
</tr>

<tr>
<?=form_open('search/find_customer');?>
<?=form_hidden('fieldName', 'customer_surname');?>
<td><strong>Surname:</strong></td>
<td><input type="text" name="keyWord"> (Enter customer surname)</td>
<td><input type="submit" value="Search"></td>
</form>
</tr>

<tr>
<?=form_open('search/find_customer');?>
<?=form_hidden('fieldName', 'customer_number');?>
<form name="customer_search" action="search_customers.php" method="post">
<td><strong>Customer number</strong></td>
<td><input type="text" name="keyWord"> (Enter customer number)</td>
<td><input type="submit" value="Search"></td>
</form>
</tr>



<tr>
<?=form_open('search/find_customer');?>
<?=form_hidden('fieldName', 'customer_email');?>
<td><strong>Email</strong></td>
<td><input type="text" name="keyWord"> (Enter customer email)</td>
<td><input type="submit" value="Search"></td>
</form>
</tr>

</table>
</div>