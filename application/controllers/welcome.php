<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->session->set_userdata("user_id", "111"); // temporary for dev
		$user_id = $this->session->userdata("user_id");
		$this->load->model("User_model");
		$data["row"] = $this->db->get_where("users", 
									array("user_id" => $user_id))
								->row();
		$friends_array = $this->db->select("user_id_1, user_id_2")
								->where("user_id_1", $user_id)
								->or_where("user_id_2", $user_id)
								->get("friends")
								->result_array();
		$friends = array();
		array_walk_recursive($friends_array, function($f) use (&$friends, $user_id) 
											{ if ($f != $user_id) $friends[] = $f; });
		$data["friends"] = $this->db->where_in("user_id", $friends)
									->get("users")
									->result();


		$this->load->view("header");
		$this->load->view("welcome", $data);
	}
}
function flatten(array $array) 
{ 
	$return = array(); 
	array_walk_recursive($array, function($a,$b) use (&$return) { $return[$b] = $a; }); return $return; } 
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */