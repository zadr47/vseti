<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/ever/function.php');

/*****************************************************************************************************************************/
/*****************************************************************************************************************************/
/*************                                                                                             *******************/
/*************                                                                                             *******************/
/*************                		                 КЛАССЫ РЕГИСТРАЦИИ                                    *******************/
/*************                                                                                             *******************/
/*************                                                                                             *******************/
/*****************************************************************************************************************************/
/*****************************************************************************************************************************/

class user_reg{
	private 	$id;
	private 	$login;
	private 	$password;
	private 	$linck;
	private 	$reg_data;

	public function __construct($login, $password){
		
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');

		$sql = 'SELECT max(id) FROM user;';

		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$conn->close();
		$result_fetch_array = $result_query->fetch_array();
		//$id = $result_fetch_array['max(id)']+1;
		$this->id = $result_fetch_array['max(id)']+1;
		$this->login = trim($login);
		$this->password = md5($password);
		$this->reg_data = time();
		$this->linck = '/users.php?id='.$this->id;
	}
	public function isUser($login){
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$sql = "SELECT * FROM user WHERE login ='".$login."'";
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
	public function __destruct(){
		//echo "был вызван диструктор";
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');

		$sql = "INSERT INTO user (id, login, password, linck, reg_data) VALUES (
		".$this->id.",
		'".$this->login."',
		'".$this->password."',
		'".$this->linck."',
		".$this->reg_data.");";

		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$conn->query($sql);
		$conn->close();
	}
}




class user_auto{
	private $login;
	private $password;

	public function __construct($login,$password){
		$this->login = $login;
		$this->password = $password;
	}

	public function isLogin(){
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$sql = "SELECT * FROM user WHERE login ='".$this->login."'";
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

	public function isTruePassword($password){
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$sql = "SELECT password FROM user WHERE login ='".$this->login."'";
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$conn->close();
		$result_fetch_array = $result_query->fetch_array();
		if($result_fetch_array['password']==md5($password)){
			return true;
		}else{
			return false;
		}
	}
}






class user_get{
	private		$id;
	private 	$login;
	private 	$password;
	private 	$avatar;
	private 	$linck;
	private 	$reg_data;

	public function __construct($id){

		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');

		$sql = 'SELECT * FROM user WHERE id = '.$id;

		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$conn->close();
		$result_fetch_array = $result_query->fetch_array();
		$this->id = $result_fetch_array['id'];
		$this->login = $result_fetch_array['login'];
		$this->password = $result_fetch_array['password'];
		$this->avatar = $result_fetch_array['avatar'];
		$this->reg_data = $result_fetch_array['reg_data'];
		$this->linck = $result_fetch_array['linck'];
	}
	public function add_avatar($avatar){
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/img')){
			mkdir($_SERVER['DOCUMENT_ROOT'].'/img');
		}
		if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/img/user'.$this->id)){
			mkdir($_SERVER['DOCUMENT_ROOT'].'/img/user'.$this->id);
		}
		$this->avatar = '/img/user'.$this->id.'/img'.$this->id.'.jpg';
		move_uploaded_file($avatar['tmp_name'],$_SERVER['DOCUMENT_ROOT'].'/'.$this->avatar);
		$sql = "UPDATE user SET avatar = '".$this->avatar."' WHERE id = ".$this->id;
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connewct_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$conn->query($sql);
		$conn->close();
	}
	public function get_avatar(){
		return $this->avatar;
	}
	public function __toString(){
		return '<b>'.$this->login.'</b> - '.$this->id;
	}
	public function get_linck(){
		return $this->linck;
	}
	public function get_login(){
		return $this->login;
	}
	public function get_id_by_login($login){
		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$sql = "SELECT id FROM user WHERE login ='".$login."'";
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$conn->close();
		$result_fetch_array = $result_query->fetch_array();
		return $result_fetch_array['id'];
	}
}


/*****************************************************************************************************************************/
/*****************************************************************************************************************************/
/*************                                                                                             *******************/
/*************                                                                                             *******************/
/*************                		           КЛАСС ДЛЯ ПЕРВОГО ВХОДА  	                               *******************/
/*************                                                                                             *******************/
/*************                                                                                             *******************/
/*****************************************************************************************************************************/
/*****************************************************************************************************************************/

