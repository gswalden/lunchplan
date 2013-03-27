<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class SignUp extends CI_Controller {

	public function index()
	{
		$this->load->view('signup');
	}

	public function newUser()
	{
		$data["first_name"] = $this->input->post("first_name", TRUE); // TRUE = XSS filter on
		$data["last_name"]  = $this->input->post("last_name", TRUE);
		$data["email"]      = $this->input->post("email", TRUE);

		$this->load->model("User_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->User_model->add($data);
	}

	public function newGroup()
	{
		$data["name"] = $this->input->post("name", TRUE); // TRUE = XSS filter on
		$data["user_id"] = ; // get current userid

		$this->load->model("Group_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->Group_model->add($data);
	}
}
