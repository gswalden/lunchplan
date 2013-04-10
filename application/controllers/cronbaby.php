<?php
// Disable for development
//if ( ! CRON) exit("Only accessible via cron jobs.");

class Cronbaby extends CI_Controller {

	public function index()
	{
		
		$this->expired_events();
		$this->optimize_db();

		redirect("/");
	}

	public function expired_events()
	{
		$query = $this->db->get_where("events", array("end <" => date("Y-m-d H:i:s")));
		if ($query->num_rows() > 0):
			$events = $query->result_array();
			$this->db->trans_start();
			$this->db->insert_batch("events_old", $events);
			foreach ($events as $event)
				$event_ids[] = $event["event_id"];
			$this->db->where_in("event_id", $event_ids);
			$this->db->delete("events");
			$this->db->trans_complete();
		endif;
		// Handled by InnoDB foreign key relation
		//$this->expired_invites($event_ids);
	}

	public function expired_invites($ids = FALSE)
	{
		if ( ! $ids):
			$query = $this->db->select("event_id")
							  ->where("end <", date("Y-m-d H:i:s"))
							  ->get("events");
			if ($query->num_rows() > 0) {
				$event_ids = $query->result();
				foreach ($event_ids as $event_id)
					$ids[] = $event_id->event_id;
			}
			else
				return;
		endif;
			
		$this->db->where_in("event_id", $ids);
		$this->db->delete("event_members");
	}

	public function optimize_db()
	{
		$this->load->dbutil();
		$this->dbutil->optimize_database();
	}


}