<?php

/**
 * @author Mike Brady
 * @copyright 2008
 */

class Availability_model extends Model
{
    var $calendarOutput;

    function Availability_model()
    {
        parent::Model();
        $this->load->model('global_model');
    }

    // GET THE LATEST AVAILABILITY INFO FROM THE DB
    function getLatestAvailability($townId,$calendarDate,$rooms,$sleeps,$code)
    {
        $rootPage = base_url();

        // Set incoming date var (if set, it comes in from controller)
       	$splitDate = explode('-',$calendarDate);
		$day_in = 1;
       	$month_in = $splitDate[1];
       	$year_in = $splitDate[0];

        // Make a current date: This will, on the final cut, bring in a date from somewhere, probably as a class
        $date = mktime(0, 0, 0, $month_in, $day_in, $year_in);

        // This puts the day, month, and year in seperate variables
        $calendarDate = date('Y-m-d', $date);
        $day = date('d', $date);
        $dayname = date('l', $date);
        $datenum = date('jS', $date);

        $month = date('m', $date);
        $monthname = date('F', $date);
        $year = date('Y', $date);

        // Here we generate the first day of the month
        $first_day = mktime(0, 0, 0, $month, 1, $year);
        // This gets us the month name
        $title = date('F', $first_day);
        // How many days in current month
        $days_in_month = cal_days_in_month(0, $month, $year);

        // Test output string
        $output = "Days in current month ->" . $days_in_month . "<br />" .
            "Current date in English ->" . $dayname . ", the " . $datenum . " of " . $monthname .
            "<br />" . $day . "/" . $month . "/" . $year;
        //echo $output."<br /><br />";

        // ===================== Set header for table ==============================================================
        // First get town name for table header
        $query = $this->public_db->query("SELECT town_name from towns where town_id='$townId'");

        if ($query->num_rows() > 0)
        {
            // Loop result set and fill an array
            foreach ($query->result_array() as $row)
            {
                $townName = $row['town_name'];
            }
        }

        $span = $days_in_month + 1;

        // Calendar header div
        $prevMonth = date('Y-m-d', mktime(0, 0, 0, $month-1, 1,   $year));// might not need these two lines any more
        $nextMonth = date('Y-m-d', mktime(0, 0, 0, $month+1, 1,   $year));// might not need these two lines any more        
        
        $calendarOutput = "<div  class=\"table_header\"><strong>$monthname, $year: $townName availability</strong></div>";

        // Plot day names
        $calendarOutput .= '<table class="avail" cellpadding="4" cellspacing="0" border="0">';
        $calendarOutput .= "<tr><td class=\"avail_blank\">&nbsp;</td>";
        for ($co = 1; $co <= $days_in_month; $co++)
        {
            $displayDate = mktime(0, 0, 0, $month_in, $co, $year_in);
            $displayDayName = date('D', $displayDate);
            $calendarOutput .= "<td class=\"avail_cellhead\" width=\"23\">{$displayDayName}</td>";
        }
        $calendarOutput .= "</tr>";

        // Plot day numbers
        $calendarOutput .= "<tr><td class=\"avail_blank\">&nbsp;</td>";
        for ($co = 1; $co <= $days_in_month; $co++)
        {
            $displayDate = mktime(0, 0, 0, $month_in, $co, $year_in);
            $displayDayNum = date('d', $displayDate);
            $calendarOutput .= "<td class=\"avail_cellhead\">{$displayDayNum}</td>";
        }
        $calendarOutput .= "</tr>";

        // ===================== Get current live properties and put into an array ==============
        
        $this->public_db->select('property_name, property_code, property_units, livebook');
        $this->public_db->from('properties');
        $this->public_db->join('towns','towns.town_id = properties.property_town_id','left');
		$this->public_db->where('towns.town_id',$townId);
        $this->public_db->where('property_status','LVE');
        if($rooms != 'any')
        {
        	$this->public_db->where('property_bedrooms =',$rooms);
        }
        if($sleeps != 'any')
        {
        	$this->public_db->where('property_capacity >=',$sleeps);
        }
        if($code != 'any')
        {
        	$this->public_db->where('sort_code',$code);
        }
        $this->public_db->order_by('property_name');
        
        $query = $this->public_db->get('properties');

        if ($query->num_rows() > 0)
        {
            // Loop result set and fill an array
            foreach ($query->result_array() as $row)
            {
                $propertyCode[] = $row['property_code'];
                $propName[] = addslashes($row['property_name']);
                $leftColPropName[] = $row['property_name'];
                $propAlloc[] = $row['property_units'];
                $liveBook[] = $row['livebook'];
            }

            // For each property, start to output the calendar, and at each day, check the availability table for a match
            // and set booking status as appropriate.
            foreach ($propertyCode as $key => $valuePropertyCode)
            {
            	if($liveBook[$key] == 'YES'){$livebookClass = "_livebook";}else{$livebookClass = "";}
                $calendarOutput .= "<tr><td class=\"avail_leftcol$livebookClass\">{$leftColPropName[$key]}</td>";


                // Begin calendar output
                for ($co = 1; $co <= $days_in_month; $co++)
                {
                    // Some fields for matching calendar and availability dates
                    $chkDate = mktime(0, 0, 0, $month, $co, $year);
                    $calDate = date("Y-m-d", $chkDate);
                    $displayAvailDate = date("M d Y", $chkDate);
                    $satClass="";
                    $day_of_week_check = date("D", $chkDate);
                    if($day_of_week_check == "Sat")
                    {
                    	$satClass="_sat";
                    }
                    else
					{
                    	$satClass="";
                    }

                    // Pull matching records from DB
                    $query = $this->public_db->query("select availDate, availAlloc from availability where availPropertyCode='$valuePropertyCode' and availDate = '$calDate'");
                    if ($query->num_rows() > 0)
                    {
                        foreach ($query->result_array() as $row)
                        {
                            $availDate = $row['availDate'];
                            $availAlloc = $row['availAlloc']; // remainding allocation in availability db
                            $remainderAlloc = $propAlloc[$key] - $availAlloc; // remainderAlloc = property record allocation amount
                            	if ($remainderAlloc <= 0)
                            	{
                                	// No availability
									$calendarOutput .= "<td class=\"avail_data_booked$satClass\" ALIGN=\"center\"><a href=\"javascript:setReleaseVars('$calendarDate','$townId','$propertyCode[$key]','$propName[$key]','$displayAvailDate','$calDate','release')\"><strong><u>X</u></strong></a></td>";
                            	}
                            	else
                            	{
                                	// Availability but with some bookings left
									$calendarOutput .= "<td class=\"avail_data_free$satClass\" ALIGN=\"center\"><a href=\"javascript:setVars('$calendarDate','$townId','$propertyCode[$key]','$propName[$key]','$displayAvailDate','$calDate','booking')\"\"><strong><u>$remainderAlloc</u></strong></a></td>";
                            	}
                        }
                    } else
                    {
                        // Completely unbooked
						$calendarOutput .= "<td class=\"avail_data_free$satClass\" ALIGN=\"center\"><a href=\"javascript:setVars('$calendarDate','$townId','$propertyCode[$key]','$propName[$key]','$displayAvailDate','$calDate','booking')\"><strong><u>$propAlloc[$key]</u></strong></a></td>";
                    }
                }
                $query->free_result();
                $calendarOutput .= "</tr>";
            }
        } else
        {
            $output = '<h4>There were no records!</h4>';
        } // End of num_rows if
        $calendarOutput .= '</table>';
        return $calendarOutput;
    } // End of getLatestAvailability

