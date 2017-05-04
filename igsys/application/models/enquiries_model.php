<?php
/**
 * @author Mike Brady
 * @copyright 2008
 */
 
class Enquiries_model extends Model
{

    function Enquiries_model()
    {
        parent::Model();
        $this->load->model('global_model');
    }

    function get_latest_queries()
    {
        // Variable declarations
		$output = '<table class="listing" width="100%" border="0"><tr><th width="29">&nbsp;</th><th width="40">ID</th><th width="80">Date</th><th width="200">Customer</th><th width="100">From</th><th>Email</th><th width="50">Source</th><th colspan="3" width="45">Action</th></tr></table>';
        $i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        $query = $this->public_db->query('SELECT * FROM queries left join country_dd on queries.customer_country = country_dd.id where customer_status="QRY" order by detail_id desc');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $item) {
            	$output .= '<table class="listing" width="100%" border="0">';
				$i = $i + 1;
                $col = ($i % 2) ? 'hilite' : 'lowlite';
                if($item->source == 'LVE'){$col = 'live';}
                $output .= '<tr>' . "\n\r" .
					'<td class="' . $col . '" width="29">';
					if($item->admin_note != '')
					{
						$output .= '<a id="' . $item->detail_id .'" href="#" class="aNote"><img src="images/app/note_yes.gif" border="0" width="20" height="20" title="Read note" /></a></td>';
					}
					else
					{
						$output .= '<a id="' . $item->detail_id .'" href="#" class="aNote"><img src="images/app/note_no.gif" border="0" width="20" height="20" title="Add note" /></a></td>';
					}
					
				$output .=
					'<td width="40" class="' . $col . '">' . $item->detail_id .'&nbsp;</td>' .  "\n\r" .
					'<td width="80" class="' . $col . '">' . $this->global_model->toDisplayDate($item->detail_date). '&nbsp;</td>' . "\n\r" .
                    '<td width="200" class="' . $col . '">' . $item->customer_name . '&nbsp;</td>' . "\n\r" .
                    '<td width="100" class="' . $col . '">' . $item->name . '&nbsp;</td>' . "\n\r" .
                    '<td class="' . $col . '">' . $item->customer_email . '&nbsp;</td>' . "\n\r" .
                    '<td width="50" class="' . $col . '">' . $item->source . '&nbsp;</td>' . "\n\r";
				$output
					.=
					'<td width="15"><a href="index.php/enquiries/view_enquiry/' . $item->detail_id .'"><img src="images/app/view.gif" border="0" width="20" height="20" title="View this record"/></a></td>' . "\n\r" .
					'<td width="15"><a href="index.php/enquiries/edit_enquiry/' . $item->detail_id .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>' . "\n\r" .
					'<td width="15"><a href="index.php/enquiries/delete_enquiry/' . $item->detail_id . '"><img src="images/app/delete.gif" border="0" width="20" height="20" title="Delete this record"/></a></td>' . "\n\r" .			
					'</tr>' . "\n\r";
				$output .="</table>";
				$output .= '
				<div id="divNote' . $item->detail_id . '" class="divNote">
				<strong>Notes:</strong>
				<form action="index.php/enquiries/update_note" method="post">
				<input type="hidden" name="enquiryId" value="' . $item->detail_id . '" />
				<textarea name="admin_note" cols="120" rows="8">' . $item->admin_note . '</textarea><br />
				<input type="submit" value="Update note" />
				</form>
				</div>';
			
            }
        } else {
            $output = '<h4>There were no records!</h4>';
        }
        return $output;
    }
 
	function ajax_get_latest_queries()
    {
        // Variable declarations
		$output = '<table class="listing" width="100%" border="0"><tr><th width="29">&nbsp;</th><th width="40">ID</th><th width="80">Date</th><th width="200">Customer</th><th width="100">From</th><th>Email</th><th width="50">Source</th><th colspan="3" width="45">Action</th></tr></table>';
        $i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        $query = $this->public_db->query('SELECT * FROM queries left join country_dd on queries.customer_country = country_dd.id where customer_status="QRY" order by detail_id desc');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $item) {
            	$output .= '<table class="listing" width="100%" border="0">';
				$i = $i + 1;
                $col = ($i % 2) ? 'hilite' : 'lowlite';
                if($item->source == 'LVE'){$col = 'live';}
                $output .= '<tr>' . "\n\r" .
					'<td class="' . $col . '" width="29">';
					if($item->admin_note != '')
					{
						$output .= '<a id="' . $item->detail_id .'" href="#" class="aNote"><img src="images/app/note_yes.gif" border="0" width="20" height="20" title="Read note" /></a></td>';
					}
					else
					{
						$output .= '<a id="' . $item->detail_id .'" href="#" class="aNote"><img src="images/app/note_no.gif" border="0" width="20" height="20" title="Add note" /></a></td>';
					}
					
				$output .=
					'<td width="40" class="' . $col . '">' . $item->detail_id .'&nbsp;</td>' .  "\n\r" .
					'<td width="80" class="' . $col . '">' . $this->global_model->toDisplayDate($item->detail_date). '&nbsp;</td>' . "\n\r" .
                    '<td width="200" class="' . $col . '">' . $item->customer_name . '&nbsp;</td>' . "\n\r" .
                    '<td width="100" class="' . $col . '">' . $item->name . '&nbsp;</td>' . "\n\r" .
                    '<td class="' . $col . '">' . $item->customer_email . '&nbsp;</td>' . "\n\r" .
                    '<td width="50" class="' . $col . '">' . $item->source . '&nbsp;</td>' . "\n\r";
				$output
					.=
					'<td width="15"><a href="index.php/enquiries/view_enquiry/' . $item->detail_id .'"><img src="images/app/view.gif" border="0" width="20" height="20" title="View this record"/></a></td>' . "\n\r" .
					'<td width="15"><a href="index.php/enquiries/edit_enquiry/' . $item->detail_id .'"><img src="images/app/edit.gif" border="0" width="20" height="20" title="Edit this record"/></a></td>' . "\n\r" .
					'<td width="15"><a href="index.php/enquiries/delete_enquiry/' . $item->detail_id . '"><img src="images/app/delete.gif" border="0" width="20" height="20" title="Delete this record"/></a></td>' . "\n\r" .			
					'</tr>' . "\n\r";
				$output .="</table>";
				$output .= '
				<div id="divNote' . $item->detail_id . '" class="divNote">
				<strong>Notes:</strong>
				<form action="index.php/enquiries/update_note" method="post">
				<input type="hidden" name="enquiryId" value="' . $item->detail_id . '" />
				<textarea name="admin_note" cols="120" rows="8">' . $item->admin_note . '</textarea><br />
				<input type="submit" value="Update note" />
				</form>
				</div>';
			
            }
        } else {
            $output = '<h4>There were no records!</h4>';
        }
        return $output;
    }
 
 	function update_enquiry($enquiry, $note)
	{
		$data = array(
               'title' => $title,
               'name' => $name,
               'date' => $date
            );
	}
    
    function get_enquiry_by_id($enquiryId)
    {
    	$query  = 	$this->public_db->query("select * from queries where detail_id='$enquiryId'");
    	return $query;
    }

	function update_note($enquiryId,$admin_note)
	{
		$query = $this->public_db->query("update queries set admin_note = '$admin_note' where detail_id = '$enquiryId'");
		return 'done';
	}
    
    function delete_enquiry_by_id($enquiryId)
    {
    	$query = $this->public_db->query("update queries set customer_status = 'DEL' where detail_id = '$enquiryId'");
    	return 'done';
    }

}

?>
