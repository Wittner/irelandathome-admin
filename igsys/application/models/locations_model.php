<?php
class Locations_model extends Model
{

    function Locations_model()
    {
        parent::Model();
        $this->load->model('global_model');
        $this->public_db = $this->load->database('public', true);
    }

/*  ADD LOCATION */
	function add_location($inputData)
    {
        // Add a new owner
		$this->public_db->insert('towns', $inputData);
		Return;
    }
 
/*	LIST LOCATION */
 	function list_locations()
	{
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        $output = '<table width="100%" border="0"><tr><th>Location</th><th>Amenities</th><th colspan="2">Actions</th></tr>';
		$this->public_db->select('*');
		$this->public_db->from('towns');
		$this->public_db->order_by('town_name','asc');
		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
		{
            foreach ($query->result() as $item)
			{
                $i = $i + 1;
                $col = ($i % 2) ? 'hilite' : 'lowlite';
                $output .= '<tr>' .
					'<td class="' . $col . '">' . $item->town_name . '&nbsp;</td>' .
					'<td class="' . $col . '">' . strip_tags(substr($item->amenities,0,50)) . '...&nbsp;</td>' .
					'<td width="15"><a href="index.php/locations/edit_location/' . $item->town_id .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>' .
					'<td width="15"><a href="index.php/locations/delete_location/' . $item->town_id . '"><img src="images/app/delete.gif" border="0" width="20" height="20" title="Delete this record"/></a></td>' .
					'</tr>';
            }
        } else {
            $output = '<h4>No search results found!</h4>';
        }
        $output .="</table>";
        return $output;
	}	 	

/*	GET LOCATION BY CODE */
	function get_location_by_id($townId)
	{
		$this->public_db->select('*');
		$this->public_db->from('towns');
		$this->public_db->where("town_id = '$townId'");
		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
		{
           return $query;
        } else {
            $output = '<h4>No search results found!</h4>';
        	return $output;            
        }
	}
	
/*	UPDATE LOCATION */
	function update_location($townId,$inputData)
	{
		$this->public_db->where('town_id', $townId);
		$this->public_db->update('towns', $inputData);
		return $townId;
	}

/* DELETE LOCATION */
	function delete_location($townId)
	{
		$this->public_db->where('town_id', $townId);
		$this->public_db->update('towns', $inputData);
		return $townId;
	}
    
/*  GET LOCATION AUTOCOMPLETE */
	function get_location_autocomplete($q)
	{
		$autocompleteArray = '';
		$counter = '0';
		$this->public_db->select('town_name, town_id');
		$this->public_db->from('towns');
		$this->public_db->where("country = 'IRL'");
		$this->public_db->where("town_name like '$q%'");
		$this->public_db->order_by('town_name','asc');
		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
		{
            foreach ($query->result() as $item)
			{
				$counter++;
				//echo $counter . '<br />';
				$autocompleteArray .= $item->town_name . '|' . $item->town_id . "\n";
            }
        } else {
            $autocompleteArray = '';
        }
        return $autocompleteArray;
	}

}// End of Class
?>