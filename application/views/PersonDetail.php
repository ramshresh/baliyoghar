<style type="text/css">
	#addParticipants_person_table tr td {
		padding: 10px;
	}

	#addParticipants_person_table tr td:hover {
		background: rgba(0, 0, 0, 0.1);
	}

	#addParticipants_person_table tr {
		border-bottom: 2px solid #f7f7f9;
	}

	.addParticipants_person_table_div {
		border: 1px solid #ccc;
		border-radius: 5px;
		margin-top: 10px;
		background: #f7f7f9;

	}

	.addParticipants_person_table_div input[type=checkbox] {
		margin-top: -5px;
	}

	.addParticipants_person_table_div p {
		font-size: 16px;
		padding: 10px;
	}

	td.instructor {
		background: rgba(0, 255, 0, 0.08);
	}

	p[class^="participants_"] {
		border: 1px solid #ccc;
		padding: 2px 2px 2px 2px;
		border-radius: 3px;
		margin-bottom: 1px;
		margin-right: 1px;
		width: auto;
		float: left;
		color: #555;
		font: 12px arial, verdana, sans-serif;
	}

	p[class^="participants_"] a {
		background: url(../img/del.png) right no-repeat;
		width: 16px;
		height: 16px;
		display: inline-block;
	}

	p[class^="participants_"] a:hover {
		background: url(../img/del_red.png) right no-repeat;
	}

	p.greenBg {
		background: rgba(0, 255, 0, 0.1);
	}

	table.event_detail_table td {
		text-align: left;
		border: 1px solid #3A87AD;
		background: rgba(255, 255, 255, 0.3);
	}

	table.event_detail_table td.title {
		background: rgba(0, 0, 0, 0.05);
		text-align: left;
		width: 150px;
		border: 1px solid #3A87AD;
	}

	table.event_detail_table {
		margin-top: 15px;
	}

	h3 {
		color: #888;
	}

	label {
		display: inline-block;
		font-weight: bold;
		margin: 0;
		padding: 0;
	}

</style>
<script type="text/javascript">
	$(document).ready(function () {
		/*  $(document.body).on('click','input[id^=unselectcandidate_]',function(){
		 var id =$(this).attr('id');
		 var array = id.split("_");
		 var personid=array[1];
		 var eventid = array[2];
		 });
		 */

		$(document.body).on('click', 'a[id^=unselectcandidate_]', function () {
			var yes = confirm('Are you sure ?');
			if (yes == true) {
				var id = $(this).attr('id');
				var array = id.split("_");
				var participation_id = array[1];
				var path = "../Event/deleteCandidate_async";
				$.ajax({
					type: "POST",
					url: path,
					data: {
						participation_id: participation_id
					},
					cache: false,
					error: function (xhr, status, error) {
						alert('Error !\n Please try again.\n(Please check your internet connection.)');
					},
					success: function (msg) {
						if ($.trim(msg) == 'no') {
							alert('Action failed.\nPlease try again after some time or refresh the page.');
						} else {
							$('#participant_row_' + participation_id).remove();
						}
					}
				});
			}
		});
	});
</script>

