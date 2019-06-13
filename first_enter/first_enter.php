<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/class.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/function.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/session.php');

	$data = $_REQUEST;
	$user = $_SESSION['connection'];
	if(isset($data['do_first_enter'])||isset($data['do_next'])){
		$errors = [];
		if(empty($data['name'])){
			$errors[] = 'укажите ваше имя';
		}
		if(empty($data['surname'])){
			$errors[] = 'укажите вышу фамилию';
		}
		if(empty($data['gender'])){
			$errors[] = 'укажите ваш пол';
		}
		if(empty($data['life_city'])){
			$errors[] = 'укажите ваш город';			
		}
		if(empty($data['birthday'])){
			$errors[] = 'укажите ваш день рожденья';			
		}
		if(!empty($errors)){
			echo $errors[0];
			require_once($_SERVER['DOCUMENT_ROOT'].'/first_enter/first_enter_struct.php');
		}else{
			//тут будет класс 
			$id = user_get::get_id_by_login($user);
			$dataUser = new data_user_reg($id,$data['name'],$data['surname']);
			$dataUser->bring_gender($data['gender']);
			$dataUser->bring_life_city($data['life_city']);
			$dataUser->bring_birthday($data['birthday']);
			header('location:/');
		}
	}else{
		require_once($_SERVER['DOCUMENT_ROOT'].'/first_enter/first_enter_struct.php');
	}

