<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class User extends CI_Controller {

	public function index()
	{
		$this->load->view('signup');
	}

	public function new()
	{
		$data["first_name"] = $this->input->post("first_name", TRUE); // TRUE = XSS filter on
		$data["last_name"]  = $this->input->post("last_name", TRUE);
		$data["email"]      = $this->input->post("email", TRUE);

		$this->load->model("User_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->User_model->add($data);
	}

	public function update($user_id)
	{
		$data["user_id"] = $user_id; // get current userid

		$this->load->model("User_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->User_model->update($data);
	}

	public function delete($user_id)
	{
		$data["user_id"] = $user_id; // get current userid

		$this->load->model("User_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->User_model->delete($data);
	}

	public function add_friend($user_id)
	{
		$data[] = ; // get current userid
		$data[] = $user_id; // freind userid
		$data = $this->_sort_IDs($data);

		$this->load->model("User_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->User_model->add_friend($data);
	}

	public function delete_friend($user_id)
	{
		$data[] = ; // get current userid
		$data[] = $user_id; // friend userid
		$data = $this->_sort_IDs($data);

		$this->load->model("User_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->User_model->delete_friend($data);
	}

	private function _sort_IDs($ids) // sort low to high before entering db
	{
		sort($ids);
		return array("user_id_1" => $ids[0], "user_id_2" => $ids[1]);
	}
}
