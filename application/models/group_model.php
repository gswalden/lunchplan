<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Group_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function add($data)
    {
    	$this->db->insert("groups", $data);
    }

    function update($data, $id)
    {
        $this->db->where("id", $id);
        $this->db->update("groups", $data);
    }

    function join($data)
    {
    	$this->db->insert("group_members", $data);
    }

    function leave($data)
    {
        $this->db->delete("group_members", $data);
    }

    function delete($data)
    {
        $this->db->delete("groups", $data);
    }

    function getGroups($user_id, $array=false) // true = return arrays, false = return objects
    {
        $query = $this->db->select("group_id")
                          ->where("user_id", $user_id)
                          ->get("group_members");
        if ($query->num_rows() < 1)
            return false;                                  
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

    function getNonGroups($user_id)
    {
        $groups_array = $this->getGroups($user_id, true);
        $groups = array();
        if ($groups_array !== false):
            array_walk_recursive($groups_array, function($g) use (&$groups) 
                                                { $groups[] = $g; });
            $this->db->where_not_in("group_id", $groups);
        endif;
        $query = $this->db->get("groups");
        if ($query->num_rows() < 1)
            return false;
        return $query->result();        
    }
}