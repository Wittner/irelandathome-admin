<div>
<?php foreach($query->result() as $row): ?>




$bookingNumber = "<?=$row->booking_number;?>";
$paymentPurpose = "<?=$row->payment1_purpose; ?>";
$paymentDate = "<?=$row->payment1_date; ?>";
$paymentDueDate = "<?=$row->payment1_due_date; ?>";
$paymentPaidDate = "<?=$row->payment1_date; ?>";
$paymentMethod = "<?=$row->payment1_method; ?>";
$paymentAmount = "<?=$row->payment1_amount; ?>";
$paymentRef = "<?=$row->payment1_ref; ?>";
$data<?=$row->booking_number;?>1 = $this->global_model->data_transfer_action($bookingNumber,$paymentPurpose,$paymentDate,$paymentDueDate,$paymentPaidDate,$paymentMethod,$paymentAmount,$paymentRef);

$bookingNumber = "<?=$row->booking_number;?>";
$paymentPurpose = "<?=$row->payment2_purpose; ?>";
$paymentDate = "<?=$row->payment2_date; ?>";
$paymentDueDate = "<?=$row->payment2_due_date; ?>";
$paymentPaidDate = "<?=$row->payment2_date; ?>";
$paymentMethod = "<?=$row->payment2_method; ?>";
$paymentAmount = "<?=$row->payment2_amount; ?>";
$paymentRef = "<?=$row->payment2_ref; ?>";
$data<?=$row->booking_number;?>2 = $this->global_model->data_transfer_action($bookingNumber,$paymentPurpose,$paymentDate,$paymentDueDate,$paymentPaidDate,$paymentMethod,$paymentAmount,$paymentRef);

$bookingNumber = "<?=$row->booking_number;?>";
$paymentPurpose = "<?=$row->payment3_purpose; ?>";
$paymentDate = "<?=$row->payment3_date; ?>";
$paymentDueDate = "<?=$row->payment3_due_date; ?>";
$paymentPaidDate = "<?=$row->payment3_date; ?>";
$paymentMethod = "<?=$row->payment3_method; ?>";
$paymentAmount = "<?=$row->payment3_amount; ?>";
$paymentRef = "<?=$row->payment3_ref; ?>";
$data<?=$row->booking_number;?>3 = $this->global_model->data_transfer_action($bookingNumber,$paymentPurpose,$paymentDate,$paymentDueDate,$paymentPaidDate,$paymentMethod,$paymentAmount,$paymentRef);

$bookingNumber = "<?=$row->booking_number;?>";
$paymentPurpose = "<?=$row->payment4_purpose; ?>";
$paymentDate = "<?=$row->payment4_date; ?>";
$paymentDueDate = "<?=$row->payment4_due_date; ?>";
$paymentPaidDate = "<?=$row->payment4_date; ?>";
$paymentMethod = "<?=$row->payment4_method; ?>";
$paymentAmount = "<?=$row->payment4_amount; ?>";
$paymentRef = "<?=$row->payment4_ref; ?>";
$data<?=$row->booking_number;?>4 = $this->global_model->data_transfer_action($bookingNumber,$paymentPurpose,$paymentDate,$paymentDueDate,$paymentPaidDate,$paymentMethod,$paymentAmount,$paymentRef);


<?php endforeach; ?>
</div>
									