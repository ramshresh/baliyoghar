<style type="text/css">
    table.table tr th{
        text-align: center;
        background:rgba(51,154,184,0.5);
    }
    table.table{
        border:1px solid #ccc;
    }
</style>
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
    <table style="border:0px solid #CCC;margin:30px 0 30px 0" width="100%">
        <tr>
            <td style="padding:20px">
                <a href="../User/userList">
                    <button class="btn">
                        <h6 class="text-info">  Manage existing users </h6>
                    </button>
                </a>&nbsp;&nbsp;
                <a href="../Control/vu">View user login/logout<?php if (isset($deleted_count)) echo '(' . $deleted_count[4] . ')'; ?></a>
                <br/><br/>
                <h6 class="text-info" style="margin:5px;">+ Create a new user </h6>
                <?php //echo form_open('User/newUser'); ?>
                <div id="user_create_new_div" style="border:1px solid #ccc;border-radius:5px;padding:10px;">
                    <?php
                    //  echo form_open_multipart('PersonController/grabAndValidatePersonData', array('id' => 'people_entry_form', 'name' => 'people_entry_form'));
                    ?> 
                    <input type="text" id="user_fullname" name="user_fullname" placeholder="Enter full name" required="required"/>
                    <br /><input type="text" id="user_username" name="user_username" placeholder="Enter username" required="required"/>
                    <br /><input type="password" id="user_password" name ="user_password" placeholder="Enter password" required="required"/>
                    <br /><input type="password" id="user_confirm_password" name ="user_confirm_password" placeholder="Confirm password" required="required"/>
                    <br/><select name="user_role" id="user_role" >
                        <option value="">--Select role--</option>
                        <option value="superadmin">Super Admin</option>
                        <option value="subadmin">Sub Admin</option>
                        <option value="user">User</option>
                    </select><br/>
                    <br /><button class="btn btn-info" id="createuser_btn" style="margin-top: -10px" id="">Create</button>
                    <img src ="../img/loading.gif" style="margin-top: -10px; padding:5px;display:none" id="loading_image"/>
                </div>
                <div id="usercreatesuccess" class="message-success" style="display:none">
                    <center><p class="text-success">User created successfully.</p></center>
                </div>
                <div id="usercreatefail" class="message-error" style="display:none">
                    <center><p class="text-error">User creation failed! Please try again.</p></center>
                </div>

                <br />
                <hr />
                <h6 class="text-info" style="margin:5px;">Manage default privileges </h6>

                <div id="user_privilege_div" style="border:1px solid #ccc;border-radius:5px;padding:10px;">
                    <?php echo form_open('UserController/privilege_subadmin'); ?>
                    <table class="table" style="margin-top:10px;margin-bottom:10px">
                        <tr>
                            <th colspan="5" style="text-align:left;background:rgba(240,240,240,0.7);color:#3097b5">
                                Default Privileges of Sub Admin
                            </th>
                        </tr>
                        <tr >
                            <th>S.N</th>
                            <th>Form</th>
                            <th>Create</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Person</td>
                            <td><input type="checkbox" name="person_create" value="1"> Allow create</td>
                            <td><input type="checkbox" name="person_edit" value="1"> Allow edit</td>
                            <td><input type="checkbox" name="person_delete" value="1"> Allow delete</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Event</td>
                            <td><input type="checkbox" name="event_create" value="1"> Allow create</td>
                            <td><input type="checkbox" name="event_edit" value="1"> Allow edit</td>
                            <td><input type="checkbox" name="event_delete" value="1"> Allow delete</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Course and subcourse</td>
                            <td><input type="checkbox" name="course_create" value="1"> Allow create</td>
                            <td><input type="checkbox" name="course_edit" value="1"> Allow edit</td>
                            <td><input type="checkbox" name="course_delete" value="1"> Allow delete</td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align:right">
                                <button class="btn btn-info" onClick="return false;" style="margin-top: -10px" id="course_btn_add">Save</button>
                            </td>

                        </tr>
                    </table>
                    </form>
                    <?php echo form_open('UserController/privilege_user'); ?>

                    <table class="table" style="margin-bottom:10px">
                        <tr>
                            <th colspan="5" style="text-align:left;background:rgba(240,240,240,0.7);color:#3097b5">
                                Default Privileges of User
                            </th>
                        </tr>
                        <tr >
                            <th>S.N</th>
                            <th>Form</th>
                            <th>Create</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Person</td>
                            <td><input type="checkbox" name="person_create" value="1"> Allow create</td>
                            <td><input type="checkbox" name="person_edit" value="1"> Allow edit</td>
                            <td><input type="checkbox" name="person_delete" value="1"> Allow delete</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Event</td>
                            <td><input type="checkbox" name="event_create" value="1"> Allow create</td>
                            <td><input type="checkbox" name="event_edit" value="1"> Allow edit</td>
                            <td><input type="checkbox" name="event_delete" value="1"> Allow delete</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Course and subcourse</td>
                            <td><input type="checkbox" name="course_create" value="1"> Allow create</td>
                            <td><input type="checkbox" name="course_edit" value="1"> Allow edit</td>
                            <td><input type="checkbox" name="course_delete" value="1"> Allow delete</td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align:right">
                                <button class="btn btn-info" onClick="return false;" style="margin-top: -10px" id="course_btn_add">Save</button>
                            </td>

                        </tr>
                    </table>
                    </form>
                </div>
            </td>
        </tr>
    </table>
    <?php } ?>
</div> <!-- end of container tag-->


<script type="text/javascript">
    $(document).ready(function(){
        
        $('#createuser_btn').click(function(){
            var confirm_password = $('#user_confirm_password').val();
            var password = $('#user_password').val();
            var username = $.trim($('#user_username').val());
            var role = $.trim($('#user_role').val());
            var fullname = $.trim($('#user_fullname').val());
            
            if(username != '' && fullname != ''){
                if(password==confirm_password){
                    $('#loading_image').show();
                    $.ajax({						
                        type: "POST",
                        url: "../User/createUser",
                        data: {
                            fullname:fullname,
                            username:username,
                            password:password,
                            role:role
                        },
                        cache: false,
                        error: function(xhr, status, error) {
                            $('#loading_image').hide();
                            alert('Error !\n Please try again.\n(Please check your internet connection.)');
                        },
                        success: function (msg) {
                            $('#loading_image').hide();
                            if($.trim(msg)=='1'){
                                $('#usercreatefail').hide();
                                $('#usercreatesuccess').show();
                                //reset form
                                $('#user_confirm_password').val('');
                                $('#user_password').val('');
                                $('#user_username').val('');
                                $('#user_role').val('');
                                $('#user_fullname').val('');
                            }else{
                                $('#usercreatefail').show();
                                $('#usercreatesuccess').hide();
                               
                            }
                        }
                    });
                }else{
                    alert('Password didnot match');
                }
            }else{
                alert('Username and fullname fields both required');
            }
        });
        
    });
</script>