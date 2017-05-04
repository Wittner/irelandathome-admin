<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Admin system</title>
<base href="<?php echo base_url(); ?>" />
<!-- CSS LINKS -->
<link rel='stylesheet' type='text/css' media='all' href='iahAdminCss.css' />
<link type="text/css" href="jsfiles/jquery/css/redmond/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
<link rel='stylesheet' type='text/css' media='all' href='jsfiles/jquery/autocomplete/jquery.autocomplete.css' />

<!-- JQuery main script -->
<script type="text/javascript" src="jsfiles/jquery/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="jsfiles/jquery/jquery-ui-1.7.2.custom.min.js"></script>

<!-- JQuery plugins -->
<!-- ## Autocomplete -->
<script type="text/javascript" src="jsfiles/jquery/autocomplete/jquery.autocomplete.js"></script>

<!-- JQuery Functions includes -->

<!-- ## Site navigation -->
<script type="text/javascript" src="jsfiles/jquery/includes/navigation.js"></script>
<!-- Autocomplete stuff -->
<script type="text/javascript">
function findValue(li) {
	if( li == null ) return alert("No match!");

	// if coming from an AJAX call, let's use the CityId as the value
	if( !!li.extra ) var sValue = li.extra[0];

	// otherwise, let's just display the value in the text box
	else var sValue = li.selectValue;

	// Go directly to destination
	window.location = document.getElementById('autonavDestination').value + sValue;
}

function selectItem(li) {
	findValue(li);
}

function formatItem(row) {
	return row[0] + " (id: " + row[1] + ")";
}

function lookupAjax(){
	var oSuggest = $("#CityAjax")[0].autocompleter;

	oSuggest.findValue();

	return false;
}

function lookupLocal(){
	var oSuggest = $("#CityLocal")[0].autocompleter;

	oSuggest.findValue();

	return false;
}
</script>

<!-- My swap date js. When date is put in a 'from' field, it is automatically fed to the 'to' field -->
<script type="text/javascript">
function pushDate(x)
{
var y=document.getElementById(x).value;
document.getElementById('toDate').value=y;
}
</script>

</head>
<body>

<div id="wrapper">
<div id="titleBar">Ireland at Home administration system &copy; 2008-2009</div>
<div id="loginBar"><strong>Logged in:</strong> Mike Brady, Ireland at Home. Wednesday 15th July</div>

<!-- Ajax news start -->
<div id="newsBar">
Ticker will go here
</div>

<!-- Sales ticker begin -->
<?
$salesData = $this->sales_model->get_sales_marquee();
if ($salesData != '')
{
echo '<marquee>' . $salesData . '</marquee>';	
}
?>
<!-- Sales ticker end -->


