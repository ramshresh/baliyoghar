<style type="text/css">
    table.table tr th{
        text-align: center;
        background:rgba(0,255,0,0.1);
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

                <h4> List of users: </h4>
                <table class="table table-striped" style="margin-top:20px">
                    <tr>
                        <th style="width:50px">S.N.</th>
                        <th style="width:200px">Username </th>
                        <th style="width:140px">Role </th>
                        <th style="width:160">Created by</th>
                        <th style="width:150px">Created date</th>
                        <th >Actions</th>
                    </tr>


                    <?php
                    $string = '';
                    if (isset($user_data)) {
                        $count = count($user_data);
                        if ($count > 0) {
                            for ($i = 0; $i < $count; $i++) {
                                $string .= '<tr>';

                                $string .= '<td>';
                                $string .= $i + 1;
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= '<p class="text-success"><b><a href="../UserEventController/viewUser?id=' . $user_data[$i][0] . '">' . $user_data[$i][1] . '</a></b></p>';
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= $user_data[$i][2];
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= $user_data[$i][3];
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= $user_data[$i][4];
                                $string .= '</td>';
                                $string .= '<td>';
                                $string .= '&nbsp;<button class="btn btn-danger handcursor" id="userMgmt_del_' . $user_data[$i][0] . '"><span class="icon-trash icon-white"></span>&nbsp;Delete</button>';
                                $string .= '&nbsp<button onclick = "alert(\'not functional\')" class="btn btn-warning handcursor" id="userMgmt_change_' . $user_data[$i][0] . '"><span class="icon-trash icon-pencil"></span>&nbsp;Change password</button>';

                                $string .= '</td>';

                                $string .= '</tr>';
                            }
                            echo $string;
                        } else {
                            echo '<tr><td colspan="8"><p class="text-error"><b>No data</b></p></td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8"><p class="text-error"><b>No data</b></p></td></tr>';
                    }
                    ?>

                </table>
            </td>
        </tr>
    </table>
    <?php } ?>
</div> <!-- end of container tag-->

<script type="text/javascript">
    $(document.body).on('click','button[id^=userMgmt_del_]',function(){
        if(confirm('Are you sure you want to delete this user?')){
            var id =$(this).attr('id');
            var array = id.split("_");
            var id = array[2];
            $.ajax({						
                type: "POST",
                url: "../User/deleteUser",
                data: {
                    id:id
                },
                cache: false,
                error: function(xhr, status, error) {
                    alert('Error !\n Please try again.\n(Please check your internet connection.)');
                },
                success: function (msg) {
                    if($.trim(msg)=='1'){
                        location.href='../User/userList';
                    }else{
                        alert('User couldn\'t be deleted');
                    }
                }
            });
        }
    });
</script>