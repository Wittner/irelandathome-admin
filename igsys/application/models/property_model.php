<?php
class Property_model extends Model
{

  function Property_model()
  {
    parent::Model();
    $this->load->model('global_model');
    $this->load->database();
    $this->public_db = $this->load->database('public', true);
  }

  function add_property($inputData)
  {
    // Add a new property
    $this->db->insert('properties', $inputData);
    $this->public_db->insert('properties', $inputData);
    $propertyId = $this->public_db->insert_id();
    Return $propertyId;
  }

  /*	LIST PROPERTIES */
  function list_properties($searchFilter)
  {
    $i = 0; // Odd/even counter for alternate coloured <td>'s
    $col = ''; // Color style name for alternate coloured <td>'s
    $csvOutput = 'Name, Code, Live booking?, Address, Action' . "\r\n";
    $output = '
    <table border="0">
    <tr>
    <td>Filter listing: </td><td><a href="index.php/properties/list_properties/live">Live</a> | <a href="index.php/properties/list_properties/not">Not Live</a> | <a href="index.php/properties/list_properties/all">All</a></td>
    </tr>
    </table>';

    $output .= '<table width="100%" border="0"><tr><th>Name</th><th>Code</th><th>Live booking?</th><th>Address</th><th colspan="5" align="center">Action</th></tr>';
    $this->public_db->select('property_name, property_code, property_address, livebook');
    $this->public_db->from('properties');
    $this->public_db->join('towns','properties.property_town_id=towns.town_id');
    $this->public_db->join('county','towns.county_id=county.county_id');
    if($searchFilter != 'all') {
      $this->public_db->where('property_status', $searchFilter);
    }
    $countrySelector = 'IRL';
    $this->public_db->where('country_id', $countrySelector);
    $this->public_db->order_by('property_name','asc');
    $query = $this->public_db->get();
    if ($query->num_rows() > 0)
    {
      foreach ($query->result() as $item)
      {
        $i = $i + 1;
        $col = ($i % 2) ? 'hilite' : 'lowlite';
        $csvOutput .= $item->property_name . ',' . $item->property_code . ',' . $item->livebook . "\r\n";
        $output .= '<tr>' .
        '<td class="' . $col . '"><a href="http://www.irelandathome.com/detail.php?code=' . $item->property_code . '">' . $item->property_name .'</a>&nbsp;</td>' .
        '<td class="' . $col . '">' . $item->property_code . '&nbsp;</td>' .
        '<td class="' . $col . '">' . $item->livebook . '&nbsp;</td>' .
        '<td class="' . $col . '">' . $item->property_address . '&nbsp;</td>' .
        '<td width="15"><a href="index.php/properties/edit_property/' . $item->property_code .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>' .
        '<td width="15"><a href="index.php/properties/delete_property/' . $item->property_code . '"><img src="images/app/delete.gif" border="0" width="20" height="20" title="Delete this record"/></a></td>' .
        '<td align="center"><a href="index.php/properties/show_owner/' . $item->property_code . '"><img src="images/app/showowner.gif" border="0" width="20" height="20" title="Show owners"/></a></td>' .
        '<td align="center"><a href="index.php/properties/show_rates/' . $item->property_code . '"><img src="images/app/showrates.gif" border="0" width="20" height="20" title="Edit rates"/></a></td>' .
        '</tr>';
      }
    } else {
      $output = '<h4>No search results found!</h4>';
    }
    $output .="</table>";
    // $output .="<pre>" . $csvOutput . "</pre>";
    return $output;
  }

