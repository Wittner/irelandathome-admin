
<div id="headerBar">
<!-- Control bar for edit booking view  -->

<?= $heading ;?>
<?php foreach($query->result() as $row): ?>
    <?php
    $currentBookingDate = $row->enquiryDate;
    $currentSourceCode = $row->sourceCode;
    $currentBookingNumber = $row->bookingNumber;
    $currentBookingDateYear = substr($currentBookingDate, 0, 4);
    $currentBookingDateMonth = substr($currentBookingDate, 5, 2);
    $currentBookingDateDay = substr($currentBookingDate, 8, 2);


echo "- <strong>Enquiry Date:</strong> {$currentBookingDateDay}/{$currentBookingDateMonth}/{$currentBookingDateYear} | <strong>Source code:</strong> {$currentSourceCode} | <strong>Booking Number</strong>: {$currentBookingNumber} </div>";

?>
<?php endforeach; ?>


<!--
<div id="controlBar">
<?php if($row->alternatives!='Yes'){echo "<span style=\"color : #ff0000;text-decoration: blink;\">Customer has requested no alternatives please!</span>";}?>&nbsp;
</div>
-->


