<style type="text/css">
    input[type='text'],select,input[type='checkbox'],input[type='radio']{
        margin-bottom:2px;
        margin-top:2px;
    }
    label{
        color:#2f96b4;
    }
    .txt-err{
        color:#e9322d;
    }
    #main-organizer-block,#implementing-partner-block{
        width:200px;
        height:90px;
        overflow-y: scroll;
        padding:10px;
        border:1px solid #ccc;
        border-radius:5px;
    }

</style>
<div class="container">

    
    <table style="border:1px solid #CCC;margin-top:30px" width="100%">
        <tr><td style="padding:20px">
                <?php echo validation_errors(); ?>
                <span style="color:green"><?php if (isset($insert)) echo $insert; ?></span>   <br /> 
                <?php echo form_open('Event/createEvent', array('id' => 'event_entry_form', 'name' => 'event_entry_form')); ?>

                <table border="0">
                    <tr>
                        <td colspan="3">
                            <label style="display:inline-block">Event Title</label> 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="text" style="width:645px" id="event_title" name="event_title" placeholder="Enter title"/>
                        </td>
                    </tr>
                    <tr>
                        <td  >
                            <table border="0">

                                <tr>
                                    <td style="padding-right:30px;"><label>Event-type(course)</label> </td>
                                    <td>
                                        <select name="event_course_category" id="event_course_category">
                                            <option value="">-- SELECT --</option>
                                            <?php
                                            if (isset($CourseContent)) {
                                                echo $CourseContent;
                                            }
                                            ?>
                                        </select>
                                        <span style="width:100px;display:inline-block">
                                            <img src ="../img/loading.gif" style="margin-top: -10px; padding:5px;display:none" id="loading_image"/>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-right:30px;"><label draggable="true">Subcourse</label> </td>
                                    <td>
                                        <span id="getSubCourse">
                                            <select name="event_course_subcategory" id="event_course_subcategory" disabled="disabled">
                                                <option value="">-- SELECT --</option>
                                            </select>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>event level</label> </td>
                                    <td>
                                        <select name="event_level" id="event_level">
                                            <option value="">-- SELECT --</option>
                                            <option value="Municipality">Municipality</option>
                                            <option value="District">District</option>
                                            <option value="Region">Region</option>
                                        </select>
                                    </td>
                                </tr>



                                <tr>
                                    <td><label>Start date</label> </td>
                                    <td>
                                        <input type="text" name="event_start_date"  id="event_start_date" class="nepali-calendar" placeholder="Enter start date" />
                                        <!--input type="text" class="datepicker" id="event_start_date" name="event_start_date" placeholder="Enter start date"-->
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>End date</label> </td>
                                    <td>
                                        <input type="text" name="event_end_date"  id="event_end_date" class="nepali-calendar" placeholder="Enter end date" />
                                        <!--input type="text" class="datepicker" id="event_end_date" name="event_end_date" placeholder="Enter end date"-->
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="border-right:1px solid #ccc;padding-right:50px;vertical-align: top">
                            <table border="0">
                                <tr>
                                    <td><label>Event year</label> </td>
                                    <td>
                                        <select name="event_year" id="event_year">
                                            <option value="">-- SELECT --</option>
                                            <option value="2012">2069</option>
                                            <option value="2013">2070</option>
                                            <option value="2014">2071</option>
                                            <option value="2015">2072</option>
                                            <option value="2016">2073</option>
                                            <option value="2017">2074</option>
                                            <option value="2018">2075</option>
                                            <option value="2019">2076</option>
                                            <option value="2020">2077</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-right:10px"><label>Implemented by</label> </td>
                                    <td><input type="text" name="event_implementedby" placeholder="Implemented by"/> </td>
                                </tr>
                                <tr>
                                    <td><label>Venue</label> </td>
                                    <td><input type="text" name="event_venue" placeholder="Enter venue"/> </td>
                                </tr>
                                <tr>
                                    <td><label>Address</label> </td>
                                    <td><input type="text" name="event_address" placeholder="Enter address"/> </td>
                                </tr>
                                <tr>
                                    <td><label>Country</label> </td>
                                    <td>
                                        <select name="event_country">

                                            <option value=""   >Select one</option>
                                            <option value="af"   >Afghanistan</option>
                                            <option value="ax"   >Aland Islands</option>
                                            <option value="al"   >Albania</option>
                                            <option value="dz"   >Algeria</option>
                                            <option value="as"   >American Samoa</option>
                                            <option value="ad"   >Andorra</option>
                                            <option value="ao"   >Angola</option>
                                            <option value="ai"   >Anguilla</option>
                                            <option value="aq"   >Antarctica</option>
                                            <option value="ag"   >Antigua and Barbuda</option>
                                            <option value="ar"   >Argentina</option>
                                            <option value="am"   >Armenia</option>
                                            <option value="aw"   >Aruba</option>
                                            <option value="au"   >Australia</option>
                                            <option value="at"   >Austria</option>
                                            <option value="az"   >Azerbaijan</option>
                                            <option value="bs"   >Bahamas</option>
                                            <option value="bh"   >Bahrain</option>
                                            <option value="bd"   >Bangladesh</option>
                                            <option value="bb"   >Barbados</option>
                                            <option value="by"   >Belarus</option>
                                            <option value="be"   >Belgium</option>
                                            <option value="bz"   >Belize</option>
                                            <option value="bj"   >Benin</option>
                                            <option value="bm"   >Bermuda</option>
                                            <option value="bt"   >Bhutan</option>
                                            <option value="bo"   >Bolivia</option>
                                            <option value="ba"   >Bosnia and Herzegovina</option>
                                            <option value="bw"   >Botswana</option>
                                            <option value="bv"   >Bouvet Island</option>
                                            <option value="br"   >Brazil</option>
                                            <option value="io"   >British Indian Ocean Territory</option>
                                            <option value="vg"   >British Virgin Islands</option>
                                            <option value="bn"   >Brunei</option>
                                            <option value="bg"   >Bulgaria</option>
                                            <option value="bf"   >Burkina Faso</option>
                                            <option value="bi"   >Burundi</option>
                                            <option value="kh"   >Cambodia</option>
                                            <option value="cm"   >Cameroon</option>
                                            <option value="ca"   >Canada</option>
                                            <option value="cv"   >Cape Verde</option>
                                            <option value="ky"   >Cayman Islands</option>
                                            <option value="cf"   >Central African Republic</option>
                                            <option value="td"   >Chad</option>
                                            <option value="cl"   >Chile</option>
                                            <option value="cn"   >China</option>
                                            <option value="cx"   >Christmas Island</option>
                                            <option value="cc"   >Cocos (Keeling) Islands</option>
                                            <option value="co"   >Colombia</option>
                                            <option value="km"   >Comoros</option>
                                            <option value="cg"   >Congo</option>
                                            <option value="ck"   >Cook Islands</option>
                                            <option value="cr"   >Costa Rica</option>
                                            <option value="hr"   >Croatia</option>
                                            <option value="cu"   >Cuba</option>
                                            <option value="cy"   >Cyprus</option>
                                            <option value="cz"   >Czech Republic</option>
                                            <option value="cd"   >Democratic Republic of Congo</option>
                                            <option value="dk"   >Denmark</option>
                                            <option value="xx"   >Disputed Territory</option>
                                            <option value="dj"   >Djibouti</option>
                                            <option value="dm"   >Dominica</option>
                                            <option value="do"   >Dominican Republic</option>
                                            <option value="tl"   >East Timor</option>
                                            <option value="ec"   >Ecuador</option>
                                            <option value="eg"   >Egypt</option>
                                            <option value="sv"   >El Salvador</option>
                                            <option value="gq"   >Equatorial Guinea</option>
                                            <option value="er"   >Eritrea</option>
                                            <option value="ee"   >Estonia</option>
                                            <option value="et"   >Ethiopia</option>
                                            <option value="fk"   >Falkland Islands</option>
                                            <option value="fo"   >Faroe Islands</option>
                                            <option value="fm"   >Federated States of Micronesia</option>
                                            <option value="fj"   >Fiji</option>
                                            <option value="fi"   >Finland</option>
                                            <option value="fr"   >France</option>
                                            <option value="gf"   >French Guyana</option>
                                            <option value="pf"   >French Polynesia</option>
                                            <option value="tf"   >French Southern Territories</option>
                                            <option value="ga"   >Gabon</option>
                                            <option value="gm"   >Gambia</option>
                                            <option value="ge"   >Georgia</option>
                                            <option value="de"   >Germany</option>
                                            <option value="gh"   >Ghana</option>
                                            <option value="gi"   >Gibraltar</option>
                                            <option value="gr"   >Greece</option>
                                            <option value="gl"   >Greenland</option>
                                            <option value="gd"   >Grenada</option>
                                            <option value="gp"   >Guadeloupe</option>
                                            <option value="gu"   >Guam</option>
                                            <option value="gt"   >Guatemala</option>
                                            <option value="gn"   >Guinea</option>
                                            <option value="gw"   >Guinea-Bissau</option>
                                            <option value="gy"   >Guyana</option>
                                            <option value="ht"   >Haiti</option>
                                            <option value="hm"   >Heard Island and Mcdonald Islands</option>
                                            <option value="hn"   >Honduras</option>
                                            <option value="hk"   >Hong Kong</option>
                                            <option value="hu"   >Hungary</option>
                                            <option value="is"   >Iceland</option>
                                            <option value="in"   >India</option>
                                            <option value="id"   >Indonesia</option>
                                            <option value="ir"   >Iran</option>
                                            <option value="iq"   >Iraq</option>
                                            <option value="xe"   >Iraq-Saudi Arabia Neutral Zone</option>
                                            <option value="ie"   >Ireland</option>
                                            <option value="il"   >Israel</option>
                                            <option value="it"   >Italy</option>
                                            <option value="ci"   >Ivory Coast</option>
                                            <option value="jm"   >Jamaica</option>
                                            <option value="jp"   >Japan</option>
                                            <option value="jo"   >Jordan</option>
                                            <option value="kz"   >Kazakhstan</option>
                                            <option value="ke"   >Kenya</option>
                                            <option value="ki"   >Kiribati</option>
                                            <option value="kw"   >Kuwait</option>
                                            <option value="kg"   >Kyrgyzstan</option>
                                            <option value="la"   >Laos</option>
                                            <option value="lv"   >Latvia</option>
                                            <option value="lb"   >Lebanon</option>
                                            <option value="ls"   >Lesotho</option>
                                            <option value="lr"   >Liberia</option>
                                            <option value="ly"   >Libya</option>
                                            <option value="li"   >Liechtenstein</option>
                                            <option value="lt"   >Lithuania</option>
                                            <option value="lu"   >Luxembourg</option>
                                            <option value="mo"   >Macau</option>
                                            <option value="mk"   >Macedonia</option>
                                            <option value="mg"   >Madagascar</option>
                                            <option value="mw"   >Malawi</option>
                                            <option value="my"   >Malaysia</option>
                                            <option value="mv"   >Maldives</option>
                                            <option value="ml"   >Mali</option>
                                            <option value="mt"   >Malta</option>
                                            <option value="mh"   >Marshall Islands</option>
                                            <option value="mq"   >Martinique</option>
                                            <option value="mr"   >Mauritania</option>
                                            <option value="mu"   >Mauritius</option>
                                            <option value="yt"   >Mayotte</option>
                                            <option value="mx"   >Mexico</option>
                                            <option value="md"   >Moldova</option>
                                            <option value="mc"   >Monaco</option>
                                            <option value="mn"   >Mongolia</option>
                                            <option value="ms"   >Montserrat</option>
                                            <option value="ma"   >Morocco</option>
                                            <option value="mz"   >Mozambique</option>
                                            <option value="mm"   >Myanmar</option>
                                            <option value="na"   >Namibia</option>
                                            <option value="nr"   >Nauru</option>
                                            <option value="np"   SELECTED  >Nepal</option>
                                            <option value="nl"   >Netherlands</option>
                                            <option value="an"   >Netherlands Antilles</option>
                                            <option value="nc"   >New Caledonia</option>
                                            <option value="nz"   >New Zealand</option>
                                            <option value="ni"   >Nicaragua</option>
                                            <option value="ne"   >Niger</option>
                                            <option value="ng"   >Nigeria</option>
                                            <option value="nu"   >Niue</option>
                                            <option value="nf"   >Norfolk Island</option>
                                            <option value="kp"   >North Korea</option>
                                            <option value="mp"   >Northern Mariana Islands</option>
                                            <option value="no"   >Norway</option>
                                            <option value="om"   >Oman</option>
                                            <option value="pk"   >Pakistan</option>
                                            <option value="pw"   >Palau</option>
                                            <option value="ps"   >Palestinian Territories</option>
                                            <option value="pa"   >Panama</option>
                                            <option value="pg"   >Papua New Guinea</option>
                                            <option value="py"   >Paraguay</option>
                                            <option value="pe"   >Peru</option>
                                            <option value="ph"   >Philippines</option>
                                            <option value="pn"   >Pitcairn Islands</option>
                                            <option value="pl"   >Poland</option>
                                            <option value="pt"   >Portugal</option>
                                            <option value="pr"   >Puerto Rico</option>
                                            <option value="qa"   >Qatar</option>
                                            <option value="re"   >Reunion</option>
                                            <option value="ro"   >Romania</option>
                                            <option value="ru"   >Russia</option>
                                            <option value="rw"   >Rwanda</option>
                                            <option value="sh"   >Saint Helena and Dependencies</option>
                                            <option value="kn"   >Saint Kitts and Nevis</option>
                                            <option value="lc"   >Saint Lucia</option>
                                            <option value="pm"   >Saint Pierre and Miquelon</option>
                                            <option value="vc"   >Saint Vincent and the Grenadines</option>
                                            <option value="ws"   >Samoa</option>
                                            <option value="sm"   >San Marino</option>
                                            <option value="st"   >Sao Tome and Principe</option>
                                            <option value="sa"   >Saudi Arabia</option>
                                            <option value="sn"   >Senegal</option>
                                            <option value="sc"   >Seychelles</option>
                                            <option value="sl"   >Sierra Leone</option>
                                            <option value="sg"   >Singapore</option>
                                            <option value="sk"   >Slovakia</option>
                                            <option value="si"   >Slovenia</option>
                                            <option value="sb"   >Solomon Islands</option>
                                            <option value="so"   >Somalia</option>
                                            <option value="za"   >South Africa</option>
                                            <option value="gs"   >South Georgia and South Sandwich Islands</option>
                                            <option value="kr"   >South Korea</option>
                                            <option value="es"   >Spain</option>
                                            <option value="pi"   >Spratly Islands</option>
                                            <option value="lk"   >Sri Lanka</option>
                                            <option value="sd"   >Sudan</option>
                                            <option value="sr"   >Suriname</option>
                                            <option value="sj"   >Svalbard and Jan Mayen</option>
                                            <option value="sz"   >Swaziland</option>
                                            <option value="se"   >Sweden</option>
                                            <option value="ch"   >Switzerland</option>
                                            <option value="sy"   >Syria</option>
                                            <option value="tw"   >Taiwan</option>
                                            <option value="tj"   >Tajikistan</option>
                                            <option value="tz"   >Tanzania</option>
                                            <option value="th"   >Thailand</option>
                                            <option value="tg"   >Togo</option>
                                            <option value="tk"   >Tokelau</option>
                                            <option value="to"   >Tonga</option>
                                            <option value="tt"   >Trinidad and Tobago</option>
                                            <option value="tn"   >Tunisia</option>
                                            <option value="tr"   >Turkey</option>
                                            <option value="tm"   >Turkmenistan</option>
                                            <option value="tc"   >Turks And Caicos Islands</option>
                                            <option value="tv"   >Tuvalu</option>
                                            <option value="ug"   >Uganda</option>
                                            <option value="ua"   >Ukraine</option>
                                            <option value="ae"   >United Arab Emirates</option>
                                            <option value="uk"   >United Kingdom</option>
                                            <option value="us"   >United States</option>
                                            <option value="um"   >United States Minor Outlying Islands</option>
                                            <option value="uy"   >Uruguay</option>
                                            <option value="vi"   >US Virgin Islands</option>
                                            <option value="uz"   >Uzbekistan</option>
                                            <option value="vu"   >Vanuatu</option>
                                            <option value="va"   >Vatican City</option>
                                            <option value="ve"   >Venezuela</option>
                                            <option value="vn"   >Vietnam</option>
                                            <option value="wf"   >Wallis and Futuna</option>
                                            <option value="eh"   >Western Sahara</option>
                                            <option value="ye"   >Yemen</option>
                                            <option value="zm"   >Zambia</option>
                                            <option value="zw"   >Zimbabwe</option>
                                            <option value="rs"   >Serbia</option>
                                            <option value="me"   >Montenegro</option>

                                        </select>

                                    </td>
                                </tr>
                                <!--tr>
                                    <td><label>Cost Sharing</label> </td>
                                    <td><select name="event_cost_sharing" id="event_cost_sharing">
                                            <option value="">-- SELECT --</option>
                                            <option value="Municipality">Municipality</option>
                                            <option value="NSET">NSET</option>
                                            <option value="Others">Others</option>
                                        </select></td>
                                </tr-->



                            </table>
                        </td>
                        <td style="padding-left:20px;vertical-align: top">
                            <!--
                            <p class="text-info inline-block" style="margin-bottom:5px">cost sharing (%)</p><span class="text-error inline-block size11">&nbsp;&nbsp; * sum must be 100%</span></p>
                            <hr style="margin-bottom:5px;margin-top:5px"/>
                            <table border="0">
                                <tr>
                                    <td>
                                        <table width="100%">
                            <?php
                            if (isset($csparty_array)) {
                                for ($i = 0; $i < count($csparty_array); $i++) {
                                    echo "<tr>";
                                    echo '<td align="right" style="width:150px;overflow:hidden">' . $csparty_array[$i][1] . '&nbsp:&nbsp;&nbsp;</td>';
                                    echo '<td><input type="text"  id="csparty_' . $csparty_array[$i][0] . '" name="csparty_' . $csparty_array[$i][0] . '" style="font:12px;width:100px;height:15px;margin-bottom:0" /></td>';
                                    echo "</tr>";
                                }
                            } else {
                                echo "<div class='message-error'><p class='text-error'> Some error occured!</p>
                                                    <p class='text-error'><a href='../HomeController/events'>Click here</a> to retry</p></div>";
                            }
                            ?>
                                            <tr>
                                                <td colspan="2">
                                                    <br />
                                                    <div class="message-error curved" id="message" style="display:none"> Sum must be 100</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            -->
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding:20px 0 0 0">
                            <?php
                            if (isset($csparty_array)) {
                                echo '<button id="save_event_btn" disabled="disabled" class="btn btn-info">Save event</button>';
                            }
                            ?>
                            <input type="reset" class="btn" value="Reset"/>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>

    </table></form>
