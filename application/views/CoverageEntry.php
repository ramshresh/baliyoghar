
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
        <tr>
            <td style="padding:20px" >
                <?php
                if (isset($_GET['s']) && $_GET['s'] == 1) {
                    echo '<div class="message-success">New coverage level added successfully.</div>';
                }
                if (isset($_GET['s']) && $_GET['s'] == 2) {
                    echo '<div class="message-error">New coverage level Couldn\'t be added. Please try again later.</div>';
                }
                if (isset($_GET['s']) && $_GET['s'] == 3) {
                    echo '<div class="message-error">Coverage level already exists.</div>';
                }
                ?>
                <h5 class="nicefont nicecolor">Coverage entry form </h5>
                <?php echo form_open('Home/addCoverageLevel', array('name' => 'coverage_level_form', 'id' => 'coverage_level_form')); ?>
                <label for="coverage_title" style="display:inline-block">Coverage level : </label>
                <input type="text" id="coverage_level" name="coverage_level" required />
                <input type="submit" class="btn btn-info" name="submit" value="save" />
                <?php echo form_close(); ?>
                <hr />
                <h5 class="nicefont nicecolor" style="display:inline-block">Add coverage location </h5>
                <span style="display:none" id="coverage_location_loading"><img src="../img/loading.gif" />&nbsp;<span class="text-warning">Saving...</span></span>
                <table>
                    <tr>
                        <td><label for="select_coverage" style="display:inline-block">Coverage level: </label></td>
                        <td>

                            <?php
                            //set drop down menu for coverage level
                            if (isset($coverage_level_list) && count($coverage_level_list) > 0) {
                                echo '<select id="select_coverage" name="select_coverage">';
                                echo '<option value="">--SELECT--</option>';
                                for ($i = 0; $i < count($coverage_level_list); $i++) {
                                    echo '<option value="' . $coverage_level_list[$i][0] . '">' . $coverage_level_list[$i][1] . '</option>';
                                }
                                echo '</select>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="coverage_location" >Coverage location: </label></td>
                        <td>
                            <input type="text" id="coverage_location" name="coverage_location" />
                            <span id="locationCodeSpan" style="display:none">
                                &nbsp; &nbsp; &nbsp;
                                <label for="coverage_location_code" style="display:inline-block">code: </label>
                                <input type="text" id="coverage_location_code" name="coverage_location_code" />
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <img src="../img/loading.gif" id="loading" style="display:none"/>&nbsp; <input type="submit" class="btn btn-info" name="submit" id="save_coverage_location" value="save" />
                            <br /><br />
                            <div class="message-success" id="success" style="width:auto;display:none">
                                Coverage location <span id="new_coverage_location" class="nicecolor"></span> added successfully
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="left">
                            <!-- TODO -->
                        </td>
                    </tr>
                </table>
                <hr />
                <h5 class="nicefont nicecolor">Edit / Delete coverage location</h5>
                <span class="text-info">Select coverage level &nbsp;&nbsp</span> 
                <?php
                //set drop down menu for coverage level
                if (isset($coverage_level_list) && count($coverage_level_list) > 0) {
                    echo '<select id="edit_coverage" name="edit_coverage">';
                    for ($i = 0; $i < count($coverage_level_list); $i++) {
                        echo '<option value="' . $coverage_level_list[$i][0] . '">' . $coverage_level_list[$i][1] . '</option>';
                    }
                    echo '</select>';
                }
                ?>
                &nbsp;
                <button class="btn btn-info" id="btn_select_covereage_level">go</button>
                <br />
                <br />
            </td>
        </tr>

    </table>
    <?php } ?>
</div> <!-- end of container tag -->

<script type="text/javascript">  
    $(document.body).on('change','#select_coverage',function(){
        var coverage_level = $('#select_coverage>option:selected').text();
        // alert(coverage_level.toUpperCase());
        if(coverage_level.toUpperCase() == 'MUNICIPALITY' || coverage_level.toUpperCase() == 'VDC'){
            $('#locationCodeSpan').show();
        }
        else{
            $('#locationCodeSpan').hide();
            $('#coverage_location_code').val('');
        }
    });
    
    $(document.body).on('click','#btn_select_covereage_level',function(){
        var coverage_level = $('#edit_coverage').val();
        location.href="../Home/editCoverage?id="+coverage_level;
    });
    
    $(document.body).on('click','#save_coverage_location',function(){
        if($('#select_coverage').val()!=''){
            var location = $.trim($('#coverage_location').val());
            if(location !=''){
                $('#loading').show();
                var code =  $('#coverage_location_code').val();
                var level = $('#select_coverage').val();
                $.ajax({						
                    type: "POST",
                    url: "../Home/addCoverageLocation",
                    data: {
                        coverage_location:location,
                        coverage_location_code:code,
                        coverage_level:level
                    },
                    cache: false,
                    error: function(xhr, status, error) {
                        $('#loading').hide();
                        $('#success').hide();
                        alert('Error !\n Please try again.\n(Please check your internet connection.)');
                    },
                    success: function (msg) {
                        $('#loading').hide();
                        var success = $.trim(msg);
                        if(success == 'yes'){
                            $('#new_coverage_location').text('('+location+')');
                            //reset form
                            $('#coverage_location_code').val('');
                            $('#coverage_location').val('');
                            //  $('#locationCodeSpan').hide();
                            $('#success').show();
                        }
                        else{
                            $('#success').hide();
                            //reset form
                            $('#coverage_location_code').val('');
                            $('#coverage_location').val('');
                            // $('#locationCodeSpan').hide();
                            // alert(success);
                        }
                    }
                });
            }else{
                alert('Please enter coverage location.');
            }
        }
        else{
            alert('please select coverage level first');
        }
    });
     
    /*
     //CODE SNIPPET
    
            $(document).ready(function(){
                Object.size = function(obj) {
                    var size = 0, key;
                    for (key in obj) {
                        if (obj.hasOwnProperty(key)) size++;
                    }
                    return size;
                };

            });
    
            $(document.body).on('change','#select_coverage',function(){
            var coverage_level_id = $('#select_coverage').val(); 
            $.ajax({						
                type: "POST",
                url: "",
                data: {
                    coverage_level_id:coverage_level_id
                },
                cache: false,
                error: function(xhr, status, error) {
                    alert('Error !\n Please try again.\n(Please check your internet connection.)');
                },
                success: function (msg) {
                    var obj = $.trim(msg);
                    var datasize = Object.size(obj);
                    if(datasize>0){
                        var content = '<select name="event_course_subcategory" id="event_course_subcategory" ><option value="">-- SELECT --</option>';
                        for(i  in obj){
                            content += '<option value="'+obj[i].course_subcat_id+'">'+obj[i].subcoursename+'</option>';
                        }
                        content += '</select>';   
                        $("#getSubCourse").html(content);
                    }
                    else{
                        $("#event_course_subcategory").prop("disabled", true);
                    }
                }
            });
        });
     */
</script>

