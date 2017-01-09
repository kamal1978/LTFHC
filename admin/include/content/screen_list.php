			<div>
				<h3 class="col-sm-10">Screen List</h3>
				<div class="col-sm-2 text-right">
					<a href="?page=<?php echo $page; ?>&action=add" class="btn btn-warning">
						<span class='glyphicon glyphicon-plus'></span>
						ADD NEW
					</a>
				</div>
				<div>
					<table class="table table-bordered">
						<thead>
							<tr class="info">
								<!--<th>Si.</th>-->
								<th>Screen Id</th>
								<th>Screen Name</th>
								<th>Sequence</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
					<?php
							
						$stmt = $con->prepare("SELECT a.id, a.name, a.sequence, a.status FROM $table1 a ORDER BY a.sequence") or die($con->error);
						$stmt->execute();
						//$result = $stmt->get_result();
						$stmt->bind_result($id, $name, $sequence, $status);
						$i=1;
						while ($stmt->fetch())
						{							
							echo"<tr class='active'>
									<!--<td>$i</td>-->
									<td>$id</td>
									<td>$name</td>
									<td>$sequence</td>
									<td>
										<a href='?page=$page&action=edit&id=$id' class='btn btn-primary btn-sm'>
											<span class='glyphicon glyphicon-pencil'></span>
											Edit
										</a>
									</td>
								</tr>";
							$i++;
						}
					?>
						</tbody>
					</table>
				</div>
			</div>