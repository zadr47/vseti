<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/function.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/class.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/session.php');
	//добавить поиск пользователей
	//добавить диалоги

	//получаем из логина в ссесии айди
	$id = user_get::get_id_by_login($_SESSION['connection']);

	$data = $_REQUEST;

	if(data_user_reg::is_id_in_datauser($id)){
		$user = new user_get($id);
		require_once($_SERVER['DOCUMENT_ROOT'].'/vseti/vseti_html.php');
		echo "<hr />";
		if(isset($data['do_avatar'])){
			$user->add_avatar($_FILES['avatar']);
			unset($data['do_avatar']);
			unset($data['avatar']);
		}	
		if(isset($data['do_search'])){
			if(!empty($data['search'])){

				$arrID = search($data['search']);
				if(empty($arrID)){
					echo "результаты поиска...";
				}else{
					if(is_int($arrID)){
						$userSearch = new data_user_get($arrID);
						echo "<a href='".$userSearch->get_linck()."' width='50px'>
								<img src='".$userSearch->get_avatar()."' width='50px'>
						  		<b>".$userSearch->get_name().' '.$userSearch->get_surname()."</b>
						  	  </a>";
					}else{
						foreach ($arrID as $v) {
							$userSearch = new data_user_get($v);
							echo "<a href='".$userSearch->get_linck()."' width='50px'>
									<img src='".$userSearch->get_avatar()."' width='50px'>
							  		<b>".$userSearch->get_name().' '.$userSearch->get_surname()."</b>
							  	  </a>";
							echo "<br />";
						}
					}
					unset($arrID);
					unset($data['do_search']);
					unset($data['search']);
				}
			
			}
		}

		echo "<hr />";
	
	}else{
		require_once($_SERVER['DOCUMENT_ROOT'].'/first_enter/first_enter.php');
	}

























	/*
	$data = $_REQUEST;
	if(!data_user::isset_this_user_in_datauser($_SESSION['connection']->user_id_id)){
			require_once($_SERVER['DOCUMENT_ROOT'].'/first_enter/first_enter.php');			
		}else{
			require_once($_SERVER['DOCUMENT_ROOT'].'/vseti/vseti.php');			
					
			//добавить поиск пользователей
			//добавить диалоги
		//}
	if(!isset($data['do_search'])){
		require_once($_SERVER['DOCUMENT_ROOT'].'/vseti/vseti_html.php');
	}else{
		if(!empty($data['search'])){
			$str = trim($data['search']);

			preg_match('|(.+)\s(.+)|xsi',$str,$arr);
			$name = $arr[1];
			$surname = $arr[2];
			require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
			$sql = "SELECT * FROM `datauser` WHERE name='".$name."' and surname='".$surname."' LIMIT 1;";
			$conn = new mysqli(HOST,USER,PASSWORD,BD);
			if($conn->connect_error){
				die("<b>подключение не удалось:</b>".$conn->connect_error);
			}
			$result_query = $conn->query($sql);
			$conn->close();
			$result_num_rows = $result_query->num_rows;
			if($result_num_rows==0){
				echo "ничего не найдено";
			}else{
				$user = $result_query->fetch_array();
				$linck = "vseti/vseti/user/id".$user['id'].".php";
				echo "<img src='/".$user['avatat']."' width='50px'>";
				echo "<a href ='//".$linck."'>".$user['name'].' '.$user['surname']."</a>";
			}
		}
	}
	*/