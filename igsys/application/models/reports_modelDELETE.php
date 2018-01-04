<?php
class Reports_model extends Model
{

    function Reports_model()
    {
        parent::Model();
        $this->load->model('global_model');
    }

/*	REPORT - SALES BY ARRIVAL DATE */
	function sales_report_by_arrival_date($fromDate,$toDate,$owner_id,$property_code,$customer_email,$customer_country,$source_code,$referrer)
	{
		$form = form_open('reports/excel_sales_report_by_arrival_date');
		$reportFromDate = $this->global_model->toDisplayDate($fromDate);
		$reportToDate = $this->global_model->toDisplayDate($toDate);
		$bookingFeeTotal = 0;
		$customerPriceTotal = 0;
        $customerNightsTotal = 0;
		$ownerBalanceTotal = 0;
		$commissionTotal = 0;
		$agentTotal = 0;
		$agentFeeTotal = 0;
        $totalOwnerCharges = 0;
        $totalIahCharges = 0;
        $ownerChargeGrandTotal = 0;
        $iahChargeGrandTotal = 0;
        $vatGrandTotal = 0;
		$this->db->select('*,fromDate as sortdate');
		$this->db->from('bookings');
		$this->db->join('customers','customers.customer_number = bookings.customerNumber');
		$this->db->join('properties','bookings.propertyCode = properties.property_code');
		$this->db->join('owners','properties.property_owner_id=owners.owner_id');
		$clause_1 = "fromDate BETWEEN '$fromDate' AND '$toDate'";
		$this->db->where($clause_1);
		$clause_2 = 'PAYMNT';
		$this->db->where('bookingStatus', $clause_2);
		if($owner_id != 'any')
		{
			$this->db->where('owner_id',$owner_id);
		}
		if($property_code != 'any')
		{
			$this->db->where('propertyCode',$property_code);
		}
		if($source_code != 'any')
		{
			$this->db->where('sourceCode',$source_code);
		}
		if($customer_email != '')
		{
			$this->db->where('customer_email',$customer_email);
		}
		if($referrer != 'any')
		{
			$this->db->where('customerReferral',$referrer);
		}
		if($customer_country != 'any')
		{
			$this->db->where('customer_country', $customer_country);
		}

		$this->db->order_by('sortdate','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
            $totalRecords = $query->num_rows();
			$i = 0; // Odd/even counter for alternate coloured <td>'s
    	    $col = ''; // Color style name for alternate coloured <td>'s

    	    $reportDate = date('d M Y');
    	    $output = '
    	    <p>
			<strong>Report name:</strong> Sales Report<br />
			<strong>Report date:</strong> ' . $reportDate .'
			</p>

			<p>
			<strong>From:</strong> ' . $reportFromDate . '<br>
			<strong>To:</strong> ' . $reportToDate . ' </p>
			';
			$output .= '
            <div class="report-table-wrapper">
				<table class="report-table">
                <tr>
                    <th colspan="2">Total bookings: ' . $totalRecords . '</th>
                    <th colspan="12" style="background-color: white">&nbsp;</th>
				<tr>
                    <th class="mainhead report-th">Owner ref.</th>
                    <th class="mainhead">IAH ref.</th>
                    <th class="mainhead">Property</th>
                    <th class="mainhead">Owner</th>
                    <th class="mainhead">Arrival</th>
                    <th class="mainhead">Customer</th>
                    <th class="mainhead">Referral</th>
                    <th class="mainhead">Country</th>
                    <th class="mainhead">Booked</th>
                    <th class="mainhead">Nights</th>
                    <th class="mainhead">Price</th>
                    <th class="mainhead">Commission</th>
                    <th class="mainhead">Booking fee</th>
                    <th class="mainhead">VAT</th>
                    <th class="mainhead">IAH due</th>
                    <th class="mainhead">Owner charges</th>
                    <th class="mainhead">IAH charges</th>
                    <th class="mainhead">Owner due</th>
				</tr>';
            $rowStyle = 'report-row-light'; // For colouring rows in table
			foreach ($query->result() as $item)
			{
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
				$displayBookingDate = $this->global_model->toDisplayDate($item->bookingDate);
				$customerCountry = $this->global_model->get_country_by_id($item->customer_country);


				// Do tot-ups
				$bookingFeeTotal += $item->bookingFee;
				$customerPriceTotal += $item->customerPrice;
				$ownerBalanceTotal += $item->ownerBalance;
				$commissionTotal += $item->commissionAmount;
				$agentFeeTotal += $item->agentFee;
                $customerNightsTotal += $item->customerNights;
                $vatGrandTotal += $item->vatAmount;

                // Owner and IAH total charges
                $totalOwnerCharges = $this->charges_model->get_owner_total_charges_for_booking($item->bookingNumber);
                $ownerChargeGrandTotal += $totalOwnerCharges;
                $totalIahCharges = $this->charges_model->get_iah_total_charges_for_booking($item->bookingNumber);
                $iahChargeGrandTotal += $totalIahCharges;

                $output .= '
				<tr class="' . $rowStyle . '">
                    <td nowrap class="normal">' . $item->ownerReference . ' &nbsp;</td>
                    <td nowrap class="normal">' . $item->bookingNumber . ' &nbsp;</td>
                    <td nowrap class="normal">' . $item->property_name . ' &nbsp;</td>
                    <td nowrap class="normal">' . $item->contact_fname . ' ' . $item->contact_sname . ' &nbsp;</td>
                    <td nowrap class="normal">' . $displayFromDate . ' &nbsp;</td>
                    <td nowrap class="normal">' . $item->customer_name . ' ' . $item->customer_surname . '&nbsp;</td>
                    <td nowrap class="normal">' . $item->customerReferral . ' &nbsp;</td>
                    <td nowrap class="normal">' . $customerCountry . ' &nbsp;</td>
                    <td nowrap class="normal">' . $displayBookingDate . ' &nbsp</td>
                    <td nowrap class="normal">' . $item->customerNights . ' &nbsp</td>
                    <td nowrap class="normal" align="right">' . $item->customerPrice . ' &nbsp</td>
                    <td nowrap class="normal" align="right">' . $item->commissionAmount . ' &nbsp</td>
                    <td nowrap class="normal">' . $item->bookingFee . ' &nbsp</td>
                    <td nowrap class="normal">'.$item->vatAmount.' &nbsp</td>
                    <td nowrap class="normal" align="right">' . $item->agentFee . ' &nbsp</td>
                    <td nowrap class="normal">'.$totalOwnerCharges.' &nbsp</td>
                    <td nowrap class="normal">'.$totalIahCharges.' &nbsp</td>
                    <td nowrap class="normal" align="right">' . $item->ownerBalance . ' &nbsp</td>
				</tr>
				';
                $rowStyle = ($rowStyle = 'report-row-light' ? 'report-row-light' : 'report-row-dark');
			 }
                $output .= '
				<tr>
                    <th class="mainhead" colspan="8"></th>
                    <th class="mainhead" nowrap>Nights</th>

                    <th class="mainhead" nowrap>Price</th>
                    <th class="mainhead" nowrap>Commission</th>
                    <th class="mainhead" nowrap>Booking fee</th>
                    <th class="mainhead" nowrap>VAT</th>
                    <th class="mainhead" nowrap>IAH due</th>
                    <th class="mainhead" nowrap>Owner charges</th>
                    <th class="mainhead" nowrap>IAH Charges</th>
                    <th class="mainhead" nowrap>Owner due</th>
				</tr>';
		$output .='
				<tr>
                    <td valign="top" colspan="8" align="right"><strong>Totals:</strong></td>
                    <td valign="top" align="right">' . $customerNightsTotal . '</td>
                    <td valign="top" align="right">' . $customerPriceTotal . '</td>
                    <td valign="top" align="right">' . $commissionTotal . '</td>
                    <td valign="top" align="right">' . $bookingFeeTotal . '</td>
                    <td valign="top" align="right">'.$vatGrandTotal.'</td>
                    <td valign="top" align="right">' . $agentFeeTotal . '</td>
                    <td valign="top" align="right">'.$ownerChargeGrandTotal.'</td>
                    <td valign="top" align="right">'.$iahChargeGrandTotal.'</td>
                    <td valign="top" align="right" nowrap>' . $ownerBalanceTotal . '</td>
                </tr>
				</table>'
				. $form .'
				<input type="hidden" name="fromDate" value="' . $fromDate . '" />
				<input type="hidden" name="toDate" value="' . $toDate . '" />
				<input type="hidden" name="owner_id" value="' . $owner_id . '" />
				<input type="hidden" name="source_code" value="' . $source_code . '" />
				<input type="hidden" name="property_code" value="' . $property_code . '" />
				<input type="hidden" name="customer_country" value="' . $customer_country . '" />
        <input type="hidden" name="referrer" value="' . $referrer . '" />
				';
		$output .= '<p align="center"><input type="submit" value="Download as Excel file" /></p>
				    </form>
                    </div>';
		}
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    return $output;
	}

/*	REPORT CSV - SALES BY ARRIVAL DATE */
	function csv_sales_report_by_arrival_date($fromDate,$toDate,$owner_id,$property_code,$customer_country,$source_code,$referrer)
	{
		$reportFromDate = $this->global_model->toDisplayDate($fromDate);
		$reportToDate = $this->global_model->toDisplayDate($toDate);
    $customerNightsTotal = 0;
		$bookingFeeTotal = 0;
		$customerPriceTotal = 0;
		$ownerBalanceTotal = 0;
		$commissionTotal = 0;
		$agentTotal = 0;
		$agentFeeTotal = 0;
        $totalOwnerCharges = 0;
        $totalIahCharges = 0;
        $ownerChargeGrandTotal = 0;
        $iahChargeGrandTotal = 0;
        $vatGrandTotal = 0;

		$this->db->select('*');
		$this->db->from('bookings');
		$this->db->join('customers','customers.customer_number = bookings.customerNumber');
		$this->db->join('properties','bookings.propertyCode = properties.property_code');
		$this->db->join('owners','properties.property_owner_id=owners.owner_id');
		$clause_1 = "fromDate BETWEEN '$fromDate' AND '$toDate'";
		$this->db->where($clause_1);
		$clause_2 = 'PAYMNT';
		$this->db->where('bookingStatus', $clause_2);
		if($owner_id != 'any')
		{
			$this->db->where('owner_id',$owner_id);
		}
		if($property_code != 'any')
		{
			$this->db->where('propertyCode',$property_code);
		}
    if($referrer != 'any')
		{
			$this->db->where('customerReferral',$referrer);
		}
		if($source_code != 'any')
		{
			$this->db->where('sourceCode',$source_code);
		}
		if($customer_country != 'any')
		{
			$this->db->where('customer_country', $customer_country);
		}

		$this->db->order_by('bookingDate','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$i = 0; // Odd/even counter for alternate coloured <td>'s
    	    $col = ''; // Color style name for alternate coloured <td>'s
            $totalRecords = $query->num_rows();

    	    $reportDate = date('d M Y');
            $output  = "\"REPORT DATE\",\"$reportDate\" \r\n";
            $output .= "\"TOTAL BOOKINGS\",\"$totalRecords\" \r\n";
    	    $output .= '"Owner ref","IAH ref.","Property","Owner","Arrival","Customer","Referral","Country","Date booked","Nights","Price","Commission","Booking fee","VAT","IAH due","Owner charges","IAH charges","Owner due"' . "\r\n";
			foreach ($query->result() as $item)
			{
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
				$displayBookingDate = $this->global_model->toDisplayDate($item->bookingDate);
				$customerCountry = $this->global_model->get_country_by_id($item->customer_country);

				// Do tot-ups
        $customerNightsTotal += $item->customerNights;
				$bookingFeeTotal += $item->bookingFee;
				$customerPriceTotal += $item->customerPrice;
				$ownerBalanceTotal += $item->ownerBalance;
				$commissionTotal += $item->commissionAmount;
				$agentFeeTotal += $item->agentFee;

                // Owner and IAH total charges
                $totalOwnerCharges = $this->charges_model->get_owner_total_charges_for_booking($item->bookingNumber);
                $ownerChargeGrandTotal += $totalOwnerCharges;
                $totalIahCharges = $this->charges_model->get_iah_total_charges_for_booking($item->bookingNumber);
                $iahChargeGrandTotal += $totalIahCharges;
                $vatGrandTotal += $item->vatAmount;

                $output .= '"'.$item->ownerReference.'","'.$item->bookingNumber.'","'.$item->property_name.'","'.$item->contact_fname.' '.$item->contact_sname.'","'.$displayFromDate.'","'.$item->customer_name.' '.$item->customer_surname.'","'.$item->customerReferral.'","'.$customerCountry.'","'.$displayBookingDate.'","'.$item->customerNights.'","'.$item->customerPrice.'","'.$item->commissionAmount.'","'.$item->bookingFee.'","'.$item->vatAmount.'","'.$item->agentFee.'","'.$totalOwnerCharges.'","'.$totalIahCharges.'","'.$item->ownerBalance.'"' . "\r\n";
			}
            $output .='""," "," "," "," "," "," "," ","Totals ","'.$customerNightsTotal.'","'.$customerPriceTotal.'","'.$commissionTotal.'","'.$bookingFeeTotal.'","'.$vatGrandTotal.'","'.$agentFeeTotal.'","'.$ownerChargeGrandTotal.'","'.$iahChargeGrandTotal.'","'.$ownerBalanceTotal.'"' . "\r\n";
		}
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    return $output;
	}

