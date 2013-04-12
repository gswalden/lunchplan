<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Event_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function add($data)
    {
    	$this->db->insert("events", $data);
        return $this->db->insert_id();
    }

    public function add_group($data)
    {
        $this->db->insert("event_groups", $data);
        $this->load->model("Group_model");
        $group_members = $this->Group_model->get_group_members($data["group_id"]);
        foreach ($group_members as $group_member)
            $this->join(array("event_id" => $data["event_id"],
                              "pending"  => 1,
                              "user_id"  => $group_member->user_id));
    }

    public function delete($data)
    {
        $this->db->delete("events", $data);
    }

    public function delete_group($data)
    {
        $this->db->delete("event_groups", $data);
    }

    public function get_event()
    {
        return $this->db->get_where("events", array("event_id" => $event_id))->result();
    }
    
    public function get_events($user_id, $pending = 0)
    {
        if ($pending < 2) // 0 = get accepted events; 1 = get invites; 2 = get others
            $this->db->where("pending", $pending);
        $query = $this->db->select("event_id")
                          ->where("user_id", $user_id)
                          ->get("event_members");
        if ($query->num_rows() < 1)
            return FALSE;                                  
        $events_array = $query->result();

        $events = array();
        foreach ($events_array as $event)
            $events[] = $event->event_id;

        $query = $this->db->where_in("event_id", $events)
                          ->get("events");
        
        return $query->result();       
    }

    public function get_friends_events($user_id)
    {
        $this->load->model("User_model");
        $friends = $this->User_model->get_friends($user_id);
        if ($friends === FALSE)
            return FALSE;
        foreach ($friends as $friend)
            $friend_list[] = $friend->user_id;
        unset($friends);
        $this->db->where_in("user_id", $friend_list);
        date_default_timezone_set("America/New_York");
        $this->db->where("end >", date("Y-m-d H:i:s"));
        $query = $this->db->get("events");
        if ($query->num_rows() < 1)
            return FALSE;
        return $query->result();
    }

    public function get_my_events($user_id)
    {
        return $this->db->get_where("events", array("user_id" => $user_id))->result();
    }

    public function get_non_events($user_id)
    {
        $events_array = $this->get_events($user_id, 2);
        
        if ($events_array !== FALSE):
            $events = array();
            foreach ($events_array as $event)
                $events[] = $event->event_id;
            $this->db->where_not_in("event_id", $events);
        endif;
        $query = $this->db->get("events");
        
        if ($query->num_rows() < 1)
            return FALSE;
        return $query->result();        
    }

    public function invite($data, $response)
    {
        if ($response):
            $this->db->where($data);
            $res["pending"] = 0;
            $this->db->update("event_members", $res);
        else:
            $this->db->where($data);
            $this->db->delete("event_members");
        endif;    
    }

    public function join($data)
    {
    	$this->db->insert("event_members", $data);
    }

    public function leave($data)
    {
        $this->db->delete("event_members", $data);
    }

    public function update($data, $id)
    {
        $this->db->where("id", $id);
        $this->db->update("events", $data);
    }
}