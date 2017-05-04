<div id="delivery">

<?
if($payments != ''){
$paymentsOutput ="
{$payments}
";  
}else
{$paymentsOutput = '';}

if($iahChargesOutput != ''){
$iahChargesOutput ="
{$iahChargesOutput}
";  
}else
{$iahChargesOutput = '';}

if($ownerChargesOutput != ''){
$ownerChargesOutput ="
{$ownerChargesOutput}
";  
}else
{$ownerCharges = '';}

?>

<?php foreach($query->result() as $row): ?>
<?
/* SET THE OWNER PAID DATE */

if($row->ownerPaidDate == '0000-00-00')
{
    $ownerPaidDate = date('Y-m-d');
}
else
{
    $ownerPaidDate = $row->ownerPaidDate;
}
$displayOwnerPaidDate = $this->global_model->toDisplayDate($ownerPaidDate);

$displayArrivalDate = $this->global_model->toDisplayDate($row->fromDate);
$displayDepartureDate = $this->global_model->toDisplayDate($row->toDate);

?>

<!-- Booking record start -->

<table border="0" width="100%" align="center" cellpadding="8" cellspacing="8" bgcolor="#E6F7FF">

<!-- Personal data -->
<tr>
<td class="avail_mainhead" valign="top" colspan="6">Personal Data</td>
</tr>

<tr>
    <td class="normal" valign="top" colspan="2">
        <strong>Name:</strong><?=$row->customer_name ; ?> <?=$row->customer_surname ; ?><br />
        <strong>Company</strong><br /><?=$row->companyName;?>
    </td>
    <td class="normal" valign="top" colspan="2">
        <strong>Phone</strong><br />
        <?=$row->customer_landphone;?><br />
        <strong>Mobile</strong><br />
        <?=$row->customer_mobile;?>
    </td>
    <td class="normal" valign="top" colspan="2">
        <a href="mailto:<?= $row->customer_email;?>"><u>Email</u></a>
    </td>
</tr>

<tr>
    <td class="normal" valign="top" colspan="2"><strong>Address</strong><br /><?=$row->customer_address;?></td>
    <td class="normal" valign="top" colspan="2"><strong>Notes</strong><br /><?=$row->customerSpecials;?></td>
    <td class="normal" valign="top" colspan="2"><strong>Properties</strong><br /><?=$row->propertyList;?></td>
</tr>

<tr>
    <td class="wtback" valign="top" colspan="6">&nbsp;</td>
</tr>

<!-- Property and arrival -->
<tr>
<td class="avail_mainhead" valign="top" colspan="6">Property and Arrival</td>
</tr>

<tr>
<td class="normal" valign="top"><strong>Arr.Date</strong></td>
<td class="normal" valign="top"><?=$displayArrivalDate?></td>
<td class="normal" valign="top"><strong>Arr.Time</strong></td>
<td class="normal" valign="top"><?=$row->fromTime; ?></td>
<td class="normal" valign="top"><strong>Adults</strong></td>
<td class="normal" valign="top"><?=$row->adults; ?></td>
</tr>

<tr>
<td class="normal" valign="top"><strong>Dep.Date</strong></td>
<td class="normal" valign="top"><?=$displayDepartureDate?>
</td>
<td class="normal" valign="top"><strong>Dep.Time</strong></td>
<td class="normal" valign="top"><?=$row->toTime; ?></td>
<td class="normal" valign="top"><strong>Children</strong></td>
<td class="normal" valign="top"><?=$row->children;?></td>
</tr>

<tr>
<td class="normal" valign="top"><strong>Nights</strong></td>
<td class="normal" valign="top"><?=$row->customerNights;?></td>
<td class="normal" colspan="2">&nbsp;</td>
<td class="normal" valign="top"><strong>Infants</strong></td>
<td class="normal" valign="top"><?=$row->infants;?></td>
</tr>


<tr>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" valign="top">&nbsp;</td>
<td class="normal" valign="top">&nbsp;</td>
</tr>

<tr>
    <td class="normal" valign="top"><strong>Property</strong></td>
    <td class="normal" valign="top">
        <?=$this->property_model->get_property_name_by_code($row->propertyCode);?>
    </td>
<td class="normal">&nbsp;</td>
<td class="normal" valign="top">
    <strong>Cot?</strong><br />
    <?php if ($row->bookingsCot=="no"){echo "No";}else{echo "Yes";}?>
</td>
<td class="normal" valign="top">
    <strong>High chair?</strong><br />
    <?php if ($row->bookingsHighchair=="no"){echo "No";}else{echo "Yes";}?>
</td>
</tr>

<tr>
<td class="wtback" valign="top" colspan="6">&nbsp;</td>
</tr>

<tr>
<td class="avail_mainhead" valign="top" colspan="6">Statement</td>
</tr>


<tr>
<td class="normal" valign="top" colspan="6"></td>
</tr>

