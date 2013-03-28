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