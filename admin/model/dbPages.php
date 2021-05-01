<?php

require_once 'model/database.php';

class dbPages extends database
{
	public function getAll()
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->query('SELECT * FROM pages');
		return $QUERY;
	}

	public function getContent($idPage)
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT * FROM pages WHERE idPage = ?');

		if ($this->dbExist($QUERY, $idPage))
		{
			$QUERY->execute(array($idPage));
			return $QUERY->fetch();
		}
		else
		{
			throw new Exception('Désolé, la page demandée n\'éxiste pas.');
		}
	}

	public function updateTitle($idPage, $titlePage)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM pages WHERE idPage = ?');
		$QUERY = $DB->prepare('UPDATE pages SET titlePage = ? WHERE idPage = ?');

		if ($this->dbExist($CHECKID, $idPage))
		{
			$QUERY->execute(array($titlePage, $idPage));
		}
		else
		{
			throw new Exception('Désolé, la page n\'éxiste pas.');
		}
	}

	public function updateFilename($idPage, $fileName)
	{
		$DB = $this->dbConnect();


		$CHECKID = $DB->prepare('SELECT * FROM pages WHERE idPage = ?');
		$QUERY = $DB->prepare('UPDATE pages SET fileName = ? WHERE idPage = ?');

		if ($this->dbExist($CHECKID, $idPage))
		{
			$QUERY->execute(array($fileName, $idPage));
		}
		else
		{
			throw new Exception('Désolé, la page n\'éxiste pas.');
		}
	}

	public function updateContent($idPage, $contentPage)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM pages WHERE idPage = ?');
		$QUERY = $DB->prepare('UPDATE pages SET contentPage = ? WHERE idPage = ?');

		if ($this->dbExist($CHECKID, $idPage))
		{
			$QUERY->execute(array($contentPage, $idPage));
		}
		else
		{
			throw new Exception('Désolé, la page n\'éxiste pas.');
		}
	}

	public function insert($titlePage, $fileName)
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('INSERT INTO pages (idPage, titlePage, fileName, contentPage)
								VALUES (NULL, ?, ?, "<p>To write...</p>") ');

		$QUERY->execute(array($titlePage, $fileName));
	}

	public function delete($idPage)
	{
		$DB = $this->dbConnect();

		$CHECKID = $DB->prepare('SELECT * FROM pages WHERE idPage = ?');
		$QUERY = $DB->prepare('DELETE FROM pages WHERE idPage = ?');

		if ($this->dbExist($CHECKID, $idPage))
		{
			$QUERY->execute(array($idPage));
		}
		else
		{
			throw new Exception('Désolé, la page n\'éxiste pas.');
		}
	}
}