<div class="container">

	<div class="row">
		<div class="span12">
			<center><span style="color:green"><?php if (isset($insert)) echo $insert; ?></span></center>
			<hr/>
			<h5 class="text-info"><?php if (isset($fullname)) echo strtoupper($title) . " " . strtoupper($fullname); ?></h5>
			<hr/>
		</div>
	</div>

	<div class="row">

		<div class="span9">
			<table width="75%" border="0" class="text-info">
				<tr>
					<td><label>Profession</label></td>
					<td><?php echo $work_name; ?></td>
				</tr>
				<tr>
					<td><label>Citizenship No</label></td>
					<td><?php echo $citizenship_no; ?></td>
				</tr>
				<tr>
					<td width="26%"><label>Date of Birth :</label></td>
					<td colspan="4"><?php
						if (isset($dob_en)) {
							if ($dob_en != '0000-00-00') {
								echo '&nbsp;&nbsp;' . $dob_en . ' (AD)';
							} else {
								//echo 'n/a';
							}
						}
						if (isset($dob_np)) {
							if ($dob_np != '0000-00-00') {
								echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $dob_np . ' (BS)';
							} else {
								// echo '&nbsp;&nbsp;&nbsp;&nbsp;n/a';
							}
						}
						if (isset($dob_np) && isset($dob_en)) {
							if ($dob_np == '0000-00-00' && $dob_en == '0000-00-00') {
								echo 'n/a';
							}
						}


						?></td>
				</tr>
				<tr>
					<td><label>Gender :</label></td>
					<td width="24%"><?php if (isset($gender)) echo '&nbsp;&nbsp;' . $gender; ?></td>
					<td width="8%">&nbsp;</td>
					<td width="21%"><label>Age :</label></td>
					<td width="21%"><?php if (isset($age) && $age != 0) {
							echo '&nbsp;&nbsp;' . $age . ' yrs';
						} else {
							echo 'n/a';
						} ?></td>
				</tr>
				<tr>
					<td><label>Ethnicity :</label></td>
					<td width="24%"><?php if (isset($caste_ethnicity_value)) echo '&nbsp;&nbsp;' . $caste_ethnicity_value; ?></td>
					<td width="8%">&nbsp;</td>
				</tr>
				<tr>
					<td><label>Permanent Address :</label></td>
					<td><?php if (isset($p_address)) echo '&nbsp;&nbsp;' . $p_address; ?></td>
					<td>&nbsp;</td>
					<td><label>Contact Address :</label></td>
					<td><?php if (isset($c_address)) echo '&nbsp;&nbsp;' . $c_address; ?></td>
				</tr>
				<tr>
					<td><label>Land Line :</label></td>
					<td><?php if (isset($phone)) echo '&nbsp;&nbsp;' . $phone; ?></td>
					<td>&nbsp;</td>
					<td><label>Mobile No :</label></td>
					<td><?php if (isset($mobile)) echo '&nbsp;&nbsp;' . $mobile; ?></td>
				</tr>
				<tr>
					<td><label>Email :</label></td>
					<td colspan="4"><?php if (isset($email)) echo '&nbsp;&nbsp;' . $email; ?></td>
				</tr>
			</table>
			<p>&nbsp;</p>
		</div>

		<div class="span3">
			<?php if (isset($photo) && (strpos($photo, 'image_') !== false)) { ?>

				<img src="../gallery/thumbs/<?php echo $photo; ?>" style="margin-bottom:10px;"/>
				<!-- <br/> <a href="../gallery/<?php echo $photo; ?>">View full size</a>-->

			<?php } else { ?>
				<img src="../img/no_image.gif" height="134px" width="100px" style="margin-bottom:10px;"/>
			<?php } ?>
		</div>
	</div>
	<div class="row">
		<div class="span12">
			<h4 class="nicecolor nicefont">Organizational information</h4>
			<table class="text-info">
				<tr>
					<td width="120px"><label>Org Name : </label></td>
					<td colspan="3"><?php if (isset($org_name)) echo $org_name; ?></td>
				</tr>
				<tr>
					<td><label>Org Address : </label></td>
					<td colspan="3"><?php if (isset($org_address)) echo $org_address; ?></td>
				</tr>
				<tr>
					<td><label>Position : </label></td>
					<td colspan="3"><?php if (isset($position)) echo $position; ?></td>
				</tr>
				<tr>
					<td><label>Phone :</label></td>
					<td width="200px"><?php if (isset($org_phone)) echo $org_phone; ?></td>
					<td><label>Fax : </label></td>
					<td><?php if (isset($org_fax)) echo ' ' . $org_fax; ?> </td>
				</tr>
				<tr>
					<td><label>status : </label></td>
					<td colspan="3"><?php if (isset($current_status) && isset($updated_date)) echo $current_status . ' as of date ' . date("Y-m-d", strtotime($updated_date)); ?></td>
				</tr>

			</table>
		</div>
	</div>

	<!--
        <table width="100%" border="0" cellspacing="0" cellpadding="5" class="dataListing" >
            <tr>
                <th align="center" width="20%">Name</th>
                <th align="center" width="15%">Date of birth</th>
                <th align="center" width="20%">Mobile</th>
                <th width="20%" align="center">Org name</th>
                <th width="15%" align="center">Org fax</th>
                <th width="10%" align="center">Position</th>
            </tr>
            <tr class="whiteTd" >
                <td align="center"><p class="text-error"><?php if (isset($fullname)) echo $title . " " . $fullname; ?> </p></td>
                <td align="center">
                    <p class="text-info">
                        <?php
	if (isset($dob)) {
		if ($dob != '0000-00-00') {
			echo $dob;
		} else {
			echo 'n/a';
		}
	}
	?>
                    </p>
                </td>
                <td align="center"><p class="text-info"><?php if (isset($mobile)) echo $mobile; ?></p></td>

                <td align="center"><p class="text-info"><?php if (isset($org_name)) echo $org_name; ?></p></td>
                <td align="center"><p class="text-info"><?php if (isset($org_fax)) echo $org_fax; ?> </td>
                <td align="center"><p class="text-info"><?php if (isset($position)) echo $position; ?></p></td>
            </tr>
            <tr>
                <th>Permanent address</th>
                <th>Age</th>
                <th>Phone</th>
                <th>Org. address</th>
                <th>Country</th>
                <th>Current status</th>
            </tr>
            <tr class="whiteTd" >
                <td align="center"><p class="text-info"><?php if (isset($p_address)) echo $p_address; ?></p></td>
                <td align="center"><p class="text-info"><?php if (isset($age)) echo $age; ?></p></td>
                <td align="center" ><p class="text-info"><?php if (isset($phone)) echo $phone; ?></p></td>
                <td align="center"><p class="text-info"><?php if (isset($org_address)) echo $org_address; ?></p></td>
                <td align="center"> <p class="text-info"><?php if (isset($country)) echo $country; ?></p></td>
                <td align="center"><p class="text-info"><?php if (isset($current_status)) echo $current_status; ?></p></td>
            </tr>
            <tr>
                <th  >Contact address</th>
                <th  >Gender</th>
                <th  >Email</th>
                <th >Org. phone</th>
                <th >&nbsp;</th>
                <th >&nbsp;</th>
            </tr>
            <tr class="whiteTd" >
                <td align="center"><p class="text-info"><?php if (isset($c_address)) echo $c_address; ?></p></td>
                <td align="center"><p class="text-info"><?php if (isset($gender)) echo $gender; ?></p></td>
                <td align="center"><p class="text-info"><?php if (isset($email)) echo $email; ?></p></td>
                <td align="center"><p class="text-info"><?php if (isset($org_phone)) echo $org_phone; ?></p></td>
                <td align="center"></td>
                <td align="center"></td>
            </tr>
        </table
