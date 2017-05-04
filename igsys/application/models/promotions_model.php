<?php
class Promotions_model extends Model
{

    function Promotions_model()
    {
        parent::Model();
        $this->load->model('global_model');
    }

/*	GET ALL PROMOTIONS */
	function get_promotions_all()
	{
		$this->db->select('*');
		$this->db->from('promotions');
		$query = $this->db->get();	
		return $query;
	}
	
/* 	LIST PROMOTIONS */
	function list_promotions()
	{
        $output = '<div class="promotion_title">THE REAL DEAL</div><div class="promotion_subtitle">Very special offers from Ireland at Home</div><hr width="100%" />';
		$this->public_db->select('*');
		$this->public_db->from('promotions');
		$this->public_db->join('properties','properties.property_code = promotions.promotionPropertyCode');
		$this->public_db->join('towns','properties.property_town_id=towns.town_id');
		$query = $this->public_db->get();
		if ($query->num_rows() > 0)
		{
            foreach ($query->result() as $item)
			{
                $output .=
                '<div class="block_promotions">' .
					'<div class="promotion_property"><a class="promotino_property" href="index.php/promotions/edit_promotion/' . $item->promotionId .'">' . $item->property_name .'</a>&nbsp;</div>' .
					'<div class="promotion_description">' . $item->promotionDescription .'<br /><a href="index.php/promotions/delete_promotion/' . $item->promotionId . '">Remove</a></div>' .
					'<hr width="100%" />' .
    			'</div>';
            }
        }
		else
		{
            $output = '<h4>There are no current promotions!</h4>';
        }
        return $output;
	}

/*  ADD A PROMOTION */
	function add_promotion($promotionPropertyCode,$promotionDescription)
	{
		$data = array
			(
			'promotionId' => '',
			'promotionPropertyCode' => $promotionPropertyCode,
			'promotionDescription' => $promotionDescription
			);
		$this->public_db->insert('promotions', $data);
		$promotionId = $this->public_db->insert_id();
		return $promotionId;
	}

/*  UPDATE A PROMOTION */
	function update_promotion($promotionId,$promotionPropertyCode,$promotionDescription)
	{
		$data = array(
		'promotionPropertyCode' => $promotionPropertyCode,
		'promotionDescription' => $promotionDescription);
		$this->public_db->where('promotionId', $promotionId);
		$this->public_db->update('promotions', $data);
		return $promotionId;
	}

/*  DELETE A PROMOTION */
	function delete_promotion($promotionId)
	{
        $this->public_db->delete('promotions', array('promotionId' => $promotionId));
        return $promotionId;
	}

/*  GET PROMOTION BY ID */
	function get_promotion_by_id($promotionId)
	{
		$this->public_db->select('*');
		$this->public_db->from('promotions');
		$this->public_db->where("promotionId='$promotionId'");
		$query = $this->public_db->get();
		return $query;
	}


}// End of Class
?>