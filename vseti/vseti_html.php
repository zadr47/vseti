<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<p>вы авторизованы</p>
	<a href='/index.php'>моя страница</a><br />
	<a href='/my_friends/my_friends.php'>мои друзья</a><br />
	<a href='/ever/logout.php'>Выйти</a><br />
	<b><?= $user ?></b><br />
	<img src="<?= $user->get_avatar()?>" width='200px'>
	<form action="/vseti/vseti.php" method="POST" 	enctype="multipart/form-data">
		<input type="file" name="avatar">
		<input type="submit" name="do_avatar">
	</form>
	<form action="/vseti/vseti.php" method="POST">
		<input type="text" name="search" placeholder="найти пользователя">
		<input type="submit" name="do_search">
	</form>
</body>
</html>