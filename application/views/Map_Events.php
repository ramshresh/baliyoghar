<link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css'>
<link href="../leaflet/leaflet.css" rel="stylesheet">
<link href="../leaflet/label/leaflet.label.css" rel="stylesheet">
<style>
    #map {
        height: 500px;
        width: 100%;
        background-color: #FFFFFF;
        border: groove;
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
<div class="site-index">
    <div id="map"></div>
</div>
<script src="../leaflet/label/leaflet.label.js"></script>
<script>
    jQuery(document).ready(function () {

        var stringToColour = function(str) {
            if (typeof str != "undefined") {
                var hash = 0;
                for (var i = 0; i < str.length; i++) {
                    hash = str.charCodeAt(i) + ((hash << 5) - hash);
                }
                var colour = '#';
                for (var i = 0; i < 3; i++) {
                    var value = (hash >> (i * 8)) & 0xFF;
                    colour += ('00' + value.toString(16)).substr(-2);
                }
                return colour;
            }
            else {
                return '#ff0000';
            }

        }

    var map = new L.Map('map');
    // create the tile layer with correct attribution
    var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
    var baseLayerOSM = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 15, attribution: osmAttrib});

    // start the map in South-East England
    map.setView(new L.LatLng(27.7, 86.2),9);
    map.addLayer(baseLayerOSM);


        var rtcMarkerStyle = {
            radius: 5,
            fillColor: "#ffff00",
            color: "#000",
            weight: 1,
            opacity: 1,
            fillOpacity: 1
        };


        var eventsMarkerStyle = {
            radius: 20,
            fillColor: "#ff7800",
            color: "#000",
            weight: 1,
            opacity: 1,
            fillOpacity: 0.8
        };

        $.ajax({
            type: "POST",
            url: "getEventsGeojson",
            dataType: 'json',
            success: function (response) {
                events = L.geoJson(response, {
                    pointToLayer: function (feature, latlng) {
                        clr = '#00ffff';
                        if(feature.properties['course_name'] !=null){
                            console.log('defined');
                            console.log(feature.properties['course_name']);
                            clr =stringToColour(feature.properties['course_name']);
                        }


                        return L.circleMarker(latlng, {
                            radius: 5,
                            fillColor: clr,
                            color: "#000",
                            weight: 1,
                            opacity: 1,
                            fillOpacity: 1
                        });
                    },
                    onEachFeature: function (feature, layer) {
                        popupOptions = {maxWidth: 200};

                        popupTxt ="";
                        for(key in feature.properties){
                            value = feature.properties[key];
                            popupTxt +=key+': '+value+'<br>';
                        }
                        layer.bindPopup(popupTxt
                            ,popupOptions);
                    }
                }).addTo(map);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);

            }
        });

    var wmsBoundaryNepalVDCs = L.tileLayer.wms("http://localhost:8080/geoserver/nset_baliyo_ghar_demo/wms", {
        layers: 'nset_baliyo_ghar_demo:line_boundary_vdc_nepal',
        format: 'image/png',
        transparent: true,
        version: '1.1.0',
        attribution: "NGIIP"
    }).addTo(map);

    });
</script>

<script src="../leaflet/leaflet-src.js"></script>