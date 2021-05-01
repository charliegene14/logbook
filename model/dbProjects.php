<?php 

require_once 'model/database.php';

class dbProjects extends database
{
	public function getCount()
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->query('SELECT COUNT(idProject) AS total FROM projects');
		$COUNT = $QUERY->fetch()['total'];
		return $COUNT;
	}

	public function getAll()
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->query('SELECT * FROM projects p
							LEFT JOIN category_post cp
							ON p.typeCat = cp.Type');
		return $QUERY;
	}

	public function getProject($idProject)
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT * FROM projects p
								LEFT JOIN category_post cp
								ON p.typeCat = cp.Type
								WHERE idProject = ?');

		if ($this->dbExist($QUERY, $idProject)) {
			$QUERY->execute(array($idProject));

			while ($data = $QUERY->fetch()) {
				$array[0] = $data;
			}
			return $array[0];
		} else {
			throw new Exception('Oops, projet introuvable.');
		}
	}

	public function getLastVersion($idProject)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare('SELECT * FROM projects_versions
								WHERE theVersion =
									(SELECT MAX(theVersion) FROM projects_versions
									WHERE idProject = ?)');

		if ($this->dbExist($QUERY, $idProject)) {
			$QUERY->execute(array($idProject));
			while ($data = $QUERY->fetch()) {
				$array[0] = $data;
			}
			return $array[0];
		} else {
			return false;
		}
	}

	public function getFirstPost($idProject)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare('SELECT * FROM post
								 WHERE datePost =
										(SELECT MIN(datePost) FROM post p
											LEFT JOIN projects prj
											ON p.Type = prj.typeCat
										 	WHERE prj.idProject = ?)');

		if ($this->dbExist($QUERY, $idProject)) {
			$QUERY->execute(array($idProject));
			while ($data = $QUERY->fetch()) {
				$array[0] = $data;
			}
			return $array[0];
		} else {
			return false;
		}
	}

	public function getLastPost($idProject)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare('SELECT * FROM post
								 WHERE datePost =
										(SELECT MAX(datePost) FROM post p
											LEFT JOIN projects prj
											ON p.Type = prj.typeCat
										 	WHERE prj.idProject = ?)');

		if ($this->dbExist($QUERY, $idProject)) {
			$QUERY->execute(array($idProject));
			while ($data = $QUERY->fetch()) {
				$array[0] = $data;
			}
			return $array[0];
		} else {
			return false;
		}
	}

	public function getVersions($idProject)
	{
		$DB = $this->dbConnect();

		$CHECK = $DB->prepare('SELECT * FROM projects WHERE idProject = ?');
		$QUERY = $DB->prepare('SELECT * FROM projects_versions WHERE idProject = ? ORDER BY dateVersion DESC');

		if ($this->dbExist($CHECK, $idProject)) {
			$QUERY->execute(array($idProject));
			return $QUERY;
		} else {
			throw new Exception('Oops, projet introuvable.');
		}
	}

	public function getNumberPosts($idProject)
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT COUNT(idPost)
								AS number
								FROM post p
								LEFT JOIN projects prj
								ON p.Type = prj.TypeCat
								WHERE prj.idProject = ?');
		$QUERY->execute(array($idProject));
		$result = $QUERY->fetch()['number'];
		return $result;
	}

	public function getTotalTime($idProject)
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(timePost)))
								AS total
								FROM post p
								LEFT JOIN projects prj
								ON p.Type = prj.TypeCat
								WHERE prj.idProject = ?');
		$QUERY->execute(array($idProject));

		$result = strval($QUERY->fetch()['total']);
		return $result;
	}

	public function getHoursParts(int $idProject): array
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT p.Work,
								SUM(TIME_TO_SEC(p.timePost)) / 3600 as hoursFloat,
								SEC_TO_TIME(SUM(TIME_TO_SEC(p.timePost))) as hoursStr,
								wp.nameWork
								FROM post p
								LEFT JOIN work_parts wp
								ON p.Work = wp.idWork
								LEFT JOIN projects prj
								ON p.Type = prj.typeCat
								WHERE prj.idProject = ?
								GROUP BY p.Work');

		$QUERY->execute(array($idProject));
		$workParts = $QUERY->fetchAll();
		$newArray = [];

		foreach ($workParts as $part) {
			if ($part['nameWork'] == NULL) {
				$part['nameWork'] = 'Dans aucune partie';
			}
			array_push($newArray, $part);
		}

		return $newArray;
	}

	public function getHoursTools(int $idProject): array
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT p.Tool,
									SUM(TIME_TO_SEC(p.timePost)) / 3600 as hoursFloat,
									SEC_TO_TIME(SUM(TIME_TO_SEC(p.timePost))) as hoursStr,
									t.nameTool
								FROM post p
								LEFT JOIN tools t
								ON p.Tool = t.idTool
								LEFT JOIN projects prj
								ON p.Type = prj.typeCat
								WHERE prj.idProject = ?
								GROUP BY p.Tool');

		$QUERY->execute(array($idProject));
		$tools = $QUERY->fetchAll();
		$newArray = [];

		foreach ($tools as $tool) {
			if ($tool['nameTool'] == NULL) {
				$tool['nameTool'] = 'Avec aucun outil';
			}
			array_push($newArray, $tool);
		}

		return $newArray;
	}
}
