<?php
class Notice_model extends Model
{

    function Notice_model()
    {
        parent::Model();
        $this->load->database();
    }

/*	LIST NOTICES */
 	function list_notices()
	{
		$i = 0; // Odd/even counter for alternate coloured <td>'s
        $col = ''; // Color style name for alternate coloured <td>'s
        $output = '<table width="100%" border="0" cellpadding="4"><tr><th>Notification</th><th>Author</th><th>Date</th><th colspan="5" align="center">Action</th></tr>';
		$this->db->select('*');
		$this->db->from('notices');
		$this->db->order_by('notice_id','desc');
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
            foreach ($query->result() as $item)
			{
                $i = $i + 1;
                $col = ($i % 2) ? 'hilite' : 'lowlite';
				$output .='
				<tr>
					<td class="' . $col . '">' . $item->notice_message . '</td>
					<td class="' . $col . '" width="81">' . $item->notice_author . '</td>
					<td class="' . $col . '" width="72">' . $item->notice_date . '</td>';
					if($item->notice_author == $this->session->userdata('admin_name'))
					{
						$output .= '<td class="' . $col . '" width="80"><a href="index.php/notices/edit_notice/' . $item->notice_id . '">Edit</a> | <a href="index.php/notices/delete_notice/' . $item->notice_id . '">Delete</a></td>';
					}
					else
					{
						$output .= '<td class="' . $col . '" width="80">&nbsp;</td>';
					}
				$output .= '</tr>';

            }
        } else {
            $output = '<h4>No notices found!</h4>';
        }
        $output .="</table>";
        return $output;
	}	 	

/*	GET NOTICE BY ID */
	function get_notice_by_id($noticeId)
	{
		$this->db->select('*');
		$this->db->from('notices');
		$this->db->where("notice_id = '$noticeId'");
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
           return $query;
        }
		else
		{
            $output = '<h4>No notices found!</h4>';
        	return $output;
        }
	}

/*	UPDATE NOTICE */
	function update_notice($noticeId,$inputData)
	{
		$this->db->where('notice_id', $noticeId);
		$this->db->update('notices', $inputData);
	}

/*  DELETE NOTICE */
	function delete_notice($noticeId)
	{
		$this->db->delete('notices', array('notice_id' => $noticeId));
	}

/*  ADD NOTICE */
/*  ADD LOCATION */
	function add_notice($inputData)
    {
        // Add a new notice
		$this->db->insert('notices', $inputData);
		Return;
    }
}// End of Class
?>