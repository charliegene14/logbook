<?php 

class database
{
	protected function dbConnect()
	{
		$DB =  new PDO('mysql:host=localhost;dbname=logbook;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		return $DB;
	}

	protected function dbExist($query, $execute)
	{
		if ($execute == NULL) {
			if ($query->execute() && $query->fetchAll()) {
				$query->closeCursor();
				return true;
			}
		} else {
			if ($query->execute(array($execute)) && $query->fetchAll()) {
				$query->closeCursor();
				return true;
			}
		}
		$query->closeCursor();
		return false;
	}
}
