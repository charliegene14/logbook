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
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare("SELECT cp.Type, cp.nameCat
								FROM category_post cp
								INNER JOIN post p 
								ON cp.Type = p.Type
								INNER JOIN tool_to_post ttp
								ON ttp.idPost = p.idPost
								WHERE ttp.idTool = ?
								GROUP BY cp.Type");

		$QUERY->execute(array($idTool));
		return $QUERY;
	}

	public function getByWork($idWork)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare("SELECT cp.Type, cp.nameCat
								FROM category_post cp
								INNER JOIN post p 
								ON cp.Type = p.Type
								WHERE p.Work = ?
								GROUP BY cp.Type");

		$QUERY->execute(array($idWork));
		return $QUERY;
	}

	public function getHoursInMonth(?int $month = null, ?int $year = null): array
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT p.Type,
									SUM(TIME_TO_SEC(ttp.timeTool)) / 3600 as totalFloat, 
									SEC_TO_TIME(SUM(TIME_TO_SEC(ttp.timeTool))) as totalStr,
									cp.nameCat,
									cp.colorCat
								FROM post p
								LEFT JOIN category_post cp
								ON p.Type = cp.Type
								LEFT JOIN tool_to_post ttp
								ON p.idPost = ttp.idPost
								WHERE p.datePost
								BETWEEN ?
								AND ?
								GROUP BY p.Type');

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

		return $QUERY->fetchAll();
	}

	public function getHoursInYear(?int $year = null): array
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT p.Type,
									SUM(TIME_TO_SEC(ttp.timeTool)) / 3600 as totalFloat, 
									SEC_TO_TIME(SUM(TIME_TO_SEC(ttp.timeTool))) as totalStr,
									cp.nameCat,
									cp.colorCat
								FROM post p
								LEFT JOIN category_post cp
								ON p.Type = cp.Type
								LEFT JOIN tool_to_post ttp
								ON p.idPost = ttp.idPost
								WHERE p.datePost
								BETWEEN ?
								AND ?
								GROUP BY p.Type');

		if ($year == null || $year < 1970 || $year > 2100) {
			$year = intval(date('Y'));
		}

		$startDate = new DateTime($year . '-01-01');
		$startYear = $startDate->format('Y-m-d');
		$endYear = (clone $startDate)->modify('+1 year -1 days')->format('Y-m-d');

		$QUERY->execute(array($startYear, $endYear));
		return $QUERY->fetchAll();
	}

	public function getTotalHours(): array
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT p.Type,
									SUM(TIME_TO_SEC(ttp.timeTool)) / 3600 as totalFloat, 
									SEC_TO_TIME(SUM(TIME_TO_SEC(ttp.timeTool))) as totalStr,
									cp.nameCat,
									cp.colorCat
								FROM post p
								LEFT JOIN category_post cp
								ON p.Type = cp.Type
								LEFT JOIN tool_to_post ttp
								ON p.idPost = ttp.idPost
								GROUP BY p.Type');

		$QUERY->execute();
		return $QUERY->fetchAll();
	}
}
