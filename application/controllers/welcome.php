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
		$data["user"] = $this->User_model->getUser($user_id);
		$data["friends"] = $this->User_model->getFriends($user_id);


		$this->load->view("header");
		$this->load->view("welcome", $data);
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */