<?php
require_once ("../include/config.php");
require_once ("../include/".PAGE6.".php");

$json = $_POST["ltfhcJSON"];

if (get_magic_quotes_gpc())
	$json = stripslashes($json);
$data = json_decode($json);

$a=array();

$login_id=$data->login_id;
$password=$data->password;
//$login_id="test";
//$password="123";

$table1=TBL2;

$stmt = $con->prepare("SELECT hcw_username FROM $table1 WHERE hcw_username = ? && hcw_pass = ? && status='1'") or die($con->error);
$stmt->bind_param( "ss", $login_id, $password); 
$stmt->execute();
$stmt->store_result();
//$stmt->bind_result($id);

if($stmt->num_rows>0)
	$a['status'] = "1";
else
{
	$a['status'] = "0";
	$a['msg'] = "Wrong login id or password.";
}

echo json_encode($a);
?>

