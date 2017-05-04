<!-- Bookings listing view -->
<div id="headerBar">Now viewing: <?= $heading ;?></div>

<div>
<?php echo $this->pagination->create_links(); ?>
<?= $results; ?>
</div>