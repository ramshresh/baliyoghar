<!--script src="../../js/root.js" type="text/javascript"></script-->
<script>
    var root='../';

    $('document').ready(function(){
        Object.size = function(obj) {
            var size = 0, key;
            for (key in obj) {
                if (obj.hasOwnProperty(key)) size++;
            }
            return size;
        };
        
     
    
        $('#coverage').change(function(){
            $('#loading_coverage').show()
            var coverage_id=$('#coverage').val();
            
            if($.trim(coverage_id)=='')
            {$('#location').prop('disabled',true); $('#loading_coverage').hide();
    
            }
            else
            {
            
                $.post(root+"Event/getCoverageLocation",{coverage_level:coverage_id},function(data,status){
                    
                    if(status)
                    {
                    
                        var coverage_content =jQuery.parseJSON($.trim(data));
                        var string = '<select name="location" id="location">';
                        for(i  in coverage_content){
                            string +='<option value="'+coverage_content[i].coverage_location+'">'+coverage_content[i].coverage_location+'</option>';
                        }
                        string += '</select>';
                          
                        $('#coverage_location_content').html(string);
                    }
                });
        
                $('#loading_coverage').hide();
            }

        });

        //////////////

        $('#event').change(function(){
            $('#loading_events').show()
            var event_id=$('#event').val();
            
            if($.trim(event_id)=='')
            {$('#course').prop('disabled',true); $('#loading_events').hide();
    
            }
            else
            {
            
                $.post(root+"Event/grabSubCourseData_async",{course_cat_id:event_id},function(data,status){
                    
                    if(status)
                    {
                    
                        var subcourse =jQuery.parseJSON($.trim(data));
                        var string = '<select name="course" id="course">';
                        for(i  in subcourse){
                            string +='<option value="'+subcourse[i].course_subcat_id+'">'+subcourse[i].subcoursename+'</option>';
                        }
                        string += '</select>';
                          
                        $('#subcourse_content').html(string);
                    }
                });
        
                $('#loading_events').hide();
            }

        });




    })
    




</script>
<style type="text/css">
    input[type=text],select,button{-moz-border-radius: 0px;-webkit-border-radius: 0px;border-radius: 0px;}
    input[type=text]{width:150px;}
    select{width:165px;}
    .left{float: left;}
    .clear{clear:both;}
    hr{margin:5px;}
