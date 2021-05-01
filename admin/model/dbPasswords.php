<?php 

require_once 'model/database.php';

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

	public function update($namePass, $newPass)
	{
		$DB = $this->dbConnect();
		$CHECK = $DB->prepare('SELECT thePass FROM passwds WHERE namePass = ?');
		$UPDATE = $DB->prepare('UPDATE passwds SET thePass = ? WHERE namePass = ?');

		if ($this->dbExist($CHECK, $namePass))
		{
			$UPDATE->execute(array($newPass, $namePass));
		}
		else
		{
			throw new Exception('Le nom de mot de passe n\'éxiste pas dans la BDD');
		}
	}
}