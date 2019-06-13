<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/function.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/class.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/session.php');


	$data = $_REQUEST;	
	$_SESSION['id_user_linck'] = $data['id'];
	$id_user_linck = (int)$_SESSION['id_user_linck'];

	$id_user_session = (int)user_get::get_id_by_login($_SESSION['connection']);

	$user_session = new data_user_get($id_user_session);

	$user_linck = new data_user_get($id_user_linck);


	echo "<a href='index.php'>моя страница</a>";
	echo "<br />";
	echo "<b>".$user_linck->get_name().' '.$user_linck->get_surname()."</b>";
	echo "<br />";
	echo "<img src='".$user_linck->get_avatar()."' width='200px'>";



	//нужно вывести кнопку в зависимости оношения авторизированого пользователя к пользователю по ссылке
	$sql = "SELECT * FROM friends WHERE 
			id =".$user_session->get_id()." AND fid = ".$user_linck->get_id()." OR 
			fid =".$user_session->get_id()." AND id = ".$user_linck->get_id();

	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
	$conn = new mysqli(HOST,USER,PASSWORD,BD);
	if($conn->connect_error){
		die("<b>подключение не удалось:</b>".$conn->connect_error);
	}
	$result_query = $conn->query($sql);
	$conn->close();
	$result_fetch_assoc = $result_query->fetch_assoc();

	if($result_query->num_rows > 0){

		$sql = "SELECT * FROM friends WHERE id=".$id_user_session." AND fid=".$id_user_linck;
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$conn->close();

		if($result_query->num_rows > 0){
			$am_i_friend = $result_fetch_assoc['am_i_friend'];
			$is_he_friend = $result_fetch_assoc['is_he_friend'];
		}else{
			$am_i_friend = $result_fetch_assoc['is_he_friend'];
			$is_he_friend = $result_fetch_assoc['am_i_friend'];
		}

		echo "<form action = 'users.php?id=".$id_user_linck."' method='POST'>";
		if($am_i_friend == true && $is_he_friend == true){
			//кнопка - удалить из друзей
			echo "<input type = 'submit' name = 'do_del_friend' value='удалить из друзей'>";
		}
		if($am_i_friend == false && $is_he_friend == false){
			//кнопка - добавить в друзья
			echo "<input type = 'submit' name = 'do_add_friend' value='добавить в друзья'>";
		}
		if($am_i_friend == true && $is_he_friend == false){
			//кнопка - отменить заявку
			echo "<input type = 'submit' name = 'do_del_friend' value='отменить заявку в друзья'>";
		}
		if($am_i_friend == false && $is_he_friend == true){
			//кнопка - принять заявку 
			echo "<input type = 'submit' name = 'do_add_friend' value='принять заявку в друзья'>";
		}
		echo "</form>";
	}else{
		echo "<form action = 'users.php?id=".$id_user_linck."' method='POST'>";
		
			echo "<input type = 'submit' name = 'do_add_friend' value='добавить в друзья'>";
		
		echo "</form>";
	}


	if(isset($data['do_add_friend'])){
		$user_session->add_friend($user_linck);
	}

	if(isset($data['do_del_friend'])){
		$user_session->del_friend($user_linck);
	}


























/*
	$sql = "SELECT * FROM friends WHERE id =".$user_session->get_id()."fid = ".$user_linck->get_id();
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
	$conn = new mysqli(HOST,USER,PASSWORD,BD);
	if($conn->connect_error){
		die("<b>подключение не удалось:</b>".$conn->connect_error);
	}

	$result = $conn->query($sql);
	$conn->close();


	$result_num_rows = $result_query->num_rows;

	if($result_num_rows > 0){
		$result_fetch_assoc = $result_query->fetch_assoc();

		$am_i_friend = $result_fetch_assoc['am_i_friend'];
		$is_he_friend = $result_fetch_assoc['is_he_friend'];

		if($am_i_friend == 1){
			$am_i_friend = true;
		}else{
			$am_i_friend = false;
		}
		if($is_he_friend == 1){
			$is_he_friend = true;
		}else{
			$is_he_friend = false;
		}

		if($is_he_friend && $am_i_friend){
			echo "<form action='users.php?id=".$id_user_linck."' method='POST'>
					<input type='submit' name='do_del_friends' value='удалить из друзей'>
			  	  </form>";
		}else if($am_i_friend == true && $is_he_friend == false){
			echo "<form action='users.php?id=".$id_user_linck."' method='POST'>
					<input type='submit' name='do_del_friends' value='отменить заявку'>
			  	  </form>";
		}else{
			echo "<form action='users.php?id=".$id_user_linck."' method='POST'>
				 	<input type='submit' name='do_add_friends' value='добавить в друзья'>
			  	  </form>";
		}	
	}else{
		echo "<form action='users.php?id=".$id_user_linck."' method='POST'>
			 	<input type='submit' name='do_add_friends' value='добавить в друзья'>
		  	  </form>";
	}



*/





