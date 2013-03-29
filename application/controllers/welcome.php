<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->session->set_userdata("user_id", "111"); // temporary for dev
		$user_id = $this->session->userdata("user_id");
		$this->load->model("User_model");
		$this->load->model("Group_model");
		$data["user"] = $this->User_model->getUser($user_id);
		$data["friends"] = $this->User_model->getFriends($user_id);
		$data["nonfriends"] = $this->User_model->getNonFriends($user_id);
		$data["input_first"] =	array(
				              "name"        => "first_name",
				              "placeholder" => "First name",
				              "maxlength"   => "100");
		$data["input_last"] =	array(
				              "name"        => "last_name",
				              "placeholder" => "Last name",
				              "maxlength"   => "100");
		$data["input_email"] =	array(
				              "name"        => "email",
				              "placeholder" => "E-mail",
				              "maxlength"   => "100");
		$data["name_submit"] =	array(
				              "name"        => "name_submit");
		$data["input_group_name"] =	array(
				              "name"        => "group_name",
				              "placeholder" => "Group name",
				              "maxlength"   => "100");
		$data["group_submit"] =	array(
				              "name"        => "group_submit");
		$data["input_event_name"] =	array(
				              "name"        => "event_name",
				              "placeholder" => "Event name");
		$data["input_event_loc"] =	array(
				              "name"        => "location",
				              "placeholder" => "Location");
        $data["date_options"] = array(
        					"today"		    => "Today",
                  			"tomorrow"      => "Tomorrow",
                  			"overmorrow"    => "Overmorrow");
		$data["length_options"] =	array(
				              "30min"       => "30 Minutes",
				              "1hr"         => "1 Hour",
				              "2hr"         => "2 Hours");
		$data["event_submit"] =	array(
				              "name"        => "event_submit");

		$data["groups"] = $this->Group_model->getGroups($user_id);
		$data["nongroups"] = $this->Group_model->getNonGroups($user_id);
		$this->load->helper("form");
		$this->load->view("header");
		$this->load->view("welcome", $data);
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */