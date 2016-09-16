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
                <?php
                if(isset($associated_message) && ($associated_message !='')){
                echo $associated_message;
                }
                ?>

                <h5>Course list</h5>

                <table width="100%" border="0" cellspacing="0" cellpadding="5" class="dataListing" >
                    <tr>
                        <th align="left" width="3%">S.N</th>
                        <th align="left" width="80%">Event Type</th>
                        <th style="width:17%">Actions</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < count($course_data); $i++) {


                        echo "<tr>";
                        echo "<td style='width:50px'>" . ($i + 1) . "</td>";
                        echo '<td style="text-align:left"><p class="text-success"><b><a href="../Course/viewCourse?id=' . $course_data[$i][0] . '">' . $course_data[$i][1] . '</a></b>&nbsp; &nbsp; #(' . $course_data[$i][2] . ' subcourse)</p></td>';
                        echo '<td style="width:350px">
                        <a href="../Course/editCourse?id=' . $course_data[$i][0] . '"><button class="btn btn-info" id="course_edit_' . $course_data[$i][0] . '"><span class="icon-trash icon-pencil"></span>&nbsp;Edit</button></a>
                        <a href="../Course/deleteCourse?id=' . $course_data[$i][0] . '" onclick="return window.confirm(\'are you sure want to delete? \n All subcourses will be deleted. ?\')"><button class="btn btn-danger" id="course_delete_' . $course_data[$i][0] . '"><span class="icon-trash icon-white"></span>&nbsp;Delete</button></a>';

                        echo '</td>';

                        echo "</tr>";
                    }
                    ?>
                </table>




<!--







                <table class="table table-striped" border="0">
                    <tr>
                        <th style="width:50px">S.N.</th>
                        <th style='text-align:left'>Course title</th>

                        <th style="width:160px">Actions</th>
                    </tr>

                    <?php
                    /*
                    for ($i = 0; $i < count($course_data); $i++) {


                        echo "<tr>";
                        echo "<td style='width:50px'>" . ($i + 1) . "</td>";
                        echo '<td style="text-align:left"><p class="text-success"><b><a href="../CourseController/viewCourse?id=' . $course_data[$i][0] . '">' . $course_data[$i][1] . '</a></b></p><sub>(' . $course_data[$i][2] . ' subcourse)</sub></td>';
                        echo '<td style="width:350px">
                        <a href="../CourseController/editCourse?id=' . $course_data[$i][0] . '"><button class="btn btn-info" id="course_edit_' . $course_data[$i][0] . '"><span class="icon-trash icon-pencil"></span>&nbsp;Edit</button></a>
                        <a href="../CourseController/deleteCourse?id=' . $course_data[$i][0] . '" onclick="return window.confirm(\'are you sure want to delete? \n All subcourses will be deleted. ?\')"><button class="btn btn-danger" id="course_delete_' . $course_data[$i][0] . '"><span class="icon-trash icon-white"></span>&nbsp;Delete</button></a>';

                        echo '</td>';

                        echo "</tr>";
                    }
                    */
                    ?>

                </table>
-->
            </td>
        </tr>
    </table>
</div> <!-- end of container tag-->
