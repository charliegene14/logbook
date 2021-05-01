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

	public function getPage($fileName)
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare("SELECT * FROM pages WHERE fileName = ?");

		if ($this->dbExist($QUERY, $fileName))
		{
			$QUERY->execute(array($fileName));
			return $QUERY;
		}
		else
		{
			throw new Exception('Désolé, la page demandée n\'éxiste pas.');
		}
	}

}