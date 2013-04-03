<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

if ( ! CRON) exit("Only accessible via cron jobs.");

class Cronbaby extends CI_Controller {

	public function index()
	{
		$this->optimize_db();
		
	}

	public function expired_invites()
	{
		
	}

	public function optimize_db()
	{
		$this->dbutil->optimize_database();
	}


}