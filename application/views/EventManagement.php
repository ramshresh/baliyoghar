<style type="text/css">
    table.table tr th{
        text-align: center;
        background:rgba(0,255,0,0.1);
    }
    table.table{
        border:1px solid #ccc;
    }


    /*
    table.dataListing{
        color: #666666;
        font: 11px Tahoma,Geneva,sans-serif;
        border-left: 1px solid #CCCCCC;
        border-top: 1px solid #CCCCCC;
    }

    table.dataListing tr {
        color: #666666;
        font: 11px Tahoma,Geneva,sans-serif;
    }
    table.dataListing th {
        background: none repeat scroll 0 0 #EFEFEF;
        border-bottom: 1px solid #CCCCCC;
        border-left: 1px solid #F6F6F6;
        border-right: 1px solid #CCCCCC;
        color: #333333;
        font: bold 11px/16px Arial,Helvetica,sans-serif;
        padding: 5px;
        text-shadow: 1px 1px 0 #F6F6F6;
    }
    table.dataListing tr.whiteTd {
        background-color: #FFFFFF;
    }
    table.dataListing tr.fadeTd td {
        background-color: #F9F9F9;
    }
    table.dataListing td {
        background: none repeat scroll 0 0 #FCFCFC;
        border-bottom: 1px solid #CCCCCC;
        border-left: 1px solid #F6F6F6;
        border-right: 1px solid #CCCCCC;
        color: #444444;
        padding: 5px;
    }
    table.dataListing td p.text-info{
        margin:0;
        padding:0;
    }
    */


    form{
        margin:0px;
    }
