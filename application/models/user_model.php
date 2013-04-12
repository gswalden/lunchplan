<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class User_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function add($data)  // Create new user
    {
        $this->db->insert("users", $data);
        return $this->db->insert_id();
    }

    public function add_friend($data) // Create friendship
    {
        $this->db->insert("friends", $data);
    }
    
    public function delete($data) // Delete user
    {
        $this->db->delete("users", $data);
    }

    public function delete_friend($data) // Deletes a friendship
    {
        $this->db->where($data);
        $this->db->delete("friends"); // $data should contain both ids
    }

    public function get_friends($user_id, $pending=0) // TRUE = return arrays, FALSE = return objects
    {
        switch ($pending) {
            case 0: // all confirmed friends
                $sql = "pending = '$pending' AND (user_id_1 = '$user_id' OR user_id_2 = '$user_id')";
                break;
            case 1: // requested friends, if current user received request
                $sql = "(user_id_1 = '$user_id' AND pending = '1') OR (user_id_2 = '$user_id' AND pending = '2')";
                break;
            case 2: // pending requests from current user
                $sql = "(user_id_1 = '$user_id' AND pending = '2') OR (user_id_2 = '$user_id' AND pending = '1')";
                break;
            default: // all others (not friends, not requested)
                $sql = "user_id_1 = '$user_id' OR user_id_2 = '$user_id'";
                break;
        }
        $query = $this->db->select("user_id_1, user_id_2")
                          ->where($sql)
                          ->get("friends");
        if ($query->num_rows() < 1)
            return FALSE;                                  
        $friends_array = $query->result();

        $friends = array();
        foreach ($friends_array as $friend)
            if ($friend->user_id_1 != $user_id)
                $friends[] = $friend->user_id_1;
            else
                $friends[] = $friend->user_id_2;

        return $this->db->where_in("user_id", $friends)
                        ->get("users")
                        ->result();       
    }

    public function get_non_friends($user_id)
    {
        $friends = array($user_id); // array begins with current user, then add friends & requests
        $friends_array = $this->get_friends($user_id, 3);
        if ($friends_array !== FALSE):
            foreach ($friends_array as $friend)
                $friends[] = $friend->user_id;
            $this->db->where_not_in("user_id", $friends);
        endif;
        $query = $this->db->get("users");
        
        if ($query->num_rows() < 1)
            return FALSE;
        return $query->result();
    }

    public function get_user($user_id)
    {
        return $this->db->get_where("users", array("user_id" => $user_id))->row();        
    }

    public function invite($data, $response)
    {
        if ($response):
            $this->db->where($data);
            $res["pending"] = 0;
            $this->db->update("friends", $res);
        else:
            $this->db->where($data);
            $this->db->delete("friends");
        endif;    
    }

    public function update($data, $id) // Update user
    {
        $this->db->where("id", $id);
        $this->db->update("users", $data);
    }

    private function _delete_all_friends($id) // Deletes all user's friendships 
    {
        $this->db->where("user_id_1", $id);
        $this->db->or_where("user_id_2", $id);
        $this->db->delete("friends");
    }
}