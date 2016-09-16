<style type="text/css">
    input[type=file]{
        width:150px;
    }
    input[type=text],textarea{
        font:12px arial,verdana,sans-serif;
        color:#1d5987;
        margin-bottom:0px;
        resize: none
    }
    input[type=radio]{
        margin-top:0px;
    }
    table.addimage td{
        padding:5px 0 0px 10px;
        vertical-align: top;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
    
        $(document.body).on('click', 'input[id^=editcheck_]', function() {
            var id =$(this).attr('id');
            var array = id.split("_");
            if($('#editcheck_'+array[1]).is(':checked')){
                $('#title_'+array[1]).attr('disabled',false);
                $('#description_'+array[1]).attr('disabled',false);
                $('#save_'+array[1]).attr('disabled',false);
                $('#publish_'+array[1]).attr('disabled',false);
                $('#publish1_'+array[1]).attr('disabled',false);
            }else{
                $('#title_'+array[1]).attr('disabled',true);
                $('#description_'+array[1]).attr('disabled',true);
                $('#save_'+array[1]).attr('disabled',true);
                $('#publish_'+array[1]).attr('disabled',true);
                $('#publish1_'+array[1]).attr('disabled',true);
            }
        });
        
        $(document.body).on('click', 'button[id^=save_]', function() {
            var id =$(this).attr('id');
            var array = id.split("_");
            var title =   $.trim($('#title_'+array[1]).val());
            var description =   $.trim($('#description_'+array[1]).val());
            var publish=0;
            if($('#publish_'+array[1]).is(':checked')){
                publish=1;
            }else{
                publish=0;
            }
            $('#loading_'+array[1]).show();
            $.ajax({						
                type: "POST",
                url: '../Home/editSlider',
                data: {
                    id:array[1],
                    title:title,
                    description:description,
                    publish:publish
                },
                cache: false,
                error: function(xhr, status, error) {
                    alert('Error !\n Please try again.\n(Please check your internet connection.)');
                    $('#loading_'+array[1]).hide();
                },
                success: function (msg) {
                    $('#loading_'+array[1]).hide();
                    $('#loading_'+array[1]).hide();
                    if($.trim(msg)=='no'){
                        alert('Action failed.\nPlease try again after some time or refresh the page.');
                    }else{
                        dismiss(500);
                    }
                }
            });
            
            
        });
        $(document.body).on('click', 'button[id^=delete_]', function() {
            var id =$(this).attr('id');
            var array = id.split("_");
            var yes = confirm('Are you sure to remove this image from slider permanently?\nAlternatively you can make it invisible by just unpublishing it.\n Delete it anyway???')
            if(yes==true){
                $('#loading_'+array[1]).show();
                $.ajax({						
                    type: "POST",
                    url: '../Home/deleteSliderImage',
                    data: {
                        id:array[1]
                    },
                    cache: false,
                    error: function(xhr, status, error) {
                        alert('Error !\n Please try again.\n(Please check your internet connection.)');
                        $('#loading_'+array[1]).hide();
                    },
                    success: function (msg) {
                        $('#loading_'+array[1]).hide();
                        if($.trim(msg)!='1'){
                            alert('Action failed.\nPlease try again after some time or refresh the page and try again.');
                        }else{
                            $('#row_'+array[1]).remove();
                        }
                    }
                });
            }    
        });
        
       
    });
