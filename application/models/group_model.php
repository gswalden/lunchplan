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
}