  /*	REPORT - SALES BY DEPARTURE DATE */
  	function sales_report_by_departure_date($fromDate,$toDate,$owner_id,$property_code,$customer_email,$customer_country,$source_code,$referrer)
  	{
  		$form = form_open('reports/excel_sales_report_by_departure_date');
  		$reportFromDate = $this->global_model->toDisplayDate($fromDate);
  		$reportToDate = $this->global_model->toDisplayDate($toDate);
  		$bookingFeeTotal = 0;
  		$customerPriceTotal = 0;
          $customerNightsTotal = 0;
  		$ownerBalanceTotal = 0;
  		$commissionTotal = 0;
  		$agentTotal = 0;
  		$agentFeeTotal = 0;
          $totalOwnerCharges = 0;
          $totalIahCharges = 0;
          $ownerChargeGrandTotal = 0;
          $iahChargeGrandTotal = 0;
          $vatGrandTotal = 0;
  		$this->db->select('*,toDate as sortdate');
  		$this->db->from('bookings');
  		$this->db->join('customers','customers.customer_number = bookings.customerNumber');
  		$this->db->join('properties','bookings.propertyCode = properties.property_code');
  		$this->db->join('owners','properties.property_owner_id=owners.owner_id');
  		$clause_1 = "toDate BETWEEN '$fromDate' AND '$toDate'";
  		$this->db->where($clause_1);
  		$clause_2 = 'PAYMNT';
  		$this->db->where('bookingStatus', $clause_2);
  		if($owner_id != 'any')
  		{
  			$this->db->where('owner_id',$owner_id);
  		}
  		if($property_code != 'any')
  		{
  			$this->db->where('propertyCode',$property_code);
  		}
  		if($source_code != 'any')
  		{
  			$this->db->where('sourceCode',$source_code);
  		}
  		if($customer_email != '')
  		{
  			$this->db->where('customer_email',$customer_email);
  		}
  		if($referrer != 'any')
  		{
  			$this->db->where('customerReferral',$referrer);
  		}
  		if($customer_country != 'any')
  		{
  			$this->db->where('customer_country', $customer_country);
  		}

  		$this->db->order_by('sortdate','asc');
  		$query = $this->db->get();
  		if ($query->num_rows() > 0)
  		{
              $totalRecords = $query->num_rows();
  			$i = 0; // Odd/even counter for alternate coloured <td>'s
      	    $col = ''; // Color style name for alternate coloured <td>'s

      	    $reportDate = date('d M Y');
      	    $output = '
      	    <p>
  			<strong>Report name:</strong> Sales Report by departure date<br />
  			<strong>Report date:</strong> ' . $reportDate .'
  			</p>

  			<p>
  			<strong>From:</strong> ' . $reportFromDate . '<br>
  			<strong>To:</strong> ' . $reportToDate . ' </p>
  			';
  			$output .= '
              <div class="report-table-wrapper">
  				<table class="report-table">
                  <tr>
                      <th colspan="2">Total bookings: ' . $totalRecords . '</th>
                      <th colspan="12" style="background-color: white">&nbsp;</th>
  				<tr>
                      <th class="mainhead report-th">Owner ref.</th>
                      <th class="mainhead">IAH ref.</th>
                      <th class="mainhead">Property</th>
                      <th class="mainhead">Owner</th>
                      <th class="mainhead">Departure</th>
                      <th class="mainhead">Arrival</th>
                      <th class="mainhead">Customer</th>
                      <th class="mainhead">Referral</th>
                      <th class="mainhead">Country</th>
                      <th class="mainhead">Booked</th>
                      <th class="mainhead">Nights</th>
                      <th class="mainhead">Price</th>
                      <th class="mainhead">Commission</th>
                      <th class="mainhead">Booking fee</th>
                      <th class="mainhead">VAT</th>
                      <th class="mainhead">IAH due</th>
                      <th class="mainhead">Owner charges</th>
                      <th class="mainhead">IAH charges</th>
                      <th class="mainhead">Owner due</th>
  				</tr>';
              $rowStyle = 'report-row-light'; // For colouring rows in table
  			foreach ($query->result() as $item)
  			{
  				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
  				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
  				$displayBookingDate = $this->global_model->toDisplayDate($item->bookingDate);
  				$customerCountry = $this->global_model->get_country_by_id($item->customer_country);


  				// Do tot-ups
  				$bookingFeeTotal += $item->bookingFee;
  				$customerPriceTotal += $item->customerPrice;
  				$ownerBalanceTotal += $item->ownerBalance;
  				$commissionTotal += $item->commissionAmount;
  				$agentFeeTotal += $item->agentFee;
                  $customerNightsTotal += $item->customerNights;
                  $vatGrandTotal += $item->vatAmount;

                  // Owner and IAH total charges
                  $totalOwnerCharges = $this->charges_model->get_owner_total_charges_for_booking($item->bookingNumber);
                  $ownerChargeGrandTotal += $totalOwnerCharges;
                  $totalIahCharges = $this->charges_model->get_iah_total_charges_for_booking($item->bookingNumber);
                  $iahChargeGrandTotal += $totalIahCharges;

                  $output .= '
  				<tr class="' . $rowStyle . '">
                      <td nowrap class="normal">' . $item->ownerReference . ' &nbsp;</td>
                      <td nowrap class="normal">' . $item->bookingNumber . ' &nbsp;</td>
                      <td nowrap class="normal">' . $item->property_name . ' &nbsp;</td>
                      <td nowrap class="normal">' . $item->contact_fname . ' ' . $item->contact_sname . ' &nbsp;</td>
                      <td nowrap class="normal">' . $displayToDate . ' &nbsp;</td>
                      <td nowrap class="normal">' . $displayFromDate . ' &nbsp;</td>
                      <td nowrap class="normal">' . $item->customer_name . ' ' . $item->customer_surname . '&nbsp;</td>
                      <td nowrap class="normal">' . $item->customerReferral . ' &nbsp;</td>
                      <td nowrap class="normal">' . $customerCountry . ' &nbsp;</td>
                      <td nowrap class="normal">' . $displayBookingDate . ' &nbsp</td>
                      <td nowrap class="normal">' . $item->customerNights . ' &nbsp</td>
                      <td nowrap class="normal" align="right">' . $item->customerPrice . ' &nbsp</td>
                      <td nowrap class="normal" align="right">' . $item->commissionAmount . ' &nbsp</td>
                      <td nowrap class="normal">' . $item->bookingFee . ' &nbsp</td>
                      <td nowrap class="normal">'.$item->vatAmount.' &nbsp</td>
                      <td nowrap class="normal" align="right">' . $item->agentFee . ' &nbsp</td>
                      <td nowrap class="normal">'.$totalOwnerCharges.' &nbsp</td>
                      <td nowrap class="normal">'.$totalIahCharges.' &nbsp</td>
                      <td nowrap class="normal" align="right">' . $item->ownerBalance . ' &nbsp</td>
  				</tr>
  				';
                  $rowStyle = ($rowStyle = 'report-row-light' ? 'report-row-light' : 'report-row-dark');
  			 }
                  $output .= '
  				<tr>
                      <th class="mainhead" colspan="8"></th>
                      <th class="mainhead" nowrap>Nights</th>

                      <th class="mainhead" nowrap>Price</th>
                      <th class="mainhead" nowrap>Commission</th>
                      <th class="mainhead" nowrap>Booking fee</th>
                      <th class="mainhead" nowrap>VAT</th>
                      <th class="mainhead" nowrap>IAH due</th>
                      <th class="mainhead" nowrap>Owner charges</th>
                      <th class="mainhead" nowrap>IAH Charges</th>
                      <th class="mainhead" nowrap>Owner due</th>
  				</tr>';
  		$output .='
  				<tr>
                      <td valign="top" colspan="8" align="right"><strong>Totals:</strong></td>
                      <td valign="top" align="right">' . $customerNightsTotal . '</td>
                      <td valign="top" align="right">' . $customerPriceTotal . '</td>
                      <td valign="top" align="right">' . $commissionTotal . '</td>
                      <td valign="top" align="right">' . $bookingFeeTotal . '</td>
                      <td valign="top" align="right">'.$vatGrandTotal.'</td>
                      <td valign="top" align="right">' . $agentFeeTotal . '</td>
                      <td valign="top" align="right">'.$ownerChargeGrandTotal.'</td>
                      <td valign="top" align="right">'.$iahChargeGrandTotal.'</td>
                      <td valign="top" align="right" nowrap>' . $ownerBalanceTotal . '</td>
                  </tr>
  				</table>'
  				. $form .'
  				<input type="hidden" name="fromDate" value="' . $fromDate . '" />
  				<input type="hidden" name="toDate" value="' . $toDate . '" />
  				<input type="hidden" name="owner_id" value="' . $owner_id . '" />
  				<input type="hidden" name="source_code" value="' . $source_code . '" />
  				<input type="hidden" name="property_code" value="' . $property_code . '" />
  				<input type="hidden" name="customer_country" value="' . $customer_country . '" />
          <input type="hidden" name="referrer" value="' . $referrer . '" />
  				';
  		$output .= '<p align="center"><input type="submit" value="Download as Excel file" /></p>
  				    </form>
                      </div>';
  		}
  		else
  		{
          	$output = '<h4>There are no records!</h4>';
          }
      return $output;
  	}


