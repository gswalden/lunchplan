<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Group extends CI_Controller {

	public function index()
	{
		$this->load->view('signup');
	}

	public function new()
	{
		$data["name"] = $this->input->post("name", TRUE); // TRUE = XSS filter on
		$data["user_id"] = ; // get current userid

		$this->load->model("Group_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->Group_model->add($data);
	}

	public function update($group_id)
	{
		$data["group_id"] = $group_id; // get current userid

		$this->load->model("Group_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->Group_model->update($data);
	}

	public function join($group_id)
	{
		$data["group_id"] = $group_id; // get current userid
		$data["user_id"] = ; // get current userid

		$this->load->model("Group_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->Group_model->join($data);
	}

	public function leave($group_id)
	{
		$data["group_id"] = $group_id; // get current userid
		$data["user_id"] = ; // get current userid

		$this->load->model("Group_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->Group_model->leave($data);
	}

	public function delete($group_id)
	{
		$data["group_id"] = $group_id; // get current userid

		$this->load->model("Group_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->Group_model->delete($data);
	}
}