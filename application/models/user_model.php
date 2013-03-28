<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function add($data)  // Create new user
    {
        $this->db->insert("users", $data);
    }

    function getFriends($user_id, $array=false) // true = return arrays, false = return objects
    {
        $query = $this->db->select("user_id_1, user_id_2")
                          ->where("user_id_1", $user_id)
                          ->or_where("user_id_2", $user_id)
                          ->get("friends");
        if ($query->num_rows() < 1)
            return false;                                  
        $friends_array = $query->result_array();
        $friends = array();
        array_walk_recursive($friends_array, function($f) use (&$friends, $user_id) 
                                            { if ($f != $user_id) $friends[] = $f; });
        $query = $this->db->where_in("user_id", $friends)
                          ->get("users");
        if ($array)
            return $query->result_array();
        return $query->result();       
    }

    function getNonFriends($user_id)
    {
        $friends_array = $this->getFriends($user_id, true);
        $friends = array($user_id); // array begins with current user, then add friends
        if ($friends_array !== false)
            array_walk_recursive($friends_array, function($f) use (&$friends) 
                                                { $friends[] = $f; });
        return $this->db->where_not_in("user_id", $friends)
                        ->get("users")
                        ->result();        
    }

    function getUser($user_id)
    {
        return $this->db->get_where("users", array("user_id" => $user_id))->row();        
    }

    function update($data, $id) // Update user
    {
        $this->db->where("id", $id);
        $this->db->update("users", $data);
    }

    function delete($data) // Delete user
    {
        $this->db->delete("users", $data);
        $this->_delete_all_friends($data['id']);
    }

    function add_friend($data) // Create friendship
    {
        $this->db->insert("friends", $data);
    }

    function delete_friend($data) // Deletes a friendship
    {
        $this->db->where($data);
        $this->db->delete("friends"); // $data should contain both ids
    }

    private function _delete_all_friends($id) // Deletes all user's friendships 
    {
        $this->db->where("user_id_1", $id);
        $this->db->or_where("user_id_2", $id);
        $this->db->delete("friends");
    }
}