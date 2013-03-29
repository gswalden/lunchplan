<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class User extends CI_Controller {

	public function index()
	{
		$this->load->view('header');
		$this->load->view('welcome');
	}

	public function create() // create new user
	{
		$data["first_name"] = $this->input->post("first_name", TRUE); // TRUE = XSS filter on
		$data["last_name"]  = $this->input->post("last_name", TRUE);
		$data["email"]      = $this->input->post("email", TRUE);

		$this->load->model("User_model");
		$this->User_model->add($data);

		redirect("/");
	}

	public function update($user_id) // update user
	{
		$data["user_id"] = $user_id;

		$this->load->model("User_model");
		$this->User_model->update($data);
	}

	public function delete($user_id) // delete user
	{
		$data["user_id"] = $user_id;

		$this->load->model("User_model");
		$this->User_model->delete($data);
	}

	public function add_friend($user_id) // add friendship between current user & $user_id
	{
		$data[] = $this->session->userdata("user_id"); // get current userid
		$data[] = $user_id; // friend userid
		$data = $this->_sort_IDs($data);

		$this->load->model("User_model");
		$this->User_model->add_friend($data);
		
		redirect("/");
	}

	public function delete_friend($user_id) // delete friendship between current user & $user_id
	{
		$data[] = $this->session->userdata("user_id"); // get current userid
		$data[] = $user_id; // friend userid
		$data = $this->_sort_IDs($data);

		$this->load->model("User_model");
		$this->User_model->delete_friend($data);
		
		redirect("/");
	}

	private function _sort_IDs($ids) // sort low to high before entering db; important for simpler add/drop functions
	{
		sort($ids);
		return array("user_id_1" => $ids[0], "user_id_2" => $ids[1]);
	}
}
