<?php
class Company_model extends Model
{

    function Company_model()
    {
        parent::Model();
        $this->load->model('global_model');
    }

	function get_company_combo($companyId)
	// Get a list of companies for a combo box display
	{
		$output = '';
		$query = $this->db->query("select * from companies order by companyName desc"); 
		foreach($query->result() as $row){
			$output .= '<option value="' .  $row->companyId . '"';
			if($row->companyId == $companyId)
			{
				$output .= ' selected';
			}
			$output .= '>' . $row->companyName . '</option>';
		}
		return $output;
	}
	
	function get_company_by_id($companyId)
	{
		$output = '';
					$this->db->select('companyId, companyName'); 
		$query =	$this->db->get_where('companies', array('companyId' => $companyId));
		foreach($query->result() as $row){
			$output .= "<input type=\"text\" name=\"company\" value=\"" . $row->companyName . "\" readonly=\"true\" />";
		}
		return $output;
	}

    
}// End of Class
?>