    // LOAD UP THE INFO FOR THE CONTROL BAR TOWNS DROPDOWN
    function make_towns_combo($townId)
    {
        // Town dropdown
        // Vars
        $townsDropDown = '';
        // ===================== Get town dropdown info ==============
        $query = $this->public_db->query("SELECT town_id, town_name from towns ORDER BY town_name");

        if ($query->num_rows() > 0)
        {
            // Loop result set and fill an array
            foreach ($query->result_array() as $row)
            {
                $townSelectId = $row['town_id'];
                $townName = $row['town_name'];
                $townsDropDown .= '<option value="' . $townSelectId . '"';
				if($townSelectId == $townId)
				{
					$townsDropDown .= ' selected';
				}
				$townsDropDown .= '>' . $townName . '</option>';
            }
        }
        return $townsDropDown;
    } // End of load_toolbars


    function add_availability($propertyCode,$fromDate,$customerNights)
    {
		// First check if required availability is actually available
		
		// Work out all the dates from arrival to departure
		$list='';
		$splitFromDate=explode("-",$fromDate);
		$fromDay = $splitFromDate[2];
		$fromMonth = $splitFromDate[1];
		$fromYear = $splitFromDate[0];
        for($co=0;$co<=$customerNights-1;$co++)
		{
   			$insertDate=date("Y-m-d", mktime(0, 0, 0, $fromMonth, $fromDay+$co, $fromYear));
   			$query = $this->public_db->query("select availAlloc from availability where availDate = '$insertDate' and availPropertyCode='$propertyCode' ");// This to find if there's a matching entry
   			if ($query->num_rows() >= '1')
   			{
   				$query = $this->public_db->query("update availability set availAlloc=availAlloc+1 where availDate='$insertDate' and availPropertyCode='$propertyCode'");
   			}
			else
   			{
   				$query = $this->public_db->query("insert into availability (availId, availPropertyCode, availStatus, availAlloc, availDate)values('', '$propertyCode', 'BOOKED', 1, '$insertDate') ");
   			}
   			
		}
		
        $availResult = "Availability updated!";
        return $availResult;
    }

