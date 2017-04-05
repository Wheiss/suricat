<?php

/*
* Данный файл возвращает массив путей в формате: 
* 'URI' => 'контроллер/метод контроллера'
*/

return array(	
	'main' => 'num/index', //actionIndex in SiteController
    'site' => 'num/index', //actionIndex in SiteController
    'index' => 'num/index', //actionIndex in SiteController
    'auth' => 'authentication/sign_in', 
	'sign-up' => 'registration/sign_up',
	'log-out' => 'Logout/log_out',
    '^$' => 'num/index', //actionIndex in SiteController
    '.+' => 'notfound/error', //actionError in NotfoundController
);