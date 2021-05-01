<?php 

require_once 'model/database.php';

class dbPosts extends database
{
	public function getList($wherePost, $postByPage)
	{
		$DB = $this->dbConnect();

		$REQ_TOTAL_POSTS = $DB->prepare("SELECT COUNT(idPost) AS total FROM post p WHERE $wherePost");
		$REQ_TOTAL_POSTS->execute();

		$TOTAL_POSTS = $REQ_TOTAL_POSTS->fetch()['total'];
		$TOTAL_PAGE = ceil($TOTAL_POSTS / $postByPage);

		if (isset($_GET['pg']) and intval($_GET['pg']) and $_GET['pg'] > 0) {
			$PAGE_NOW = $_GET['pg'];
			if ($PAGE_NOW > $TOTAL_PAGE) {
				throw new Exception('Désolé, la page demandée n\'éxiste pas.');
			}
		} else {
			$PAGE_NOW = 1;
		}

		$FIRST_POST = ($PAGE_NOW - 1) * $postByPage;

		$REQ_POSTS = $DB->prepare("SELECT * FROM post p
							INNER JOIN category_post cp
							ON p.Type = cp.Type
							LEFT JOIN work_parts wp
							ON p.Work = wp.idWork
							LEFT JOIN tools t
							ON p.Tool = t.idTool
							WHERE $wherePost
							ORDER BY p.datePost DESC, p.idPost DESC
							LIMIT $FIRST_POST, $postByPage");

		if ($this->dbExist($REQ_POSTS, NULL)) {
			$REQ_POSTS->execute();
			return [$REQ_POSTS, $TOTAL_PAGE, $PAGE_NOW];
		} else {
			throw new Exception('Désolé, une erreur est survenue');
		}
	}

	public function getPost($idPost)
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare("SELECT * FROM post p
								INNER JOIN category_post cp
								ON p.Type = cp.Type
								LEFT JOIN work_parts wp
								ON p.Work = wp.idWork
								LEFT JOIN tools t
								ON p.Tool = t.idTool
								WHERE idPost = ?");

		if ($this->dbExist($QUERY, $idPost)) {
			$QUERY->execute(array($idPost));
			return $QUERY;
		} else {
			throw new Exception('Désolé, aucun article ici');
		}
	}

	public function getMonthList(?int $month = null, ?int $year = null): array
	{
		$DB = $this->dbConnect();

		$QUERY = $DB->prepare('SELECT * FROM post p
								INNER JOIN category_post cp
								ON p.Type = cp.Type
								LEFT JOIN work_parts wp
								ON p.Work = wp.idWork
								LEFT JOIN tools t
								ON p.Tool = t.idTool
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

		$QUERY = $DB->prepare('SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(timePost))) AS totalStr,
								SUM(TIME_TO_SEC(timePost)) / 3600 AS totalFloat
								FROM post p
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

		$array = $QUERY->fetchAll();
		$newArray = [];

		foreach ($array as $data) {
			if ($data['totalStr'] == NULL) {
				$data['totalStr'] = 'Aucune donnée';
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

		$QUERY = $DB->prepare("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(timePost)) / $numDays) AS average
								FROM post p
								WHERE datePost BETWEEN ? AND ?");

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

		$QUERY = $DB->prepare('SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(timePost))) AS total
								FROM post p
								WHERE datePost BETWEEN ? AND ?');

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

		$QUERY = $DB->prepare('SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(timePost))) AS total
								FROM post p');
		$QUERY->execute();
		$total = $QUERY->fetch()['total'];

		if ($total == null) {
			return 'Aucune donnée.';
		} else {
			return $total;
		}
	}
}
