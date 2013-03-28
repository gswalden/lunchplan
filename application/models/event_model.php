<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Event_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function add($data)
    {
    	$this->db->insert("events", $data);
    }

    function update($data, $id)
    {
        $this->db->where("id", $id);
        $this->db->update("events", $data);
    }

    function join($data)
    {
    	$this->db->insert("event_members", $data);
    }

    function leave($data)
    {
        $this->db->delete("event_members", $data);
    }

    function delete($data)
    {
        $this->db->delete("events", $data);
    }

    function addGroup($data)
    {
        $this->db->insert("event_groups", $data);
    }

    function deleteGroup($data)
    {
        $this->db->delete("event_groups", $data);
    }
}