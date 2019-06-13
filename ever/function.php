<?php 
	function damp($value,&$a = NULL){
		echo "<pre>";
		print_r($value);
		echo "</pre>";
		$a = "ничего не произошло";
	}
	function itis($value){
		if($value){
			echo "yes";
		}else{
			echo "no";
		}
	}

	function is_table_user(){
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/session.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$sql = "CREATE TABLE `".BD."`.`user` ( 
				`id` INT(11) NOT NULL , `login` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
				`password` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
				`linck` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , 
				`avatar` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , 
				`reg_data` INT(11) NOT NULL ,
				PRIMARY KEY (`id`), UNIQUE (`login`)) ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_general_ci;";
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$conn->close();
	}
	function is_table_datauser(){
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/session.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$sql = "CREATE TABLE `".BD."`.datauser ( `id` INT(11) NOT NULL , `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `surname` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `gender` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , `life_city` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL , `birthday` INT(11) NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_general_ci;";
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$conn->close();
	}
	function is_table_friends(){
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/session.php');
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$sql = "CREATE TABLE `".BD."`.`friends` ( `id` INT(11) NOT NULL , `fid` INT(11) NOT NULL , `am_i_friend` BOOLEAN NOT NULL , `is_he_friend` BOOLEAN NOT NULL ) ENGINE = MyISAM CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;";
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$conn->close();
	}

	function search($str){
		//обеспечиваю безопасность полученых данных
		$str = htmlspecialchars($str);
		$str = trim($str);

		//проверяю не пустая ли переменная
		if(empty($str)){
			return 1;
		}

		//разбиваю слова в запросе
		$arrStr = explode(' ',$str);

		//формирую sql запрос
		$sql = "SELECT id FROM datauser WHERE ";
		foreach ($arrStr as $k => $v) {
			if(!empty(trim($v))){

				if(isset($arrStr[$k - 1])){
					$sql .= ' OR ';
				}
				$sql .= "name LIKE '%".$v."%' OR surname LIKE '%".$v."%'";

			}
		}

		//подключаемся к БД и выполняем запрос
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error());
		}
		$result_query = $conn->query($sql);
		$conn->close();
		//проверить количество вернувшихся строк
		//если ноль и меньше - вернуть false
		if(($num = $result_query->num_rows) > 0){
			//создаю массив и в него заношу айди из каждой полученой строки
			while ($result_fetch_assoc = $result_query->fetch_assoc()) {
				$arrID[] = $result_fetch_assoc['id'];
			}
			return $arrID;
		}else{
			return 0;
		}
	}




	function search_friends($str,$id){
		//обеспечиваю безопасность полученых данных
		$str = htmlspecialchars($str);
		$str = trim($str);

		//проверяю не пустая ли переменная
		if(empty($str)){
			return 1;
		}

		//разбиваю слова в запросе
		$arrStr = explode(' ',$str);

		//формирую sql запрос
		$sql = "SELECT id FROM datauser WHERE ";
		foreach ($arrStr as $k => $v) {
			if(!empty(trim($v))){

				if(isset($arrStr[$k - 1])){
					$sql .= ' OR ';
				}
				$sql .= "name LIKE '%".$v."%' OR surname LIKE '%".$v."%'";

			}
		}

		//подключаемся к БД и выполняем запрос
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error());
		}
		$result_query = $conn->query($sql);
		$conn->close();
		//проверить количество вернувшихся строк
		//если ноль и меньше - вернуть false
		if(($num = $result_query->num_rows) > 0){
			//создаю массив и в него заношу айди из каждой полученой строки
			while ($result_fetch_assoc = $result_query->fetch_assoc()) {
				$arrID[] = $result_fetch_assoc['id'];
			}
			return $arrID;
		}else{
			return 0;
		}
	}

	function issetLogin($login){
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$sql = "SELECT id FROM userid WHERE login = '".$login."';";
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$conn->close();
		//$result_fetch_array = $result_query->fetch_array();
		$result_num_rows = $result_query->num_rows;
		if($result_num_rows>0){
			return true;
		}else{
			return false;
		}
	}
	function issetInBD($table,$value,$parametr = 'id'){
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$sql = "SELECT * FROM $table WHERE id = '".$value."';";
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$conn->close();
		$result_num_rows = $result_query->num_rows;
		if($result_num_rows>0){
			return true;
		}else{
			return false;
		}
	}
	function getInBD($what,$where,$value){
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$sql = "SELECT * FROM $where WHERE $what = ".$value;
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$conn->close();
		return $result_query->fetch_array();
	}

	function isset_bd_iserid(){
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$sql = "SHOW TABLES LIKE 'userid'";
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$result_num_rows = $result_query->num_rows;
		if($result_num_rows==0){
			$sql = "CREATE TABLE `vseti`.`userid` ( `id` INT(11) NOT NULL , `login` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `password` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `reg_data` INT(11) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`login`)) ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_general_ci;";
			$conn->query($sql);
		}
		$conn->close();
	}

	function isset_bd_datauser(){
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$sql = "SHOW TABLES LIKE 'userid'";
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$result_num_rows = $result_query->num_rows;
		if($result_num_rows==0){
			$sql = "CREATE TABLE `vseti`.`datauser` ( `id` INT(11) NOT NULL , `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `surname` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `patronymic` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `avatar` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL , `birthday` INT(11) NULL DEFAULT NULL , `lastonlaine` INT(11) NOT NULL , `born` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL , `statys` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_general_ci;";
			$conn->query($sql);
		}
		$conn->close();
	}
	function isset_in_datauser($login){
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$sql = "SELECT * FROM userid WHERE login = '".$login."';";
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$conn->close();
		$result_num_rows = $result_query->num_rows;
		if($result_num_rows==0){
			return false;
		}else{
			return true;
		}
	}