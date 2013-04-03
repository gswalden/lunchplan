<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Event_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function add($data)
    {
    	$this->db->insert("events", $data);
        return $this->db->insert_id();
    }

    function add_group($data)
    {
        $this->db->insert("event_groups", $data);
    }

    function delete($data)
    {
        $this->db->delete("events", $data);
    }

    function delete_group($data)
    {
        $this->db->delete("event_groups", $data);
    }

    function get_events($user_id, $array=FALSE, $pending = 0) // TRUE = return arrays, FALSE = return objects
    {
        if ($pending < 2) // 0 = get accepted events; 1 = get invites; 2 = get others
            $this->db->where("pending", $pending);
        $query = $this->db->select("event_id")
                          ->where("user_id", $user_id)
                          ->get("event_members");
        if ($query->num_rows() < 1)
            return FALSE;                                  
        $events_array = $query->result_array();

        $events = array();
        array_walk_recursive($events_array, function($e) use (&$events) 
                                            { $events[] = $e; });
        $query = $this->db->where_in("event_id", $events)
                          ->get("events");
        
        if ($array)
            return $query->result_array();
        return $query->result();       
    }

    function get_non_events($user_id)
    {
        $events_array = $this->get_events($user_id, TRUE, 2);
        
        $events = array();
        if ($events_array !== FALSE):
            array_walk_recursive($events_array, function($e) use (&$events) 
                                                { $events[] = $e; });
            $this->db->where_not_in("event_id", $events);
        endif;
        $query = $this->db->get("events");
        
        if ($query->num_rows() < 1)
            return FALSE;
        return $query->result();        
    }

    function invite($data, $response)
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

    function join($data)
    {
    	$this->db->insert("event_members", $data);
    }

    function leave($data)
    {
        $this->db->delete("event_members", $data);
    }

    function update($data, $id)
    {
        $this->db->where("id", $id);
        $this->db->update("events", $data);
    }
}