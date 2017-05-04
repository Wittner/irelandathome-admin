<?php
class Owner_model extends Model
{

    function Owner_model()
    {
        parent::Model();
        $this->load->model('global_model');
        $this->load->database();
        $this->public_db = $this->load->database('public', true);
    }

/*  ADD OWNER */
	function add_owner($inputData)
    {
        // Add a new owner
        $this->db->insert('owners', $inputData);
		$this->public_db->insert('owners', $inputData);
		Return;
    }
 
/*	LIST OWNERS */
 	function list_owners()
	{
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        $output = '<table width="100%" border="0"><tr><th>Name</th><th>Phone 1</th><th>Phone 2</th><th>Mobile</th><th>Email</th><th colspan="3" align="center">Action</th></tr>';
		$this->public_db->select('*');
		$this->public_db->from('owners');
		$this->public_db->where("status = 'LVE'");
		$this->public_db->order_by('contact_sname','asc');
		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
		{
            foreach ($query->result() as $item)
			{
                $i = $i + 1;
                $col = ($i % 2) ? 'hilite' : 'lowlite';
                $output .= '<tr>' .
					'<td class="' . $col . '">' . $item->contact_sname . ' ' . $item->contact_fname . '&nbsp;</td>' .
					'<td class="' . $col . '">' . $item->phone1 . '&nbsp;</td>' .
                    '<td class="' . $col . '">' . $item->phone2 . '&nbsp;</td>' .
                    '<td class="' . $col . '">' . $item->mobile . '&nbsp;</td>' .
                    '<td class="' . $col . '">' . $item->email . '&nbsp;</td>' .
					'<td width="15"><a href="index.php/owners/edit_owner/' . $item->owner_id .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>' .
					'<td width="15"><a href="index.php/owners/delete_owner/' . $item->owner_id . '"><img src="images/app/delete.gif" border="0" width="20" height="20" title="Delete this record"/></a></td>' .
					'</tr>';
            }
        } else {
            $output = '<h4>No search results found!</h4>';
        }
        $output .="</table>";
        return $output;
	}	 	

/*	GET OWNER BY CODE */
	function get_owner_by_id($ownerId)
	{
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        $output = '<table width="100%" border="0"><tr><th>Name</th><th>Code</th><th>Address</th><th colspan="5" align="center">Action</th></tr>';
		$this->public_db->select('*');
		$this->public_db->from('owners');
		$this->public_db->where("owner_id = '$ownerId'");
		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
		{
           return $query;
        } else {
            $output = '<h4>No search results found!</h4>';
        	return $output;            
        }
	}
	
/*	UPDATE OWNER */	
	function update_owner($ownerId,$inputData)
	{
		$this->db->where('owner_id', $ownerId);
		$this->db->update('owners', $inputData);
		$this->public_db->where('owner_id', $ownerId);
		$this->public_db->update('owners', $inputData);
		return $ownerId;
	}

/*  GET OWNER NAME BY PROPERTY CODE */
	function get_owner_name_by_code($propertyCode)
	{
		$this->public_db->select('property_code,contact_fname, contact_sname');
		$this->public_db->from('properties');
		$this->public_db->join('owners','properties.property_owner_id = owners.owner_id');
		$this->public_db->where('property_code', $propertyCode);
		$query = $this->public_db->get();
		foreach($query->result() as $item)
		{
			$ownerName = $item->contact_fname . ' ' . $item->contact_sname;
		}
		return $ownerName;
	}
    
	function get_owner_combo($ownerId)
	// Get a list of live properties for a combo box display
	{
		$output = '';
					$this->public_db->select('owner_id,contact_fname,contact_sname');
					$this->public_db->where('status','LVE');
					$this->public_db->order_by("contact_sname", "asc");
		$query =	$this->public_db->get('owners');
		foreach($query->result() as $row)
		{
			$output .= '<option value="' . $row->owner_id . '"';
			if($row->owner_id==$ownerId){
				$output .= ' selected';
			}
			$output .= '>' . $row->contact_sname . ' ' . $row->contact_fname . '</option>';
		}
		return $output;
	}    

/*	DELETE OWNER */
	function delete_owner($ownerId)
	{
		$this->public_db->where('owner_id', $ownerId);
		$this->public_db->update('owners', $inputData);
		return $ownerId;
	}

/*  GET OWNER AUTOCOMPLETE */
	function get_owner_autocomplete($q)
	{
		$autocompleteArray = '';
		$counter = '0';
		$this->public_db->select('contact_fname, contact_sname, owner_id');
		$this->public_db->from('owners');
		$this->public_db->where("status='LVE'");
		$this->public_db->where("contact_sname like '$q%'");
		$this->public_db->order_by('contact_sname','asc');
		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
		{
            foreach ($query->result() as $item)
			{
				$counter++;
				//echo $counter . '<br />';
				$autocompleteArray .= $item->contact_sname . ' ' . $item->contact_fname . '|' . $item->owner_id . "\n";
            }
        } else {
            $autocompleteArray = '';
        }
        return $autocompleteArray;
	}    
}// End of Class
?>