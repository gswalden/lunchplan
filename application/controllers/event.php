<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Event extends CI_Controller {

	public function index()
	{
		$this->load->view('event');
	}

	public function create() // create new event
	{
		$user_id = $this->session->userdata("user_id");	
		$data["name"] = $this->input->post("event_name");
		$data["location"]   = $this->input->post("location");
		$datetime      		= new DateTime(null, new DateTimeZone("America/New_York"));
		switch ($this->input->post("start")) {
			case "today":
				break;
			case "tomorrow":
				$datetime->add(new DateInterval("P1D"));
				break;
			case "overmorrow":
				$datetime->add(new DateInterval("P2D"));
				break;	
		}
		$data["start"] = $datetime->format("Y-m-d H:i:s");
		switch ($this->input->post("length")) {
			case "30min":
				$datetime->add(new DateInterval("PT30M"));
				break;
			case "1hr":
				$datetime->add(new DateInterval("PT1H"));
				break;
			case "2hr":
				$datetime->add(new DateInterval("PT2H"));
				break;	
		}
		$data["end"]     = $datetime->format("Y-m-d H:i:s");
		unset($datetime);
		$data["user_id"] = $user_id;		

		$this->load->model("Event_model");
		$event_id = $this->Event_model->add($data);
		
		unset($data);
		$data = array("event_id" => $event_id,
					  "user_id"  => $user_id);
		$this->Event_model->join($data, FALSE);

		unset($data);
		$data["event_id"] = $event_id;
		$i = 1;
		$post_data = $this->input->post("group$i");
		while ($post_data !== FALSE):
			$data["group_id"] = $post_data;
			$this->Event_model->addGroup($data);
			$i++;
			$post_data = $this->input->post("group$i");
		endwhile;
		
		unset($data, $i, $post_data);
		$data = array("event_id" => $event_id,
					  "pending"  => 1);
		$i = 1;
		$post_data = $this->input->post("friend$i");
		while ($post_data !== FALSE):
			$data["user_id"] = $post_data;
			$this->Event_model->join($data, FALSE);
			$i++;
			$post_data = $this->input->post("friend$i");
		endwhile;

		redirect("/");
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

	public function deleteGroup($event_id, $group_id) // remove group from event
	{
		$data["event_id"] = $event_id;
		$data["group_id"] = $group_id;
		$this->load->model("Event_model");
		$this->Event_model->deleteGroup($data);
	}
}