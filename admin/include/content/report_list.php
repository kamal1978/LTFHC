<?php
$page_name="?page=$page";
if($trimester=$_REQUEST['trimester'])
{
	$where .=" AND b.trmstr_id='$trimester'";
	$page_name .="&trimester=$trimester";
}
if($from_date=$_REQUEST['from_date'])
{
	if(!$to_date=$_REQUEST['to_date'])
		$to_date=date("Y-m-d");
	$where .=" AND DATE(b.date) BETWEEN '$from_date' AND '$to_date'";
	$page_name .="&from_date=$from_date";
	$page_name .="&to_date=$to_date";
}
if($_POST['filter'])
{
	echo"<script language='javascript'>
			window.location.href = '$page_name';
		</script>";
}
?>
			<div>
				<h3 class="col-sm-10">Report</h3>
				<div>
					<table class="table">
						<form method="POST" name="filter_form">
						<tr class='active table-bordered'>
							<td>
								<?php
								if($trimester=="1")
									$ft="selected";
								else
								if($trimester=="2")
									$st="selected";
								else
								if($trimester=="3-1")
									$tt1="selected";
								else
								if($trimester=="3-2")
									$tt2="selected";
								else
								if($trimester=="4")
									$ds="selected";
								?>
								<select class='form-control' name="trimester" id="trimester">
									<option value="">Select Trimester</option>
									<option value="1" <?php echo $ft; ?>>First Trimester</option>
									<option value="2" <?php echo $st; ?>>Second Trimester</option>
									<option value="3-1" <?php echo $tt1; ?>>Third Trimester (28th Week to 36 Week)</option>
									<option value="3-2" <?php echo $tt2; ?>>Third Trimester (37 Week and above)</option>
									<option value="4" <?php echo $ds; ?>>Delivery Status</option>
								</select>
							</td>
							<td>
								<div class="form-group input-group date" id="from_datepicker">
									<input type="text" name="from_date" class="form-control" id="from_date"  value="<?php echo $from_date; ?>" placeholder="From Date" readonly>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								<script type="text/javascript">
								$(function () {
									$('#from_datepicker').datetimepicker({
										format: 'YYYY-MM-DD',
										ignoreReadonly: true
									});
								});
								</script>
							</td>
							<td>
								<div class="form-group input-group date" id="to_datepicker">
									<input type="text" name="to_date" class="form-control" id="to_date"  value="<?php echo $to_date; ?>" placeholder="To Date" readonly>
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								<script type="text/javascript">
								$(function () {
									$('#to_datepicker').datetimepicker({
										format: 'YYYY-MM-DD',
										ignoreReadonly: true
									});
								});
								</script>
							</td>
							<input type="hidden" name="filter" value="1">
							<td class="text-center">
								<button type="submit" class="btn btn-success">
									<span class='glyphicon glyphicon-filter'></span>
									Filter
								</button>
							</td>
							<?php if($trimester || $from_date){ ?>
							<td class="text-center">
								<a href="include/content/export_report.php?trimester=<?php echo $trimester; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" class="btn btn-success">
									<span class='glyphicon glyphicon-export'></span>
									Export
								</a>
							</td>
							<?php } ?>
						</tr>
						</form>
					</table>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr class="info">
							<?php
								echo "<th>Patient Id</th>";
								echo "<th>Visit</th>";
								echo "<th>Visit Date</th>";
								echo "<th>Trimester</th>";
								echo "<th>Patient Name</th>";
								//echo "<th>DOB</th>";
								echo "<th>Age</th>";
								echo "<th>Gender</th>";
								echo "<th>Father Husband Name</th>";
								echo "<th>Address</th>";
								echo "<th>Mobile Number</th>";
								echo "<th>Height</th>";
								echo "<th>Weight</th>";
								echo "<th>BMI</th>";
								echo "<th>BPL Card Color</th>";
								echo "<th>BPL Card Number</th>";
								echo "<th>Landmark</th>";
								echo "<th>Country</th>";
								echo "<th>State</th>";
								echo "<th>District</th>";
								echo "<th>Block</th>";
								echo "<th>Village</th>";
								echo "<th>User Name</th>";
								
							$stmt = $con->prepare("SELECT a.id, a.question FROM $table1 a WHERE a.status=1 AND a.tremesterid='$trimester' ORDER BY a.categoryid, a.sequenceid") or die($con->error);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($id, $question);

							while ($stmt->fetch())
							{
								$question_id[]=$id;
								echo "<th>$question</th>";
							}
							$stmt->close();
							?>
							</tr>
						</thead>
						<tbody>
					<?php
					$stmt = $con->prepare("SELECT a.Patient_Id, a.Visit_Id, a.Visit_Date, a.Trimester, a.Name, a.Date_Of_Birth, IF(a.years='0', IF(a.months='0', CONCAT(a.days, ' Days'), CONCAT(a.months, ' Months')), CONCAT(a.years, ' Years')) AS age, a.Gender, a.Fathers_Husbands_FName, a.Address, a.Mobile_Number, a.Height, a.Weight, a.bmi, a.BPL_Card_Color, a.BPL_Card_Number, a.Landmark, a.Country, a.State, a.District, a.Block, a.Village, a.data_entry_id FROM ".TBL2." a WHERE a.Trimester='$trimester' AND a.Visit_Date BETWEEN '$from_date' AND '$to_date'") or die($con->error);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($patient_id, $visit_id, $visit_date, $trimester, $patient_name, $dob, $age, $gender, $father_husband_name, $address, $mobile_no, $height, $weight, $bmi, $bpl_card_color, $bpl_card_no, $landmark, $country, $state, $district, $block, $village, $data_entry_id);
					while ($stmt->fetch())
					{							
						echo "<tr class='active'>";
							echo "<td>$patient_id</td>";
							echo "<td>$visit_id</td>";
							echo "<td>".date('d M Y', strtotime($visit_date))."</td>";
							echo "<td>$trimester</td>";
							echo "<td>$patient_name</td>";
							//echo "<td>".date('d M Y', strtotime($dob))."</td>";
							echo "<td>$age</td>";
							echo "<td>$gender</td>";
							echo "<td>$father_husband_name</td>";
							echo "<td>$address</td>";
							echo "<td>$mobile_no</td>";
							echo "<td>$height</td>";
							echo "<td>$weight</td>";
							echo "<td>$bmi</td>";
							echo "<td>$bpl_card_color</td>";
							echo "<td>$bpl_card_no</td>";
							echo "<td>$landmark</td>";
							echo "<td>$country</td>";
							echo "<td>$state</td>";
							echo "<td>$district</td>";
							echo "<td>$block</td>";
							echo "<td>$village</td>";
							echo "<td>$data_entry_id</td>";
						
						for($i=0; $i<sizeof($question_id); $i++)
						{
							$answertext="";
							$stmt1 = $con->prepare("SELECT b.answertext, a.field_type FROM $table1 a JOIN $table2 b ON a.id=b.questionid WHERE b.questionid='$question_id[$i]' AND b.patientid='$patient_id' AND b.visit_count='$visit_id' $where") or die($con->error);
							$stmt1->execute();
							$stmt1->store_result();
							$stmt1->bind_result($answertext, $field_type);
							$stmt1->fetch();
							$stmt1->close();
							
							if($field_type=="date")
								$answertext=date("d M Y", strtotime($answertext));

							echo"<td>$answertext</td>";
						}
						echo "</tr>";
					}
					$stmt->close();
					?>
						</tbody>
					</table>
				</div>
			</div>