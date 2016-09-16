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
                        string += '<option value="">All</option>';
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
                <h5 class="nicecolor">Summary Report</h5>
                <?php
                $hidden = array('clicked' => 'yes');
                echo form_open('report/summaryreportresult', '', $hidden)
                ?>
                <table border="0" width="50%" align="center">
                    <tr>
                        <td align="left"><label for="">Start date:</label></td>
                        <td align="left"><input type="text" name="event_start_date"  id="event_start_date" class="datepicker" placeholder="Enter start date" value="<?php if(isset($from_date)){ echo $from_date;}?>"/></td>
                        <td style="width:18px"></td>
                        <td align="left"><label for="">End date:</label></td>
                        <td align="left"><input type="text" name="event_end_date"  id="event_end_date" class="datepicker" placeholder="Enter end date" value="<?php if(isset($to_date)){ echo $to_date;}?>"/></td>
                    </tr>
                    <tr>
                        <td align="left"><label for="">Coverage:</label></td>
                        <td align="left">

                            <select name="coverage" id="coverage">
                                <option value="">All</option>
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
                                <option value="">All</option>
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
                <div id="search_result_summaryreport">
                    <br />
                    <br />
                    <hr />
                    <b class="nicecolor nicefont left"> Summary </b>
                    <div class="clear"></div>
                    <table width="100%" border="0" class="dataListing">
                        <tr>
                            <th width="8%" rowspan="2">S.N</th>
                            <th width="30%" rowspan="2">Training type</th>
                            <th width="20%" rowspan="2">Total training</th>
                            <th width="42%" colspan="3">Total participants</th>
                        </tr>
                        <tr>
                            <th width="14%">Male</th>
                            <th width="14%">Female</th>
                            <th width="14%">Total</th>
                        </tr>
                        <?php
                        if (isset($summary_array) && count($summary_array) > 0) {
                            for ($i = 0; $i < count($summary_array); $i++) {
                                echo '<tr>';
                                echo ' <td>' . ($i + 1) . '</td>
                                    <td>' . $summary_array[$i][1] . '</td>
                                    <td>' . $summary_array[$i][2] . '</td>
                                    <td>' . $summary_array[$i][3] . '</td>
                                    <td>' . $summary_array[$i][4] . '</td>
                                    <td>' . (intval($summary_array[$i][3]) + intval($summary_array[$i][4])) . '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>

                    </table>

                   
                    
                    <div class="clear"></div>
                    
                    <br>
<hr>
<b class="nicecolor nicefont left"> Detail report </b>
<br>
                    
                    
                    <?php
                    if (isset($summary_array)) {
                        
                        for ($i = 0; $i < count($summary_array); $i++) {
                        
                            if(count($summary_array[$i][5])>0)
                            {
                            echo "<br /><b>" . $summary_array[$i][1] . "</b><hr>";
                            echo ' <table width="100%" border="1" class="dataListing">
                        <tr>
                            <th rowspan="2" width="3%">S.N</th>
                            <th rowspan="2" width="15%">Event title</th>
                            <th rowspan="2" width="7%">Start date</th>
                            <th rowspan="2" width="7%">End date</th>
                            <th rowspan="2" width="5%">Year</th>
                        
                            <th colspan="3" width="15%">Number of participants</th>
                            <th colspan="2" width="13%">Total instructor</th>
                        </tr>
                        <tr>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Total</th>
                            <th>Instructor</th>
                            <th>Asst. Instructor</th>
                        </tr>';
                            
                            $course_detail_array = $summary_array[$i][5];
                            for ($j = 0; $j < count($course_detail_array); $j++) {
                                //' . $course_detail_array[$j][4] . '
                                echo '<tr>
                                    <td>' . ($j + 1) . '</td>
                                    <td>' . $course_detail_array[$j][0] . '</td>
                                    <td>' . $course_detail_array[$j][1] . '</td>
                                    <td>' . $course_detail_array[$j][2] . '</td>
                                    <td>' . $course_detail_array[$j][3] . '</td>
                                   
                                    <td>' . $course_detail_array[$j][5] . '</td>
                                    <td>' . $course_detail_array[$j][6] . '</td>
                                    <td>' . (intval($course_detail_array[$j][5]) + intval($course_detail_array[$j][6])) . '</td>
                                    <td>' . $course_detail_array[$j][7] . '</td>
                                    <td>' . $course_detail_array[$j][8] . '</td>
                                </tr>';
                            }
                            echo '</table>';
}
                            if (count($subcat_report) > 0) {
                             
                
                                $subcatagory = array();
                                $b = 0;
                                $serialno=1;
                                for ($n = 0; $n < count($subcat_report); $n++) {
                                    
                                    if ($subcat_report[$n][1] == $summary_array[$i][0])
                                        {
                                        $subcatagory[$b] = $subcat_report[$n][8];

                                        if ($b != 0) {
                                               if ($subcatagory[$b - 1] == $subcatagory[$b])
                                                {
                                                echo '<tr>
                                    <td>'.($serialno++).'</td>
                                    <td>' . $subcat_report[$n][0] . '</td>
                                    <td>' . $subcat_report[$n][3] . '</td>
                                    <td>' . $subcat_report[$n][4] . '</td>
                                    <td>' . $subcat_report[$n][9] . '</td>
                                    <td>' . $subcat_report[$n][5] . '</td>
                                    <td>' . $subcat_report[$n][6] . '</td>
                                    <td>' . (intval($subcat_report[$n][5]) + intval($subcat_report[$n][6]) ) . '</td>
                                    <td>' . $subcat_report[$n][7] . '</td>
                                        <td>' . $subcat_report[$n][10] . '</td>
                                </tr>';
                                            } 
                                            
                                            else {
                                                
                                                echo "</table>";

                                                echo "<br /><b>" . $subcat_report[$n][8] . "</b><hr>";
                                                echo ' <table width="100%" border="1" class="dataListing">
                        <tr>
                            <th rowspan="2" width="3%">S.N</th>
                            <th rowspan="2" width="15%">Event title</th>
                            <th rowspan="2" width="7%">Start date</th>
                            <th rowspan="2" width="7%">End date</th>
                            <th rowspan="2" width="5%">Year</th>
                            <th colspan="3" width="15%">Number of participants</th>
                            <th colspan="2" width="13%">Total instructor</th>
                        </tr>
                        <tr>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Total</th>
                            <th>Instructor</th>
                            <th>Asst. Instructor</th>
                        </tr>';
$serialno=1;
                                                echo '<tr>
                                    <td>'.($serialno++).'</td>
                                    <td>' . $subcat_report[$n][0] . '</td>
                                    <td>' . $subcat_report[$n][3] . '</td>
                                    <td>' . $subcat_report[$n][4] . '</td>
                                    <td>' . $subcat_report[$n][9] . '</td>
                                    <td>' . $subcat_report[$n][5] . '</td>
                                    <td>' . $subcat_report[$n][6] . '</td>
                                    <td>' . (intval($subcat_report[$n][5]) + intval($subcat_report[$n][6]) ) . '</td>
                                    <td>' . $subcat_report[$n][7] . '</td>
                                        <td>' . $subcat_report[$n][10] . '</td>
                                </tr>';
                                            }
                                        } 
                                        
                                        
                                        else
                                            
                                      {
                                           
                                            echo "<br /><b>" . $subcat_report[$n][8] . "</b><hr>";
                                           
                                            echo ' <table width="100%" border="1" class="dataListing">
                        <tr>
                            <th rowspan="2" width="3%">S.N</th>
                            <th rowspan="2" width="15%">Event title</th>
                            <th rowspan="2" width="7%">Start date</th>
                            <th rowspan="2" width="7%">End date</th>
                            <th rowspan="2" width="5%">Year</th>
                            <th colspan="3" width="15%">Number of participants</th>
                            <th colspan="2" width="13%">Total instructor</th>
                        </tr>
                        <tr>
                            <th>Male</th>
                            <th>Female</th>
                            <th>Total</th>
                            <th>Instructor</th>
                            <th>Asst. Instructor</th>
                        </tr>';


                                            echo '<tr>
                                    <td>'.($serialno++).'</td>
                                    <td>' . $subcat_report[$n][0] . '</td>
                                    <td>' . $subcat_report[$n][3] . '</td>
                                    <td>' . $subcat_report[$n][4] . '</td>
                                    <td>' . $subcat_report[$n][9] . '</td>
                                    <td>' . $subcat_report[$n][5] . '</td>
                                    <td>' . $subcat_report[$n][6] . '</td>
                                    <td>' . (intval($subcat_report[$n][5]) + intval($subcat_report[$n][6]) ) . '</td>
                                    <td>' . $subcat_report[$n][7] . '</td>
                                        <td>' . $subcat_report[$n][10] . '</td>
                                </tr>';
                                        }
                                     $b++;   
                                    }
                                    
                                }
                                
                                if($b>0){echo '</table>';}
                            }
                        }
                    }
                    ?>

                </div>
            </td>
        </tr>
    </table>

</div> <!-- end of container tag-->