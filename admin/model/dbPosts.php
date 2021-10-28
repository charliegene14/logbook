<?php 

require_once 'model/database.php';

class dbPosts extends database
{
	public function getNumber($param)
	{
		$DB = $this->dbConnect();

		if ($param == NULL)
		{
			$QUERY = $DB->query('SELECT MAX(idPost) AS number FROM post');
		}
		elseif ($param == 'nextID')
		{
			$QUERY = $DB->query('SELECT MAX(idPost)+1 AS number FROM post');
		}

		$NUMBER = $QUERY->fetch()['number'];
		return $NUMBER;
	}

	public function getAll() {
		$db = $this->dbConnect();
		$query = $db->prepare(' SELECT * FROM post p
                                LEFT JOIN category_post cp ON p.Type = cp.Type
                                LEFT JOIN work_parts wp ON p.Work = wp.idWork
                                LEFT JOIN tool_to_post ttp ON p.idPost = ttp.idPost
                                LEFT JOIN tools t ON ttp.idTool = t.idTool
                                ORDER BY p.datePost DESC, p.idPost DESC');
        $query->execute();
		return $query;
	}

	public function getPost($idPost)
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare("SELECT * FROM post p
								INNER JOIN category_post cp
								ON p.Type = cp.Type
								LEFT JOIN work_parts wp
								ON p.Work = wp.idWork
								WHERE idPost = ?");

 		if ($this->dbExist($QUERY, $idPost))
		{
			$QUERY->execute(array($idPost));
			return $QUERY;
		}
		else
		{
			throw new Exception('Désolé, aucun article ici');
		}
	}

	public function getTools($idPost) {
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare("SELECT * FROM tool_to_post WHERE idPost = ?");

		$QUERY->execute(array($idPost));

		$array = [];
		while ($data = $QUERY->fetch()) {
			array_push($array, $data);
		}

		return $array;
	}

	public function insert($idPost, $type, $work, $titlePost, $datePost, $contentPost)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare('INSERT INTO post (idPost, Type, Work, titlePost, datePost, contentPost)
							VALUES (?, ?, ?, ?, ?, ?)');

		if ($work == 'NULL') {
			$QUERY->execute(array($idPost, $type, NULL, $titlePost, $datePost, $contentPost));
		} else {
			$QUERY->execute(array($idPost, $type, $work, $titlePost, $datePost, $contentPost));
		}
	}

	public function update($idPost, $type, $work, $titlePost, $datePost, $contentPost)
	{
		$DB = $this->dbConnect();
		$CHECKID = $DB->prepare('SELECT * FROM post WHERE idPost = ?');

		$QUERY = $DB->prepare('UPDATE post
								SET Type = ?,
								Work = ?,
								titlePost = ?,
								datePost = ?,
								contentPost = ?
								WHERE idPost = ?');

		if ($this->dbExist($CHECKID, $idPost))
		{
			if ($work == 'NULL')
			{
				$QUERY->execute(array($type, NULL, $titlePost, $datePost, $contentPost, $idPost));
			}
			else
			{
				$QUERY->execute(array($type, $work, $titlePost, $datePost, $contentPost, $idPost));
			}
		}
		else
		{
			throw new Exception('Désolé, l\'article est introuvable');
		}
	}

	public function delete($idPost)
	{
		$DB = $this->dbConnect();
		$CHECKID = $DB->prepare('SELECT * FROM post WHERE idPost = ?');
		$QUERY = $DB->prepare('DELETE FROM post WHERE idPost = ?');


		if ($this->dbExist($CHECKID, $idPost))
		{
			$QUERY->execute(array($idPost));
		}
		else
		{
			throw new Exception('Désolé, l\'article est introuvable');
		}
	}

	public function insertTool(int $idTool = null, int $idPost, $time) {
		$DB = $this->dbConnect();
		
		$QUERY = $DB->prepare('INSERT INTO tool_to_post (idTool, idPost, timeTool)
								VALUES (?, ?, ?)');

		if ($idTool == NULL) {
			$QUERY->execute(array(NULL, $idPost, $time));
		} else {
			$QUERY->execute(array($idTool, $idPost, $time));
		}
	}

	public function updateTool(int $id, int $idTool = null, int $idPost, $time) {
		$DB = $this->dbConnect();
		$CHECKID = $DB->prepare('SELECT * FROM tool_to_post WHERE id = ?');

		$QUERY = $DB->prepare('UPDATE tool_to_post
								SET idTool = ?,
								idPost = ?,
								timeTool = ?
								WHERE id = ?');

		if ($this->dbExist($CHECKID, $id)) {
			$QUERY->execute(array($idTool, $idPost, $time, $id));
		} else {
			throw new Exception('Désolé, une erreur est survenue.');
		}
	}

	public function deleteTool(int $id) {
		$DB = $this->dbConnect();
		$CHECKID = $DB->prepare('SELECT * FROM tool_to_post WHERE id = ?');
		$QUERY = $DB->prepare('DELETE FROM tool_to_post WHERE id = ?');

		if ($this->dbExist($CHECKID, $id))
		{
			$QUERY->execute(array($id));
		}
	}
}