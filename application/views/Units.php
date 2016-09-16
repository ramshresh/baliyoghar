<style type="text/css">
    #main-organizer-block,#implementing-partner-block{
        width:200px;
        height:90px;
        overflow-y: scroll;
        padding:10px;
        border:1px solid #ccc;
        border-radius:5px;
    }
    h1,h2,h3,h4,h5,h6,form,table{margin:0px;}
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

<script type="text/javascript">
    /*  $(document.body).on('click','#addnewvdc',function(){
     $( "#dialog" ).dialog();
     $('#location_code_text').val('');
     $('#location_text').val('');
     });
     */
    $(document.body).on('click', '#location_savebtn', function() {
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
                error: function(xhr, status, error) {
                    alert('Error !\n Please try again.\n(Please check your internet connection.)');
                },
                success: function(msg) {
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

    $(document.body).on('click', '#location_cancelbtn', function() {
        $('.ui-dialog').remove(); //dismiss the popup
        // $('#dialog').html(''); // reset the form div of popup
    });
</script>
<!-- end script import -->

<script type="text/javascript">
    $(document).ready(function() {
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

    });
</script>
<div class="container">

</div> <!-- end of container tag-->



<div id="dialog" style="width:auto" title="" style="padding:10px;display:none">

</div>