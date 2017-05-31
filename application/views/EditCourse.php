

<style type="text/css">
    input[type=text],button.btn-danger,button.btn-info{
        margin-bottom:5px;
    }
</style>
<div class="container">

    <table style="border:1px solid #CCC;margin-top:30px;margin-bottom:30px;" width="100%" class="getBg">
        <tr>
            <td style="padding:20px;">
                <?php
                if (isset($coursename)) {
                    echo form_open('Course/updateCourseName');
                    echo '<input type="hidden" name="editcourse_id" value="'.$courseid.'" />';
                    echo 'Course : <input type="text" name="editcourse_name" value="' . $coursename . '" id="editcourse_name" />';
                    echo '&nbsp;<button class="btn btn-info" id="editcourse_button_' . $courseid . '" >Update</button>';
                    echo '</form>';
                }
                ?>

                <hr />
                
                <div id="message" class="message-error" style="display:none;border-radius:10px">
                    <span class="text-error">The subcourse couldn't be deleted. It's associated with some events.</span>
                </div>
                
                <p class="text-info">Edit subcourses </p>
                <?php
                if (isset($subcourse_array)) {
                    $string = '';
                    for ($i = 0; $i < count($subcourse_array); $i++) {
                        $string .='<span id="subcourse_span_'.$subcourse_array[$i][0].'">';
                        $string .='<input type="text" value="' . $subcourse_array[$i][1] . '" id="subcourse_txt_' . $subcourse_array[$i][0] . '"/>';
                        $string .='&nbsp;<button class="btn btn-info" id="subcourse_btnedit_' . $subcourse_array[$i][0] . '">Edit</button>';
                        $string .='&nbsp;<button class="btn btn-danger" id="subcourse_btndelete_' . $subcourse_array[$i][0] . '">Delete</button>';
                        $string .= '<img src ="../img/loading.gif" style="margin-top: -10px; padding:5px;display:none" id="editcourse_img_' . $subcourse_array[$i][0] . '"/><br />';
                        $string .= '</span>';
                        
                    }
                    echo $string;
                }
                ?>
            </td>
        </tr>

    </table>
</div> <!-- end of container tag-->

