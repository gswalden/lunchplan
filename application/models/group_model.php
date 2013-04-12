<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Group_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function add($data)
    {
    	$this->db->insert("groups", $data);
        return $this->db->insert_id();
    }

    public function delete($data)
    {
        $this->db->delete("groups", $data);
    }    

    public function get_groups($user_id, $pending = 0) // TRUE = return arrays, FALSE = return objects
    {
        if ($pending < 2) // 0 = get groups; 1 = get group invites; 2 = get others
            $this->db->where("pending", $pending);
        $query = $this->db->select("group_id")
                          ->where("user_id", $user_id)
                          ->get("group_members");
        if ($query->num_rows() < 1)
            return FALSE;                                  
        $groups_array = $query->result();
        
        $groups = array();
        foreach ($groups_array as $group)
            $groups[] = $group->group_id;
        $query = $this->db->where_in("group_id", $groups)
                          ->get("groups");

        return $query->result();       
    }

    public function get_group_members($group_id, $skip_current_user = TRUE)
    {
        if ($skip_current_user)
            $this->db->where("user_id !=", $this->session->userdata("user_id"));
        $this->db->where(array("group_id" => $group_id, "pending" => 0));
        return $this->db->get("group_members")->result();
    }

    public function get_non_groups($user_id)
    {
        $groups_array = $this->get_groups($user_id, 2);
        if ($groups_array !== FALSE):
            $groups = array();
            foreach ($groups_array as $group)
                $groups[] = $group->group_id;
            $this->db->where_not_in("group_id", $groups);
        endif;
        $query = $this->db->get("groups");
        if ($query->num_rows() < 1)
            return FALSE;
        return $query->result();        
    }

    public function invite($data, $response)
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

    public function join($data)
    {
    	$this->db->insert("group_members", $data);
    }

    public function leave($data)
    {
        $this->db->delete("group_members", $data);
    }
    
    public function update($data, $id)
    {
        $this->db->where("id", $id);
        $this->db->update("groups", $data);
    }
    
}