    /*	REPORT CSV - SALES BY ARRIVAL DATE */
    	function csv_sales_report_by_departure_date($fromDate,$toDate,$owner_id,$property_code,$customer_country,$source_code,$referrer)
    	{
    		$reportFromDate = $this->global_model->toDisplayDate($fromDate);
    		$reportToDate = $this->global_model->toDisplayDate($toDate);
        $customerNightsTotal = 0;
    		$bookingFeeTotal = 0;
    		$customerPriceTotal = 0;
    		$ownerBalanceTotal = 0;
    		$commissionTotal = 0;
    		$agentTotal = 0;
    		$agentFeeTotal = 0;
            $totalOwnerCharges = 0;
            $totalIahCharges = 0;
            $ownerChargeGrandTotal = 0;
            $iahChargeGrandTotal = 0;
            $vatGrandTotal = 0;

    		$this->db->select('*');
    		$this->db->from('bookings');
    		$this->db->join('customers','customers.customer_number = bookings.customerNumber');
    		$this->db->join('properties','bookings.propertyCode = properties.property_code');
    		$this->db->join('owners','properties.property_owner_id=owners.owner_id');
    		$clause_1 = "toDate BETWEEN '$fromDate' AND '$toDate'";
    		$this->db->where($clause_1);
    		$clause_2 = 'PAYMNT';
    		$this->db->where('bookingStatus', $clause_2);
    		if($owner_id != 'any')
    		{
    			$this->db->where('owner_id',$owner_id);
    		}
    		if($property_code != 'any')
    		{
    			$this->db->where('propertyCode',$property_code);
    		}
        if($referrer != 'any')
    		{
    			$this->db->where('customerReferral',$referrer);
    		}
    		if($source_code != 'any')
    		{
    			$this->db->where('sourceCode',$source_code);
    		}
    		if($customer_country != 'any')
    		{
    			$this->db->where('customer_country', $customer_country);
    		}

    		$this->db->order_by('toDate','asc');
    		$query = $this->db->get();
    		if ($query->num_rows() > 0)
    		{
    			$i = 0; // Odd/even counter for alternate coloured <td>'s
        	    $col = ''; // Color style name for alternate coloured <td>'s
                $totalRecords = $query->num_rows();

        	    $reportDate = date('d M Y');
                $output  = "\"REPORT DATE\",\"$reportDate\" \r\n";
                $output .= "\"TOTAL BOOKINGS\",\"$totalRecords\" \r\n";
        	    $output .= '"Owner ref","IAH ref.","Property","Owner","Departure","Arrival","Customer","Referral","Country","Date booked","Nights","Price","Commission","Booking fee","VAT","IAH due","Owner charges","IAH charges","Owner due"' . "\r\n";
    			foreach ($query->result() as $item)
    			{
    				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
    				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
    				$displayBookingDate = $this->global_model->toDisplayDate($item->bookingDate);
    				$customerCountry = $this->global_model->get_country_by_id($item->customer_country);

    				// Do tot-ups
            $customerNightsTotal += $item->customerNights;
    				$bookingFeeTotal += $item->bookingFee;
    				$customerPriceTotal += $item->customerPrice;
    				$ownerBalanceTotal += $item->ownerBalance;
    				$commissionTotal += $item->commissionAmount;
    				$agentFeeTotal += $item->agentFee;

                    // Owner and IAH total charges
                    $totalOwnerCharges = $this->charges_model->get_owner_total_charges_for_booking($item->bookingNumber);
                    $ownerChargeGrandTotal += $totalOwnerCharges;
                    $totalIahCharges = $this->charges_model->get_iah_total_charges_for_booking($item->bookingNumber);
                    $iahChargeGrandTotal += $totalIahCharges;
                    $vatGrandTotal += $item->vatAmount;

                    $output .= '"'.$item->ownerReference.'","'.$item->bookingNumber.'","'.$item->property_name.'","'.$item->contact_fname.' '.$item->contact_sname.'","'.$displayToDate.'","'.$displayFromDate.'","'.$item->customer_name.' '.$item->customer_surname.'","'.$item->customerReferral.'","'.$customerCountry.'","'.$displayBookingDate.'","'.$item->customerNights.'","'.$item->customerPrice.'","'.$item->commissionAmount.'","'.$item->bookingFee.'","'.$item->vatAmount.'","'.$item->agentFee.'","'.$totalOwnerCharges.'","'.$totalIahCharges.'","'.$item->ownerBalance.'"' . "\r\n";
    			}
                $output .='""," "," "," "," "," "," "," "," ","Totals ","'.$customerNightsTotal.'","'.$customerPriceTotal.'","'.$commissionTotal.'","'.$bookingFeeTotal.'","'.$vatGrandTotal.'","'.$agentFeeTotal.'","'.$ownerChargeGrandTotal.'","'.$iahChargeGrandTotal.'","'.$ownerBalanceTotal.'"' . "\r\n";
    		}
    		else
    		{
            	$output = '<h4>There are no records!</h4>';
            }
        return $output;
    	}

/* End sales by departure date *.


/*	REPORT - SALES BY BOOKING DATE */
	function sales_report_by_booking_date($fromDate,$toDate,$owner_id,$property_code,$customer_country,$source_code,$referrer)
	{
		$form = form_open('reports/excel_sales_report_by_booking_date');
		$reportFromDate = $this->global_model->toDisplayDate($fromDate);
		$reportToDate = $this->global_model->toDisplayDate($toDate);
		$bookingFeeTotal = 0;
		$customerPriceTotal = 0;
		$ownerBalanceTotal = 0;
		$commissionTotal = 0;
		$agentTotal = 0;
		$agentFeeTotal = 0;
        $totalOwnerCharges = 0;
        $totalIahCharges = 0;
        $ownerChargeGrandTotal = 0;
        $iahChargeGrandTotal = 0;
        $vatGrandTotal = 0;
		$this->db->select('*');
		$this->db->from('bookings');
		$this->db->join('customers','bookings.customerNumber = customers.customer_number');
		$this->db->join('properties','bookings.propertyCode = properties.property_code');
		$this->db->join('owners','owners.owner_id = properties.property_owner_id');
		$clause_1 = "bookingDate BETWEEN '$fromDate' AND '$toDate'";
		$this->db->where($clause_1);
		$clause_2 = 'PAYMNT';
		$this->db->where('bookingStatus', $clause_2);
		if($property_code != 'any')
		{
			$this->db->where('propertyCode',$property_code);
		}
		if($owner_id != 'any')
		{
			$this->db->where('owner_id',$owner_id);
		}
		if($source_code != 'any')
		{
			$this->db->where('sourceCode',$source_code);
		}
    if($referrer != 'any')
		{
			$this->db->where('customerReferral',$referrer);
		}
		if($customer_country != 'any')
		{
			$this->db->where('customer_country', $customer_country);
		}
		$this->db->order_by('bookingDate','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$i = 0; // Odd/even counter for alternate coloured <td>'s
    	    $col = ''; // Color style name for alternate coloured <td>'s

    	    $reportDate = date('d M Y');
    	    $output = '
    	    <p>
			<strong>Report name:</strong> Sales Report<br />
			<strong>Report date:</strong> ' . $reportDate .'
			</p>

			<p>
			<strong>From:</strong> ' . $reportFromDate . '<br>
			<strong>To:</strong> ' . $reportToDate . ' </p>
			';
			$output .= '
				<table width="1000" border="1" cellpadding="2" cellspacing="0">
				<tr>
          <th class="mainhead">Owner ref.</th>
          <th class="mainhead">IAH ref.</th>
          <th class="mainhead">Property</th>
          <th class="mainhead">Owner</th>
          <th class="mainhead">Arrival</th>
          <th class="mainhead">Customer</th>
          <th class="mainhead">Referrer</th>
          <th class="mainhead">Country</th>
          <th class="mainhead">Ngts</th>
          <th class="mainhead">Date booked</th>
          <th class="mainhead">Price</th>
          <th class="mainhead">Comm.</th>
          <th class="mainhead">Booking fee</th>
          <th class="mainhead">VAT</th>
          <th class="mainhead">IAH Due</th>
          <th class="mainhead">Owner charges</th>
          <th class="mainhead">IAH charges</th>
          <th class="mainhead">Owner due</th>
				</tr>';
			foreach ($query->result() as $item)
			{
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
				$displayBookingDate = $this->global_model->toDisplayDate($item->bookingDate);
				$customerCountry = $this->global_model->get_country_by_id($item->customer_country);

        // Owner and IAH total charges
        $totalOwnerCharges = $this->charges_model->get_owner_total_charges_for_booking($item->bookingNumber);
        $ownerChargeGrandTotal += $totalOwnerCharges;
        $totalIahCharges = $this->charges_model->get_iah_total_charges_for_booking($item->bookingNumber);
        $iahChargeGrandTotal += $totalIahCharges;

				// Do tot-ups
				$bookingFeeTotal += $item->bookingFee;
				$customerPriceTotal += $item->customerPrice;
				$ownerBalanceTotal += $item->ownerBalance;
				$commissionTotal += $item->commissionAmount;
                $vatGrandTotal += $item->vatAmount;
				$agentFeeTotal += $item->agentFee;

				$output .= '
				<tr>
  				<td nowrap class="normal">' . $item->ownerReference . ' &nbsp;</td>
  				<td nowrap class="normal">' . $item->bookingNumber . ' &nbsp;</td>
  				<td nowrap class="normal">' . $item->property_name . ' &nbsp;</td>
  				<td nowrap class="normal">' . $item->contact_fname . ' ' . $item->contact_sname . ' &nbsp;</td>
  				<td nowrap class="normal">' . $displayFromDate . ' &nbsp;</td>
  				<td nowrap class="normal">' . $item->customer_name . ' ' . $item->customer_surname . '&nbsp;</td>
          <td nowrap class="normal">' . $item->customerReferral . '&nbsp;</td>
  				<td nowrap class="normal">' . $customerCountry . '&nbsp;</td>
  				<td nowrap class="normal">' . $item->customerNights . ' &nbsp;</td>
  				<td nowrap class="normal">' . $displayBookingDate . ' &nbsp;</td>
          <td nowrap class="normal" align="right">' . $item->customerPrice . ' &nbsp</td>
          <td nowrap class="normal" align="right">' . $item->commissionAmount . ' &nbsp;</td>
          <td nowrap class="normal" align="right">' . $item->bookingFee . ' &nbsp;</td>
          <td nowrap class="normal" align="right">' . $item->vatAmount . ' &nbsp;</td>
          <td nowrap class="normal" align="right">' . $item->agentFee . ' &nbsp;</td>
          <td nowrap class="normal" align="right">' . $totalOwnerCharges . ' &nbsp;</td>
          <td nowrap class="normal" align="right">' . $totalIahCharges . ' &nbsp;</td>
          <td nowrap class="normal" align="right">' . $item->ownerBalance . ' &nbsp;</td>
				</tr>
				';
			}
		$output .='
				<tr>
				<td colspan="9">&nbsp;</td>
				<td valign="top">Totals:</td>
        <td valign="top" align="right" nowrap>' . $customerPriceTotal . '</td>
        <td valign="top" align="right" nowrap>' . $commissionTotal . '</td>
        <td valign="top" align="right" nowrap>' . $bookingFeeTotal . '</td>
        <td valign="top" align="right" nowrap>' . $vatGrandTotal . '</td>
        <td valign="top" align="right" nowrap>' . $agentFeeTotal . '</td>
        <td valign="top" align="right" nowrap>' . $ownerChargeGrandTotal . '</td>
        <td valigh="top" align="right" nowrap>' . $iahChargeGrandTotal . '</td>
				<td valign="top" align="right" nowrap>' . $ownerBalanceTotal . '</td>



				</table>'
				. $form .'
				<input type="hidden" name="fromDate" value="' . $fromDate . '" />
				<input type="hidden" name="toDate" value="' . $toDate . '" />
				<input type="hidden" name="owner_id" value="' . $owner_id . '" />
				<input type="hidden" name="source_code" value="' . $source_code . '" />
				<input type="hidden" name="property_code" value="' . $property_code . '" />
				<input type="hidden" name="customer_country" value="' . $customer_country . '" />
        <input type="hidden" name="referrer" value="' . $referrer . '" />

				<p align="center"><input type="submit" value="Download as Excel file" /></p>
				</form>
				';
		}
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    return $output;
	}

/*	REPORT CSV - SALES BY BOOKING DATE */
	function csv_sales_report_by_booking_date($fromDate,$toDate,$owner_id,$property_code,$customer_country,$source_code,$referrer)
	{
		$reportFromDate = $this->global_model->toDisplayDate($fromDate);
		$reportToDate = $this->global_model->toDisplayDate($toDate);
		$bookingFeeTotal = 0;
		$customerPriceTotal = 0;
		$ownerBalanceTotal = 0;
		$commissionTotal = 0;
		$agentTotal = 0;
		$agentFeeTotal = 0;
        $totalOwnerCharges = 0;
        $totalIahCharges = 0;
        $ownerChargeGrandTotal = 0;
        $iahChargeGrandTotal = 0;
        $vatGrandTotal = 0;
		$this->db->select('*');
		$this->db->from('bookings');
		$this->db->join('customers','customers.customer_number = bookings.customerNumber');
		$this->db->join('properties','bookings.propertyCode = properties.property_code');
		$this->db->join('owners','properties.property_owner_id=owners.owner_id');
		$clause_1 = "bookingDate BETWEEN '$fromDate' AND '$toDate'";
		$this->db->where($clause_1);
		$clause_2 = 'PAYMNT';
		$this->db->where('bookingStatus', $clause_2);
		if($owner_id != 'any')
		{
			$this->db->where('owner_id',$owner_id);
		}
		if($property_code != 'any')
		{
			$this->db->where('propertyCode',$property_code);
		}
		if($source_code != 'any')
		{
			$this->db->where('sourceCode',$source_code);
		}
    if($referrer != 'any')
		{
			$this->db->where('customerReferral',$referrer);
		}
		if($customer_country != 'any')
		{
			$this->db->where('customer_country', $customer_country);
		}

		$this->db->order_by('bookingDate','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$i = 0; // Odd/even counter for alternate coloured <td>'s
    	    $col = ''; // Color style name for alternate coloured <td>'s

    	    $reportDate = date('d M Y');
            $output = '"Owner ref.","IAH ref.","Property","Owner","Arrival","Customer","Referral","Country","Nights","Date booked","Price","Commission","Booking fee","VAT","IAH Due","Owner charges","IAH charges","Owner due"' . "\r\n";

			foreach ($query->result() as $item)
			{
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
				$displayBookingDate = $this->global_model->toDisplayDate($item->bookingDate);
				$customerCountry = $this->global_model->get_country_by_id($item->customer_country);

        // Owner and IAH total charges
        $totalOwnerCharges = $this->charges_model->get_owner_total_charges_for_booking($item->bookingNumber);
        $ownerChargeGrandTotal += $totalOwnerCharges;
        $totalIahCharges = $this->charges_model->get_iah_total_charges_for_booking($item->bookingNumber);
        $iahChargeGrandTotal += $totalIahCharges;

				// Do tot-ups
				$bookingFeeTotal += $item->bookingFee;
				$customerPriceTotal += $item->customerPrice;
				$ownerBalanceTotal += $item->ownerBalance;
				$commissionTotal += $item->commissionAmount;
                $vatGrandTotal += $item->vatAmount;
				$agentFeeTotal += $item->agentFee;

				$output .='"'.$item->ownerReference.'","'.$item->bookingNumber.'","'.$item->property_name.'","'.$item->contact_fname. ' ' .$item->contact_sname.'","'.$displayFromDate.'","'.$item->customer_name. ' ' .$item->customer_surname.'","'.$item->customerReferral.'","'.$customerCountry.'","'.$item->customerNights.'","'.$displayBookingDate.'","'.$item->customerPrice.'","'.$item->commissionAmount.'","'.$item->bookingFee.'","'.$item->vatAmount.'","'.$item->agentFee.'","'.$totalOwnerCharges.'","'.$totalIahCharges.'","'.$item->ownerBalance.'"'. "\n";
			}
		$output .='" "," "," "," "," "," "," "," "," ","Totals","'.$customerPriceTotal.'","'.$commissionTotal.'","'.$bookingFeeTotal.'","'.$vatGrandTotal.'","'.$agentFeeTotal.'","'.$ownerChargeGrandTotal.'","'.$iahChargeGrandTotal.'","'.$ownerBalanceTotal.'"'. "\r\n";
		}
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    return $output;
	}

/*	ARRIVALS */
	function arrivals_report($fromDate,$toDate,$owner_id,$prop_code)
	{
		$emailForm = form_open('comms/post_arrivals_email');
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        // [KEY] Nt=No.nights A=No.Adults C=No.Children I=No.Infants
        $output = '
		<table width="100%" border="0">
		<tr>
      <th>Our Ref</th>
      <th>Property</th>
      <th>Name</th>
      <th>Phone</th>
      <th>Arr date</th>
      <th>Arr time</th>
      <th>Dep date</th>
      <th>Dep time</th>
			<th>Nt</th>
			<th>A</th>
			<th>C</th>
			<th>I</th>
			<th>Cot</th>
			<th>HC</th>
      <th>Referral</th>
		</tr>';
		$this->db->select('*, bookings.cot as cotNeeded, bookings.highchair as bookingsHighchair');
		$this->db->from('bookings');
		$this->db->join('customers','customers.customer_number = bookings.customerNumber');
		$this->db->join('properties','bookings.propertyCode = properties.property_code');
		$this->db->join('owners','properties.property_owner_id = owners.owner_id');
		if($prop_code != 'any')
		{
			$this->db->where("propertyCode = '$prop_code'");
		}
		if($owner_id != 'any')
		{
			$this->db->where("owner_id = '$owner_id'");
		}
		$clause_1 = "fromDate BETWEEN '$fromDate' AND '$toDate'";
		$this->db->where($clause_1);
		$clause_2 = 'PAYMNT';
		$this->db->where('bookingStatus', $clause_2);
		$this->db->order_by('fromDate','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
        foreach ($query->result() as $item) {
	    	$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
				$i = $i + 1;
            	$col = ($i % 2) ? 'hilite' : 'lowlite';
            	$output
				.='<tr>'
        . '<td class="' . $col . '">' . $item->bookingNumber . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->property_name . '&nbsp;</td>'
        . '<td class="' . $col . '">' . $item->customer_name. ' ' . $item->customer_surname . '&nbsp;</td>'
        . '<td class="' . $col . '">' . $item->customer_mobile . '&nbsp;</td>'
        . '<td nowrap class="' . $col . '">' . $displayFromDate . '&nbsp;</td>'
        . '<td nowrap class="' . $col . '">' . $item->fromTime . '&nbsp;</td>'
        . '<td nowrap class="' . $col . '">' . $displayToDate . '&nbsp;</td>'
        . '<td nowrap class="' . $col . '">' . $item->toTime . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->customerNights . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->adults . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->children . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->infants . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->cotNeeded . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->bookingsHighchair . '&nbsp;</td>'
        . '<td class="' . $col . '">' . $item->customerReferral . '&nbsp;</td>';
			}
		$output .= '</table>';
	    // The following sets up the short form for an email to be sent with the table and owner email address automatically included
		$message = base64_encode($output);
		$output .='
		<p align="center">
		' . $emailForm . '
		<input type="hidden" name="fromAddress" value="sales@irelandathome.com" />
		<input type="hidden" name="message" value="' . $message . '" />
		<input type="hidden" name="subject" value="Arrivals report" />
		Email this report to: <input type="text" name="toAddress" value="' . $item->email . '" />
		<input type="submit" name="submit" value="Email the report" />
		</form>
		</p>
		';
		}
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    return $output;
	}

/*	UNPAID OWNERS REPORT */
	function unpaid_owners($fromDate,$toDate,$owner_id,$property_code)
	{
		$form = form_open('reports/csv_unpaid_owners');
		$reportFromDate = $this->global_model->toDisplayDate($fromDate);
		$reportToDate = $this->global_model->toDisplayDate($toDate);
		$bookingFeeTotal = 0;
		$customerPriceTotal = 0;
		$ownerBalanceTotal = 0;
		$commissionTotal = 0;
		$agentTotal = 0;
		$agentFeeTotal = 0;
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        // [KEY] Nt=No. nights A=No. Adults C=No. Children I=No. Infants
        $output = '
		<table width="100%" border="0">
		<tr>
			<th>Property</th>
			<th>Name</th>
			<th>Arrival</th>
			<th>Departure</th>
			<th>Nt</th>
			<th>A</th>
			<th>C</th>
			<th>I</th>
			<th>Cot</th>
			<th>Chair</th>
			<th>Our ref</th>
			<th>Owner Ref</th>
			<th>Phone</th>
		</tr>';

		$this->db->select('*');
		$this->db->from('bookings');
		$this->db->join('customers','customers.customer_number = bookings.customerNumber');
		$this->db->join('properties','bookings.propertyCode = properties.property_code');
		$this->db->join('owners','properties.property_owner_id = owners.owner_id');
		$clause_1 = "fromDate BETWEEN '$fromDate' AND '$toDate'";
		$clause_2 = "ownerPaid != 'yes'";
		$clause_3 = "bookingStatus != 'CANCELLED'";
		$this->db->where($clause_1);
		$this->db->where($clause_2);
		$this->db->where($clause_3);
		if($property_code != 'any')
		{
			$this->db->where('propertyCode',$property_code);
		}
		if($owner_id != 'any')
		{
			$this->db->where('owner_id',$owner_id);
		}
		$this->db->order_by('fromDate','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$i = 0; // Odd/even counter for alternate coloured <td>'s
    	    $col = ''; // Color style name for alternate coloured <td>'s

    	    $reportDate = date('d M Y');
    	    $output = '
    	    <p>
			<strong>Report name:</strong> Unpaid owners report<br />
			<strong>Report date:</strong> ' . $reportDate .'
			</p>

			<p>
			<strong>From:</strong> ' . $reportFromDate . '<br>
			<strong>To:</strong> ' . $reportToDate . ' </p>
			';
			$output .= '
				<table width="1000" border="1" cellpadding="2" cellspacing="0">
				<tr>
				<th class="mainhead">Owner ref.</th>
				<th class="mainhead">IAH ref.</th>
				<th class="mainhead">Property</th>
				<th class="mainhead">Owner</th>
				<th class="mainhead">Arrival</th>
				<th class="mainhead">Customer</th>
				<th class="mainhead">Ngts</th>
				<th class="mainhead">Date booked</th>
				<th class="mainhead">Booking fee</th>
				<th class="mainhead">Price</th>
				<th class="mainhead">Owner due</th>
				<th class="mainhead">Comm.</th>
				<th class="mainhead">IAH Due</th>
				</tr>';
			foreach ($query->result() as $item)
			{
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
				$displayBookingDate = $this->global_model->toDisplayDate($item->bookingDate);

				// Do tot-ups
				$bookingFeeTotal += $item->bookingFee;
				$customerPriceTotal += $item->customerPrice;
				$ownerBalanceTotal += $item->ownerBalance;
				$commissionTotal += $item->commissionAmount;
				$agentFeeTotal += $item->agentFee;

				$output .= '
				<tr>
				<td nowrap class="normal">' . $item->ownerReference . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->bookingNumber . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->property_name . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->contact_fname . ' ' . $item->contact_sname . ' &nbsp;</td>
				<td nowrap class="normal">' . $displayFromDate . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->customer_name . ' ' . $item->customer_surname . '&nbsp;</td>
				<td nowrap class="normal">' . $item->customerNights . ' &nbsp</td>
				<td nowrap class="normal">' . $displayBookingDate . ' &nbsp</td>
				<td nowrap class="normal">' . $item->bookingFee . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->customerPrice . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->ownerBalance . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->commissionAmount . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->agentFee . ' &nbsp</td>
				</tr>
				';
			}
		$output .='
				<tr>
				<td colspan="7">&nbsp;</td>
				<td valign="top">Totals:</td>
				<td valign="top" align="right">' . $bookingFeeTotal . '</td>
				<td valign="top" align="right">' . $customerPriceTotal . '</td>
				<td valign="top" align="right" nowrap>' . $ownerBalanceTotal . '</td>
				<td valign="top" align="right">' . $commissionTotal . '</td>
				<td valign="top" align="right">' . $agentFeeTotal . '</td>
				</table>'
				. $form .'
				<input type="hidden" name="fromDate" value="' . $fromDate . '" />
				<input type="hidden" name="toDate" value="' . $toDate . '" />
				<input type="hidden" name="owner_id" value="' . $owner_id . '" />
				<input type="hidden" name="property_code" value="' . $property_code . '" />

				<p align="center"><input type="submit" value="Download as Excel file" /></p>
				</form>
				';
		$output .= '</table>';
		}
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    return $output;
	}

/*	UNPAID OWNERS REPORT FOR CSV */
	function csv_unpaid_owners($fromDate,$toDate,$owner_id,$property_code)
	{
		$form = form_open('reports/csv_unpaid_owners');
		$reportFromDate = $this->global_model->toDisplayDate($fromDate);
		$reportToDate = $this->global_model->toDisplayDate($toDate);
		$bookingFeeTotal = 0;
		$customerPriceTotal = 0;
		$ownerBalanceTotal = 0;
		$commissionTotal = 0;
		$agentTotal = 0;
		$agentFeeTotal = 0;
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        // [KEY] Nt=No. nights A=No. Adults C=No. Children I=No. Infants
        $output = '
		<table width="100%" border="0">
		<tr>
			<th>Property</th>
			<th>Name</th>
			<th>Arrival</th>
			<th>Departure</th>
			<th>Nt</th>
			<th>A</th>
			<th>C</th>
			<th>I</th>
			<th>Cot</th>
			<th>Chair</th>
			<th>Our ref</th>
			<th>Owner Ref</th>
			<th>Phone</th>
		</tr>';
		$this->db->select('*');
		$this->db->from('bookings');
		$this->db->join('customers','customers.customer_number = bookings.customerNumber');
		$this->db->join('properties','bookings.propertyCode = properties.property_code');
		$this->db->join('owners','properties.property_owner_id = owners.owner_id');
		$clause_1 = "fromDate BETWEEN '$fromDate' AND '$toDate'";
		$clause_2 = "ownerPaid != 'yes'";
		$clause_3 = "bookingStatus != 'CANCELLED'";
		$this->db->where($clause_1);
		$this->db->where($clause_2);
		$this->db->where($clause_3);
		if($property_code != 'any')
		{
			$this->db->where('propertyCode',$property_code);
		}
		if($owner_id != 'any')
		{
			$this->db->where('owner_id',$owner_id);
		}
		$this->db->order_by('fromDate','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$i = 0; // Odd/even counter for alternate coloured <td>'s
    	    $col = ''; // Color style name for alternate coloured <td>'s

    	    $reportDate = date('d M Y');
    	    $output = "\"Owner ref.\",\"IAH ref.\",\"Property\",\"Owner\",\"Arrival\",\"Customer\",\"Nights\",\"Date booked\",\"Booking fee\",\"Price\",\"Owner due\",\"Commission\",\"IAH Due\" \r\n";
			foreach ($query->result() as $item)
			{
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
				$displayBookingDate = $this->global_model->toDisplayDate($item->bookingDate);

				// Do tot-ups
				$bookingFeeTotal += $item->bookingFee;
				$customerPriceTotal += $item->customerPrice;
				$ownerBalanceTotal += $item->ownerBalance;
				$commissionTotal += $item->commissionAmount;
				$agentFeeTotal += $item->agentFee;

				$output .= "\"$item->ownerReference\",\"$item->bookingNumber\",\"$item->property_name\",\"$item->contact_fname $item->contact_sname\",\"$displayFromDate\",\"$item->customer_name $item->customer_surname\",\"$item->customerNights\",\"$displayBookingDate\",\"$item->bookingFee\",\"$item->customerPrice\",\"$item->ownerBalance\",\"$item->commissionAmount\",\"$item->agentFee\" \n";
			}
		$output .="\" \",\" \",\" \",\" \",\" \",\" \",\" \",\"Totals\",\"$bookingFeeTotal\",\"$customerPriceTotal\",\"$ownerBalanceTotal\",\"$commissionTotal\",\"$agentFeeTotal\" \r\n";		$output .= '</table>';
		}
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    return $output;
	}

/*	OVERDUE BALANCES */
	function overdue_balances()
	{
	$balanceDueTotal = 0;
	$customerPriceTotal = 0;
	$set_date  = mktime(0, 0, 0, date("m"), date("d")-7, date("Y"));
	$chk_date= date("Y-m-d","$set_date");
	$this->db->select('*');
	$this->db->from('bookings');
	$this->db->join('customers','customers.customer_number = bookings.customerNumber');
	$this->db->join('properties','bookings.propertyCode = properties.property_code');
	$clause_1 = "reminderSent !='0000-00-00' and reminderSent <= '$chk_date' and customerBalance >0";
	$this->db->where($clause_1);
	$this->db->order_by('fromDate','asc');
	$query = $this->db->get();
	if ($query->num_rows() > 0)
	{
		$i = 0; // Odd/even counter for alternate coloured <td>'s
	    $col = ''; // Color style name for alternate coloured <td>'s
	    $reportDate = date('d M Y');
		$output = '
		<table width="1000" border="1" cellpadding="2" cellspacing="0">
		<tr>
		<th class="mainhead">Booking ref.</th>
		<th class="mainhead">Arrival</th>
		<th class="mainhead">Name</th>
		<th class="mainhead">Email</th>
		<th class="mainhead">Landline</th>
		<th class="mainhead">Mobile</th>
		<th class="mainhead">Property</th>
		<th class="mainhead">Reminder sent</th>
		<th class="mainhead">Amount due</th>
		</tr>';
		foreach ($query->result() as $item)
		{
			$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);

			// Do tot-ups
			$customerPriceTotal += $item->customerPrice;

			$output .= '
			<tr>
			<td nowrap class="normal">' . $item->bookingNumber . ' &nbsp;</td>
			<td nowrap class="normal">' . $displayFromDate . ' &nbsp;</td>
			<td nowrap class="normal">' . $item->customer_name . ' ' . $item->customer_surname . '&nbsp;</td>
			<td nowrap class="normal">' . $item->customer_email . ' &nbsp;</td>
			<td nowrap class="normal">' . $item->customer_landphone . ' &nbsp;</td>
			<td nowrap class="normal">' . $item->customer_mobile . ' &nbsp;</td>
			<td nowrap class="normal">' . $item->property_name . ' &nbsp</td>
			<td nowrap class="normal">' . $item->reminderSent . ' &nbsp</td>
			<td nowrap class="normal" align="right">' . $item->customerBalance . ' &nbsp</td>
			</tr>
			';
		}
		$output .='
		<tr>
		<td colspan="7">&nbsp;</td>
		<td valign="top">Totals:</td>
		<td valign="top" align="right">' . $customerPriceTotal . '</td>
		</table>
		';
		}
		else
		{
	    	$output = '<h4>There are no records!</h4>';
	    }
	return $output;
	}

