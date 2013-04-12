<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

require_once APPPATH . "libraries/REST_Controller.php";

class API extends REST_Controller {

	public function events_get()
	{
		$event_id = $this->get("id");
		if ( ! $event_id)
			$this->response(NULL, 400);
		$this->load->model("Event_model");

		$type = $this->get("type");
		switch ($type) {
			case "my":
				$data = $this->Event_model->get_my_events($user_id);
				break;
			case "invites":
				$data = $this->Event_model->get_events($user_id, 1);
				break;
			case "friends":
				$data = $this->Event_model->get_friends_events($user_id);
				break;	
			case "all":
			default:
				$data = $this->Event_model->get_events($user_id);
				break;
		}
				
		$this->_send_response($data);
	}

	public function event_get()
	{
		$event_id = $this->get("id");
		if ( ! $event_id)
			$this->response(NULL, 400);

		$this->load->model("Event_model");
		$data = $this->Event_model->get_event($event_id);
		
		$this->_send_response($data);
	}

	public function events_get()
	{
		$user_id = $this->get("id");
		if ( ! $user_id)
			$this->response(NULL, 400);
		$this->load->model("Event_model");
		$type = $this->get("type");
		switch ($type) {
			case "my":
				$data = $this->Event_model->get_my_events($user_id);
				break;
			case "invites":
				$data = $this->Event_model->get_events($user_id, 1);
				break;
			case "friends":
				$data = $this->Event_model->get_friends_events($user_id);
				break;	
			case "all":
			default:
				$data = $this->Event_model->get_events($user_id);
				break;
		}
				
		$this->_send_response($data);
	}

	public function friendships_get()
	{
		$user_id = $this->get("id");
		if ( ! $user_id)
			$this->response(NULL, 400);

		$this->load->model("User_model");
		$data = $this->User_model->get_friends($user_id);
		
		$this->_send_response($data);
	}

	public function respond_friendship_post()
	{
		$user_id = $this->get("user_id"); // user getting request
		$friend_id = $this->get("friend_id");
		$response = $this->get("response");
		if ( ! ($user_id AND $friend_id))
			$this->response(NULL, 400);

		$data = $this->_sort_IDs(array($user_id, $friend_id));
		$this->load->model("User_model");
		$data = $this->User_model->invite($data, $response);
		
		$this->_send_response(array('status' => 'success'));
	}

	public function request_friendship_post()
	{
		$user_id = $this->get("user_id"); // user sending request
		$friend_id = $this->get("friend_id");
		if ( ! ($user_id AND $friend_id))
			$this->response(NULL, 400);

		$data = $this->_sort_IDs(array($user_id, $friend_id));
		if ($data["user_id_1"] == $friend_id)
			$data["pending"] = 1; // first user_id receives request
		else
			$data["pending"] = 2; // second user_id receives request
		$this->load->model("User_model");
		$data = $this->User_model->add_friend($user_id);
		
		$this->_send_response(array('status' => 'success'));
	}

	public function user_get()
	{
		$user_id = $this->get("id");
		if ( ! $user_id)
			$this->response(NULL, 400);

		$this->load->model("User_model");
		$data = $this->User_model->get_user($user_id);
		
		$this->_send_response($data);
	}

	public function user_post()
	{

	}

	private function _send_response($data)
	{
		if ($data)
			$this->response($data, 200);
		else
			$this->response(NULL, 404);
	}

	private function _sort_IDs($ids) // sort low to high before entering db; important for simpler add/drop functions
	{
		sort($ids);
		return array("user_id_1" => $ids[0], "user_id_2" => $ids[1]);
	}

}