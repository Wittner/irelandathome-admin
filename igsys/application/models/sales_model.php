<?php
class Sales_model extends Model
{

/*  CONSTRUCTOR */
    function Sales_model()
    {
        parent::Model();
        $this->load->model('global_model');
        $this->load->model('customer_model');
        $this->load->model('offer_model');
    }

/*  CREATE NEW SALE */
    function create_new_sale($enquiryDate,$saleDate,$saleStatus,$customerNights,$customerNumber,$customerReferral,$propertyList,$fromDate,$fromTime,$adults,$children,$infants,$cot,$highchair,$toDate,$toTime,$propertyCode,$customerSpecials,$sourceCode,$adminInit)
    {
           $data = array(
            'salesId' 		=> '',
            'enquiryDate' 		=> $enquiryDate,
            'saleDate'			=> $saleDate,
            'customerNights' 	=> $customerNights,
            'customerNumber' 	=> $customerNumber,
            'customerReferral' 	=> $customerReferral,
            'propertyList' 		=> $propertyList,
            'fromDate' 			=> $fromDate,
            'fromTime' 			=> $fromTime,
            'adults' 			=> $adults,
            'children'		 	=> $children,
            'infants'			=> $infants,
            'cot'				=> $cot,
            'highchair'			=> $highchair,
            'toDate' 			=> $toDate,
            'toTime' 			=> $toTime,
            'propertyCode' 		=> $propertyCode,
            'customerSpecials' 	=> $customerSpecials,
            'saleStatus'	 	=> $saleStatus,
            'adminInit' 		=> $adminInit,
            'sourceCode' 		=> $sourceCode);

        // Add the new sale
      $this->db->insert('sales', $data);
      $salesId = $this->db->insert_id();
      return $salesId;
    }


/*	GET SALE BY ID */
    function get_sale_by_id($salesId)
    {
		$query  = 	$this->db->query("
									select *, sales.cot as salesCot, sales.highchair as salesHighchair
									from sales
									left join customers
									on customers.customer_number = sales.customerNumber
									left join companies
									on customers.customerCompanyId = companies.companyId
									left join properties
									on properties.property_code = sales.propertyCode
									left join owners
									on owners.owner_id = properties.property_owner_id
									where salesId = $salesId");
    	return $query;
    }

/*	UPDATE SALE BY ID */
    function update_sale($saleId,$customerNights,$customerNumber,$customerReferral,$propertyList,$fromDate,$fromTime,$adults,$children,$infants,$cot,$highchair,$toDate,$toTime,$propertyCode,$customerSpecials)
    {
	     $data = array(
          'customerNights' 	=> $customerNights,
          'customerNumber' 	=> $customerNumber,
          'customerReferral' 	=> $customerReferral,
          'propertyList' 		=> $propertyList,
          'fromDate' 			=> $fromDate,
          'fromTime' 			=> $fromTime,
          'adults' 			=> $adults,
          'children'		 	=> $children,
          'infants'			=> $infants,
          'cot'				=> $cot,
          'highchair'			=> $highchair,
          'toDate' 			=> $toDate,
          'toTime' 			=> $toTime,
          'propertyCode' 		=> $propertyCode,
          'customerSpecials' 	=> $customerSpecials
        );

      $this->db->where('salesId', $saleId);
      $this->db->update('sales', $data);
      return "done";
    }

/* COUNT CURRENT SALES */
	function count_current_sales()
	{
		$query = $this->db->query("select salesId
						  from sales
						  left join customers
						  on customers.customer_number=sales.customerNumber
						  where saleStatus = 'OPEN' or saleStatus = 'PAID'");
		$rows = $query->num_rows();
		return $rows;
	}


/*	LIST SALES */
	function list_sales($num,$offset)
	{
	$i=0;// Counter
	$output  ='<table width="100%" border="0">';
	$this->db->select('saleDate, fromDate, customerSpecials, customer_name, customer_surname, salesId, customer_email, saleStatus');
	$this->db->from('sales');
	$this->db->join('customers', 'customers.customer_number=sales.customerNumber');
	$where = "saleStatus = 'OPEN' or saleStatus = 'PAID'";
	$this->db->where($where);
	$this->db->order_by('sales.salesId','desc');
	$this->db->limit($num, $offset);
	$query = $this->db->get();

	if ($query->num_rows() > 0)
	{
	$output .='<tr><th>Booking Date</th><th>Arrival</th><th>Customer</th><th>Sale Id.</th><th>email</th><th colspan="3" align="center">Action</th></tr>';
        	foreach ($query->result() as $item)
			{
				$displayBookingDate = $this->global_model->toDisplayDate($item->saleDate);
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
        		$i = $i + 1;
            	$col = ($i % 2) ? 'hilite' : 'lowlite';
            	$output
				.='<tr>'
				. '<td class="' . $col . '">' . $displayBookingDate . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $displayFromDate . '&nbsp;</td>';
				if($item->customerSpecials != '')
				{
					$output .= '<td class="' . $col . '"><a href="" title="' . $item->customerSpecials . '"><strong>' . $item->customer_name. ' ' . $item->customer_surname . '&nbsp;</a></td>';
				}
				else
				{
					$output .= '<td class="' . $col . '">' . $item->customer_name. ' ' . $item->customer_surname . '&nbsp;</a></td>';
				}
				$output
				.='<td class="' . $col . '">' . $item->salesId . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->customer_email . '&nbsp;</td>'
				. '<td width="15"><a href="index.php/sales/edit_sale/' . $item->salesId .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>'
				. '<td width="15">';
					if($item->saleStatus=='PAID')
					{
						$output .= '<img src="images/app/smiley.gif" border="0" width="20" height="20" title="Payment received!"/>';
					}
					else
					{
						$output .= '&nbsp;';
					}
				$output
				.= '<td width="30">&nbsp;</td></tr>';
        	}
    }
	else
	{
       	$output = '<h4>There are no records!</h4>';
    }
    $output .= '</table>';
    return $output;
	}

/*	GET SALES DATA OUTPUT FOR MARQUEE */
	function get_sales_marquee()
	{
	$output  ='<strong> Payments -> </strong> ';
	$query =	$this->db->query("select * from sales left join customers on customers.customer_number=sales.customerNumber where saleStatus = 'PAID' order by fromDate");
	if ($query->num_rows() > 0)
		{
        	foreach ($query->result() as $item)
			{
				$displayBookingDate = $this->global_model->toDisplayDate($item->saleDate);
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);

            	$output .= '|<a href="index.php/sales/edit_sale/' . $item->salesId . '"> ' . $item->customer_name . ' ' . $item->customer_surname . ' ' . $displayBookingDate .'</a>| ';
	        }
	    }
		else
		{
        	$output = '';
        }
    return $output;
	}

/* 	CHANGE CUSTOMER EMAIL STATUS ON BOOKING */
	/*
	Customer email notification codes in bookings table look like this CDN|CFN|CRN
	First element is customer deposit status, second is customer final status and third is customer reference obtained status
	*/
	function change_sale_status($saleId,$status)
	{
		$query = $this->db->query("select saleStatus from sales where salesId ='$saleId'");
		foreach ($query->result() as $item)
		{
			switch($status)
			{
				case 'delete':
					$newSaleStatus = 'DEL';
				break;
				case 'archive':
					$newSaleStatus = 'ARC';
					break;
				default:
					$newSaleStatus = 'OPEN';
			}
		}
		$query =	$this->db->query("update sales set saleStatus = '$newSaleStatus' where salesId = '$saleId'");
	}

	function change_owner_booking_email_status($bookingNumber,$status)
	{
		$query = $this->db->query("select ownerNotificationStatus from bookings where bookingNumber ='$bookingNumber'");
		foreach ($query->result() as $item)
		{
			$ownerEmailStatus = explode("|", $item->ownerNotificationStatus);
			switch($status)
			{
				case 'deposit_paid':
					$newStatus = array('ODS',$ownerEmailStatus[1],$ownerEmailStatus[2]);
				break;
				case 'paid_in_full':
					$newStatus = array($ownerEmailStatus[0],'OFS',$ownerEmailStatus[2]);
				break;
				case 'reference_obtained':
					$newStatus = array($ownerEmailStatus[0],$ownerEmailStatus[1],'ORS');
				break;

			}
		}
		$ownerEmailStatus = implode('|',$newStatus);
		$query =	$this->db->query("update bookings set ownerNotificationStatus = '$ownerEmailStatus' where bookingNumber = '$bookingNumber'");
	}

/*	SEARCH THROUGH SALES BY CUSTOMER NUMBER*/
	function get_sales_by_customerid($customerNumber)
	{
	$i=0;// Counter
	$output  ='<table width="100%" border="0">';
	$this->db->select('*');
	$this->db->from('sales');
	$this->db->join('customers', 'customers.customer_number=sales.customerNumber');
	$where = "(saleStatus = 'OPEN' or saleStatus = 'PAID') and customerNumber = '$customerNumber'";
	$this->db->where($where);
	$this->db->order_by('salesId','desc');
	$query = $this->db->get();

	if ($query->num_rows() > 0)
	{
	$output .='<tr><th>Booking Date</th><th>Arrival</th><th>Customer</th><th>Sale Id.</th><th>email</th><th colspan="3" align="center">Action</th></tr>';
        	foreach ($query->result() as $item)
			{
				$displayBookingDate = $this->global_model->toDisplayDate($item->saleDate);
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
        		$i = $i + 1;
            	$col = ($i % 2) ? 'hilite' : 'lowlite';
            	$output
				.='<tr>'
				. '<td class="' . $col . '">' . $displayBookingDate . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $displayFromDate . '&nbsp;</td>';
				if($item->customerSpecials != '')
				{
					$output .= '<td class="' . $col . '"><a href="" title="' . $item->customerSpecials . '"><strong>' . $item->customer_name. ' ' . $item->customer_surname . '&nbsp;</a></td>';
				}
				else
				{
					$output .= '<td class="' . $col . '">' . $item->customer_name. ' ' . $item->customer_surname . '&nbsp;</a></td>';
				}
				$output
				.='<td class="' . $col . '">' . $item->salesId . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->customer_email . '&nbsp;</td>'
				. '<td width="15"><a href="index.php/sales/edit_sale/' . $item->salesId .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>'
				. '<td width="15">';
					if($item->saleStatus=='PAID')
					{
						$output .= '<img src="images/app/smiley.gif" border="0" width="20" height="20" title="Payment received!"/>';
					}
					else
					{
						$output .= '&nbsp;';
					}
				$output
				.= '<td width="30">&nbsp;</td></tr>';
        	}
    }
	else
	{
       	$output = '<h4>There are no records!</h4>';
    }
    $output .= '</table>';
    return $output;
	}

/* UPDATE OFFER SENT DATE */
	function set_sale_offer_sent_date($saleId)
	{
		$offerSentDate = date('Y-m-d');
		$query = $this->db->query("update sales set offerSentDate = '$offerSentDate' where salesId = '$saleId'");
	}

/*	SEND AN OFFER FROM SALE */
    function send_offer()
    {
    	$this->offer_model->send_offer($saleId);
    }

/*	FIND SALES */
	function find_sales($searchBy,$kwd)
	{
		switch ($searchBy)
		{
			case "name":
			$query = $this->db->query("
			SELECT salesId, fromDate, toDate, customerSpecials, customer_name, customer_email, customer_surname, saleStatus
			from customers
			left join sales
			on customers.customer_number = sales.customerNumber
			where customer_name like '%$kwd%'
			and saleStatus != 'DEL'
			ORDER BY salesId
			");
			break;

			case "surname":
			$query = $this->db->query("
			SELECT salesId, fromDate, toDate, customerSpecials, customer_name, customer_email, customer_surname, saleStatus
			from customers
			left join sales
			on customers.customer_number = sales.customerNumber
			where customer_surname like '%$kwd%'
			and saleStatus != 'DEL'
			ORDER BY salesId
			");
			break;

			case "property":
			$query = $this->db->query("
			SELECT salesId, fromDate, toDate, customerSpecials, customer_name, customer_email, customer_surname, saleStatus
			from sales
			left join customers
			on customers.customer_number = sales.customerNumber
			where sales.propertyCode = '$kwd'
			and saleStatus != 'DEL'
			ORDER BY salesId
			");
			break;

			case "cusno":
			$query = $this->db->query("
			SELECT salesId, fromDate, toDate, customerSpecials, customer_name, customer_email, customer_surname, saleStatus
			from sales
			left join customers
			on customers.customer_number = sales.customerNumber
			where sales.customerNumber = '$kwd'
			and saleStatus != 'DEL'
			ORDER BY salesId
			");
			break;

			case "book_id":
			$query = $this->db->query("
			SELECT salesId, fromDate, toDate, customerSpecials, customer_name, customer_email, customer_surname, saleStatus
			from sales
			left join customers
			on customers.customer_number = sales.customerNumber
			where salesId = '$kwd'
			and saleStatus != 'DEL'
			ORDER BY salesId
			");
			break;

			case "referrer":
			$query = $this->db->query("
			SELECT salesId, fromDate, toDate, customerSpecials, customer_name, customer_email, customer_surname, saleStatus
			from sales
			left join customers
			on customers.customer_number = sales.customerNumber
			where customerReferral = '$kwd'
			and saleStatus != 'DEL'
			ORDER BY salesId
			");
			break;

			default:
			$query = $this->db->query("select * from sales where salesId = '0'");
			break;
		}
		if ($query->num_rows() > 0)
		{
			$i = 0; // Odd/even counter for alternate coloured <td>'s
    	    $col = ''; // Color style name for alternate coloured <td>'s
        	$output = '<table width="100%" border="0"><tr><th width="80">Arrival</th><th width="80">Departure</th><th width="80">ID</th><th width="160">Name</th><th>Email</th><th colspan="3">Action</th></tr>';
        	foreach ($query->result() as $item)
			{
				$displayFromDate = $this->global_model->toDisplayDate($item->fromDate);
				$displayToDate = $this->global_model->toDisplayDate($item->toDate);
        		$i = $i + 1;
            	$col = ($i % 2) ? 'hilite' : 'lowlite';
            	$output
				.='<tr>'
				. '<td class="' . $col . '">' . $displayFromDate . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $displayToDate . '&nbsp;</td>'
				. '<td class="' . $col . '">' . $item->salesId . '&nbsp;</td>';
				if($item->customerSpecials != '')
				{
					$output .= '<td class="' . $col . '"><a href="" title="' . $item->customerSpecials . '"><strong>' . $item->customer_surname. ' ' . $item->customer_name . '&nbsp;</a></td>';
				}
				else
				{
					$output .= '<td class="' . $col . '">' . $item->customer_name. ' ' . $item->customer_surname . '&nbsp;</a></td>';
				}
				$output
				.='<td class="' . $col . '">' . $item->customer_email . '&nbsp;</td>'
				. '<td width="15"><a href="index.php/sales/edit_sale/' . $item->salesId .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>'
				. '<td width="15">';
					if($item->saleStatus=='PAID')
					{
						$output .= '<img src="images/app/smiley.gif" border="0" width="20" height="20" title="Payment received!"/>';
					}
					else
					{
						$output .= '&nbsp;';
					}
				$output
				.= '<td width="30">&nbsp;</td></tr>';
        	}
	    }
		else
		{
	       	$output = '<h4>There are no records!</h4>';
	    }
	    $output .= '</table>';
	    return $output;
		}


} // End of class



?>
