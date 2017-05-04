<?php
$this->load->model('global_model');
$news_data = $this->global_model->get_company_data();
$company_name = $news_data['name'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Admin system</title>
<base href="<?php echo base_url();?>" />

<!-- CSS Files -->
<link rel='stylesheet' type='text/css' media='all' href='iahAdminCss.css' />
<link rel='stylesheet' type='text/css' media='all' href='jsfiles/jquery/autocomplete/jquery.autocomplete.css' />
<link rel="stylesheet" href="menu_navigation_files/cbcscbmenu_navigation.css" type="text/css" />
<link href="jsfiles/tcalendar/calendar.css" rel="stylesheet" type="text/css" />

<!-- JQUERY -->
<script type="text/javascript" src="jsfiles/jquery/jquery-1.2.2.pack.js"></script>

<!-- JQuery Plugins -->
<!--	Animated divs -->
			<script type="text/javascript" src="jsfiles/jquery/animatedcollapse/animatedcollapse.js"></script>
<!-- 	JQuery news scroller (carouselle) -->
			<script src="jsfiles/jquery/scroller/jcarousellite_1.0.1c4.js" type="text/javascript"></script>
<!-- 	Autocomplete -->
			<script type="text/javascript" src="jsfiles/jquery/autocomplete/jquery.autocomplete.js"></script>

<!-- Jason moon calendar -->
<script type="text/javascript" src="jsfiles/calendar/calendarDateInput.js"></script>
<!-- Tigra calendar -->
<!-- Removed -->
<!-- Pop up calendar -->
<script type="text/javascript" src="jsfiles/calendar/calendarDateInput.js" /></script>

<!-- JavaScript functions -->

<script type="text/javascript">
	/* book availability div */
	animatedcollapse.addDiv('booknow', 'fade=1,height=50px')
	animatedcollapse.init()
</script>
<script type="text/javascript">
	/* release availability div */
	animatedcollapse.addDiv('releasenow', 'fade=1,height=50px')
	animatedcollapse.init()
</script>

<!-- My swap date js. When date is put in a 'from' field, it is automatically fed to the 'to' field -->
<script type="text/javascript">
	function pushDate(x)
	{
		var y=document.getElementById(x).value;
		document.getElementById('toDate').value=y;
		}
</script>

 <script type="text/javascript">
 $(function() {
 $(".newsticker-jcarousellite").jCarouselLite({
         vertical: true,
         visible: 1,
         auto:5000,
         speed:1000
     });
 });
 </script>

<!-- JQuery inhouse code -->
<script type="text/javascript" src="jsfiles/main.js"></script>

</head>

<!-- Start of body -->
<body>

<div id="wrapper">
<div id="titleBar"><?php echo $company_name; ?> administration system &copy; <?php echo date('Y');?></div>
<div id="loginBar"><strong>Logged in:</strong> <?php echo $this->session->userdata('admin_name'); ?>, <?php echo $company_name; ?>. <?php echo date('l jS M Y ');?></div>

<!-- News bar -->
<div id="newsBar">
<!-- There is a thumbnail div class for small images and a title class for a main title div -->
    <div class="newsticker-jcarousellite">
		<ul>
            <li>
                <div class="info">
				Please refresh your browsers to see the news feed properly, (no need to log out) thanks
				<span class="cat">From: Mike 10:04 20th October 2009</span>
				</div>
				<div class="clear"></div>
			</li>
            <li>
                <div class="info">
                Please refresh your browsers to see the news feed properly, (no need to log out) thanks
				<span class="cat">From: Ian 10:04 20th October 2009</span>
				</div>
				<div class="clear"></div>
			</li>
   			<li>
                <div class="info">
                Please refresh your browsers to see the news feed properly, (no need to log out) thanks
				<span class="cat">From: Lynda 10:04 20th October 2009</span>
				</div>
				<div class="clear"></div>
			</li>
        </ul>
    </div>

</div>
<!-- End of News bar -->

<!-- Sales ticker begin -->
<?php
$salesData = $this->sales_model->get_sales_marquee();
if ($salesData != '')
{
echo '<marquee>' . $salesData . '</marquee>';	
}
?>
<!-- Sales ticker end -->

<!-- Drop down menu begin -->
<div id="menuBar">
<ul id="ebul_cbmenu_navigation_2" class="ebul_cbmenu_navigation" style="display: none;">
<li><a href="index.php/sales/create_manual_sale" title="">Create sale</a></li>
<li><a title="">Find</a>
  <ul id="ebul_cbmenu_navigation_2_2">
  <li><a href="index.php/search/customer_search_input" title="">Customers</a></li>
  <li><a href="index.php/search/sales_search_input" title="">Sales</a></li>
  </ul></li>
<li><a href="index.php/specials/list_offers" title="">Special offers</a></li>
<li><a href="index.php/promotions/list_promotions" title="">Promotions</a></li>
<li><a href="index.php/specials/list_late_availability" title="">Late availability</a></li>
<li><a href="index.php/notices/list_notifications" title="">Notifications</a></li>
<li><a href="index.php/favourites/list_favourites" title="">Favourites</a></li>
<li><a href="index.php/comms/send_sms" title="">Send message</a></li>
<li><a href="send_sms.php" title=""></a></li>
</ul>
<ul id="ebul_cbmenu_navigation_3" class="ebul_cbmenu_navigation" style="display: none;">
<li><a href="index.php/enquiries" title="">Latest Queries</a></li>
</ul>
<ul id="ebul_cbmenu_navigation_4" class="ebul_cbmenu_navigation" style="display: none;">
<li><a href="index.php/sales/list_sales" title="">Latest</a></li>
<li><a href="index.php/booking/list_bookings/reference_pending" title="">Reference pending</a></li>
<li><a href="index.php/booking/list_bookings/deposit_paid" title="">Outstanding balances</a></li>
<li><a href="index.php/booking/list_bookings/paid_in_full" title="">Zero balances</a></li>
<li><a href="index.php/booking/list_bookings/reference_obtained" title="">Reference obtained</a></li>
<li><a href="index.php/booking/list_bookings/instructions_sent" title="">Instructions sent</a></li>
<li><a href="index.php/booking/list_bookings/owner_paid" title="">Owner paid</a></li>
<li><a href="index.php/booking/list_bookings/customer_credit" title="">Plus balances</a></li>
<li><a href="index.php/booking/list_bookings/cancelled" title="">Cancelled</a></li>
<li><a href="index.php/booking/list_bookings/vouchers" title="">Vouchers</a></li>
</ul>
<ul id="ebul_cbmenu_navigation_5" class="ebul_cbmenu_navigation" style="display: none;">
<li><a href="index.php/customers/list_customers" title="">List customers</a></li>
<li><a href="index.php/customers/add_customer_input" title="">Add new customer</a></li>
</ul>
<ul id="ebul_cbmenu_navigation_6" class="ebul_cbmenu_navigation" style="display: none;">
<li><a href="index.php/availability" title="">Check availability</a></li>
</ul>
<ul id="ebul_cbmenu_navigation_7" class="ebul_cbmenu_navigation" style="display: none;">
<li><a href="index.php/properties/list_properties/live" title="">List properties</a></li>
<li><a href="index.php/properties/add_property_input" title="">Add property</a></li>
<li><a href="index.php/properties/search_properties_input" title="">Property search</a></li>
</ul>
<ul id="ebul_cbmenu_navigation_8" class="ebul_cbmenu_navigation" style="display: none;">
<li><a href="index.php/owners/list_owners" title="">List owners</a></li>
<li><a href="index.php/owners/add_owner_input" title="">Add owners</a></li>
</ul>
<ul id="ebul_cbmenu_navigation_9" class="ebul_cbmenu_navigation" style="display: none;">
<li><a href="index.php/locations/list_locations" title="">List locations</a></li>
<li><a href="index.php/locations/add_location_input" title="">Add locations</a></li>
</ul>
<ul id="ebul_cbmenu_navigation_10" class="ebul_cbmenu_navigation" style="display: none;">
<li><a href="index.php/reports/arrivals_input" title="">Arrivals</a></li>
<li><a href="index.php/reports/sales_by_arrival_date_input" title="">Sales report (X arrival date)</a></li>
<li><a href="index.php/reports/sales_by_booking_date_input" title="">Sales report (X booking date)</a></li>
<li><a href="index.php/reports/cancelled_sales_input" title="">Cancelled sales (X arrival date)</a></li>
<li><a href="index.php/reports/cancelled_sales_booking_input" title="">Cancelled sales (X booking date)</a></li>
<li><a href="index.php/reports/unpaid_owners_input" title="">Unpaid owners</a></li>
<li><a href="index.php/reports/overdue_balances" title="">Balances overdue</a></li>
<li><a href="index.php/reports/bookings_by_origin_input" title="">Bookings by origin</a></li>
</ul>

<ul id="cbmenu_navigationebul_table" class="cbmenu_navigationebul_menulist" style="width: 891px; height: 26px;">
  <li class="spaced_li"><a href="index.php/login" target="_top"><img id="cbi_cbmenu_navigation_1" src="menu_navigation_files/ebbtcbmenu_navigation1_0.gif" name="ebbcbmenu_navigation_1" width="76" height="26" style="vertical-align: bottom;" border="0" alt="LOGOUT" title="" /></a></li>
  <li class="spaced_li"><a><img id="cbi_cbmenu_navigation_2" src="menu_navigation_files/ebbtcbmenu_navigation2_0.gif" name="ebbcbmenu_navigation_2" width="69" height="26" style="vertical-align: bottom;" border="0" alt="TOOLS" title="" /></a></li>
  <li class="spaced_li"><a><img id="cbi_cbmenu_navigation_3" src="menu_navigation_files/ebbtcbmenu_navigation3_0.gif" name="ebbcbmenu_navigation_3" width="82" height="26" style="vertical-align: bottom;" border="0" alt="QUERIES" title="" /></a></li>
  <li class="spaced_li"><a><img id="cbi_cbmenu_navigation_4" src="menu_navigation_files/ebbtcbmenu_navigation4_0.gif" name="ebbcbmenu_navigation_4" width="68" height="26" style="vertical-align: bottom;" border="0" alt="SALES" title="" /></a></li>
  <li class="spaced_li"><a><img id="cbi_cbmenu_navigation_5" src="menu_navigation_files/ebbtcbmenu_navigation5_0.gif" name="ebbcbmenu_navigation_5" width="104" height="26" style="vertical-align: bottom;" border="0" alt="CUSTOMERS" title="" /></a></li>
  <li class="spaced_li"><a><img id="cbi_cbmenu_navigation_6" src="menu_navigation_files/ebbtcbmenu_navigation6_0.gif" name="ebbcbmenu_navigation_6" width="115" height="26" style="vertical-align: bottom;" border="0" alt="AVAILABILITY" title="" /></a></li>
  <li class="spaced_li"><a><img id="cbi_cbmenu_navigation_7" src="menu_navigation_files/ebbtcbmenu_navigation7_0.gif" name="ebbcbmenu_navigation_7" width="93" height="26" style="vertical-align: bottom;" border="0" alt="PROPERTY" title="" /></a></li>
  <li class="spaced_li"><a><img id="cbi_cbmenu_navigation_8" src="menu_navigation_files/ebbtcbmenu_navigation8_0.gif" name="ebbcbmenu_navigation_8" width="82" height="26" style="vertical-align: bottom;" border="0" alt="OWNERS" title="" /></a></li>
  <li class="spaced_li"><a><img id="cbi_cbmenu_navigation_9" src="menu_navigation_files/ebbtcbmenu_navigation9_0.gif" name="ebbcbmenu_navigation_9" width="99" height="26" style="vertical-align: bottom;" border="0" alt="LOCATIONS" title="" /></a></li>
  <li><a><img id="cbi_cbmenu_navigation_10" src="menu_navigation_files/ebbtcbmenu_navigation10_0.gif" name="ebbcbmenu_navigation_10" width="94" height="26" style="vertical-align: bottom;" border="0" alt="REPORTS" title="" /></a></li>
</ul>
<script type="text/javascript" src="menu_navigation_files/cbjscbmenu_navigation.js"></script>
</div>
<!-- Drop down menu end -->

<!-- JQuery Autocomplete -->
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