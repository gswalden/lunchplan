<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Group extends CI_Controller {

	public function index()
	{
		$this->load->view('signup');
	}

	public function create() // create new group
	{
		$data["name"] = $this->input->post("group_name");
		$data["user_id"] = $this->session->userdata("user_id"); // get current userid

		$this->load->model("Group_model");
		$this->Group_model->add($data);

		redirect("/");
	}

	public function delete($group_id) // delete group
	{
		$data["group_id"] = $group_id;

		$this->load->model("Group_model");
		$this->Group_model->delete($data);

		redirect("/");
	}

	public function join($group_id) // add current user to group
	{
		$data["group_id"] = $group_id;
		$data["user_id"] = $this->session->userdata("user_id"); // get current userid

		$this->load->model("Group_model");
		$this->Group_model->join($data);

		redirect("/");
	}

	public function leave($group_id) // remove current user from group
	{
		$data["group_id"] = $group_id;
		$data["user_id"] = $this->session->userdata("user_id"); // get current userid

		$this->load->model("Group_model");
		$this->Group_model->leave($data);

		redirect("/");
	}

	public function update($group_id) // update group
	{
		$data["group_id"] = $group_id;

		$this->load->model("Group_model");
		$this->Group_model->update($data);
	}
}