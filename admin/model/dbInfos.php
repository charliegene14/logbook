<?php

require_once 'model/database.php';

class dbInfo extends database
{
	public function getList()
	{
		$DB = $this->dbConnect();
		$REQ_INFOS = $DB->prepare('SELECT * FROM infos');
		$REQ_INFOS->execute();
		
		return $REQ_INFOS;

	}

	public function getContent($nameInfo)
	{
		$DB = $this->dbConnect();
		$REQ_INFOS = $DB->prepare('SELECT contentInfo FROM infos WHERE nameInfo= ? ');
		

		if ($this->dbExist($REQ_INFOS, $nameInfo))
		{
			$REQ_INFOS->execute(array($nameInfo));
			$CONTENT_INFO = $REQ_INFOS->fetch()['contentInfo'];
			return $CONTENT_INFO;
		}
		else
		{
			throw new Exception('L\'information n\'éxiste pas dans la BDD');
		}
	}

	public function updateContent($nameInfo, $contentInfo)
	{
		$DB = $this->dbConnect();
		$REQ_INFOS = $DB->prepare('SELECT contentInfo FROM infos WHERE nameInfo= ? ');
		$REQ_UPDT = $DB->prepare('UPDATE infos SET contentInfo = ? WHERE nameInfo = ?');

		if ($this->dbExist($REQ_INFOS, $nameInfo))
		{
			$REQ_UPDT->execute(array($contentInfo, $nameInfo));
		}
		else
		{
			throw new Exception('L\'information n\'éxiste pas dans la BDD');
		}
	}
}