<!-- Tab panes -->
								
	<div class="tab-pane fade" id="cloudTTN-pills">
		</br>
		<div id="cloudTTN_status_msg"></div>
		
		<div class="col-md-10 col-md-offset-0">
		
		<?php
			$date=date('Y-m-d\TH:i:s');
			echo '<p>Date/Time: ';
			echo $date;
			echo '</p>';											
			ob_start();
			system("tac /home/pi/lora_gateway/log/post-processing.log | egrep -a -m 1 'uploading with python.*CloudTTN.*py' | cut -d '>' -f1");
			//system("egrep -a 'uploading with python.*CloudTTN.*py' /home/pi/lora_gateway/log/post-processing.log | tail -1 | cut -d '>' -f1");
			$last_upload=ob_get_contents(); 
			ob_clean();
			echo '<p>';
			if ($last_upload=='') {
				echo '<font color="red"><b>no upload with CloudTTN.py found</b></font>';					
			}
			else {
				$date=str_replace("T", " ", $date, $count);
				$datetime1 = new DateTime($date);
				$last_upload_1=str_replace("T", " ", $last_upload, $count);
				$datetime2 = new DateTime($last_upload_1);
				$interval = $datetime1->diff($datetime2);			
				echo 'last upload time with CloudTTN.py: <font color="green"><b>';
				echo $last_upload;
				echo $interval->format(' %mm-%dd-%hh-%imin from current date');
				echo '</b></font>';					
			}
			echo '</p>';									
		?>                            
				
		  <div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
			  <thead></thead>
			 <tbody>
			   <tr>
					<td>Enabled
					</td>
					<td id="cloudTTN_status_value"></td>
					
					<td align="right">
					<input type="checkbox" id="ttn_status_toggle" data-toggle="toggle" data-on="true" data-off="false" <?php if(get_cloud_status($lorawan_encrypted_clouds, "python CloudTTN.py")) echo "checked";?>>
					</td>
			
					<!-- <td align="right"><button id="btn_edit_cloudTTN_status" type="button" class="btn btn-primary"><span class="fa fa-edit"></span></button></td> -->
					
					<td id="td_edit_cloudTTN_status">
						<div id="div_cloudTTN_status_options" class="form-group">
							<div class="radio">
							<fieldset id="cloudTTN_status_group" >
								<label>
									<input type="radio" name="cloudTTN_status_group" id="cloudTTN_true" value="true" checked>True
								</label>
								</br>
								<label>
									<input type="radio" name="cloudTTN_status_group" id="cloudTTN_false" value="false" >False
								</label>
								</fieldset>
							</div>
						</div>
					</td> 
					<td id="td_cloudTTN_status_submit" align="right">
						<button id="btn_cloudTTN_status_submit" type="submit" class="btn btn-primary">Submit <span class="fa fa-arrow-right"></span></button>
					</td>
			   </tr>

				<tr>
					<td><a href="#" class="my_tooltip" data-toggle="tooltip" title="Indicate a list of accepted device addresses, e.g. 6,7,0x01020304">source list</a></td>
					<td id="td_cloudTTN_source_list_value">
						<?php 
							$array = $key_clouds['ttn_source_list'];
							$size = count($key_clouds['ttn_source_list']);
							$i = 0;
							if($size == 0) echo "Empty";
							foreach( $array as $cel){
								if(($size-1) == $i){
									echo $cel;
								}else{
									echo $cel . ",";
								}
								$i++;
							}
						?>
					</td>
					<td align="right">
						<button id="btn_edit_cloudTTN_source_list" type="button" class="btn btn-primary">
							<span class="fa fa-edit"></span>
						</button>
					</td>
					<td id="td_edit_cloudTTN_source_list">
						<div id="div_edit_cloudTTN_source_list" class="form-group">
							<label>Add a sensor to your list</label>
							<input id="cloudTTN_source_list_input" class="form-control" placeholder="e.g. 6,7,0x01020304" type="text"
							value="<?php 
								$array = $key_clouds['ttn_source_list'];
								$size = count($key_clouds['ttn_source_list']);
								$i = 0;
								foreach( $array as $cel){
									if(($size-1) == $i){
										echo $cel;
									}else{
										echo $cel . ",";
									}
									$i++;
								}
							?>" autofocus>
						</div>
					</td>
					<td id="td_cloudTTN_source_list_submit" align="right">
						<button id="btn_cloudTTN_source_list_submit" type="submit" class="btn btn-primary">
							Submit
							<span class="fa fa-arrow-right"></span>
						</button>
					</td>
				</tr>
			 </tbody>
			</table>
		  </div>
		</div>
</div>		
