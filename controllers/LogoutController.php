<?php

class LogoutController
{
	
	public function actionLog_out()
	{
		//	Очищаем данные сессии
		$_SESSION = [];
		//	Удаляем куки сессии
		if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie('user');
            setcookie('password');
        }
		//	Уничтожаем хранилище сессии
		session_destroy();

		//	Переходим на страничку авторизации
		header('Location: /auth');
		die;
		return true;
	}
	
}