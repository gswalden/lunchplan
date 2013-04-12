<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Event extends CI_Controller {

	public function index()
	{
		$this->load->view('event');
	}

	public function add_group($event_id, $group_id) // add group to event
	{
		$data["event_id"] = $event_id;
		$data["group_id"] = $group_id;
		$this->load->model("Event_model");
		$this->Event_model->add_group($data);
	}

	public function create() // create new event
	{
		$post = $this->input->post();
		$post["user_id"] = $this->session->userdata("user_id");
		$this->load->library("Eventclass");
		$this->Eventclass->create($post);

		redirect("/");
	}

	public function delete($event_id) // delete event
	{
		$data["event_id"] = $event_id;
		$this->load->model("Event_model");
		$this->Event_model->delete($data);
		redirect("/");
	}

	public function delete_group($event_id, $group_id) // remove group from event
	{
		$data["event_id"] = $event_id;
		$data["group_id"] = $group_id;
		$this->load->model("Event_model");
		$this->Event_model->delete_group($data);
	}

	public function invite($event_id, $response) // add current user to event
	{
		$data["user_id"] = $this->session->userdata("user_id"); // get current userid
		$data["event_id"] = $event_id;
		if ($response == "yes")
			$response = TRUE;
		else
			$response = FALSE;

		$this->load->model("Event_model");
		$this->Event_model->invite($data, $response);

		redirect("/");
	}

	public function join($event_id) // add current user to event
	{
		$data["user_id"] = $this->session->userdata("user_id"); // Get current user_id
		$data["event_id"] = $event_id;
		$this->load->model("Event_model");
		$this->Event_model->join($data);
		redirect("/");
	}

	public function leave($event_id) // remove current user from event
	{
		$data["user_id"] = $this->session->userdata("user_id"); // Get current user_id
		$data["event_id"] = $event_id;
		$this->load->model("Event_model");
		$this->Event_model->leave($data);
		redirect("/");
	}

	public function update($event_id) // update event
	{
		$data["event_id"] = $event_id;
		$this->load->model("Event_model");
		$this->Event_model->update($data);
	}
}