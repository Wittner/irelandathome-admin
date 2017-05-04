<?php
/**
 * Offers
 * 
 * @package Ireland at Home 2009
 * @author Mike Brady
 * @copyright 2008
 * @version $Id$
 * @access public
 */
class Promotions extends Controller
{

    function Promotions()
    {
        parent::Controller();
        $this->load->database();
        $this->public_db = $this->load->database('public', true);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model('promotions_model');
        $this->load->model('global_model');
        $this->load->model('property_model');
        $this->global_model->is_logged_in();
    }

    function list_promotions()
    {
        $data['heading'] = 'Latest Promotions';
        $data['results'] = $this->promotions_model->list_promotions();
        $headerView = $this->global_model->get_standard_header_view();
        $this->load->view('promotions/promotions_list_view', $data);
        $this->load->view('footer_view');
    }
    
/*	ADD A PROMOTION INPUT VIEW */
	function add_promotion_input()
	{
		$data['heading'] = 'Add promotion';
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('controlbar_view',$data);
		$this->load->view('promotions/add_promotion_input_view',$data);
		$this->load->view('footer_view');
	}
	
/*  ADD A PROMOTION */
	function add_promotion()
	{
		$promotionPropertyCode = $this->input->post('promotionPropertyCode');
		$promotionDescription = $this->input->post('promotionDescription');
		$this->promotions_model->add_promotion($promotionPropertyCode,$promotionDescription);
		$this->list_promotions();
	}

/*  EDIT A PROMOTION */
	function edit_promotion($promotionId)
	{
		$data['heading'] = 'Edit Promotion';
		$data['query'] = $this->promotions_model->get_promotion_by_id($promotionId);
		$headerView = $this->global_model->get_standard_header_view();
		$this->load->view('controlbar_view',$data);
		$this->load->view('promotions/promotions_edit_view',$data);
		$this->load->view('footer_view');
	}

/*  UPDATE A PROMOTION */
	function update_promotion()
	{
		$promotionId = $this->input->post('promotionId');
		$promotionPropertyCode = $this->input->post('promotionPropertyCode');
		$promotionDescription = $this->input->post('promotionDescription');
		$this->promotions_model->update_promotion($promotionId,$promotionPropertyCode,$promotionDescription);
		$this->list_promotions();
	}

/*  DELETE A PROMOTION */
	function delete_promotion($promotionId)
	{
		$this->promotions_model->delete_promotion($promotionId);
		$this->list_promotions();
	}
	
}

?>
