<?php
require_once ("../include/config.php");
require_once ("../include/".PAGE6.".php");

class Login
{
	function __construct($con, $login_id, $password)
	{
		$this->con=$con;
		$this->login_id=$login_id;
		$this->password=$password;
	}
	
	function encrypt($string, $data)
	{

		$salt = substr(md5(mt_rand(), true), 8);

		$key = md5($string . $salt, true);
		$iv  = md5($key . $string . $salt, true);

		$ct = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, $iv);

		return base64_encode('Salted__' . $salt . $ct);
	}

	function decrypt($plain_string, $encrypted_string)
	{
		$encrypted_string = base64_decode($encrypted_string);
		$salt = substr($encrypted_string, 8, 8);
		$ct   = substr($encrypted_string, 16);

		$key = md5($plain_string . $salt, true);
		$iv  = md5($key . $plain_string . $salt, true);

		$pt = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ct, MCRYPT_MODE_CBC, $iv);

		return $pt;
	}
	
	function check_user_id()
	{
		$stmt = $this->con->prepare("SELECT login_id FROM ".TBL1." WHERE login_id = ? && status='1'") or die($this->con->error);
		$stmt->bind_param("s", $this->login_id); 
		$stmt->execute();
		$stmt->store_result();
		//$stmt->bind_result($id);
		if($stmt->num_rows>0)
			$login_table=TBL1;
		else
		{
			$stmt = $this->con->prepare("SELECT login_id FROM master_doctor WHERE login_id = ? && status='1'") or die($this->con->error);
			$stmt->bind_param("s", $this->login_id); 
			$stmt->execute();
			$stmt->store_result();
			//$stmt->bind_result($id);
			if($stmt->num_rows>0)
				$login_table="master_doctor";
			else
			{	
				$stmt = $this->con->prepare("SELECT login_id FROM master_counselor WHERE login_id = ? && status='1'") or die($this->con->error);
				$stmt->bind_param("s", $this->login_id); 
				$stmt->execute();
				$stmt->store_result();
				//$stmt->bind_result($id);
				if($stmt->num_rows>0)
					$login_table="master_counselor";
			}
		}
		
		return($login_table);
	}
	
	function matchPassword($login_table, $entered_password)
	{
		$a=array();
		$stmt = $this->con->prepare("SELECT password FROM $login_table WHERE login_id = ? && status='1'") or die($this->con->error);
		$stmt->bind_param("s", $this->login_id); 
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($existing_encrypted_password);
		$stmt->fetch();
		$stmt->close();	
		$check_current_password=$this::decrypt($entered_password, $existing_encrypted_password);
		
		if(trim($check_current_password)==ENC_STRING)
		{
			$a["status"]=1;
			$a["msg"]="<div class='success'>Password checked successfull</div><br>&nbsp;";
		}
		else
		{
			$a["status"]=0;
			$a["msg"]="<div class='error'>Error : Password checked unsuccessfull</div><br>&nbsp;";
		}
		return($a);
	}
	
	function verify()
	{
		$verify=array();
		if($login_table=$this::check_user_id())
		{
			$match=$this::matchPassword($login_table, $this->password);
			if($match['status']==1)
			{
				$stmt = $this->con->prepare("SELECT name, type, auth_path FROM $login_table WHERE login_id=? AND status='1'") or die($this->con->error);
				$stmt->bind_param( "s", $this->login_id); 
				$stmt->execute();
				//$stmt->store_result();
				//$stmt->num_rows>0;
				$stmt->bind_result($name, $type, $auth_path);
				if($stmt->fetch())
				{
					$verify['login_name']=$name;
					$verify['login_type']=$type;
					$verify['auth_path']=$auth_path;
				}
				else
					$verify['error']="User ID and password are not matching...!!!";
			}
			else
				$verify['error']="User ID and password are not matching...!!!";
		}
		else
			$verify['error']="User ID is not found...!!!";
		
		return($verify);
	}
}

if($_POST['login_id'])
{
	$login_id=$_POST['login_id'];
	$password=$_POST['password'];
	
	$a=array();
	
	$login=new Login($con, $login_id, $password);

			
		$verify=$login->verify();

		if(!$verify['error'])
		{
			session_start();
			$_SESSION[APPLICATION_ID.'_login_id']=$login_id;
			$_SESSION[APPLICATION_ID.'_password']=$password;
			$_SESSION[APPLICATION_ID.'_login_name']=$verify['login_name'];
			$_SESSION[APPLICATION_ID.'_user_type']=$verify['user_type'];
			$_SESSION[APPLICATION_ID.'_login_type']=$verify['login_type'];
			$_SESSION[APPLICATION_ID.'_auth_path']=$verify['auth_path'];
			unset($_SESSION[APPLICATION_ID.'_patient_detail']);
			
			if($_SESSION[APPLICATION_ID.'_auth_path'])
				$location=$_SESSION[APPLICATION_ID.'_auth_path'];
			else
			if($verify['login_type']=="doctor" || $verify['login_type']=="counselor")
				$location="user/".PAGE1.".php";
			else
				$location=$verify['login_type']."/".PAGE1.".php";

			if($location)
			{
				$_SESSION[APPLICATION_ID.'_auth_path']=$location;
				$a['status'] = "1";
				$a['location'] = $location;
			}
		}
		else
		{
			$a['status'] = "0";
			$a['msg'] = $verify['error'];
			$login_id="";
			$password="";
			$location="";
		} 
	
}

echo json_encode($a);
?>

