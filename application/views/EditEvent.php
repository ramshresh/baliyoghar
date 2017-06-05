<link href="../leaflet/leaflet.css" rel="stylesheet">
<link href="../leaflet/label/leaflet.label.css" rel="stylesheet">
<link href="../leaflet/control/geocoder/dist/Control.Geocoder.css" rel="stylesheet">
<script src="../js/adminextents/district_vdc_municipality.js">
  <
  style
  type = "text/css" >

  #
  main - organizer - block,
  #
  implementing - partner - block
  {
    width: 300
    px;
    height: 120
    px;
    overflow - y
  :
    scroll;
    padding: 5
    px;
    border: 1
    px
    solid #ccc;
    border - radius
  :
    5
    px;
  }

  h1, h2, h3, h4, h5, h6, form, table
  {
    margin: 0
    px;
  }

  /*{{{  Map*/
  /*General marker style*/
  .map - marker
  {
    position: relative;
    text - align
  :
    center;
    font - weight
  :
    bold;
    background: #
    444;
    width: 26
    px;
    height: 26
    px;
    border - radius
  :
    5
    px;
    margin - top
  :
    -34
    px;
      /*Shift by arrow top+height*/
    margin - left
  :
    -13
    px;
      /*Shift by half the marker width*/
  }

  .map - marker
  div.arrow
  {
    position: relative;
    border - style
  :
    solid;
    border - color
  : #444
    transparent
    transparent
    transparent;
    border - width
  :
    10
    px
    6
    px
    0
    6
    px;
      /*Arrow w/h is defined by the borders*/
    left: 7
    px;
      /*(Marker width - arrow width)/2*/
    width: 0
    px;
    height: 0
    px;
  }

  .map - marker
  div.icon
  {
    position: relative;
    overflow: hidden;
    background - repeat
  :
    no - repeat;
    background - position
  :
    center;
    background - color
  : #ccc;
    width: 24
    px;
      /*Same as marker width*/
    height: 24
    px;
      /*Same as marker height*/
    line - height
  :
    24
    px;
    font - size
  :
    12
    px;
    border - radius
  :
    4
    px;
    margin - left
  :
    1
    px;
    margin - top
  :
    1
    px;
  }

  /*Marker content instances*/
  .map - marker.exclamation
  div.icon
  :
  before
  {
    content: '!';
  }

  .map - marker.A
  div.icon
  :
  before
  {
    content: 'A';
  }

  /*Marker color instances*/
  .map - marker.red
  div.icon
  {
    background: #
    ff2222;
  }

  .map - marker.green
  div.icon
  {
    background: #
    008800;
    color: #
    fff;
  }

  .map - marker.green
  {
    background: #
    000;
  }

  .map - marker.green
  div.arrow
  {
    border - top - color
  : #000;
  }

  /*Marker states*/
  .map - marker.inactive
  {
    opacity: 0.6;
  }

  /*}}}  Map*/
  </
  style >

  <!-- import script for popup -->

  < script
  src = "../js/popup/jquery.ui.core.js" ></script>
<script src="../js/popup/jquery.ui.widget.js"></script>
<script src="../js/popup/jquery.ui.mouse.js"></script>
<script src="../js/popup/jquery.ui.draggable.js"></script>
<script src="../js/popup/jquery.ui.position.js"></script>
<script src="../js/popup/jquery.ui.resizable.js"></script>
<script src="../js/popup/jquery.ui.button.js"></script>
<script src="../js/popup/jquery.ui.dialog.js"></script>

