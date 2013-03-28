<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Event extends CI_Controller {

	public function index()
	{
		$this->load->view('event');
	}

	public function new() // create new event
	{
		$data["event_name"] = $this->input->post("event_name", TRUE); // TRUE = XSS filter on
		$data["location"]   = $this->input->post("location", TRUE);
		$data["start"]      = $this->input->post("start", TRUE);
		$data["end"]        = $this->input->post("end", TRUE);
		$data["user_id"]    = $this->session->userdata("user_id");		
		$data["group"]      = $this->input->post("group", TRUE);		

		$this->load->model("Event_model");
		$this->Event_model->add($data);
	}

	public function join($event_id) // add current user to event
	{
		$data["user_id"] = $this->session->userdata("user_id"); // Get current user_id
		$data["event_id"] = $event_id;
		$this->load->model("Event_model");
		$this->Event_model->join($data);
	}

	public function leave($event_id) // remove current user from event
	{
		$data["user_id"] = $this->session->userdata("user_id"); // Get current user_id
		$data["event_id"] = $event_id;
		$this->load->model("Event_model");
		$this->Event_model->leave($data);
	}

	public function delete($event_id) // delete event
	{
		$data["event_id"] = $event_id;
		$this->load->model("Event_model");
		$this->Event_model->delete($data);
	}

	public function update($event_id) // update event
	{
		$data["event_id"] = $event_id;
		$this->load->model("Event_model");
		$this->Event_model->update($data);
	}

	public function addGroup($event_id, $group_id) // add group to event
	{
		$data["event_id"] = $event_id;
		$data["group_id"] = $group_id;
		$this->load->model("Event_model");
		$this->Event_model->addGroup($data);
	}

	public function leave($event_id, $group_id) // remove group from event
	{
		$data["event_id"] = $event_id;
		$data["group_id"] = $group_id;
		$this->load->model("Event_model");
		$this->Event_model->deleteGroup($data);
	}
}