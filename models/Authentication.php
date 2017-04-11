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
	private $password;

	public function __construct($login = '', $password = '', &$error_array)
	{
		$this->login = $login;
		$this->password = $password;

	}

	/*
	*	Функция для проверки существования логина
	*/
	public static function authCheckToken($id, $token_hash, &$error_array)
	{		
		//	В этом блоке достаем токен и время его создания
		try {
		$db = Db::GetConnection();
		$query = 'SELECT token,token_time FROM users WHERE id=:id';
		$query = $db->prepare($query);
		$query->bindParam('id', $id);
		$query->execute();
		$result = $query->fetchAll();
		$db_token = $result[0]['token'];

		//	Вытаскиваем время создания токена из БД
		$token_time = new DateTime($result[0]['token_time']);

		//	Вычисляем, когда кончается срок годности токена
		$token_time = $token_time->add(new DateInterval('PT1H'));
		} catch (PDOException $e) {
			echo 'Ошибка базы данных';
		}

		$current_time = new DateTime();

		//	Если токен совпадает и срок его годности не подошел к концу - записываем ID в сессию
		if(password_verify($db_token, $token_hash) && ($current_time<$token_time)) {
			$_SESSION['user_id'] = $id;
			return true;
		}
		else {
			$error_array['false_cookies'] = 'Ложные куки';
			return false;
		}
	}

	/*
	*	Функция для проверки соответствия пароля логину
	*/
	public function authCheck(&$error_array)
	{
		try {
			$db = Db::GetConnection();
			$query = 'SELECT id, password FROM users WHERE login = ?';
			$query = $db->prepare($query);
			$query->bindParam(1, $this->login, PDO::PARAM_STR, 36);
			$query->execute();
			$result = $query->fetchAll();
            $id = $result[0]['id'];
            $pass_hash = $result[0]['password'];
            
		} catch (PDOException $e) {
			echo 'Ошибка базы данных';
		}

		if($id && $pass_hash) {
			if (password_verify( $this->password, $pass_hash)) {

				//	В случае успеха запишем id в сессию и печеньки
				$_SESSION['user_id'] = $id;

				//	Если запоминаем пользователя:
				if(isset($_POST['remember']) && ($_POST['remember'] == true)){

					//	В этой куке будем хранить id
					setcookie('kwo', $id, time()+3600, "", "", false, true);

					$token = random_bytes(12);
					try{
						//	Запись токена в БД
						$query = 'UPDATE users SET token=:token,token_time=:token_time WHERE id=:id';
						$query = $db->prepare($query);
						$query->bindParam(':token', $token);
						$token_time = new DateTime();
						$token_time = $token_time->format('Y-m-d H:i:s');
						$query->bindParam(':token_time', $token_time);
						$query->bindParam(':id', $id);
						$query->execute();
					} catch (PDOException $e) {
						echo 'Ошибка базы данных';
					}
					//	А в этой хеш токена
					$hashed_token = password_hash($token, PASSWORD_DEFAULT);
					setcookie('kwe', $hashed_token, time()+3600, "", "", false, true);

				}
				return true;
			}
			else {
				$error_array['password_error'] = 'Пароль не соответсует логину';
				return false;
			}
		}
		else {
			$error_array['login_error'] = 'Такой логин не зарегистрирован';
			return false;
		}
		
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