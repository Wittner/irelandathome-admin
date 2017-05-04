<?php
class Payment_model extends Model
{

/*	CONSTRUCTOR */
    function Payment_model()
    {
        parent::Model();
        $this->load->model('global_model');
    }

/*	ADD PAYMENT TO A BOOKING */
    function add_payment($bookingNumber,$paymentPurpose,$paymentMethod,$paymentAmount,$paymentRef)
    {
        // Add a new payment
		// Set a creation date for customer
		$paymentDate = date('Y-m-d');
			
		// Create new entry in customer file			
        $paymentData = array
		(
		'paymentId' 			=> '',
		'paymentBookingNumber' 	=> $bookingNumber,
		'paymentDate'			=> $paymentDate,
		'paymentPurpose'		=> $paymentPurpose,
		'paymentMethod'			=> $paymentMethod,
		'paymentAmount'			=> $paymentAmount,
		'paymentRef'			=> $paymentRef
		);
		
		$this->db->insert('payments', $paymentData);
		
		$paymentId = $this->db->insert_id();
		return $paymentId; 
    }
   
/*	GET PAYMENTS FOR A BOOKING */    
	function get_payments_by_booking_number($bookingNumber)
	{
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        $output  = '<table border="0" width="100%">'; // Table start
					$this->db->order_by("paymentId", "asc");
		$query  = 	$this->db->get_where('payments', array('paymentBookingNumber' => $bookingNumber));

		if ($query->num_rows() != 0)
		{
        	$output .=
			'
			<tr><td colspan="5"><strong>Payments:</strong></td></tr>
			<tr>
			<td class="normal" valign="top" nowrap="yes" width="70">Date</td>
			<td class="normal" valign="top" nowrap="yes">Purpose</td>
			<td class="normal" valign="top" nowrap="yes">Method</td>
			<td class="normal" valign="top" nowrap="yes">Reference</td>
			<td class="normal" valign="top" nowrap="yes" width="100">Amount</td>
			</tr>
			';
			foreach ($query->result_array() as $row)
			{
			$i = $i + 1;
			$col = ($i % 2) ? 'hilite' : 'lowlite';
			$paymentDate = $row['paymentDate'];
			$displayPaymentDate = $this->global_model->toDisplayDate($paymentDate);
			$paymentPurpose = $row['paymentPurpose'];
			$paymentMethod = $row['paymentMethod'];
			$paymentRef = $row['paymentRef'];
			$paymentAmount = $row['paymentAmount'];
			$output .=
			'<tr>' .
			'<td class="' . $col . '">' . $displayPaymentDate . '</td>' .
			'<td class="' . $col . '">' . $paymentPurpose . '</td>'.
			'<td class="' . $col . '">' . $paymentMethod . '</td>' .
			'<td class="' . $col . '">' . $paymentRef . '</td>' .
			'<td align="right" class="' . $col . '">' . $paymentAmount . '</td>' .
			'</tr>';
			}
		}
		$output .= '</table>';
		
    	return $output;
	}

/*	GET TOTAL OF PAYMENTS FOR A BOOKING */
	function get_total_payments_for_booking($bookingNumber)
	{
		$query=$this->db->query("select sum(paymentAmount) total from payments where paymentBookingNumber ='$bookingNumber' group by paymentBookingNumber");
    	foreach ($query->result_array() as $row)
		{
			$paymentTotal = $row['total'];
		}
	return $paymentTotal;
    }
	
/* CHECK IF PAYMENTS EXIST FOR BOOKING */	
	function check_payment_exists($paymentId)
	{
		$this->db->where('paymentId', $paymentId);
		$this->db->from('payments');
		$result = $this->db->count_all_results();
		return $result;
	}
    
}// End of Class
?>