	function release_availability($propertyCode,$fromDate,$numberNights)
    {
		// First work out all the dates from arrival to departure
		$list='';
		$splitFromDate=explode("-",$fromDate);
		$fromDay = $splitFromDate[2];
		$fromMonth = $splitFromDate[1];
		$fromYear = $splitFromDate[0];
        for($co=0;$co<=$numberNights-1;$co++)
		{
   			$insertDate=date("Y-m-d", mktime(0, 0, 0, $fromMonth, $fromDay+$co, $fromYear));
   			$query = $this->public_db->query("select * from availability where availDate='$insertDate' and availPropertyCode = '$propertyCode'");
   			if ($query->num_rows() > 0)
        	{
            	// Loop result set and fill an array
            	foreach ($query->result_array() as $item)
            	{
					if($item->availAlloc >= 2)
					{
                        $query = $this->public_db->query("update availability set availAlloc=availAlloc-1 where availDate='$insertDate' and availPropertyCode='$propertyCode'");
					}
					else
					{
                        $query = $this->public_db->query("update availability set availAlloc='80' where availDate='$insertDate' and availPropertyCode='$propertyCode'");
					}
            	}
			}
		
        $availResult = "Availability updated!";
        return $availResult;
    }
    
    function make_month_combo($selectedDate)
    {
    	// Make combo for choosing other months for 12 months ahead from current date (start count at 0 to allow for current month)
		$monthCombo = '';
		// Set a current date (on first day of month) for date picker combo
       	$currentDate = date('Y-m-d');
		$currentDateArr = explode('-',$currentDate);
		for($co=0;$co<=11;$co++)
		{
			$selectMonth =  date('Y-m-d', mktime(0, 0, 0, $currentDateArr[1]+$co, 1, $currentDateArr[0]));
			$displaySelectMonth =  date('M Y', mktime(0, 0, 0, $currentDateArr[1]+$co, 1, $currentDateArr[0]));
			$monthCombo .= '<option value="' . $selectMonth . '"';
			if($selectMonth == $selectedDate)
			{
				$monthCombo .= ' selected';
			}
			$monthCombo .= '>' . $displaySelectMonth . '</option>';
		}
		return $monthCombo;
    }

} // End of class





?>
