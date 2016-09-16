

<style type="text/css">
    hr{
        margin:3px;
    }
    #event_detail_table th{
        color:#1f6377;
        padding:10px;
        font-size: 12px;
    }
    #event_detail_table td{
        color: #3a87ad;
        padding:10px;
        font-size: 12px;
        border-bottom:1px solid #E0E0E0;
    }

</style>
<div class="container">

    <table style="border:1px solid #CCC;margin-top:30px;margin-bottom:30px;" width="100%" class="getBg" >
        <tr>
            <td style="padding:20px;">
        <center>  <span style="color:green"><?php if (isset($insert)) echo $insert; ?></span></center>

        <hr />
        <h5 class="text-success size16" style="text-align: center">Event detail </h5>
        <hr />

        <br />



        <table width="100%x"  cellpadding="5" class="dataListing" id="event_detail_table">
            <tr>
                <th align="left" width="20%">Event Title</th>
                <td align="left" width="80%" ><span class="text-success"><?php if (isset($title)) echo $title; ?></span></td>
            </tr>
            <tr>
                <th align="left" width="20%">Event-type</th>
                <td align="left" width="80%"><?php if (isset($course)) echo $course; ?></td>
            </tr>
            <tr>
                <th align="left" width="20%">Course</th>
                <td align="left" width="80%"><?php if (isset($subcourse)) echo $subcourse; ?></td>
            </tr>

            <tr>
                <th align="left" width="20%">Coverage level</th>
                <td align="left" width="80%"><?php if (isset($level)) echo $level; ?></td>
            </tr>
            <tr>
                <th align="left" width="20%">Coverage location</th>
                <td align="left" width="80%"><?php if (isset($location)) echo $location; ?></td>
            </tr>
              <tr>
                <th align="left" width="20%">Longitude </th>
                <td align="left" width="80%"><?php if (isset($longitude)) echo $longitude; ?></td>
            </tr>
              <tr>
                <th align="left" width="20%">Latitude</th>
                <td align="left" width="80%"><?php if (isset($latitude)) echo $latitude; ?></td>
            </tr>
            <tr>
                <th align="left" width="20%">Start date</th>
                <td align="left" width="80%"><?php if (isset($start_date)) echo $start_date; ?></td>
            </tr>
            <tr>
                <th align="left" width="20%">End date</th>
                <td align="left" width="80%"><?php if (isset($end_date)) echo $end_date; ?></td>
            </tr>
            <tr>
                <th align="left" width="20%">Event year</th>
                <td align="left" width="80%"><?php if (isset($year)) echo $year; ?></td>
            </tr>
            <tr>
                <th align="left" width="20%">Venue</th>
                <td align="left" width="80%"><?php if (isset($venue)) echo $venue; ?></td>
            </tr>
            <tr>
                <th align="left" width="20%">Address</th>
                <td align="left" width="80%"><?php if (isset($address)) echo $address; ?></td>
            </tr>
        </table>

        <br />









        <!--table width="100%" border="0" cellspacing="0" cellpadding="5" class="dataListing" >
            <tr>
                <th align="left" width="13%">Event Title</th>
                <th align="left" width="15%">Event-type</th>
                <th align="left" width="15%">Course</th>
                <th width="10%" align="center">Coverage</th>
                <th width="7%" align="center">Start date</th>
                <th width="8%" align="center">End date</th>
            </tr>
            <tr class="whiteTd" >
                <td align="left"><span class="text-success uppercase"><?php if (isset($title)) echo $title; ?></span></td>
                <td align="left"><p class="text-info"><?php if (isset($course)) echo $course; ?></p></td>
                <td align="left"><p class="text-info"><?php if (isset($subcourse)) echo $subcourse; ?></p></td>

                <td align="center"><p class="text-info"><?php if (isset($level)) echo $level; ?></p></td>
                <td align="center"><p class="text-info"><?php if (isset($start_date)) echo $start_date; ?> </td>
                <td align="center"><p class="text-info"><?php if (isset($start_date)) echo $start_date; ?></p></td>
            </tr>
            <tr style="background:transparent" >
                <td colspan="6">&nbsp;</td>
            </tr>
            <tr>
                <th align="left" width="13%">Event year</th>
                <th align="left" width="15%">Venue</th>
                <th align="left" width="15%">Address</th>
                <th width="10%" align="center">Organizer</th>
                <th width="7%" align="center">Impl. Partner</th>
                <th width="8%" align="center">Cost sharing</th>
            </tr>
            <tr class="whiteTd" >
                <td align="left"><p class="text-info"><?php if (isset($year)) echo $year; ?></p></td>
                <td align="left"><p class="text-info"><?php if (isset($venue)) echo $venue; ?></p></td>
                <td align="left"><p class="text-info"><?php if (isset($address)) echo $address; ?></p></td>
                <td align="center"><p class="text-info"><?php if (isset($implemented_by)) echo $implemented_by; ?></p></td>
                <td align="center"> <p class="text-info"><?php if (isset($country)) echo $country; ?></p></td>
                <td align="center"></td>
            </tr>
        </table-->
        <!---organizer and impl partner -->
        <br />
        <hr />
        <h5 class="text-error" style="text-align: center">Main organizer and Implementing partners </h5>
        <hr />

        <br />
        <table width="100%">
            <tr>
                <td width="50%" style="vertical-align: top">
                    <span class="text-info"><strong>Main organizers</strong></span><br />
                    <table width="300px"  cellpadding="5" class="dataListing" id="cost_shares">
                        <tr>
                            <th align="left" width="10%">#</th>
                            <th align="left" width="75%">Oranizer</th>
                        </tr>
                         <?php
                        if (isset($main_organizer_array)) {
                            for ($i = 0; $i < count($main_organizer_array); $i++) {
                                echo '<tr>
                                        <td>' . ($i + 1) . '</td>
                                        <td>' . $main_organizer_array[$i][1] . '</td>
                                     </tr>';
                            }
                        }
                        ?>
                    </table>

                </td>
                <td width="50%" style="vertical-align: top">
                    <!-- total costs -->
                    <span class="text-info"><strong>Implementing partners</strong></span><br />
                    <table width="300px"  cellpadding="5" class="dataListing" id="cost_shares">
                        <tr>
                            <th align="left" width="10%">#</th>
                            <th align="left" width="75%">Implementing partners</th>
                        </tr>
                        <?php
                        if (isset($impl_partner_array)) {
                            for ($i = 0; $i < count($impl_partner_array); $i++) {
                                echo '<tr>
                                        <td>' . ($i + 1) . '</td>
                                        <td>' . $impl_partner_array[$i][1] . '</td>
                                     </tr>';
                            }
                        }
                        ?>
                    </table>
                    <!-- end total costs -->
                </td>
            </tr>
        </table>
        <br />

        <!-- end organizer and impl partner -->


        <br />
        <hr />
        <h5 class="text-error" style="text-align: center">Budget detail </h5>
        <hr />

        <br />
        <a href="../Event/budgetEntry?id=<?= $event_id ?>" class="btn text-success" style="margin-top:-6px;float: right;margin-bottom:0px;margin-right:5px" id=""><img src="../img/edit.png" />&nbsp;Edit budget entry</a>
        <table width="100%">
            <tr>
                <td width="50%" style="vertical-align: top">
                    <span class="text-info"><strong>Cost shares</strong></span><br />
                    <table width="300px"  cellpadding="5" class="dataListing" id="cost_shares">
                        <tr>
                            <th align="left" width="10%">#</th>
                            <th align="left" width="75%">Party</th>
                            <th align="left" width="15%">Share</th>
                        </tr>
                        <?php
                        for ($i = 0; $i < count($share); $i++) {
                            echo '<tr>
                    <td>' . ($i + 1) . '</td>
                    <td>' . $share[$i][1] . '</td>
                    <td>' . $share[$i][2] . '%</td>
                    </tr>';
                        }
                        ?>
                    </table>

                </td>
                <td width="50%" style="vertical-align: top">
                    <!-- total costs -->
                    <span class="text-info"><strong>Direct costs</strong></span><br />
                    <table width="300px"  cellpadding="5" class="dataListing" id="cost_shares">
                        <tr>
                            <th align="left" width="40%">Total direct cost</th>
                            <td align="left" width="60%"> <?php if(isset($unit)){echo $unit.' ';} echo $directcost_array[0][0]; ?> </td>
                        </tr>
                        <tr>
                            <th align="left" width="40%">Staff cost</th>
                            <td align="left" width="60%"><?php if(isset($unit)){echo $unit.' ';} echo $directcost_array[0][1]; ?></td>
                        </tr>
                        <tr>
                            <th align="left" width="40%">Travel cost</th>
                            <td align="left" width="60%"><?php if(isset($unit)){echo $unit.' ';} echo $directcost_array[0][2]; ?></td>
                        </tr>

                    </table>
                    <!-- end total costs -->
                </td>
            </tr>
        </table>
        <br />

        <!-- inkind contribution -->
        <span class="text-info"><strong>Inkind contribution</strong></span><br />
        <table width="100%"  cellpadding="5" class="dataListing" >
            <tr>
                <th width="5%">#</th>
                <th width="15%">Level</th>
                <th width="20%">Description</th>
                <th width="10%">No. of pax</th>
                <th width="10%">Hours</th>
                <th width="10%">Rate (per hour)</th>
                <th width="10%">Total</th>
            </tr>
            <?php
            $grandtotal = 0;
            if(!isset($unit)){$unit="Rs. ";}
            if (isset($inkind_contribution_array)) {
                for ($i = 0; $i < count($inkind_contribution_array); $i++) {
                    $total = ( intval($inkind_contribution_array[$i][3]) * intval($inkind_contribution_array[$i][4]) * intval($inkind_contribution_array[$i][5]));
                    $grandtotal +=$total;
                    echo ' <tr>
                                <td>' . ($i + 1) . '</td>
                                <td>' . $inkind_contribution_array[$i][1] . '</td>
                                <td>' . $inkind_contribution_array[$i][2] . '</td>
                                <td>' . $inkind_contribution_array[$i][3] . '</td>
                                <td>' . $inkind_contribution_array[$i][4] . '</td>
                                <td>'.$unit.' '. $inkind_contribution_array[$i][5] . '</td>
                                <td>'.$unit.' '. $total . '</td>
                            </tr>';
                }
            }
            
            ?>

            <tr>
                <td colspan="6" align="right"><h5 class="nicecolor">Grand Total : </h5></td>
                <td><h5 class="nicecolor"><?= $unit.' '.($grandtotal+$directcost_array[0][0]+$directcost_array[0][1]+$directcost_array[0][2]) ?> /-</h5></td>
            </tr>

        </table>

        <!-- end inkind contribution -->
        <br />

        <hr />
        <h5 class="text-error" style="text-align: center">Participants of the event</h5>
        <hr />

        <br />

        <input type="hidden" id="event_id" value="<?= $event_id ?>" />
        <a href="../Event/addParticipant?id=<?= $event_id ?>" class="btn text-success" style="margin-top:-6px;float: right;margin-bottom:0px;margin-right:5px;margin-bottom: 10px;" id=""><img src="../img/add-new.png" />&nbsp;Add new participant</a>
       
        <table width="100%" border="0" cellspacing="0" cellpadding="5" class="dataListing" >
            <tr>
                <th align="left" width="3%">S.N</th>
                <th align="left" width="13%">Name</th>
                <th align="left" width="15%">Email</th>
                <th align="left" width="15%">Address</th>
                <th width="10%" align="center">Mobile</th>
                <th width="7%" align="center">Type</th>
                <th width="8%" align="center">View</th>
            </tr>

            <?php
            if (isset($participants_array)) {
                if (count($participants_array) > 0) {
                    for ($i = 0; $i < count($participants_array); $i++) {
                        echo "<tr id='participant_row_" . $participants_array[$i][0] . "'>";
                        echo "<td align='left'>" . ($i + 1) . "</td>";
                        echo "<td align='left'><p class='text-info'>" . $participants_array[$i][1] . "</p></td>";
                        echo "<td align='left'>" . $participants_array[$i][4] . "</td>";
                        echo "<td align='left'>" . $participants_array[$i][3] . "</td>";
                        echo "<td align='center'>" . $participants_array[$i][5] . "</td>";
                        if ($participants_array[$i][2] == 0) {
                            echo "<td align='center'>Participant</td>";
                        } else if ($participants_array[$i][2] == 1) {
                            echo "<td align='center'>Instructor</td>";
                        } else {
                            echo "<td align='center'>Asst. Instructor</td>";
                        }
                        echo '<td align="center">
                            <a class= "text-success" href="../Person/viewPerson?id=' . $participants_array[$i][0] . '">view</a>
                                &nbsp; | &nbsp;
                                <a class= "text-error handcursor" id="removecandidate_' . $participants_array[$i][0] . '">unselect</a>
                            </td>';
                        echo "</tr>";
                    }
                }
            }
            ?>

        </table>


        <!--       
       
           <div>
               <table width="80%" class="table">
                   <tr>
                       <th>Name</th>
                       <th>Email</th>
                       <th>Address</th>
                       <th>Type</th>
                       <th>View</th>
       
                   </tr>
        <?php /*
          if (isset($participants_array)) {
          if (count($participants_array) > 0) {
          for ($i = 0; $i < count($participants_array); $i++) {
          echo "<tr>";
          echo "<td>" . $participants_array[$i][1] . "</td>";
          echo "<td>" . $participants_array[$i][4] . "</td>";
          echo "<td>" . $participants_array[$i][3] . "</td>";
          if ($participants_array[$i][2] == 1) {
          echo "<td>Instructor</td>";
          } else {
          echo "<td>Participant</td>";
          }
          echo '<td><p class= "text-success"><a href="../PersonController/viewPerson?id=' . $participants_array[$i][0] . '">view</a></p></td>';
          echo "</tr>";
          }
          }
          }
         * 
         */
        ?>
               </table>
           </div>
        -->

        <br />
        <hr />


        <?php
        /* Was designed for easy access.. but later removed */
        /*

          <div id="selected_candidates">
          <h5>Edit or Add participants from existing record:</h5>
          <?php
          if (isset($participants_array)) {
          if (count($participants_array) > 0) {
          $instructor_class = '';
          for ($i = 0; $i < count($participants_array); $i++) {
          if ($participants_array[$i][2] == "1") {
          $instructor_class = "greenBg";
          } else {
          $instructor_class = '';
          }
          echo '<p class="participants_' . $participants_array[$i][0] . ' ' . $instructor_class . '">';
          echo $participants_array[$i][1];
          echo '<a id="candidate_cross_' . $participants_array[$i][0] . '" ></a>';
          echo '</p>';
          }
          } else {
          //no participants selected
          }
          }
          ?>
          </div>
          <div style="clear:left" />
          <hr />

          <ul  class="nav nav-tabs" width="100%" style="margin:0 auto;border:1px solid #ccc;border-top-left-radius: 5px;border-top-right-radius: 5px;">
          <li><a  id="alphabet_A" >A</a></li>
          <li><a  id="alphabet_B">B</a></li>
          <li><a  id="alphabet_C">C</a></li>
          <li><a  id="alphabet_D">D</a></li>
          <li><a  id="alphabet_E">E</a></li>
          <li><a  id="alphabet_F">F</a></li>
          <li><a  id="alphabet_G">G</a></li>
          <li><a href="#" id="alphabet_H">H</a></li>
          <li><a href="#" id="alphabet_I">I</a></li>
          <li><a href="#" id="alphabet_J">J</a></li>
          <li><a href="#" id="alphabet_K">K</a></li>
          <li><a href="#" id="alphabet_L">L</a></li>
          <li><a href="#" id="alphabet_M">M</a></li>
          <li><a href="#" id="alphabet_N">N</a></li>
          <li><a href="#" id="alphabet_O">O</a></li>
          <li><a href="#" id="alphabet_P">P</a></li>
          <li><a href="#" id="alphabet_Q">Q</a></li>
          <li><a href="#" id="alphabet_R">R</a></li>
          <li><a href="#" id="alphabet_S">S</a></li>
          <li><a href="#" id="alphabet_T">T</a></li>
          <li><a href="#" id="alphabet_U">U</a></li>
          <li><a href="#" id="alphabet_V">V</a></li>
          <li><a href="#" id="alphabet_W">W</a></li>
          <li><a href="#" id="alphabet_X">X</a></li>
          <li><a href="#" id="alphabet_Y">Y</a></li>
          <li><a href="#" id="alphabet_Z">Z</a></li>
          </ul>

          <div  style="padding:10px 0 0 5px;border-left:1px solid #ccc;border-right:1px solid #ccc;border-bottom:1px solid #ccc;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">
          <center>Add participants : <input style="width:400px" type="text" placeholder="Search here" id="person_search_txt"/>
          <button class="btn" style="margin-top:-10px" id="person_search_btn"><i class="icon-search"></i></button>
          </center>

          </div>
          <center>
          <span style="width:50px;height:17px;display:block" >
          <span id="person_loading_message" style="display:none">
          <img src ="../../img/loading.gif"  />
          <p class="text-info" style="display:inline">Loading...</p>
          </span>
          </span>

          </center>
          <hr style="margin-top:3px;">
          <div  style="border:1px solid #ccc;padding:5px" id="addParticipants_person_div">
          <input type="hidden" value="<?php echo $event_id; ?>" id="event_eventId" />
          <table width="100%" id="addParticipants_person_table" border="0">
          <tr>
          <td>

          </td>
          </tr>


          </table>
          </div>

         */
        /* end was designed for easy access but later removed */
        ?>

        </td>
        </tr>

    </table>
</div> <!-- end of container tag-->

