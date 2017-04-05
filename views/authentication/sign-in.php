<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title>Аутентификация</title>
	<link rel="stylesheet" type="text/css" href="/views/css/main.css">
</head>
<body>
	<form action="/auth" method="post" class="auth-form">
	<table>
		<tr>
		<td><p>Ваш логин:</p></td>
		<td><input type="text" name="login" value="<?=htmlspecialchars(@$_POST['login'])?>" /></td>
		</tr>
		<tr> </tr>
		<tr>
		<td><p>Пароль:</p></td>
		<td><input type="password" name="password" value="<?=htmlspecialchars(@$_POST['password'])?>" /></td>
		</tr>
		<tr> </tr>
		<tr>
			<td colspan="2"><?php 
			if(!empty($authentication_errors)) {
				foreach ($authentication_errors as $name => $text) {
					echo "<p class='error'>$text</p>";
				}
			}?>
			</td>
		</tr>
		<tr>
		<td><input type="submit" value="Войти" /></td>
		<td><button form="redirect" onClick='location.href="/sign-up"' id="right-btn">Зарегистрироваться</button></td>
		</tr>
	</table>
	</form>
</body>
</html>