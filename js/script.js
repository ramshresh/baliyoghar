/*
 * @author Gaurab
 */

$('document').ready(function () {

  var root = '../';

  //-------------------------------------------------------------------
  $('#course_btn_save').on('click', function () {

    var course_category = $('#course_category').val();
    if (course_category == '') {
      alert("Please select a course.");
      return false;
    }
    var course_subcategory = $('#course_subcategory').val();
    if ($.trim(course_subcategory) == '') {
      alert("Please enter subcourse.");
      return false;
    }
    $('#loading_image_subcourse').show();
    $.ajax({
      type: "POST",
      url: root + "Course/grabAndValidateSubCourseData_async",
      data: {
        course_category: course_category,
        course_subcategory: course_subcategory
      },
      cache: false,
      error: function (xhr, status, error) {
        alert('Error !\n Please try again.\n(Please check your internet connection.)');
      },
      success: function (msg) {
        $('#loading_image_subcourse').hide();
        $('#course_subcategory').val('');
        if ($.trim(msg) == "yes") {
          var date = new Date();
          var hour = date.getHours();
          var minute = date.getMinutes();
          var am = "AM";
          if (hour > 12) {
            hour = hour - 12;
            am = "PM";
          }
          var html = '<span class="text-info size11"> &gt; Subcategory (<span class="text-success size11"><b>' + course_subcategory + '</b></span>) added under category <span class="text-success"><b>' + $('#course_category>option:selected').text() + '</b></span> at (' + hour + ':' + minute + ' ' + am + ')</span><br />';
          $('#course_div_progress').show();
          $('#course_div_progress').append(html);
        } else {
          alert("Sorry ! Your query failed. ");
        }
      }
    });
    // $("#dropdownindex").val($("#course_category").prop("selectedIndex"));
  });

  $('#eventPageno').on('change', function () {
    var selected_page = $(this).val();
    var search_string = $.trim($('#event_search_txt').val());
    window.location.replace(root + "Event/event_pagination?page=" + selected_page + "&search_string=" + search_string);
  });
  $('#personPageno').on('change', function () {
    var selected_page = $(this).val();
    var search_string = $.trim($('#person_search_txt').val());
    window.location.replace(root + "Person/person_pagination?page=" + selected_page + "&search_string=" + search_string);
  });

  $('#course_btn_cancel').click(function () {
    $("#hiddenspan_add_new_category").hide();
    $("#hiddenspan_existing_category").show();
    $("#loading_image").hide();
    $('#course_txt_add_new').val('');
  });
  $("#course_btn_add_new").click(function () {
    $("#hiddenspan_existing_category").hide();
    $("#hiddenspan_add_new_category").show();
    $("#course_btn_add").show();
  });

  $(document.body).on('click', 'a[id^=alphabet_]', function () {
    var id = $(this).attr('id');
    var array = id.split("_");
    search_person(array[1], "alphabet");
  });

  $("#course_btn_add").on('click', function () {
    var course_name = $('#course_txt_add_new').val();
    //if($.trim(course_name)!= '')
    if ($.trim(course_name) != "") {
      $("#loading_image").show();
      $("#course_btn_add").hide();
      $.ajax({
        type: "POST",
        url: root + "Course/grabCourseData_async",
        data: {
          course_name: course_name
        },
        cache: false,
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
          $("#loading_image").hide();
          $('#course_txt_add_new').val('');
        },
        success: function (msg) {
          // alert(msg);
          $("#loading_image").hide();
          if (msg == "no") {
            alert("Insertion failed");
            $('#course_txt_add_new').val('');
          }
          else {
            var obj = jQuery.parseJSON(msg);
            var content = '<select name="course_category" id="course_category"><option value="">-- SELECT --</option>';
            for (i  in obj) {
              content += '<option value="' + obj[i].course_cat_id + '">' + obj[i].coursename + '</option>';
              // alert(obj[i].coursename);
            }
            content += '</select>';
            //alert("yessss");
            $("#hiddenspan_category").html(content);
            $("#hiddenspan_add_new_category").hide();
            $("#hiddenspan_existing_category").show();
            $('#course_txt_add_new').val('');

            var date = new Date();
            var hour = date.getHours();
            var minute = date.getMinutes();
            var am = "AM";
            if (hour > 12) {
              hour = hour - 12;
              am = "PM";
            }
            var html = '<span class="text-info size11"> &gt; New category (<span class="text-success"><b>' + course_name + '</b></span>) added at (' + hour + ':' + minute + ' ' + am + ')</span><br />';
            $('#course_div_progress').show();
            $('#course_div_progress').append(html);
          }
        }
      });
    }
    else {
      alert('Please enter course name.')
    }
  });
  //--------------------EVENT--------------------
  var event_course_buttonclick_counter = 0;
  $('#event_course_category').on('change', function () {
    $("#loading_image").show();
    var course_id = $('#event_course_category').val();
    if (course_id == '') {
      $("#loading_image").hide();
      $("#event_course_subcategory").prop("disabled", true);
    } else {
      //-----------------------------------------
      $.ajax({
        type: "POST",
        url: root + "Event/grabSubCourseData_async",
        data: {
          course_cat_id: course_id
        },
        cache: false,
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
          $("#loading_image").hide();
        },
        success: function (msg) {
          $("#loading_image").hide();

          var obj = jQuery.parseJSON(msg);
          var datasize = Object.size(obj);
          if (datasize > 0) {
            var content = '<select name="event_course_subcategory" id="event_course_subcategory" ><option value="">-- SELECT --</option>';
            for (i  in obj) {
              content += '<option value="' + obj[i].course_subcat_id + '">' + obj[i].subcoursename + '</option>';
            }
            content += '</select>';
            $("#getSubCourse").html(content);
          }
          else {
            $("#event_course_subcategory").prop("disabled", true);
          }

        }
      });
    }
  });

  $(document.body).on('change', '#event_level', function () {
    $("#loading_image1").show();
    var coverage_level = $.trim($('#event_level>option:selected').text());
    var coverage_level_id = $.trim($('#event_level>option:selected').val());
    //alert(coverage_level.toUpperCase());
    if (coverage_level_id == '') {
      $("#loading_image1").hide();
      $('#mandatory_msg').show();
      $('#coverage_location_content').empty();
    } else {

      //-----------------------------------------
      $.ajax({
        type: "POST",
        url: root + "Event/getCoverageLocation",
        data: {
          coverage_level: coverage_level_id
        },
        cache: false,
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
          $("#loading_image1").hide();
        },
        success: function (msg) {
          $("#loading_image1").hide();
          if (coverage_level.toUpperCase() == 'MUNICIPALITY') {
            $('#mandatory_msg').hide();
            var data = $.trim(msg);
            var municipality = jQuery.parseJSON(data);
            var datasize = Object.size(municipality);
            var content = '';
            if (datasize > 0) {
              var string = '<select name="coverage_location" id="coverage_location">';
              for (i  in municipality) {
                string += '<option value="' + municipality[i].coverage_location + '">' + municipality[i].coverage_location + '</option>';
              }
              string += '</select>';

              $('#coverage_location_content').html(string);

            }
          }
          else if (coverage_level.toUpperCase() == 'REGION') {
            $('#mandatory_msg').hide();
            var data = $.trim(msg);
            var region = jQuery.parseJSON(data);
            var datasize = Object.size(region);
            var content = '';
            if (datasize > 0) {
              var string = '<select name="coverage_location" id="coverage_location">';
              for (i  in region) {
                string += '<option value="' + region[i].coverage_location + '">' + region[i].coverage_location + '</option>';
              }
              string += '</select>';
              // alert(string);
              $('#coverage_location_content').html(string);
            }
            //-------------------------
            $('#mandatory_msg').hide();
            //  $('#coverage_location_content').html('<input type="text" placeholder="Enter region.." name="coverage_location" id="coverage_location" />');
          }
          else if (coverage_level.toUpperCase() == 'VDC') {
            //alert('vdc');
            $('#mandatory_msg').hide();
            // $('#coverage_location_content').html('<input type="text" placeholder="Enter vdc.." name="coverage_location" id="coverage_location" />');

            var data = $.trim(msg);
            var vdc = jQuery.parseJSON(data);
            var datasize = Object.size(vdc);
            var content = '';
            var string = '<select name="coverage_location" id="coverage_location">';

            if (datasize > 0) {

              for (i  in vdc) {
                string += '<option value="' + vdc[i].coverage_location + '">' + vdc[i].coverage_location + '</option>';
              }
            } else {

            }
            string += '</select>';
            string += '&nbsp;<img src="../img/add-new.png" title="Add new VDC" id="addnewvdc" />';
            // $('#mandatory_msg').hide();
            $('#coverage_location_content').html(string);

            //getPopUpTable(id1,id2,location,identifier)
            //this function can be overloaded in future to extend the same functionality for municipality and district
            //
            //
            // var string1 = getPopUpTable('vdc',coverage_level_id);
            //
            //
            //if new option to be added show in popup
            //$('#dialog').html(string1);
            //set title of popup window div
            //$('#dialog').prop('title','Add new vdc');


          }
          else if (coverage_level.toUpperCase() == 'DISTRICT') {
            var data = $.trim(msg);
            var district = jQuery.parseJSON(data);
            var datasize = Object.size(district);
            var content = '';
            if (datasize > 0) {
              var string = '<select name="coverage_location" id="coverage_location">';
              for (i  in district) {
                string += '<option value="' + district[i].coverage_location + '">' + district[i].coverage_location + '</option>';
              }
              string += '</select>';
              $('#mandatory_msg').hide();
              $('#coverage_location_content').html(string);

            }
          }
          else if (coverage_level.toUpperCase() == 'NATIONAL') {
            //national
            $('#mandatory_msg').hide();
            $('#coverage_location_content').html('<span class="text-success">NATIONAL</span>');
          } else {
            $('#mandatory_msg').hide();
            $('#coverage_location_content').html('<input type="text" placeholder="Enter location.." name="coverage_location" id="coverage_location" />');
          }
        }

      });
    }
  });

  $(document.body).on('click', '#addnewvdc', function () {
    var string1 = getPopUpTable('vdc', $('#event_level').val());
    $('#dialog').html(string1);
    //set title of popup window div
    $('#dialog').prop('title', 'Add new vdc');
    $("#dialog").dialog();
    $('#location_code_text').val('');
    $('#location_text').val('');
  });
  $(document.body).on('click', 'a[id^=candidate_cross_]', function () {
    var id = $(this).attr('id');
    var array = id.split("_");
    var eventId = $("#event_eventId").val();
    $.ajax({
      type: "POST",
      url: root + "Event/deleteCandidate_async",
      data: {
        person_id: array[2],
        event_id: eventId
      },
      error: function (xhr, status, error) {
        alert('Error !\n Please try again.\n(Please check your internet connection.)');
      },
      success: function (msg) {
        if (msg == "yes") {
          $(".participants_" + array[2]).remove();
          $('#instructorCheck_' + array[2]).attr('checked', false);
          $('#personCheck_' + array[2]).attr('checked', false);
          $("#detail_" + array[2]).removeClass('instructor');
          $('#instructorSpan_' + array[2]).hide();
        }
        else {
          alert("couldn't delete");
        }
      }
    }); //end ajax
  });
  //editing subcourses - ajax
  $(document.body).on('click', 'button[id^=subcourse_btnedit_]', function () {
    var id = $(this).attr('id');
    var array = id.split("_");
    var subcourse_id = array[2];
    var new_subcourse = $("#subcourse_txt_" + array[2]).val();
    $('#editcourse_img_' + array[2]).show();
    $.ajax({
      type: "POST",
      url: root + "Course/editSubcourse_async",
      data: {
        subcourse_id: subcourse_id,
        new_subcourse: new_subcourse
      },
      error: function (xhr, status, error) {
        alert('Error !\n Please try again.\n(Please check your internet connection.)');
      },
      success: function (msg) {
        if ($.trim(msg) == 'yes') {
          $('#editcourse_img_' + array[2]).hide();
          alert('value updated');
        } else {
          $('#editcourse_img_' + array[2]).hide();
          alert('update failed');
        }
      }
    }); //end ajax
  });
  //deleting subcourses - ajax
  $(document.body).on('click', 'button[id^=subcourse_btndelete_]', function () {
    var id = $(this).attr('id');
    var array = id.split("_");
    var subcourse_id = array[2];
    //var new_subcourse = $("#subcourse_txt_"+array[2]).val();
    $('#editcourse_img_' + array[2]).show();
    $.ajax({
      type: "POST",
      url: root + "Course/deleteSubcourse_async",
      data: {
        subcourse_id: subcourse_id
      },
      error: function (xhr, status, error) {
        alert('Error !\n Please try again.\n(Please check your internet connection.)');
      },
      success: function (msg) {
        if ($.trim(msg) == 'yes') {
          $('#subcourse_span_' + array[2]).remove();
          $('#editcourse_img_' + array[2]).hide();
          alert('record deleted');
        } else if ($.trim(msg) == 'associated') {
          $('#editcourse_img_' + array[2]).hide();
          dismiss(5000);
        } else {
          $('#editcourse_img_' + array[2]).hide();
          alert('deletion failed');
        }
      }
    }); //end ajax

  });

  // $('input[id^=instructorCheck_]').on('click', function(){
  $(document.body).on('click', 'input[id^=instructorCheck_]', function () {
    var id = $(this).attr('id');
    var array = id.split("_");
    $("#instructorCheck_" + array[1]).prop("disabled", true);
    $("#loadingImage_" + array[1]).show();
    var eventId = $("#event_eventId").val();
    $.ajax({
      type: "POST",
      url: root + "Event/addInstructor_async",
      data: {
        person_id: array[1],
        event_id: eventId
      },
      error: function (xhr, status, error) {
        alert('Error !\n Please try again.\n(Please check your internet connection.)');
        $("#instructorCheck_" + array[1]).prop("disabled", false);
        $("#loadingImage_" + array[1]).hide();
      },
      success: function (msg) {
        if (msg == "yes") {
          $("#detail_" + array[1]).prop('class', 'instructor');
          $('#instructorCheck_' + array[1]).attr('checked', true);
          $(".participants_" + array[1]).addClass('greenBg');
          //  var appendstring='<p class="participants_'+array[1]+' greenBg">'+$('#name_'+array[1]).val()+'<a href="#" id="candidate_cross_'+array[1]+'"></a></p>';
          //  $('#selected_candidates').append(appendstring);

        }
        if (msg == "no") {
          $('#instructorCheck_' + array[1]).attr('checked', false);
          $("#detail_" + array[1]).removeClass('instructor');
          $(".participants_" + array[1]).removeClass('greenBg');
        }
        $("#instructorCheck_" + array[1]).prop("disabled", false);
        $("#loadingImage_" + array[1]).hide();
      }
    }); //end ajax

  });
  //-----------------------------------add candidates-------------------------------

  $(document.body).on('click', 'input[id^=personCheck_]', function () {
    var id = $(this).attr('id');
    var array = id.split("_");
    $("#personCheck_" + array[1]).prop("disabled", true);
    $("#loadingImage_" + array[1]).show();
    var eventId = $("#event_eventId").val();
    $.ajax({
      type: "POST",
      url: root + "Event/addCandidate_async",
      data: {
        person_id: array[1],
        event_id: eventId
      },
      error: function (xhr, status, error) {
        alert('Error !\n Please try again.\n(Please check your internet connection.)');
      },
      success: function (msg) {
        if (msg == "yes") {
          // $("#detail_"+array[1]).prop('class','instructor');
          $('#personCheck_' + array[1]).attr('checked', true);
          var appendstring = '<p class="participants_' + array[1] + '">' + $('#name_' + array[1]).val() + '<a href="#" id="candidate_cross_' + array[1] + '"></a></p>';
          $('#selected_candidates').append(appendstring);
          if ($('#personCheck_' + array[1]).prop('checked')) {
            $('#instructorSpan_' + array[1]).show();
          }
        }
        if (msg == "no") {
          $('#personCheck_' + array[1]).attr('checked', false);
          $('.participants_' + array[1]).remove();
          $("#detail_" + array[1]).removeClass('instructor');
          if ($('#personCheck_' + array[1]).prop('checked')) {
          }
          else {
            $('#instructorSpan_' + array[1]).hide();
            $('#instructorCheck_' + array[1]).attr('checked', false);
          }

        }
        $("#personCheck_" + array[1]).prop("disabled", false);
        $("#loadingImage_" + array[1]).hide();
      }
    }); //end ajax

  });
  //---------------------------person searching---------------------------//
  $('#person_search_btn').on('click', function () {
    var string = $.trim($('#person_search_txt').val());
    search_person(string, "search");
  });

  function search_person(string, identifier) {

    $('#person_loading_message').show();

    $.ajax({
      type: "POST",
      url: root + "Event/search_person_async",
      data: {
        search_string: string,
        identifier: identifier
      },
      error: function (xhr, status, error) {
        alert('Error !\n Please try again.\n(Please check your internet connection.)');
      },
      success: function (msg) {
        var person_data = jQuery.parseJSON(msg);
        var datasize = Object.size(person_data);
        if (datasize > 0) {
          var string = "";
          var COLUMN = 3;
          var columncount = 0;

          for (k  in person_data) {
            if (columncount == 0) {
              string += "<tr>";
            }
            columncount++;
            var check1 = '';
            var check2 = '';
            var style = 'style="display:none"';
            var instructor = '';
            //---------------------------------------------------------------------
            $('#selected_candidates p[class^=participants_]').each(function () {

              var span = $(this);
              if (span.attr('class').toLowerCase().indexOf("participants_" + person_data[k].person_id) >= 0) {
                check1 = 'checked="checked"';
                style = '';
                if (span.hasClass("greenBg")) {
                  check1 = 'checked="checked"';
                  check2 = 'checked="checked"';
                  instructor = "instructor";

                } else {
                }

              } else {
              }
            });
            //---------------------------------------------------------------------

            string += "<td id='detail_" + person_data[k].person_id + "'  class='" + instructor + "'>";
            string += "<input type='hidden' id='name_" + person_data[k].person_id + "' value='" + person_data[k].fullname + "' />";
            string += "<strong>" + person_data[k].title + " " + person_data[k].fullname + "</strong>";
            string += "<br />" + person_data[k].mobile + "<br /> " + person_data[k].email;
            string += '<div class="addParticipants_person_table_div" >';
            string += '<span class="btn"><input type="checkbox" ' + check1 + ' id="personCheck_' + person_data[k].person_id + '"/>';
            string += '<label style="display:inline" for="personCheck_' + person_data[k].person_id + '">';
            string += '<p style="display:inline" class="text-info">select</p>';
            string += ' </label>';
            string += ' </span>';

            string += ' <span style="width:150px;height:27px;display:inline-block">&nbsp;';
            string += '  <span class="btn" ' + style + ' id="instructorSpan_' + person_data[k].person_id + '"><input type="checkbox" ' + check2 + ' id="instructorCheck_' + person_data[k].person_id + '"/>';
            string += '<label style="display:inline" for="instructorCheck_' + person_data[k].person_id + '">';
            string += '<p style="display:inline" class="text-success">Instructor?</p>';
            string += '</label>';
            string += '</span>';
            string += '</span>';
            string += '<span style="width:50px;height:27px;display:inline-block">';
            string += '&nbsp;';
            string += '<img src ="../../img/loading.gif" id="loadingImage_' + person_data[k].person_id + '" style="display:none" />';
            string += '</span>';
            string += '</div>';
            string += "</td>";


            if (columncount == COLUMN) {
              string += "</tr>";
              columncount = 0;
            }

          }


        } else {
          string = "<tr><td><center><p class='text-error'><b> No data matches your search query: 0 results </b></p></center></td></tr>";
        }
        $('#addParticipants_person_table').html(string);
        $('#person_loading_message').hide();
      }
    }); //end ajax

  }


  Object.size = function (obj) {
    var size = 0, key;
    for (key in obj) {
      if (obj.hasOwnProperty(key)) size++;
    }
    return size;
  };

  $(document.body).on('click', '#csparty_btn', function () {
    var party = $.trim($('#addcsparty_txt').val());
    if (party == '') {
      alert('Field shouln\'t be blank');
      return false;
    } else {
      $('#csparty_img').show();
      $.ajax({
        type: "POST",
        url: root + "Home/addParty",
        data: {
          party: party
        },
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
          $('#csparty_img').hide();
          $('#addcsparty_txt').val('');
        },
        success: function (msg) {
          $('#csparty_img').hide();
          msg = $.trim(msg);
          if ($.trim(msg) != '0') {
            var string = '<tr id="csparty-row_' + msg + '">';
            string += '<td align = "center">' + $('#hidden-party-counter').val() + '</td>';
            string += '<td align = "left" ><span id="csparty-inputspan_' + msg + '" >' + party + '</span>';
            string += '<input type="text" style="margin:0;width:200px;height:15px;font:11px arial,verdana;display:none" id="csparty-hiddentxt_' + msg + '" value="' + party + '" >';
            string += '   </td>';
            string += '<td align="left"><span id="csparty-editspan_' + msg + '" >';
            string += ' <a class="handcursor" id="csparty-edit_' + $('#hidden-party-counter').val() + '_' + msg + '">edit</a>';
            string += ' &nbsp;&nbsp;&nbsp;</span>';

            string += '<span style="display:none" id="csparty-updatespan_' + msg + '" >';
            string += ' <a class="text-success handcursor" id="csparty-save_' + msg + '">save</a>';
            string += ' &nbsp; <a  class="text-warning handcursor" id="csparty-cancel_' + msg + '">cancel</a>';
            string += ' &nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;';
            string += ' </span>';

            string += '<a class="text-error handcursor" id="csparty-delete_' + msg + '" >delete</a></td>';
            string += '</tr>';

            $('#hidden-party-counter').val(parseInt($('#hidden-party-counter').val(), 10) + 1);
            $('#csparty_table').append(string);
            $('#addcsparty_txt').val('');
          } else {
            alert('Sorry, insertion failed');
            $('#addcsparty_txt').val('');
          }

        }
      });
    }
  });
  $(document.body).on('click', 'a[id^=csparty-edit_]', function () {
    var id = $(this).attr('id');
    var array = id.split("_");
    $('#csparty-inputspan_' + array[2]).hide();
    $('#csparty-hiddentxt_' + array[2]).show();

    $('#csparty-editspan_' + array[2]).hide();
    $('#csparty-updatespan_' + array[2]).show();

  });
  $(document.body).on('click', 'a[id^=csparty-cancel_]', function () {
    var id = $(this).attr('id');
    var array = id.split("_");
    $('#csparty-inputspan_' + array[1]).show();
    $('#csparty-hiddentxt_' + array[1]).hide();

    $('#csparty-editspan_' + array[1]).show();
    $('#csparty-updatespan_' + array[1]).hide();

  });
  $(document.body).on('click', 'a[id^=csparty-delete_]', function () {
    var confirmation = confirm('Are you sure want to continue?\n If other data are dependent on this data the action will be cancelled.');
    if (confirmation == true) {
      $('#csaction_img').show();
      var id = $(this).attr('id');
      var array = id.split("_");
      $.ajax({
        type: "POST",
        url: root + "Home/deleteParty",
        data: {
          id: array[1]
        },
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
          $('#csaction_img').hide();
        },
        success: function (msg) {
          $('#csaction_img').hide();
          if ($.trim(msg) == 1) {
            $('#csparty-row_' + array[1]).remove();
          } else if ($.trim(msg) == 'associated') {
            dismiss(5000);
          } else {
            alert('Sorry, the action failed.');
          }
        }
      });
    }
  });
  $(document.body).on('click', 'a[id^=csparty-save_]', function () {
    var id = $(this).attr('id');
    var array = id.split("_");
    var party_name = $.trim($('#csparty-hiddentxt_' + array[1]).val());
    if (party_name == '') {
      alert('Field is blank');
      return false;
    }
    else {
      $('#csaction_img').show();
      $.ajax({
        type: "POST",
        url: root + "Home/editParty",
        data: {
          id: array[1],
          party: party_name
        },
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
          $('#csaction_img').hide();
        },
        success: function (msg) {
          $('#csaction_img').hide();
          if ($.trim(msg) == 1) {
            $('#csparty-inputspan_' + array[1]).text(party_name);
            //repeat action similarr to that of clicking cancel button
            $('#csparty-inputspan_' + array[1]).show();
            $('#csparty-hiddentxt_' + array[1]).hide();

            $('#csparty-editspan_' + array[1]).show();
            $('#csparty-updatespan_' + array[1]).hide();
          } else {
            alert('Sorry, the action failed.');
          }
        }
      });
    }
  });
  //--------------------------------------ADD person to event ajax --------------------------//

  /*
   * checking the availability of person before adding as participants in the event
   */
  $(document.body).on('click', '#person_availability_btn', function () {

    var fullname = $.trim($('#person_name').val());
    var dob_en = $.trim($('#person_dob_en').val());
    var dob_np = $.trim($('#person_dob_np').val());
    var age = $.trim($('#person_age').val());

    //replace / in nepali date with - , to search in mysql database
    var dob_np1 = $('#person_dob_np').val().replace(/\//g, '-');
    var mobile = $.trim($('#person_mobile').val());
    var phone = $.trim($('#person_phone').val());
    var citizenship_no = $.trim($('#person_citizenship_no').val());

    if ($.trim(fullname) == '' && $.trim(citizenship_no) == '') {
      alert('Please Provide Full Name Or Citizenship No  ');
      $('#person_tablebody').hide();
      return false;
    }

    if ($.trim(age) == '' && $.trim(dob_en) == '' && $.trim(dob_np) == '') {
      alert('Please fill in Birthdate or Age  ');
      $('#person_tablebody').hide();
      return false;
    }
    /*if($.trim(fullname)=='')
     {

     alert("Please enter required field");
     $('#person_tablebody').hide();
     return false;
     }*/


    $.ajax({
      type: "POST",
      url: root + "Event/person_exists",
      data: {
        fullname: fullname,
        dob_en: dob_en,
        dob_np: dob_np1,
        mobile: mobile,
        phone: phone,
        citizenship_no: citizenship_no
      },
      error: function (xhr, status, error) {
        alert('Error !\n Please try again.\n(Please check your internet connection.)');
      },
      success: function (msg) {
        $('#participants_search_result').html('');
        if ($.trim(msg) == 'no') {
          $('#person_tablebody').show();
        }
        //  $('#add_new_person_btn').prop("disabled",false);
        else {
          $('#person_tablebody').hide();
          //  $('#add_new_person_btn').prop("disabled",true);
          var data = $.trim(msg);
          var person = jQuery.parseJSON(data);
          var datasize = Object.size(person);
          var content = '';

          if (datasize < 1) {
            $('#person_tablebody').show();
            $('#participants_results').hide();
            return false;
          }

          if (datasize == 1) {
            /*//hide the instructor selection box
             $('#instructor_selection').hide();
             //disable the button so that that same data don't get inserted
             //  $('#add_new_person_btn').prop("disabled",true);
             //show the note about how to enable the save button and show chekboxes
             $('#participant_note').show();
             //fill the form with fetched data
             for(i  in person){
             $('#person_name').val(person[i].fullname);
             $('#person_dob_en').val(person[i].dob_en);
             $('#person_dob_np').val(person[i].dob_np.replace(/\-/g, '/'));
             $('#person_mobile').val(person[i].mobile);
             $('#person_image').html('<img src="../gallery/thumbs/'+person[i].photo+'" />');
             $('#person_paddress').val(person[i].p_address);
             $('#person_caddress').val(person[i].c_address);
             $('#person_phone').val(person[i].phone);
             $('#person_email').val(person[i].email);
             $('#person_org_name').val(person[i].org_name);
             $('#person_org_address').val(person[i].org_address);
             $('#person_org_phone').val(person[i].org_phone);
             $('#person_org_fax').val(person[i].org_fax);
             $('#person_position').val(person[i].position);

             $('#person_title').val(person[i].title);
             $('#person_gender').val(person[i].gender);
             $('#person_country').val(person[i].country);
             $('#person_current_status').val(person[i].current_status);
             $('#person_citizenship_no').val(person[i].citizenship_no);

             }*/
          } else {
            //hide the note about how to enable the save button and show chekboxes
            $('#participant_note').hide();
            //show the instructor selection box
            $('#instructor_selection').show();
            //reset the form
            $('#people_entry_form')[0].reset();
            //remove the image form upper table where sure match was found previously
            $('#person_image').html('');
            //show the search result table first,
            $('#participants_results').show();
            //enable the submit button
            //  $('#add_new_person_btn').prop("disabled",false);
          }

          if (datasize >= 1) {
            $('#participants_results').show();
            //person = jQuery.parseJSON(data);
            var string = '<tr>' +
              '<th width="5%" align="center">#</th>' +
              '<th width="7%" align="left">Image</th>' +
              '<th width="15%" align="left">Name</th>' +
              '<th width="15%" align="left">Citizenship No</th>' +
              '<th width="15%" align="left">Address</th>' +
              '<th width="8%" align="left">Mobile</th>' +
              '<th width="13%" align="left">Email</th>' +
              '<th width="13%" align="left">Org name</th>' +
              '<th width="12%" align="left">Position</th>' +
              '<th width="12%" align="left">Select  <img class="inline-block" src="../img/loading.gif" id="addparticipants_loading" style="margin-right:30px;float:right;display:none;" /></th>' +
              '</tr>';

            for (i  in person) {
              string += '<tr>';
              string += '<td align="center" valign="top" >' + (parseInt(i) + 1) + '</td>';
              string += '<td align="left" valign="top"><img  src="../gallery/thumbs/' + person[i].photo + '" /></td>';
              string += '<td align="left" valign="top">' + person[i].title + " " + person[i].fullname + '</td>';
              string += '<td align="left" valign="top">' + person[i].citizenship_no + '</td>';
              string += '<td align="left" valign="top">' + person[i].c_address + '</td>';
              string += '<td align="left" valign="top">' + person[i].mobile + '</td>';
              string += '<td align="left" valign="top">' + person[i].email + '</td>';
              string += '<td align="left" valign="top">' + person[i].org_name + '</td>';
              string += '<td align="left" valign="top">' + person[i].position + '</td>';
              string += '<td align="left" valign="top">';
              string += '<input type="checkbox" value="0" class ="person_participant0_' + person[i].person_id + '"  /> &nbsp;Participant';
              string += '<br /><input type="checkbox" value="1" class ="person_participant1_' + person[i].person_id + '"  /> &nbsp;Instructor';
              string += '<br /><input type="checkbox" value="2" class="person_participant2_' + person[i].person_id + '"  /> &nbsp;Asst. instructor';
              string += '<br /><br /><p class="text-error" id="delete_participant_' + person[i].person_id + '"></p>';
              string += '</td>';
              string += '</tr>';

            }
            $('#participants_search_result').append(string);
          } else {
            /*  // $('#add_new_person_btn').prop("disabled",false);
             //reset the form if filled by any previous search data
             $('#people_entry_form')[0].reset();
             //again fillup the primary search data into the form
             $('#person_name').val(fullname);
             $('#person_dob_np').val(dob_np);
             $('#person_dob_en').val(dob_en);
             $('#person_mobile').val(mobile);
             //remove the image form upper table where sure match was found previously
             $('#person_image').html('');
             //hide the search result table first,
             $('#participants_results').show();
             //make the table of search result blank
             $('#participants_search_result').html('<tr><td>No match found : 0 result</td></tr>')*/
          }
        }
      }
    });
  });

  $(document.body).on('click', '#person_reset', function () {
    //hide the note about how to enable the save button and show chekboxes
    $('#participant_note').hide();
    //show the instructor selection box
    $('#instructor_selection').show();
    //remove the image form upper table where sure match was found previously
    $('#person_image').html('');
    //show the search result table first,
    $('#participants_results').show();
    //enable the submit button
    $('#add_new_person_btn').prop("disabled", false);
  });

  $('#person_close').click(function () {
    //hide the search result table ,
    $('#participants_results').hide();
  });
  /*These events - from add person page.. to select as instructor or sub instructor*/
  //now no use
  /*  $('#person_asstinst').on('click',function(){
   if($('#person_asstinst').is(':checked')){
   $('#person_inst').attr('checked',false);
   }
   });
   $('#person_inst').on('click',function(){
   if($('#person_inst').is(':checked')){
   $('#person_asstinst').attr('checked',false);
   }
   });
   */
  /* clicked on checkboxes to select or unselect participants .. in add person page*/
  $(document.body).on('click', 'input[class^=person_participant]', function () {
    var event_id = $('#event_id').val();
    var id = $(this).attr('class');
    var array = id.split("_");
    var person_id = array[2];
    var participant_value = parseInt($(this).val());
    var path = '';
    if ($('.person_participant' + participant_value + '_' + person_id).is(':checked')) {
      path = root + "Event/addInstructor_async";
    } else {
      path = root + "Event/deleteCandidate_async";
    }
    var flag = 0;

    switch (participant_value) {
      case 0:
        $('.person_participant1_' + person_id).attr('checked', false);
        $('.person_participant2_' + person_id).attr('checked', false);
        break;
      case 1:
        $('.person_participant0_' + person_id).attr('checked', false);
        $('.person_participant2_' + person_id).attr('checked', false);
        break;
      case 2:
        $('.person_participant1_' + person_id).attr('checked', false);
        $('.person_participant0_' + person_id).attr('checked', false);
        break;
      default:
        flag = 1;
        break;
    }
    if (flag == 0) {
      //proceed with the ajax request
      $('#addparticipants_loading').show();
      $.ajax({
        type: "POST",
        url: path,
        data: {
          person_id: person_id,
          event_id: event_id,
          event_inst: participant_value
        },
        cache: false,
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
        },
        success: function (msg) {
          $('#addparticipants_loading').hide();
          if ($.trim(msg) == 'no') {
            alert('Action failed.\nPlease try again after some time or refresh the page.');
          }
        }
      });
    } else {
      alert('Oops, something went wrong! \n Please contact your administrator.')
    }
  });

  /* clicked on  unselect link to remove participants .. in event detail page*/
  $(document.body).on('click', 'a[id^=removecandidate_]', function () {

    var yes = confirm('Are you sure ?');
    if (yes == true) {
      var id = $(this).attr('id');
      var array = id.split("_");
      var person_id = array[1];
      var event_id = $('#event_id').val();
      var path = root + "Event/deleteCandidate_async";
      $.ajax({
        type: "POST",
        url: path,
        data: {
          person_id: person_id,
          event_id: event_id
        },
        cache: false,
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
        },
        success: function (msg) {
          if ($.trim(msg) == 'no') {
            alert('Action failed.\nPlease try again after some time or refresh the page.');
          } else {
            $('#participant_row_' + person_id).remove();
          }
        }
      });
    }
  });

  //EventDetail.php
  var dlg = $("#editCandidateForm"); // Get the dialog container.
