<?php

function isValidToken($string)
{
	if ($string == $_SESSION['token'])
	{
		return true;
	}
	return false;
}