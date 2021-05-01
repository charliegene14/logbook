<?php 

require_once 'model/database.php';

class dbWorks extends database
{
	public function getAll()
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->query('SELECT * FROM work_parts');
		return $QUERY;
	}

	public function getByType($typeCat)
	{
		$DB = $this->dbConnect();

		if ($typeCat == NULL) {
			$QUERY = $DB->query('SELECT * FROM work_parts WHERE typeCat IS NULL');
			return $QUERY;
		} else {
			$QUERY = $DB->prepare("SELECT * FROM work_parts WHERE typeCat = ?");
			$QUERY->execute(array($typeCat));
			return $QUERY;
		}
	}

	public function getByTool($idTool)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare("SELECT wp.typeCat, wp.idWork, wp.nameWork
								FROM work_parts wp
								INNER JOIN post p 
								ON wp.idWork = p.Work
								WHERE p.Tool = ?
								GROUP BY wp.idWork");

		$QUERY->execute(array($idTool));
		return $QUERY;
	}
}
