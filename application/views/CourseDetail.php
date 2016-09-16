

<style type="text/css">

</style>
<div class="container">

    <table style="border:1px solid #CCC;margin-top:30px;margin-bottom:30px;" width="100%" >
        <tr>
            <td style="padding:20px;">

                <?php
                if (isset($coursename)) {
                    ?>
                    <table class="dataListing" width="100%" cellspacing="0" cellpadding="5" border="0">
                        <tbody>
                            <tr>
                                <th  align="left">Event type : <b class="text-error"><?= $coursename ?></b></th>
                            </tr>
                        </tbody>
                    </table>
                    <br />
                    <table class="dataListing" width="400px" cellspacing="0" cellpadding="5" border="0">
                        <tbody>
                            <tr>
                                <th width="50px" align="center">#</th>
                                <th width="350px" align="left">Courses</th>
                            </tr>
                            <?php
                            for ($i = 0; $i < count($subcourse_data); $i++) {
                                echo '<tr>
                            <td align="center">' . ($i + 1) . '</td>
                            <td align="left">' . $subcourse_data[$i][1] . '</td>
                        </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                    <br />
                    <p class="text-error">List of events that are associated with this event type</p>

                    <table class="dataListing" width="100%" cellspacing="0" cellpadding="5" border="0">
                        <tbody>
                            <tr>
                                <th width="5%" align="center">#</th>
                                <th width="25%" align="left">Event title</th>
                                <th width="20%" align="left">Event type</th>
                                <th width="25%" align="left">Course</th>
                                <th width="15%" align="left">Date</th>
                                <th width="25%" align="left">Total Participants</th>
                            </tr>

                            <?php
                            for ($i = 0; $i < count($associated_events); $i++) {
                                echo '  <tr>
                            <td align="center">' . ($i + 1) . '</td>
                            <td align="left"><a href="../Event/viewEvent?id=' . $associated_events[$i][0] . '">' . $associated_events[$i][1] . '</a></td>
                            <td align="left">' . $associated_events[$i][2] . '</td>
                            <td align="left">' . $associated_events[$i][3] . '</td>
                            <td align="left">' . $associated_events[$i][4] . ' to ' . $associated_events[$i][5] . '</td>
                            <td align="left">' . $associated_events[$i][6] . '</td>
                                </tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                    <?php
                }
                ?>
            </td>
        </tr>

    </table>
</div> <!-- end of container tag-->

