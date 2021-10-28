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

	public function updateName($idWork, $nameWork)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM work_parts WHERE idWork = ?');
		$QUERY = $DB->prepare('UPDATE work_parts SET nameWork = ? WHERE idWork = ?');

		if ($this->dbExist($CHECKID, $idWork))
		{
			$QUERY->execute(array($nameWork, $idWork));
		}
		else
		{
			throw new Exception('Désolé, la partie n\'éxiste pas.');
		}
	}

	public function insert($idWork, $typeCat, $nameWork)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM work_parts WHERE idWork = ?');
		$MOVELINES = $DB->prepare('UPDATE work_parts SET idWork = idWork+1 WHERE idWork >= ? ORDER BY idWork DESC');

		$QUERY = $DB->prepare('INSERT INTO work_parts (typeCat, idWork, nameWork)
								VALUES (?, ?, ?) ');

		if ($this->dbExist($CHECKID, $idWork))
		{
			$MOVELINES->execute(array($idWork));
		}

		$QUERY->execute(array($typeCat, $idWork, $nameWork));
	}

	public function delete($idWork)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM work_parts WHERE idWork = ?');
		$MOVELINES = $DB->prepare('UPDATE work_parts SET idWork = idWork-1 WHERE idWork >= ?');
		$QUERY = $DB->prepare('DELETE FROM work_parts WHERE idWork = ?');

		if ($this->dbExist($CHECKID, $idWork))
		{
			$QUERY->execute(array($idWork));
			$MOVELINES->execute(array($idWork));
		}
		else
		{
			throw new Exception('Désolé, la partie n\'éxiste pas.');
		}
	}

	public function upLine($idWork)
	{
		$DB = $this->dbConnect();
		$CHECKID = $DB->prepare('SELECT * FROM work_parts WHERE idWork = ?');

		$FIRST = $DB->prepare('UPDATE work_parts SET idWork = idWork+1 WHERE idWork > ? ORDER BY idWork DESC');
		$SECOND = $DB->prepare('UPDATE work_parts SET idWork = idWork+2 WHERE idWork = ? -1');
		$THIRD = $DB->prepare('UPDATE work_parts SET idWork = idWork-1 WHERE idWork >= ?');

		if ($this->dbExist($CHECKID, $idWork))
		{
			$FIRST->execute(array($idWork));
			$SECOND->execute(array($idWork));
			$THIRD->execute(array($idWork));
		}
		else
		{
			throw new Exception('Désolé, la partie n\'éxiste pas.');
		}
	}

	public function downLine($idWork)
	{
		$DB = $this->dbConnect();
		$CHECKID = $DB->prepare('SELECT * FROM work_parts WHERE idWork = ?');

		$FIRST = $DB->prepare('UPDATE work_parts SET idWork = idWork-1 WHERE idWork < ?');
		$SECOND = $DB->prepare('UPDATE work_parts SET idWork = idWork-2 WHERE idWork = ?+1');
		$THIRD = $DB->prepare('UPDATE work_parts SET idWork = idWork+1 WHERE idWork <= ? ORDER BY idWork DESC');

		if ($this->dbExist($CHECKID, $idWork))
		{
			$FIRST->execute(array($idWork));
			$SECOND->execute(array($idWork));
			$THIRD->execute(array($idWork));
		}
		else
		{
			throw new Exception('Désolé, le partie n\'éxiste pas.');
		}
	}
}