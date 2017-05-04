<meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
<?php
class Ratescheck_model extends Model
{

    function Ratescheck_model()
    {
        parent::Model();
    }

	function get_rates($propertyCode,$fromDate,$toDate,$nights)
	{
		$hiSeasonStart = strtotime($this->property_model->get_high_season_dates('start', $propertyCode));
		$hiSeasonEnd = strtotime($this->property_model->get_high_season_dates('end', $propertyCode));
		$nightsArray = array('');
		$total = 0;
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
		$dayCounter = 0;
		$result = '';
		$matchResult = '';
		$period = 1;
		$satNights=0;
		$peakWkNights =0;
		$peakNights=0;
		$dayName='';
		$ratesFromDate = '';
		$date_parts_fromDate = explode("-", $fromDate);
        $date_parts_toDate = explode("-", $toDate);
        $checkEndDate = strtotime($toDate); // This is to allow us to take one night off at end of stay for calculation purposes
        for($co=0;$co<=$nights-1;$co++)
        {
			$checkDate[$co] = strtotime(date("Y-m-d", mktime(0,0,0, $date_parts_fromDate[1], $date_parts_fromDate[2]+$co, $date_parts_fromDate[0])));
        }           
		$this->public_db->select('*');
		$this->public_db->from('standardrates');
		$this->public_db->where("propertyCode = '$propertyCode'");
		$this->public_db->order_by('fromDate','asc');
		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
			{
				// Loop through all the relevant periods in the rates table
				foreach ($query->result() as $item)
				{
    				$satNights = 0;
    				$peakNights = 0;
					$dbFromDate = strtotime($item->fromDate);
					$dbToDate = strtotime($item->toDate);
					//echo 'Period id: ' . $item->standardRateId . ' From date: ' . date("d-m-Y",$dbFromDate) . ' To date: ' . date("d-m-Y",$dbToDate) . '<br />';
					// Loop through the array of dates that user is staying
					foreach($checkDate as $key => $check)
					{
						//echo 'Check date ->' . date("d-m-Y", $check) . '<br />';
						// Update rateable nights for each date which falls between the start and end date of the current period
						if($check >= $dbFromDate && $check <= $dbToDate)// If the given from/to dates are between the db dates
						{
							$dayCounter ++;
							if($check >= $hiSeasonStart && $check <= $hiSeasonEnd) // If we are in the high season
							{
    						 // Keeps count of the total number of days in the stay
    								//echo 'High season' . '<br />';
								$satCheck = date("D", $check);
								if ($satCheck == 'Sat')
         							{
          								
									$rateNights = $rateNights + 7;
									$satNights ++;
          								//echo ' Saturdays: ' . $rateNights . '<br />' ;
         							}
								else
								{
									if($satNights == 0)
									{
										$rateNights = 7;
									}
								}

							} // End of high season check
							else // We are not in the high season
							{
								$rateNights ++ ;
								//echo $rateNights . ' ' . date("d-m-y", $check) . ' ' . date("d-m-y", $checkDate[0]) . ' ' . $item->standardRateId . '<br />';

							}
						}
                    
					}


					// If we have a chargeable number of rate nights within the current period
					//echo 'Rateable nights: ' . $rateNights . '<br /><br />';
					
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
						if($rateNights == 1 and $dayCounter >= 2)
						{

							$result = $item->xtraNight;
						}
						if($rateNights == 1 and $dayCounter == 1)
						{
							$result = $item->rateOne;
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
						$total = $total + $result;
						$nightsArray[] = '<tr><td>' . $item->standardRateId . '</td><td>' . $this->global_model->toDisplayDate($item->fromDate) . '</td><td>' . $this->global_model->toDisplayDate($item->toDate) . '</td><td>' . $xtraDaysMultiplier . '</td><td>' . $rateNights . '</td><td>' . $result . '</td><td>' . $total . '</td></tr>';

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
				$finalRate .= $nights;
			}
			return $finalRate;
	}

/*	LIST RATES TO TABLE */
	function list_rates($propertyCode)
	{
		$output = '';
		$this->public_db->select('*');
		$this->public_db->from('standardrates');
		$this->public_db->where("propertyCode = '$propertyCode'");
		$this->public_db->order_by('fromDate','asc');
		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
		{
		$output = '
		<table width="100%" border="1">
		<tr><th>Rate Id</th><th>Property</th><th>From</th><th>To</th><th>1 night</th><th>2 nights</th><th>3 nights</th><th>4 nights</th><th>5 nights</th><th>6 nights</th><th>1 week</th><th>Xtra night</th></tr>';
			foreach ($query->result() as $item)
			{
				$output .= '<tr><td>' . $item->standardRateId . '</td><td>' . $item->propertyCode . '</td><td>' . $this->global_model->toDisplayDate($item->fromDate) . '</td><td>' . $this->global_model->toDisplayDate($item->toDate) . '</td><td>' . $item->rateOne . '</td><td>' . $item->rateTwo . '</td><td>' . $item->rateThree . '</td><td>' . $item->rateFour . '</td><td>' . $item->rateFive . '</td><td>' . $item->rateSix . '</td><td>' . $item->rateSeven . '</td>' . '<td>' . $item->xtraNight . '</td></tr>';
			}
		$output .='</table>';
		}
	return $output;
	}
	
  
}// End of Class
?>