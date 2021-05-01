<?php 

require_once 'model/database.php';

class dbCategories extends database
{
	public function getAll()
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->query('SELECT * FROM category_post');
		return $QUERY;
	}

	public function getByTool($idTool)
	{
		$DB= $this->dbConnect();
		$QUERY = $DB->prepare("SELECT cp.Type, cp.nameCat
								FROM category_post cp
								INNER JOIN post p 
								ON cp.Type = p.Type
								WHERE p.Tool = ?
								GROUP BY cp.Type");

		$QUERY->execute(array($idTool));
		return $QUERY;
	}

	public function getByWork($idWork)
	{
		$DB= $this->dbConnect();
		$QUERY = $DB->prepare("SELECT cp.Type, cp.nameCat
								FROM category_post cp
								INNER JOIN post p 
								ON cp.Type = p.Type
								WHERE p.Work = ?
								GROUP BY cp.Type");

		$QUERY->execute(array($idWork));
		return $QUERY;
	}

	public function updateName($type, $nameCat)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM category_post WHERE Type = ?');
		$QUERY = $DB->prepare('UPDATE category_post SET nameCat = ? WHERE Type = ?');

		if ($this->dbExist($CHECKID, $type))
		{
			$QUERY->execute(array($nameCat, $type));
		}
		else
		{
			throw new Exception('Désolé, la catégorie n\'éxiste pas.');
		}
	}

	public function updateColor($type, $colorCat)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM category_post WHERE Type = ?');
		$QUERY = $DB->prepare('UPDATE category_post SET colorCat = ? WHERE Type = ?');

		if ($this->dbExist($CHECKID, $type))
		{
			$QUERY->execute(array($colorCat, $type));
		}
		else
		{
			throw new Exception('Désolé, la catégorie n\'éxiste pas.');
		}
	}

	public function insert($type, $nameCat, $colorCat)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM category_post WHERE Type = ?');
		$MOVELINES = $DB->prepare('UPDATE category_post SET Type = Type+1 WHERE Type >= ? ORDER BY Type DESC');

		$QUERY = $DB->prepare('INSERT INTO category_post (Type, nameCat, colorCat)
								VALUES (?, ?, ?) ');

		if ($this->dbExist($CHECKID, $type))
		{
			$MOVELINES->execute(array($type));
		}

		$QUERY->execute(array($type, $nameCat, $colorCat));
	}

	public function delete($type)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM category_post WHERE Type = ?');
		$MOVELINES = $DB->prepare('UPDATE category_post SET Type = Type-1 WHERE Type >= ?');
		$QUERY = $DB->prepare('DELETE FROM category_post WHERE Type = ?');

		if ($this->dbExist($CHECKID, $type))
		{
			$QUERY->execute(array($type));
			$MOVELINES->execute(array($type));
		}
		else
		{
			throw new Exception('Désolé, la catégorie n\'éxiste pas.');
		}
	}

	public function upLine($type)
	{
		$DB = $this->dbConnect();
		$CHECKID = $DB->prepare('SELECT * FROM category_post WHERE Type = ?');

		$FIRST = $DB->prepare('UPDATE category_post SET Type = Type+1 WHERE Type > ? ORDER BY Type DESC');
		$SECOND = $DB->prepare('UPDATE category_post SET Type = Type+2 WHERE Type = ? -1');
		$THIRD = $DB->prepare('UPDATE category_post SET Type = Type-1 WHERE Type >= ?');

		if ($this->dbExist($CHECKID, $type))
		{
			$FIRST->execute(array($type));
			$SECOND->execute(array($type));
			$THIRD->execute(array($type));
		}
		else
		{
			throw new Exception('Désolé, la catégorie n\'éxiste pas.');
		}
	}

	public function downLine($type)
	{
		$DB = $this->dbConnect();
		$CHECKID = $DB->prepare('SELECT * FROM category_post WHERE Type = ?');

		$FIRST = $DB->prepare('UPDATE category_post SET Type = Type-1 WHERE Type < ?');
		$SECOND = $DB->prepare('UPDATE category_post SET Type = Type-2 WHERE Type = ?+1');
		$THIRD = $DB->prepare('UPDATE category_post SET Type = Type+1 WHERE Type <= ? ORDER BY Type DESC');

		if ($this->dbExist($CHECKID, $type))
		{
			$FIRST->execute(array($type));
			$SECOND->execute(array($type));
			$THIRD->execute(array($type));
		}
		else
		{
			throw new Exception('Désolé, la catégorie n\'éxiste pas.');
		}
	}
}