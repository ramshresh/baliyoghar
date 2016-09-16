<div class="container" >
    <table style="border:1px solid #CCC;margin-top:30px;margin-bottom:30px;background:#F0F0F0" width="100%" >
        <tr>
            <td style="padding:20px;">
                <?php
                echo form_open_multipart('Person/addNewPicture');
                ?>
                <input type="hidden" name="person_id" value="<?=$person_id?>" />
                <?php
                if ($image == '') {
                    echo '<br /><p class="text-info">Upload a new Image of ' . $person_name.'</p>';
                    echo form_upload('userfile');
                    ?>
                <?php
                } else {
                    ?>
                <img src="../gallery/thumbs/<?php echo $image; ?>" />
                <br />
                <?php
                    echo '<br /><p class="text-info">Change picture of ' . $person_name.'</p>';
                    ?>
                 <?php echo form_upload('userfile'); ?>
                <?php
                }
                ?>
                <input type="submit" class="btn btn-info" id="" value="Upload"/>
                <?php
                echo form_close();
                ?>
            </td>
        </tr>
    </table>
</div>