</style>
<div class="container">

    <table style="border:0px solid #CCC;margin:30px 0 30px 0" width="100%" class="getBg">
        <tr>
            <td style="padding:20px">
                <div  style="padding:10px 0 0 5px;border:1px solid #ccc;border-radius: 5px;">
                    <table width="100%" border="0">
                        <tr>
                            <td width="50%">
                                <?php echo form_open_multipart('Event/searchEvent'); ?>
                                <input type="hidden" name="identifier" value="all" />
                                <input style="width:400px"  name="event_searchString" type="text" placeholder="Search events by title" value="<?php if (isset($search_string)) echo $search_string; ?>" id="event_search_txt"/>
                                <button class="btn" style="margin-top:-10px" id=""><i class="icon-search"></i></button>
                                </form>
                            </td>
                            <td align="right">
                                <!--
                                <?php// echo form_open_multipart('Event/searchEvent'); ?>
                                <input type="hidden" name="identifier" value="date" />
                                <p style="margin-top:-10px;display:inline-block">Search by dates </p>
                                <input type="text" class="datepicker" style="width:100px" name="event_start_date" placeholder="Enter start date">
                                <p class="text-info" style="display:inline-block;"> - </p> 
                                <input type="text" class="datepicker" style="width:100px" name="event_end_date" placeholder="Enter end date">
                                <button class="btn" style="margin-top:-10px;margin-right:10px" id=""><i class="icon-search"></i></button>
                                </form>
                                -->
                            </td>
                        </tr>
                    </table>
                </div>

                <hr  style="margin-bottom:10px;"/>
                <p class="text-success" style="display:inline-block;">Showing page no: <?php if (isset($current_page)) {
                                    echo $current_page;
                                } ?> of <?php if (isset($total_pages)) {
                                    echo $total_pages;
                                } ?></p>
                <p class="text-info" style="margin-left:100px;display:inline-block"> Go to page &nbsp;&nbsp;</p>
                <select id="eventPageno" style="display:inline-block">

                    <?php
                    for ($i = 0; $i < $total_pages; $i++) {
                        $selected = '';
                        if (($i + 1) == $current_page) {
                            $selected = "SELECTED";
                        }
                        echo '<option value="' . ($i + 1) . '" ' . $selected . '>' . ($i + 1) . '</option>';
                    }
                    ?>

                </select>

                <hr style="margin-top:0px;" />

                <h5>Event list</h5>

                <table width="100%" border="0" cellspacing="0" cellpadding="5" class="dataListing" >
                    <tr>
                        <th align="left" width="3%">S.N</th>
                        <th align="left" width="13%">Title</th>
                        <th align="left" width="8%">Event year</th>
                        <th align="left" width="15%">Course</th>
                        <th width="18%" align="center">Subcourse</th>
                        <th width="18%" align="center">Venue</th>
                        <th width="8%" align="center">Start date</th>
                        <th style="width:160px">Actions</th>
                    </tr>

                    <?php
                    $string = '';
                    if (isset($event_data)) {
                        $count = count($event_data);
                        if ($count > 0) {
                            for ($i = 0; $i < $count; $i++) {
                                $string .= '<tr>';

                                $string .= '<td>';
                                $string .= $i + 1;
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= '<p class="text-success"><b><a href="../Event/viewEvent?id=' . $event_data[$i][0] . '">' . $event_data[$i][1] . '</a></b></p>';
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= $event_data[$i][2];
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= $event_data[$i][3];
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= $event_data[$i][4];
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= $event_data[$i][5];
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= $event_data[$i][6];
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= '<a href="../Event/editEvent?id=' . $event_data[$i][0] . '"><button class="btn btn-info" id="eventMgmt_edit_' . $event_data[$i][0] . '"><span class="icon-trash icon-pencil"></span>&nbsp;Edit</button></a>';
                                $string .= '&nbsp;<a href="../Event/deleteEvent?id=' . $event_data[$i][0] . '" onClick="return window.confirm(\'Are you sure want to delete\');"><button class="btn btn-danger" id="eventMgmt_del_' . $event_data[$i][0] . '"><span class="icon-trash icon-white"></span>&nbsp;Delete</button></a>';

                                $string .= '</td>';

                                $string .= '</tr>';
                            }
                            echo $string;
                        } else {
                            echo '<tr><td colspan="8"><p class="text-error"><b>No data</b></p></td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8"><p class="text-error"><b>No data</b></p></td></tr>';
                    }
                    ?>
                </table>

<!--<table class="table table-striped" style="margin-top:20px">
    <tr>
        <th style="width:50px">S.N.</th>
        <th>Event title</th>
        <th>Event year</th>
        <th>Course</th>
        <th>Sub course</th>
        <th>Venue</th>
        <th>Start date</th>
        <th style="width:160px">Actions</th>
    </tr>


                <?php
                /*
                  $string = '';
                  if (isset($event_data)) {
                  $count = count($event_data);
                  if ($count > 0) {
                  for ($i = 0; $i < $count; $i++) {
                  $string .= '<tr>';

                  $string .= '<td>';
                  $string .= $i + 1;
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= '<p class="text-success"><b><a href="../EventController/viewEvent?id=' . $event_data[$i][0] . '">'.$event_data[$i][1].'</a></b></p>';
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= $event_data[$i][2];
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= $event_data[$i][3];
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= $event_data[$i][4];
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= $event_data[$i][5];
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= $event_data[$i][6];
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= '<a href="../EventController/editEvent?id='.$event_data[$i][0].'"><button class="btn btn-info" id="eventMgmt_edit_' . $event_data[$i][0] . '"><span class="icon-trash icon-pencil"></span>&nbsp;Edit</button></a>';
                  $string .= '&nbsp;<a href="../EventController/deleteEvent?id=' . $event_data[$i][0] . '" onClick="return window.confirm(\'Are you sure want to delete\');"><button class="btn btn-danger" id="eventMgmt_del_' . $event_data[$i][0] . '"><span class="icon-trash icon-white"></span>&nbsp;Delete</button></a>';

                  $string .= '</td>';

                  $string .= '</tr>';
                  }
                  echo $string;
                  } else {
                  echo '<tr><td colspan="8"><p class="text-error"><b>No data</b></p></td></tr>';
                  }
                  } else {
                  echo '<tr><td colspan="8"><p class="text-error"><b>No data</b></p></td></tr>';
                  }
                 */
                ?>

</table>

                -->
            </td>
        </tr>
    </table>
</div> <!-- end of container tag-->
