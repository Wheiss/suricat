<?php

class NumController
{
	public function actionIndex()
	{
		//	Используем /components/Authorisator.php
		if (isset($_SESSION['user_id'])) {
			$number = new Num($_SESSION['user_id']);

			//	Если мы нажали на +1
			if(!empty($_POST['plusplus'])) {
				$number->numPlus();
				header('Location: /main');
				die;
			}
			$num = $number->getNum();
			require_once(ROOT.'/views/num/index.php');
		}
		else {
			header('Location: /auth');
			die;
		}

		return true;
	}
}