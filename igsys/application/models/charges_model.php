<?php
class Charges_model extends Model
{

    function Charges_model()
    {
        parent::Model();
        $this->load->model('global_model');
    }

    function add_charge($chargeBookingNumber,$chargePurpose,$chargeAmount,$chargeAllocation)
    {
        // Add a new charge
		// Set a creation date for charge
		$chargeDate = date('Y-m-d');
			
		// Create new entry in customer file			
        $chargeData = array(
		'chargeId' 				=> '',
		'chargeBookingNumber' 	=> $chargeBookingNumber,
		'chargeDate'			=> $chargeDate,
		'chargePurpose'			=> $chargePurpose,
		'chargeAmount'			=> $chargeAmount,
		'chargeAllocation'		=> $chargeAllocation
		);
		
		$this->db->insert('charges', $chargeData);
		
		$chargeId = $this->db->insert_id();
		return $chargeId; 
    }
   
    
	function get_charges_by_booking_number($bookingNumber)
	{
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        $output  = '<table border="0" width="100%" align="right">'; // Table start
					$this->db->order_by("chargeId", "asc");
		$query  = 	$this->db->get_where(
					'charges', array(
						'chargeBookingNumber' => $bookingNumber,
						'chargeAllocation' => 'iah'
					)
					);
		if ($query->num_rows() != 0)
		{
			$output .=
			'
			<tr><td colspan="3"><strong>Charges:</strong></td>
			<tr>
			<td class="normal" valign="top" nowrap="yes" width="70">Date</td>
			<td class="normal" valign="top" nowrap="yes">Purpose</td>
			<td class="normal" valign="top" nowrap="yes" width="100">Amount</td>
			</tr>
			';
			foreach ($query->result_array() as $row)
			{
			$i = $i + 1;
			$col = ($i % 2) ? 'hilite' : 'lowlite';
			$chargeDate = $row['chargeDate'];
			$displayChargeDate = $this->global_model->toDisplayDate($chargeDate);
			$chargePurpose = $row['chargePurpose'];
			$chargeAmount = $row['chargeAmount'];
			$output .=
			'<tr>' .
			'<td class="' . $col . '">' . $displayChargeDate . '</td>' .
			'<td class="' . $col . '">' . $chargePurpose . '</td>'.
			'<td align="right" class="' . $col . '">' . $chargeAmount . '</td>' .
			'</tr>';
			}
		}
		$output .= "</table>";
		
    	return $output;
	}

		function get_iah_charges_by_booking_number($bookingNumber)
	{
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        $output  = '<table border="0" width="100%" align="right">'; // Table start
					$this->db->order_by("chargeId", "asc");
		$query  = 	$this->db->get_where('charges', array(
											'chargeBookingNumber' => $bookingNumber,
											'chargeAllocation' => 'iah')
										);
		if ($query->num_rows() != 0)
		{
			$output .=
			'
			<tr><td colspan="3"><strong>Ireland At Home charges:</strong></td>
			<tr>
			<td class="normal" valign="top" nowrap="yes" width="70">Date</td>
			<td class="normal" valign="top" nowrap="yes">Purpose</td>
			<td class="normal" valign="top" nowrap="yes" width="100">Amount</td>
			</tr>
			';
			foreach ($query->result_array() as $row)
			{
			$i = $i + 1;
			$col = ($i % 2) ? 'hilite' : 'lowlite';
			$chargeDate = $row['chargeDate'];
			$displayChargeDate = $this->global_model->toDisplayDate($chargeDate);
			$chargePurpose = $row['chargePurpose'];
			$chargeAmount = $row['chargeAmount'];
			$output .=
			'<tr>' .
			'<td class="' . $col . '">' . $displayChargeDate . '</td>' .
			'<td class="' . $col . '">' . $chargePurpose . '</td>'.
			'<td align="right" class="' . $col . '">' . $chargeAmount . '</td>' .
			'</tr>';
			}
		}
		$output .= "</table>";
		
    	return $output;
	}

		function get_owner_charges_by_booking_number($bookingNumber)
	{
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        $output  = '<table border="0" width="100%" align="right">'; // Table start
					$this->db->order_by("chargeId", "asc");
		$query  = 	$this->db->get_where('charges', array(
											'chargeBookingNumber' => $bookingNumber,
											'chargeAllocation' => 'owner')
										);
		if ($query->num_rows() != 0)
		{
			$output .=
			'
			<tr><td colspan="3"><strong>Owner charges:</strong></td>
			<tr>
			<td class="normal" valign="top" nowrap="yes" width="70">Date</td>
			<td class="normal" valign="top" nowrap="yes">Purpose</td>
			<td class="normal" valign="top" nowrap="yes" width="100">Amount</td>
			</tr>
			';
			foreach ($query->result_array() as $row)
			{
			$i = $i + 1;
			$col = ($i % 2) ? 'hilite' : 'lowlite';
			$chargeDate = $row['chargeDate'];
			$displayChargeDate = $this->global_model->toDisplayDate($chargeDate);
			$chargePurpose = $row['chargePurpose'];
			$chargeAmount = $row['chargeAmount'];
			$output .=
			'<tr>' .
			'<td class="' . $col . '">' . $displayChargeDate . '</td>' .
			'<td class="' . $col . '">' . $chargePurpose . '</td>'.
			'<td align="right" class="' . $col . '">' . $chargeAmount . '</td>' .
			'</tr>';
			}
		}
		$output .= "</table>";
		
    	return $output;
	}

/*	GET TOTAL OF CHARGES FOR A BOOKING */
	function get_total_charges_for_booking($bookingNumber)
	{
		$chargeTotal='0.00';
		$query=$this->db->query("select sum(chargeAmount) total from charges where chargeBookingNumber = '$bookingNumber' group by chargeBookingNumber");
    	foreach ($query->result_array() as $row)
		{
			$chargeTotal = $row['total'];
		}
	return $chargeTotal;
    }

    function get_iah_total_charges_for_booking($bookingNumber)
	{
		$chargeTotal='0.00';
		$query=$this->db->query("select sum(chargeAmount) total from charges where chargeBookingNumber = '$bookingNumber' && chargeAllocation = 'iah' group by chargeBookingNumber");
    	foreach ($query->result_array() as $row)
		{
			$chargeTotal = $row['total'];
		}
	return $chargeTotal;
    }

    function get_owner_total_charges_for_booking($bookingNumber)
	{
		$chargeTotal='0.00';
		$query=$this->db->query("select sum(chargeAmount) total from charges where chargeBookingNumber = '$bookingNumber' && chargeAllocation = 'owner' group by chargeBookingNumber");
    	foreach ($query->result_array() as $row)
		{
			$chargeTotal = $row['total'];
		}
	return $chargeTotal;
    }

/*	CHECK IF PAYMENTS EXIST (PROBABLY DEFUNCT NOW) */	
	function check_payment_exists($paymentId)
	{
		$this->db->where('paymentId', $paymentId);
		$this->db->from('payments');
		$result = $this->db->count_all_results();
		return $result;
	}
    
}// End of Class
?>