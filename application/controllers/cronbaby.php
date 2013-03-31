<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

if ( ! CRON) exit("Only accessible via cron jobs.");

class Cronbaby extends CI_Controller {

	public function index()
	{
		$this->_optimize_db();
		
	}

	private function _expired_invites()
	{
			
	}

	private function _optimize_db()
	{
		$this->dbutil->optimize_database();
	}


}