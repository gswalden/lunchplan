<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Eventclass
{
	private $CI;

	public function __construct()
	{
		$this->CI =& get_instance(); // sets CI as refernce to framework (in order to use)
	}

	public function create($post)
	{
		$user_id = $post["user_id"];
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
		$data["user_id"] = $user_id;		

		$this->CI->load->model("Event_model");
		$this->CI->db->trans_start();
		$event_id = $this->CI->Event_model->add($data);
		
		unset($data, $datetime, $post["user_id"], $post["event_name"], $post["location"], $post["start"], 
			$post["length"], $post["event_submit"]);

		$data = array("event_id" => $event_id,
					  "user_id"  => $user_id);
		$this->CI->Event_model->join($data);

		unset($data);

		$keys = array_keys($post);
		foreach ($keys as $key)
			if (strpos($key, "group") !== FALSE)
				$valid_keys[] = $key;
		if (isset($valid_keys)):
			$data["event_id"] = $event_id;
			$this->CI->load->model("Group_model");
			foreach ($valid_keys as $valid_key):
				$data["group_id"] = $post[$valid_key];
				$this->CI->Event_model->add_group($data);
				$group_members = $this->CI->Group_model->get_group_members($data["group_id"]);
				foreach ($group_members as $group_member):
					$users_to_invite[] = $group_member->user_id;
				endforeach;
				unset($post[$valid_key]);
			endforeach;
		endif;
		
		unset($data, $group_members, $group_member, $keys, $key, $valid_keys, $valid_key);
		
		$keys = array_keys($post);
		foreach ($keys as $key)
			if (strpos($key, "friend") !== FALSE)
				$valid_keys[] = $key;
		if (isset($valid_keys))	
			foreach ($valid_keys as $valid_key)
				$users_to_invite[] = $post[$valid_key];

		if (isset($users_to_invite)):
			$data = array("event_id" => $event_id,
						  "pending"  => 1);
			$users_to_invite = array_unique($users_to_invite);
		    unset($users_to_invite[array_search($user_id, $users_to_invite)]); // exclude creator (already added)
			foreach ($users_to_invite as $user_to_invite):
				$data["user_id"] = $user_to_invite;
				$this->CI->Event_model->join($data);
			endforeach;
		endif;
		$this->CI->db->trans_complete();
	}

	public function invite()
	{

	}
}