class data_user_get extends user_get{
	private 		$id;
	private 		$name;
	private			$surname;
	private 		$gender;
	private			$life_city;
	private			$birthday;

	public function __construct($id){
		parent::__construct($id);

		$sql = "SELECT * FROM datauser WHERE id =".$id;

		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}

		$result_query = $conn->query($sql);
		$conn->close();

		$result_fetch_array = $result_query->fetch_array();

		$this->id = $id;
		$this->name = $result_fetch_array['name'];
		$this->surname = $result_fetch_array['surname'];
		$this->gender = $result_fetch_array['gender'];
		$this->life_city = $result_fetch_array['life_city'];
		$this->birthday = $result_fetch_array['birthday'];
	}

	public function update_name($name){

		$sql = "UPDATE datauser SET name=['".$name."'] WHERE id =".$this->id;

		require_once($_SERVER['DOCUMENT_ROOT'].'ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}

		$conn->query($sql);
		$conn->close();
	}

	public function update_surname($surname){

		$sql = "UPDATE datauser SET surname=['".$surname."'] WHERE id =".$this->id;

		require_once($_SERVER['DOCUMENT_ROOT'].'ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}

		$conn->query($sql);
		$conn->close();
	}
	public function update_birthday($birthday){

		$sql = "UPDATE datauser SET birthday=['".$birthday."'] WHERE id =".$this->id;

		require_once($_SERVER['DOCUMENT_ROOT'].'ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}

		$conn->query($sql);
		$conn->close();
	}
	public function update_life_city($life_city){

		$sql = "UPDATE datauser SET life_city=['".$life_city."'] WHERE id =".$this->id;

		require_once($_SERVER['DOCUMENT_ROOT'].'ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}

		$conn->query($sql);
		$conn->close();
	}
	public function update_gender($gender){

		$sql = "UPDATE datauser SET gender=['".$gender."'] WHERE id =".$this->id;

		require_once($_SERVER['DOCUMENT_ROOT'].'ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}

		$conn->query($sql);
		$conn->close();
	}
	public function get_id(){
		return $this->id;
	}
	public function get_name(){
		return $this->name;
	}
	public function get_surname(){
		return $this->surname;
	}
	public function get_birthday(){
		return $this->birthday;
	}
	public function get_life_city(){
		return $this->life_city;
	}
	public function get_gender(){
		return $this->gender;
	}

	public function add_friend(data_user_get $user){
		$sql = "SELECT * FROM friends WHERE 
					id=".$this->id." AND fid=".$user->id." OR 
					fid=".$this->id." AND id=".$user->id;

		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}

		$result_query = $conn->query($sql);
		if($result_query->num_rows > 0){
			//мне нужно узнать в какой калонке находится id а в какой fid
			// как это сделать 
			// нужно сделать запрос на то где точно указаны калонка и её данные 
			// если возвращает больше 0 стро то это верно если возвращает 0 то это не верно 
			$sql = "SELECT * FROM friends WHERE id=".$this->id." AND fid=".$user->id;
			$result_query = $conn->query($sql);
			if($result_query->num_rows > 0){
				$sql =	"UPDATE friends set am_i_friend=1 WHERE id=".$this->id." AND fid=".$user->id;
			}else{
				$sql =	"UPDATE friends set is_he_friend=1 WHERE fid=".$this->id." AND id=".$user->id;				
			}				
		}else{
			$sql = "INSERT into friends (id,fid,am_i_friend,is_he_friend) 
				VALUES(".$this->id.",".$user->id.",1,0)";			
		}

		$conn->query($sql);
		$conn->close();
	}

	public function del_friend(data_user_get $user){

		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}

		$sql = "SELECT * FROM friends WHERE id= ".$this->id." AND fid=".$user->id;		
		$result_query = $conn->query($sql);
		if($result_query->num_rows > 0){
			$sql = "UPDATE friends SET am_i_friend = 0  WHERE id = ".$this->id." AND fid = ".$user->id.";";
		}else{
			$sql = "UPDATE friends SET is_he_friend = 0  WHERE fid = ".$this->id." AND id = ".$user->id.";";
		}
		$conn->query($sql);
		$conn->close();
	}

	public function __destruct(){

		$sql = "UPDATE datauser SET 
				name='".$this->name."',
				surname='".$this->surname."',
				gender='".$this->gender."',
				life_city='".$this->life_city."',
				birthday=".$this->birthday."
			WHERE id = ".$this->id;

		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error);
		}
		$result_query = $conn->query($sql);
		$conn->close();
	}
}

