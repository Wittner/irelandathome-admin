<?php
class Offer_model extends Model
{

    function Offer_model()
    {
        parent::Model();
        $this->load->model('global_model');
    }

/* ADD AN OFFER */
    function add_offer($saleId,$propertyCode,$fromDate,$toDate,$offerPrice,$adminUsername,$offerQty)
    {
		// Set a creation date for customer
		$offerDate = date('Y-m-d');
			
		// Create new entry in customer file			
		$data = array(
		'offerId' => '',
		'saleId' => $saleId,
		'propertyCode' => $propertyCode,
		'fromDate' => $fromDate,
		'toDate' => $toDate,
		'offerPrice' => $offerPrice,
		'adminUsername' => $adminUsername,
		'offerDate' => $offerDate,
		'offerQty' => $offerQty
		);
		$this->db->insert('offers', $data);
		return $saleId; 
    }
   
/*	LIST OFFERS */
	function list_offers($saleId)
	{
	$query =	$this->db->query("select *, offers.fromDate as offersFromDate, offers.toDate as offersToDate from offers left join properties on properties.property_code = offers.propertyCode where saleId = '$saleId' and offerStatus = 'LVE'");
	if ($query->num_rows() > 0)
	{
		$i=0;// Counter
		$output  ='<table width="100%" border="0">';
		$output .='<tr><th>Sale Id.</th><th>Added</th><th>Property</th><th>Qty.</th><th>Arrival</th><th>Departure</th><th>Price</th><th>memo</th></tr>';
       	foreach ($query->result() as $item)
		{
			$displayOfferDate = $this->global_model->toDisplayDate($item->offerDate);
			$displayOfferFromDate = $this->global_model->toDisplayDate($item->fromDate);
			$displayOfferToDate = $this->global_model->toDisplayDate($item->toDate);
			$property_name = $this->property_model->get_property_name_by_code($item->propertyCode);
       		$i = $i + 1;
           	$col = ($i % 2) ? 'hilite' : 'lowlite';
           	$output
			.='<tr>'
			. '<td class="' . $col . '">' . $item->saleId . '&nbsp;</td>'
			. '<td class="' . $col . '">' . $displayOfferDate . '&nbsp;</td>'
			. '<td class="' . $col . '">' . $property_name . '&nbsp;</td>'
			. '<td class="' . $col . '">' . $item->offerQty . '&nbsp;</td>'
			. '<td class="' . $col . '">' . $displayOfferFromDate . '&nbsp;</td>'
			. '<td class="' . $col . '">' . $displayOfferToDate . '&nbsp;</td>'
			. '<td class="' . $col . '">' . $item->offerPrice . '&nbsp;</td>'
			. '<td class="' . $col . '"><a href="index.php/sales/remove_offer/' . $item->saleId . '/' . $item->offerId . '">Remove</a></td>'
			. '</tr>';
        }
        	$output .= '</table>';
    }
	else
	{
       	$output = '';
    }
    return $output;
	}

/*	GET OFFERS BY SALE ID */
	function get_offer_by_sale_id($saleId)
	{
		$output = '';
					$this->db->select('property_code, property_name'); 
		$query =	$this->db->get_where('properties', array('property_code' => $propertyCode));
		foreach($query->result() as $row){
			$output .= "<input type=\"text\" name=\"property\" value=\"" . $row->property_name . "\" readonly=\"true\" size=\"35\"/>";
		}
		return $output;
	}

/*	LIST OFFERS FOR EMAIL */
	function get_offers_for_email($saleId)
	{
	$output = '';
	$APP_companyDetails = $this->global_model->get_company_data();
	$query =	$this->db->query("select *, offers.fromDate as offersFromDate, offers.toDate as offersToDate from offers left join properties on properties.property_code = offers.propertyCode where saleId = '$saleId' and offerStatus = 'LVE'");
	if ($query->num_rows() > 0)
	{
       	foreach ($query->result() as $item)
		{
			$displayFromDate = $this->global_model->toDisplayDate($item->offersFromDate);
			$displayToDate = $this->global_model->toDisplayDate($item->offersToDate);
			$pic1 = $this->property_model->get_property_detail($item->propertyCode,'pic1');
			$property_name = $this->property_model->get_property_detail($item->propertyCode,'property_name');
			$property_bedrooms =  $this->property_model->get_property_detail($item->propertyCode,'property_bedrooms');
			$property_capacity = $this->property_model->get_property_detail($item->propertyCode,'property_capacity');
			$property_intro = $this->property_model->get_property_detail($item->propertyCode,'property_intro');
			
           	$output .=
			'
			<table width="500" border="0" cellpadding="4" cellspacing="0">
			<tr><td bgcolor="#FFFFFF" valign="top" style="font-size:12px;color:#000000;line-height:150%;font-family:trebuchet ms;" align="left">
			<img src="http://www.irelandathome.com/images/'.$pic1.'" width="150" height="100" align="left" hspace="20" border="1" />
			<p>
			<strong>'.$property_name.'</strong> <a href="http://www.irelandathome.com/detail.php?code='.$item->propertyCode.'">(<u>View property</u>)</a><br />
			<strong>Bedrooms: </strong>'.$property_bedrooms.' <strong>Sleeps:</strong> '.$property_capacity.'<br />
			<b>Arrival Date:</b> '.$displayFromDate.'<br />
			<b>Departure Date: </b>'.$displayToDate.'<br />
			<b>Units Requested:</b> '.$item->offerQty.'<br />
			</strong>
			</p>

			<p>
			'.$property_intro.'
			</p>

			<p align="center">
			<!-- . $APP_companyDetails["baseurl"] . -->
			<b><span style="font-size:14px;color:#ff0000;">YOUR OFFER PRICE! '.$item->offerPrice.' ('.$APP_companyDetails['currency'].')</span><br />
			<a href="http://www.irelandathome.com/remote_rx_offer_accept.php?id='.$item->offerId.'&amp;prop='.$item->propertyCode.'">&gt;&gt;<u>CLICK HERE TO BOOK THIS OFFER NOW!&lt;&lt;</u></a><br />
			(you will be transferred to our online payment system)
			<hr />
			</p>
			</td>
			</tr>
			</table>
			';
        }
    }
	else
	{
       	$output = '';
    }
    return $output;
	}


/*	DELETE OFFER */
	function delete_offer($offerId)
	{
		$query = $this->db->query("update offers set offerStatus='DEL' where offerId = $offerId");
	}

/*	DELETE OFFERS CONNECTED WITH A SALE */
	function delete_offers_by_sale($saleId)
	{
		$query = $this->db->query("update offers set offerStatus='DEL' where saleId = $saleId");
	}
	
    
}// End of Class
?>