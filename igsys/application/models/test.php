<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Admin system</title>
<base href="http://localhost/sites/iah-2009/acc_admin/" />
<link rel='stylesheet' type='text/css' media='all' href='iahAdminCss.css' />
<!-- Nav menu -->
<link rel="stylesheet" href="menu_navigation_files/cbcscbmenu_navigation.css" type="text/css" />

<!-- News ticker -->
<script src="jsfiles/news_ticker/ajaxticker.js" type="text/javascript">
/***********************************************
* Ajax Ticker script (txt file source)- © Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for this script and 100s more.
***********************************************/
</script>

<!-- Animated divs -->
<script type="text/javascript" src="jsfiles/jquery-1.2.2.pack.js"></script>
<script type="text/javascript" src="jsfiles/animatedcollapse.js">
/***********************************************
* Animated Collapsible DIV v2.0- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/
</script>
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


<!-- Jason moon calendar -->
<script type="text/javascript" src="jsfiles/calendar/calendarDateInput.js"></script>

<!-- Tigra calendar -->
<link href="jsfiles/tcalendar/calendar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jsfiles/tcalendar/calendar_eu.js">
<!-- Pop up calendar -->
<script type="text/javascript" src="jsfiles/calendar/calendarDateInput.js">
/***********************************************
* Jason's Date Input Calendar- By Jason Moon http://calendar.moonscript.com/dateinput.cfm
* Script featured on and available at http://www.dynamicdrive.com
* Keep this notice intact for use.
***********************************************/
</script>

<!-- My swap date js. When date is put in a 'from' field, it is automatically fed to the 'to' field -->
<script type="text/javascript">
function pushDate(x)
{
var y=document.getElementById(x).value;
document.getElementById('toDate').value=y;
}
</script>
<!-- -->

</head>
<body>

<div id="wrapper">
<div id="titleBar">Ireland at Home administration system &copy; 2008-2009</div>
<div id="loginBar"><strong>Logged in:</strong> Mike Brady, Ireland at Home. Wednesday 15th July</div>

<!-- Ajax news start -->
<div id="newsBar">
<script type="text/javascript">
var xmlfile="news/tickercontent.txt" //path to ticker txt file on your server.
//ajax_ticker(xmlfile, divId, divClass, delay, optionalfadeornot)
new ajax_ticker(xmlfile, "ajaxticker1", "someclass", 3500, "fade")
</script>
</div>
<!-- Ajax news end -->

<!-- Sales ticker begin -->
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
<li><a href="index.php/specials/list_late_availability" title="">Late availability</a></li>
<li><a href="index.php/notices/list_notifications" title="">Notifications</a></li>
<li><a href="index.php/favourites/list_favourites" title="">Favourites</a></li>
<li><a href="index.php/comms/send_sms" title="">Send message</a></li>
<li><a href="send_sms.php" title=""></a></li>
</ul>
<ul id="ebul_cbmenu_navigation_3" class="ebul_cbmenu_navigation" style="display: none;">
<li><a href="index.php" title="">Latest Queries</a></li>
</ul>
<ul id="ebul_cbmenu_navigation_4" class="ebul_cbmenu_navigation" style="display: none;">
<li><a href="index.php/sales/list_sales" title="">Latest</a></li>
<li><a href="index.php/booking/list_bookings/reference_pending" title="">Reference pending</a></li>
<li><a href="index.php/booking/list_bookings/deposit_paid" title="">Outstanding balances</a></li>
<li><a href="index.php/booking/list_bookings/paid_in_full" title="">Zero balances</a></li>
<li><a href="index.php/booking/list_bookings/reference_obtained" title="">Reference obtained</a></li>
<li><a href="index.php/booking/list_bookings/instructions_sent" title="">Instructions sent</a></li>
<li><a href="index.php/booking/list_bookings/owner_paid" title="">Owner paid</a></li>
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
<li><a href="index.php/properties/list_properties" title="">List properties</a></li>
<li><a href="index.php/properties/add_property_input" title="">Add property</a></li>
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
<li><a href="index.php/reports/unpaid_owners_input" title="">Unpaid owners</a></li>
<li><a href="index.php/reports/overdue_balances" title="">Balances overdue</a></li>
</ul>

<ul id="cbmenu_navigationebul_table" class="cbmenu_navigationebul_menulist" style="width: 891px; height: 26px;">
  <li class="spaced_li"><a href="index.php/admin/logout" target="_top"><img id="cbi_cbmenu_navigation_1" src="menu_navigation_files/ebbtcbmenu_navigation1_0.gif" name="ebbcbmenu_navigation_1" width="76" height="26" style="vertical-align: bottom;" border="0" alt="LOGOUT" title="" /></a></li>
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

<!-- Rates result view -->
<div id="headerBar">Now viewing: Rates for Bayview Lodge</div>