class data_user_reg	{
	private 		$id;
	private 		$name;
	private			$surname;
	private 		$gender;
	private			$life_city;
	private			$birthday;

	public function __construct($id,$name,$surname){
		$this->id = $id;
		$this->name = $name;
		$this->surname = $surname;
		$this->gender = NULL;
		$this->life_city = NULL;
		$this->birthday = NULL;
	}
	public function bring_gender($gender){
		$this->gender = $gender;
	}
	public function bring_life_city($life_city){
		$this->life_city = $life_city;
	}
	public function bring_birthday($birthday){
		$this->birthday = $birthday;
	}
	public function is_id_in_datauser($id){

		$sql = "SELECT * FROM datauser WHERE id =".$id;

		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error());
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

	public function __destruct(){

		$sql = "INSERT into datauser (id,name,surname,gender,life_city,birthday) VALUES (
			".$this->id.",
			'".$this->name."',
			'".$this->surname."',
			'".$this->gender."',
			'".$this->life_city."',
			".$this->birthday."
			)";

		require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
		$conn = new mysqli(HOST,USER,PASSWORD,BD);
		if($conn->connect_error){
			die("<b>подключение не удалось:</b>".$conn->connect_error());
		}
		$conn->query($sql);
		$conn->close();
	}
}



















/*****************************************************************************************************************************/
/*****************************************************************************************************************************/
/*************                                                                                             *******************/
/*************                                                                                             *******************/
/*************                		      КЛАССЫ КОТОРЫЕ НЕ ИСПОЛЬЗУЮТЬСЯ СКРИПТЕ	                       *******************/
/*************                                                                                             *******************/
/*************                                                                                             *******************/
/*****************************************************************************************************************************/
/*****************************************************************************************************************************/
	/*		ЭТОТ КЛАСС ИСПОЛЬЗУЕТСЯ ПРИ НАЧАЛЬНОЙ РАБОТЕ С ПОЛЬЗОВАТЕЛЕМ (регистрации авторизации)
			для того что бы зарегистрировать пользователя передайте в конструктор $login и $password
			для того чтобы достать пользователя из БД передайте в конструктор $login
			МЕТОДЫ:
			issetUser($login) - возвращает true если пользователь с таким логином существует и наоборот
	*/