</script> 
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
        <table style="margin-top:30px;margin-bottom:30px;" width="100%" >
            <tr>
                <td style="padding:20px;">
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

                        if (isset($err) && $err != '') {
                            echo ' <div class="message-error">
                    <span class="text-error">' . $err . '. Please make sure that the width and height are 960px and 360px respectively.</span>
                </div><br />';
                        }
                        if (isset($success) && $success != '') {
                            echo ' <div class="message-success">
                    <span class="text-success">' . $success . '</span>
                </div><br />';
                        }
                        ?>
                        <table width="100%" style="border:1px solid #ccc;background:rgba(250,250,250,0.9);">
                            <tr>
                                <td style="padding:10px;">
                                    <img src="../img/gallery.png" /> Gallery Manager
                                </td>
                            </tr>
                        </table>

                        <?php echo form_open_multipart('Home/slider', array('name' => 'slider_form', 'id' => 'slider_form')); ?>

                        <table class="addimage" style="border:1px solid #ccc;background:rgba(250,250,250,0.9);margin-top:15px;" width="100%">
                            <tr >
                                <td width="15%">Image :</td>
                                <td aligh="left"><?php // echo form_upload('userfile',array('required'=>'required'));          ?>
                                    <input type="file" name="userfile" REQUIRED />
                                    <p class="text-error nicefont size11">* The dimension of image should be exactly width=960px and height=360px. 
                                        Please crop and/or resize the image with given size before uploading.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>Title </td>
                                <td><input type="text" name="slider_title" /> </td>
                            </tr>
                            <tr>
                                <td>  Description </td>
                                <td><textarea name="slider_description"> </textarea></td>
                            </tr>
                            <tr>
                                <td style="padding-bottom:10px">
                                    <input type="checkbox" name="slider_publish" value="1" checked="checked" />&nbsp; publish
                                </td>
                                <td align="left" style="padding-bottom:10px">
                                    <button class="btn btn-info">Add image to gallery</button>
                                </td>
                            </tr>
                        </table>
                        </form>
                        <div id="message" class="message-success" style="display:none;width:200px;margin:5px auto;border-radius:10px"><b class="text-success">saved</b></div>
                        <table class="dataListing" width="100%" cellspacing="0"  border="0">
                            <tbody>
                                <tr>
                                    <th width="5%" align="center">#</th>
                                    <th width="20%" align="left">Image</th>
                                    <th width="20%" align="left">Title</th>
                                    <th width="25%" align="left">Description</th>
                                    <th width="5%" align="center">Publish</th>
                                    <th width="5%" align="center">Edit</th>
                                    <th width="20%" align="left">Action</th>
                                </tr>

                                <?php
                                for ($i = 0; $i < count($slider_images); $i++) {
                                    $no = '';
                                    $yes = '';
                                    echo ' <tr id="row_' . $slider_images[$i][0] . '">
                            <td align="center">' . ($i + 1) . '</td>
                            <td align="left"><img src="../slider/tooltips/' . $slider_images[$i][3] . '" /></td>
                            <td align="left">
                            <input type="text" value="' . $slider_images[$i][1] . '" id="title_' . $slider_images[$i][0] . '" DISABLED />
                                </td>
                            <td align="left">
                            <textarea id="description_' . $slider_images[$i][0] . '" DISABLED>' . $slider_images[$i][2] . '</textarea>
                                </td>
                            <td align="left">';
                                    if ($slider_images[$i][7] == 1) {
                                        $yes = 'CHECKED';
                                    } else {
                                        $no = 'CHECKED';
                                    }
                                    echo '<span >
                                <input type="radio" name="publish_' . $slider_images[$i][0] . '" id="publish_' . $slider_images[$i][0] . '" value="1" ' . $yes . ' DISABLED />&nbsp;YES
                               <br /><input type="radio" name="publish_' . $slider_images[$i][0] . '" id="publish1_' . $slider_images[$i][0] . '" value="0" ' . $no . ' DISABLED />&nbsp;NO
                            </span>
                            </td>
                            <td align="center">
                            <input type="checkbox" id="editcheck_' . $slider_images[$i][0] . '" />
                            </td>
                            <td align="left">
                            <button class="btn btn-success" id="save_' . $slider_images[$i][0] . '" DISABLED>Save</button>&nbsp;&nbsp;
                            <button class="btn btn-danger" id="delete_' . $slider_images[$i][0] . '" >Delete</button>
                           &nbsp;&nbsp;<img src="../img/loading.gif" id="loading_' . $slider_images[$i][0] . '" class="inline-block" style="display:none" />
                            </td>
                        </tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                        <?php
                    }
                    ?>
                </td>
            </tr>

        </table>
    <?php } ?>
</div> <!-- end of container tag-->

