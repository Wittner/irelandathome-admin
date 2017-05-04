<?php
class Rates_model extends Model
{

    function Rates_model()
    {
        parent::Model();
    }

	function get_rdates($propertyCode,$fromDate,$toDate,$nights)
	{
		$checkDate = '';
		$rateNights = 0;// Set as 1 initially because otherwise the arrival date is not counted as a night's stay (from here on it is put back to zero on each loop)
		$xtraDays = 0;
		$xtraDaysMultiplier = 0;
		$xtraDaysRemainder = 0;
		$xtraDaysPrice = 0;
		$finalRate = '';
		$round = 1;
		$co = 0;
		$counter = 0;
		$result = '';
		$matchResult = '';
		$period = 1;
		$ratesFromDate = '';
		$date_parts_fromDate = explode("-", $fromDate);
        $date_parts_toDate = explode("-", $toDate);
        $checkEndDate = strtotime($toDate); // This is to allow us to take one night off at end of stay for calculation purposes
        for($co=0;$co<=$nights;$co++)
        {
			$checkDate[$co] = strtotime(date("Y-m-d", mktime(0,0,0, $date_parts_fromDate[1], $date_parts_fromDate[2]+$co, $date_parts_fromDate[0])));
        }           
		$this->public_db->select('*');
		$this->public_db->from('standardrates');
		$this->public_db->where("propertyCode = $propertyCode");
		$this->public_db->order_by('standardRateId','asc');
		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
			{
				// Loop through all the relevant periods in the rates table
				foreach ($query->result() as $item)
				{

					$dbFromDate = strtotime($item->fromDate);
					$dbToDate = strtotime($item->toDate);
					// Loop through the array of dates that user is staying
					foreach($checkDate as $key => $check)
					{
						// Update rateable nights for each date which falls between the start and end date of the current period
						if($check >= $dbFromDate && $check <= $dbToDate)
						{
							$rateNights ++ ;
							// If we are on the last date of the stay, do a minus 1 because last day is not a night (if you catch my drift!)
							if($check == $checkEndDate)
							{
								$rateNights = $rateNights -1;								
							}
						}
						
					}


					// If we have a chargeable number of rate nights
					if ($rateNights >= 1)
					{
						// Make up a price
						// Get rateNights and divide by 7 for number of chargeable weeks in this period
						if($rateNights >= 8)
						{
							$xtraDaysMultiplier = round(floor($rateNights / 7));// quotient (rounded down because a division ending in .859879 will round UP automatically and give an incorrect number of weeks)
							$rateNights = $rateNights % 7; // modulus
						}
						if($rateNights == 0)
						{
							$result = 0;
						}
						if($rateNights == 1)
						{
							$result = $item->xtraDay;
						}
						if($rateNights == 1 && $nights == 1)
						{
							$result = $item->rateOne;
						}
						elseif($rateNights == 2)
						{
							$result = $item->rateTwo;	
						}
						elseif($rateNights == 3)
						{
							$result = $item->rateThree;
						}
						elseif($rateNights == 4)
						{
							$result = $item->rateFour;
						}
						elseif($rateNights == 5)
						{
							$result = $item->rateFive;
						}
						elseif($rateNights == 6)
						{
							$result = $item->rateSix;
						}
						elseif($rateNights == 7)
						{
							$result = $item->rateSeven;
						}
						if($xtraDaysMultiplier >= 1)
						{
							$result = $result + ($xtraDaysMultiplier * $item->rateSeven);
						}
						$nightsArray[] = '<tr><td>' . $item->standardRateId . '<td>' . $item->fromDate . '</td><td>' . $item->toDate . '</td><td>' . $xtraDaysMultiplier . '</td><td>' . $rateNights . '</td><td>' . $result . '</td></tr>';
					}			
							$rateNights=0; // Return to 0 for next db record
							$xtraDaysMultiplier = 0;
				}
			}
			else
			{
				$result = 'No records';
			}
			foreach($nightsArray as $nights)
			{
				$finalRate .= $nights . '<br />';
			}		
			return $finalRate . '<br />';
	}

/*	LIST RATES TO TABLE */
	function list_rates($propertyCode)
	{
		$this->public_db->select('*');
		$this->public_db->from('standardrates');
		$this->public_db->where("propertyCode = $propertyCode");
		$this->public_db->order_by('standardRateId','asc');
		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
		{
		$output = '
		<table width="100%" border="1">
		<tr><th>Rate Id</th><th>Property</th><th>From</th><th>To</th><th>1 night</th><th>2 nights</th><th>3 nights</th><th>4 nights</th><th>5 nights</th><th>6 nights</th><th>1 week</th><th>Xtra night</th></tr>';
			foreach ($query->result() as $item)
			{
				$output .= '<tr><td>' . $item->standardRateId . '</td><td>' . $item->propertyCode . '</td><td>' . $item->fromDate . '</td><td>' . $item->toDate . '</td><td>' . $item->rateOne . '</td><td>' . $item->rateTwo . '</td><td>' . $item->rateThree . '</td><td>' . $item->rateFour . '</td><td>' . $item->rateFive . '</td><td>' . $item->rateSix . '</td><td>' . $item->rateSeven . '</td>' . '<td>' . $item->xtraDay . '</td></tr>';
			}
		$output .='</table>';
		}
	return $output;
	}

/*	UPDATE A SINGLE RATE */
	function update_single_rate($rateId,$inputData)
	{
		$this->public_db->where('standardRateId', $rateId);
		$this->public_db->update('standardrates', $inputData); 
	}
	
/*	ADD SINGLE RATE */
	function add_single_rate($inputData)
	{
		$this->public_db->insert('standardrates', $inputData); 
	}

/* DELETE SINGLE RATE */
	function delete_single_rate($rateId)
	{
		$this->public_db->where('standardRateId', $rateId);
		$this->public_db->delete('standardrates'); 
	}
	
/* SWAP RATES */
	function swap_rates($source,$target)
	{
		$this->public_db->delete('standardrates', array('propertyCode' => $target));
		$this->public_db->select('*');
		$this->public_db->from('standardrates');
		$this->public_db->where("propertyCode = '$source'");
		$this->public_db->order_by('standardRateId', 'asc');
		$query = $this->public_db->get();
        if ($query->num_rows() > 0)
		{
            foreach ($query->result() as $item)
			{
				$this->public_db->set('propertyCode',$target);
				$this->public_db->set('fromDate',$item->fromDate);
				$this->public_db->set('toDate',$item->toDate);
				$this->public_db->set('rateOne',$item->rateOne);
				$this->public_db->set('rateTwo',$item->rateTwo);
				$this->public_db->set('rateThree',$item->rateThree);
				$this->public_db->set('rateFour',$item->rateFour);
				$this->public_db->set('rateFive',$item->rateFive);
				$this->public_db->set('rateSix',$item->rateSix);
				$this->public_db->set('rateSeven',$item->rateSeven);
				$this->public_db->set('xtraNight',$item->xtraNight);
				$this->public_db->insert('standardrates');
			}
		}
	return 'done';
	}
	
  
}// End of Class
?>