/*
	class user_id{
		public 	  $user_id_id;
		public 	  $login;
		protected $password;
		protected $reg_data;

		public function __construct($login, $password = NULL){
			if(user_id::issetUser($login)){
				//достать из бд
				require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');

				$sql = "SELECT * FROM userid WHERE login = '".$login."'";

				$conn = new mysqli(HOST,USER,PASSWORD,BD);
				if($conn->connect_error){
					die("<b>подключение не удалось:</b>".$conn->connect_error);
				}
				$result_query = $conn->query($sql);
				$conn->close();

				$result_fetch_array = $result_query->fetch_array();

				$this->user_id_id = $result_fetch_array['id'];
				$this->login = $result_fetch_array['login'];
				$this->password = $result_fetch_array['password'];
				$this->reg_data = $result_fetch_array['reg_data'];
			}else{
				//хз чё делать но надеюсь в таком случаее пароль указан
				if($password === NULL){
					die('неправильная работа с классом необходимо в параметрах передать "password"');
				}

				require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');

				$sql = 'SELECT max(id) FROM userid;';

				$conn = new mysqli(HOST,USER,PASSWORD,BD);
				if($conn->connect_error){
					die("<b>подключение не удалось:</b>".$conn->connect_error);
				}
				$result_query = $conn->query($sql);
				$conn->close();
				$result_fetch_array = $result_query->fetch_array();
				$id = $result_fetch_array['max(id)']+1;
				$this->user_id_id = $id;
				$this->login = trim($login);
				$this->password = $password;
				$this->reg_data = time();
			}
		}
		public function issetUser($login){
			require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
			$sql = "SELECT * FROM userid WHERE login ='".$login."'";
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
		public function __destruct(){
			require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
			$sql = "INSERT INTO userid (id, login, password, reg_data) VALUES (".$this->user_id_id.",'".$this->login."','".$this->password."',".$this->reg_data.");";
			$conn = new mysqli(HOST,USER,PASSWORD,BD);
			if($conn->connect_error){
				die("<b>подключение не удалось:</b>".$conn->connect_error);
			}
			$conn->query($sql);
			$conn->close();
		}
	}

	class data_user extends user_id{
		private $data_user_id;
		private $name;
		private $surname;
		private $gender;
		private $avatar;
		public function __construct(user_id $user){
			parent::__construct($user->login);
			if($this->isset_this_user_in_datauser($user->user_id_id)){
				require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
				$sql = "SELECT * FROM datauser WHERE id = ".$this->user_id_id.";";
				$conn = new mysqli(HOST,USER,PASSWORD,BD);
				if($conn->connect_error){
					die("<b>подключение не удалось:</b>".$conn->connect_error);
				}
				$result_query = $conn->query($sql);
				$conn->close();
				$result_fetch_array = $result_query->fetch_array();
				$this->name = $result_fetch_array['name'];
				$this->surname = $result_fetch_array['surname'];
				$this->gender = $result_fetch_array['gender'];
				$this->avatar = $result_fetch_array['avatar'];
			}
			$this->data_user_id = $this->user_id_id;
		}
		public function put_user($name,$surname,$gender){
			$this->name = $name;
			$this->surname = $surname;
			$this->gender = $gender;
			require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
			$sql = "INSERT INTO datauser (id, name, surname, gender) VALUES (".$this->data_user_id.",'".$name."','".$surname."','".$gender."');";;
			$conn = new mysqli(HOST,USER,PASSWORD,BD);
			if($conn->connect_error){
				die("<b>подключение не удалось:</b>".$conn->connect_error);
			}
			$result_query = $conn->query($sql);
			$conn->close();
		}
		public function isset_this_user_in_datauser($id){
			//существует ли в таблице login переданный в параметрах
			//возвращает true или false
			require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
			$sql = "SELECT * FROM datauser WHERE id = ".$id.";";
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
		public function print_name(){	
			return $this->name.' '.$this->surname;
		}

		public function put_pfoto($avatar,$id){	
			$this->avatar = $avatar;		
			require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
			$sql = "UPDATE datauser SET avatat ='".$avatar."' WHERE id = ".$id;
			$conn = new mysqli(HOST,USER,PASSWORD,BD);
			if($conn->connect_error){
				die("<b>подключение не удалось:</b>".$conn->connect_error);
			}
			$result_query = $conn->query($sql);
			$conn->close();
		}

		public function print_pfoto(){
			return "<img src='".$this->avatar."' width = '100px', height = '100'>";
		}
		
		public function __destruct(){
			//занести все в бд
			require_once($_SERVER['DOCUMENT_ROOT'].'/ever/conn.php');
			$sql = "INSERT INTO datauser (id, name, surname, gender, avatar) VALUES (".$this->data_user_id.",'".$this->name."','".$this->surname."','".$this->gender."','".$this->avatar."');";
			$conn = new mysqli(HOST,USER,PASSWORD,BD);
			if($conn->connect_error){
				die("<b>подключение не удалось:</b>".$conn->connect_error);
			}
			$result_query = $conn->query($sql);
			$conn->close();
		}
	}

*/

/*
	CREATE TABLE `vseti`.`userid` ( `id` INT(11) NOT NULL , `login` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `password` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `reg_data` INT(11) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`login`)) ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_general_ci;
*/
/*
INSERT INTO userid (id, login, password, reg_data) VALUES (1,'misha','123',313131);

*/

/*CREATE TABLE `vseti`.`datauser` ( `id` INT(11) NOT NULL , `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `surname` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `gender` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `avatat` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_general_ci;*/