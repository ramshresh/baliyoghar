<?php
$myCounter = 0;
$files = glob("slider/*.*");

for ($i = 0; $i < count($files); $i++) {
    $ext = pathinfo($files[$i], PATHINFO_EXTENSION);
    if ($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif") {
        echo "<img src='../" . $files[$i] . "' />";
    }
}
?>
<div id="wowslider-container1" style="margin-bottom:30px">
    <div class="ws_images"><ul>
            <?php
            if(isset($slider_images)){
            for ($i = 0; $i < count($slider_images); $i++) {
                ?>
                <li><img src="../slider/images/<?= $slider_images[$i][3] ?>" alt="<?= $slider_images[$i][1] ?>" title="<?= $slider_images[$i][1] ?>" id="wows1_<?= $i ?>"/><?= $slider_images[$i][2] ?></li>
                <?php
            }
            ?>
        </ul></div>
    <!--div class="ws_thumbs">
        <div>
            <?php
            for ($i = 0; $i < count($slider_images); $i++) {
             ?>
                <a href="#" title="<?= $slider_images[$i][1] ?>"><img src="<?php echo '../slider/tooltips/' . $slider_images[$i][3]; ?>" alt="" /></a>
                <?php
            }
            }
            ?>
        </div>
    </div-->
    <div class="ws_shadow" style="margin:0"></div>
</div>
<script type="text/javascript" src="../slider/engine/wowslider.js"></script>
<script type="text/javascript" src="../slider/engine/script.js"></script>
