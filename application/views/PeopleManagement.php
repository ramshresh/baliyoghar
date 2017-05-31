<style type="text/css">
    table.table tr th{
        text-align: center;
        background:rgba(0,255,0,0.1);
    }
    table.table{
        border:1px solid #ccc;
    }
</style>
<div class="container">

    <table style="border:0px solid #CCC;margin:30px 0 30px 0" width="100%" class="getBg">
        <tr>
            <td style="padding:20px">
                <?php echo form_open_multipart('Person/searchPeople'); ?>
                <div  style="padding:10px 0 0 5px;border:1px solid #ccc;border-radius: 5px;">
                    <table width="100%" border="0">
                        <tr>
                            <td width="50%">

                                <input style="width:400px" type="text"  name="person_searchString" placeholder="Search people" id="person_search_txt" value="<?php if (isset($search_string)) echo $search_string; ?>"/>
                                <button class="btn" style="margin-top:-10px" id="person_search_btn1"><i class="icon-search"></i></button>
                                
                            </td>

                        </tr>
                    </table>
                </div>
                </form>
                <hr  style="margin-bottom:10px;"/>
                <p class="text-success" style="display:inline-block;">Showing page no: <?php echo $current_page; ?> of <?php echo $total_pages; ?></p>
                <p class="text-info" style="margin-left:100px;display:inline-block"> Go to page &nbsp;&nbsp;</p>
                <select id="personPageno" style="display:inline-block">

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

                <span class="msfont">List of people.</span>

                <table width="100%" border="0" cellspacing="0" cellpadding="5" class="dataListing" >
                    <tr>
                        <th align="left" width="3%">S.N</th>
                        <th align="left" width="18%">Name</th>
                        <th align="left" width="">Contact address</th>
                        <th align="left" width="10%">Mobile</th>
                        <th width="15%" align="center">Email</th>
                        <th width="12%" align="center">Organization</th>
                        <th width="12%" align="center">Position</th>
                        <th style="width:160px">Actions</th>
                    </tr>

                    <?php
                    $string = '';
                    if (isset($person_data)) {
                        $count = count($person_data);
                        if ($count > 0) {
                            for ($i = 0; $i < $count; $i++) {
                                $string .= '<tr>';

                                $string .= '<td>';
                                $string .= ($current_page - 1) * 30 + $i + 1;
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= '<p class="text-success"><b><a href="../Person/viewPerson?id=' . $person_data[$i][0] . '">' . $person_data[$i][1] . ' ' . $person_data[$i][2] . '</a></b></p>';
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= $person_data[$i][3];
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= $person_data[$i][4];
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= $person_data[$i][5];
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= $person_data[$i][6];
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= $person_data[$i][7];
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= '<a href="../Person/edit?id=' . $person_data[$i][0] . '"><button class="btn btn-info" id="personMgmt_edit_' . $person_data[$i][0] . '"><span class="icon-trash icon-pencil"></span>&nbsp;Edit</button></a>';
                                $string .= '&nbsp;<a href="../Person/delete?id=' . $person_data[$i][0] . '" onClick="return window.confirm(\'Are you sure want to delete\');"><button class="btn btn-danger" id="eventMgmt_del_' . $person_data[$i][0] . '"><span class="icon-trash icon-white"></span>&nbsp;Delete</button></a>';

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




                <!--
                
                
                                <table class="table table-striped" style="margin-top:20px">
                                    <tr>
                                        <th style="width:50px">S.N.</th>
                                        <th>Name</th>
                                        <th>Contact address</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Organization</th>
                                        <th>Position</th>
                                        <th style="width:160px">Actions</th>
                                    </tr>
                
                
                <?php
                /*
                  $string = '';
                  if (isset($person_data)) {
                  $count = count($person_data);
                  if ($count > 0) {
                  for ($i = 0; $i < $count; $i++) {
                  $string .= '<tr>';

                  $string .= '<td>';
                  $string .= ($current_page - 1) * 30 + $i + 1;
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= '<p class="text-success"><b><a href="../PersonController/viewPerson?id=' . $person_data[$i][0] . '">' . $person_data[$i][1] . ' ' . $person_data[$i][2] . '</a></b></p>';
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= $person_data[$i][3];
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= $person_data[$i][4];
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= $person_data[$i][5];
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= $person_data[$i][6];
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= $person_data[$i][7];
                  $string .= '</td>';
                  $string .= '<td>';
                  $string .= '<a href="../PersonController/editPerson?id=' . $person_data[$i][0] . '"><button class="btn btn-info" id="personMgmt_edit_' . $person_data[$i][0] . '"><span class="icon-trash icon-pencil"></span>&nbsp;Edit</button></a>';
                  $string .= '&nbsp;<a href="../PersonController/deletePerson?id=' . $person_data[$i][0] . '" onClick="return window.confirm(\'Are you sure want to delete\');"><button class="btn btn-danger" id="eventMgmt_del_' . $person_data[$i][0] . '"><span class="icon-trash icon-white"></span>&nbsp;Delete</button></a>';

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
                 * 
                 */
                ?>
                
                                </table>
                                
                -->
            </td>
        </tr>
    </table>
</div> <!-- end of container tag-->