  /*	LIST PROPERTIES BY TOWN */
  function list_properties_by_town($townId)
  {
    $i = 0; // Odd/even counter for alternate coloured <td>'s
    $col = ''; // Color style name for alternate coloured <td>'s
    $output = '<table width="100%" border="0"><tr><th>Name</th><th>Code</th><th>Address</th><th colspan="5" align="center">Action</th></tr>';
    $this->public_db->select('*');
    $this->public_db->from('properties');
    $this->public_db->join('towns','properties.property_town_id=towns.town_id');
    $this->public_db->join('county','towns.county_id=county.county_id');
    $this->public_db->where("property_status='LVE'");
    $this->public_db->where("country_id='IRL'");
    $this->public_db->where("property_town_id = $townId");
    $this->public_db->order_by('property_code','asc');
    $query = $this->public_db->get();
    if ($query->num_rows() > 0)
    {
      foreach ($query->result() as $item)
      {
        $i = $i + 1;
        $col = ($i % 2) ? 'hilite' : 'lowlite';
        $output .= '<tr>' .
        '<td class="' . $col . '">' . $item->property_name .'&nbsp;</td>' .
        '<td class="' . $col . '">' . $item->property_code . '&nbsp;</td>' .
        '<td class="' . $col . '">' . $item->property_address . '&nbsp;</td>' .
        '<td width="15"><a href="index.php/properties/edit_property/' . $item->property_code .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>' .
        '<td width="15"><a href="index.php/properties/delete_property/' . $item->property_code . '"><img src="images/app/delete.gif" border="0" width="20" height="20" title="Delete this record"/></a></td>' .
        '<td width="15" align="center"><a href="index.php/owners/edit_owner/' . $item->property_owner_id . '"><img src="images/app/showowner.gif" border="0" width="20" height="20" title="Show owners"/></a></td>' .
        '<td width="15" align="center"><a href="index.php/properties/show_rates/' . $item->property_code . '"><img src="images/app/showrates.gif" border="0" width="20" height="20" title="Edit rates"/></a></td>' .
        '</tr>';
      }
    } else {
      $output = '<h4>No search results found!</h4>';
    }
    $output .="</table>";
    return $output;
  }

  /*	SHOW OWNER PROPERTIES */
  function list_properties_by_owner($ownerId)
  {
    $i = 0; // Odd/even counter for alternate coloured <td>'s
    $col = ''; // Color style name for alternate coloured <td>'s
    $output = '<table width="100%" border="0"><tr><th>Name</th><th>Code</th><th>Address</th><th colspan="3" align="center">Action</th></tr>';
    $this->public_db->select('*');
    $this->public_db->from('properties');
    $this->public_db->join('towns','properties.property_town_id = towns.town_id');
    $this->public_db->join('county','towns.county_id = county.county_id');
    $this->public_db->where("property_status = 'LVE'");
    $this->public_db->where("country_id = 'IRL'");
    $this->public_db->where("property_owner_id = $ownerId");
    $this->public_db->order_by('property_code','asc');
    $query = $this->public_db->get();
    if ($query->num_rows() > 0)
    {
      foreach ($query->result() as $item)
      {
        $i = $i + 1;
        $col = ($i % 2) ? 'hilite' : 'lowlite';
        $output .= '<tr>' .
        '<td class="' . $col . '">' . $item->property_name .'&nbsp;</td>' .
        '<td class="' . $col . '">' . $item->property_code . '&nbsp;</td>' .
        '<td class="' . $col . '">' . $item->property_address . '&nbsp;</td>' .
        '<td width="15"><a href="index.php/properties/edit_property/' . $item->property_code .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>' .
        '<td width="15"><a href="index.php/properties/delete_property/' . $item->property_code . '"><img src="images/app/delete.gif" border="0" width="20" height="20" title="Delete this record"/></a></td>' .
        '<td width="15" align="center"><a href="index.php/properties/show_rates/' . $item->property_code . '"><img src="images/app/showrates.gif" border="0" width="20" height="20" title="Edit rates"/></a></td>' .
        '</tr>';
      }
    } else {
      $output = '<h4>No search results found!</h4>';
    }
    $output .="</table>";
    return $output;
  }

  /*  GET PROPERTY AUTOCOMPLETE */
  function get_property_autocomplete($q)
  {
    $autocompleteArray = '';
    $counter = '0';
    $this->public_db->select('property_name, property_code');
    $this->public_db->from('properties');
    $this->public_db->where("property_status='LVE'");
    $this->public_db->where("country_id='IRL'");
    $this->public_db->where("property_name like '$q%'");
    $this->public_db->order_by('property_name','asc');
    $query = $this->public_db->get();
    if ($query->num_rows() > 0)
    {
      foreach ($query->result() as $item)
      {
        $counter++;
        //echo $counter . '<br />';
        $autocompleteArray .= $item->property_name . '|' . $item->property_code . "\n";
      }
    } else {
      $autocompleteArray = '';
    }
    return $autocompleteArray;
  }