<div>

		<table width="100%" border="1">
		<tr><th>Rate Id</th><th>Property</th><th>From</th><th>To</th><th>1 night</th><th>2 nights</th><th>3 nights</th><th>4 nights</th><th>5 nights</th><th>6 nights</th><th>1 week</th><th>Xtra night</th></tr><tr><td>135</td><td>JAIA01</td><td>01-01-2009</td><td>03-04-2009</td><td>350.00</td><td>350.00</td><td>370.00</td><td>375.00</td><td>383.00</td><td>400.00</td><td>450.00</td><td>65.00</td></tr><tr><td>136</td><td>JAIA01</td><td>04-04-2009</td><td>17-04-2009</td><td>600.00</td><td>600.00</td><td>600.00</td><td>600.00</td><td>600.00</td><td>600.00</td><td>600.00</td><td>50.00</td></tr><tr><td>137</td><td>JAIA01</td><td>18-04-2009</td><td>30-04-2009</td><td>400.00</td><td>400.00</td><td>420.00</td><td>425.00</td><td>433.00</td><td>450.00</td><td>500.00</td><td>50.00</td></tr><tr><td>138</td><td>JAIA01</td><td>01-05-2009</td><td>03-05-2009</td><td>500.00</td><td>500.00</td><td>500.00</td><td>500.00</td><td>500.00</td><td>500.00</td><td>500.00</td><td>500.00</td></tr><tr><td>139</td><td>JAIA01</td><td>04-05-2009</td><td>08-05-2009</td><td>400.00</td><td>400.00</td><td>420.00</td><td>425.00</td><td>433.00</td><td>450.00</td><td>500.00</td><td>50.00</td></tr><tr><td>188</td><td>JAIA01</td><td>09-05-2009</td><td>28-05-2009</td><td>450.00</td><td>450.00</td><td>480.00</td><td>488.00</td><td>500.00</td><td>525.00</td><td>600.00</td><td>50.00</td></tr><tr><td>140</td><td>JAIA01</td><td>29-05-2009</td><td>31-05-2009</td><td>600.00</td><td>600.00</td><td>600.00</td><td>600.00</td><td>600.00</td><td>600.00</td><td>600.00</td><td>50.00</td></tr><tr><td>141</td><td>JAIA01</td><td>01-06-2009</td><td>12-06-2009</td><td>450.00</td><td>450.00</td><td>480.00</td><td>488.00</td><td>500.00</td><td>525.00</td><td>600.00</td><td>50.00</td></tr><tr><td>142</td><td>JAIA01</td><td>13-06-2009</td><td>03-07-2009</td><td>700.00</td><td>700.00</td><td>700.00</td><td>700.00</td><td>700.00</td><td>700.00</td><td>700.00</td><td>700.00</td></tr><tr><td>143</td><td>JAIA01</td><td>04-07-2009</td><td>21-08-2009</td><td>900.00</td><td>900.00</td><td>900.00</td><td>900.00</td><td>900.00</td><td>900.00</td><td>900.00</td><td>900.00</td></tr><tr><td>144</td><td>JAIA01</td><td>22-08-2009</td><td>11-09-2009</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td></tr><tr><td>145</td><td>JAIA01</td><td>12-09-2009</td><td>25-09-2009</td><td>400.00</td><td>400.00</td><td>410.00</td><td>412.00</td><td>416.00</td><td>425.00</td><td>450.00</td><td>50.00</td></tr><tr><td>146</td><td>JAIA01</td><td>26-09-2009</td><td>22-10-2009</td><td>350.00</td><td>350.00</td><td>360.00</td><td>363.00</td><td>367.00</td><td>375.00</td><td>400.00</td><td>50.00</td></tr><tr><td>147</td><td>JAIA01</td><td>23-10-2009</td><td>31-10-2009</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>50.00</td></tr><tr><td>148</td><td>JAIA01</td><td>01-11-2009</td><td>21-12-2009</td><td>350.00</td><td>350.00</td><td>360.00</td><td>363.00</td><td>367.00</td><td>375.00</td><td>400.00</td><td>50.00</td></tr><tr><td>149</td><td>JAIA01</td><td>22-12-2009</td><td>28-12-2009</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>50.00</td></tr><tr><td>150</td><td>JAIA01</td><td>29-12-2009</td><td>02-01-2010</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>650.00</td><td>50.00</td></tr><tr><td>154</td><td>JAIA01</td><td>03-01-2010</td><td>03-04-2010</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td><td>0.00</td></tr></table><br />


<b>From:</b> 2009-05-28<br />
<b>To:</b> 2009-06-02<br />
<b>Nights:</b> 5<br />


<table border="1">
<tr><th>Rate Id</th><th>From period</th><th>To period</th><th>Weeks</th><th>Nights</th><th>Price</th><th>Running total</th></tr>

<tr><td>188</td><td>09-05-2009</td><td>28-05-2009</td><td>0</td><td>1</td><td>450.00</td><td>450</td></tr>

<tr><td>140</td><td>29-05-2009</td><td>31-05-2009</td><td>0</td><td>3</td><td>600.00</td><td>1050</td></tr><tr><td>141</td><td>01-06-2009</td><td>12-06-2009</td><td>0</td><td>1</td><td>50.00</td><td>1100</td></tr>
</table>
<a href="index.php/ratescheck">BACK</a>
</div>
</div>
<!-- End of wrapper div -->
</body>
</html>