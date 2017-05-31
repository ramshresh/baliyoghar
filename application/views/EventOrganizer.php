<style type="text/css">

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
    <table style="border:1px solid #CCC;margin-top:30px;margin-bottom:30px;" width="100%" >
        <tr>
            <td style="padding:20px;vertical-align: top">
                <p class="text-info">Add new event organizer</p>
                <input type="hidden" name="loggedin_user" id="loggedin_user" value ="<?= $this->session->userdata('username') ?>"/>
                <input type="text" name="mainorganizer" id="addmainorganizer_txt" style="margin-bottom:0px"/>
                <button class="btn btn-info" id="mainorganizer_btn" >Add new</button>
                <span class="loading-image-block">
                    <img src="../img/loading.gif" style="display:none" id="mainorganizer_img" />
                </span>
            </td>
            <td style="padding:20px;vertical-align: top">
                <p class="text-info">Existing event organizer</p>
                <table class="dataListing" id="mainorganizer_table" style="width:400px" cellspacing="0" cellpadding="5" border="0">
                    <tr>
                        <th width="8%" align="center">#</th>
                        <th width="57%" align="left">Organizer</th>
                        <th width="35%" align="left">Action
                            <span class="loading-image-block">
                                <img src="../img/loading.gif" style="display:none" id="mainorganizerAction_img" />
                            </span></th>
                    </tr>
                    <?php
                    if (isset($mainorganizer_array)) {
                        for ($i = 0; $i < count($mainorganizer_array); $i++) {
                            echo '<tr id="mainorganizer-row_' . $mainorganizer_array[$i][0] . '">';
                            echo '<td align = "center">' . ($i + 1) . '</td>';
                            echo '<td align = "left" ><span id="mainorganizer-inputspan_' . $mainorganizer_array[$i][0] . '" >' . $mainorganizer_array[$i][1] . '</span>';
                            echo '<input type="text" style="margin:0;width:200px;height:15px;font:11px arial,verdana;display:none" id="mainorganizer-hiddentxt_' . $mainorganizer_array[$i][0] . '" value="' . $mainorganizer_array[$i][1] . '" >
                                 </td>';
                            echo '<td align="left"><span id="mainorganizer-editspan_' . $mainorganizer_array[$i][0] . '" >
                                 <a class="handcursor" id="mainorganizer-edit_' . ($i + 1) . '_' . $mainorganizer_array[$i][0] . '">edit</a>
                                 &nbsp;&nbsp;&nbsp;</span>';

                            echo '<span style="display:none" id="mainorganizer-updatespan_' . $mainorganizer_array[$i][0] . '" >
                                 <a class="text-success handcursor" id="mainorganizer-save_' . $mainorganizer_array[$i][0] . '">save</a>
                                 &nbsp; <a  class="text-warning handcursor" id="mainorganizer-cancel_' . $mainorganizer_array[$i][0] . '">cancel</a>
                                 &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                                 </span>';

                            echo '<a class="text-error handcursor" id="mainorganizer-delete_' . $mainorganizer_array[$i][0] .
                            '" >delete</a></td>';
                            echo '</tr>';
                        }
                        echo "<input type='hidden' value='" . ($i + 1) . "' id='hidden-party-counter' />";
                    }
                    ?>

                </table>
            </td>
        <tr>
            <td colspan="2">
        <center>
            <div id="message" class="message-error" style="display:none;border-radius:10px">
                <span class="text-error">Can't delete. There are other data aassociated with it.</span>
            </div>
        </center>
        </td>
        </tr>
    </table>
    <?php } ?>
</div> <!-- end of container tag-->


