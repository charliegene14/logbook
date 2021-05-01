<?php 

require_once 'model/database.php';

class dbNavigation extends database
{
	public function getAll()
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->query('SELECT * FROM navigation');
		return $QUERY;
	}
}