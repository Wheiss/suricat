<?php

/*
*	Класс для работы с нашим БОЛЬШИМ числом
*/

class Num
{
	private $user_id = '';
	private $num = 0;

	public function __construct($user_id)
	{
		// 1
		$this->user_id = $user_id;
		
		try {
			$db = Db::GetConnection();
			$query = "SELECT num FROM users WHERE id = :user_id";		
			$query = $db->prepare($query);
            $query->bindParam(':user_id', $user_id, PDO::PARAM_INT, 12);
			$query->execute();
			$num = $query->fetchAll()[0]['num'];
		} catch (PDOException $e) {
			echo 'Ошибка базы данных';
		}		
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
			$user_id = $this->user_id;
			//	Перед отправкой запроса увеличиваем наше число
			$num = ++$this->num;
			$query = "UPDATE users SET num = '$num' WHERE id = :user_id";
			$query = $db->prepare($query);
			$query->bindParam(':user_id', $user_id);
			$query->execute();
		} catch (PDOException $e) {
			echo 'Ошибка базы данных';
		}
	}
}