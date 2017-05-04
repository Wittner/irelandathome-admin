<?php

class Function_model extends Model
{

    function Function_model()
    {
        parent::Model();
    }

    function getTowns($townName)
    {
    	$this->db->like('town_name',$townName);
    	$this->db->orderby('town_name');
    	$query = $this->db->get('towns');
    	if($query->num_rows()>'0')
		{
			$output = '<li>';
			foreach($query->result() as $function_info)
			{
				$output .= '<strong>' . $function_info->town_name . '</strong>';
			}
			$output .= '</li>';
			return $output;
		}else{return 'Sorry, there are no results';}
    }

}
?>