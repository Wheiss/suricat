<?php

/*
*	Класс отвечающий за конфигурацию
*/

class Config {

	//	параметры базы данных

	public static $db_params = array(
	'host' => 'localhost',
	'dbname' => 'suricat_db',
	'user' => 'root',
	'password' => '',
	);

	//	Массив путей в формате: 
	// 'URI' => 'контроллер/метод контроллера'

	public static $routes = array(	
	'num' => 'num/index', //actionIndex in SiteController
	'main' => 'num/index', //actionIndex in SiteController
    'site' => 'num/index', //actionIndex in SiteController
    'index' => 'num/index', //actionIndex in SiteController
    'auth' => 'authentication/sign_in', 
    'sign-in' => 'authentication/sign_in', 
	'sign-up' => 'registration/sign_up',
	'log-out' => 'Logout/log_out',
    '^$' => 'num/index', //actionIndex in SiteController
    '.+' => 'notfound/error', //actionError in NotfoundController
	);

	//	локальный ключ
	public static $local_key = 'itsaneasypepper';	//	15 символов

	//	названия месяцов на русском
	public static $months = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');

}
