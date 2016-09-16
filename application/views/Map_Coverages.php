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
    .poly-label{
        background: none;
        border: none;
    }

</style>
<div class="site-index">
    <div id="map"></div>
</div>
<script src="../leaflet/label/leaflet.label.js"></script>
<script>
    jQuery(document).ready(function () {

    var map = new L.Map('map');
    // create the tile layer with correct attribution
    var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
    var baseLayerOSM = new L.TileLayer(osmUrl, {minZoom: 8, maxZoom: 15, attribution: osmAttrib});

    // start the map in South-East England
    map.setView(new L.LatLng(27.7, 86.2),9);
    map.addLayer(baseLayerOSM);

    //START [WFSLayer: 1] BaliyoGhar Program Districts' VDC and Municipalities Boundaries
    var owsrootUrl = 'http://localhost:8080/geoserver/nset_baliyo_ghar_demo/ows'//https://<GEOSERVER URL>/geoserver/ows';

    var defaultParameters = {
        service : 'WFS',
        version : '1.0.0',
        request : 'GetFeature',
        typeName : 'nset_baliyo_ghar_demo:poly_boundary_vdc_dhading_nuwakot_dolakha',//'<WORKSPACE:LAYERNAME>',
        outputFormat : 'text/javascript',
        format_options : 'callback:getJson',
        SrsName : 'EPSG:4326'
    };
    var parameters = L.Util.extend(defaultParameters);
    var URL = owsrootUrl + L.Util.getParamString(parameters);
    var wfsAreaVDCsDhadingNuwakotDolakha = null;
    var ajax = $.ajax({
        url : URL,
        dataType : 'jsonp',
        jsonpCallback : 'getJson',
        success : function (response) {
            wfsAreaVDCsDhadingNuwakotDolakha = L.geoJson(response, {
                style: function (feature) {
                    return {
                        weight: 2,
                        opacity: 1,
                        //color: 'black',
                        dashArray: '3',
                        fillOpacity: 0.4,
                        fillColor: '#23a325'
                    };
                },
                onEachFeature: function (feature, layer) {
                    popupOptions = {maxWidth: 200};
                    layer.bindPopup(feature.properties.vdc_name
                        ,popupOptions);

                    var lb =layer.getBounds().getCenter();
                    var label = L.marker(lb, {
                        icon: L.divIcon({
                            className: 'poly-label',
                            html: feature.properties.vdc_name,
                            iconSize: [100, 40]
                        })
                    }).addTo(map);
                }
            }).addTo(map);
        }
    });
    //END [WFS: 1]

    //START [WFS: 2] BaliyoGhar Program Districts' program VDC and Municipalities area
    var owsrootUrl = 'http://localhost:8080/geoserver/nset_baliyo_ghar_demo/ows'//https://<GEOSERVER URL>/geoserver/ows';

    var defaultParameters = {
        service : 'WFS',
        version : '1.0.0',
        request : 'GetFeature',
        typeName : 'nset_baliyo_ghar_demo:poly_vdc_dissolved_by_nset_resource_center_dhading_nuwakot_dolakha',//'<WORKSPACE:LAYERNAME>',
        outputFormat : 'text/javascript',
        format_options : 'callback:getJson',
        SrsName : 'EPSG:4326'
    };
    var parameters = L.Util.extend(defaultParameters);
    var URL = owsrootUrl + L.Util.getParamString(parameters);
    var wfsAreaVDCsBaliyoGharProgramAlls = null;
    var ajax = $.ajax({
        url : URL,
        dataType : 'jsonp',
        jsonpCallback : 'getJson',
        success : function (response) {
            wfsAreaVDCsBaliyoGharProgramAlls = L.geoJson(response, {
                style: function (feature) {
                    return {
                        weight: 2,
                        opacity: 1,
                        //color: 'black',
                        dashArray: '3',
                        fillOpacity: 0.4,
                        fillColor: 'red'
                    };
                },
                onEachFeature: function (feature, layer) {
                    popupOptions = {maxWidth: 200};
                    layer.bindPopup(feature.properties.vdc_name
                        ,popupOptions);
                }
            }).addTo(map);
        }
    });
    //END [WFS: 2]



    var wmsBoundaryNepalVDCs = L.tileLayer.wms("http://localhost:8080/geoserver/nset_baliyo_ghar_demo/wms", {
        layers: 'nset_baliyo_ghar_demo:line_boundary_vdc_nepal',
        format: 'image/png',
        transparent: true,
        version: '1.1.0',
        attribution: "NGIIP"
    }).addTo(map);



    //END [WFS: 3]

    //START [WFS: 4] BaliyoGhar Program LRTCs Local Reconstruction Technology Centers
    var owsrootUrl = 'http://localhost:8080/geoserver/nset_baliyo_ghar_demo/ows'//https://<GEOSERVER URL>/geoserver/ows';

    var defaultParameters = {
        service : 'WFS',
        version : '1.0.0',
        request : 'GetFeature',
        typeName : 'nset_baliyo_ghar_demo:drtc_staff',//'<WORKSPACE:LAYERNAME>',
        outputFormat : 'text/javascript',
        format_options : 'callback:getJson',
        SrsName : 'EPSG:4326'
    };
    var parameters = L.Util.extend(defaultParameters);
    var URL = owsrootUrl + L.Util.getParamString(parameters);
    var wfsPointDRTC = null;


    var ajax1 = $.ajax({
        url : URL,
        dataType : 'jsonp',
        jsonpCallback : 'getJson',
        success : function (response) {
            wfsPointDRTC = L.geoJson(response, {
                style: function (feature) {
                    return {
                        weight: 2,
                        opacity: 1,
                        //color: 'black',
                        dashArray: '3',
                        fillOpacity: 0.4,
                        fillColor: 'red'
                    };
                },
                onEachFeature: function (feature, layer) {
                    popupOptions = {maxWidth: 200};
                    vdc = feature.properties.vdc;
                    rtc_name =feature.properties.rtc_name;
                    console.log(feature.properties);
                    popuptxt='<h5>'+vdc+'<br>'+rtc_name+'</h5><br>';
                    if(feature.properties.staff_designation!=undefined){
                        sNamesObj=JSON.parse(feature.properties.staff_full_name);
                        sDesigObj=JSON.parse(feature.properties.staff_designation);
                        if(sNamesObj!=undefined){
                            for(var i=0;i<sNamesObj.length;i++){
                                popuptxt+=
                                    '<strong>' +sDesigObj[i]+'</strong> -> '+sNamesObj[i]+'<br>';
                            }
                        }
                    }



                    layer.bindPopup(popuptxt,popupOptions);
                }
            }).addTo(map);
        }
    });

    //END [WFS: 4]

    //START [WFS: 5] BaliyoGhar Program LRTCs Local Reconstruction Technology Centers
    /*
     var owsrootUrl2 = 'http://localhost:8080/geoserver/nset_baliyo_ghar_demo/ows'//https://<GEOSERVER URL>/geoserver/ows';

     var defaultParameters2 = {
     service : 'WFS',
     version : '1.0.0',
     request : 'GetFeature',
     typeName : 'nset_baliyo_ghar_demo:lrtc_staff',//'<WORKSPACE:LAYERNAME>',
     outputFormat : 'text/javascript',
     format_options : 'callback:getJson',
     SrsName : 'EPSG:4326'
     };
     var parameters2 = L.Util.extend(defaultParameters2);
     var URL2 = owsrootUrl2 + L.Util.getParamString(parameters2);
     var wfsPointLRTC2 = null;

     var ajax2 = $.ajax({
     url : URL,
     dataType : 'jsonp',
     jsonpCallback : 'getJson',
     success : function (response) {
     wfsPointLRTC = L.geoJson(response, {
     style: function (feature) {
     return {
     weight: 2,
     opacity: 1,
     //color: 'black',
     dashArray: '3',
     fillOpacity: 0.4,
     fillColor: 'red'
     };
     },
     onEachFeature: function (feature, layer) {

     popupOptions = {maxWidth: 200};
     vdc = feature.properties.vdc;
     rtc_name =feature.properties.rtc_name;

     var popuptxt='<h5>'+vdc+'<br>'+rtc_name+'</h5><br>';

     if(feature.properties.staff_designation!=undefined){
     sNamesObj=JSON.parse(feature.properties.staff_full_name);
     sDesigObj=JSON.parse(feature.properties.staff_designation);
     if(sNamesObj!=undefined){
     for(var i=0;i<sNamesObj.length;i++){
     popuptxt+=
     '<strong>' +sDesigObj[i]+'</strong> -> '+sNamesObj[i]+'<br>';
     }
     }
     }





     layer.bindPopup(popuptxt,popupOptions);
     }
     }).addTo(map);
     }
     });
     */
    //END [WFS: 5]

    });
</script>

<script src="../leaflet/leaflet-src.js"></script>