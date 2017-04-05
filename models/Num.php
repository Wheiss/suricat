<?php

/*
*	Класс для работы с нашим БОЛЬШИМ числом
*/

class Num
{
	private $user = '';
	private $num = 0;

	public function __construct($user)
	{
		// 1
		$this->user = $user;
		
		try {
			$db = Db::GetConnection();
			$query = "SELECT num FROM users WHERE login = '$user'";
			$query = $db->prepare($query);
			$query->execute();
		} catch (PDOException $e) {
			echo 'Ошибка базы данных';
		}
		$num = $query->fetch()['num'];

		// 2
		$this->num = $num;
	}
	public function getNum()
	{
		return $this->num;
	}
	
	/*
	*	Увеличиваем значение числа на 1
	*/

	public function numPlus()
	{
		try {
			$db = Db::GetConnection();
			$user = $this->user;
			//	Перед отправкой запроса увеличиваем наше число
			$num = ++$this->num;
			$query = "UPDATE users SET num = '$num' WHERE login = '$user'";
			$query = $db->prepare($query);
			$query->execute();
		} catch (PDOException $e) {
			echo 'Ошибка базы данных';
		}
	}
}