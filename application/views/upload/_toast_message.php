<?php
/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 6/8/2017
 * Time: 3:09 PM
 */
?>
<?php if(isset($toast_message)):?>
    <?php
    $title = isset($toast_message['title'])?$toast_message['title']:'{{ title }}';
    $message = isset($toast_message['message'])?$toast_message['message']:'{{ message }}';
    $class = isset($toast_message['class'])?$toast_message['class']:'info';
    ?>
    <div class="alert alert-<?= $class; ?> alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong><?= $title ?></strong>
        <div><?= $message ?></div>
    </div>
<?php endif; ?>
