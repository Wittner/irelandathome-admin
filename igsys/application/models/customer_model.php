<?php
class Customer_model extends Model
{

    function Customer_model()
    {
        parent::Model();
        $this->load->model('global_model');
    }

/*	GET CUSTOMER BY NUMBER */    
	function get_customer_by_number($customerNumber)
	{
		$this->db->select('*');
		$this->db->from('customers');
		$this->db->where('customer_number', $customerNumber);
		$query = $this->db->get();	
		return $query;
	}
	
/*	CHECK CUSTOMER EXISTS */	
	function customer_exist($customerEmail)
    // Returns customer_number if customer exists
    {
    	// This method checks if a customer exists by searching against their email address
    	$query = $this->db->query("SELECT customer_number from customers WHERE customer_email='$customerEmail'");
    	if ($query->num_rows() > 0)
    	{
    		foreach ($query->result_array() as $row)
            {
				$customerNumber = $row['customer_number'];
    		}
    	}
    	else{
    		$customerNumber = '';
    	}
    	return $customerNumber;
    }
    
    function find_customer($searchBy,$keyword)
    {
		
		switch ($search_by)
		{
			case "name":
				$sql="
				select *
				from customers
				where customer_name like '$keyword'
				and customer_status !='DEL'
				";
			break;
			
			case "surname":
				$sql="
				select *
				from customers
				where customer_surname like '$keyword'
				and customer_status !='DEL'
				";
			break;
			
			case "cusno":
				$sql="
				select *
				from customers
				where customer_number like '$keyword'
				and customer_status !='DEL'
				";
			break;
			
			case "email":
				$sql="
				select *
				from customers
				where customer_email like '$keyword'
				and customer_status !='DEL'
				";
			break;
			
			default:
			$display_block .="<a href=\"check_cus_deposit_notify.php?booking_id=$booking_id\"><img src=\"env_open.png\" border=\"0\"  alt=\"Send customer notification\"></a>&nbsp;<a href=\"check_owner_deposit_notify.php?booking_id=$booking_id\"><img src=\"env_open.png\" border=\"0\"  alt=\"Send owner notification\"></a>&nbsp;";
		}
    }
    
/* 	LIST CUSTOMERS */
	function list_customers()
	{
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        $output = '<table width="100%" border="0"><tr><th>Number</th><th>Name</th><th>Phone</th><th>Mobile</th><th>Email</th><th>Date</th><th colspan="5">Action</th></tr>';
		$this->db->select('*');
		$this->db->from('customers');
		$this->db->where("customer_status='QUERY1'");
		$this->db->order_by('customer_id','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
            foreach ($query->result() as $item)
			{
                $i = $i + 1;
                $col = ($i % 2) ? 'hilite' : 'lowlite';
                $output .= '<tr>' .
					'<td class="' . $col . '">' . $item->customer_number .'&nbsp;</td>' . 
					'<td class="' . $col . '">' . $item->customer_name . ' ' . $item->customer_surname . '&nbsp;</td>' .
                    '<td class="' . $col . '">' . $item->customer_landphone . '&nbsp;</td>' .
                    '<td class="' . $col . '">' . $item->customer_mobile . '&nbsp;</td>' .
                    '<td class="' . $col . '"><a href="mailto:' . $item->customer_email . '">' . $item->customer_email . '</a>&nbsp;</td>' .
                    '<td class="' . $col . '">' . $item->customer_date . '&nbsp;</td>';
				$output
					.='<td width="15"><a href="index.php/customers/edit_customer/' . $item->customer_number .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this customer record"/></a></td>'
					. '<td width="15"><a href="index.php/customers/delete_customer/' . $item->customer_number . '"><img src="images/app/delete.gif" border="0" width="20" height="20" title="Delete this customer"/></a></td>'
					. '<td width="15"><a href="index.php/sales/create_customer_sale/' . $item->customer_number . '"><img src="images/app/makesale.gif" border="0" width="20" height="20" title="Create sale for this customer"/></a></td>'
					. '<td width="15"><a href="index.php/search/customer_sales/' . $item->customer_number . '"><img src="images/app/listsales.gif" border="0" width="20" height="20" title="View customer sales"/></a></td>'														
					. '</tr>';
            }
        } else {
            $output = '<h4>No search results found!</h4>';
        }
        $output .="</table>";
        return $output;
	}

/*	UPDATE CUSTOMER */
	function update_customer($customerNumber,$customerName,$customerSurname,$customerCompanyId,$customerLandphone,$customerMobile,$customerEmail,$customerCountry,$customerAddress,$customerReferral,$customerDate)
	{
		$data = array(
		'customer_date' => $customerDate,
		'customer_number' => $customerNumber,
		'customer_name' => $customerName,
		'customer_surname' => $customerSurname,
		'customerCompanyId' => $customerCompanyId,
		'customer_country' => $customerCountry,
		'customer_address' => $customerAddress,
		'customer_landphone' => $customerLandphone,
		'customer_mobile' => $customerMobile,
		'customer_email' => $customerEmail,
		'customer_referral' => $customerReferral);
		$this->db->where('customer_number', $customerNumber);
		$this->db->update('customers', $data); 
		return $customerNumber;
	}    

/*	ADD CUSTOMER */
    function add_customer($customerName,$customerSurname,$customerLandphone,$customerMobile,$customerEmail,$customerCountry,$customerAddress,$customerReferral,$customerDate,$customerCompanyId)
    {
        // Add a new customer
		// First get latest customer number from seed table
		$customerNumber = $this->global_model->get_latest_customer_number();
		
		// Set a creation date for customer
		$customerDate = date('Y-m-d');
			
		// Create new entry in customer file			
		$data = array(
		'customer_id' => '',
		'customer_date' => $customerDate,
		'customer_number' => $customerNumber,
		'customer_name' => $customerName,
		'customer_surname' => $customerSurname,
		'customer_country' => $customerCountry,
		'customer_address' => $customerAddress,
		'customer_landphone' => $customerLandphone,
		'customer_mobile' => $customerMobile,
		'customer_email' => $customerEmail,
		'customerCompanyId' => $customerCompanyId,
		'customer_referral' => $customerReferral);
		$this->db->insert('customers', $data);
		
		$customerId = $this->db->insert_id();
		return $customerNumber; 
    }
    
}// End of Class
?>