/*	REPORT - CANCELLED SALES BY ARRIVAL */
	function cancelled_sales_report($fromDate,$toDate,$owner_id,$property_code)
	{
		$form = form_open('reports/excel_cancelled_sales_report');
		$reportFromDate = $this->global_model->toDisplayDate($fromDate);
		$reportToDate = $this->global_model->toDisplayDate($toDate);
		$bookingFeeTotal = 0;
		$customerPriceTotal = 0;
		$ownerBalanceTotal = 0;
		$commissionTotal = 0;
		$agentTotal = 0;
		$agentFeeTotal = 0;
		$this->db->select('*,fromDate as sortdate');
		$this->db->from('bookings');
		$this->db->join('customers','customers.customer_number = bookings.customerNumber');
		$this->db->join('properties','bookings.propertyCode = properties.property_code');
		$this->db->join('owners','properties.property_owner_id=owners.owner_id');
		$clause_1 = "fromDate BETWEEN '$fromDate' AND '$toDate'";
		$clause_2 = "CANCELLED";
		$this->db->where($clause_1);
		$this->db->where('bookingStatus', $clause_2);
		if($owner_id != 'any')
		{
			$this->db->where('owner_id',$owner_id);
		}
		if($property_code != 'any')
		{
			$this->db->where('propertyCode',$property_code);
		}
		$this->db->order_by('sortdate','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$i = 0; // Odd/even counter for alternate coloured <td>'s
    	    $col = ''; // Color style name for alternate coloured <td>'s

    	    $reportDate = date('d M Y');
    	    $output = '
    	    <p>
			<strong>Report name:</strong> Cancelled sales report<br />
			<strong>Report date:</strong> ' . $reportDate .'
			</p>

			<p>
			<strong>From:</strong> ' . $reportFromDate . '<br>
			<strong>To:</strong> ' . $reportToDate . ' </p>
			';
			$output .= '
				<table width="1000" border="1" cellpadding="2" cellspacing="0">
				<tr>
				<th class="mainhead">Owner ref.</th>
				<th class="mainhead">IAH ref.</th>
				<th class="mainhead">Property</th>
				<th class="mainhead">Owner</th>
				<th class="mainhead">Arrival</th>
				<th class="mainhead">Customer</th>
				<th class="mainhead">Ngts</th>
				<th class="mainhead">Date booked</th>
				<th class="mainhead">Booking fee</th>
				<th class="mainhead">Price</th>
				<th class="mainhead">Owner due</th>
				<th class="mainhead">Comm.</th>
				<th class="mainhead">IAH Due</th>
				</tr>';
			foreach ($query->result() as $item)
			{
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
				$displayBookingDate = $this->global_model->toDisplayDate($item->bookingDate);

				// Do tot-ups
				$bookingFeeTotal += $item->bookingFee;
				$customerPriceTotal += $item->customerPrice;
				$ownerBalanceTotal += $item->ownerBalance;
				$commissionTotal += $item->commissionAmount;
				$agentFeeTotal += $item->agentFee;

				$output .= '
				<tr>
				<td nowrap class="normal">' . $item->ownerReference . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->bookingNumber . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->property_name . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->contact_fname . ' ' . $item->contact_sname . ' &nbsp;</td>
				<td nowrap class="normal">' . $displayFromDate . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->customer_name . ' ' . $item->customer_surname . '&nbsp;</td>
				<td nowrap class="normal">' . $item->customerNights . ' &nbsp</td>
				<td nowrap class="normal">' . $displayBookingDate . ' &nbsp</td>
				<td nowrap class="normal">' . $item->bookingFee . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->customerPrice . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->ownerBalance . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->commissionAmount . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->agentFee . ' &nbsp</td>
				</tr>
				';
			}
		$output .='
				<tr>
				<td colspan="7">&nbsp;</td>
				<td valign="top">Totals:</td>
				<td valign="top" align="right">' . $bookingFeeTotal . '</td>
				<td valign="top" align="right">' . $customerPriceTotal . '</td>
				<td valign="top" align="right" nowrap>' . $ownerBalanceTotal . '</td>
				<td valign="top" align="right">' . $commissionTotal . '</td>
				<td valign="top" align="right">' . $agentFeeTotal . '</td>
				</table>'
				. $form .'
				<input type="hidden" name="fromDate" value="' . $fromDate . '" />
				<input type="hidden" name="toDate" value="' . $toDate . '" />
				<input type="hidden" name="owner_id" value="' . $owner_id . '" />
				<input type="hidden" name="property_code" value="' . $property_code . '" />

				<p align="center"><input type="submit" value="Download as Excel file" /></p>
				</form>
				';
		$output .= '</table>';
		}
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    return $output;
	}

