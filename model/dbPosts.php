<?php 

require_once realpath($_SERVER['DOCUMENT_ROOT']).'/model/database.php';

class dbPosts extends database
{
	public function getAll() {
		$db = $this->dbConnect();
		$query = $db->prepare(' SELECT * FROM post p
                                LEFT JOIN category_post cp ON p.Type = cp.Type
                                LEFT JOIN work_parts wp ON p.Work = wp.idWork
                                LEFT JOIN tool_to_post ttp ON p.idPost = ttp.idPost
                                LEFT JOIN tools t ON ttp.idTool = t.idTool
                                ORDER BY p.datePost DESC, p.idPost DESC');
        $query->execute();
		return $query;
	}

	public function getPost($idPost)
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare("SELECT * FROM post p
								INNER JOIN category_post cp
								ON p.Type = cp.Type
								LEFT JOIN work_parts wp
								ON p.Work = wp.idWork
								WHERE idPost = ?");

		if ($this->dbExist($QUERY, $idPost)) {
			$QUERY->execute(array($idPost));
			return $QUERY;
		} else {
			throw new Exception('Désolé, aucun article ici');
		}
	}

	public function getTools($idPost) {
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare("SELECT * FROM tool_to_post ttp
								LEFT JOIN tools t
								ON ttp.idTool = t.idTool
								WHERE idPost = ?");

		$QUERY->execute(array($idPost));

		$array = [];
		while ($data = $QUERY->fetch()) {
			array_push($array, $data);
		}

		return $array;
	}

	public function getMonthList(?int $month = null, ?int $year = null): array
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT * FROM post p
								INNER JOIN category_post cp
								ON p.Type = cp.Type
								LEFT JOIN work_parts wp
								ON p.Work = wp.idWork
								WHERE datePost BETWEEN ? AND ?');

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

	public function getHoursInMonth(?int $month = null, ?int $year = null): array
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(ttp.timeTool))) AS totalStr,
								SUM(TIME_TO_SEC(ttp.timeTool)) / 3600 AS totalFloat
								FROM post p
								LEFT JOIN tool_to_post ttp
								ON p.idPost = ttp.idPost
								WHERE p.datePost BETWEEN ? AND ?');

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

		foreach ($array as $data) {
			if ($data['totalStr'] == NULL) {
				$data['totalStr'] = 'Aucune donnée';
				$data['totalFloat'] = 0;
			}
			array_push($newArray, $data);
		}

		return $newArray[0];
	}

	public function getAverageHoursInMonth(?int $month = null, ?int $year = null): string
	{
		$DB = $this->dbConnect();

		if ($month == null || $year == null) {
			$month = intval(date('m'));
		}
		if ($year == null || $year < 1970 || $year > 2100) {
			$year = intval(date('Y'));
		}

		$numDays = cal_days_in_month(0, $month, $year);

		$QUERY = $DB->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(ttp.timeTool)) / $numDays) AS average
								FROM post p
								LEFT JOIN tool_to_post ttp
								ON p.idPost = ttp.idPost
								WHERE p.datePost BETWEEN ? AND ?");

		$startDate = new DateTime($year . '-' . $month . '-01');
		$startMonth = $startDate->format('Y-m-d');
		$endMonth = (clone $startDate)->modify('+1 month -1 days')->format('Y-m-d');

		$QUERY->execute(array($startMonth, $endMonth));

		$total = $QUERY->fetch()['average'];

		if ($total == null) {
			return 'Aucune donnée';
		} else {
			return $total . ' / jour';
		}
	}

	public function getHoursInYear(?int $year = null): string
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(ttp.timeTool))) AS total
								FROM post p
								LEFT JOIN tool_to_post ttp
								ON p.idPost = ttp.idPost
								WHERE p.datePost BETWEEN ? AND ?');

		if ($year == null || $year < 1970 || $year > 2100) {
			$year = intval(date('Y'));
		}

		$startDate = new DateTime($year . '-01-01');
		$startYear = $startDate->format('Y-m-d');
		$endYear = (clone $startDate)->modify('+1 year -1 days')->format('Y-m-d');

		$QUERY->execute(array($startYear, $endYear));

		$total = $QUERY->fetch()['total'];

		if ($total == null) {
			return 'Aucune donnée';
		} else {
			return $total;
		}
	}

	public function getTotalHours(): string
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(ttp.timeTool))) AS total
								FROM post p
								LEFT JOIN tool_to_post ttp
								ON p.idPost = ttp.idPost');
		$QUERY->execute();
		$total = $QUERY->fetch()['total'];

		if ($total == null) {
			return 'Aucune donnée.';
		} else {
			return $total;
		}
	}
}
