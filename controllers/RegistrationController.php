<?php
class RegistrationController
{
	public function actionSign_up()
	{
		//	Перенаправление в аутентификацию, если в сессии или кукисах задан пользователь
		if(isset($_SESSION['user_id'])) {
			header('Location: /num');
			die;
		}
		//	Если у пользователя заданы куки - перенаправим его в авторизацию
		if( !empty($_COOKIE['kwe']) && !empty($_COOKIE['kwo']) ) {
			header('Location: /auth');
			die;
		}

		//	Массив для хранения ошибок регистрации
		$registration_errors =[];

		if(!empty($_POST)) {
			$registration = new Registration($_POST['login'], $_POST['password'], $_POST['birth_day'], $_POST['birth_month'], $_POST['birth_year']);

			if ($registration->checkFields($registration_errors) && $registration->writeAndLogIn($registration_errors)) {
				header('Location: /num');
				die;
			}
		}
		
		require_once(ROOT.'/views/registration/sign-up.php');
		return true;
	}
}