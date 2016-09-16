

<style type="text/css">
    #addParticipants_person_table tr td{
        padding:10px;
    }
    #addParticipants_person_table tr td:hover{
        background:rgba(0,0,0,0.1);
    }
    #addParticipants_person_table tr {
        border-bottom:2px solid #f7f7f9;
    }
    .addParticipants_person_table_div{
        border:1px solid #ccc;
        border-radius:5px;
        margin-top:10px;
        background:#f7f7f9;

    }
    .addParticipants_person_table_div input[type=checkbox]{
        margin-top:-5px;
    }
    .addParticipants_person_table_div p{
        font-size: 16px;
        padding:10px;
    }
    td.instructor{
        background:rgba(0,255,0,0.08);
    }
    p[class^="participants_"]{
        border:1px solid #ccc;
        padding:2px 2px 2px 2px;
        border-radius:3px;
        margin-bottom:1px;
        margin-right:1px;
        width:auto;
        float:left;
        color:#555;
        font: 12px arial, verdana, sans-serif;
    }
    p[class^="participants_"] a{
        background:url(../../img/del.png) right no-repeat;
        width:16px;
        height:16px;
        display:inline-block;
    }
    p[class^="participants_"] a:hover{
        background:url(../../img/del_red.png) right no-repeat;
    }
    p.greenBg{
        background:rgba(0,255,0,0.1);
    }
</style>
<div class="container">

    <table style="border:1px solid #CCC;margin-top:30px;margin-bottom:30px;" width="100%" >
        <tr>
            <td style="padding:20px;">
        <center>  <span style="color:green"><?php if (isset($insert)) echo $insert; ?></span></center>
        <table border="0" width="100%">
            <tr>
                <td width="10%"><b><p class="text-info"> Event title : </p></b></td>
                <td width="15%"><p class="text-info"><?php if (isset($title)) echo $title; ?> </p></td>
                <td width="10%"></td>
                <td ></td>
                <td></td>
            </tr>
            <tr>
                <td ><b><p class="text-info">Course : </p></b></td>
                <td><p class="text-info"><?php if (isset($course)) echo $course; ?></p></td>
                <td><b><p class="text-info">Sub course :</p></b></td>
                <td><p class="text-info"><?php if (isset($subcourse)) echo $subcourse; ?></p></td>
                <td></td>
            </tr>
            <tr>
                <td ><b><p class="text-info">Start date:</p></b> </td>
                <td><p class="text-info"><?php if (isset($start_date)) echo $start_date; ?></p></td>
                <td><b><p class="text-info">End date : </p></b></td>
                <td><p class="text-info"><?php if (isset($end_date)) echo $end_date; ?></p></td>
                <td></td>
            </tr>
            <tr>
                <td><b><p class="text-info" >Venue : </p></b></td>
                <td><p class="text-info"><?php if (isset($venue)) echo $venue; ?></p></td>
                <td><b><p class="text-info">Address : </p></b></td>
                <td><p class="text-info"><?php if (isset($address)) echo $address; ?></p></td>
                <td></td>
            </tr>
        </table>
        <div id="selected_candidates"><p class="text-error">selected candidates :</p>
         <!--   <p class="participants_ redBg">gaurab <a href="#"></a></p>
            <p class="participants_"> saurab <a href="#" id="candidate_cross_"></a></p> -->
        </div>
        <div style="clear:left" />
        <hr />

                <ul  class="nav nav-tabs" width="100%" style="margin:0 auto;border:1px solid #ccc;border-top-left-radius: 5px;border-top-right-radius: 5px;">
                    <li><a href="#" id="alphabet_A" >A</a></li>
                    <li><a href="#" id="alphabet_B">B</a></li>
                    <li><a href="#" id="alphabet_C">C</a></li>
                    <li><a href="#" id="alphabet_D">D</a></li>
                    <li><a href="#" id="alphabet_E">E</a></li>
                    <li><a href="#" id="alphabet_F">F</a></li>
                    <li><a href="#" id="alphabet_G">G</a></li>
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
            <center><input style="width:400px" type="text" placeholder="Search candidates" id="person_search_txt"/>
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
                <?php
                $COLUMN = 3;
                $ROW = (count($person_data) / $COLUMN) > (intval(count($person_data) / $COLUMN)) ? (intval(count($person_data) / $COLUMN)) + 1 : intval((count($person_data) / $COLUMN));
                $string = "";
                $k = 0;
                for ($i = 0; $i < $ROW; $i++) {
                    $string .= "<tr>";
                    for ($j = 0; $j < $COLUMN; $j++) {
                        $string .= "<td id='detail_" . $person_data[$k][0] . "'>";
                        $string .= "<input type='hidden' id='name_".$person_data[$k][0]."' value='".$person_data[$k][2]."' />";
                        $string .="<strong>" . $person_data[$k][1] . " " . $person_data[$k][2] . "</strong>";
                        $string .= "<br />" . $person_data[$k][4] . "<br /> " . $person_data[$k][3];
                        $string .= '<div class="addParticipants_person_table_div" >

                                    <span class="btn"><input type="checkbox" id="personCheck_' . $person_data[$k][0] . '"/>
                                        <label style="display:inline" for="personCheck_' . $person_data[$k][0] . '">
                                            <p style="display:inline" class="text-info">select</p>
                                        </label>
                                    </span>
                                     <span style="width:150px;height:27px;display:inline-block">&nbsp;
                                    <span class="btn" style="display:none" id="instructorSpan_' . $person_data[$k][0] . '"><input type="checkbox" id="instructorCheck_' . $person_data[$k][0] . '"/>
                                        <label style="display:inline" for="instructorCheck_' . $person_data[$k][0] . '">
                                            <p style="display:inline" class="text-success">Instructor?</p>
                                        </label>
                                    </span>
                                    </span>
                                    <span style="width:50px;height:27px;display:inline-block">
                                    &nbsp;
                                   <img src ="../../img/loading.gif" id="loadingImage_' . $person_data[$k][0] . '" style="display:none" />
                                       </span>


                                </div>';
                        $string .= "</td>";
                        $k++;
                    }
                    $string .= "</tr>";
                }
                echo $string;
                ?>

            </table>
        </div>

        </td>
        </tr>

    </table>
</div> <!-- end of container tag-->

