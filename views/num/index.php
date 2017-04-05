<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title>Большая цифра</title>
	<link rel="stylesheet" type="text/css" href="/views/css/main.css">
</head>
<body>
	<form action="/main" method="post" class="main-form">
	<table>
		<tr>
			<td colspan="2"><?="<p class='big_num'>".$num."</p>"?></td>
		</tr>
		<tr>
		<td><input type="submit" name="plusplus" value="+1" /></td>
		<td><button form="redirect" onClick='location.href="/log-out"' id="right-btn">Выйти</button></td>
		</tr>
	</table>
	</form>
</body>
</html>