<script type="text/javascript">
    
    $(document.body).on('click','#mainorganizer_btn',function(){
        var organizer = $.trim($('#addmainorganizer_txt').val());
        if(organizer ==''){
            alert('Field shouln\'t be blank');
            return false;
        }else{
            $('#mainorganizerAction_img').show();
            $.ajax({
                type: "POST",
                url: "../Home/addEventOrganizer",
                data: {
                    organizer:organizer
                },
                error: function(xhr, status, error) {
                    alert('Error !\n Please try again.\n(Please check your internet connection.)');
                    $('#mainorganizerAction_img').hide();
                    $('#addmainorganizer_txt').val('');
                },
                success: function (msg) {
                    $('#mainorganizerAction_img').hide();
                    msg = $.trim(msg);
                    if($.trim(msg)!='0'){
                        var string = '<tr id="mainorganizer-row_' + msg +'">';
                        string += '<td align = "center">'+$('#hidden-party-counter').val()+'</td>';
                        string += '<td align = "left" ><span id="mainorganizer-inputspan_' + msg + '" >' + organizer + '</span>';
                        string += '<input type="text" style="margin:0;width:200px;height:15px;font:11px arial,verdana;display:none" id="mainorganizer-hiddentxt_' +msg+ '" value="' +organizer+'" >';
                        string +=  '   </td>';
                        string += '<td align="left"><span id="mainorganizer-editspan_' +msg+ '" >';
                        string +=   ' <a class="handcursor" id="mainorganizer-edit_' +$('#hidden-party-counter').val()+'_' +msg+ '">edit</a>';
                        string +=   ' &nbsp;&nbsp;&nbsp;</span>';

                        string += '<span style="display:none" id="mainorganizer-updatespan_' +msg+ '" >';
                        string +=   ' <a class="text-success handcursor" id="mainorganizer-save_' +msg+ '">save</a>';
                        string +=    ' &nbsp; <a  class="text-warning handcursor" id="mainorganizer-cancel_' +msg+ '">cancel</a>';
                        string +=    ' &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;';
                        string +=    ' </span>';

                        string += '<a class="text-error handcursor" id="mainorganizer-delete_' +msg+ '" >delete</a></td>';
                        string += '</tr>';
                        
                        $('#hidden-party-counter').val(parseInt( $('#hidden-party-counter').val(), 10)+1);
                        $('#mainorganizer_table').append(string);
                        $('#addmainorganizer_txt').val('');
                    }else{
                        alert('Sorry, insertion failed');
                        $('#addmainorganizer_txt').val('');
                    }
                
                }
            });
        }
    });
    $(document.body).on('click', 'a[id^=mainorganizer-edit_]', function() {
        var id =$(this).attr('id');
        var array = id.split("_");
        console.log(id);
        console.log(array);

        $('#mainorganizer-inputspan_'+array[2]).hide();
        $('#mainorganizer-hiddentxt_'+array[2]).show();
        
        $('#mainorganizer-editspan_'+array[2]).hide();
        $('#mainorganizer-updatespan_'+array[2]).show();
        
    });
    
     $(document.body).on('click', 'a[id^=mainorganizer-save_]', function() {
        var id =$(this).attr('id');
        var array = id.split("_");
        var organizer_name =  $.trim($('#mainorganizer-hiddentxt_'+array[1]).val());
        if(organizer_name == ''){
            alert('Field is blank');
            return false;
        }
        else{
            $('#mainorganizerAction_img').show();
            $.ajax({
                type: "POST",
                url: "../Home/editEventOrganizer",
                data: {
                    id:array[1],
                    organizer:organizer_name
                },
                error: function(xhr, status, error) {
                    alert('Error !\n Please try again.\n(Please check your internet connection.)');
                   $('#mainorganizerAction_img').hide();
                },
                success: function (msg) {
                    $('#mainorganizerAction_img').hide();
                    if($.trim(msg)==1){
                        $('#mainorganizer-inputspan_'+array[1]).text(organizer_name);
                        //repeat action similarr to that of clicking cancel button
                        $('#mainorganizer-inputspan_'+array[1]).show();
                        $('#mainorganizer-hiddentxt_'+array[1]).hide();
        
                        $('#mainorganizer-editspan_'+array[1]).show();
                        $('#mainorganizer-updatespan_'+array[1]).hide();
                    }else{
                        alert('Sorry, the action failed.');
                    }
                }
            });
        }     
    });
    
    $(document.body).on('click', 'a[id^=mainorganizer-cancel_]', function() {
        var id =$(this).attr('id');
        var array = id.split("_");
        $('#mainorganizer-inputspan_'+array[1]).show();
        $('#mainorganizer-hiddentxt_'+array[1]).hide();
        
        $('#mainorganizer-editspan_'+array[1]).show();
        $('#mainorganizer-updatespan_'+array[1]).hide();

    });
    
    $(document.body).on('click', 'a[id^=mainorganizer-delete_]', function() {
        var confirmation = confirm('Are you sure want to continue?\n If other data are dependent on this data the action will be cancelled.');
        if(confirmation==true){
           // $('#csaction_img').show();
            var id =$(this).attr('id');
            var array = id.split("_");
            $.ajax({
                type: "POST",
                url: "../Home/deleteEventOrganizer",
                data: {
                    id:array[1]
                },
                error: function(xhr, status, error) {
                    alert('Error !\n Please try again.\n(Please check your internet connection.)');
                   // $('#csaction_img').hide();
                },
                success: function (msg) {
                  //  $('#csaction_img').hide();
                    if($.trim(msg)==1){
                        $('#mainorganizer-row_'+array[1]).remove();
                    }else if($.trim(msg)=='associated'){
                        dismiss(5000);
                    }else{
                        alert('Sorry, the action failed.');
                    }
                }
            });
        }      
    });
    
    /*
    $(document.body).on('click', 'a[id^=csparty-save_]', function() {
        var id =$(this).attr('id');
        var array = id.split("_");
        var party_name =  $.trim($('#csparty-hiddentxt_'+array[1]).val());
        if(party_name == ''){
            alert('Field is blank');
            return false;
        }
        else{
            $('#csaction_img').show();
            $.ajax({
                type: "POST",
                url: root+"Home/editParty",
                data: {
                    id:array[1],
                    party:party_name
                },
                error: function(xhr, status, error) {
                    alert('Error !\n Please try again.\n(Please check your internet connection.)');
                    $('#csaction_img').hide();
                },
                success: function (msg) {
                    $('#csaction_img').hide();
                    if($.trim(msg)==1){
                        $('#csparty-inputspan_'+array[1]).text(party_name);
                        //repeat action similarr to that of clicking cancel button
                        $('#csparty-inputspan_'+array[1]).show();
                        $('#csparty-hiddentxt_'+array[1]).hide();
        
                        $('#csparty-editspan_'+array[1]).show();
                        $('#csparty-updatespan_'+array[1]).hide();
                    }else{
                        alert('Sorry, the action failed.');
                    }
                }
            });
            
        }     
    });
    */
    
</script>