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

	public function getList($wherePost, $postByPage)
	{
		$DB = $this->dbConnect();

		$REQ_TOTAL_POSTS = $DB->prepare("SELECT COUNT(idPost) AS total FROM post p WHERE $wherePost");
		$REQ_TOTAL_POSTS->execute();

		$TOTAL_POSTS = $REQ_TOTAL_POSTS->fetch()['total'];
		$TOTAL_PAGE = ceil($TOTAL_POSTS / $postByPage);

		if(isset($_GET['pg']) AND intval($_GET['pg']) AND $_GET['pg'] > 0)
		{
			$PAGE_NOW = $_GET['pg'];
			if ($PAGE_NOW > $TOTAL_PAGE)
			{
				throw new Exception('Désolé, la page demandée n\'éxiste pas.');
			}
		}
		else
		{
			$PAGE_NOW = 1;
		}

		$FIRST_POST = ($PAGE_NOW - 1) * $postByPage;

		$REQ_POSTS = $DB->prepare("SELECT * FROM post p
							INNER JOIN category_post cp
							ON p.Type = cp.Type
							LEFT JOIN work_parts wp
							ON p.Work = wp.idWork
							LEFT JOIN tools t
							ON p.Tool = t.idTool
							WHERE $wherePost
							ORDER BY p.idPost DESC
							LIMIT $FIRST_POST, $postByPage");

		if ($this->dbExist($REQ_POSTS, NULL))
		{
			$REQ_POSTS->execute();
			return [$REQ_POSTS, $TOTAL_PAGE, $PAGE_NOW];
		}
		else
		{
			throw new Exception('Désolé, une erreur est survenue.');
		}
		
	}

	public function getPost($idPost)
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare("SELECT * FROM post p
								INNER JOIN category_post cp
								ON p.Type = cp.Type
								LEFT JOIN work_parts wp
								ON p.Work = wp.idWork
								LEFT JOIN tools t
								ON p.Tool = t.idTool
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

	public function insert($idPost, $type, $work, $tool, $timePost, $titlePost, $datePost, $contentPost)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare('INSERT INTO post (idPost, Type, Work, Tool, timePost, titlePost, datePost, contentPost)
							VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

		if ($work == 'NULL' AND $tool == 'NULL')
		{
			$QUERY->execute(array($idPost, $type, NULL, NULL, $timePost, $titlePost, $datePost, $contentPost));
		}
		elseif ($tool == 'NULL')
		{
			$QUERY->execute(array($idPost, $type, $work, NULL, $timePost, $titlePost, $datePost, $contentPost));
		}
		elseif ($work == 'NULL')
		{
			$QUERY->execute(array($idPost, $type, NULL, $tool, $timePost, $titlePost, $datePost, $contentPost));
		}
		else
		{
			$QUERY->execute(array($idPost, $type, $work, $tool, $timePost, $titlePost, $datePost, $contentPost));
		}
	}

	public function update($idPost, $type, $work, $tool, $timePost, $titlePost, $datePost, $contentPost)
	{
		$DB = $this->dbConnect();
		$CHECKID = $DB->prepare('SELECT * FROM post WHERE idPost = ?');

		$QUERY = $DB->prepare('UPDATE post
								SET Type = ?,
								Work = ?,
								Tool = ?,
								timePost = ?,
								titlePost = ?,
								datePost = ?,
								contentPost = ?
								WHERE idPost = ?');

		if ($this->dbExist($CHECKID, $idPost))
		{
			if ($work == 'NULL' AND $tool == 'NULL')
			{
				$QUERY->execute(array($type, NULL, NULL, $timePost, $titlePost, $datePost, $contentPost, $idPost));
			}
			elseif ($tool == 'NULL')
			{
				$QUERY->execute(array($type, $work, NULL, $timePost, $titlePost, $datePost, $contentPost, $idPost));
			}
			elseif ($work == 'NULL')
			{
				$QUERY->execute(array($type, NULL, $tool, $timePost, $titlePost, $datePost, $contentPost, $idPost));
			}
			else
			{
				$QUERY->execute(array($type, $work, $tool, $timePost, $titlePost, $datePost, $contentPost, $idPost));
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
}