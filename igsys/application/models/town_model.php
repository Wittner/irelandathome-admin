<?php
class Town_model extends Model
{

    function Town_model()
    {
        parent::Model();
        $this->load->model('global_model');
    }

/*	ADD */
    function add_town($customerName,$customerSurname,$customerLandphone,$customerMobile,$customerEmail,$customerCountry,$customerAddress,$customerReferral)
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
		'customer_referral' => $customerReferral);
		$this->db->insert('customers', $data);
		
		$customerId = $this->db->insert_id();
		return $customerNumber; 
    }
   
/*	GET BY CODE */    
	function get_town_by_code($propertyCode)
	{
		$output = '';
					$this->db->select('property_code, property_name'); 
		$query =	$this->db->get_where('properties', array('property_code' => $propertyCode));
		foreach($query->result() as $row){
			$output .= "<input type=\"text\" name=\"property\" value=\"" . $row->property_name . "\" readonly=\"true\" size=\"35\"/>";
		}
		return $output;
	}

/*	CREATE COMBO */
	function get_town_combo($townId)
	// Get a list of towns for a combo box display
	{
		$output = '';
					$this->public_db->select('*');
					$this->public_db->from('towns');
					$this->public_db->order_by("town_name", "asc");
		$query =	$this->public_db->get();
		foreach($query->result() as $row)
		{
			$output .= '<option value="' . $row->town_id . '"';
			if($row->town_id==$townId){
				$output .= ' selected';
			}
			$output .= '>' . $row->town_name . '</option>';
		}
		return $output;
	}

/*	UPDATE */	
	function update_property()
	{
		$data = array(		
		'customerName' => $customerName,
		'customerSurname' => $customerSurname,
		'customerLandphone' => $customerLandphone,
		'customerMobile' => $customerMobile,
		'customerEmail' => $customerEmail,
		'customerCountry' => $customerCountry,
		'customerAddress' => $customerAddress,
		'customerReferral' => $customerReferral);
		$this->db->where('customer_number', $customerNumber);
		$this->db->update('customers', $data); 
		return $customerNumber;
	}

/*	CHECK IF EXISTS */	
	function property_exist($customerEmail)
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
    
    
}// End of Class
?>