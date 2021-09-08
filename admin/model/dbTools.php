<?php 

require_once 'model/database.php';

class dbTools extends database
{
	public function getAll()
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->query('SELECT * FROM tools');
		return $QUERY;
	}

	public function getByType($typeCat)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare("SELECT t.idTool, t.nameTool FROM tools t
								INNER JOIN tool_to_post ttp
								ON t.idTool = ttp.idTool
								INNER JOIN post p 
								ON ttp.idPost = p.idPost
								WHERE p.Type = ?
								GROUP BY t.idTool");

		$QUERY->execute(array($typeCat));
		return $QUERY;
	}

	public function getByWork($idWork)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare("SELECT t.idTool, t.nameTool FROM tools t
								INNER JOIN tool_to_post ttp
								ON t.idTool = ttp.idTool
								INNER JOIN post p 
								ON ttp.idPost = p.idPost
								WHERE p.Work = ?
								GROUP BY t.idTool");

		$QUERY->execute(array($idWork));
		return $QUERY;
	}

	public function updateName($idTool, $nameTool)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM tools WHERE idTool = ?');
		$QUERY = $DB->prepare('UPDATE tools SET nameTool = ? WHERE idTool = ?');

		if ($this->dbExist($CHECKID, $idTool))
		{
			$QUERY->execute(array($nameTool, $idTool));
		}
		else
		{
			throw new Exception('Désolé, l\'outil n\'éxiste pas.');
		}
	}

	public function insert($idTool, $nameTool)
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('INSERT INTO tools (idTool, nameTool)
								VALUES (?, ?) ');

		$QUERY->execute(array($idTool, $nameTool));
	}

	public function delete($idTool)
	{
		$DB = $this->dbConnect();
		
		$CHECKID = $DB->prepare('SELECT * FROM tools WHERE idTool = ?');
		$MOVELINES = $DB->prepare('UPDATE tools SET idTool = idTool-1 WHERE idTool >= ?');
		$QUERY = $DB->prepare('DELETE FROM tools WHERE idTool = ?');

		if ($this->dbExist($CHECKID, $idTool))
		{
			$QUERY->execute(array($idTool));
			$MOVELINES->execute(array($idTool));
		}
		else
		{
			throw new Exception('Désolé, l\'outil n\'éxiste pas.');
		}
	}

	public function getIcon($idTool) {
		if (is_file('../public/img/tools/'.$idTool.'.png')):
		?>
			<img class="admin_tool_icon" src="../public/img/tools/<?=$idTool?>.png" />
		<?php
		endif;
	}

	public function nextID() {
		$DB = $this->dbConnect();
		$QUERY = $DB->query('SELECT MAX(idTool)+1 AS number FROM tools');

		return $QUERY->fetch()['number'];
	}
}