<p class="text-info">
    <i>   * The page will be redirected to participants page after saving this event.</i>
</p>










<table style="border:1px solid #CCC;margin-top:30px" width="100%">
    <tr><td style="padding:20px">
            <?php echo validation_errors(); ?>
            <span style="color:green"><?php if (isset($insert)) echo $insert; ?></span>   <br /> 
            <?php echo form_open('Event/createEvent', array('id' => 'event_entry_form', 'name' => 'event_entry_form')); ?>

            <table width="" border="0">
                <tr>
                    <td ><label for="event_title">Title : </label></td>
                    <td colspan="4">
                        <input type="text" style="width:712px" id="event_title" name="event_title" placeholder="Enter title"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table border="0" width="100%">
                            <tr>
                                <td style="width:148px"><label for="event_start_date">Start date : </label></td>
                                <td style="width:220px;">
                                    <input type="text" name="event_start_date"  id="event_start_date" class="datepicker" placeholder="Enter start date" style="width:150px;"/>
                                </td>
                                <td style="width:90px"><label for="event_end_date">End date : </label></td>
                                <td style="width:202px">
                                    <input type="text" name="event_end_date"  id="event_end_date" class="datepicker" placeholder="Enter end date" style="width:150px;"/>
                                </td>
                                <td style="width:100px"><label for="event_year">Event year : </label></td>
                                <td>
                                    <select name="event_year" id="event_year" style="width:107px;">
                                        <option value="2012">2012</option>
                                        <option value="2013" selected>2013</option>
                                        <option value="2014">2014</option>
                                        <option value="2015">2015</option>
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width:150px"><label for="event_course_category">Event type : </label></td>
                    <td style="width:300px">
                        <select name="event_course_category" id="event_course_category" >
                            <option value="">-- SELECT --</option>
                            <?php
                            if (isset($CourseContent)) {
                                echo $CourseContent;
                            }
                            ?>
                        </select>
                        <span style="width:20px;display:inline-block">
                            <img src ="../img/loading.gif" style="margin-top: -10px; padding:5px;display:none" id="loading_image"/>
                        </span>
                    </td>
                    <td style="width:50px" ></td>
                    <td style="width:150px"><label for="event_course_subcategory">Course : </label></td>
                    <td style="width:300px">
                        <span id="getSubCourse">
                            <select name="event_course_subcategory" id="event_course_subcategory" disabled="disabled">
                                <option value="">-- SELECT --</option>
                            </select>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td ><label>Coverage level : </label></td>
                    <td >
                        <select name="event_level" id="event_level">
                            <option value="">Select</option>
                            <option value="Municipality">Municipality</option>
                            <option value="Region">Region</option>
                            <option value="VDC">VDC</option>
                            <option value="District">District</option>
                            <option value="National">National</option>
                        </select>

                    </td>
                    <td style="width:50px" ></td>
                    <td><label>Coverage location : </label></td>
                    <td><span class="text-error size11">*Select coverage level first</span> </td>
                </tr>
                <tr>
                    <td style="vertical-align: top">
                        <label for="main-organizer-block">Main organizer : </label>
                       <!-- <input type="radio" checked="checked" id="main-organizer-radio" name="organizer-radio">&nbsp; <label for="main-organizer-radio" style="display:inline-block"><span class="text-warning"> select </span></label> -->
                    </td>
                    <td>
                        <div id="main-organizer-block">
                            <input type="checkbox" name="main_org_municipality" value="municipality" /> &nbsp; Municipality
                            <br /><input type="checkbox" name="main_org_nset" value="NSET" /> &nbsp; NSET
                            <br /><input type="checkbox" name="main_org_vdc" value="VDC" /> &nbsp; VDC
                            <br /><input type="checkbox" name="main_org_region" value="Region" /> &nbsp; Region
                        </div>
                    </td>
                    <td style="width:50px" ></td>
                    <td style="vertical-align: top">
                        <label for="implementing-partner-block">Implementing partner : </label>
                  <!--     <input type="radio" id="implementing-partner-radio" name="organizer-radio" />&nbsp;<label for="implementing-partner-radio" style="display:inline-block"><span class="text-warning"> select </span></label> -->
                    </td>
                    <td>
                        <div id="implementing-partner-block">
                            <input type="checkbox" name="main_org_municipality" value="municipality" /> &nbsp; Municipality
                            <br /><input type="checkbox" name="main_org_nset" value="NSET" /> &nbsp; NSET
                            <br /><input type="checkbox" name="main_org_vdc" value="VDC" /> &nbsp; VDC
                            <br /><input type="checkbox" name="main_org_region" value="Region" /> &nbsp; Region
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label>Venue : </label></td>
                    <td>
                        <input type="text" name="event_venue" placeholder="Enter venue"/>
                    </td>
                    <td style="width:50px" ></td>
                    <td><label>Address : </label></td>
                    <td>
                        <input type="text" name="event_address" placeholder="Enter address"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="padding:20px 0 0 0">
                        <?php
                        if (isset($csparty_array)) {
                            echo '<button id="save_event_btn"  class="btn btn-info">Save event</button>';
                        }
                        ?>
                        <input type="reset" class="btn" value="Reset"/>
                    </td>
                </tr>
            </table>
            <?php echo form_close(); ?>

        </td>
    </tr>

</table></form>
<p class="text-info">
    <i>   * The page will be redirected to participants page after saving this event.</i>
</p>
</div> <!-- end of container tag-->



