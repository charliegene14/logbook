<?php 

require_once realpath($_SERVER["DOCUMENT_ROOT"]).'/model/database.php';

class dbPassword extends database
{
	public function getPass($namePass)
	{
		$DB = $this->dbConnect();

		$REQ_PASS = $DB->prepare('SELECT thePass FROM passwds WHERE namePass = ?');

		if ($this->dbExist($REQ_PASS, $namePass))
		{
			$REQ_PASS->execute(array($namePass));
			$DBPASS = $REQ_PASS->fetch()['thePass'];
			return $DBPASS;
		}
		else
		{
			throw new Exception('Le nom de mot de passe n\'éxiste pas dans la BDD');
		}
	}
}