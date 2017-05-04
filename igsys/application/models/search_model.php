<?php
class Search_model extends Model
{

    function Search_model()
    {
        parent::Model();
        $this->load->model('global_model');
    }

	function search_customers($fieldName,$keyWord)
	{
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        $output = '<table width="100%" border="0"><tr><th>Number</th><th>Name</th><th>Phone</th><th>Mobile</th><th>Email</th><th>Date</th><th colspan="5">Action</th></tr>';
		$this->db->select('*');
		$this->db->from('customers');
		$this->db->like($fieldName,$keyWord);
		$this->db->order_by('customer_id','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $item) {
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
    
}// End of Class
?>