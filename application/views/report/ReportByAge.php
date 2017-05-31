<style type="text/css">
    input[type=text],select{-moz-border-radius: 0px;-webkit-border-radius: 0px;border-radius: 0px;}
    input[type=text],button{width:150px;}
    select{width:165px;}
    .left{float: left;}
    .clear{clear:both;}
    hr{margin:5px;}
</style>

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



<div class="container" >
    <table style="border:1px solid #CCC;margin-top:30px;" width="100%" class="maintable getBg">
        <tr>
            <td style="padding:20px;min-height:300px;display:block;text-align: center;vertical-align: middle">
                <h5 class="nicecolor">Report by age</h5>
                <?php $hidden = array('clicked' => 'yes');
                echo form_open('Report/agereport', '', $hidden) ?>
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
                        <td style="width:18px"></td>
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
                    <hr />
                    <b class="nicecolor nicefont left"> Search result </b>
                    <div class="clear"></div>
                    <hr />

                   
                    <div class="clear"></div>
         
                    <table class="dataListing" width="100%" border="0" cellpadding="0" cellpadding="5" border="0">
                        <tbody class="edit_coverage_location">
                            <tr>
                                <th width="2%" rowspan="2">#</th>
                                <th width="11%" rowspan="2" align="center">Event Name</th>
                                <th width="6%" rowspan="2" align="center">Start Date</th>
                                <th width="6%" rowspan="2" align="center">End Date</th>
                                <th height="28" colspan="6" align="center">Age</th>
                                <th height="28" colspan="3" align="center">No of Participant</th>
                            </tr>
                            <tr>
                                <th width="6%">&lt;20</th>
                                <th width="6%">21 - 30</th>
                                <th width="6%">31 - 40</th>
                                <th width="6%">41 - 50</th>
                                <th width="6%">51 - 60</th>
                                <th width="6%">61&gt;</th>
                                <th width="6%">Male</th>
                                <th width="6%">Female</th>
                                <th width="6%">Total</th>
                            </tr>

                            <?php
                            if (isset($agereport_array)) {
                                for ($i = 0; $i < count($agereport_array); $i++) {

                                    echo ' <tr>
                        <td>'.($i+1).'&nbsp;</td>
                        <td><a href="../Event/viewEvent?id='.$agereport_array[$i]['event_id'].'">'.$agereport_array[$i]['title'].'</a></td>
                        <td>'.$agereport_array[$i]['start_date'].'</td>
                        <td>'.$agereport_array[$i]['end_date'].'</td>
                        <td>'.$agereport_array[$i]['less_than_20'].'</td>
                        <td>'.$agereport_array[$i]['between_21_30'].'</td>
                        <td>'.$agereport_array[$i]['between_31_40'].'</td>
                        <td>'.$agereport_array[$i]['between_41_50'].'</td>
                        <td>'.$agereport_array[$i]['between_51_60'].'</td>
                        <td>'.$agereport_array[$i]['more_than_60'].'</td>
                         <td>'.$agereport_array[$i]['totalmale'].'</td>
                         <td>'.$agereport_array[$i]['totalfemale'].'</td>
                         <td>'.$agereport_array[$i]['total'].'</td>
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