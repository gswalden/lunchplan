<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Group_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function add($data)
    {
    	$this->db->insert("groups", $data);
        return $this->db->insert_id();
    }

    function delete($data)
    {
        $this->db->delete("groups", $data);
    }    

    function get_groups($user_id, $array=FALSE, $pending = 0) // TRUE = return arrays, FALSE = return objects
    {
        if ($pending < 2) // 0 = get groups; 1 = get group invites; 2 = get others
            $this->db->where("pending", $pending);
        $query = $this->db->select("group_id")
                          ->where("user_id", $user_id)
                          ->get("group_members");
        if ($query->num_rows() < 1)
            return FALSE;                                  
        $groups_array = $query->result_array();
        $groups = array();
        array_walk_recursive($groups_array, function($g) use (&$groups) 
                                            { $groups[] = $g; });
        $query = $this->db->where_in("group_id", $groups)
                          ->get("groups");
        if ($array)
            return $query->result_array();
        return $query->result();       
    }

    function get_non_groups($user_id)
    {
        $groups_array = $this->get_groups($user_id, TRUE, 2);
        $groups = array();
        if ($groups_array !== FALSE):
            array_walk_recursive($groups_array, function($g) use (&$groups) 
                                                { $groups[] = $g; });
            $this->db->where_not_in("group_id", $groups);
        endif;
        $query = $this->db->get("groups");
        if ($query->num_rows() < 1)
            return FALSE;
        return $query->result();        
    }

    function invite($data, $response)
    {
        if ($response):
            $this->db->where($data);
            $res["pending"] = 0;
            $this->db->update("group_members", $res);
        else:
            $this->db->where($data);
            $this->db->delete("group_members");
        endif;    
    }

    function join($data)
    {
    	$this->db->insert("group_members", $data);
    }

    function leave($data)
    {
        $this->db->delete("group_members", $data);
    }
    
    function update($data, $id)
    {
        $this->db->where("id", $id);
        $this->db->update("groups", $data);
    }
    
}