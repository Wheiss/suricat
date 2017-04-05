<?php
/*
*	Этот компонент проверяет, авторизован ли пользователь
*	Он использует модель Authentification
*/

class Authorisator
{
	public static function authorise(&$authentication_errors=[])
	{

		if(!empty($_SESSION['user'])) {
			$auth = new Authentication ( $_SESSION['user'], $_SESSION['password'], $authentication_errors);
			if($auth->checkFields($authentication_errors)) {
				return true;
			}
		}

		if(!empty($_COOKIE['user'])) {
			$auth = new Authentication ( $_COOKIE['user'], $_COOKIE['password'], $authentication_errors);
			if($auth->checkFields($authentication_errors)) {
				return true;
			}
		}
		if(!empty(($_POST))) {
			$auth = new Authentication( $_POST['login'], $_POST['password'], $authentication_errors);
			if($auth->checkFields($authentication_errors)) {
				return true;
			}
		}

		return false;
	}
	
}