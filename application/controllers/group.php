<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Group extends CI_Controller {

	public function index()
	{
		$this->load->view('signup');
	}

	public function create() // create new group
	{
		$post = $this->input->post();
		$user_id = $this->session->userdata("user_id"); // get current userid
		unset($post["user_id"]);

		$data["name"] = $post["group_name"];
		unset($post["group_name"]);
		$data["user_id"] = $user_id;

		$this->load->model("Group_model");
		$group_id = $this->Group_model->add($data);

		unset($data);
		$data = array("group_id" => $group_id,
					  "user_id"  => $user_id);
		$this->Group_model->join($data);

		unset($data);
		$keys = array_keys($post);
		foreach ($keys as $key)
			if (strpos($key, "friend") !== FALSE)
				$valid_keys[] = $key;
		$data = array("group_id" => $group_id,
					  "pending"  => 1);
		foreach ($valid_keys as $valid_key):
			$data["user_id"] = $post[$valid_key];
			$this->Group_model->join($data);
		endforeach;

		redirect("/");
	}

	public function delete($group_id) // delete group
	{
		$data["group_id"] = $group_id;

		$this->load->model("Group_model");
		$this->Group_model->delete($data);

		redirect("/");
	}

	public function invite($group_id, $response) // add current user to event
	{
		$data["user_id"] = $this->session->userdata("user_id"); // get current userid
		$data["group_id"] = $group_id;
		if ($response == "yes")
			$response = TRUE;
		else
			$response = FALSE;

		$this->load->model("Group_model");
		$this->Group_model->invite($data, $response);

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