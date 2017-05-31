
<div class="container">
 <?php
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
        ?>
    <table style="border:1px solid #CCC; margin-top:30px" width="100%" class="getBg">
        <tr><td style="padding:20px">
                <?php echo validation_errors(); ?>
                <?php if (isset($insert) && isset($value)) echo '<span style="color:green">'.$insert . ' ' . $value.' </span>   <br />'; ?> 
                <?php // echo form_open('CourseController/grabAndValidateSubCourseData'); ?>

                <table border="0" width="100%">
                    <tr>
                        <td style="width:180px;height:50px"><label>Event type : </label> </td>
                        <td style="width:420px">
                            <input type="hidden" name="dropdownindex" id="dropdownindex"/>
                            <span id="hiddenspan_existing_category" >
                                <span id="hiddenspan_category" >
                                    <select name="course_category" id="course_category">
                                        <option value="">-- SELECT --</option>
                                        <?php
                                        if (isset($CourseContent)) {
                                            echo $CourseContent;
                                        }
                                        ?>
                                    </select>
                                </span>
                                <input type="button" id="course_btn_add_new" class="btn" value="+ Add new" style="margin-top: -10px"/>
                            </span>

                            <span id="hiddenspan_add_new_category" style="display: none">
                                <input type="text" id="course_txt_add_new" placeholder="Enter new event type" required="required"/>
                                <button class="btn btn-info" onClick="return false;" style="margin-top: -10px" id="course_btn_add">Add</button>
                                <img src ="../img/loading.gif" style="margin-top: -10px; padding:5px;display:none" id="loading_image"/>
                                <input type="button" id="course_btn_cancel" class="btn" value="Cancel" style="margin-top: -10px"/>
                            </span>
                        </td>
                        <td rowspan="2" style="padding-left:10px;vertical-align: top" >
                            <div id="course_div_progress" style="padding:10px;border:1px solid #ccc;border-radius:5px;display:none">
                               
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-right:30px;vertical-align: top;"><label style="padding-top:40px;">Course : </label> </td>
                        <td style="vertical-align: top;">
                            <hr style="margin-top:5px"/>
                            <input type="text" name="course_subcategory" id="course_subcategory" placeholder="Enter course" required="required">
                           <br/>  <button class="btn btn-info" id="course_btn_save" >Save</button> 
                            <img src ="../img/loading.gif" style="margin-top: -10px; padding:5px;display:none" id="loading_image_subcourse"/>
                        </td>
                    </tr>
                    
                    
                </table>
               <!-- </form> -->
            </td>
        </tr>

    </table>
    <?php } ?>
</div> <!-- end of container tag-->


