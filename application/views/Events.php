<link href="../leaflet/leaflet.css" rel="stylesheet">
<link href="../leaflet/label/leaflet.label.css" rel="stylesheet">
<link href="../leaflet/control/geocoder/dist/Control.Geocoder.css" rel="stylesheet">
<script src="../js/adminextents/district_vdc_municipality.js">

<style type="text/css">

	#main-organizer-block, #implementing-partner-block {
		width: 300px;
		height: 120px;
		overflow-y: scroll;
		padding: 5px;
		border: 1px solid #ccc;
		border-radius: 5px;
	}

	h1, h2, h3, h4, h5, h6, form, table {
		margin: 0px;
	}
</style>

<style>
	/*General marker style*/
	.map-marker {
		position: relative;
		text-align: center;
		font-weight: bold;
		background: #444;
		width: 26px;
		height: 26px;
		border-radius: 5px;
		margin-top: -34px; /*Shift by arrow top+height*/
		margin-left: -13px; /*Shift by half the marker width*/
	}

	.map-marker div.arrow {
		position: relative;
		border-style: solid;
		border-color: #444 transparent transparent transparent;
		border-width: 10px 6px 0 6px; /*Arrow w/h is defined by the borders*/
		left: 7px; /*(Marker width - arrow width)/2*/
		width: 0px; height: 0px;
	}

	.map-marker div.icon {
		position: relative;
		overflow: hidden;
		background-repeat:no-repeat;
		background-position:center;
		background-color: #ccc;
		width: 24px; /*Same as marker width*/
		height: 24px; /*Same as marker height*/
		line-height: 24px;
		font-size: 12px;
		border-radius: 4px;
		margin-left: 1px;
		margin-top: 1px;
	}

	/*Marker content instances*/
	.map-marker.exclamation div.icon:before{
		content: '!';
	}
	.map-marker.A div.icon:before{
		content: 'A';
	}

	/*Marker color instances*/
	.map-marker.red div.icon{background: #ff2222;}

	.map-marker.green div.icon{background: #008800;color: #fff;}
	.map-marker.green {background: #000;}
	.map-marker.green div.arrow{border-top-color: #000;}

	/*Marker states*/
	.map-marker.inactive {
		opacity: 0.6;
	}

</style>
<!-- import script for popup -->

<script src="../js/popup/jquery.ui.core.js"></script>
<script src="../js/popup/jquery.ui.widget.js"></script>
<script src="../js/popup/jquery.ui.mouse.js"></script>
<script src="../js/popup/jquery.ui.draggable.js"></script>
<script src="../js/popup/jquery.ui.position.js"></script>
<script src="../js/popup/jquery.ui.resizable.js"></script>
<script src="../js/popup/jquery.ui.button.js"></script>
<script src="../js/popup/jquery.ui.dialog.js"></script>




<div class="container">
	<table style="border:1px solid #CCC;margin-top:30px" width="100%" class="getBg">
		<tr>
			<td style="padding:20px">
				<h3 class="uppercase nicefont nicecolor"><b class=""></b> &nbsp;Report Activity/Event </h3>
				<hr/>

				<span style="color:green"><?php if (isset($insert)) echo $insert . "<br />"; ?></span>
				<?php echo form_open('Event/createEvent', array('id' => 'event_entry_form', 'name' => 'event_entry_form')); ?>
				<input type="hidden" name="identifier" value="insert"/>
				<table width="" border="0">
					<tr>
						<td><label for="event_title">Title : </label></td>
						<td colspan="4">
							<input type="text" style="width:712px" id="event_title" name="event_title"
								   placeholder="Enter title"
                                   value="<?php echo set_value('event_title') ?>"
                            />
						</td>
					</tr>
					<tr>
						<td><label for="event_code">Code : </label></td>
						<td colspan="4">
							<input type="text" style="width:712px" id="event_code" name="event_code"
								   placeholder="Enter Code"
                                   value="<?php echo set_value('event_code') ?>"
                            />
                            <?= form_error('event_code','<label for="event_code" generated="true" class="error">','</label>')?>
						</td>
					</tr>
					<tr>
						<td colspan="5">
							<table border="0" width="100%">
								<tr>
									<td style="width:148px"><label for="event_start_date">Start date : </label></td>
									<td style="width:220px;">
										<input type="text" name="event_start_date" id="event_start_date"
											   class="datepicker" placeholder="Enter start date"
                                               value="<?php echo set_value('event_start_date') ?>"
                                               style="width:150px;"/>
                                        <?= form_error('event_start_date','<label for="event_code" generated="true" class="error">','</label>')?>
									</td>
									<td style="width:90px"><label for="event_end_date">End date : </label></td>
									<td style="width:202px">
										<input type="text" name="event_end_date" id="event_end_date" class="datepicker"
											   placeholder="Enter end date" value="<?php echo set_value('event_end_date') ?>"
                                               style="width:150px;"/>
                                        <?= form_error('event_end_date','<label for="event_code" generated="true" class="error">','</label>')?>
									</td>
<!--									<td style="width:100px"><label for="event_year">Event year : </label></td>-->
									<!--<td>
										<select name="event_year" id="event_year" style="width:107px;">
											<option value="2012" >2012</option>
											<option value="2013" selected>2013</option>
											<option value="2014">2014</option>
											<option value="2015">2015</option>
											<option value="2016">2016</option>
											<option value="2017">2017</option>
											<option value="2018">2018</option>
											<option value="2019">2019</option>
											<option value="2020">2020</option>
										</select>
									</td>-->
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
                            <?= form_error('event_course_category','<label for="event_course_category" generated="true" class="error">','</label>')?>
                            <span style="width:20px;display:inline-block">
                                <img src="../img/loading.gif" style="margin-top: -10px; padding:5px;display:none"
									 id="loading_image"/>
                            </span>
						</td>
						<td style="width:50px"><span class="text-info"><b>&gt;&gt;</b></span></td>
						<td style="width:150px"><label for="event_course_subcategory">Course : </label></td>
						<td style="width:300px">
                            <span id="getSubCourse">
                                <select name="event_course_subcategory" id="event_course_subcategory"
										disabled="disabled">
									<option value="">-- SELECT --</option>
								</select>
                                <?= form_error('event_course_subcategory','<label for="event_course_category" generated="true" class="error">','</label>')?>
                            </span>
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
                                        echo '<input type="checkbox" class="tg" id="mainorg_' . $organizer_array[$i][0] . '" name="mainorg_' . $organizer_array[$i][0] . '" value="' . $organizer_array[$i][1] . '" /> &nbsp; ' . $organizer_array[$i][1];
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
                                        echo '<input type="checkbox" class="tg" id="implpartner_' . $organizer_array[$i][0] . '"  name="implpartner_' . $organizer_array[$i][0] . '" value="' . $organizer_array[$i][1] . '" /> &nbsp; ' . $organizer_array[$i][1];
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
						<td><label>Coverage level : </label></td>
						<td>
							<select name="coverage_level" id="event_level">
								<option value="">Select</option>
								<?php
								if (isset($coverage_level_array) && count($coverage_level_array) > 0) {
									for ($i = 0; $i < count($coverage_level_array); $i++) {
										echo '<option value="' . $coverage_level_array[$i][0] . '">' . $coverage_level_array[$i][1] . '</option>';
									}
								}
								?>
							</select>
                            <span style="width:20px;display:inline-block">
                                <img id="loading_image" style="margin-top: -10px; padding: 5px; display: none;"
									 src="../img/loading.gif">
                            </span>
						</td>
						<td style="width:50px"><span class="text-info"><b>&gt;&gt;</b></span></td>
						<td><label>Coverage location : </label></td>
						<td>
							<span class="text-error size11" id="mandatory_msg">*Select coverage level first</span>
							<span id="coverage_location_content"></span>
						</td>
					</tr>


                    <tr>
                        <td><label>District : </label></td>
                        <td>
                            <select name="district" id="district">
                            </select>
                            <?= form_error('district','<label for="district" generated="true" class="error">','</label>')?>

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
                            <?= form_error('vdc','<label for="vdc" generated="true" class="error">','</label>')?>

                        </td>
                    </tr>


                    <tr>
                        <td><label>Ward No : </label></td>
                        <td>
                            <span class="text-error size11" id="mandatory_msg-vdc">*Select vdc first</span>
                            <span id="select_ward_no_content"></span>
                            <?= form_error('ward_no','<label for="ward_no" generated="true" class="error">','</label>')?>

                        </td>
                        
                    </tr>

					<tr>
						<td><label>Venue : </label></td>
						<td>
							<input type="text" name="event_venue" placeholder="Enter venue"
                                   value="<?php echo set_value('event_venue') ?>"
                            />
                            <?= form_error('event_venue','<label for="event_venue" generated="true" class="error">','</label>')?>

                        </td>
						<td style="width:50px"></td>
						<td><label>Tole/Placename : </label></td>
						<td>
							<input type="text" name="event_address" placeholder="Enter address"
                                   value="<?php echo set_value('event_address') ?>"
                            />
                            <?= form_error('event_address','<label for="event_address" generated="true" class="error">','</label>')?>

                        </td>
					</tr>
					<tr>
						<td><label>Latitude : </label></td>
						<td><input type="number" name="latitude" placeholder="Enter Latitude"
                                   value="<?php echo set_value('latitude') ?>"
                            />
                            <?= form_error('latitude','<label for="latitude" generated="true" class="error">','</label>')?>

                        </td>
						<td style="width:50px"></td>
						<td><label>Longitude : </label></td>
						<td><input type="number" name="longitude" placeholder="Enter Longitude"
                                   value="<?php echo set_value('longitude') ?>"
                            />
                            <?= form_error('longitude','<label for="longitude" generated="true" class="error">','</label>')?>

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
							<button id="save_event_btn" class="btn btn-info">Save event</button>
							<input type="reset" class="btn" value="Reset"/>
						</td>
					</tr>
				</table>
				<?php echo form_close(); ?>
			</td>
		</tr>
	</table>
	<p class="text-info">
		<i> * The page will be redirected to participants page after saving this event.</i>
	</p>
</div> <!-- end of container tag-->




<script src="../leaflet/leaflet-src.js"></script>
<script src="../leaflet/search/dist/leaflet-search.min.js"></script>
<script src="../leaflet/control/geocoder/dist/Control.Geocoder.js"></script>


<script type="text/javascript">
    /*  $(document.body).on('click','#addnewvdc',function(){
     $( "#dialog" ).dialog();
     $('#location_code_text').val('');
     $('#location_text').val('');
     });
     */
    $(document.body).on('click', '#location_savebtn', function () {
      var location = $.trim($('#location_text').val());
      if (location == '') {
        alert('Location field is blank');
      } else {
        var location_code = $('#location_code_text').val();
        var level_id = $('#hidden_levelid_identifier').val();
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



    var new_event_marker;
    var map = new L.Map('map');
    var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var osmAttrib = 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
    var baseLayerOSM = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 15, attribution: osmAttrib});
    // start the map in South-East England
    map.setView(new L.LatLng(27.7, 86.2), 9);
    map.addLayer(baseLayerOSM);

    L.Control.geocoder().addTo(map);
    map.on('click', function (e) {
      createOrUpdateMarkerLatLng(e.latlng);
      syncLatlngFromMarker();
    });

    function createOrUpdateMarkerLatLng(latlng){
      if(typeof(new_event_marker)==='undefined')
      {


        new_event_marker = new L.marker(latlng,{ draggable: true});
        new_event_marker.addTo(map);
      }
      else
      {
        new_event_marker.setLatLng(latlng);
      }
    }
    function setMarkerLatLng(latlng){
      createOrUpdateMarkerLatLng(latlng);
    }
    function getMarkerLatLng(){
      return new_event_marker.latlng;
    }

    var $lat=$( "input[name='latitude']" );
    var $lng=$( "input[name='longitude']" );

    function syncLatlngToMarker(){
      var latVal=$lat.val();
      var lngVal=$lng.val();
      if(latVal.length>0 && lngVal.length>0)
      {
        setMarkerLatLng([latVal , lngVal]);
      }else{
        alert('empty');
      }
    }
    function syncLatlngFromMarker(){
      $lat.val(new_event_marker.getLatLng().lat);
      $lng.val(new_event_marker.getLatLng().lng);
    }

    $lat.on("change paste keyup", function() {
      if(typeof(new_event_marker)!='undefined')
      {
        var lat =$lat.val();
        var lng =new_event_marker.getLatLng().lng;
        var latlng ={"lat":lat,"lng":lng};
        new_event_marker.setLatLng(latlng);
        map.panTo(new L.LatLng(lat, lng));
      }

    });

    $lng.on("change paste keyup", function() {
      if(typeof(new_event_marker)!='undefined')
      {
        var lng =$lng.val();
        var lat =new_event_marker.getLatLng().lat;
        var latlng ={"lat":lat,"lng":lng};
        new_event_marker.setLatLng(latlng);
        map.panTo(new L.LatLng(lat, lng));
      }

    });

//
    data = [{iconclass: 'A', lat: 59.915, lon: 10.735}
      ,{iconclass: 'exclamation', lat: 59.9, lon: 10.7}
      ,{iconclass: 'BBL', lat: 59.9, lon: 10.75}
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
    data.forEach(function(row){
      var pos = new L.LatLng(row.lat,row.lon);
      var iconclass = iconclasses[row.iconclass]?row.iconclass:'';
      var iconstyle = iconclass?iconclasses[iconclass]:'';
      var icontext = iconclass?'':row.iconclass;

      var icon = L.divIcon({
        className: 'map-marker '+iconclass,
        iconSize:null,
        html:'<div class="icon" style="'+iconstyle+'">'+icontext+'</div><div class="arrow" />'
      });

      L.marker(pos).addTo(map); //reference marker
      L.marker(pos,{icon: icon}).addTo(map);
    });
  });

 
</script>