<script type="text/javascript">

  $(document.body).on('click', '#location_savebtn', function () {
    var location = $.trim($('#location_text').val());
    if (location == '') {
      alert('Location field is blank');
    } else {
      var location_code = $('#location_code_text').val();
      var level_id = $('#hidden_levelid_identifier').val();
      alert('Location field is okay');
      //------------------
      $.ajax({
        type: "POST",
        url: "../Home/addCoverageLocation",
        data: {
          coverage_location: location,
          coverage_location_code: location_code,
          coverage_level: level_id
        },
        cache: false,
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
        },
        success: function (msg) {
          var success = $.trim(msg);
          if (success == 'yes') {
            //if added to database , load the newly added vdc into dropdown and set the value
            $('#coverage_location').append('<option value="' + location + '">' + location + '</option>');
            $('#coverage_location').val(location);

            $('.ui-dialog').remove(); //dismiss the popup
            // $('#dialog').html(''); // reset the form div of popup
          }
          else {
            $('#dialog').html('<p class="text-error size11"><b>Sorry ! your request failed.</b></p>'); // reset the form div of popup
          }
        }
      });
    }
    //-----------------
  });

  $(document.body).on('click', '#location_cancelbtn', function () {
    $('.ui-dialog').remove(); //dismiss the popup
    // $('#dialog').html(''); // reset the form div of popup
  });
</script>
<!-- end script import -->

<script type="text/javascript">
  //    $(document).ready(function(){
  //        //either main organizer can be selected or implementing partner but not both at the same time -eg , vdc, vdc
  //        $(document.body).on('click','input[id^=mainorg_]',function(){
  //            var id =$(this).attr('id');
  //            var array = id.split("_");
  //            if($(this).is(':checked')){
  //                $('#implpartner_'+array[1]).prop('checked', false);
  //            }
  //        });
  //        $(document.body).on('click','input[id^=implpartner_]',function(){
  //            var id =$(this).attr('id');
  //            var array = id.split("_");
  //            if($(this).is(':checked')){
  //                $('#mainorg_'+array[1]).prop('checked', false);
  //            }
  //        });
  //
  //    });
</script>
<style>
    a.button {
        -webkit-appearance: button;
        -moz-appearance: button;
        appearance: button;

        text-decoration: none;
        color: initial;
    }
