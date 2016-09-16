<style type="text/css">
    #help_icon{
        position:relative;
    }
</style>

<div class="container">

    <br />
     <center><span style="margin-bottom:10px;display:inline-block;"> <button class="btn btn-info nicefont size16 text-info" onClick="location.href='newevents'">Add Events</button></span></center>

    <br />

    <center>
        <br />
        <?php
        require_once 'slider/slider.php';
        ?>
    </center>

    <div class="container" style="width:980px;margin-bottom:50px" >


        <div id="help_icon">

            <div style="margin:0;display:none" id="mainContent">
                <center>
                    <img src="../img/triangle.png" style="margin-top:-5px"/>
                </center>
            <table style="border:3px solid #297B9F;margin-top:-4px;background:rgba(250,250,250,0.8)" width="100%" >
                <tr>
                    <td style="padding:20px;">
                        <div id="helpcontent" >
                            <?php
                            if (isset($helpcontent)) {
                                echo $helpcontent;

                            }
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            </div><!-- end of main content -->
        </div>
    </div> <!-- end of container tag -->
</div>
