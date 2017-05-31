<style type="text/css">
    hr{
        margin:5px 0;
    }
    input[type=text]{
        border-radius:0;
        width:150px;
        font-size:11px;
        color:#005580;
    }
    table.dataListing td{text-align: center}
</style>

<div class="container">
    <table style="border:1px solid #CCC;margin-top:30px;margin-bottom:30px;" width="100%" >
        <tr>
            <td style="padding:20px;">
                <h5> <?php
if (isset($event_id)) {
    echo '<span class="nicecolor">Budget entry for </span><span class="text-info"><a href="../Event/viewEvent?id=' . $event_id . '">' . $event_title . "</a></span>";
} else {
    //redirect('Home/event', 'refresh');
    redirect('Event/event_list_pagination', 'refresh');
}
?> </h5>

                <?php
                if (count($direct_cost_array) == 1) {
                    $tdc_value = $direct_cost_array[0][0];
                    $staff_cost_value = $direct_cost_array[0][1];
                    $travel_cost_value = $direct_cost_array[0][2];
                } else {
                    $tdc_value = 0;
                    $staff_cost_value = 0;
                    $travel_cost_value = 0;
                }
                ?>
<a href="../Event/addParticipant?id=<?= $event_id ?>" class="btn text-success" style="margin-top:-6px;float: right;margin-bottom:0px;margin-right:5px" id=""><img src="../img/add-new.png" />&nbsp;Add new participant</a>
                <table width="100%" border="0">

                    <tr>
                        <?php echo form_open('Event/saveBudget') ?>
                    <input type="hidden" id="event_id" name="event_id" value="<?= $event_id ?>" />
                    <td style="width:400px;"> 
                        <table width="100%" style="border:1px solid #ccc">
                            <tr>
                                <td style="padding-top:10px;padding-left:10px" >
                                    Total direct cost : <input type="text" name="total_direct_cost" id="total_direct_cost" placeholder="Enter total direct cost" value="<?= $tdc_value ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top:10px;padding-left:10px" >
                                    Currency Unit :&nbsp;&nbsp;&nbsp;&nbsp;<select name="currency_unit" style="width:100px;">
									<?php if(isset($currency)){echo $currency;}  ?> 
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:10px">   
                                    <hr />
                                    <p class="text-info" style="margin-bottom:5px;display:inline-block">Direct cost sharing </p><span class="text-error inline-block size11">&nbsp;&nbsp; * sum must be 100%</span>
                                    <hr />
                                    <table border="0" >
                                        <tr>
                                            <td>
                                                <table width="100%">

                                                    <?php
                                                    /*
                                                      if (isset($csparty_array)) {
                                                      for ($i = 0; $i < count($csparty_array); $i++) {
                                                      $sharepercentage = 0;
                                                      echo "<tr>";
                                                      echo '<td align="right" style="width:150px;overflow:hidden">' . $csparty_array[$i][1] . '&nbsp:&nbsp;&nbsp;</td>';

                                                      for ($j = 0; $j < count($share); $j++) {
                                                      if (count($share) >= 1) {
                                                      if ($share[$j][3] == $csparty_array[$i][0]) {
                                                      $sharepercentage = $share[$i][2];
                                                      break;
                                                      }
                                                      }
                                                      }
                                                      echo '<td><input type="text" value="' . $sharepercentage . '" id="csparty_' . $csparty_array[$i][0] . '" name="csparty_' . $csparty_array[$i][0] . '" style="font:12px;width:100px;height:15px;margin-bottom:0" /></td>';
                                                      echo "</tr>";
                                                      }
                                                      } else {
                                                      echo "<div class='message-error'><p class='text-error'> Some error occured!</p>
                                                      <p class='text-error'><a href='../HomeController/events'>Click here</a> to retry</p></div>";
                                                      }

                                                     */
                                                    ?>

                                                    <?php
                                                    /*
                                                      for ($i = 0; $i < count($csparty_array); $i++) {
                                                      echo $csparty_array[$i][0]."<br />";
                                                      }
                                                      echo "<hr />";
                                                      for ($j = 0; $j < count($share); $j++) {
                                                      echo $share[$j][3]." = ".$share[$i][2]." <br />";
                                                      }
                                                     */
                                                    if (isset($csparty_array)) {
                                                        for ($i = 0; $i < count($csparty_array); $i++) {
                                                            $sharepercentage = 0;
                                                            echo "<tr>";
                                                            echo '<td align="right" style="width:150px;overflow:hidden">' . $csparty_array[$i][1] . '&nbsp:&nbsp;&nbsp;</td>';

                                                            for ($j = 0; $j < count($share); $j++) {
                                                                if (count($share) >= 1) {
                                                                    if ($share[$j][3] == $csparty_array[$i][0]) {
                                                                        $sharepercentage = $share[$j][2];
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                            echo '<td><input type="text" value="' . $sharepercentage . '" id="csparty_' . $csparty_array[$i][0] . '" name="csparty_' . $csparty_array[$i][0] . '" style="font:12px;width:100px;height:15px;margin-bottom:0" /></td>';
                                                            echo "</tr>";
                                                        }
                                                    } else {
                                                        echo "<div class='message-error'><p class='text-error'> Some error occured!</p>
                                                    <p class='text-error'><a href='../HomeController/events'>Click here</a> to retry</p></div>";
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="2">
                                                            <br />

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="vertical-align: top; padding:10px;">
                        <!-- right side -->
                        <table>
                            <tr>
                                <td>Staff cost :</td>
                                <td><input type="text" name="staff_cost" id="staff_cost" value="<?= $staff_cost_value ?>" placeholder="Enter staff cost.." /></td>
                            </tr>
                            <tr>
                                <td>Travel cost:</td>
                                <td><input type="text" name="travel_cost" id="travel_cost" value="<?= $travel_cost_value ?>" placeholder="Enter travel cost.." /></td>
                            </tr>
                        </table>

                        <div class="message-error curved" id="message" style="display:none;position:absolute"> <span class="text-error">Sum must be 100%</span></div>
                        <br />
                        <br />
                        <br />
                        <button  class="btn btn-info" id="save_all_btn" >Save All</button>
                    </td>
                    <?php echo form_close(); ?>
        </tr>

        <tr>
            <td colspan="2">

            </td>
        </tr>
        <tr>
            <td colspan="2">
                <br />
                <span class="uppercase text-info">  In kind contribution </span>
                <span id="loading" style="float:right;display:none"><img src="../img/loading.gif" />&nbsp;&nbsp;<span class="text-warning">Please wait...</span></span>
                <hr />
                <table class="dataListing" width="100%" id="inkind_contribution_table">
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Level</th>
                        <th width="20%">Description</th>
                        <th width="10%">No. of pax</th>
                        <th width="10%">Hours</th>
                        <th width="10%">Rate (per hour)</th>
                        <th width="10%">Total</th>
                        <th width="10%">Action</th>
                    </tr>
                    <tr style="border-bottom:5px solid #2f96b4">
                        <td>*</td>
                        <td><input type="text" id="inkind_level_txt" style="width:150px"/></td>
                        <td><input type="text" id="inkind_desc_txt" style="width:300px"/></td>
                        <td><input type="text" value="0" id="inkind_pax_txt" style="width:80px"/></td>
                        <td><input type="text" value="0" id="inkind_hour_txt" style="width:50px"/></td>
                        <td><input type="text" value="0" id="inkind_rate_txt" style="width:50px"/></td>
                        <td><input type="text" value="0" id="inkind_total_txt" disabled/></td>
                        <td><button class="btn" id="save_budget_btn" >save</button></td>
                    </tr>
                    <?php
                    $grandtotal = $tdc_value + $staff_cost_value + $travel_cost_value;
                    if (isset($inkind_contribution_array) && count($inkind_contribution_array) > 0) {
                        for ($i = 0; $i < count($inkind_contribution_array); $i++) {
                            $total = ( floatval($inkind_contribution_array[$i][3]) * floatval($inkind_contribution_array[$i][4]) * floatval($inkind_contribution_array[$i][5]));
                            $grandtotal +=$total;
                            echo '<tr id="row_' . $inkind_contribution_array[$i][0] . '">';
                            echo '<td align="left">*</td>';
                            echo '<td align="left"><label>' . $inkind_contribution_array[$i][1] . '</label></td>';
                            echo '<td align="left"><label>' . $inkind_contribution_array[$i][2] . '</label></td>';
                            echo '<td align="left"><label>' . $inkind_contribution_array[$i][3] . '</label></td>';
                            echo '<td align="left"><label>' . $inkind_contribution_array[$i][4] . '</label></td>';
                            echo '<td align="left"><label>' . $inkind_contribution_array[$i][5] . '</label></td>';
                            echo '<td  id = "total_' . $inkind_contribution_array[$i][0] . '" align="left" class="text-info">' . $total . '</td>';
                            echo '<td><a class="text-error handcursor" id="deleterow_' . $inkind_contribution_array[$i][0] . '">delete</a></td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </table>
                <input type="text" id="grand_total_text" style="font-weight: bold;display:inline-block;float:right;width:260px"value="<?= $grandtotal ?>" />
                <h5 class="nicefont nicecolor" style="float:right">Grand Total : &nbsp;&nbsp;</h5>
            </td> 
    </table>
</td>
</tr>
</table>
</div>

<script type="text/javascript" >
    $(document).ready(function(){
        var blankfields;
        $(document.body).on('click','#save_budget_btn',validateBudgetEntry);
    
        function validateBudgetEntry(){
            blankfields='';
            var level = $.trim($('#inkind_level_txt').val()) == ''?blank('level'):$('#inkind_level_txt').val();
            var pax = $.trim($('#inkind_pax_txt').val()) == ''?blank('pax'):$('#inkind_pax_txt').val();
            var hour = $.trim($('#inkind_hour_txt').val()) == ''?blank('hour'):$('#inkind_hour_txt').val();
            var rate = $.trim($('#inkind_rate_txt').val()) == ''?blank('rate'):$('#inkind_rate_txt').val();
        
            if(level && pax && hour && rate){
                //-------
                var description = $.trim($('#inkind_desc_txt').val());
                //var total = parseFloat(pax)*parseFloat(hour)*parseFloat(level);
                $('#loading').show();
                $.ajax({
                    type: "POST",
                    url: "../Event/saveInkindContribution",
                    data: {
                        event_id:$.trim($('#event_id').val()),
                        level:level,
                        description:description,
                        pax:pax,
                        hour:hour,
                        rate:rate
                    },
                    error: function(xhr, status, error) {
                        alert('Error !\n Please try again.\n(Please check your internet connection.)');
                        $('#loading').hide();
                    },
                    success: function (msg) {
                        $('#loading').hide();
                        if($.trim(msg)==0){
                            alert('Sorry, the action failed.');
                        }else{
                            var inkind_id = $.trim(msg);
                            //----------------
                            var string  = '<tr id="row_'+inkind_id+'">';
                            string +=    '<td align="left">*</td>';
                            string +=    '<td align="left"><label>'+level+'</label></td>';
                            string +=    '<td align="left"><label>'+description+'</label></td>';
                            string +=    '<td align="left"><label>'+pax+'</label></td>';
                            string +=    '<td align="left"><label>'+hour+'</label></td>';
                            string +=    '<td align="left"><label>'+rate+'</label></td>';
                            string +=    '<td align="left" class="text-info" id="total_'+inkind_id+'">'+(parseFloat(pax)*parseFloat(hour)*parseFloat(rate))+'</td>';
                            string +=    '<td><a class="text-error handcursor" id="deleterow_'+inkind_id+'">delete</a></td>';
                            string += '</tr>';   
                                
                            //append row to table
                            $('#inkind_contribution_table').append(string);
                            $('#grand_total_text').val(parseFloat($('#grand_total_text').val())+(parseFloat(pax)*parseFloat(hour)*parseFloat(rate)));
                                
                            //clear form
                            $('#inkind_level_txt').val('');
                            $('#inkind_pax_txt').val('0');
                            $('#inkind_hour_txt').val('0');
                            $('#inkind_rate_txt').val('0');
                            $('#inkind_total_txt').val('0');
                            $('#inkind_desc_txt').val()
                            //----------------
                        }
                    }
                });
                //-------
            }
            else{
                alert('Please fill these fields : \n'+blankfields);
                return false;
            }
        }
        
        $(document.body).on('click','a[id^=deleterow_]',function(){
            var id =$(this).attr('id');
            var array = id.split("_");
            var inkind_id=array[1];
            
            //------------------
            $.ajax({
                type: "POST",
                url: "../Event/deleteInkindContribution",
                data: {
                    inkind_id:inkind_id
                },
                error: function(xhr, status, error) {
                    alert('Error !\n Please try again.\n(Please check your internet connection.)');
                    $('#loading').hide();
                },
                success: function (msg) {
                    $('#loading').hide();
                    if($.trim(msg)==0){
                        alert('Sorry, the action failed.');
                    }else{
                         $('#grand_total_text').val(parseFloat($('#grand_total_text').val())-(parseFloat($.trim($('#total_'+inkind_id).text()))));
                        $('#row_'+inkind_id).remove();
                    }
                }
            });
            //------------------
        });
        
        
        function blank(field){
            blankfields += field+'\n';
            return false;
        }
        
        $('#inkind_pax_txt,#inkind_hour_txt,#inkind_rate_txt').on('blur',function(){
            var pax = $.trim($('#inkind_pax_txt').val()) == ''?0:parseFloat($('#inkind_pax_txt').val());
            var hour = $.trim($('#inkind_hour_txt').val()) == ''?0:parseFloat($('#inkind_hour_txt').val());
            var rate = $.trim($('#inkind_rate_txt').val()) == ''?0:parseFloat($('#inkind_rate_txt').val());
            $('#inkind_total_txt').val(pax*hour*rate);
        });

    });
</script>