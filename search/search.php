<?php 
	$data = $_REQUEST;



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


/*




























	if(isset($data['do_search'])){
		$strSearch = trim($data['search']);
		$strSearch = htmlspecialchars($strSearch);

		$isEmptySearch = empty($strSearch);
		//разбиваю запрос на отдельные слова
		$arrStr = explode(' ',$strSearch);

		//формирую запрос к бд
		foreach($arrStr as $k =>  $v){
			if(isset($arrStr[$k-1])){				
				$str .= ' OR';
			}
			$str .= "  login LIKE '%".$v."%'";
		}
		$sql = "SELECT id FROM user WHERE ".$str;

		//устанавлюваю соединение с БД
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}

		//выполняю запрос к БД
		$result_query = $conn->query($sql);
		$conn->close();

		//обрабатываю полученные данные
		$result_num_rows = $result_query->num_rows;
		if($result_num_rows>0){
			//нужно создать массив с айдишниками вернувшихся строк
			$arrUsers = [];
			require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
			$conn = new mysqli(HOST,USER,PASSWORD,BD);
			if($conn->connect_error){
				die("<b>подключение не удалось:</b>".$conn->connect_error);
			}
			if($result_query = $conn->query($sql)){
				while($row = $result_query->fetch_assoc()){
					$arrUsers[] = $row['id'];
				}
			}			
		}else{
			//ничего не найдено
			$messeg = "ничего не найдено";
		}
		if(empty($strSearch)){
			$messeg = "ничего не найдено";			
		}
	}
	*/