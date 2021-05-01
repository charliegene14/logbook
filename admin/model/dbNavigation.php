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

	public function updateName($idNav, $nameNav)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM navigation WHERE idNav = ?');
		$QUERY = $DB->prepare('UPDATE navigation SET nameNav = ? WHERE idNav = ?');

		if ($this->dbExist($CHECKID, $idNav))
		{
			$QUERY->execute(array($nameNav, $idNav));
		}
		else
		{
			throw new Exception('Désolé, le menu n\'éxiste pas.');
		}
	}

	public function updateLink($idNav, $linkNav)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM navigation WHERE idNav = ?');
		$QUERY = $DB->prepare('UPDATE navigation SET linkNav = ? WHERE idNav = ?');

		if ($this->dbExist($CHECKID, $idNav))
		{
			$QUERY->execute(array($linkNav, $idNav));
		}
		else
		{
			throw new Exception('Désolé, le menu n\'éxiste pas.');
		}
	}

	public function insert($idNav, $nameNav, $linkNav)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM navigation WHERE idNav = ?');
		$MOVELINES = $DB->prepare('UPDATE navigation SET idNav = idNav+1 WHERE idNav >= ? ORDER BY idNav DESC');

		$QUERY = $DB->prepare('INSERT INTO navigation (idNav, nameNav, linkNav)
								VALUES (?, ?, ?) ');

		if ($this->dbExist($CHECKID, $idNav))
		{
			$MOVELINES->execute(array($idNav));
		}

		$QUERY->execute(array($idNav, $nameNav, $linkNav));
	}

	public function delete($idNav)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM navigation WHERE idNav = ?');
		$MOVELINES = $DB->prepare('UPDATE navigation SET idNav = idNav-1 WHERE idNav >= ?');
		$QUERY = $DB->prepare('DELETE FROM navigation WHERE idNav = ?');

		if ($this->dbExist($CHECKID, $idNav))
		{
			$QUERY->execute(array($idNav));
			$MOVELINES->execute(array($idNav));
		}
		else
		{
			throw new Exception('Désolé, le menu n\'éxiste pas.');
		}
	}

	public function upLine($idNav)
	{
		$DB = $this->dbConnect();
		$CHECKID = $DB->prepare('SELECT * FROM navigation WHERE idNav = ?');

		$FIRST = $DB->prepare('UPDATE navigation SET idNav = idNav+1 WHERE idNav > ? ORDER BY idNav DESC');
		$SECOND = $DB->prepare('UPDATE navigation SET idNav = idNav+2 WHERE idNav = ? -1');
		$THIRD = $DB->prepare('UPDATE navigation SET idNav = idNav-1 WHERE idNav >= ?');

		if ($this->dbExist($CHECKID, $idNav))
		{
			$FIRST->execute(array($idNav));
			$SECOND->execute(array($idNav));
			$THIRD->execute(array($idNav));
		}
		else
		{
			throw new Exception('Désolé, le menu n\'éxiste pas.');
		}
	}

	public function downLine($idNav)
	{
		$DB = $this->dbConnect();
		$CHECKID = $DB->prepare('SELECT * FROM navigation WHERE idNav = ?');

		$FIRST = $DB->prepare('UPDATE navigation SET idNav = idNav-1 WHERE idNav < ?');
		$SECOND = $DB->prepare('UPDATE navigation SET idNav = idNav-2 WHERE idNav = ?+1');
		$THIRD = $DB->prepare('UPDATE navigation SET idNav = idNav+1 WHERE idNav <= ? ORDER BY idNav DESC');

		if ($this->dbExist($CHECKID, $idNav))
		{
			$FIRST->execute(array($idNav));
			$SECOND->execute(array($idNav));
			$THIRD->execute(array($idNav));
		}
		else
		{
			throw new Exception('Désolé, le menu n\'éxiste pas.');
		}
	}
}