  /*	GET PROPERTY BY CODE */
  function get_property_by_code($propertyCode)
  {
    $i = 0; // Odd/even counter for alternate coloured <td>'s
    $col = ''; // Color style name for alternate coloured <td>'s
    $output = '<table width="100%" border="0"><tr><th>Name</th><th>Code</th><th>Address</th><th colspan="5" align="center">Action</th></tr>';
    $this->public_db->select('*');
    $this->public_db->from('properties');
    $this->public_db->join('owners','properties.property_owner_id = owners.owner_id');
    $this->public_db->where("property_code = '$propertyCode'");
    $query = $this->public_db->get();
    if ($query->num_rows() > 0)
    {
      return $query;
    } else {
      $output = '<h4>No search results found!</h4>';
      return $output;
    }
  }

  /*	GET PROPERTY NAME BY CODE */
  function get_property_name_by_code($propertyCode)
  {
    $this->public_db->select('property_name');
    $this->public_db->from('properties');
    $this->public_db->where("property_code = '$propertyCode'");
    $query = $this->public_db->get();
    if ($query->num_rows() > 0)
    {
      foreach ($query->result() as $item)
      {
        $propertyName = $item->property_name;
      }
    }
    else
    {
      $propertyName = 'No property selected';
    }
    return $propertyName;
  }

  /*	GET PROPERTY CODE BY ID */
  function get_property_code_by_id($propertyId)
  {
    $this->public_db->select('property_code');
    $this->public_db->from('properties');
    $this->public_db->where("property_id = '$propertyId'");
    $query = $this->public_db->get();
    if ($query->num_rows() > 0)
    {
      foreach ($query->result() as $item)
      {
        $propertyCode = $item->property_code;
      }
    }
    else
    {
      $propertyCode = 'No property selected';
    }
    return $propertyCode;
  }

  /*	GET PROPERTY TYPE */
  function get_property_type($propertyCode)
  {
    $this->public_db->select('property');
    $this->public_db->from('properties');
    $this->public_db->where("property_code = '$propertyCode'");
    $query = $this->db->get();
    if ($query->num_rows() > 0)
    {
      foreach($query->result() as $row)
      {
        $propertyCode = $row->property_code;
      }

    } else {
      $propertyCode = '';
    }
    return $propertyCode;
  }

  /*  GET PROPERTY DETAIL BY PROPERTY CODE */
  function get_property_detail($propertyCode,$field)
  {
    $this->public_db->select($field);
    $this->public_db->from('properties');
    $this->public_db->where("property_code = '$propertyCode'");
    $query = $this->public_db->get();
    if ($query->num_rows() > 0)
    {
      foreach($query->result() as $row)
      {
        $result = $row->$field;
      }

    } else {
      $result = '';
    }
    return $result;
  }

  /*  GET CARETAKER DETAILS BY PROPERTY CODE */
  function get_caretaker_detail($propertyCode,$field)
  {
    $this->public_db->select($field);
    $this->public_db->from('properties');
    $this->public_db->where("property_code = '$propertyCode'");
    $query = $this->public_db->get();
    if ($query->num_rows() > 0)
    {
      foreach($query->result() as $row)
      {
        $result = $row->$field;
      }

    } else {
      $result = '';
    }
    return $result;
  }

  /*  GET CARETAKER NUMBER BY PROPERTY CODE */
  function get_owner_detail($propertyCode,$field)
  {
    $this->public_db->select($field);
    $this->public_db->from('properties');
    $this->public_db->join('owners','properties.property_owner_id = owners.owner_id');
    $this->public_db->where("property_code = '$propertyCode'");
    $query = $this->public_db->get();
    if ($query->num_rows() > 0)
    {
      foreach($query->result() as $row)
      {
        $result = $row->$field;
      }

    } else {
      $result = '';
    }
    return $result;
  }

  /*  GET CARETAKER email BY PROPERTY CODE */
  function get_caretaker_name_by_property_code($propertyCode)
  {
    $this->public_db->select('property');
    $this->public_db->from('properties');
    $this->public_db->where("property_code = '$propertyCode'");
    $query = $this->public_db->get();
    if ($query->num_rows() > 0)
    {
      foreach($query->result() as $row)
      {
        $propertyCode = $row->caretaker_name;
      }

    } else {
      $propertyCode = '';
    }
    return $propertyCode;
  }

