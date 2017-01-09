<?php
if($action=="edit" && $id)
{
	$stmt = $con->prepare("SELECT a.id, a.name, a.type, a.bg_image, a.image, a.save_value, a.mandatory, a.options, a.default_value, a.attribute, a.onclick_function, a.onclick_target, a.onclick_target_value_id, a.screen_id, a.layout_id, a.sequence FROM $table1 a WHERE id='$id'") or die($con->error);
	$stmt->execute();
	//$result = $stmt->get_result();			
	//$row = $result->fetch_assoc();
	$stmt->bind_result($id, $name, $type, $bg_image_path, $image_path, $save_value, $mandatory, $options, $default_value, $attribute, $onclick_function, $onclick_target, $onclick_target_value_id, $screen_id, $layout_id, $sequence);
	$stmt->fetch();
	$stmt->close();
}

if($type=="image")
{
	$image_div_display="";
	$bg_image_div_display="none";
}
else
{
	$image_div_display="none";
	$bg_image_div_display="";
}

?>							
	<script>
	$(document).ready(function(){
		
		/*Jquery Ajax function to call the PHP page which saves the data of the form*/
		$("form#form").submit(function(){
			var form_data = new FormData(this);
			//var form_data = $("#form").serialize();
			//alert(form_data);                    
			
				$('#myModal').modal({backdrop: 'static', keyboard: false});
				$.ajax({
					type: "POST",
					url: "ajax_pages/save_data.php?action=<?php echo $action; ?>&table=<?php echo $table1; ?>&id=<?php echo $id; ?>",
					//data: $("#form").serialize(),
					data: form_data,
					cache: false,
					contentType: false,
					processData: false,
					success: function(response) {
						//alert(response);
						var result=JSON.parse(response);
						if(result.status==1)
						{
							alert(result.msg);
							window.location="index.php<?php echo $page_name; ?>&action=<?php echo $action; ?>&id=<?php echo $id; ?>";
						}
						else
						if(result.status==0)
						{
							alert(result.msg);
							$('#myModal').modal("hide");
						}
					},
					error: function(response) {
						alert(response);
					}
				});
			
			return false;
		});
		
		$("#type").change(function(){
			if($("#type").val()=="image")
			{
				$("#image_div").slideDown();
				$("#bg_image_div").slideUp();
			}
			else
			{
				$("#image_div").slideUp();
				$("#bg_image_div").slideDown();
			}
			
		});
	});
	
	function deleteImage(img, path)
	{
		$('#myModal').modal({backdrop: 'static', keyboard: false});
				$.ajax({
					type: "GET",
					url: "ajax_pages/delete_image.php?action=<?php echo $action; ?>&table=<?php echo $table1; ?>&id=<?php echo $id; ?>&image_type="+img+"&path="+path,
					success: function(response) {
						//alert(response);
						var result=JSON.parse(response);
						if(result.status==1)
						{
							alert(result.msg);
							window.location="index.php<?php echo $page_name; ?>&action=<?php echo $action; ?>&id=<?php echo $id; ?>";
						}
						else
						if(result.status==0)
						{
							alert(result.msg);
							$('#myModal').modal("hide");
						}
					},
					error: function(response) {
						alert(response);
					}
				});
	}
	/*Ajax function to call the page which give layout name according to the selected screen without refreshing the current page*/
	function getLayout(table, screen_id)
	{
		var strURL="ajax_pages/get_layout.php";
		//alert(screen_id);
		var xmlhttp;
		if (window.XMLHttpRequest)
			xmlhttp=new XMLHttpRequest();
		else
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
				document.getElementById("layout_id").innerHTML=xmlhttp.responseText;
		}
		xmlhttp.open("POST",strURL,true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("table="+table+"&screen_id="+screen_id);
	}
	</script>
			<div class="well">
				<h3 class="col-sm-10">Component Form</h3>
				<div class="col-sm-2 text-right">
					<a href="<?php echo $page_name; ?>&action=view" class="btn btn-warning">
						<span class='glyphicon glyphicon-list'></span>
						VIEW LIST
					</a>
				</div>
				<form method="POST" class="form-horizontal" role="form" id="form" enctype="multipart/form-data">
					<div class="form-group">
						<label class="control-label col-sm-4" >Component Id :</label>
						<div class="col-sm-8">
							<label class="control-label" ><?php echo $id; ?></label>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-4" for="name">Component :</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" placeholder="Enter component">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="type">Component Type :</label>
						<div class="col-sm-8">
							<?php $$type="selected"; ?>
							<select class='form-control' name="type" id="type">
								<option value="">Select</option>
								<option value="text" <?php echo $text; ?>>Text</option>
								<option value="datetime" <?php echo $datetime; ?>>Date Time</option>
								<option value="date" <?php echo $date; ?>>Date</option>
								<option value="time" <?php echo $time; ?>>Time</option>
								<option value="dropdown" <?php echo $dropdown; ?>>Drop Down</option>
								<option value="checkbox" <?php echo $checkbox; ?>>Check Box</option>
								<option value="checkboxlist" <?php echo $checkboxlist; ?>>Check Box List</option>
								<option value="radio" <?php echo $radio; ?>>Radio</option>
								<option value="patient_list" <?php echo $patient_list; ?>>Patient List</option>
								<option value="visit_list" <?php echo $visit_list; ?>>Visit List</option>
								<option value="patient_detail" <?php echo $patient_detail; ?>>Patient Detail</option>
								<option value="button" <?php echo $button; ?>>Button</option>
								<option value="label" <?php echo $label; ?>>Label</option>
								<option value="age" <?php echo $age; ?>>Age</option>
								<option value="menu_list" <?php echo $menu_list; ?>>Menu List</option>
								<option value="image" <?php echo $image; ?>>Image</option>
							</select>
						</div>
					</div>
					<div class="form-group" id="bg_image_div" style="display:<?php echo $bg_image_div_display; ?>">
						<label class="control-label col-sm-4" for="option">Background Image :</label>
						<div class="col-sm-8">
							<label class="btn btn-primary">
								Browse&hellip; <input type="file" name="bg_image" id="bg_image" style="display: none;">
							</label>
							<?php if($bg_image_path){ ?>
							<img src="../<?php echo $bg_image_path; ?>" width="40">
							<a href="#" onclick="deleteImage('bg_image', '<?php echo $bg_image_path; ?>')"><span class="glyphicon glyphicon-trash"></span></a>
							<?php } ?>
						</div>
					</div>
					<div class="form-group" id="image_div" style="display:<?php echo $image_div_display; ?>">
						<label class="control-label col-sm-4" for="option">Component Image :</label>
						<div class="col-sm-8">
							<label class="btn btn-primary">
								Browse&hellip; <input type="file" name="image" id="image" style="display: none;">
							</label>
							<?php if($image_path){ ?>
							<img src="../<?php echo $image_path; ?>" width="40">
							<a href="#" onclick="deleteImage('component_image', '<?php echo $image_path; ?>')"><span class="glyphicon glyphicon-trash"></span></a>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="option">Save Component Value :</label>
						<div class="col-sm-8">
							<input type="checkbox" class='form-control' name="save_value" id="save_value" value="1" <?php echo $save_value==1?"checked":""; ?> >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="type">Mandatory :</label>
						<div class="col-sm-8">
							<?php $$mandatory="selected"; ?>
							<select class='form-control' name="mandatory" id="type">
								<option value="no" <?php echo $no; ?>>No</option>
								<option value="yes" <?php echo $yes; ?>>Yes</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="option">Component Options :</label>
						<div class="col-sm-8">
							<textarea class="form-control" name="options" id="option"><?php echo $options; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="default_value">Default Value :</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="default_value" id="default_value" value="<?php echo $default_value; ?>" placeholder="Enter field default value">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="attribute">Component Attribute :</label>
						<div class="col-sm-8">
							<textarea class="form-control" name="attribute" id="attribute"><?php echo $attribute; ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="attribute">OnClick :</label>
						<div class="col-sm-3">
							<select class='form-control' name="onclick_function">
								<option value="">Select Function</option>
								<?php $$onclick_function="selected"; ?>
								<option value='save' <?php echo $save; ?>>Save</option>
								<option value='backward' <?php echo $backward; ?>>Backward</option>
								<option value='forward' <?php echo $forward; ?>>Forward</option>
							</select>
						</div>
						<div class="col-sm-2">
							<select class='form-control' name="onclick_target">
								<option value="">Select Target</option>
								<?php $$onclick_target="selected"; ?>
								<option value='screen' <?php echo $screen; ?>>Screen</option>
								<option value='alert' <?php echo $alert; ?>>Alert</option>
							</select>
						</div>
						<div class="col-sm-3">
							<select class='form-control' name="onclick_target_value_id">
								<option value="">Select Target Value</option>
								<?php
								$$onclick_target_value_id="selected";
								$stmt = $con->prepare("SELECT a.id, a.name FROM $table3 a WHERE a.status=1 ORDER BY a.name") or die($con->error);
								$stmt->execute();
								//$result = get_result($stmt);
								$stmt->bind_result($onclick_target_value_id1, $onclick_target_value_name);
								while ($stmt->fetch())
								{
									$onclick_target_value_selected=$$onclick_target_value_id1;
									
									echo "<option value='$onclick_target_value_id1' $onclick_target_value_selected>$onclick_target_value_name</option>";
								}
								$$onclick_target_value_id="";
								$stmt->close();
								?>			
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="screen_id">Screen :</label>
						<div class="col-sm-8">
							<select class='form-control' name="screen_id" onchange="getLayout('<?php echo $table2; ?>', this.value)">
								<option value="">Select</option>
								<?php
								$$screen_id="selected";
								$stmt = $con->prepare("SELECT a.id, a.name FROM $table3 a WHERE a.status=1 ORDER BY a.name") or die($con->error);
								$stmt->execute();
								//$result = get_result($stmt);
								$stmt->bind_result($screenid, $screen_name);
								while ($stmt->fetch())
								{
									$screen_selected=$$screenid;
									
									echo "<option value='$screenid' $screen_selected>$screen_name</option>";
								}
								$$screen_id="";
								$stmt->close();
								?>								
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="sub_category_id">Layout :</label>
						<div class="col-sm-8">
							<select class='form-control' name="layout_id" id="layout_id">
								<option value="">Select</option>
								<?php
								$layout_where=$screen_id?" AND screen_id='$screen_id'":"";
								$$layout_id="selected";
								$stmt = $con->prepare("SELECT a.id, a.name FROM $table2 a WHERE a.status=1 $layout_where ORDER BY a.name") or die($con->error);
								$stmt->execute();
								//$result = get_result($stmt);
								$stmt->bind_result($layoutid, $layout_name);
								while ($stmt->fetch())
								{
									$layout_selected=$$layoutid;
									
									echo "<option value='$layoutid' $layout_selected>$layout_name</option>";
								}
								$$layout_selected="";
								$stmt->close();
								?>								
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" >Sequence :</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" name="sequence" id="sequence" value="<?php echo $sequence; ?>" placeholder="Enter sequence">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" class="btn btn-danger" id="btn-submit" name="submit">Submit</button>
						</div>
					</div>
				</form>
			</div>