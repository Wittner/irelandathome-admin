<!-- Enquiry listing view -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>
<div id="queryList">
<?= $results; ?>
</div>
<!-- JQuery -->
<script type="text/javascript">
$(document).ready(function() {
  $('#queryList a.aNote').click(function() {
  	var divId = 'divNote' + $(this).attr('id');
    $('#' + divId).toggle('slide');
	return false;
  });
});
</script>