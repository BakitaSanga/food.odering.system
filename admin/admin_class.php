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
		$qry = $this->db->query("SELECT * FROM users where username = '".$username."'");
		if($qry->num_rows > 0){
			$row = $qry->fetch_array();
			if(password_verify($password, $row['password'])){
				foreach ($row as $key => $value) {
					if($key != 'password' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
					return 1;
			}
		}else{
			return 3;
		}
	}
	function login2(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM user_info where email = '".$email."'");
		if($qry->num_rows > 0){
			$row = $qry->fetch_array();
			if(password_verify($password, $row['password'])){
				foreach ($row as $key => $value) {
					if($key != 'password' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
				$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']);
				$this->db->query("UPDATE cart set user_id = '".$_SESSION['login_user_id']."' where client_ip ='$ip' ");
					return 1;
			}
		}else{
			return 3;
		}
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
		$data .= ", password = '".password_hash($password, PASSWORD_DEFAULT)."' ";
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
		$data .= ", password = '".password_hash($password, PASSWORD_DEFAULT)."' ";
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

	function delete_cart(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM cart where id = ".$id);
		if($delete)
			return 1;
	}

	function save_order(){
		extract($_POST);
		$data = " name = '".$first_name." ".$last_name."' ";
		$data .= ", address = '$address' ";
		$data .= ", mobile = '$mobile' ";
		$data .= ", email = '$email' ";
		if(isset($_SESSION['login_user_id'])){
			$data .= ", user_id = '".$_SESSION['login_user_id']."' ";
		}
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

function forgot_password(){
	extract($_POST);
	// Check if email exists
	$check = $this->db->query("SELECT * FROM user_info WHERE email = '".$email."'");
	if($check->num_rows == 0){
		return 2; // Email not found
	}
	
	// Generate reset token
	$token = bin2hex(random_bytes(32));
	$expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
	
	// Delete any existing tokens for this email
	$this->db->query("DELETE FROM password_resets WHERE email = '".$email."'");
	
	// Insert new token
	$insert = $this->db->query("INSERT INTO password_resets (email, token, expires_at) VALUES ('".$email."', '".$token."', '".$expires_at."')");
	
	if($insert){
		// In production, send email here
		// For now, output the reset link to console
		error_log("Password reset link: reset_password.html?token=".$token);
		return 1;
	}
	return 0;
}

function verify_reset_token(){
	extract($_POST);
	$check = $this->db->query("SELECT * FROM password_resets WHERE token = '".$token."' AND expires_at > NOW()");
	if($check->num_rows > 0){
		return 1;
	}
	return 0;
}

function reset_password(){
	extract($_POST);
	// Verify token is valid
	$check = $this->db->query("SELECT * FROM password_resets WHERE token = '".$token."' AND expires_at > NOW()");
	if($check->num_rows == 0){
		return 2; // Invalid or expired token
	}
	
	$reset_data = $check->fetch_array();
	$email = $reset_data['email'];
	
	// Update password
	$update = $this->db->query("UPDATE user_info SET password = '".password_hash($password, PASSWORD_DEFAULT)."' WHERE email = '".$email."'");
	
	if($update){
		// Delete used token
		$this->db->query("DELETE FROM password_resets WHERE token = '".$token."'");
		return 1;
	}
	return 0;
}

}