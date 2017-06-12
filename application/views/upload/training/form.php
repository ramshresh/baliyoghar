<?php
/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 6/8/2017
 * Time: 2:57 PM
 */
?>
<h1>Upload Events Form</h1>
<?php $this->load->view('upload/_toast_message');?>
<?php echo form_open_multipart(base_url().'upload/upload_trainings','method="POST"'); ?>
<button type="submit" class="btn btn-primary pull-right">Upload</button>
<input type="file" name="userfile" class="btn pull-right" size="20">
<?php form_close(); ?>
