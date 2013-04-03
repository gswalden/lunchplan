<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class User extends CI_Controller {

	public function index()
	{
		$this->load->view('header');
		$this->load->view('welcome');
	}

	public function add_friend($user_id) // add friendship between current user & $user_id
	{
		$data[] = $this->session->userdata("user_id"); // get current userid
		$data[] = $user_id; // friend userid
		$data = $this->_sort_IDs($data);
		if ($data["user_id_1"] == $user_id)
			$data["pending"] = 1; // first user_id receives request
		else
			$data["pending"] = 2; // second user_id receives request

		$this->load->model("User_model");
		$this->User_model->add_friend($data);
		
		redirect("/");
	}

	public function create() // create new user
	{
		$data["first_name"] = $this->input->post("first_name");
		$data["last_name"]  = $this->input->post("last_name");
		$data["email"]      = $this->input->post("email");

		$this->load->model("User_model");
		$this->User_model->add($data);

		redirect("/");
	}

	public function delete($user_id) // delete user
	{
		$data["user_id"] = $user_id;

		$this->load->model("User_model");
		$this->User_model->delete($data);
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

	public function invite($user_id, $response)
	{
		$data[] = $this->session->userdata("user_id"); // get current userid
		$data[] = $user_id; // friend userid
		$data = $this->_sort_IDs($data);
		if ($response == "yes")
			$response = TRUE;
		else
			$response = FALSE;

		$this->load->model("User_model");
		$this->User_model->invite($data, $response);

		redirect("/");
	}

	public function update($user_id) // update user
	{
		$data["user_id"] = $user_id;

		$this->load->model("User_model");
		$this->User_model->update($data);
	}

	private function _sort_IDs($ids) // sort low to high before entering db; important for simpler add/drop functions
	{
		sort($ids);
		return array("user_id_1" => $ids[0], "user_id_2" => $ids[1]);
	}
}