/*	REPORT CSV - CANCELLED SALES BY ARRIVAL DATE */
	function csv_cancelled_sales_report($fromDate,$toDate,$owner_id,$property_code)
	{
		$reportFromDate = $this->global_model->toDisplayDate($fromDate);
		$reportToDate = $this->global_model->toDisplayDate($toDate);
		$bookingFeeTotal = 0;
		$customerPriceTotal = 0;
		$ownerBalanceTotal = 0;
		$commissionTotal = 0;
		$agentTotal = 0;
		$agentFeeTotal = 0;
		$this->db->select('*,fromDate as sortdate');
		$this->db->from('bookings');
		$this->db->join('customers','customers.customer_number = bookings.customerNumber');
		$this->db->join('properties','bookings.propertyCode = properties.property_code');
		$this->db->join('owners','properties.property_owner_id=owners.owner_id');
		$clause_1 = "fromDate BETWEEN '$fromDate' AND '$toDate'";
		$clause_2 = "CANCELLED";
		$this->db->where($clause_1);
		$this->db->where('bookingStatus', $clause_2);
		if($owner_id != 'any')
		{
			$this->db->where('owner_id',$owner_id);
		}
		if($property_code != 'any')
		{
			$this->db->where('propertyCode',$property_code);
		}
		$this->db->order_by('sortdate','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$i = 0; // Odd/even counter for alternate coloured <td>'s
    	    $col = ''; // Color style name for alternate coloured <td>'s

    	    $reportDate = date('d M Y');
    	    $output = "\"Owner ref.\",\"IAH ref.\",\"Property\",\"Owner\",\"Arrival\",\"Customer\",\"Nights\",\"Date booked\",\"Booking fee\",\"Price\",\"Owner due\",\"Commission\",\"IAH Due\" \r\n";
			foreach ($query->result() as $item)
			{
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
				$displayBookingDate = $this->global_model->toDisplayDate($item->bookingDate);

				// Do tot-ups
				$bookingFeeTotal += $item->bookingFee;
				$customerPriceTotal += $item->customerPrice;
				$ownerBalanceTotal += $item->ownerBalance;
				$commissionTotal += $item->commissionAmount;
				$agentFeeTotal += $item->agentFee;

				$output .= "\"$item->ownerReference\",\"$item->bookingNumber\",\"$item->property_name\",\"$item->contact_fname $item->contact_sname\",\"$displayFromDate\",\"$item->customer_name $item->customer_surname\",\"$item->customerNights\",\"$displayBookingDate\",\"$item->bookingFee\",\"$item->customerPrice\",\"$item->ownerBalance\",\"$item->commissionAmount\",\"$item->agentFee\" \n";
			}
		$output .="\" \",\" \",\" \",\" \",\" \",\" \",\" \",\"Totals\",\"$bookingFeeTotal\",\"$customerPriceTotal\",\"$ownerBalanceTotal\",\"$commissionTotal\",\"$agentFeeTotal\" \r\n";
		}
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    return $output;
	}

