<div id="headerBar">
<!-- Control bar for owners list view with  -->
<!-- jsfiles/autocomplete/auto_properties.php -->
Find an owner: 
<form style="display: inline;">
<input type="text" id="cityAjax" value="" size="45" />
<input type="hidden" id="autonavDestination" value="<?= $this->config->site_url(); ?>/owners/edit_owner/" />
</form>
</div>

<script type="text/javascript">
$(document).ready(function() {

	$("#cityAjax").autocomplete(
		"index.php/owners/owner_autocomplete",
		{
			delay:10,
			minChars:1,
			matchSubset:1,
			matchContains:1,
			cacheLength:10,
			onItemSelect:selectItem,
			onFindValue:findValue,
			formatItem:formatItem,
			autoFill:true
		}
	);

});
</script>