</style>
<div class="container" >
    <table style="border:1px solid #CCC;margin-top:30px;" width="100%" class="maintable getBg">
        <tr>
            <td style="padding:20px;min-height:300px;display:block;text-align: center;vertical-align: middle">
                <h5 class="nicecolor">Report by coverage</h5>
                <?php
                $hidden = array('clicked' => 'yes');
                echo form_open('report/coveragereport', '', $hidden)
                ?>
                <table border="0" width="50%" align="center">
                    <tr>
                        <td align="left"><label for="">Start date:</label></td>
                        <td align="left"><input type="text" name="event_start_date"  id="event_start_date" class="datepicker" placeholder="Enter start date" value="<?php if(isset($datefrom)){ echo $datefrom;}?>"/></td>
                        <td style="width:18px"></td>
                        <td align="left"><label for="">End date:</label></td>
                        <td align="left"><input type="text" name="event_end_date"  id="event_end_date" class="datepicker" placeholder="Enter end date" value="<?php if(isset($dateto)){ echo $dateto;}?>"/></td>
                    </tr>
                    <tr>
                        <td align="left"><label for="">Coverage:</label></td>
                        <td align="left">

                            <select name="coverage" id="coverage">
                                <option value="">--select--</option>
                                <?php
                                if (isset($coverage_level_array) && count($coverage_level_array) > 0) {
                                    for ($i = 0; $i < count($coverage_level_array); $i++) {
                                        echo '<option value="' . $coverage_level_array[$i][0] . '"';
                                        if(isset($coverage)){if($coverage==$coverage_level_array[$i][0]){echo 'selected';}}
                                        echo '>' . $coverage_level_array[$i][1] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <img src="../img/loading.gif" style="display:none;" id="loading_coverage"/>
                        </td>
                        <td style="width:18px"> </td>
                        <td align="left"><label for="">Location:</label></td>
                        <td align="left">
                            <span id="coverage_location_content">
                                <select name="location" id="location" disabled="disabled">
                    <?php if(isset($location)){echo '<option value="">'.$location.'</option>';} else {?>
                                    <option value="">--select--</option>
                                    <?php }?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td align="left"><label for="">Event type:</label></td>
                        <td align="left">
                            <select name="Event" id="event">
                                <option value="">--select--</option>
                                <?php
                                if (isset($CourseContent)) {
                                    echo $CourseContent;
                                }
                                ?>

                            </select>
                            <img src="../img/loading.gif" style="display:none" id="loading_events"/>
                        </td>
                        <td style="width:18px"></td>
                        <td align="left"><label for="">Course:</label></td>
                        <td align="left">
                            <span id="subcourse_content">
                                <select name="course" id="course" disabled="disabled">
                                        <?php if(isset($course)){echo '<option value="">'.$course.'</option>';} else {?>
                                    <option value="">--select--</option>
                                    <?php }?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" align="center">
                            <br />
                            <button class="btn" id="search_button_peoplereport"><b class="icon-search"></b>&nbsp;search</button>
                        </td>
                    </tr>
                </table>
                <?php echo form_close(); ?>

                <br/>
                <img src="../img/loading.gif" id="loading" style="display:none"/>
                <div id="search_result_peoplereport">
                    <br />
                    <br />
<!--                    <div class="row">
                        <div class="span12">
                  <?php if(isset($datefrom)){ echo '<span class="left"><label>Date From : </label>'.$datefrom.'</span>';}?>  
                            <?php if(isset($dateto)){ echo '<span class="left"><label>Date To : </label>'.$dateto.'</span>';}?>  
                            <?php if(isset($coverage)){ echo '<span class="left"><label>Coverage : </label>'.$coverage.'</span>';}?>  
                            <?php if(isset($location)){ echo '<span class="left"><label>Location : </label>'.$location.'</span>';}?>  
                            <?php if(isset($event_type)){ echo '<span class="left"><label>Event Type : </label>'.$event_type.'</span>';}?>  
                            <?php if(isset($course)){ echo '<span class="left"><label>Course : </label>'.$course.'</span>';}?>  
                        </div>
                        </div>-->
                    <hr/>
                    <b class="nicecolor nicefont left"> Search result </b>
                    <div class="clear"></div>
                    <hr />
                
                    <span class="left">
                        <h6 style="border-bottom:1px solid #ccc;">Summary</h6>
                        <span class="text-success">Total male: <?php
                if (isset($coverage_report)) {

                    if (count($coverage_report) > 0) {
                        echo $coverage_report[count($coverage_report) - 1]['totalmale'];
                    }
                }
                ?> </span>&nbsp; &nbsp | &nbsp; &nbsp;
                        <span class="text-success">Total female:<?php
                            if (isset($coverage_report)) {
                                  if (count($coverage_report) > 0) {
                                echo $coverage_report[count($coverage_report) - 1]['totalfemale'];
                                  }
                            }
                ?></span>
                    </span>
                    <div class="clear"></div>
                    <table class="dataListing" width="100%" cellspacing="0" cellpadding="5" border="0">
                        <tbody class="edit_coverage_location">
                            <tr>
                                <th width="5%" align="center">#</th>
                                <th width="15%" align="center">Full name</th>
                                <th width="5%" align="center">Gender</th>
                                <th width="7%" align="center">DOB(EN)</th>
								<th width="7%" align="center">DOB(NP)</th>
                                <th width="16%" align="center">Address</th>
                                <th width="5%" align="center">Current age</th>
                                <th width="10%" align="center">Status</th>
                                <th width="10%" align="center">Org Name</th>
                                <th width="10%" align="center">Org Address</th>

                                <th width="10%" align="center">Org phone</th>

                            </tr>
                            <?php
                            if (isset($coverage_report)) {
                                for ($i = 0; $i < count($coverage_report); $i++) {
                                    $year = date('Y');
                                    $dob_year = explode("-", $coverage_report[$i]['dob_en']);
                                    $current_year = $year - $dob_year[0];
                                    echo '<tr>
                                <td align="center">' . ($i + 1) . '</td>
                                <td align="left"><a href="../person/viewPerson?id=' . $coverage_report[$i]["id"] . '">' . $coverage_report[$i]['fullname'] . '</a></td>
                                     <td align="left">' . $coverage_report[$i]['gender'] . '</td>
                                                 <td align="center">' . $coverage_report[$i]['dob_en'] . '</td>
												 <td align="center">' . $coverage_report[$i]['dob_np'] . '</td>
                                <td align="left">' . $coverage_report[$i]['address'] . '</td>
                           <td align="left">' . $current_year . '</td>
                                <td align="center">' . $coverage_report[$i]['status'] . '</td>
                                <td align="center">' . $coverage_report[$i]['org_name'] . '</td>
                                       <td align="center">' . $coverage_report[$i]['org_address'] . '</td>
                                <td align="center">' . $coverage_report[$i]['org_phone'] . '</td>
                                
                            </tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>

</div> <!-- end of container tag-->