// Get the window dimensions.
  var width = $(window).width();
  var height = $(window).height();

// Provide some space between the window edges.
  width = width - 50;
  height = height - 150; // iframe height will need to be even less to account for space taken up by dialog title bar, buttons, etc.

// Set the iframe height.
  $(dlg.children("iframe").get(0)).css("height", height + "px");

  dlg.dialog({
    autoOpen: false,
    modal: true,
    height: 300, // Set the height to auto so that it grows along with the iframe.
    width: 600,
    create: function (event, ui) {
      $(this).siblings('div.ui-dialog-titlebar').remove();
    },
    buttons: {
      'Cancel': function () {
        $(this).dialog('close');
      },
      'Save': function () {
        $('#edit_participation_form').submit();
      }
    }

  });


  //EventDetail.php
  /* clicked on  edit link to edit participants .. in event detail page*/
  $(document.body).on('click', 'a[id^=editparticipation_]', function (event) {

    var elem = $(this);
    var id = $(this).attr('id');
    var array = id.split("_");
    var person_id = array[1];
    var event_id = $('#event_id').val();
    //var path = root+"Event/editCandidateForm_async";
    var path = root + "Event/editParticipationForm_async";
    $.ajax({
      type: "POST",
      url: path,
      data: {
        person_id: person_id,
        event_id: event_id
      },
      cache: false,
      error: function (xhr, status, error) {
        alert('Error !\n Please try again.\n(Please check your internet connection.)');
      },
      success: function (msg) {
        if ($.trim(msg) == 'no') {
          alert('Action failed.\nPlease try again after some time or refresh the page.');
        } else {
          $('#editCandidateForm').empty();
          $('#editCandidateForm').append(msg);
          $('#editCandidateForm > form').data("person_id", person_id);
          $('#editCandidateForm > form').data("dtBase", 'a[id^=editparticipation_]');
          $('#editCandidateForm > form').data("dt", event.delegateTarget);
          $("#editCandidateForm").dialog('open');
        }
      }
    });

  });


  /*88888888888888888888888 REPORTS 888888888888888888888888888888*/

  $('#people_report_div').click(function () {
    window.location.replace(root + "Report/peopleReport");
  });


  $("input[id^=csparty_],input[id^=person_org_fax],#person_org_fax,#inkind_rate_txt,#inkind_pax_txt,#inkind_hour_txt,#total_direct_cost,#staff_cost,#travel_cost").on('keypress', function (ev) {
    var keyCode = window.event ? ev.keyCode : ev.which;
    //codes for 0-9
    if (keyCode < 48 || keyCode > 57) {
      //codes for backspace, delete, enter
      if (keyCode != 0 && keyCode != 8 && keyCode != 13 && !ev.ctrlKey) {

        if (keyCode == 46) {
          //dont allow multiple decimal points
          if ($(this).val().contains('.')) {
            ev.preventDefault();
          }
        }
        if (keyCode != 46) {
          ev.preventDefault();
        }

      }
    }
  });

  ///////////////////////////validation before saving//////////////////////////////
  $('input[id^=csparty_]').on('blur', function () {
    var total = 0;
    $('input[id^=csparty_]').each(function () {
      if ($.trim($(this).val()) == '') {
      }
      else {
        total += parseFloat($(this).val());
      }

    });
    if (total == 100) {
      //if total percentage is not 100% , dont allow to save the data
      $('#save_event_btn').prop("disabled", false);
      return false;
    }
    else {
      $('#save_event_btn').prop("disabled", true);
      dismiss(1000);
      return false;
    }

  });


  //in person entry.. when focus from nepali date is lost, verify date and convert to english date
  $('#person_dob_np').on('blur', function () {
    var s = $('#person_dob_np').val().replace(/\_/g, '0');
    var parts = s.split('/');
    var year = parseInt(parts[0]);
    var month = parseInt(parts[1]);
    var day = parseInt(parts[2]);
    if (month > 12 || month < 1 || day > 32 || day < 1) {
      alert('invalid date');
    } else {
      /* get english date */
      $.ajax({
        type: "POST",
        url: root + 'Person/convertDate',
        data: {
          identifier: 'np',
          //since the nepali dates are separated with / , convert the separator as -
          dob_np: year + '-' + month + '-' + day
        },
        cache: false,
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
        },
        success: function (msg) {
          $('#person_dob_en').val($.trim(msg));
        }
      });
      /* end get english date */

      /* get age */
      $.ajax({
        type: "POST",
        url: root + 'Person/calculateAge',
        data: {
          identifier: 'np',
          //since the nepali dates are separated with / , convert the separator as -
          dob_np: year + '-' + month + '-' + day
        },
        cache: false,
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
        },
        success: function (msg) {
          $('#person_age').val($.trim(msg));
        }
      });
      /* end get age */
    }
  });

  //in person entry.. when focus from english date is lost, verify date and convert to nepali date
  $('#person_dob_en').on('blur', function () {
    var date = $('#person_dob_en').val().replace(/\_/g, '0');

    var parts = date.split('-');
    var year = parseInt(parts[0]);
    var month = parseInt(parts[1]);
    var day = parseInt(parts[2]);
    if (month > 12 || month < 1 || day > 32 || day < 1) {
      alert('invalid date');
    } else {
      /* get nepali date */
      $.ajax({
        type: "POST",
        url: root + 'Person/convertDate',
        data: {
          identifier: 'en',
          dob_en: date
        },
        cache: false,
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
        },
        success: function (msg) {
          $('#person_dob_np').val($.trim(msg).replace(/\-/g, '/'));
        }
      });
      /* end get nepali date */

      /* get age */
      $.ajax({
        type: "POST",
        url: root + 'Person/calculateAge',
        data: {
          identifier: 'en',
          dob_en: date
        },
        cache: false,
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
        },
        success: function (msg) {
          $('#person_age').val($.trim(msg).replace(/\-/g, '/'));
        }
      });
      /* end get age */
    }
  });
});

