<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Groupclass
{
	private $CI;

	public function __construct()
	{
		$this->CI =& get_instance(); // sets CI as refernce to framework (in order to use)	
	}

	public function create($post)
	{
		$user_id = $post["user_id"];
		$data["name"] = $post["group_name"];
		$data["user_id"] = $user_id;

		$this->CI->load->model("Group_model");
		$this->CI->db->trans_start();
		$group_id = $this->CI->Group_model->add($data);

		unset($data);
		$data = array("group_id" => $group_id,
					  "user_id"  => $user_id);
		$this->CI->Group_model->join($data);

		unset($data, $post["user_id"], $post["group_name"], $post["group_submit"]);
		$keys = array_keys($post);
		foreach ($keys as $key)
			if (strpos($key, "friend") !== FALSE)
				$valid_keys[] = $key;
		if (isset($valid_keys)):
			$data = array("group_id" => $group_id,
						  "pending"  => 1);	
			foreach ($valid_keys as $valid_key):
				$data["user_id"] = $post[$valid_key];
				$this->CI->Group_model->join($data);
			endforeach;
		endif;
		$this->CI->db->trans_complete();
	}

	public function invite($group_id, $user_id, $response)
	{
		$data["user_id"] = $user_id;
		$data["group_id"] = $group_id;

		if ($response == "yes")
			$response = TRUE;
		else
			$response = FALSE;

		$this->load->model("Group_model");
		$this->Group_model->invite($data, $response);
	}	
}