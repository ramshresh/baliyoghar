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
                <p class="text-info">Add new cost sharing party</p>
                <input type="hidden" name="loggedin_user" id="loggedin_user" value ="<?= $this->session->userdata('username') ?>"/>
                <input type="text" name="csparty" id="addcsparty_txt" style="margin-bottom:0px"/>
                <button class="btn btn-info" id="csparty_btn" >Add new</button>
                <span class="loading-image-block">
                    <img src="../img/loading.gif" style="display:none" id="csparty_img" />
                </span>
            </td>
            <td style="padding:20px;vertical-align: top">
                <p class="text-info">Existing cost sharing parties</p>
                <table class="dataListing" id="csparty_table" style="width:400px" cellspacing="0" cellpadding="5" border="0">
                    <tr>
                        <th width="8%" align="center">#</th>
                        <th width="57%" align="left">Party</th>
                        <th width="35%" align="left">Action
                            <span class="loading-image-block">
                                <img src="../img/loading.gif" style="display:none" id="csaction_img" />
                            </span></th>
                    </tr>
                    <?php
                    if (isset($sharing_parties_array)) {
                        for ($i = 0; $i < count($sharing_parties_array); $i++) {
                            echo '<tr id="csparty-row_' . $sharing_parties_array[$i][0] . '">';
                            echo '<td align = "center">' . ($i + 1) . '</td>';
                            echo '<td align = "left" ><span id="csparty-inputspan_' . $sharing_parties_array[$i][0] . '" >' . $sharing_parties_array[$i][1] . '</span>';
                            echo '<input type="text" style="margin:0;width:200px;height:15px;font:11px arial,verdana;display:none" id="csparty-hiddentxt_' . $sharing_parties_array[$i][0] . '" value="' . $sharing_parties_array[$i][1] . '" >
                                 </td>';
                            echo '<td align="left"><span id="csparty-editspan_' . $sharing_parties_array[$i][0] . '" >
                                 <a class="handcursor" id="csparty-edit_' . ($i + 1) . '_' . $sharing_parties_array[$i][0] . '">edit</a>
                                 &nbsp;&nbsp;&nbsp;</span>';

                            echo '<span style="display:none" id="csparty-updatespan_' . $sharing_parties_array[$i][0] . '" >
                                 <a class="text-success handcursor" id="csparty-save_' . $sharing_parties_array[$i][0] . '">save</a>
                                 &nbsp; <a  class="text-warning handcursor" id="csparty-cancel_' . $sharing_parties_array[$i][0] . '">cancel</a>
                                 &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                                 </span>';

                            echo '<a class="text-error handcursor" id="csparty-delete_' . $sharing_parties_array[$i][0] . 
                                    '" >delete</a></td>';
                            echo '</tr>';
                        }
                        echo "<input type='hidden' value='" . ($i + 1) . "' id='hidden-party-counter' />";
                    }
                    ?>

                    <!--
                    
                                        <tr>                            
                                            <td align="center">1</td>
                                            <td align="left"><?= $this->session->userdata('fullname') ?></td>
                                            <td align="left"><a href="#">edit</a>
                                                &nbsp;&nbsp;&nbsp; 
                                                <a href="#" onclick="return confirm('are you sure?')">delete</a></td>
                                        </tr>
                                        <tr>
                                            <td align="center">1</td>
                                            <td align="left">
                                                <input type="text" value="Municipality" style="margin:0;width:200px;height:15px;font:11px arial,verdana">
                                            </td>
                                            <td align="left"> 
                    
                                                <a href="#" class="text-success">save</a>
                                                &nbsp;
                                                <a href="#" class="text-error">cancel</a>
                                                &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                    
                                                <a href="#" onclick="return confirm('are you sure?')">delete</a></td>
                                        </tr>
                                        
                    -->
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


