<?php
session_start();
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	/**
	 * Customer Login (login2)
	 * 
	 * Authenticates customer users from user_info table
	 * Uses bcrypt for password verification
	 * 
	 * @return int 1 on success, 3 on failure
	 */
	function login2(){
		extract($_POST);
		
		// Use prepared statement to prevent SQL injection
		$stmt = $this->db->prepare("SELECT * FROM user_info WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if($result->num_rows > 0){
			$user = $result->fetch_assoc();
			
			// Verify password using bcrypt
			// Check if password is MD5 (old) or bcrypt (new)
			if(strlen($user['password']) == 32){
				// Old MD5 password - check directly and upgrade
				if($user['password'] == md5($password)){
					// Update to bcrypt
					$new_hash = password_hash($password, PASSWORD_BCRYPT);
					$update = $this->db->prepare("UPDATE user_info SET password = ? WHERE user_id = ?");
					$update->bind_param("si", $new_hash, $user['user_id']);
					$update->execute();
					
					// Set session
					foreach ($user as $key => $value) {
						if($key != 'password' && !is_numeric($key))
							$_SESSION['login_'.$key] = $value;
					}
					
					// Update cart
					$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
					$this->db->query("UPDATE cart SET user_id = '".$_SESSION['login_user_id']."' WHERE client_ip ='$ip' ");
					
					return 1;
				}
			} else {
				// Bcrypt password - verify properly
				if(password_verify($password, $user['password'])){
					// Set session
					foreach ($user as $key => $value) {
						if($key != 'password' && !is_numeric($key))
							$_SESSION['login_'.$key] = $value;
					}
					
					// Update cart
					$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
					$this->db->query("UPDATE cart SET user_id = '".$_SESSION['login_user_id']."' WHERE client_ip ='$ip' ");
					
					return 1;
				}
			}
		}
		return 3;
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		$data .= ", type = '$type' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}
	function signup(){
		extract($_POST);
		$data = " first_name = '$first_name' ";
		$data .= ", last_name = '$last_name' ";
		$data .= ", mobile = '$mobile' ";
		$data .= ", address = '$address' ";
		$data .= ", email = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		$chk = $this->db->query("SELECT * FROM user_info where email = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO user_info set ".$data);
		if($save){
			$login = $this->login2();
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data." where id =".$chk->fetch_array()['id']);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	
	function save_category(){
		extract($_POST);
		$data = " name = '$name' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO category_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE category_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_category(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM category_list where id = ".$id);
		if($delete)
			return 1;
	}
	function save_menu(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", price = '$price' ";
		$data .= ", category_id = '$category_id' ";
		$data .= ", description = '$description' ";
		if(isset($status) && $status  == 'on')
		$data .= ", status = 1 ";
		else
		$data .= ", status = 0 ";

		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/img/'. $fname);
					$data .= ", img_path = '$fname' ";

		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO product_list set ".$data);
		}else{
			$save = $this->db->query("UPDATE product_list set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function delete_menu(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM product_list where id = ".$id);
		if($delete)
			return 1;
	}

	function add_to_cart(){
		extract($_POST);
		$data = " product_id = $pid ";	
		$qty = isset($qty) ? $qty : 1 ;
		$data .= ", qty = $qty ";	
		if(isset($_SESSION['login_user_id'])){
			$data .= ", user_id = '".$_SESSION['login_user_id']."' ";	
		}else{
			$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
			$data .= ", client_ip = '".$ip."' ";	

		}
		$save = $this->db->query("INSERT INTO cart set ".$data);
		if($save)
			return 1;
	}
	function get_cart_count(){
		extract($_POST);
		if(isset($_SESSION['login_user_id'])){
			$where =" where user_id = '".$_SESSION['login_user_id']."'  ";
		}
		else{
			$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
			$where =" where client_ip = '$ip'  ";
		}
		$get = $this->db->query("SELECT sum(qty) as cart FROM cart ".$where);
		if($get->num_rows > 0){
			return $get->fetch_array()['cart'];
		}else{
			return '0';
		}
	}

	function update_cart_qty(){
		extract($_POST);
		$data = " qty = $qty ";
		$save = $this->db->query("UPDATE cart set ".$data." where id = ".$id);
		if($save)
		return 1;	
	}

	function save_order(){
		extract($_POST);
		$data = " name = '".$first_name." ".$last_name."' ";
		$data .= ", address = '$address' ";
		$data .= ", mobile = '$mobile' ";
		$data .= ", email = '$email' ";
		$save = $this->db->query("INSERT INTO orders set ".$data);
		if($save){
			$id = $this->db->insert_id;
			$qry = $this->db->query("SELECT * FROM cart where user_id =".$_SESSION['login_user_id']);
			while($row= $qry->fetch_assoc()){

					$data = " order_id = '$id' ";
					$data .= ", product_id = '".$row['product_id']."' ";
					$data .= ", qty = '".$row['qty']."' ";
					$save2=$this->db->query("INSERT INTO order_list set ".$data);
					if($save2){
						$this->db->query("DELETE FROM cart where id= ".$row['id']);
					}
			}
			return 1;
		}
	}
function confirm_order(){
	extract($_POST);
		$save = $this->db->query("UPDATE orders set status = 1 where id= ".$id);
		if($save)
			return 1;
}

function delete_order(){
	extract($_POST);
	$delete = $this->db->query("DELETE FROM orders where id = ".$id);
	if($delete){
		// Also delete order items
		$this->db->query("DELETE FROM order_list where order_id = ".$id);
		return 1;
	}
}

function delete_user(){
	extract($_POST);
	$delete = $this->db->query("DELETE FROM users where id = ".$id);
	if($delete)
		return 1;
}

function save_customer(){
	extract($_POST);
	$data = " first_name = '$first_name' ";
	$data .= ", last_name = '$last_name' ";
	$data .= ", email = '$email' ";
	$data .= ", mobile = '$mobile' ";
	$data .= ", address = '$address' ";
	
	if(!empty($user_id)){
		$save = $this->db->query("UPDATE user_info set ".$data." where user_id = ".$user_id);
	}
	if($save)
		return 1;
}

function delete_customer(){
	extract($_POST);
	$delete = $this->db->query("DELETE FROM user_info where user_id = ".$user_id);
	if($delete)
		return 1;
}

function update_cart_qty(){
	extract($_POST);
	$update = $this->db->query("UPDATE cart SET qty = ".$qty." WHERE id = ".$id);
	if($update)
		return 1;
}

}