<script type="text/javascript">
/* Load html to div */
$(document).ready(function () {
	$('#navTabsMain a').click(function() {
		var divId = $(this).attr('id');
		var divTarget = $(this).attr('source');
		$('#div' + divId).load(divTarget);
	});
 });

</script>
	
<!-- Properties listing view -->

<div id="leftnav" class="leftnav">
	
</div>

<div id="mainnav" class="mainnav">

		<!-- Tabs -->
		<div id="navTabsMain">
			<ul>
				<li><a id="Home" href="#divHome" source="index.php/owners/ajax_owners_list">Home</a></li>
				<li><a id="Tools" href="#divTools" source="index.php/owners/ajax_owners_list">Tools</a></li>
				<li><a id="Queries" href="#divQueries" source="index.php/owners/ajax_list_queries">Queries</a></li>
				<li><a id="Sales" href="#divSales" source="index.php/owners/ajax_owners_list">Sales</a></li>
				<li><a id="Customers" href="#divCustomers" source="index.php/owners/ajax_owners_list">Customers</a></li>
				<li><a id="Availability" href="#divAvailability" source="index.php/owners/ajax_owners_list">Availability</a></li>
				<li><a id="Property" href="#divProperty" source="index.php/owners/ajax_owners_list">Property</a></li>
				<li><a id="Owners" href="#divOwners" source="index.php/owners/ajax_owners_list">Owners</a></li>
				<li><a id="Locations" href="#divLocations" source="index.php/owners/ajax_owners_list">Locations</a></li>
				<li><a id="Reports" href="#divReports" source="index.php/owners/ajax_owners_list">Reports</a></li>
			</ul>
			<div id="divHome"></div>
			<div id="divTools"></div>
			<div id="divQueries"></div>
			<div id="divSales"></div>
			<div id="divCustomers"></div>
			<div id="divAvailability"></div>
			<div id="divProperty"></div>
			<div id="divOwners"></div>
			<div id="divLocations"></div>
			<div id="divReports"></div>
		</div>

</div>