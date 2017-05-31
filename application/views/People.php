<style type="text/css">
	input[type='text'], select, input[type='checkbox'] {
		margin-bottom: 2px;
		margin-top: 2px;
	}

	label {
		color: #2f96b4;
	}

	.txt-err {
		color: #e9322d;
	}
</style>
<script type="text/javascript">
	$(document).ready(function () {
		//        $('#person_photo').click(function(){
		//            alert($('#person_photo').val());
		//        })
		//

		$(window).keydown(function (event) {
			if (event.keyCode == 13) {
				event.preventDefault();

				$('#person_availability_btn').click();
				setTimeout(callresult, 500);
				return false;
				// $('#person_availability_btn').click();

			}
		});
	});

	function callresult() {
		//alert('hello');
		location.href = '#results';
	}
</script>
<div class="container">

	<table style="border:1px solid #CCC;margin-top:30px" width="100%" class="getBg">
		<tr>
			<td style="padding:20px">

				<?php
				if (isset($event_title)) {
					echo '<div class="message-info">';
					echo '<span class="nicefont size16">Event title :</span> <a class="text-success nicefont size16 uppercase" href="../Event/viewEvent?id=' . $event_id . '">' . $event_title . '</a><br/>';
					echo '</div>';
				}
				?>
				<hr/>
				<h5 class="inline-block">Add new participants </h5>


				<!--tr>
					   <td colspan="2" align="right" style="border:none"-->
				<a href="../Event/budgetEntry?id=<?= $event_id ?>" class="btn text-success"
				   style="bottom:5px;float:right;" id=""><img src="../img/edit.png"/>&nbsp;Edit budget entry</a>
				<!--/td>
			</tr-->

				<div class="clear"></div>

				<?php echo validation_errors(); ?>
				<span style="color:green"><?php if (isset($insert)) echo $insert; ?></span> <br/>
				<?php
				echo form_open_multipart('Person/addPerson', array('id' => 'people_entry_form', 'name' => 'people_entry_form'));
				?>

				<input type="hidden" name="identifier" value="insert"/>
				<input type="hidden" name="repeat_page" value="1"/>
				<input type="hidden" id="event_title" name="event_title" value="<?php echo $event_title; ?>"/>
				<input type="hidden" id="event_id" name="event_id" value="<?php echo $event_id; ?>"/>

				<table width="100%" border="0">
					<tr class="message-info ">
						<!--------------------this is just test -->
						<td colspan="2">
							<div style="float:left">&nbsp;
								<span class="nicecolor"> Name* : </span>
								<?php
								echo form_input(array('name' => 'person_name', 'id' => 'person_name', 'placeholder' => 'Enter name', 'class' => 'required', 'minlength' => 2, 'maxlength' => 60, 'style' => 'width:140px'));
								?>
							</div>

							<div style="float:left">&nbsp;
								<span class="nicecolor"> Citizenship No : </span>
								<?php
								echo form_input(array('name' => 'person_citizenship_no', 'id' => 'person_citizenship_no', 'placeholder' => 'Citizenship No', 'minlength' => 2, 'maxlength' => 60, 'style' => 'width:140px'));
								?>
							</div>
							<div style="float:left">

								&nbsp; |
								<span class="nicecolor"> DOB(np) : </span>
								<!--input type="text" name="person_dob_np"  id="person_dob_np" class="nepali-calendar" placeholder="Enter date of birth" style="width:120px"/-->
								<input type="text" name="person_dob_np" id="person_dob_np" placeholder="DOB"
									   style="width:70px"/>
								&nbsp; |
								<span class="nicecolor"> DOB(en) : </span>
								<input type="text" name="person_dob_en" id="person_dob_en" placeholder="DOB"
									   style="width:70px"/>
								&nbsp; |
								<span class="nicecolor"> Age : </span>
								<input type="number" name="age" id="person_age" placeholder="Age"
									   style="width:70px"/>
								&nbsp; |
								<span class="nicecolor">  Mobile : </span>
								<input type="text" id="person_mobile" name="person_mobile"
									   placeholder="Enter mobile no." style="width:110px"/>
								&nbsp; |
								<span class="nicecolor">Phone : </span>
								<input type="text" id="person_phone" name="person_phone" placeholder="Enter phone no."
									   style="width:110px"/>
								&nbsp; |
								<a id="person_availability_btn" href="#results" class="btn">Check availability </a>
							</div>
						</td>

						<!--------------------end this is just test -->
					</tr>
					<tr id="person_tablebody" class="" style="display:none;border:none">
						<td style="padding-top:20px;vertical-align: top">
							<table border="0">

								<tr>

									<td style="padding-right:30px;"><label>Title</label></td>
									<td>
										<select name="person_title" id="person_title">
											<option value="Mr.">Mr.</option>
											<option value="Ms.">Ms.</option>
											<option value="Dr.">Dr.</option>
											<option value="Er.">Er.</option>
											<option value="Prof.">Prof.</option>
										</select>
									</td>
								</tr>

								<!--tr>
                                    <td><label>Full name*</label> </td>
                                    <td>
                                <?php
								echo form_input(array('name' => 'person_name', 'placeholder' => 'Enter name1', 'class' => 'required', 'minlength' => 2, 'maxlength' => 60));
								?>
                                    </td>


                                </tr>rth

                                <tr>
                                    <td><label>Date of birth*</label> </td>
                                    <td>
                                        <input type="text" class="datepicker" name="person_dob"  class="required" placeholder="Enter date of birth" value="1980-01-01">
                                 </tr-->
								<!--<tr>
									<td><label>Citizenship No*</label> </td>
									<td><input type="text" name="person_citizenship_no"  placeholder="Enter Citizenship No" /> </td>
								</tr>-->
								<tr>
									<td><label>Gender*</label></td>
									<td><select name="person_gender" id="person_gender">
											<option value="Male">Male</option>
											<option value="Female">Female</option>
											<option value="Other">Other</option>
										</select></td>
								</tr>

								<tr>
									<td><label>Caste/Ethnicity</label></td>
									<td><select name="person_caste_ethnicity" id="person_caste_ethnicity">
											<option value="">-- SELECT --</option>
											<option value="1">Newar</option>
											<option value="2">Janajati</option>
											<option value="3">Bahun/Chhetri</option>
											<option value="4">Muslim</option>
											<option value="5">Dalit</option>
											<option value="6">Other</option>
										</select></td>
								</tr>

								<tr>
									<td style="padding-right:10px"><label>Permanent address</label></td>
									<td><input type="text" id="person_paddress" name="person_paddress"
											   placeholder="Enter permanent address"/></td>
								</tr>
								<tr>
									<td><label>Contact address</label></td>
									<td><input type="text" id="person_caddress" name="person_caddress"
											   placeholder="Enter contact address"/></td>
								</tr>
								<tr>
									<td><label>Choose a photo</label></td>
									<td>
										<?php //echo form_upload('userfile'); ?>
										<input type="file" value="" name="userfile" id="person_photo">
										<!--button class="btn" > +Add picture </button-->
										<!--input type="file" name="person_photo" placeholder="Select photo"/-->
									</td>
								</tr>
								<tr>
									<td><label>Country</label></td>
									<td><select id="person_country" name="person_country">
											<option value="">Select one</option>
											<option value="af">Afghanistan</option>
											<option value="ax">Aland Islands</option>
											<option value="al">Albania</option>
											<option value="dz">Algeria</option>
											<option value="as">American Samoa</option>
											<option value="ad">Andorra</option>
											<option value="ao">Angola</option>
											<option value="ai">Anguilla</option>
											<option value="aq">Antarctica</option>
											<option value="ag">Antigua and Barbuda</option>
											<option value="ar">Argentina</option>
											<option value="am">Armenia</option>
											<option value="aw">Aruba</option>
											<option value="au">Australia</option>
											<option value="at">Austria</option>
											<option value="az">Azerbaijan</option>
											<option value="bs">Bahamas</option>
											<option value="bh">Bahrain</option>
											<option value="bd">Bangladesh</option>
											<option value="bb">Barbados</option>
											<option value="by">Belarus</option>
											<option value="be">Belgium</option>
											<option value="bz">Belize</option>
											<option value="bj">Benin</option>
											<option value="bm">Bermuda</option>
											<option value="bt">Bhutan</option>
											<option value="bo">Bolivia</option>
											<option value="ba">Bosnia and Herzegovina</option>
											<option value="bw">Botswana</option>
											<option value="bv">Bouvet Island</option>
											<option value="br">Brazil</option>
											<option value="io">British Indian Ocean Territory</option>
											<option value="vg">British Virgin Islands</option>
											<option value="bn">Brunei</option>
											<option value="bg">Bulgaria</option>
											<option value="bf">Burkina Faso</option>
											<option value="bi">Burundi</option>
											<option value="kh">Cambodia</option>
											<option value="cm">Cameroon</option>
											<option value="ca">Canada</option>
											<option value="cv">Cape Verde</option>
											<option value="ky">Cayman Islands</option>
											<option value="cf">Central African Republic</option>
											<option value="td">Chad</option>
											<option value="cl">Chile</option>
											<option value="cn">China</option>
											<option value="cx">Christmas Island</option>
											<option value="cc">Cocos (Keeling) Islands</option>
											<option value="co">Colombia</option>
											<option value="km">Comoros</option>
											<option value="cg">Congo</option>
											<option value="ck">Cook Islands</option>
											<option value="cr">Costa Rica</option>
											<option value="hr">Croatia</option>
											<option value="cu">Cuba</option>
											<option value="cy">Cyprus</option>
											<option value="cz">Czech Republic</option>
											<option value="cd">Democratic Republic of Congo</option>
											<option value="dk">Denmark</option>
											<option value="xx">Disputed Territory</option>
											<option value="dj">Djibouti</option>
											<option value="dm">Dominica</option>
											<option value="do">Dominican Republic</option>
											<option value="tl">East Timor</option>
											<option value="ec">Ecuador</option>
											<option value="eg">Egypt</option>
											<option value="sv">El Salvador</option>
											<option value="gq">Equatorial Guinea</option>
											<option value="er">Eritrea</option>
											<option value="ee">Estonia</option>
											<option value="et">Ethiopia</option>
											<option value="fk">Falkland Islands</option>
											<option value="fo">Faroe Islands</option>
											<option value="fm">Federated States of Micronesia</option>
											<option value="fj">Fiji</option>
											<option value="fi">Finland</option>
											<option value="fr">France</option>
											<option value="gf">French Guyana</option>
											<option value="pf">French Polynesia</option>
											<option value="tf">French Southern Territories</option>
											<option value="ga">Gabon</option>
											<option value="gm">Gambia</option>
											<option value="ge">Georgia</option>
											<option value="de">Germany</option>
											<option value="gh">Ghana</option>
											<option value="gi">Gibraltar</option>
											<option value="gr">Greece</option>
											<option value="gl">Greenland</option>
											<option value="gd">Grenada</option>
											<option value="gp">Guadeloupe</option>
											<option value="gu">Guam</option>
											<option value="gt">Guatemala</option>
											<option value="gn">Guinea</option>
											<option value="gw">Guinea-Bissau</option>
											<option value="gy">Guyana</option>
											<option value="ht">Haiti</option>
											<option value="hm">Heard Island and Mcdonald Islands</option>
											<option value="hn">Honduras</option>
											<option value="hk">Hong Kong</option>
											<option value="hu">Hungary</option>
											<option value="is">Iceland</option>
											<option value="in">India</option>
											<option value="id">Indonesia</option>
											<option value="ir">Iran</option>
											<option value="iq">Iraq</option>
											<option value="xe">Iraq-Saudi Arabia Neutral Zone</option>
											<option value="ie">Ireland</option>
											<option value="il">Israel</option>
											<option value="it">Italy</option>
											<option value="ci">Ivory Coast</option>
											<option value="jm">Jamaica</option>
											<option value="jp">Japan</option>
											<option value="jo">Jordan</option>
											<option value="kz">Kazakhstan</option>
											<option value="ke">Kenya</option>
											<option value="ki">Kiribati</option>
											<option value="kw">Kuwait</option>
											<option value="kg">Kyrgyzstan</option>
											<option value="la">Laos</option>
											<option value="lv">Latvia</option>
											<option value="lb">Lebanon</option>
											<option value="ls">Lesotho</option>
											<option value="lr">Liberia</option>
											<option value="ly">Libya</option>
											<option value="li">Liechtenstein</option>
											<option value="lt">Lithuania</option>
											<option value="lu">Luxembourg</option>
											<option value="mo">Macau</option>
											<option value="mk">Macedonia</option>
											<option value="mg">Madagascar</option>
											<option value="mw">Malawi</option>
											<option value="my">Malaysia</option>
											<option value="mv">Maldives</option>
											<option value="ml">Mali</option>
											<option value="mt">Malta</option>
											<option value="mh">Marshall Islands</option>
											<option value="mq">Martinique</option>
											<option value="mr">Mauritania</option>
											<option value="mu">Mauritius</option>
											<option value="yt">Mayotte</option>
											<option value="mx">Mexico</option>
											<option value="md">Moldova</option>
											<option value="mc">Monaco</option>
											<option value="mn">Mongolia</option>
											<option value="ms">Montserrat</option>
											<option value="ma">Morocco</option>
											<option value="mz">Mozambique</option>
											<option value="mm">Myanmar</option>
											<option value="na">Namibia</option>
											<option value="nr">Nauru</option>
											<option value="np" SELECTED>Nepal</option>
											<option value="nl">Netherlands</option>
											<option value="an">Netherlands Antilles</option>
											<option value="nc">New Caledonia</option>
											<option value="nz">New Zealand</option>
											<option value="ni">Nicaragua</option>
											<option value="ne">Niger</option>
											<option value="ng">Nigeria</option>
											<option value="nu">Niue</option>
											<option value="nf">Norfolk Island</option>
											<option value="kp">North Korea</option>
											<option value="mp">Northern Mariana Islands</option>
											<option value="no">Norway</option>
											<option value="om">Oman</option>
											<option value="pk">Pakistan</option>
											<option value="pw">Palau</option>
											<option value="ps">Palestinian Territories</option>
											<option value="pa">Panama</option>
											<option value="pg">Papua New Guinea</option>
											<option value="py">Paraguay</option>
											<option value="pe">Peru</option>
											<option value="ph">Philippines</option>
											<option value="pn">Pitcairn Islands</option>
											<option value="pl">Poland</option>
											<option value="pt">Portugal</option>
											<option value="pr">Puerto Rico</option>
											<option value="qa">Qatar</option>
											<option value="re">Reunion</option>
											<option value="ro">Romania</option>
											<option value="ru">Russia</option>
											<option value="rw">Rwanda</option>
											<option value="sh">Saint Helena and Dependencies</option>
											<option value="kn">Saint Kitts and Nevis</option>
											<option value="lc">Saint Lucia</option>
											<option value="pm">Saint Pierre and Miquelon</option>
											<option value="vc">Saint Vincent and the Grenadines</option>
											<option value="ws">Samoa</option>
											<option value="sm">San Marino</option>
											<option value="st">Sao Tome and Principe</option>
											<option value="sa">Saudi Arabia</option>
											<option value="sn">Senegal</option>
											<option value="sc">Seychelles</option>
											<option value="sl">Sierra Leone</option>
											<option value="sg">Singapore</option>
											<option value="sk">Slovakia</option>
											<option value="si">Slovenia</option>
											<option value="sb">Solomon Islands</option>
											<option value="so">Somalia</option>
											<option value="za">South Africa</option>
											<option value="gs">South Georgia and South Sandwich Islands</option>
											<option value="kr">South Korea</option>
											<option value="es">Spain</option>
											<option value="pi">Spratly Islands</option>
											<option value="lk">Sri Lanka</option>
											<option value="sd">Sudan</option>
											<option value="sr">Suriname</option>
											<option value="sj">Svalbard and Jan Mayen</option>
											<option value="sz">Swaziland</option>
											<option value="se">Sweden</option>
											<option value="ch">Switzerland</option>
											<option value="sy">Syria</option>
											<option value="tw">Taiwan</option>
											<option value="tj">Tajikistan</option>
											<option value="tz">Tanzania</option>
											<option value="th">Thailand</option>
											<option value="tg">Togo</option>
											<option value="tk">Tokelau</option>
											<option value="to">Tonga</option>
											<option value="tt">Trinidad and Tobago</option>
											<option value="tn">Tunisia</option>
											<option value="tr">Turkey</option>
											<option value="tm">Turkmenistan</option>
											<option value="tc">Turks And Caicos Islands</option>
											<option value="tv">Tuvalu</option>
											<option value="ug">Uganda</option>
											<option value="ua">Ukraine</option>
											<option value="ae">United Arab Emirates</option>
											<option value="uk">United Kingdom</option>
											<option value="us">United States</option>
											<option value="um">United States Minor Outlying Islands</option>
											<option value="uy">Uruguay</option>
											<option value="vi">US Virgin Islands</option>
											<option value="uz">Uzbekistan</option>
											<option value="vu">Vanuatu</option>
											<option value="va">Vatican City</option>
											<option value="ve">Venezuela</option>
											<option value="vn">Vietnam</option>
											<option value="wf">Wallis and Futuna</option>
											<option value="eh">Western Sahara</option>
											<option value="ye">Yemen</option>
											<option value="zm">Zambia</option>
											<option value="zw">Zimbabwe</option>
											<option value="rs">Serbia</option>
											<option value="me">Montenegro</option>

										</select>
									</td>
								</tr>
								<!--tr>
									<td><label>Phone</label> </td>
									<td><input type="text" id="person_phone" name="person_phone" placeholder="Enter phone number"/> </td>
								</tr-->

								<tr>
									<td></td>
									<td style="min-height:100px" id="person_image"></td>
								</tr>
								<tr>
									<td colspan="2">
										<div id="reset_message">
											<br/>
											<br/>
											<p class="text-error" id="participant_note" style="display:none">#Note:<i>
													To insert new record, press reset.</i></p>
										</div>
									</td>
								</tr>
							</table>

						</td>
						<td style="padding-top:20px;vertical-align: top">
							<table border="0">
								<tr>
									<td><label>Email</label></td>
									<td><input type="text" id="person_email" name="person_email"
											   placeholder="Enter email"/></td>
								</tr>
								<tr>
									<td><label>Organization name</label></td>
									<td><input type="text" id="person_org_name" name="person_org_name"
											   placeholder="Enter org. name"/></td>
								</tr>
								<tr>
									<td style="padding-right:10px"><label>Organization address</label></td>
									<td><input type="text" id="person_org_address" name="person_org_address"
											   placeholder="Enter org. address"/></td>
								</tr>
								<tr>
									<td><label>Organization phone</label></td>
									<td><input type="text" id="person_org_phone" name="person_org_phone"
											   placeholder="Enter org. phone"/></td>
								</tr>
								<tr>
									<td><label>Organization fax</label></td>
									<td><input type="text" id="person_org_fax" name="person_org_fax"
											   placeholder="Enter org. fax"/></td>
								</tr>
								<tr>
									<td><label>Position</label></td>
									<td><input type="text" id="person_position" name="person_position"
											   id="person_position" placeholder="Enter position"/></td>
								</tr>
								<tr>
									<td><label>Current status</label></td>
									<td><select name="person_current_status" id="person_current_status">
											<option value="">-- SELECT --</option>
											<option value="Active" SELECTED>Active</option>
											<option value="Retired">Retired</option>
											<option value="Migrated within country">Migrated within country</option>
											<option value="Migrated outside country">Migrated outside country</option>
											<option value="Dead">Dead</option>
										</select></td>
								</tr>


								<tr>
									<td><label>Beneficiary Type</label></td>
									<td>
										<select name="beneficiary_type" id="beneficiary_type">
											<option value="">-- SELECT --</option>
											<?php
											if (isset($beneficiaryTypeSelect)) {
												echo $beneficiaryTypeSelect;
											}
											?>
										</select>
									</td>
								</tr>

								<tr>
									<td><label>Certification Status</label></td>
									<td><select name="certification_status" id="certification_status">
										<option value="">-- SELECT --</option>
										<?php
										if (isset($certificationStatusSelect)) {
											echo $certificationStatusSelect;
										}
										?>
									</select>
									<td>
								</tr>

								<tr>
									<td><label>Education Level</label></td>
									<td><select name="education_level" id="education_level">
											<option value="">-- SELECT --</option>
											<?php
											if (isset($educationLevelSelect)) {
												echo $educationLevelSelect;
											}
											?>
										</select>
									</td>
								</tr>

								<!--   START:    Profession/Ocupation:  work_type                          -->
								<!--<tr>
									<td style="width:180px;height:50px"><label>Profession/Occupation : </label></td>
									<td style="width:420px">
										<input type="hidden" name="dropdownindex" id="dropdownindex">
                            <span id="hiddenspan_existing_work_type" style="">
                                <span id="hiddenspan_work_type">
									<select name="work_type_id" id="work_type_id">
										<option value="">-- SELECT --</option>
										<?php