/*	REPORT - CANCELLED SALES BY BOOKING DATE */
	function cancelled_sales_booking_report($fromDate,$toDate,$owner_id,$property_code)
	{
		$form = form_open('reports/excel_cancelled_sales_booking_report');
		$reportFromDate = $this->global_model->toDisplayDate($fromDate);
		$reportToDate = $this->global_model->toDisplayDate($toDate);
		$bookingFeeTotal = 0;
		$customerPriceTotal = 0;
		$ownerBalanceTotal = 0;
		$commissionTotal = 0;
		$agentTotal = 0;
		$agentFeeTotal = 0;
		$this->db->select('*,fromDate as sortdate');
		$this->db->from('bookings');
		$this->db->join('customers','customers.customer_number = bookings.customerNumber');
		$this->db->join('properties','bookings.propertyCode = properties.property_code');
		$this->db->join('owners','properties.property_owner_id=owners.owner_id');
		$clause_1 = "bookingDate BETWEEN '$fromDate' AND '$toDate'";
		$clause_2 = "CANCELLED";
		$this->db->where($clause_1);
		$this->db->where('bookingStatus', $clause_2);
		if($owner_id != 'any')
		{
			$this->db->where('owner_id',$owner_id);
		}
		if($property_code != 'any')
		{
			$this->db->where('propertyCode',$property_code);
		}
		$this->db->order_by('bookingDate','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$i = 0; // Odd/even counter for alternate coloured <td>'s
    	    $col = ''; // Color style name for alternate coloured <td>'s

    	    $reportDate = date('d M Y');
    	    $output = '
    	    <p>
			<strong>Report name:</strong> Cancelled sales report by booking date<br />
			<strong>Report date:</strong> ' . $reportDate .'
			</p>

			<p>
			<strong>From:</strong> ' . $reportFromDate . '<br>
			<strong>To:</strong> ' . $reportToDate . ' </p>
			';
			$output .= '
				<table width="1000" border="1" cellpadding="2" cellspacing="0">
				<tr>
				<th class="mainhead">Owner ref.</th>
				<th class="mainhead">IAH ref.</th>
				<th class="mainhead">Property</th>
				<th class="mainhead">Owner</th>
				<th class="mainhead">Arrival</th>
				<th class="mainhead">Customer</th>
				<th class="mainhead">Ngts</th>
				<th class="mainhead">Date booked</th>
				<th class="mainhead">Booking fee</th>
				<th class="mainhead">Price</th>
				<th class="mainhead">Owner due</th>
				<th class="mainhead">Comm.</th>
				<th class="mainhead">IAH Due</th>
				</tr>';
			foreach ($query->result() as $item)
			{
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
				$displayBookingDate = $this->global_model->toDisplayDate($item->bookingDate);

				// Do tot-ups
				$bookingFeeTotal += $item->bookingFee;
				$customerPriceTotal += $item->customerPrice;
				$ownerBalanceTotal += $item->ownerBalance;
				$commissionTotal += $item->commissionAmount;
				$agentFeeTotal += $item->agentFee;

				$output .= '
				<tr>
				<td nowrap class="normal">' . $item->ownerReference . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->bookingNumber . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->property_name . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->contact_fname . ' ' . $item->contact_sname . ' &nbsp;</td>
				<td nowrap class="normal">' . $displayFromDate . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->customer_name . ' ' . $item->customer_surname . '&nbsp;</td>
				<td nowrap class="normal">' . $item->customerNights . ' &nbsp</td>
				<td nowrap class="normal">' . $displayBookingDate . ' &nbsp</td>
				<td nowrap class="normal">' . $item->bookingFee . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->customerPrice . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->ownerBalance . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->commissionAmount . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->agentFee . ' &nbsp</td>
				</tr>
				';
			}
		$output .='
				<tr>
				<td colspan="7">&nbsp;</td>
				<td valign="top">Totals:</td>
				<td valign="top" align="right">' . $bookingFeeTotal . '</td>
				<td valign="top" align="right">' . $customerPriceTotal . '</td>
				<td valign="top" align="right" nowrap>' . $ownerBalanceTotal . '</td>
				<td valign="top" align="right">' . $commissionTotal . '</td>
				<td valign="top" align="right">' . $agentFeeTotal . '</td>
				</table>'
				. $form .'
				<input type="hidden" name="fromDate" value="' . $fromDate . '" />
				<input type="hidden" name="toDate" value="' . $toDate . '" />
				<input type="hidden" name="owner_id" value="' . $owner_id . '" />
				<input type="hidden" name="property_code" value="' . $property_code . '" />

				<p align="center"><input type="submit" value="Download as Excel file" /></p>
				</form>
				';
		$output .= '</table>';
		}
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    return $output;
	}

