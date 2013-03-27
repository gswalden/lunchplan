<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function add($data)
    {
        $this->db->insert("users", $data);
    }

    function update($data, $id)
    {
        $this->db->where("id", $id);
        $this->db->update("users", $data);
    }

    function delete($data)
    {
        $this->db->delete("users", $data);
    }
}