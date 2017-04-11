<?php

class Db
{
	public static function getConnection()
	{
	
		$params = Config::$db_params;

		$dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
		$db = new PDO($dsn, $params['user'], $params['password']);

		return $db;
	}
}