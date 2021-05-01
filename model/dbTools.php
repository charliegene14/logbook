<?php

require_once 'model/database.php';

class dbTools extends database
{
	public function getAll()
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->query('SELECT * FROM tools');
		return $QUERY;
	}

	public function getByType($typeCat)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare("SELECT t.idTool, t.nameTool FROM tools t
								INNER JOIN post p 
								ON t.idTool = p.Tool
								WHERE p.Type = ?
								GROUP BY t.idTool");

		$QUERY->execute(array($typeCat));
		return $QUERY;
	}

	public function getByWork($idWork)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare("SELECT t.idTool, t.nameTool FROM tools t
								INNER JOIN post p 
								ON t.idTool = p.Tool
								WHERE p.Work = ?
								GROUP BY t.idTool");

		$QUERY->execute(array($idWork));
		return $QUERY;
	}

	public function getHoursInMonth(?int $month = null, ?int $year = null): array
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT p.Tool,
									SUM(TIME_TO_SEC(p.timePost)) / 3600 as totalFloat, 
									SEC_TO_TIME(SUM(TIME_TO_SEC(p.timePost))) as totalStr,
									t.nameTool
								FROM post p
								LEFT JOIN tools t
								ON p.Tool = t.idTool
								WHERE p.datePost
								BETWEEN ?
								AND ?
								GROUP BY p.Tool');

		if ($month == null || $year == null) {
			$month = intval(date('m'));
		}
		if ($year == null || $year < 1970 || $year > 2100) {
			$year = intval(date('Y'));
		}

		$startDate = new DateTime($year . '-' . $month . '-01');
		$startMonth = $startDate->format('Y-m-d');
		$endMonth = (clone $startDate)->modify('+1 month -1 days')->format('Y-m-d');

		$QUERY->execute(array($startMonth, $endMonth));

		$array = $QUERY->fetchAll();
		$newArray = [];

		foreach ($array as $index) {
			if ($index['nameTool'] == NULL) {
				$index['nameTool'] = 'Aucun outil';
			}
			array_push($newArray, $index);
		}
		return $newArray;
	}

	public function getHoursInYear(?int $year = null): array
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT p.Tool,
									SUM(TIME_TO_SEC(p.timePost)) / 3600 as totalFloat, 
									SEC_TO_TIME(SUM(TIME_TO_SEC(p.timePost))) as totalStr,
									t.nameTool
								FROM post p
								LEFT JOIN tools t
								ON p.Tool = t.idTool
								WHERE p.datePost
								BETWEEN ?
								AND ?
								GROUP BY p.Tool');

		if ($year == null || $year < 1970 || $year > 2100) {
			$year = intval(date('Y'));
		}

		$startDate = new DateTime($year . '-01-01');
		$startYear = $startDate->format('Y-m-d');
		$endYear = (clone $startDate)->modify('+1 year -1 days')->format('Y-m-d');

		$QUERY->execute(array($startYear, $endYear));
		$array = $QUERY->fetchAll();
		$newArray = [];

		foreach ($array as $index) {
			if ($index['nameTool'] == NULL) {
				$index['nameTool'] = 'Aucun outil';
			}
			array_push($newArray, $index);
		}
		return $newArray;
	}

	public function getTotalHours(): array
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT p.Tool,
									SUM(TIME_TO_SEC(p.timePost)) / 3600 as totalFloat, 
									SEC_TO_TIME(SUM(TIME_TO_SEC(p.timePost))) as totalStr,
									t.nameTool
								FROM post p
								LEFT JOIN tools t
								ON p.Tool = t.idTool
								GROUP BY p.Tool');

		$QUERY->execute();
		$array = $QUERY->fetchAll();
		$newArray = [];

		foreach ($array as $index) {
			if ($index['nameTool'] == NULL) {
				$index['nameTool'] = 'Aucun outil';
			}
			array_push($newArray, $index);
		}
		return $newArray;
	}
}
