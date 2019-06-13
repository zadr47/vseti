<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>reg</title>
</head>
<body>
	<form action="reg.php" method="POST">	
		<input type="text" name="login" placeholder="придумайте логин" value = "<?php echo $_REQUEST['login'] ?>"><br />
		<input type="password" name="password1" placeholder="придумайте пароль" value = "<?php echo $_REQUEST['password1'] ?>">
		<br />
		<input type="password" name="password2" placeholder="подтвердите пароль" value = "<?php echo $_REQUEST['password2'] ?>">
		<br />
		<input type="submit" name="do_reg" value="зарегистрориваться">
	</form>
</body>
</html>