//////////////////////////////VALIDATION////////////////////////
jQuery(function ($) {
  $("#person_mobile").mask("(999) 999-9999");
  $("#person_phone").mask("99 999 9999");
  $("#person_dob_en").mask("9999-99-99");
  $("#person_dob_np").mask("9999/99/99");
  $('#event_end_date').mask('9999-99-99');
  $('#event_start_date').mask('9999-99-99');
  $('#person_org_phone').mask('99 999 9999');

  $("#people_entry_form").validate({
    rules: {
      person_email: {
        email: true
      }
    },
    messages: {

      person_email: {
        email: "Please enter valid email"
      }
    }

  });


  $("#people_edit_form").validate({
    rules: {
      person_email: {
        email: true
      }
    },
    messages: {

      person_email: {
        email: "Please enter valid email"
      }
    }

  });


  $('#event_entry_form').validate({
    rules: {
      event_title: {
        required: true
      }
    },
    messages: {
      event_title: {
        required: "Please enter event title"
      }
    }
  });
});


function dismiss(time) {

  setTimeout(function () {
    $('#message').fadeIn('slow');
  }, 50);
  setTimeout(function () {
    $('#message').fadeOut(time);
  }, 50); // <-- time in milliseconds

}

function getPopUpTable(location, level_id) {
  var string = ' <table>' +
    '<tr>' +
    '<td>' +
    '<label>' + location + ' : </label>' +
    '<input type="text" id="location_text" />' +
    '</td>' +
    '</tr>' +
    '<tr>' +
    '<td>' +
    '<label>' + location + ' code: </label>' +
    '<input type="text" id="location_code_text" />' +
    '</td>' +
    ' </tr>' +
    '<tr>' +
    '<td  align="right"><br /><button class="btn btn-info" id="location_savebtn">Save</button></td>' +
    '</tr>' +
    '</table>';
  string += '<input type="hidden" value="' + level_id + '" id="hidden_levelid_identifier" />';
  return string;
}

