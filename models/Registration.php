<?php

/*
*	Данный класс отвечает за регистрацию
*	функция checkFields осуществляет весь функционал по проверке данных,
*	используя другие ,разделенные по обязанностям, функции.
*	Все функции возвращают true и false в случае успеха/неудачи
*/
Class Registration
{

	private $login = '';
	private $password1 = '';
	private $password2 = '';
	private $birth;
	public function __construct($login, $password1, $password2, $birth_day, $birth_month, $birth_year)
	{
		$this->login = $login;
		$this->password1 = $password1;
		$this->password2 = $password2;
		$this->birth = DateTime::createFromFormat('j n Y', $birth_day.' '.$birth_month.' '.$birth_year);
	}

	private function checkFieldsFill($login, &$registration_errors)
	{
		//	 Проверка наличия всех полей
		if( !empty($login)) {
				return true;
		}
		else {
			$registration_errors['fields_error'] = 'Не все поля заполнены.';
			return false;
		}		
	}

	private function loginExists($login, &$error_array)
	{
		try {
			$db = Db::GetConnection();
			$query = "SELECT login FROM users WHERE login = '$login'";
			$user = $db->prepare($query);
			$user->execute();
		} catch (PDOException $e) {
			echo 'Ошибка базы данных';
		}
		if($user->fetch())
		{
			$error_array['login_error'] = 'Такой логин уже зарегистрирован.';
			return false;
		} else
		{
			return true;
		}
	}

	private function passwordRepeats($password1, $password2, &$error_array)
	{
		//	 Проверяем, дублируется ли пароль
			if($password1 != $password2) {
				$error_array['password_error'] = 'Пароли не совпадают.';
				return false;
			}
			else
			{
				return true;
			}
	}

	private function dateCorrect( DateTime $date, &$registration_errors)
	{
			//	 Проверяем дату рождения 	
			$now = new DateTime();
			$diff = $date->diff($now);
			//	 Если Дата рождения > 150 лет назад ошибка TOO OLD
			if($diff->y > 150) {
				$registration_errors['date_error'] = 'TOO OLD.';
			}
			//	 Если Дата рождения < 5 лет назад ошибка TOO YOUNG
			elseif ($diff->y < 5) {
				$registration_errors['date_error'] = 'TOO YOUNG.';
			}
	}

	/*
	*	Проверка всех полей
	*/
	public function checkFields(&$registration_errors)
	{
		//	Выполняем все вышеописанные проверки
		Registration::checkFieldsFill($this->login, $registration_errors);		
		Registration::loginExists($this->login, $registration_errors);
		Registration::passwordRepeats($this->password1, $this->password2, $registration_errors);
		Registration::dateCorrect($this->birth, $registration_errors);
		if(!empty($registration_errors)) {
			return false;
		}
		else {
			return true;
		}
	}

	/*
	*	Записываем все данные, полученные в конструкторе в базу данных
	*/

	public function writeAndLogIn()
	{
		try{
			$db = Db::GetConnection();
			$query = "INSERT INTO users (login, password, birth_date) VALUES (:login, :password, :birth_date)";
			//	Подготавливаем запрос. В документации написано, что этот метод защищает от SQL-инъекций
			$query = $db->prepare($query);
			$query->bindParam(':login', $this->login);

			//	Хешируем пароль
			$hash = password_hash ($this->password1, PASSWORD_DEFAULT);
			$query->bindParam(':password', $hash);

			//	Переводим дату рождения в строку
			$birth_date = $this->birth->format('Y-m-d');
			$query->bindParam(':birth_date', $birth_date);
			if($query->execute()) {
				//	Записываем в сессию юзера с паролем
				$_SESSION['user'] = $this->login;
				$_SESSION['password'] = $this->password1;
				setcookie('user', $this->login, time()+3600, "", "", false, true);
				setcookie('password', $this->password1, time()+3600, "", "", false, true);

			}
		} catch (PDOException $e) {
			echo 'Ошибка базы данных';
		}
		
		return true;
	}
	public static function months()
	{
		//	вывод месяцев в <select>
		return array(Январь, Февраль, Март, Апрель, Май, Июнь, Июль, Август, Сентябрь, Октябрь, Ноябрь, Декабрь);
	}

}