<?php
require_once ("../include/config.php");
require_once ("../include/".PAGE6.".php");
require_once("../class/Action.class");

//$_POST["ltfhcJSON"]='[{"patient_id":"p1", "visit":"1", "component_id":"1", "component_value":"Test1", "login_id":"l1"},
//		{"patient_id":"p2", "visit":"1", "component_id":"1", "component_value":"Test2", "login_id":"l1"}]';
		
$json = $_POST["ltfhcJSON"];
if (get_magic_quotes_gpc())
	$json = stripslashes($json);

$data = json_decode($json);

$login_id=$data[0]->login_id;
$myfile = fopen("json_files/patient/".$login_id."_".date("d-M-Y_H-i-s").".json", "w") or die("Unable to open file!");
fwrite($myfile, $json);
fclose($myfile);


$save_data = new action($con);
for($i=0; $i<sizeof($data); $i++)
{
	$indicator['patient_id']=$data[$i]->patient_id;
	$indicator['visit']=$data[$i]->visit;
	$indicator['component_id']=$data[$i]->component_id;
	$indicator['component_value']=$data[$i]->component_value;
	$indicator['data_entry_id']=$data[$i]->login_id;
	$where = array("patient_id"=>$indicator['patient_id'], "visit"=>$indicator['visit'], "component_id"=>$indicator['component_id']);
	$save_data->setData($con, $indicator, TBL18, $where);
	$rslt=$save_data->insertData();
}
echo json_encode($rslt);
?>

