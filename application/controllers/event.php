<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Event extends CI_Controller {

	public function index()
	{
		$this->load->view('event');
	}

	public function new()
	{
		$data["event_name"] = $this->input->post("event_name", TRUE); // TRUE = XSS filter on
		$data["location"]   = $this->input->post("location", TRUE);
		$data["start"]      = $this->input->post("start", TRUE);
		$data["end"]        = $this->input->post("end", TRUE);
		$data["planner"]    = $this->input->post("planner", TRUE);		
		$data["group"]      = $this->input->post("group", TRUE);		

		$this->load->model("Event_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->Event_model->add($data);
	}

	public function join($event_id)
	{
		$data["user_id"] = ; // Get current user_id
		$data["event_id"] = $event_id;
		$this->load->model("Event_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->Event_model->join($data);
	}

	public function leave($event_id)
	{
		$data["user_id"] = ; // Get current user_id
		$data["event_id"] = $event_id;
		$this->load->model("Event_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->Event_model->leave($data);
	}

	public function delete($event_id)
	{
		$data["event_id"] = $event_id;
		$this->load->model("Event_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->Event_model->delete($data);
	}

	public function update($event_id)
	{
		$data["event_id"] = $event_id;
		$this->load->model("Event_model", "", TRUE); // auto-connects to db w/ TRUE
		$this->Event_model->update($data);
	}
}