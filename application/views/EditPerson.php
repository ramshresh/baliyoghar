<style type="text/css">
    label {
        color: #0782C1
    }
</style>
<div class="container">

    <table style="border:1px solid #CCC;margin-top:30px" width="100%">
        <tr>
            <td style="padding:20px">
                <h4 style="color:#888">Update detail of <?php echo $title . " " . $fullname; ?></h4>
                <?php echo validation_errors(); ?>
                <span style="color:green"><?php if (isset($insert)) echo $insert . '<br /> '; ?></span>


                <hr/>
                <?php echo form_open_multipart('Person/addPerson', array('id' => 'people_edit_form', 'name' => 'people_edit_form')); ?>

                <!-----------------------------------change image--------------------------------------->
                <?php if (isset($photo) && (strpos($photo, 'image_') !== false)) { ?>
                    <img src="../gallery/thumbs/<?php echo $photo; ?>" style="margin-bottom:10px;"/>
                    <br/>
                    <a class="btn" href="../Person/changePicture?id=<?php echo $person_id; ?>"><img
                                src="../img/photos.png"/> Change picture</a>
                    <a class="btn" href="../Person/changePicture?id=r_<?php echo $person_id; ?>"><img
                                src="../img/delete_small.png"/> Remove picture</a>
                    <br/><br/>
                    <?php
                } else {
                    echo '<a class="btn" href="../Person/changePicture?id=' . $person_id . '"><img src="../img/photos.png"/> Upload picture</a>';
                }
                ?>
                <!-------------------------------------------------------------------------->


                <input type="hidden" name="identifier" value="update"/>
                <input type="hidden" name="person_id" value="<?php echo $person_id; ?>"/>

                <table width="100%">
                    <tr>
                        <td>
                            <table>
                                <tr>

                                    <td style="padding-right:30px;"><label>Title</label></td>
                                    <td>
                                        <select name="person_title" id="person_title">
                                            <option value="Mr." <?php if ($title == "Mr.") echo "SELECTED"; ?>>Mr.
                                            </option>
                                            <option value="Ms." <?php if ($title == "Ms.") echo "SELECTED"; ?>>Ms.
                                            </option>
                                            <option value="Dr." <?php if ($title == "Dr.") echo "SELECTED"; ?>>Dr.
                                            </option>
                                            <option value="Er." <?php if ($title == "Er.") echo "SELECTED"; ?>>Er.
                                            </option>
                                            <option value="Prof." <?php if ($title == "Prof.") echo "SELECTED"; ?>>
                                                Prof.
                                            </option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td><label>Full name*</label></td>
                                    <td><input type="text" name="person_name" value="<?php echo $fullname; ?>"
                                               placeholder="Enter name" required="required"/></td>
                                </tr>

                                <tr>
                                    <td><label>Citizenship No*</label></td>
                                    <td><input type="text" name="person_citizenship_no"
                                               value="<?php echo $citizenship_no; ?>" placeholder="Enter name"/></td>
                                </tr>

                                <tr>
                                    <td><label>Date of birth(np)</label></td>
                                    <td>
                                        <input type="text" name="person_dob_np" id="person_dob_np"
                                               placeholder="Enter date of birth" value="<?php echo $dob_np; ?>"/>
                                        <!--input type="text" class="datepicker" value="<?php echo $dob_np; ?>" name="person_dob" placeholder="Enter date of birth"-->
                                        <!--<input type="text" name="person_dob" placeholder="Type here..."/>-->
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Date of birth(en)</label></td>
                                    <td>
                                        <input type="text" name="person_dob_en" id="person_dob_en"
                                               value="<?php echo $dob_en; ?>"/>
                                        <!--input type="text" class="datepicker" value="<?php echo $dob_en; ?>" name="person_dob" placeholder="Enter date of birth"-->
                                        <!--<input type="text" name="person_dob" placeholder="Type here..."/>-->
                                    </td>
                                </tr>

                                <tr>
                                    <td><label>Age</label></td>
                                    <td>
                                        <input type="number" name="age" id="age"
                                               value="<?php echo $age; ?>" placeholder="Age"/>
                                    </td>
                                </tr>
                                <!--tr>
                                    <td><label>Age*</label> </td>
                                    <td><input type="number" name="person_age" value="<?php echo $age; ?>" placeholder="Enter age"/> </td>
                                </tr-->
                                <tr>
                                    <td><label>Gender</label></td>
                                    <td><select name="person_gender" id="person_title">
                                            <option value="">-- SELECT --</option>
                                            <option value="Male" <?php if ($gender == "Male") echo "SELECTED"; ?> >
                                                Male
                                            </option>
                                            <option value="Female" <?php if ($gender == "Female") echo "SELECTED"; ?>>
                                                Female
                                            </option>
                                            <option value="Other" <?php if ($gender == "Other") echo "SELECTED"; ?>>
                                                Other
                                            </option>
                                        </select></td>
                                </tr>

                                <tr>
                                    <td><label>Caste/Ethnicity</label></td>
                                    <td><select name="person_caste_ethnicity" id="person_caste_ethnicity">
                                            <option value="">-- SELECT --</option>
                                            <option value="1" <?php if ($caste_ethnicity == "1") echo "SELECTED"; ?>>
                                                Newar
                                            </option>
                                            <option value="2" <?php if ($caste_ethnicity == "2") echo "SELECTED"; ?>>
                                                Janajati
                                            </option>
                                            <option value="3" <?php if ($caste_ethnicity == "3") echo "SELECTED"; ?>>
                                                Bahun/Chhetri
                                            </option>
                                            <option value="4" <?php if ($caste_ethnicity == "4") echo "SELECTED"; ?>>
                                                Muslim
                                            </option>
                                            <option value="5" <?php if ($caste_ethnicity == "5") echo "SELECTED"; ?>>
                                                Dalit
                                            </option>
                                            <option value="6" <?php if ($caste_ethnicity == "6") echo "SELECTED"; ?>>
                                                Other
                                            </option>
                                        </select></td>
                                </tr>

                                <tr>
                                    <td style="padding-right:10px"><label>Permanent address</label></td>
                                    <td><input type="text" name="person_paddress" value="<?php echo $p_address; ?>"
                                               placeholder="Enter permanent address"/></td>
                                </tr>
                                <tr>
                                    <td><label>Contact address</label></td>
                                    <td><input type="text" name="person_caddress" value="<?php echo $c_address; ?>"
                                               placeholder="Enter contact address"/></td>
                                </tr>
                                <!--tr>
                                    <td><label>Choose a photo</label> </td>
                                    <td><input type="file" name="person_photo" placeholder="Select photo"/> </td>
                                </tr-->
                                <tr>
                                    <td><label>Country</label></td>
                                    <td><select name="person_country">

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
                                <tr>
                                    <td><label>Phone</label></td>
                                    <td><input type="text" id="person_phone" name="person_phone"
                                               value="<?php echo $phone; ?>" placeholder="Enter phone number"/></td>
                                </tr>
                                <tr>
                                    <td><label>Mobile</label></td>
                                    <td>
                                        <input type="text" id="person_mobile" name="person_mobile"
                                               value="<?php echo $mobile; ?>" placeholder="Enter mobile number"/></td>
                                </tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <tr>
                                    <td><label>Email</label></td>
                                    <td><input type="text" id="person_email" name="person_email"
                                               value="<?php echo $email; ?>" placeholder="Enter email"/></td>
                                </tr>
                                <tr>
                                    <td><label>Organization name</label></td>
                                    <td><input type="text" name="person_org_name" value="<?php echo $org_name; ?>"
                                               placeholder="Enter org. name"/></td>
                                </tr>
                                <tr>
                                    <td style="padding-right:10px"><label>Organization address</label></td>
                                    <td><input type="text" name="person_org_address" value="<?php echo $org_address; ?>"
                                               placeholder="Enter org. address"/></td>
                                </tr>
                                <tr>
                                    <td><label>Organization phone</label></td>
                                    <td><input type="text" id="person_org_phone" name="person_org_phone"
                                               value="<?php echo $org_phone; ?>" placeholder="Enter org. phone"/></td>
                                </tr>
                                <tr>
                                    <td><label>Organization fax</label></td>
                                    <td><input type="text" id="person_org_fax" name="person_org_fax"
                                               value="<?php echo $org_fax; ?>" placeholder="Enter org. fax"/></td>
                                </tr>
                                <tr>
                                    <td><label>Position</label></td>
                                    <td><input type="text" name="person_position" value="<?php echo $position; ?>"
                                               id="person_position" placeholder="Enter position"/></td>
                                </tr>
                                <tr>
                                    <td><label>Current status</label></td>
                                    <td><select name="person_current_status" id="person_current_status">
                                            <option value="">-- SELECT --</option>
                                            <option
                                                    value="Active" <?php if ($current_status == "Active") echo "SELECTED"; ?>>
                                                Active
                                            </option>
                                            <option
                                                    value="Retired" <?php if ($current_status == "Retired") echo "SELECTED"; ?>>
                                                Retired
                                            </option>
                                            <option
                                                    value="Migrated within country" <?php if ($current_status == "Migrated within country") echo "SELECTED"; ?>>
                                                Migrated within country
                                            </option>
                                            <option
                                                    value="Migrated outside country" <?php if ($current_status == "Migrated outside country") echo "SELECTED"; ?>>
                                                Migrated outside country
                                            </option>
                                            <option
                                                    value="Dead" <?php if ($current_status == "Dead") echo "SELECTED"; ?>>
                                                Dead
                                            </option>
                                        </select></td>
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
                                                                        */ ?>
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
                                    <td><label>Work Experience in Years:</label></td>
                                    <td>
                                        <input type="number" name="work_experience_years" id="work_experience_years"
                                               value="<?php echo $work_experience_years; ?>"
                                               placeholder="Work Experience in Years"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="right">
                                        <br/>
                                        <br/>
                                        <input type="submit" class="btn btn-info" value="Update data"/>
                                        <input type="reset" class="btn" value="Reset"/>
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






<!--       START:  use this-->
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
                <th width="23%" align="left">Action</th>
                <?php
                if (isset($action) && $action !== null) {
                    echo '<th style="width:60px" align="left">Action</th>';
                }
                ?>
            </tr>

            <?php
           for ($i = 0; $i < count($participations); $i++) {
                $_editParticipationRow_viewData['participation']=$participations[$i];
                $_editParticipationRow_viewData['i']=$i;

               echo "<tr id='event_row_" . $participations[$i][9] . "'>";
               $this->load->view('person/edit_participation/_editParticipationRow',$_editParticipationRow_viewData);
                echo '</tr>';
            }
            ?>

            </tbody>
        </table>

        <!--       END: use this -->

</div> <!-- end of container tag-->
<br/>

<div id="participationFormDiv"></div>