/*										if (isset($WorkTypeSelect)) {
											echo $WorkTypeSelect;
										}
										*/?>
									</select>
                                </span>
                                <input type="button" id="work_type_btn_add_new" class="btn" value="+ Add new"
									   style="margin-top: -10px">
                            </span>

                            <span id="hiddenspan_add_new_work_type" style="display: none;">
                                <input type="text" id="work_type_txt_add_new" placeholder="Enter new work type"
									   required="required">
                                <button class="btn btn-info" onclick="return false;" style="margin-top: -10px"
										id="work_type_btn_add">Add
								</button>
                                <img src="../img/loading.gif" style="margin-top: -10px; padding:5px;display:none"
									 id="loading_image">
                                <input type="button" id="work_type_btn_cancel" class="btn" value="Cancel"
									   style="margin-top: -10px">
                            </span>
									</td>
									<td rowspan="2" style="padding-left:10px;vertical-align: top">
										<div id="work_type_div_progress"
											 style="padding:10px;border:1px solid #ccc;border-radius:5px;display:none">

										</div>
									</td>
								</tr>-->
								<!-- 			END::  Profession:  work_type 					-->



								<tr>
									<td><label>Occupation</label></td>
									<td>
                                        <select name="work_type_id" id="work_type_id">
                                            <option value="">-- SELECT --</option>
                                            <?php
                                            if (isset($WorkTypeSelect)) {
                                                echo $WorkTypeSelect;
                                            }
                                            ?>
                                        </select>
                                    </td>
								</tr>

								<tr>
									<td><label>Experience(in Years)</label></td>
									<td><input type="number" id="person_work_experience_years" name="person_work_experience_years"
											   placeholder="Work Experience (In Years)"/></td>
								</tr>


								<tr>
									<td colspan="2">

										<table style="margin-top:10px">
											<tr>
												<td>
													<div id="instructor_selection">
														<h5>Please select:</h5>
														<hr style="margin:5px;"/>

														<input type="radio" id="person_participant"
															   name="participant_type" checked value="0"/> &nbsp;<label
															for="person_participant" style="display:inline-block">Participant</label>
														&nbsp;&nbsp; | &nbsp;&nbsp;
														<input type="radio" id="person_inst" name="participant_type"
															   value="1"/> &nbsp;<label for="person_inst"
																						style="display:inline-block">Instructor</label>
														&nbsp;&nbsp; | &nbsp;&nbsp;
														<input type="radio" value="2" id="person_asstinst"
															   name="participant_type"/> &nbsp;<label
															for="person_asstinst" style="display:inline-block">Asst.
															Instructor</label>
													</div>
												</td>
											</tr>
										</table>

									</td>
								</tr>
								<tr>

									<td colspan="2" align="right">
										<br/>
										<br/>

                                        <span style="float:right">
                                            <input type="submit" class="btn btn-info" id="add_new_person_btn"
												   value="Save data"/>
                                            <input type="reset" class="btn" id="person_reset" value="Reset"/>
                                        </span>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

				</form>
			</td>
		</tr>

	</table>


	<a name="results" style="text-decoration: none;">&nbsp;
		<table style="border:1px solid #CCC;margin-top:30px;display:none" width="100%" id="participants_results">
			<tr>
				<td style="padding:20px">
					<h5 style="margin:5px" class="text-info inline-block">Search result</h5><sub
						class="text-error handcursor" id="person_close">&nbsp;(close)</sub><sub
						class="text-error handcursor btn btn-primary" id="force_add"
						style="float:right;margin-bottom: 10px;"
						onclick="$('#person_tablebody').show(); $('#participants_results').hide();">&nbsp;Force
						Add</sub>
					<table class="dataListing" id="participants_search_result" width="100%" id="" cellspacing="0"
						   cellpadding="5" border="0">
						<!--tr>
							<th width="5%" align="center">#</th>
							<th width="7%" align="left">Image</th>
							<th width="17%" align="left">Name</th>
							<th width="15%" align="left">Address</th>
							<th width="10%" align="left">Mobile</th>
							<th width="10%" align="left">Email</th>
							<th width="10%" align="left">Org name</th>
							<th width="10%" align="left">Position</th>
							<th width="16%" align="left">Select</th>
						</tr-->
					</table>
				</td>
			</tr>
		</table>
	</a>
</div> <!-- end of container tag-->
<br/>

