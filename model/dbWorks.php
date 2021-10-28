<?php 

require_once realpath($_SERVER['DOCUMENT_ROOT']).'/model/database.php';

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

		$QUERY = $DB->prepare("SELECT * FROM work_parts WHERE typeCat = ?");
		$QUERY->execute(array($typeCat));
		return $QUERY;
	}

	public function getByTool($idTool)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare("SELECT wp.typeCat, wp.idWork, wp.nameWork
								FROM work_parts wp
								INNER JOIN post p 
								ON wp.idWork = p.Work
								INNER JOIN tool_to_post ttp
								ON p.idPost = ttp.idPost
								WHERE ttp.idTool = ?
								GROUP BY wp.idWork");

		$QUERY->execute(array($idTool));
		return $QUERY;
	}

	public function getByTypeTool($typeCat, $idTool) {
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare("SELECT wp.typeCat, wp.idWork, wp.nameWork
								FROM work_parts wp
								INNER JOIN post p 
								ON wp.idWork = p.Work
								INNER JOIN tool_to_post ttp
								ON p.idPost = ttp.idPost
								WHERE ttp.idTool = ?
								AND wp.typeCat = ?
								GROUP BY wp.idWork");

		$QUERY->execute(array($idTool, $typeCat));
		return $QUERY;
	}
}
