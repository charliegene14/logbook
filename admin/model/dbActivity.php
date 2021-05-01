<?php 

require_once 'model/database.php';

class ActivityIP extends database
{
	function getIP()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] != $ip)
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != $ip)
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	function getActivity()
	{
		$DB = $this->dbConnect();

		$ip = $this->getIP();
		$date = date('Y-m-d');
		$time = date('H:i:s');
		$view = $_SERVER['REQUEST_URI'];
		$method = $_SERVER['REQUEST_METHOD'];
		$host = gethostbyaddr($ip);
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

		$INSERT = $DB->prepare("INSERT INTO activ_ip (Id, ipAddr, dateVisit, timeVisit, view, method, ipHost, userAgent, accptLang)
								VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

		if (!empty($ip))
		{
			$INSERT->execute(array(NULL, $ip, $date, $time, $view, $method, $host, $userAgent, $lang));
		}
		else
		{
			die('ERROR');
		}

	}
}

class dbActivities extends database
{
	function getVisits($param)
	{
		$DB = $this->dbConnect();

		switch($param)
		{
			case 'list':
				$QUERY = $DB->query('SELECT ipAddr, MAX(dateVisit) AS lastVisit, COUNT(view) AS totalViews FROM activ_ip GROUP BY ipAddr ORDER BY lastVisit DESC');
				return $QUERY;
			break;

			case 'total':
				$QUERY = $DB->query('SELECT Id, COUNT(ipAddr) AS totalIp FROM activ_ip GROUP BY Id');
				$TOTAL = $QUERY->fetch()['totalIp'];

				return $TOTAL;
			break;
		}
	}

	function getDatesByIP($ipAddr)
	{
		$DB = $this->dbConnect();
		$QUERY = $DB->prepare('SELECT dateVisit, COUNT(view) AS viewsDate FROM activ_ip WHERE ipAddr = ? GROUP BY dateVisit DESC');

		if ($this->dbExist($QUERY, $ipAddr))
		{
			$QUERY->execute(array($ipAddr));
			return $QUERY;
		}
		else
		{
			throw new Exception('L\'adresse IP est introuvable.');
		}
	}

	function getDetailsByDate($ipAddr, $date)
	{
		$DB = $this->dbConnect();

		//$CHECKIP = $DB->prepare('SELECT * FROM activ_ip WHERE ipAddr = ?');
		//$CHECKDATE = $DB->prepare('SELECT * FROM activ_ip WHERE ipAddr = ?');

		$QUERY = $DB->prepare('SELECT * FROM activ_ip WHERE ipAddr = ? AND dateVisit = ? ORDER BY timeVisit DESC');

		/*if ($this->dbExist($QUERY, "$ipAddr, $date"))
		{*/
			$QUERY->execute(array($ipAddr, $date));
			return $QUERY;
		/*}
		else
		{
			throw new Exception('Adresse IP ou date de visite introuvable.');
		}*/
	}
}