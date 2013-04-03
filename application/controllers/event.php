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
		$post             = $this->input->post();
		$user_id          = $this->session->userdata("user_id");	
		$data["name"]     = $post["event_name"];
		$data["location"] = $post["location"];
		$datetime         = new DateTime(NULL, new DateTimeZone("America/New_York"));
		switch ($post["start"]) {
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
		switch ($post["length"]) {
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
		unset($datetime, $post["user_id"], $post["event_name"], $post["location"], $post["start"], $post["length"]);
		$data["user_id"] = $user_id;		

		$this->load->model("Event_model");
		$event_id = $this->Event_model->add($data);
		
		unset($data);
		$data = array("event_id" => $event_id,
					  "user_id"  => $user_id);
		$this->Event_model->join($data);

		unset($data);
		$keys = array_keys($post);
		foreach ($keys as $key)
			if (strpos($key, "group") !== FALSE)
				$valid_keys[] = $key;
		$data["event_id"] = $event_id;
		foreach ($valid_keys as $valid_key):
			$data["group_id"] = $post[$valid_key];
			$this->Event_model->add_group($data);
			unset($post[$valid_key]);
		endforeach;
		
		unset($data, $keys, $key, $valid_keys, $valid_key);
		$keys = array_keys($post);
		foreach ($keys as $key)
			if (strpos($key, "friend") !== FALSE)
				$valid_keys[] = $key;
		$data = array("event_id" => $event_id,
					  "pending"  => 1);
		foreach ($valid_keys as $valid_key):
			$data["user_id"] = $post[$valid_key];
			$this->Event_model->join($data);
		endforeach;

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