<tr>
<td class="6" colspan="6"><hr class="dotted" width="100%" />
    <table border="0" width="100%">
    <tr>
        <td class="normal" valign="top">
            <strong>Accommodation breakdown</strong><br />
        </td>
        <td>Amount</td>
    </tr>
    <tr>
        <td class="hilite">
            Accommodation
        </td>
        <td class="hilite" align="right">
            <?=$row->accommCost; ?>
        </td>
    </tr>
    <tr>
        <td class="normal">
            Booking fee
        </td>
        <td class="normal" align="right">
            <?=$row->bookingFee; ?>
        </td>
    </tr>
    <tr>
        <td class="hilite">
            Discount
        </td>
        <td class="hilite" align="right">
            <?=$row->bookingDiscount;?>
        </td>
    </tr>
    <tr>
        <td class="normal" align="right" colspan="2">
            <strong>
                Accommodation total: &euro;
            <?php
                $accommodationTotalCost = $row->accommCost + $row->bookingFee - $row->bookingDiscount;
                printf("%.2f",$accommodationTotalCost);
            ?>
            </strong>
        </td>
    </tr>
    </table>
</td>
</tr>

<!-- Transactions output begin -->

<!-- Owner Charges list -->
<tr>
<td colspan="6">
<?= $iahChargesOutput; ?>
</td>
</tr>

<tr>
    <td colspan="6" align="right"><strong>Total IAH charges: <?= $iahTotCharges; ?></strong></td>
</tr>

<!-- IAH Charges list -->
<tr>
<td colspan="6">
<?= $ownerChargesOutput; ?>
</td>
</tr>

<tr>
    <td colspan="6" align="right"><strong>Total Owner charges: <?= $ownerTotCharges; ?></strong></td>
</tr>

<!-- Payments list -->
<tr>
<td colspan="6">
<?= $paymentsOutput; ?>
</td>
</tr>

</td></tr>
<tr><td colspan="6"><hr class="dotted" width="100%" /></td></tr>
<!-- Transactions output end -->

<!-- Transactions total -->
<tr>
<td colspan="6">
<table align="right" border="0">
<tr><td align="right">Accommodation:</td><td class="hilite" align="right"><?php printf("%.2f",$accommodationTotalCost); ?></td></tr>
<tr><td align="right">Charges:</td><td class="hilite" align="right"><?php printf("%.2f",$totCharges); ?></td></tr>
<tr><td align="right">Total customer price:</td><td class="hilite" align="right"><?php printf("%.2f",$row->customerPrice); ?></td></tr>
<tr><td align="right"><strong>Less payments to date:</strong></td><td class="lowlite" width="100" align="right"><?=$row->customerTotalPaid;?></td></tr>
<tr><td align="right"><strong>Balance due:</strong></td><td class="hilite" width="100" align="right">&euro;<?php printf("%.2f",$row->customerBalance);?></td></tr>
<tr><td colspan="2" align="right"><hr class="dotted" width="100%" /></td></tr>
</table>
</td>
</tr>

<tr>
<td class="avail_mainhead" valign="top" colspan="6">Account Totals and comments</td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" class="normal" valign="top" colspan="2">Commissionable cost &nbsp;&nbsp; </td>
<td class="normal" valign="top"><?php printf("%.2f",$row->commissionableCost);?></td>
</tr>


<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" class="normal" valign="top" colspan="2">Commission % &nbsp;&nbsp; </td>
<td class="normal" valign="top">
  <?=$row->commissionPercentage; ?>
</td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" class="normal" valign="top" colspan="2">Commission Amount &nbsp;&nbsp; </td>
<td class="normal" valign="top"><?php printf("%.2f",$row->commissionAmount);?></td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" class="normal" valign="top" colspan="2">Booking Fee &nbsp;&nbsp; </td>
<td class="normal" valign="top"><?=$row->bookingFee; ?></td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" valign="top" colspan="2">IAH due &nbsp;&nbsp; </td>
<td class="normal" valign="top"><?php printf("%.2f",$row->agentFee);?></td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" valign="top" colspan="2">Owner balance &nbsp;&nbsp; </td>
<td class="normal" valign="top"><?php printf("%.2f",$row->ownerBalance); ?></td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" valign="top" colspan="2">Owner Paid? &nbsp;&nbsp; </td>
<td class="normal" valign="top">
<?php if($row->ownerPaid == 'no'){echo 'No';}else{echo 'Yes';} ?>
</td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" class="normal" valign="top" colspan="2">Owner paid date &nbsp;&nbsp; </td>
<td class="normal" valign="top">
    <?=$displayOwnerPaidDate;?>
</td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" valign="top" colspan="2">Booking Reference &nbsp;&nbsp; </td>
<td class="normal" valign="top"><?=$row->ownerReference; ?></td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" valign="top" colspan="2">Payment method &nbsp;&nbsp; </td>
<td class="normal" valign="top">
  <?=$row->ownerPaymentMethod; ?>
</td>
</tr>


<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" valign="top" colspan="2">Referral &nbsp;&nbsp; </td>
<td class="normal" valign="top">
  <?=$row->customerReferral; ?>
</td>
</tr>

<tr>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td class="normal" valign="top"></td>
<td align="right" class="normal" class="normal" valign="top" colspan="2">Repeat Business? &nbsp;&nbsp; </td>
<td class="normal" valign="top">
  <?=$row->repeatBusiness; ?>
</td>
</tr>

<!-- Who belongs to sale? -->
<tr>
    <td class="normal" valign="top"></td>
    <td class="normal" valign="top"></td>
    <td class="normal" valign="top"></td>
    <td align="right" class="normal" class="normal" valign="top" colspan="2">Agent &nbsp;&nbsp; </td>
    <td class="normal" valign="top"><strong><?= $row->adminInit; ?></strong></td>
  </tr>
</tr>
</table>
<!-- Booking record end -->

<?php endforeach; ?>
</div>

