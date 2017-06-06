<?php echo form_open_multipart('Event/editParticipationSave_async', array('id' => 'edit_participation_form', 'name' => 'edit_candidate_form')); ?>
<input type="hidden" name="person_id" value="<?= $person_id ?>">
<input type="hidden" name="event_id" value="<?= $event_id ?>">
<input type="hidden" name="participated_in_id" value="<?= $participated_in_id ?>">
<a href="../Person/edit?id=<?=$person_id?>">Edit Person Details</a>

<hr/>
<h3><b>Participation Details:</b></h3>
<?php echo validation_errors(); ?>
<span style="color:green"><?php if (isset($insert)) echo $insert . '<br /> '; ?></span>
<hr/>
<label>Participated As:</label>
<select name="is_instructor" id="is_instructor">
	<option value="">-- SELECT --</option>
	<?php
	if (isset($participationTypeSelect)) {
		echo $participationTypeSelect;
	}
	?>
</select>
<br/>
<label>Beneficiary Type</label>
<select name="beneficiary_type" id="beneficiary_type">
	<option value="">-- SELECT --</option>
	<?php
	if (isset($beneficiaryTypeSelect)) {
		echo $beneficiaryTypeSelect;
	}
	?>
</select>
<br/>
<label>Certification Status</label>
<select name="certification_status" id="certification_status">
	<option value="">-- SELECT --</option>
	<?php
	if (isset($certificationStatusSelect)) {
		echo $certificationStatusSelect;
	}
	?>
</select>
</form>


<script>
	var root = '../';
	// process the form
	$('form#edit_participation_form').submit(function (event) {
		event.preventDefault();
		// get the form data
		// there are many ways to get this data using jQuery (you can use the class or id also)
		var $form = $('form#edit_participation_form');

		var formData = $form.serializeArray();

		var nameValue = {};
		$.each(formData, function (i, field) {
			nameValue[field.name] = field.value;
		});

//{"identifier":"update",
// "person_id":"24",
// "person_title":"Mr.",
// "person_name":"Ram Shrestha",
// "person_citizenship_no":"912t38","person_dob_np":"2046-06-13","person_dob_en":"1989-09-29","person_gender":"Male","person_caste_ethnicity":"1",
// "person_paddress":"Panauti-3, Kavre","person_caddress":"Shuritinagar, Bagdol, Lalitpur","person_country":"np","person_phone":"01 144 1188","person_mobile":"(980) 383-1000",
// "person_email":"ramshrestha@nset.org.np","person_org_name":"NSET","person_org_address":"Sainbu-4, Bhaisepati, Lalitpur","person_org_phone":"01 551 0000","person_org_fax":"31231","person_position":"Geomatics Engineer","person_current_status":"Active","education":"","dropdownindex":"","work_type_id":"2"}


		// process the form
		$.ajax({
				type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url: $form.attr("action"),
				data: $form.serialize(), // our data object
				//dataType: 'json', // what type of data do we expect back from the server
				//encode: true
			})
			// using the done promise callback
			.done(function (data) {
				var dtBase = $form.data('dtBase');
				var person_id = $form.data('person_id');


				$('tr#participant_row_' + person_id).html(data);

				$("#editCandidateForm").dialog('close');
				// here we will handle errors and validation messages
			}).fail(function (jqXHR, textStatus, errorThrown) {
			alert('error');
			alert(JSON.stringify(jqXHR));
		});
	});

</script>


