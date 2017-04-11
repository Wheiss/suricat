<?php

class AuthenticationController
{
	
	public function actionSign_in()
	{
		$authentication_errors = [];
		if( !empty($_COOKIE['kwe']) && !empty($_COOKIE['kwo']) ) {
			//	Если куки актуальны записывает id в сессию
			Authentication::authCheckToken($_COOKIE['kwo'], $_COOKIE['kwe'], $authentication_errors);
		}

		//	Если в сессии уже записан ид переходим в /num
		if(isset($_SESSION['user_id'])) {
			header('Location: /num');
			die;
		}
		
		//	При поступлении login в POST проводим авторизацию
		if(!empty(($_POST['login']))) {
			$auth = new Authentication( $_POST['login'], $_POST['password'], $authentication_errors);
			if($auth->authCheck($authentication_errors)) {
				header('Location: /num');
				die;
			}		
		}
        require_once(ROOT.'/views/authentication/sign-in.php');
		return true;
	}
}