  /*	CREATE PROPERTY COMBO */
  function get_property_combo($propertyCode)
  // Get a list of live properties for a combo box display
  {
    $output = '';
    $this->public_db->select('property_code, property_name');
    $this->public_db->order_by("property_name", "asc");
    $query =	$this->public_db->get_where('properties', array('property_status' => 'LVE', 'country_id' => 'IRL'));
    foreach($query->result() as $row)
    {
      $output .= '<option value="' . $row->property_code . '"';
      if($row->property_code==$propertyCode){
        $output .= ' selected';
      }
      $output .= '>' . $row->property_name . '</option>';
    }
    return $output;
  }

  /*	CREATE PROPERTY COMBO */
  function get_bookable_properties_combo($propertyCode)
  // Get a list of live properties for a combo box display
  {
    $output = '';
    $this->public_db->select('property_code, property_name');
    $this->public_db->order_by("property_name", "asc");
    $query =	$this->public_db->get_where('properties', array('property_status' => 'LVE', 'country_id' => 'IRL', 'livebook' => 'YES'));
    foreach($query->result() as $row)
    {
      $output .= '<option value="' . $row->property_code . '"';
      if($row->property_code==$propertyCode){
        $output .= ' selected';
      }
      $output .= '>' . $row->property_name . '</option>';
    }
    return $output;
  }

  /*	CREATE PROPERTY COMBO WITH SELECTED PROPERTY */
  function get_property_combo_with_selected($propertyCode)
  // Get a list of live properties for a combo box display with appropriate property selected
  {
    $output = '';
    $this->public_db->select('property_code, property_name');
    $this->public_db->order_by("property_name", "asc");
    $query =	$this->public_db->get_where('properties', array('property_status' => 'LVE', 'country_id' => 'IRL'));
    foreach($query->result() as $row){
      $output .= '<option value="' . $row->property_code . '"';
      if($row->property_code == $propertyCode)
      {
        $output .=" selected";
      }

      $output .= ">" . $row->property_name . "</option>";
    }

    return $output;
  }

  function update_property($propertyCode,$inputData)
  {
    // Update local CKG and remote database
    $this->public_db->where('property_code', $propertyCode);
    $this->public_db->update('properties', $inputData);
    $this->db->where('property_code', $propertyCode);
    $this->db->update('properties', $inputData);
    return $propertyCode;
  }

  function property_exist($customerEmail)
  // Returns customer_number if customer exists
  {
    // This method checks if a customer exists by searching against their email address
    $query = $this->public_db->query("SELECT customer_number from customers WHERE customer_email='$customerEmail'");
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

  /*	PROPERTY TYPE COMBO */
  function get_property_type_combo($propType)
  {
    $output = '';
    $this->public_db->select('*');
    $this->public_db->order_by("prop_type", "asc");
    $this->public_db->from('prop_type');
    $query =	$this->public_db->get();
    foreach($query->result() as $row)
    {
      $output .= '<option value="' . $row->prop_type_id . '"';
      if($row->prop_type_id == $propType){
        $output .= ' selected';
      }
      $output .= '>' . $row->prop_type . '</option>';
    }
    return $output;
  }

  /*	EDIT RATES FOR PROPERTY */
  function get_property_rates_by_code($propertyCode)
  {
    $this->public_db->select('*');
    $this->public_db->from('standardrates');
    $this->public_db->where("propertyCode = '$propertyCode'");
    $this->public_db->order_by('fromDate','asc');
    $query = $this->public_db->get();
    if ($query->num_rows() > 0)
    {
      $result = $query;
    }
    else
    {
      $result = 'No records';
    }
    return $query;
  }

  /*  GET HIGH SEASON DATES */
  function get_high_season_dates($startEnd,$propertyCode)
  {
    $this->public_db->select('hiSeasonStart, hiSeasonEnd');
    $this->public_db->from('properties');
    $this->public_db->where("property_code = '$propertyCode'");
    $query = $this->public_db->get();
    if ($query->num_rows() > 0)
    {
      foreach($query->result() as $item)
      {
        if($startEnd == 'start')
        {
          $result = $item->hiSeasonStart;
        }
        elseif($startEnd == 'end')
        {
          $result = $item->hiSeasonEnd;
        }
      }
    }
    else
    {
      $result = 'No records';
    }
    return $result;
  }

}// End of Class
?>
