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
            <thead>
                <tr>
                    <td colspan="2" style="padding:20px">


                        <span class="nicecolor nicefont size16"><strong>Manage coverage level</strong></span>
                        <hr/>
    <?php if (isset($coverage_level_id)) { ?>
                            <table style="background:rgba(255,255,255,0.8);" border="0">
                                <tr>
                                    <td style="padding:10px;width:200px">
                                        <input type="hidden" value="<?= $coverage_level_id ?>" id="coverage_level_id" />
                                        <strong><span class="text-success coverage_level_span"><?= $coverage_name; ?></span></strong>
                                        <input type="text" id="hidden_coverage_level" value="<?= $coverage_name; ?>" style="display:none" style="width:180px" />
                                    </td>
                                    <td style="padding:10px;width:160px">
                                        <a class="text-info handcursor" id="edit_coverage_level">edit</a>
                                        <span id="update_option" style="display:none">
                                            <a class="text-success handcursor"  id="update_coverage_level">save</a>&nbsp; &nbsp; 
                                            <a class="text-warning handcursor"  id="cancel_coverage_level">cancel</a>
                                        </span>
                                        &nbsp; | &nbsp;
                                        <a class="text-error handcursor" id="delete_coverage_level" >delete</a>
                                    </td>
                                </tr>
                            </table>
    <?php } ?>

                    </td>
                </tr>
            </thead>
            <tr>
                <td style="padding:20px;vertical-align: top" width="70%" >
                    <table class="dataListing" width="100%" cellspacing="0" cellpadding="5" border="0">
                        <tbody class="edit_coverage_location">
                            <tr>
                                <th width="5%" align="center">#</th>
                                <th width="25%" align="left">Coverage level</th>
                                <th width="35%" align="left">Coverage location</th>
                                <th width="20%" align="left">Coverage location code</th>
                                <th style="width:80px" align="left">Action</th>
                            </tr>
                            <?php
                            if (isset($coverage_location_array) && count($coverage_location_array) > 0) {
                                for ($i = 0; $i < count($coverage_location_array); $i++) {
                                    echo
                                    '
                                <tr id="row_' . $coverage_location_array[$i][0] . '">
                                    <td align="center">' . ($i + 1) . '</td>
                                    <td align="left">' . $coverage_name . '</td>
                                    <td align="left" id="location_' . $coverage_location_array[$i][0] . '">' . $coverage_location_array[$i][2] . '</td>
                                    <td align="left" id="locationcode_' . $coverage_location_array[$i][0] . '">' . $coverage_location_array[$i][3] . '</td>
                                    <td align="left">
                                    <a id="edit_coverage_location_' . $coverage_location_array[$i][0] . '" class="handcursor text-info">edit</a>&nbsp; | &nbsp;
                                    <a id="delete_coverage_location_' . $coverage_location_array[$i][0] . '" class="handcursor text-error" >delete</a>
                                    </td>
                                </tr>
                                    ';
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </td>
                <td width="30%" style="vertical-align: top;padding:20px" >
                    <span id="edit_coverage_location_table">
                        <h5 class="nicecolor">Edit coverage location </h5>
                        <input type="hidden" id="hidden_coverage_location_id" />
                        <table border="0">
                            <tr>
                                <td>
                                    <label> Location:</label>
                                </td>
                                <td>
                                    <input type="text" id="location_text" style="width:150px"/>
                                </td>
                            </tr>
    <?php if (strtoupper($coverage_name) == 'MUNICIPALITY' || strtoupper($coverage_name) == 'VDC' || strtoupper($coverage_name) == 'DISTRICT') { ?>
                                <tr>
                                    <td>
                                        <label> Location code:</label>
                                    </td>
                                    <td>
                                        <input type="text" id="location_code_text" style="width:150px" />
                                    </td>
                                </tr>
    <?php } ?>
                            <tr>
                                <td colspan="2" align="right">
                                    <button id="edit_coverage_location_btn" class="btn-info btn"> Edit </button>
                                    <button id="cancel_coverage_location_btn" class="btn-warning btn"> Cancel </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="right">
                                    <div class="message-success" style="display:none;width:150px;text-align: center" id="edit_success">Edit successful !</div>
                                    <div class="message-error" style="display:none;width:100px;text-align: center" id="edit_fail">Edit failed !</div>
                                </td>
                            </tr>
                        </table>
                    </span>

                </td>
            </tr>

        </table>
<?php } ?>
</div> <!-- end of container tag-->

<script type="text/javascript">
    $(document.body).on('click','#edit_coverage_level',function(){
        //hide text
        $('.coverage_level_span').hide();
        //show input box
        $('#hidden_coverage_level').show();
       
        $('#edit_coverage_level').hide();
        $('#update_option').show();
    });
   
    $(document.body).on('click','#cancel_coverage_level',function(){
        hideupdatecontent();
    });
   
    $(document.body).on('click','#update_coverage_level',function(){
        var coverage_level_id = $.trim($('#coverage_level_id').val());
        var new_coverage_level = $.trim($('#hidden_coverage_level').val());
        $.ajax({						
            type: "POST",
            url: "../Home/editCoverageLevel",
            data: {
                coverage_level_id:coverage_level_id,
                coverage_level:new_coverage_level
            },
            cache: false,
            error: function(xhr, status, error) {
                alert('Error !\n Please try again.\n(Please check your internet connection.)');
            },
            success: function (msg) {
                var success = $.trim(msg);
                if(success == 'yes'){
                    $('.coverage_level_span').text(new_coverage_level);
                    hideupdatecontent();
                }
                else{
                    hideupdatecontent();
                }
            }
        });
    });
    
    $(document.body).on('click','#delete_coverage_level',function(){
    
        var confirmation = confirm('Are you sure you want to delete?\nAll coverage location will be deleted.');
        if(confirmation==true){
            var coverage_level_id = $.trim($('#coverage_level_id').val());
            var new_coverage_level = $.trim($('#hidden_coverage_level').val());
            $.ajax({						
                type: "POST",
                url: "../Home/deleteCoverageLevel",
                data: {
                    coverage_level_id:coverage_level_id
                },
                cache: false,
                error: function(xhr, status, error) {
                    alert('Error !\n Please try again.\n(Please check your internet connection.)');
                },
                success: function (msg) {
                    var success = $.trim(msg);
                    if(success == 'yes'){
                        location.href="../Home/newCoverage";
                    }
                    else{
                        alert('Sorry your query failed!');
                    }
                }
            });
        }else{
            // user doesn't want to delete coverage level.
        }
    });
    
    $(document.body).on('click','#cancel_coverage_location_btn',function(){
        //reset edit form
        $('#location_text').val('');
        $('#hidden_coverage_location_id').val('');
        $('#location_code_text').val('');
                        
        //show success message and hide error message
        $('#edit_fail').hide();
        $('#edit_success').hide();
    });
     
    $(document.body).on('click','#edit_coverage_location_btn',function(){
        var location=$('#location_text').val();
        var location_id =$('#hidden_coverage_location_id').val();
        if($.trim(location)!='' && $.trim(location_id)!=''){
            var location_code =$('#location_code_text').val();
            $.ajax({						
                type: "POST",
                url: "../Home/editCoverageLocation",
                data: {
                    coverage_location_id:location_id,
                    location_code:location_code,
                    coverage_location:location
                },
                cache: false,
                error: function(xhr, status, error) {
                    alert('Error !\n Please try again.\n(Please check your internet connection.)');
                },
                success: function (msg) {
                    var success = $.trim(msg);
                    if(success == 'yes'){
                        $('#location_'+location_id).text(location);
                        $('#locationcode_'+location_id).text(location_code);
                        //reset edit form
                        $('#location_text').val('');
                        $('#hidden_coverage_location_id').val('');
                        $('#location_code_text').val('');
                        
                        //show success message and hide error message
                        $('#edit_fail').hide();
                        $('#edit_success').show();
                    }
                    else{
                        //show error message and hide success message
                        $('#edit_fail').show();
                        $('#edit_success').hide();
                    }
                }
            });
        }else{
            // user doesn't want to delete coverage level.
            alert('No value to update.');
        }
    });

    function hideupdatecontent(){
        $('#edit_coverage_level').show();
        $('#update_option').hide();
        
        //hide input box
        $('#hidden_coverage_level').hide();
        $('#hidden_coverage_level').val($.trim($('.coverage_level_span').text())); //fill with actual name
       
        //show text
        $('.coverage_level_span').show();
    }
    
    /*  EDIT COVERAGE LOCATION */
    $(document.body).on('click','a[id^=edit_coverage_location_]',function(){
        var id =$(this).attr('id');
        var array = id.split("_");
        var coverage_location_id = array[3];
        $('#location_text').val($.trim($('#location_'+coverage_location_id).text()));
        $('#location_code_text').val($.trim($('#locationcode_'+coverage_location_id).text()));
        
        $('#hidden_coverage_location_id').val(coverage_location_id);
    });
    
    /*  DELETE COVERAGE LOCATION */
    $(document.body).on('click','a[id^=delete_coverage_location_]',function(){
        var confirmation = confirm('Are you sure you want to delete?');
        if(confirmation==true){
            var id =$(this).attr('id');
            var array = id.split("_");
            var coverage_location_id = array[3];
            $.ajax({						
                type: "POST",
                url: "../Home/deleteCoverageLocation",
                data: {
                    coverage_location_id:coverage_location_id
                },
                cache: false,
                error: function(xhr, status, error) {
                    alert('Error !\n Please try again.\n(Please check your internet connection.)');
                },
                success: function (msg) {
                    var success = $.trim(msg);
                    if(success == 'yes'){
                        $('#row_'+coverage_location_id).remove();
                        if($.trim($('#hidden_coverage_location_id').val())==coverage_location_id){
                            //reset edit form
                            $('#location_text').val('');
                            $('#hidden_coverage_location_id').val('');
                            $('#location_code_text').val('');
                        
                            //show success message and hide error message
                            $('#edit_fail').hide();
                            $('#edit_success').hide();
                        }
                    }
                    else{
                        alert('Sorry! your request failed');
                    }
                }
            });
        }
    });
</script>