</style>
<div class="container">
    <table style="border:1px solid #CCC;margin-top:30px" width="100%" class="getBg">
        <tr>
            <td style="padding:20px">
                <?php echo form_open('Event/updateEvent', array('id' => 'event_entry_form', 'name' => 'event_entry_form')); ?>

                <h3 class="uppercase nicefont nicecolor"><b class="icon-globe"></b>
                    &nbsp;Edit event
                    <div class="pull-right">
                        <?php if (isset($previous_event_id)): ?>
                            <a href="<?= base_url() ?>Event/editEvent?id=<?= $previous_event_id ?>" class="button">Previous</a>
                        <?php endif; ?>
                        <?php if (isset($next_event_id)): ?>
                        <a href="<?= base_url() ?>Event/editEvent?id=<?= $next_event_id ?>" class="button">Next</a>
                    </div>
                    <?php endif; ?>
                </h3>
                <hr/>
                <span style="color:green"><?php if (isset($insert)) echo $insert . "<br />"; ?></span>
                <input type="hidden" name="event_id" value="<?= $event_id ?>"/>
                <input type="hidden" name="identifier" value="edit"/>
                <input type="hidden" id="event_id" value="<?= $event_id ?>"/>

                <!--                Old Values in Hidden Input      -->
                <input type="hidden" id="old-district" value="<?= $district ?>">
                <input type="hidden" id="old-vdc" value="<?= $vdc ?>">
                <input type="hidden" id="old-ward_no" value="<?= $ward_no ?>">

                <a href="../Event/addParticipant?id=<?= $event_id ?>" class="btn text-success"
                   style="margin-top:-6px;float: right;margin-bottom:0px;margin-right:5px;margin-bottom: 10px;"
                   id=""><img src="../img/add-new.png"/>&nbsp;Add new participant</a>




                <table width="" border="0">
                    <tr>
                        <td><label for="event_title">Title : </label></td>
                        <td colspan="4">
                            <input type="text" style="width:712px"
                                   value="<?= $title ?>"
                                   id="event_title"
                                   name="event_title" placeholder="Enter title"/>
                            <?= form_error('event_title', '<label for="event_title" generated="true" class="error">', '</label>') ?>

                        </td>
                    </tr>
                    <tr>
                        <td><label for="event_code">Code : </label></td>
                        <td colspan="4">
                            <input type="text" style="width:712px" value="<?= $event_code ?>" id="event_code"
                                   name="event_code" placeholder="Enter Code"/>
                            <?= form_error('event_code', '<label for="event_code" generated="true" class="error">', '</label>') ?>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <table border="0" width="100%">
                                <tr>
                                    <td style="width:148px"><label for="event_start_date">Start date : </label></td>
                                    <td style="width:220px;">
                                        <input type="text" name="event_start_date" value="<?= $start_date ?>"
                                               id="event_start_date" class="datepicker" placeholder="Enter start date"
                                               style="width:150px;"/>
                                        <?= form_error('event_start_date', '<label for="event_start_date" generated="true" class="error">', '</label>') ?>

                                    </td>
                                    <td style="width:90px"><label for="event_end_date">End date : </label></td>
                                    <td style="width:202px">
                                        <input type="text" name="event_end_date" value="<?= $end_date ?>"
                                               id="event_end_date" class="datepicker" placeholder="Enter end date"
                                               style="width:150px;"/>
                                        <?= form_error('event_end_date', '<label for="event_end_date" generated="true" class="error">', '</label>') ?>

                                    </td>
                                    <td style="width:100px"><label for="event_year">Event year : </label></td>
                                    <td>
                                        <select name="event_year" id="event_year" style="width:107px;">
                                            <?php
                                            for ($year = 2012; $year < 2020; $year++) {
                                                $selected = '';
                                                if ($event_year == $year) {
                                                    $selected = "selected";
                                                }
                                                echo ' <option value="' . $year . '" ' . $selected . '>' . $year . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:150px"><label for="event_course_category">Event type : </label></td>
                        <td style="width:300px">
                            <select name="event_course_category" id="event_course_category">
                                <option value="">-- SELECT --</option>
                                <?php
                                if (isset($CourseContent)) {
                                    echo $CourseContent;
                                }
                                ?>
                            </select>
                            <?= form_error('event_course_category', '<label for="event_course_category" generated="true" class="error">', '</label>') ?>
                            <span style="width:20px;display:inline-block">
                                <img src="../img/loading.gif" style="margin-top: -10px; padding:5px;display:none"
                                     id="loading_image"/>
                            </span>
                        </td>
                        <td style="width:50px"><span class="text-info"><b>&gt;&gt;</b></span></td>
                        <td style="width:150px"><label for="event_course_subcategory">Course : </label></td>
                        <td style="width:300px">
                            <span id="getSubCourse">
                                <?php
                                if (count($course_subcat_list) == 0) {
                                    $disabled = 'disabled';
                                } else {
                                    $disabled = '';
                                }
                                ?>
                                <select name="event_course_subcategory" <?= $disabled ?> id="event_course_subcategory">
                                    <option value="">-- SELECT --</option>
                                    <?php
                                    for ($i = 0; $i < count($course_subcat_list); $i++) {
                                        $selected = '';
                                        if ($course_subcat_id == $course_subcat_list[$i][0]) {
                                            $selected = 'selected';
                                        }
                                        echo '<option value="' . $course_subcat_list[$i][0] . '" ' . $selected . '>' . $course_subcat_list[$i][1] . '</option>';
                                    }
                                    ?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Coverage level : </label></td>
                        <td>
                            <select name="coverage_level" id="event_level">
                                <option value="">Select</option>
                                <?php
                                if (isset($coverage_level_array) && count($coverage_level_array) > 0) {
                                    for ($i = 0; $i < count($coverage_level_array); $i++) {
                                        $selected = '';
                                        if ($coverage_level_id == $coverage_level_array[$i][0]) {
                                            $selected = 'selected';
                                        }
                                        echo '<option value="' . $coverage_level_array[$i][0] . '" ' . $selected . '>' . $coverage_level_array[$i][1] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <span style="width:20px;display:inline-block">
                                <img id="loading_image1" style="margin-top: -10px; padding: 5px; display: none;"
                                     src="../img/loading.gif">
                            </span>
                        </td>
                        <td style="width:50px"><span class="text-info"><b>&gt;&gt;</b></span></td>
                        <td><label>Coverage location : </label></td>
                        <td>
                            <?php
                            echo '<span id="coverage_location_content">';


                            //if vdc then add a + button icon
                            switch (strtoupper($level)) {
                                case 'MUNICIPALITY':
                                case 'DISTRICT':
                                case 'REGION':
                                    echo '<select id = "coverage_location" name = "coverage_location">';
                                    echo $location;
                                    echo '</select>';
                                    break;
                                case 'VDC':
                                    echo '<select id = "coverage_location" name = "coverage_location">';
                                    echo $location;
                                    echo '</select>';
                                    echo '<img id="addnewvdc" title="Add new VDC" src="../img/add-new.png">';
                                    break;
                                default:
                                    break;
                            }
                            echo '</span>';
                            ?>
                            <!---------------------------->
                            <span class="text-error size11" id="mandatory_msg" style="display:none">*Select coverage level first</span>
                            <!---------------------------->
                        </td>
                    </tr>

                    <!--                    District VDC Ward No-->
                    <tr>
                        <td><label>District : </label></td>
                        <td>
                            <select name="district" id="district">
                            </select>
                            <?= form_error('district', '<label for="district" generated="true" class="error">', '</label>') ?>

                            <span style="width:20px;display:inline-block">
                                <img id="loading_image-district" style="margin-top: -10px; padding: 5px; display: none;"
                                     src="../img/loading.gif">
                            </span>
                        </td>
                        <td style="width:50px"><span class="text-info"><b>&gt;&gt;</b></span></td>
                        <td><label>VDC/Municipality : </label></td>
                        <td>
                            <span class="text-error size11" id="mandatory_msg-district">*Select district first</span>
                            <span id="select_vdc_content"></span>
                            <?= form_error('vdc', '<label for="vdc" generated="true" class="error">', '</label>') ?>

                        </td>
                    </tr>
                    <tr>
                        <td><label>Ward No : </label></td>
                        <td>
                            <span class="text-error size11" id="mandatory_msg-vdc">*Select vdc first</span>
                            <span id="select_ward_no_content"></span>
                            <?= form_error('ward_no', '<label for="ward_no" generated="true" class="error">', '</label>') ?>

                        </td>

                    </tr>

                    <tr>
                        <td style="vertical-align: top">
                            <label for="main-organizer-block">Main organizer : </label>
                            <!-- <input type="radio" checked="checked" id="main-organizer-radio" name="organizer-radio">&nbsp; <label for="main-organizer-radio" style="display:inline-block"><span class="text-warning"> select </span></label> -->
                        </td>
                        <td>
                            <input type="hidden" name="org_identifier" id="org_identifier"/>
                            <div id="main-organizer-block">
                                <?php
                                if (isset($organizer_array)) {
                                    for ($i = 0; $i < count($organizer_array); $i++) {
                                        if ($i != 0) {
                                            echo '<br />';
                                        }
                                        $checked = '';
                                        for ($j = 0; $j < count($main_organizer_array); $j++) {
                                            $checked = '';
                                            if ($main_organizer_array[$j][2] == $organizer_array[$i][0]) {
                                                $checked = 'checked';
                                                break;
                                            }
                                        }
                                        echo '<input ' . $checked . ' type="checkbox" class="tg" id="mainorg_' . $organizer_array[$i][0] . '" name="mainorg_' . $organizer_array[$i][0] . '" value="' . $organizer_array[$i][1] . '" /> &nbsp; ' . $organizer_array[$i][1];
                                    }
                                } else {
                                    echo "<div class='message-error'><p class='text-error'> Some error occured!</p>
                                          <p class='text-error'><a href='../Home/newevents'>Click here</a> to retry</p></div>";
                                }
                                ?>
                            </div>
                        </td>
                        <td style="width:50px"></td>
                        <td style="vertical-align: top">
                            <label for="implementing-partner-block">Implementing partner : </label>
                            <!--     <input type="radio" id="implementing-partner-radio" name="organizer-radio" />&nbsp;<label for="implementing-partner-radio" style="display:inline-block"><span class="text-warning"> select </span></label> -->
                        </td>
                        <td>
                            <div id="implementing-partner-block">
                                <?php
                                if (isset($organizer_array)) {
                                    for ($i = 0; $i < count($organizer_array); $i++) {
                                        if ($i != 0) {
                                            echo '<br />';
                                        }
                                        $checked = '';
                                        for ($j = 0; $j < count($impl_partner_array); $j++) {
                                            $checked = '';
                                            // echo $impl_partner_array[$j][0].'=='.$organizer_array[$i][0].'<br />';
                                            if ($impl_partner_array[$j][2] == $organizer_array[$i][0]) {
                                                $checked = 'checked';
                                                break;
                                            }
                                        }

                                        echo '<input ' . $checked . ' type="checkbox" class="tg" id="implpartner_' . $organizer_array[$i][0] . '"  name="implpartner_' . $organizer_array[$i][0] . '" value="' . $organizer_array[$i][1] . '" /> &nbsp; ' . $organizer_array[$i][1];
                                    }
                                } else {
                                    echo "<div class='message-error'><p class='text-error'> Some error occured!</p>
                                          <p class='text-error'><a href='../HomeController/events'>Click here</a> to retry</p></div>";
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Venue : </label></td>
                        <td>
                            <input type="text" name="event_venue" value="<?= $venue ?>" placeholder="Enter venue"/>
                            <?= form_error('event_venue', '<label for="event_venue" generated="true" class="error">', '</label>') ?>

                        </td>
                        <td style="width:50px"></td>
                        <td><label>Tole/Placename : </label></td>
                        <td>
                            <input type="text" name="event_address" value="<?= $address ?>"
                                   placeholder="Enter address"/>
                            <?= form_error('event_address', '<label for="event_address" generated="true" class="error">', '</label>') ?>

                        </td>
                    </tr>

                    <tr>
                        <td><label>Latitude : </label></td>
                        <td>
                            <input type="number" name="latitude" value="<?= $latitude ?>" placeholder="Latitude"/>
                            <?= form_error('latitude', '<label for="latitude" generated="true" class="error">', '</label>') ?>

                        </td>
                        <td style="width:50px"></td>
                        <td><label>Longitude : </label></td>
                        <td>
                            <input type="number" name="longitude" value="<?= $longitude ?>" placeholder="Longitude"/>
                            <?= form_error('longitude', '<label for="longitude" generated="true" class="error">', '</label>') ?>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <div id="map" style="height:300px; width: auto; border: solid">

                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="padding:20px 0 0 0">
                            <button id="save_event_btn" class="btn btn-info">Save</button>
                        </td>
                    </tr>
                </table>
                <?php echo form_close(); ?>
            </td>
        </tr>
    </table>

</div> <!-- end of container tag-->


<div id="dialog" style="width:auto" title="" style="padding:10px">

</div>


<script type="text/javascript">
  $(document).ready(function () {
    //either main organizer can be selected or implementing partner but not both at the same time -eg , vdc, vdc
//        $(document.body).on('click','input[id^=mainorg_]',function(){
//            var id =$(this).attr('id');
//            var array = id.split("_");
//            if($(this).is(':checked')){
//                $('#implpartner_'+array[1]).prop('checked', false);
//            }
//        });
//        $(document.body).on('click','input[id^=implpartner_]',function(){
//            var id =$(this).attr('id');
//            var array = id.split("_");
//            if($(this).is(':checked')){
//                $('#mainorg_'+array[1]).prop('checked', false);
//            }
//        });


    var $lat = $("input[name='latitude']");
    var $lng = $("input[name='longitude']");

    var new_event_marker;
    var map = new L.Map('map');
    var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var osmAttrib = 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
    var baseLayerOSM = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 15, attribution: osmAttrib});
    // start the map in South-East England
    map.setView(new L.LatLng(27.7, 86.2), 9);
    map.addLayer(baseLayerOSM);

    L.Control.geocoder().addTo(map);


    if ($lat.val().length > 0 && $lng.val().length > 0) {
      new_event_marker = new L.marker([$lat.val(), $lng.val()], {draggable: true});
      new_event_marker.addTo(map);
      new_event_marker.on('dragend', function (event) {
        var marker = event.target;
        var position = marker.getLatLng();
        syncLatlngFromMarker();
      });
      map.panTo(new L.LatLng($lat.val(), $lng.val()));
      //new_event_marker.dragging.disable();
    }

    if (typeof(new_event_marker) === 'undefined') {
      map.on('click', function (e) {
        createOrUpdateMarkerLatLng(e.latlng);
        syncLatlngFromMarker();
      });
    }

    function createOrUpdateMarkerLatLng(latlng) {
      if (typeof(new_event_marker) === 'undefined') {
        new_event_marker = new L.marker(latlng, {draggable: true});
        new_event_marker.addTo(map);
      }
      else {
        new_event_marker.setLatLng(latlng);
      }
    }

    function setMarkerLatLng(latlng) {
      createOrUpdateMarkerLatLng(latlng);
    }

    function getMarkerLatLng() {
      return new_event_marker.latlng;
    }


    function syncLatlngToMarker() {
      var latVal = $lat.val();
      var lngVal = $lng.val();
      if (latVal.length > 0 && lngVal.length > 0) {
        setMarkerLatLng([latVal, lngVal]);
      } else {
        alert('empty');
      }
    }

    function syncLatlngFromMarker() {
      $lat.val(new_event_marker.getLatLng().lat);
      $lng.val(new_event_marker.getLatLng().lng);
    }

    $lat.on("change paste keyup", function () {
      if (typeof(new_event_marker) != 'undefined') {
        var lat = $lat.val();
        var lng = new_event_marker.getLatLng().lng;
        var latlng = {"lat": lat, "lng": lng};
        new_event_marker.setLatLng(latlng);
        map.panTo(new L.LatLng(lat, lng));
      }

    });

    $lng.on("change paste keyup", function () {
      if (typeof(new_event_marker) != 'undefined') {
        var lng = $lng.val();
        var lat = new_event_marker.getLatLng().lat;
        var latlng = {"lat": lat, "lng": lng};
        new_event_marker.setLatLng(latlng);
        map.panTo(new L.LatLng(lat, lng));
      }

    });

//
    data = [{iconclass: 'A', lat: 59.915, lon: 10.735}
      , {iconclass: 'exclamation', lat: 59.9, lon: 10.7}
      , {iconclass: 'BBL', lat: 59.9, lon: 10.75}
    ];

    var iconclasses = {
      exclamation: 'font-size: 22px;',
      A: 'font-size: 22px;'
    };
      /*var map = new L.Map('map', {
       center: [data[0].lat,data[0].lon],
       zoom: 13
       });
       L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
       */
    data.forEach(function (row) {
      var pos = new L.LatLng(row.lat, row.lon);
      var iconclass = iconclasses[row.iconclass] ? row.iconclass : '';
      var iconstyle = iconclass ? iconclasses[iconclass] : '';
      var icontext = iconclass ? '' : row.iconclass;

      var icon = L.divIcon({
        className: 'map-marker ' + iconclass,
        iconSize: null,
        html: '<div class="icon" style="' + iconstyle + '">' + icontext + '</div><div class="arrow" />'
      });

      L.marker(pos).addTo(map); //reference marker
      L.marker(pos, {icon: icon}).addTo(map);

    });


  });
</script>


<script src="../leaflet/leaflet-src.js"></script>
<script src="../leaflet/search/dist/leaflet-search.min.js"></script>
<script src="../leaflet/control/geocoder/dist/Control.Geocoder.js"></script>