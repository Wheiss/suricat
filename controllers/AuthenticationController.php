<?php

class AuthenticationController
{
	
	public function actionSign_in()
	{
		$authentication_errors = [];

		//	Используем /components/Authorisator.php
		if(Authorisator::authorise($authentication_errors)) {
			header('Location: /main');
			die;
		}

		require_once(ROOT.'/views/authentication/sign-in.php');
		return true;
	}
	
}