<?php

/**
 * @author Mike Brady
 * @copyright 2009
 */

class Admin_model extends Model{

	function validate()
	{
		$this->db->where('user_username', $this->input->post('username'));
		$this->db->where('user_password', sha1($this->input->post('password')));
		$query = $this->db->get('admins');
		
		if($query->num_rows == 1)
		{
			return true;
		}
	}
}

?>