-->

	<br/>
	<br/>
	<h4 class="nicecolor">Participated in : </h4>
	<?php
	if (isset($action) && $action !== null) {
		echo '<div class="message-error">
         <p class="text-warning"><b>Warning : Associated data found !</b></p>
         <span class="text-info size11"><b>Information :</b><br />To delete this person\'s record, please unselect him from the following events and try to delete again.<br />
         Unselecting data will remove all paticipation information which can\'t be undone. Please make sure you really want to delete this person\'s record and proceed.</span>
  
        </div><br />';
	}
	?>

	<table class="dataListing" width="700px" cellspacing="0" cellpadding="5" border="0">
		<tbody>
		<tr>
			<th width="5%" align="center">#</th>
			<th width="30%" align="left">Event</th>
			<th width="15%" align="left">Role</th>
			<th width="15%" align="left">Beneficiary Type</th>
			<th width="7%" align="left">year</th>
			<th width="10%" align="left">Start date</th>
			<th width="10%" align="left">End date</th>
			<th width="23%" align="left">Venue</th>
			<?php
			if (isset($action) && $action !== null) {
				echo '<th style="width:60px" align="left">Action</th>';
			}
			?>
		</tr>

		<?php
		
		for ($i = 0; $i < count($participation); $i++) {
			// echo ' <tr id="row'.$person_id.'_'.$participation[$i][6].'">';
			echo "<tr id='participant_row_" . $participation[$i][7] . "'>";
			echo ' <td align="center">' . ($i + 1) . '</td>';
			echo ' <td align="left"><a href="../Event/viewEvent?id=' . $participation[$i][6] . '">' . $participation[$i][0] . '<a></td>';
			echo '<td align="left">' . $participation[$i][1] . '</td>';
			echo '<td align="left">' . $participation[$i][8] . '</td>';
			echo '<td align="left">' . $participation[$i][2] . '</td>';

			echo '<td align="left">' . $participation[$i][3] . '</td>';
			echo '<td align="left">' . $participation[$i][4] . '</td>';
			echo '<td align="left">' . $participation[$i][5] . '</td>';
			if (isset($action) && $action !== null) {
				//  echo '<td  align="left"><a id="unselectcandidate_'.$person_id.'_'.$participation[$i][6].'" class="text-error handcursor">unselect</a></td>';
				echo '<td  align="left"><a class= "text-error handcursor" id="unselectcandidate_' . $participation[$i][7] . '">unselect</a></td>';
			}
			echo '</tr>';
		}
		?>

		</tbody>
	</table>


	<?php /*




          <table border="0" width="100%" class="table event_detail_table">
          <tr>
          <td  class="title"><b><p class="text-error"> Name : </p></b></td>
          <td ><p class="text-error"><?php if (isset($fullname)) echo $title." ".$fullname; ?> </p></td>
          </tr>
          <tr>
          <td class="title"><b><p class="text-info">Date of birth : </p></b></td>
          <td><p class="text-info"><?php if (isset($dob)) echo $dob; ?></p></td>
          </tr>
          <tr>
          <td class="title"><b><p class="text-info">Age :</p></b></td>
          <td><p class="text-info"><?php if (isset($age)) echo $age; ?></p></td>
          </tr>
          <tr>
          <td  class="title"><b><p class="text-info"> Gender : </p></b></td>
          <td ><p class="text-info"><?php if (isset($gender)) echo $gender; ?></p></td>
          </tr>
          <tr>
          <td  class="title"><b><p class="text-info"> Permanent address : </p></b></td>
          <td ><p class="text-info"><?php if (isset($p_address)) echo $p_address; ?></p></td>
          </tr>
          <tr>
          <td class="title"><b><p class="text-info">Contact address:</p></b> </td>
          <td><p class="text-info"><?php if (isset($c_address)) echo $c_address; ?></p></td>
          </tr>
          <tr>
          <td class="title"><b><p class="text-info" > Photo :</p></b></td>
          <td><p class="text-info"><?php if (isset($photo)) echo $photo; ?></p></td>
          </tr>
          <tr>
          <td class="title"><b><p class="text-info"> Country :</p></b></td>
          <td><p class="text-info"><?php if (isset($country)) echo $country; ?></p></td>
          </tr>
          <tr>
          <td class="title"><b><p class="text-info">Phone : </p></b></td>
          <td><p class="text-info"><?php if (isset($phone)) echo $phone; ?></p></td>
          </tr>
          <tr>
          <td class="title"><b><p class="text-info">Mobile:</p></b> </td>
          <td><p class="text-info"><?php if (isset($mobile)) echo $mobile; ?></p></td>
          </tr>
          <tr>
          <td class="title"><b><p class="text-info"> Email :</p></b></td>
          <td><p class="text-info"><?php if (isset($email)) echo $email; ?></p></td>
          </tr>
          <tr>
          <td class="title"><b><p class="text-info" > Org. name :</p></b></td>
          <td><p class="text-info"><?php if (isset($org_name)) echo $org_name; ?></p></td>
          </tr>
          <tr>
          <td  class="title"><b><p class="text-info"> Org. address : </p></b></td>
          <td ><p class="text-info"><?php if (isset($org_address)) echo $org_address; ?></p></td>
          </tr>
          <tr>
          <td class="title"><b><p class="text-info">Org. phone:</p></b> </td>
          <td><p class="text-info"><?php if (isset($org_phone)) echo $org_phone; ?></p></td>
          </tr>
          <tr>
          <td class="title"><b><p class="text-info" > Org. fax :</p></b></td>
          <td><p class="text-info"><?php if (isset($org_fax)) echo $org_fax; ?></p></td>
          </tr>
          <tr>
          <td class="title"><b><p class="text-info"> Position :</p></b></td>
          <td><p class="text-info"><?php if (isset($position)) echo $position; ?></p></td>
          </tr>
          <tr>
          <td class="title"><b><p class="text-info">Current status : </p></b></td>
          <td><p class="text-info"><?php if (isset($current_status)) echo $current_status; ?></p></td>
          </tr>
          <tr>
          <td colspan="2">
          <a href="../PersonController/editPerson?id=<?php echo $person_id;?>"><button class="btn btn-info" id="personMgmt_edit_<?php echo $person_id;?>"><span class="icon-trash icon-pencil"></span>&nbsp;Edit</button></a>
          &nbsp;<a href="../PersonController/deletePerson?id=<?php echo $person_id;?>" onClick="return window.confirm('Are you sure want to delete');"><button class="btn btn-danger" id="eventMgmt_del_<?php echo $person_id;?>"><span class="icon-trash icon-white"></span>&nbsp;Delete</button></a>

          </td>

          </tr>


          </table>

         */
	?>
	</td>
	</tr>
	</table>
</div> <!-- end of container tag-->

