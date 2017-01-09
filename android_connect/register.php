<?php
require_once('../include/config.php');
require_once('../include/connection.php');
require_once('../class/Action.class');

class SaveData
{		
	function __construct($con)
	{
		$this->con=$con;
		$this->action=new Action();
	}
	
	function saveData($indicator, $table, $where)
	{
		$response=array();
		$this->action->setData($this->con, $indicator, $table, $where);
		$insert_data=$this->action->insertData();
		if($insert_data['insert']=="query error")
		{
			$response["msg"] = " Query error on insert in table $table of clinic id : ".$indicator['clinic_id']." & hcw : ".$indicator['hcw_first_name'];	
			$response["status"] = "0";
		}
		else
		if($insert_data['insert']=="duplicate error")
		{
			$uwhere=array(patient_id=>"Update");
			$this->action->setData($this->con, $indicator, $table, $uwhere);
			$update_data=$this->action->updateData($where);
			if($update_data['update']=="query error")
			{
				$response["msg"] = " Query error on update in table '$table' for clinic id : ".$indicator['clinic_id']." & hcw : ".$indicator['hcw_first_name'];	
				$response["status"] = "0";	
			}
			else
			if($update_data['update']=="duplicate error")
			{
				$response["msg"] = " Duplicate data on update in table '$table' for clinic id : ".$indicator['clinic_id']." & hcw : ".$indicator['hcw_first_name'];	
				$response["status"] = "0";	
			}
			else
			if($update_data['update']=="success")
			{
				$response["msg"] = " Data has been updated in table '$table' for clinic id : ".$indicator['clinic_id']." & hcw : ".$indicator['hcw_first_name'];	
				$response["status"] = "1";	
			}
			else
			{
				$response["msg"] = " Something went wrong on update in table '$table' for clinic id : ".$indicator['clinic_id']." & hcw : ".$indicator['hcw_first_name'];	
				$response["status"] = "0";
			}
		}
		else
		if($insert_data['insert']=="success")
		{
			$response["msg"] = " Data has been inserted in table '$table' for clinic id : ".$indicator['clinic_id']." & hcw : ".$indicator['hcw_first_name'];	
			$response["status"] = "1";	
		}
		else
		{
			$response["msg"] = " Something went wrong on insert in table '$table' for clinic id : ".$indicator['clinic_id']." & hcw : ".$indicator['hcw_first_name'];	
			$response["status"] = "0";
		}
		
		return($response);
	}
}

function docPath($provider_id, $patient_id, $visit_date)
{
	$folder_name="Patient-Report-".date("d-M-Y-H-i-s", strtotime($visit_date));
    if(!file_exists("../documents/".$provider_id))
        mkdir("../documents/".$provider_id, 0777);
    if(!file_exists("../documents/".$provider_id."/".$patient_id))
        mkdir("../documents/".$provider_id."/".$patient_id, 0777);
    if(!file_exists("../documents/".$provider_id."/".$patient_id."/".$folder_name))
        mkdir("../documents/".$provider_id."/".$patient_id."/".$folder_name, 0777);
	
	$doc_path="../documents/".$provider_id."/".$patient_id."/".$folder_name."/";
	return($doc_path);
}

$json = $_POST["ltfhcJSON"];
if (get_magic_quotes_gpc())
	$json = stripslashes($json);

//$json='[{"hcw_first_name":"fname", "hcw_last_name":"lname", "hcw_loc":"Loc", "hcw_clinic_id":"3423", "hcw_username":"k1", "hcw_pass":"123", "hcw_device_id":"sdf345sd2"}]';

$data = json_decode($json);

$table1=TBL2;

$indicator=array();

$save_data = new SaveData($con);

$myfile = fopen("json_files/registration/".$login_id."_".date("d-M-Y_H-i-s").".json", "w") or die("Unable to open file!");
fwrite($myfile, $json);
fclose($myfile);

for($i=0; $i<sizeof($data); $i++)
{
	$indicator['hcw_first_name']=$data[$i]->hcw_first_name;
	$indicator['hcw_last_name']=$data[$i]->hcw_last_name;
	$indicator['hcw_loc']=$data[$i]->hcw_loc;
	$indicator['hcw_clinic_id']=$data[$i]->hcw_clinic_id;
	$indicator['hcw_username']=$data[$i]->hcw_username;
	$indicator['hcw_pass']=$data[$i]->hcw_pass;
	$indicator['hcw_device_id']=$data[$i]->hcw_device_id;
	
	$result=$save_data->saveData($indicator, $table1, array(hcw_first_name=>$indicator['hcw_first_name'], hcw_last_name=>$indicator['hcw_last_name'], hcw_clinic_id=>$indicator['hcw_clinic_id']));
}

echo json_encode($result);
?>