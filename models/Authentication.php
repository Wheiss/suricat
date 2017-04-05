<?php

/*
*	Данный класс отвечает за аутентификацию(вход)
*	функция checkFields осуществляет весь функционал по проверке данных,
*	используя другие ,разделенные по обязанностям, функции.
*	Все функции возвращают true и false в случае успеха/неудачи
*/

class Authentication
{
	private $login;
	private $password_hash;

	public function __construct($login = '', $password = '', &$error_array)
	{
		$this->login = $login;
		$this->password_hash = $password;

	}

	/*
	*	Функция для проверки существования логина
	*/
	private function loginExists($login, &$error_array)
	{		
		try {
			$db = Db::GetConnection();
			$query = "SELECT * FROM users WHERE login = '$this->login'";
			$query = $db->prepare($query);
			$query->execute();
		} catch (PDOException $e) {
			echo 'Ошибка базы данных';
		}
		if($query->fetch())
		{
			return true;
		} else
		{
			$error_array['login_error'] = 'Такой логин не зарегистрирован';
			return false;
		}
	}

	/*
	*	Функция для проверки соответствия пароля логину
	*/
	private function passwordMatches($login, $password, &$error_array)
	{
		try {
			$db = Db::GetConnection();
			$query = "SELECT password FROM users WHERE login = '$login'";
			$query = $db->prepare($query);
			$query->execute();
		} catch (PDOException $e) {
			echo 'Ошибка базы данных';
		}
		$result = $query->fetch();
		$hash = $result['password'];
		if (password_verify( $password, $hash)) {

			//	В случае успеха запишем логин и пароль в сессию и печеньки
			$_SESSION['user'] = $login;
			$_SESSION['password'] = $password;
			setcookie('user', $login, time()+3600, "", "", false, true);
			setcookie('password', $password, time()+3600, "", "", false, true);

			return true;
		}
		else {
			$error_array['password_error'] = 'Пароль не соответсует логину';
			return false;
		}
	}

	public function logIn()
	{

	}
	public function checkFields(&$error_array)
	{
		//	Проверка существования логина
		if($this->loginExists($this->login, $error_array)) {
			//	Проверяем соответствие пароля
			$this->passwordMatches($this->login, $this->password_hash, $error_array);
			if(empty($error_array)) {
				return true;
			}
			else {
				return false;
			}
		}
	}
}