/*	REPORT CSV - CANCELLED SALES BY BOOKING DATE */
	function csv_cancelled_sales_booking_report($fromDate,$toDate,$owner_id,$property_code)
	{
		$reportFromDate = $this->global_model->toDisplayDate($fromDate);
		$reportToDate = $this->global_model->toDisplayDate($toDate);
		$bookingFeeTotal = 0;
		$customerPriceTotal = 0;
		$ownerBalanceTotal = 0;
		$commissionTotal = 0;
		$agentTotal = 0;
		$agentFeeTotal = 0;
		$this->db->select('*,fromDate as sortdate');
		$this->db->from('bookings');
		$this->db->join('customers','customers.customer_number = bookings.customerNumber');
		$this->db->join('properties','bookings.propertyCode = properties.property_code');
		$this->db->join('owners','properties.property_owner_id=owners.owner_id');
		$clause_1 = "bookingDate BETWEEN '$fromDate' AND '$toDate'";
		$clause_2 = "CANCELLED";
		$this->db->where($clause_1);
		$this->db->where('bookingStatus', $clause_2);
		if($owner_id != 'any')
		{
			$this->db->where('owner_id',$owner_id);
		}
		if($property_code != 'any')
		{
			$this->db->where('propertyCode',$property_code);
		}
		$this->db->order_by('bookingDate','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$i = 0; // Odd/even counter for alternate coloured <td>'s
    	    $col = ''; // Color style name for alternate coloured <td>'s

    	    $reportDate = date('d M Y');
    	    $output = "\"Owner ref.\",\"IAH ref.\",\"Property\",\"Owner\",\"Arrival\",\"Customer\",\"Nights\",\"Date booked\",\"Booking fee\",\"Price\",\"Owner due\",\"Commission\",\"IAH Due\" \r\n";
			foreach ($query->result() as $item)
			{
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
				$displayBookingDate = $this->global_model->toDisplayDate($item->bookingDate);

				// Do tot-ups
				$bookingFeeTotal += $item->bookingFee;
				$customerPriceTotal += $item->customerPrice;
				$ownerBalanceTotal += $item->ownerBalance;
				$commissionTotal += $item->commissionAmount;
				$agentFeeTotal += $item->agentFee;

				$output .= "\"$item->ownerReference\",\"$item->bookingNumber\",\"$item->property_name\",\"$item->contact_fname $item->contact_sname\",\"$displayFromDate\",\"$item->customer_name $item->customer_surname\",\"$item->customerNights\",\"$displayBookingDate\",\"$item->bookingFee\",\"$item->customerPrice\",\"$item->ownerBalance\",\"$item->commissionAmount\",\"$item->agentFee\" \n";
			}
		$output .="\" \",\" \",\" \",\" \",\" \",\" \",\" \",\"Totals\",\"$bookingFeeTotal\",\"$customerPriceTotal\",\"$ownerBalanceTotal\",\"$commissionTotal\",\"$agentFeeTotal\" \r\n";
		}
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    return $output;
	}

