<?php
class Specials_model extends Model
{

    function Specials_model()
    {
        parent::Model();
        $this->load->model('global_model');
        $this->load->model('property_model');
    }


/*	GET SPECIAL OFFER CODE */
	function get_special_offer_code($propertyCode, $fromDate, $toDate, $holiday)
	{
		// echo $propertyCode . '|' . $fromDate . '|' . $toDate . '|' . $holiday;
		// Use 'any' for property code or dates to produce * reports
		// Vars
		$result = '';
		$clause = '';		
		$this->public_db->select('*');
		$this->public_db->from('special_offers');
		$this->public_db->join('properties', 'properties.property_code = special_offers.propertyCode');
	
		if($propertyCode != 'any')
		{
			$clause = "propertyCode = '$propertyCode'";

			if($fromDate != 'any' && $toDate != 'any')
			{
				$clause .= "  AND ((fromDate BETWEEN '$fromDate' and '$toDate' || toDate BETWEEN '$fromDate' and '$toDate') || (fromDate <= '$fromDate' && toDate >= '$toDate'))";
			}
		}
		else
		{
			if($fromDate != 'any' && $toDate != 'any')
			{
				$clause .= "((fromDate BETWEEN '$fromDate' and '$toDate' || toDate BETWEEN '$fromDate' and '$toDate') || (fromDate <= '$fromDate' && toDate >= '$toDate'))";
			}
			else
			{
				$clause .= " 1=1";
			}
		}

		$this->public_db->where($clause);
		
		if($holiday != 'any')
		{
			$this->public_db->where('holiday', $holiday);
		}

		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
		{
		    	foreach ($query->result() as $item)
		    {
		    	$displayOfferDate = $this->global_model->toDisplayDate($item->offerDate);
		    	$displayOfferFromDate = $this->global_model->toDisplayDate($item->fromDate);
		    	$displayOfferToDate = $this->global_model->toDisplayDate($item->toDate);
		    	$propertyName = $this->property_model->get_property_name_by_code($item->propertyCode);
		    	$offerShortDescription = substr($item->offerDescription, 0, 45);
				if($item->rangeType != 'Defined')
				{
			       	$result
			    	.='
			    	<div class="special_offer">
			    		<table style="width: 700px; border: 1px solid;">
			    		<tr>
			    			<td>SPECIAL OFFER</td>
			    		</tr>
			    		<tr>
			    			<td>'.$item->offerDescription.'</td>
			    		</tr>
			    		<tr>
			    			<td>Validity: Book within these dates: '.$displayOfferFromDate.' to '.$displayOfferToDate.', for &euro;'.$item->offerPrice.' inclusive</td>
			    		</tr>
						</table>
					</div>
					';
		    	}else{
		    		$result
		    		.='
		    		<div class="special_offer">
		    			<table style="width: 700px; border: 1px solid;">
		    			<tr>
		    				<td>SPECIAL OFFER</td>
		    			</tr>
		    			<tr>
		    				<td>'.$item->offerDescription.' ' . $item->propertyCode . '</td>
		    			</tr>
		    			<tr>
		    				<td>Validity: Must be booked from: '.$displayOfferFromDate.' to: '.$displayOfferToDate.'. Price: &euro;'.$item->offerPrice.' &lt;&lt <a href="book_now">BOOK NOW</a> &gt;&gt;</td>
		    			</tr>
		    			</table>
		    		</div>
		    		';
		    	}
		    }
		}
		else
		{
		    $result = '';
		}
		
		return $result;
	}

/*	LIST OFFERS */
	function get_special_offers($sortBy = 'any')
	{
		$this->public_db->select('offerId, fromDate, toDate, propertyCode, offerDescription, rangeType, offerPrice, adminUsername, offerDescription, offerDate, special_offers.holiday, offerStatus, property_name');
		$this->public_db->from('special_offers');
		$this->public_db->join('properties', 'properties.property_code = special_offers.propertyCode');
		if($sortBy != 'any')
		{
			$this->public_db->order_by($sortBy, "asc"); 
		}
		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
		{
		    $i=0;// Counter
		    $output  ='<table width="100%" border="0">';
		    $output .='<tr>
		    			<th><a href="index.php/specials/list_special_offers/offerDate">Added</a></th>
		    			<th><a href="index.php/specials/list_special_offers/property_name">Property</a></th>
		    			<th><a href="index.php/specials/list_special_offers/holiday">Season</a></th>
		    			<th><a href="index.php/specials/list_special_offers/fromDate">From date</a></th>
		    			<th><a href="index.php/specials/list_special_offers/toDate">To date</a></th>
		    			<th><a href="index.php/specials/list_special_offers/property_name">Type</th>
		    			<th>Price</th>
		    			<th>Description</th>
		    			<th>Action</th>
		    			</tr>';
		    	foreach ($query->result() as $item)
		    {
		    	$displayOfferDate = $this->global_model->toDisplayDate($item->offerDate);
		    	$displayOfferFromDate = $this->global_model->toDisplayDate($item->fromDate);
		    	$displayOfferToDate = $this->global_model->toDisplayDate($item->toDate);
		    	$propertyName = $this->property_model->get_property_name_by_code($item->propertyCode);
		    	$offerShortDescription = substr($item->offerDescription, 0, 45);
		    	$i = $i + 1;
		       	$col = ($i % 2) ? 'hilite' : 'lowlite';
		       	$output
		    	.='<tr>'
		    	. '<td class="' . $col . '">' . $displayOfferDate . '&nbsp;</td>'
		    	. '<td class="' . $col . '">' . $propertyName . '</td>'
		    	. '<td class="' . $col . '" nowrap>' . $item->holiday . '&nbsp;</td>'
		    	. '<td class="' . $col . '">' . $displayOfferFromDate . '&nbsp;</td>'
		    	. '<td class="' . $col . '">' . $displayOfferToDate . '&nbsp;</td>'
		    	. '<td class="' . $col . '">' . $item->rangeType . '&nbsp;</td>'
		    	. '<td class="' . $col . '">' . $item->offerPrice . '&nbsp;</td>'
		    	. '<td class="' . $col . '"><a href="#" class="infoLink" title="' . $item->offerDescription . '">' . $offerShortDescription . '...&nbsp;</td>'
		    	. '<td class="' . $col . '" nowrap>
		    		<a href="index.php/specials/delete_special_offer/' . $item->offerId . '">Remove</a>
		    	   	<a href="index.php/specials/edit_special_offer/' . $item->offerId . '">Edit</a>
		    	   </td>'
		    	. '</tr>';
		    }
		    	$output .= '</table>';
		    	$result = $output;
		    	return $result;
		}
		else
		{
		    $result = 'There are no special offers at the moment';
		    return $result;
		}
	}
	
	/*	ADD A SPECIAL OFFER */
		function add_special_offer($inputData)
		{
			$this->public_db->insert('special_offers', $inputData); 
		}

	/*	EDIT A SPECIAL OFFER */
		function edit_special_offer($offerId)
		{
			$this->public_db->select('offerId, fromDate, toDate, propertyCode, offerDescription, rangeType, offerPrice, adminUsername, offerDescription, offerDate, special_offers.holiday, offerStatus, property_name');
			$this->public_db->from('special_offers');
			$this->public_db->join('properties', 'properties.property_code = special_offers.propertyCode');
			$this->public_db->where('offerId', $offerId);
			$query = $this->public_db->get();
			return $query;
		}
		
	/*	UPDATE A SPECIAL OFFER */
		function update_special_offer($offerId, $inputData)
		{
			$this->public_db->where('offerId', $offerId);
			$this->public_db->update('special_offers', $inputData);
			return; 
		}

	/* DELETE SPECIAL OFFER */
		function delete_special_offer($offerId)
		{
			$this->public_db->where('offerId', $offerId);
			$this->public_db->delete('special_offers'); 
		}
    
}// End of Class
?>