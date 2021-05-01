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