//||------------Ajax_pagination
(function ($){
// Define a class like this
this.Ajax_pagination=function (opts) {
  // Add object properties like this
  this.opts = $.extend({
    //url_route:'Event/event_list_pagination_ajax',
    //form_selector:'#searchForm',
    //contentDiv_selector:'#eventsList',
    //loading_selector:'.loading'
    //keywords_selector:'#keywords'
  }, opts);
  this.url_route = opts.url_route;
  this.form_selector = opts.form_selector;
  this.contentDiv_selector = opts.contentDiv_selector;
  this.loading_selector = opts.loading_selector;
  this.keywords_selector = opts.keywords_selector;
}
// Add methods like this.  All Person objects will be able to invoke this
this.Ajax_pagination.prototype.searchFilter = function (page_num) {
  var url_route = this.url_route;
  var form_selector = this.form_selector;
  var contentDivSelector = this.contentDiv_selector;
  var loading_selector = this.loading_selector;
  var keywords_selector = this.keywords_selector;
  page_num = (page_num ) ? page_num : 0;
  var keywords = $(keywords_selector).val();
  var sortBy = $('#sortBy').val();
  var formData = $(form_selector).serialize();
  var data = formData + "&page=" + page_num;
  $.ajax({
    type: 'POST',
    url: url_route + '/' + page_num,
    data: data,
    beforeSend: function () {
      $(loading_selector).show();
    },
    success: function (html) {
      $(contentDivSelector).html(html);
      $(loading_selector).fadeOut("slow");
    }
  });
};
})(window.$);
//||END------------Ajax_pagination