/*	REPORT - BOOKINGS BY ORIGIN */
	function bookings_by_origin_report($fromDate,$toDate,$owner_id,$property_code,$source_code)
	{
		$form = form_open('reports/excel_bookings_by_origin_report');
		$reportFromDate = $this->global_model->toDisplayDate($fromDate);
		$reportToDate = $this->global_model->toDisplayDate($toDate);
		$bookingFeeTotal = 0;
		$customerPriceTotal = 0;
		$ownerBalanceTotal = 0;
		$commissionTotal = 0;
		$agentTotal = 0;
		$agentFeeTotal = 0;
		$this->db->select('*');
		$this->db->from('payments');
		$this->db->join('bookings','payments.paymentBookingNumber = bookings.bookingNumber');
        $clause_1 = "paymentDate BETWEEN '$fromDate' AND '$toDate'";
		$clause_2 = "paymentPurpose = 'Booking payment'";
		$clause_3 = "bookingStatus='PAYMNT'";
		$this->db->where($clause_1);
		$this->db->where($clause_2);
		if($source_code != 'any')
		{
			$this->db->where('sourceCode',$source_code);
		}
		$this->db->order_by('bookingDate','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			$i = 0; // Odd/even counter for alternate coloured <td>'s
    	    $col = ''; // Color style name for alternate coloured <td>'s

    	    $reportDate = date('d M Y');
    	    $output = '
    	    <p>
			<strong>Report name:</strong> Sales Report<br />
			<strong>Report date:</strong> ' . $reportDate .'
			</p>

			<p>
			<strong>From:</strong> ' . $reportFromDate . '<br>
			<strong>To:</strong> ' . $reportToDate . ' </p>
			';
			$output .= '
				<table width="1000" border="1" cellpadding="2" cellspacing="0">
				<tr>
				<th class="mainhead">Owner ref.</th>
				<th class="mainhead">IAH ref.</th>
				<th class="mainhead">Property</th>
				<th class="mainhead">Owner</th>
				<th class="mainhead">Arrival</th>
				<th class="mainhead">Customer</th>
				<th class="mainhead">Country</th>
				<th class="mainhead">Ngts</th>
				<th class="mainhead">Date booked</th>
				<th class="mainhead">Booking fee</th>
				<th class="mainhead">Price</th>
				<th class="mainhead">Owner due</th>
				<th class="mainhead">Comm.</th>
				<th class="mainhead">IAH Due</th>
				</tr>';
			foreach ($query->result() as $item)
			{
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
				$displayBookingDate = $this->global_model->toDisplayDate($item->bookingDate);
				$customerCountry = $this->global_model->get_country_by_id($item->customer_country);

				// Do tot-ups
				$bookingFeeTotal += $item->bookingFee;
				$customerPriceTotal += $item->customerPrice;
				$ownerBalanceTotal += $item->ownerBalance;
				$commissionTotal += $item->commissionAmount;
				$agentFeeTotal += $item->agentFee;

				$output .= '
				<tr>
				<td nowrap class="normal">' . $item->ownerReference . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->bookingNumber . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->property_name . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->contact_fname . ' ' . $item->contact_sname . ' &nbsp;</td>
				<td nowrap class="normal">' . $displayFromDate . ' &nbsp;</td>
				<td nowrap class="normal">' . $item->customer_name . ' ' . $item->customer_surname . '&nbsp;</td>
				<td nowrap class="normal">' . $customerCountry . '&nbsp;</td>
				<td nowrap class="normal">' . $item->customerNights . ' &nbsp</td>
				<td nowrap class="normal">' . $displayBookingDate . ' &nbsp</td>
				<td nowrap class="normal">' . $item->bookingFee . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->customerPrice . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->ownerBalance . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->commissionAmount . ' &nbsp</td>
				<td nowrap class="normal" align="right">' . $item->agentFee . ' &nbsp</td>
				</tr>
				';
			}
		$output .='
				<tr>
				<td colspan="8">&nbsp;</td>
				<td valign="top">Totals:</td>
				<td valign="top" align="right">' . $bookingFeeTotal . '</td>
				<td valign="top" align="right">' . $customerPriceTotal . '</td>
				<td valign="top" align="right" nowrap>' . $ownerBalanceTotal . '</td>
				<td valign="top" align="right">' . $commissionTotal . '</td>
				<td valign="top" align="right">' . $agentFeeTotal . '</td>
				</table>'
				. $form .'
				<input type="hidden" name="fromDate" value="' . $fromDate . '" />
				<input type="hidden" name="toDate" value="' . $toDate . '" />
				<input type="hidden" name="owner_id" value="' . $owner_id . '" />
				<input type="hidden" name="source_code" value="' . $source_code . '" />
				<input type="hidden" name="property_code" value="' . $property_code . '" />

				<p align="center"><input type="submit" value="Download as Excel file" /></p>
				</form>
				';
		}
		else
		{
        	$output = '<h4>There are no records!</h4>';
        }
    return $output;
	}

}// End of Class
?>
