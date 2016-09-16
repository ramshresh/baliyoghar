

<style type="text/css">

</style>
<div class="container">

    <table style="border:1px solid #CCC;margin-top:30px;margin-bottom:30px;" width="100%" >
        <tr>
            <td style="padding:20px;">

                <?php
                $title = 'Home';
                if (!($this->session->userdata('role') == "superadmin")) {
                    echo '<center>
                            <h3>   
                                <img src="../img/access.png" />
                                <font color="#f57939">Access Denied !</font>
                            </h3>
                            <p class="text-info">
                                <b>You don\'t have privilege to access this page. Please contact your administrator.</b>
                            </p>	
                          </center>';
                } else {
                    // if administrator logs in

                    if (isset($page) && $page != '') {
                        switch ($page) {
                            case 'course':
                                ?>
                                <table width="100%" style="border:1px solid #ccc;background:rgba(250,250,250,0.9);">
                                    <tr>
                                        <td style="padding:10px;">
                                            <img src="../img/cms.png" /> 
                                            <b class="text-info size16">Welcome to control panel : COURSES</b>
                                        </td>
                                    </tr>
                                </table>
                                <br /><br />
                                <img src="../img/list.png" /> 
                                <b class="text-info size14">List of deleted courses</b>
                                <br />
                                <table class="dataListing" width="100%" cellspacing="0" cellpadding="5" border="0">
                                    <tbody>
                                        <tr>
                                            <th width="5%" align="center">#</th>
                                            <th width="20%" align="left">Course</th>
                                            <th width="17%" align="left">Deleted by</th>
                                            <th width="13%" align="left">Deleted date</th>
                                            <th width="25%" align="left">Subcourses</th>
                                            <th width="20%" align="left">Action  </th>
                                        </tr>

                                        <?php
                                        if (isset($detail)) {
                                            $string = '';
                                            for ($i = 0; $i < count($detail); $i++) {
                                                $string .='<tr>';
                                                $string .= ' <td align="center" >' . ($i + 1) . '</td>';
                                                $string .= ' <td align="left"><a href="../Course/viewCourse?id=' . $detail[$i][0] . '">' . $detail[$i][1] . '</a></td>';
                                                $string .= ' <td align="left">' . $detail[$i][2] . '</td>';
                                                $string .= ' <td align="left">' . $detail[$i][3] . '</td>';
                                                $string .= ' <td align="left">';
                                                $subcourse = $detail[$i][4];
                                                for ($j = 0; $j < count($subcourse); $j++) {
                                                    $string .= $subcourse[$j][1] . "<br />";
                                                }
                                                $string .= ' </td>';
                                                $string .= ' <td align="left">';
                                                $string .= ' <a style="background:transparent" href="#" onclick="return alert(\'Not active now\');">Undo  |  Delete permanently</a>';
                                                $string .= ' </td>';
                                                $string .= '</tr>';
                                            }
                                            echo $string;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <!---------------------List of subcourses ------------------->

                                <hr />
                                <img src="../img/list.png" /> 
                                <b class="text-info size14">List of deleted subcourses</b>
                                <br />
                                <table class="dataListing" width="100%" cellspacing="0" cellpadding="5" border="0">
                                    <tbody>
                                        <tr>
                                            <th width="5%" align="center">#</th>
                                            <th width="20%" align="left">Subcourse</th>
                                            <th width="17%" align="left">Deleted by</th>
                                            <th width="13%" align="left">Deleted date</th>
                                            <th width="25%" align="left">Parent course</th>
                                            <th width="20%" align="left">Action  </th>
                                        </tr>
                                        <?php
                                        if (isset($sdetail)) {
                                            $string = '';
                                            for ($i = 0; $i < count($sdetail); $i++) {
                                                $string .='<tr>';
                                                $string .= ' <td align="center" >' . ($i + 1) . '</td>';
                                                $string .= ' <td align="left"><a href="../Course/viewCourse?id=' . $sdetail[$i][0] . '">' . $sdetail[$i][1] . '</a></td>';
                                                $string .= ' <td align="left">' . $sdetail[$i][2] . '</td>';
                                                $string .= ' <td align="left">' . $sdetail[$i][3] . '</td>';
                                                $string .= ' <td align="left">' . $sdetail[$i][4] . '</td>';
                                                $string .= ' <td align="left">';
                                                $string .= ' <a style="background:transparent" href="#" onclick="return alert(\'Not active now\');">Undo  |  Delete permanently</a>';
                                                $string .= ' </td>';
                                                $string .= '</tr>';
                                            }
                                            echo $string;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <?php
                                break;
                            case 'event':
                                ?>
                                <table width="100%" style="border:1px solid #ccc;background:rgba(250,250,250,0.9);">
                                    <tr>
                                        <td style="padding:10px;">
                                            <img src="../img/cms.png" /> 
                                            <b class="text-info size16">&nbsp; Control panel : EVENTS</b>
                                        </td>
                                    </tr>
                                </table>
                                <br /><br />
                                <img src="../img/list.png" /> 
                                <b class="text-info size14">List of deleted events</b>
                                <br />
                                <table class="dataListing" width="100%" cellspacing="0" cellpadding="5" border="0">
                                    <tbody>
                                        <tr>
                                            <th width="5%" align="center">#</th>
                                            <th width="20%" align="left">Event title</th>
                                            <th width="22%" align="left">Course/subcourse</th>
                                            <th width="17%" align="left">Participants</th>
                                            <th width="10%" align="left">Deleted by</th>
                                            <th width="13%" align="left">Deleted date</th>
                                            <th width="20%" align="left">Action  </th>
                                        </tr>
                                        <tr>
                                            <td align="center" colspan="7">Not designed yet</td>
                                        </tr>
                                    </tbody>
                                </table>


                                <?php
                                break;
                            case 'people':
                                ?>
                                <table width="100%" style="border:1px solid #ccc;background:rgba(250,250,250,0.9);">
                                    <tr>
                                        <td style="padding:10px;">
                                            <img src="../img/cms.png" /> 
                                            <b class="text-info size16">&nbsp; Control panel : COURSES</b>
                                        </td>
                                    </tr>
                                </table>
                                <br /><br />
                                <img src="../img/list.png" /> 
                                <b class="text-info size14">List of deleted courses</b>
                                <br />
                                <table class="dataListing" width="100%" cellspacing="0" cellpadding="5" border="0">
                                    <tbody>
                                        <tr>
                                            <th width="5%" align="center">#</th>
                                            <th width="20%" align="left">Course</th>
                                            <th width="17%" align="left">Deleted by</th>
                                            <th width="13%" align="left">Deleted date</th>
                                            <th width="25%" align="left">Subcourses</th>
                                            <th width="20%" align="left">Action  </th>
                                        </tr>
                                        <tr>
                                            <td align="center" colspan="6">Not designed yet</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <?php
                                break;
                            case 'user':
                                ?>
                                <table class="dataListing" width="100%" cellspacing="0" cellpadding="5" border="0">
                                    <tbody>
                                        <tr>
                                            <td colspan="6" align="left">
                                                <a href="../control/deleteAllLogs"><button class="btn btn-danger">Clear all data<?php if (isset($deleted_count)) echo '(' . $deleted_count[4] . ')'; ?></button></a>
                                                <?php if (isset($deleted_count) && $deleted_count[4] > 500) { ?>
                                                <a href="../control/deleteAllLogsExceptTop" ><button class="btn btn-warning">Clear all except latest 500</button></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th width="5%" align="center">#</th>
                                            <th width="25%" align="left">Name</th>
                                            <th width="15%" align="left">Username</th>
                                            <th width="15%" align="left">Role</th>
                                            <th width="20%" align="left">Login time</th>
                                            <th width="20%" align="left">Logout time </th>
                                        </tr>

                                        <?php
                                        if (isset($login_logout_array) && count($login_logout_array) > 0) {
                                            for ($i = 0; $i < count($login_logout_array); $i++) {
                                                echo '<tr>';
                                                echo '<td align="center" >' . ($i + 1) . '</td>';
                                                echo '<td align="left" >'.$login_logout_array[$i][1].'</td>';
                                                echo '<td align="left">'.$login_logout_array[$i][2].'</td>';
                                                echo '<td align="left">'.$login_logout_array[$i][3].'</td>';
                                                echo '<td align="left">'.$login_logout_array[$i][4].'</td>';
                                                echo '<td align="left">'.$login_logout_array[$i][5].'</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                                break;
                            default:
                                ?>
                                <?php
                                break;
                        }
                    }
                }
                ?>



            </td>
        </tr>

    </table>
</div> <!-- end of container tag-->

