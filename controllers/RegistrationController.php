<?php
class RegistrationController
{
	public function actionSign_up()
	{
		//	Перенаправление в аутентификацию, если в сессии или кукисах задан пользователь
		if(isset($_SESSION['user']) || isset($_COOKIE['user'])) {
			header('Location: /auth');
			die;
		}

		//	Массив для хранения ошибок регистрации
		$registration_errors =[];

		if(!empty($_POST)) {
			$registration = new Registration($_POST['login'], $_POST['password'], $_POST['password_confirm'], $_POST['birth_day'], $_POST['birth_month'], $_POST['birth_year']);

			if ($registration->checkFields($registration_errors)) {
				$registration->writeAndLogIn();
				header('Location: /sign-up');
				die;
			}
		}
		
		require_once(ROOT.'/views/registration/sign-up.php');
		return true;
	}
}