$(document).ready(function () {

  //{{{ [1]: in: EditPerson.php  , People.php --> work_type: Profession/Occupation
  var root = '../';
  $('#work_type_btn_cancel').click(function () {
    $("#hiddenspan_add_new_work_type").hide();
    $("#hiddenspan_existing_work_type").show();
    $("#loading_image").hide();
    $('#work_type_txt_add_new').val('');
  });
  $("#work_type_btn_add_new").click(function () {
    $("#hiddenspan_existing_work_type").hide();
    $("#hiddenspan_add_new_work_type").show();
    $("#work_type_btn_add").show();
  });
  $("#work_type_btn_add").on('click', function () {
    var work_name = $('#work_type_txt_add_new').val();
    //if($.trim(work_name)!= '')
    if ($.trim(work_name) != "") {
      $("#loading_image").show();
      $("#work_type_btn_add").hide();
      $.ajax({
        type: "POST",
        //url: root+"Course/grabCourseData_async",
        url: root + "Person/grabWorkTypeData_async",
        data: {
          work_name: work_name
        },
        cache: false,
        error: function (xhr, status, error) {
          alert('Error !\n Please try again.\n(Please check your internet connection.)');
          $("#loading_image").hide();
          $('#work_type_txt_add_new').val('');
        },
        success: function (msg) {
          // alert(msg);
          $("#loading_image").hide();
          if (msg == "no") {
            alert("Insertion failed");
            $('#work_type_txt_add_new').val('');
          }
          else {
            var obj = jQuery.parseJSON(msg);
            var content = '<select name="work_type_id" id="work_type_id"><option value="">-- SELECT --</option>';
            for (i  in obj) {
              content += '<option value="' + obj[i].work_type_id + '">' + obj[i].work_name + '</option>';
              // alert(obj[i].work_name);
            }
            content += '</select>';
            //alert("yessss");
            $("#hiddenspan_work_type").html(content);
            $("#hiddenspan_add_new_work_type").hide();
            $("#hiddenspan_existing_work_type").show();
            $('#work_type_txt_add_new').val('');

            var date = new Date();
            var hour = date.getHours();
            var minute = date.getMinutes();
            var am = "AM";
            if (hour > 12) {
              hour = hour - 12;
              am = "PM";
            }
            var html = '<span class="text-info size11"> &gt; New category (<span class="text-success"><b>' + work_name + '</b></span>) added at (' + hour + ':' + minute + ' ' + am + ')</span><br />';
            $('#work_type_div_progress').show();
            $('#work_type_div_progress').append(html);
          }
        }
      });
    }
    else {
      alert('Please enter work name.')
    }
  });
//}}} [1]


  //||--------Event Year  and Event Month -------||//
  (function ($) {
    $(document.body).on('change', '#event_year', function () {
      var event_year = $('#event_year').val();

      setEventMonthSelects(event_year);

      function setEventMonthSelects(event_year) {
        if (typeof event_year != 'undefined' && event_year != '') {
          $('#mandatory_msg-event_year_month').hide();
          $('#span_event_month').show();
          $('#event_month').removeAttr('disabled');

        } else {
          $('#mandatory_msg-event_year_month').show();
          $('#span_event_month').hide();
          $('#event_month').attr('disabled', 'disabled');
        }
      }

    });
  })(window.$);
  //||--------END: Event Year  and Event Month -------||//


  //|| ----- Check
  $("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
  });


  //||--------District Vdc Ward Number -------||//
  (function ($, adminExtents) {
    if (typeof adminExtents != 'undefined') {
      var districts = adminExtents.districts;
      var vdcs = adminExtents.vdc_municipalities;

      //For Editing
      var oldDistrict = $('#old-district').val();
      var oldVdc = $('#old-vdc').val();
      var oldWardNo = $('#old-ward_no').val();

      $('#district').append($('<option></option>').val('').html(""));
      for (var index in districts) {
        var value = districts[index]['label'];
        var label = districts[index]['label'];
        var option = (value == oldDistrict) ? '<option selected></option>' : '<option ></option>';
        $('#district').append($(option)
          .val(value)
          .html(label)
        );
      }
      //Initialize old vdc value for editing
      if (typeof oldDistrict != 'undefined' && typeof oldVdc != 'undefined') {
        setVdcSelectList(oldDistrict, oldVdc);
      }
      //Initialize old ward_no value for editing
      if (typeof oldDistrict != 'undefined' && typeof oldVdc != 'undefined' && typeof oldWardNo != 'undefined') {
        setWardList(oldDistrict, oldVdc, oldWardNo);
      }

      function setVdcSelectList(district, selectedVdc) {
        function findDistrictId(districts, districtName) {
          var filteredDistricts = districts.filter(function (district) {
            return district.label == districtName;
          });

          if (typeof filteredDistricts[0] != 'undefined' && filteredDistricts.length >= 0) {
            return filteredDistricts[0].name;
          } else {
            return null;
          }
        };
        function findVdcWithDistrictName(district_id) {
          return vdcs.filter(function (vdc) {
            return vdc.district == district_id;
          })
        };

        if (district != '') {
          $("#loading_image-district").show();
        }

        //var district = $.trim($('#district>option:selected').text());
        if (district == '') {
          $('#mandatory_msg-district').show();
          $('#select_vdc_content').empty();

          $('#mandatory_msg-vdc').show();
          $('#select_ward_no_content').empty();
        } else {

          var districtId = findDistrictId(districts, district);
          var filteredVdcs = findVdcWithDistrictName(districtId);


          if (Object.size(filteredVdcs) > 0) {
            var string = '<select name="vdc" id="vdc">';
            var defaultOption = '<option value="">' + '----select----' + '</option>';
            var options = '';
            for (i  in filteredVdcs) {
              var value = filteredVdcs[i]['label'];
              var label = filteredVdcs[i]['label'];
              options += (value == selectedVdc) ?
                '<option selected value="' + value + '">' + label + '</option>' :
                '<option value="' + value + '">' + label + '</option>';
            }
            string += defaultOption;
            string += options;
            string += '</select>';

            $('#mandatory_msg-district').hide();
            $('#select_vdc_content').html(string);
            $("#loading_image-district").hide();

          }
        }
      }

      function setWardList(district, vdc, selectedWardNo) {
        function findMaxWardsByVDCName($vdcName) {
          var sVdc = vdcs.filter(function (vdc) {
            return vdc.label == $vdcName;
          });

          if (sVdc.length > 0)
            return parseInt(sVdc[0].max_ward_no);
        };

        function makeWardDropDown(maxWardNo, $ward_no) {
          $ward_no.html("");
          $ward_no.append($('<option></option>').val("").html("Select Ward"));
//                for (var index in filteredVdcs) {
          for (var i = 1; i <= maxWardNo; i++) {

            $ward_no.append($('<option></option>').val(i).html(i));
          }
        };

        //$("#loading_image-vdc").show();
        if (vdc == '') {
          $('#mandatory_msg-vdc').show();
          $('#select_ward_no_content').empty();
        } else {

          var maxWardNo = findMaxWardsByVDCName(vdc);
          makeWardDropDown(maxWardNo, $('#ward_no'));

          var content = '';
          if (maxWardNo > 0) {
            var string = '<select name="ward_no" id="ward_no">';
            var defaultOption = '<option value="">' + '----select----' + '</option>';
            string += defaultOption;
            var options = '';
            for (var i = 1; i <= maxWardNo; i++) {
              var value = i;
              var label = i;
              options += (value == selectedWardNo) ?
                '<option selected value="' + value + '">' + label + '</option>' :
                '<option value="' + value + '">' + label + '</option>';
            }
            string += options;
            string += '</select>';
            $('#mandatory_msg-vdc').hide();
            $('#select_ward_no_content').html(string);
            //$("#loading_image-ward_no").hide();
          }
        }
      }

      $(document.body).on('change', '#district', function () {
        var district = $('#district').val();
        setVdcSelectList(district);
        setWardList(district, '', '');
      });
      $(document.body).on('change', '#vdc', function () {
        var district = $('#district').val();
        var vdc = $.trim($('#vdc>option:selected').text());
        //var vdc =$('#vdc').val();
        setWardList(district, vdc, oldWardNo);
      });
    }
  })(window.$, window.districtAndVdc);

});



