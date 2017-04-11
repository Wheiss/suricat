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
	private $birth;
	public function __construct($login, $password1, $birth_day, $birth_month, $birth_year)
	{
		$this->login = $login;
		$this->password1 = $password1;
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


	private function dateCorrect( DateTime $date, &$registration_errors)
	{
			//	 Проверяем дату рождения 	
			$now = new DateTime();
			$diff = $date->diff($now);
			//	 Если Дата рождения > 150 лет назад ошибка TOO OLD
			if($diff->y > 150) {
				$registration_errors['date_error'] = 'TOO OLD.';
				return false;
			}
			//	 Если Дата рождения < 5 лет назад ошибка TOO YOUNG
			elseif ($diff->y < 5) {
				$registration_errors['date_error'] = 'TOO YOUNG.';
				return false;
			}
			return true;
	}

	/*
	*	Проверка всех полей
	*/
	public function checkFields(&$registration_errors)
	{
		//	Выполняем все вышеописанные проверки
		Registration::checkFieldsFill($this->login, $registration_errors);		
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

	public function writeAndLogIn(&$registration_errors)
	{
		try{
			$db = Db::GetConnection();
			$query = "INSERT INTO users (login, password, birth_date) VALUES (:login, :password, :birth_date)";
			//	Подготавливаем запрос. В документации написано, что этот метод защищает от SQL-инъекций
			$query = $db->prepare($query);
			$query->bindParam(':login', $this->login);

			//	Хешируем пароль, приправленный локальным параметром
			$hash = password_hash ($this->password1, PASSWORD_DEFAULT);
			$query->bindParam(':password', $hash);

			//	Переводим дату рождения в строку
			$birth_date = $this->birth->format('Y-m-d');
			$query->bindParam(':birth_date', $birth_date);
			
			if($query->execute()) {

				//	Если запись прошла успешно, запишем в сессию ID пользователя
				$data = "SELECT id FROM users WHERE login = :login";
				$data = $db->prepare($data);
                $login = $this->login;
				$data->bindParam(':login', $login);
				$data->execute();

				$id = $data->fetchAll()[0]['id'];

				//	Очищаем данные сессии
				$_SESSION = [];
				//	Удаляем куки сессии
				if (ini_get("session.use_cookies")) {
		            $params = session_get_cookie_params();
		            setcookie('kwo');
		            setcookie('kwe');
		        }
				//	Уничтожаем хранилище сессии
				session_destroy();
				
				$_SESSION['user_id'] = $id;
				
				return true;
			}
			else
			{
				$registration_errors['login_error'] = 'Данный логин уже зарегистрирован';
				return false;
			}
		} catch (PDOException $e) {
			echo 'Ошибка базы данных';
		}
	}

}