<?php
/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 5/26/2017
 * Time: 10:02 AM
 */
?>

<style>
    div.table-wrapper {
        width: 100%;
        max-height: 500px;
        overflow: auto;
    }
</style>
<script src="<?= base_url() ?>js/jqueryTable2Excel/jquery.table2excel.min.js"></script>
<?php if (isset($applied_filters)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <strong>Showing Results for :</strong>
                <br>
                <strong>Year
                    :</strong> <?= (isset($applied_filters['event_year']) && $applied_filters['event_year'] != '') ? $applied_filters['event_year'] : 'ALL'; ?>
                <strong>Month
                    :</strong> <?= (isset($applied_filters['event_month_name']) && $applied_filters['event_month_name'] != '') ? $applied_filters['event_month_name'] : 'ALL'; ?>
                <br/>
                <strong>Event Type
                    :</strong> <?= (isset($applied_filters['event_type_name']) && $applied_filters['event_type_name'] != '') ? $applied_filters['event_type_name'] : 'ALL'; ?>
                <br>
                <strong>District
                    :</strong> <?= (isset($applied_filters['event_district']) && $applied_filters['event_district'] != '') ? $applied_filters['event_district'] : 'All'; ?>
                <br/>
                <strong>VDC/Municipality
                    :</strong> <?= (isset($applied_filters['event_vdc']) && $applied_filters['event_vdc'] != '') ? $applied_filters['event_vdc'] : 'ALL'; ?>
                <br/>
                <strong>Ward No
                    :</strong> <?= (isset($applied_filters['event_ward_no']) && $applied_filters['event_ward_no'] != '') ? $applied_filters['event_ward_no'] : 'ALL'; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="row">

    <div class="col-xs-4 ">
        <div class="tbl-toolbar">
            <div class="pull-left">
                <?= form_open_multipart('', 'id="keywords_searchForm"'); ?>
                <input type="hidden" name="event_year"
                       value="<?= isset($applied_filters['event_year']) ? $applied_filters['event_year'] : '' ?>"/>
                <input type="hidden" name="event_month"
                       value="<?= isset($applied_filters['event_month']) ? $applied_filters['event_month'] : '' ?>"/>
                <input type="hidden" name="event_month_name"
                       value="<?= isset($applied_filters['event_month_name']) ? $applied_filters['event_month_name'] : '' ?>"/>
                <input type="hidden" name="event_course_category"
                       value="<?= isset($applied_filters['event_type']) ? $applied_filters['event_type'] : '' ?>"/>
                <input type="hidden" name="event_course_category_name"
                       value="<?= isset($applied_filters['event_type_name']) ? $applied_filters['event_type_name'] : '' ?>"/>
                <input type="hidden" name="event_district"
                       value="<?= isset($applied_filters['event_district']) ? $applied_filters['event_district'] : '' ?>"/>
                <input type="hidden" name="event_vdc"
                       value="<?= isset($applied_filters['event_vdc']) ? $applied_filters['event_vdc'] : '' ?>"/>
                <input type="hidden" name="event_ward_no"
                       value="<?= isset($applied_filters['event_ward_no']) ? $applied_filters['event_ward_no'] : '' ?>"/>
                <div class="input-group">
                    <input id="keywords" name="keywords" class="form-control" placeholder="Search Keywords..."
                           aria-label="Search..."
                           value="<?= isset($applied_filters['keywords']) ? $applied_filters['keywords'] : '' ?>">
                    <div class="input-group-btn">
                        <button id="keywords_clearBtn" type="button" class="btn btn-default" aria-label="Clear">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                        <button id="keywords_searchBtn" type="submit" class="btn btn-default" aria-label="Search">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
    <div class="col-xs-8 ">
        <div class="tbl-toolbar">
            <div class="pull-right">
                <button id="btnExport" class="">Export to xls</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 table-wrapper">

        <?php if (!empty($people)): ?>
            <table id="table_wrapper" width="100%" border="0" cellspacing="0" cellpadding="5" class="dataListing">
                <thead>
                <tr>
                    <th rowspan="2" colspan="1">Actions</th>
                    <th rowspan="2" colspan="1" width="3%"><input type="checkbox" id="checkAll"/></th>
                    <th rowspan="1" colspan="6" >Person Details</th>
                    <th rowspan="1" colspan="2" >Participations Details</th>
                </tr>
                <tr>
                    <th align="left" width="3%">
                        Id
                    </th>
                    <th align="left" width="3%">
                        Identity
                    </th>
                    <th align="left" width="3%">
                        Date of Birth
                    </th>
                    <th align="left" width="3%">
                        Address
                    </th>
                    <th align="left" width="3%">
                        Contact
                    </th>
                    <th align="left" width="3%">
                        Organization
                    </th>
                    <th align="left" width="3%">
                        Events Count
                    </th>
                    <th align="left" width="3%">
                        Event Codes
                    </th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($people as $person) { ?>
                    <?php
                    //["event_deleted","event_event_id","event_title","event_course_cat_id","event_district","event_vdc","event_ward_no","event_year","event_start_date","event_end_date","event_venue","event_address","event_latitude","event_longitude","event_code","participation_deleted","participation_person_id","participation_person_age","participation_is_instructor","participation_beneficiary_type","participation_certification_status","person_deleted","person_work_type_id","person_fullname","person_dob_en","person_gender","person_p_address","person_c_address","person_photo","person_country","person_phone","person_mobile"
                    //,"age_below_14","age_15_19","age_20_24","age_25_29","age_30_34","age_35_above",
                    //"Other","Daily Wages","Business","Student","Service","Housewife","Agriculture","Sub\/Asst. engineers","Contractors","Architects","Engineers","House Owner","Non House Owner","Existing Mason","New Mason"]
                    ; ?>
                    <tr>
                        <td width="1%">
                            <a href="<?= base_url() ?>Person/viewPerson?id=<?= $person['person_id'] ?>">view</a>
                            <a href="<?= base_url() ?>Person/edit?id=<?= $person['person_id'] ?>"
                               onclick="return confirm('Are you sure?')">Edit</a>
                            <a onclick="event_list_pagination_deleteEvent_ajax(<?= $person['person_id'] ?>)">Delete</a>

                            <!--<form class="" method="post" action="<? /*= base_url() */ ?>Event/event_list_pagination_deleteEvent">
                                <input name="id" type="hidden" value="<? /*= $event['event_event_id'] */ ?>"/>
                                <button  type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>-->
                        </td>
                        <td width="1%">
                            <input class="row-person" type="checkbox"
                                   data-event_id="<?php echo $person['person_id'] ?>"/>
                            <div class="span3">
                                <?= $person['person_photo'] ?>
                                <?php if (isset($person['person_photo']) && (strpos($person['person_photo'], 'image_') !== false)) { ?>

                                    <img src="../gallery/thumbs/<?php echo $person['person_photo']; ?>" style="margin-bottom:10px;"/>
                                    <!-- <br/> <a href="../gallery/<?php echo $person['person_photo']; ?>">View full size</a>-->

                                <?php } else { ?>
                                    <img src="../img/no_image.gif" height="134px" width="100px" style="margin-bottom:10px;"/>
                                <?php } ?>
                            </div>
                        </td>


                        <td width="1%"><?php echo $person['person_id']; ?></td>
                        <td width="1%"><?php echo 'Name: '.$person['person_fullname']
                                .'<br/>Gender: '.$person['person_gender']
                                .'<br/>Caste/Ethnicity: '.$person['person_caste_ethnicity']
                            ;
                            ?></td>
                        <td width="1%"><?php echo 'BS: '.$person['person_dob_np'].'<br/>EN: '.$person['person_dob_en']; ?></td>
                        <td width="3%">
                            <?php echo 'Permanent: '.$person['person_p_address']
                                .'<br/>Current: '.$person['person_c_address']
                            ;
                            ?>
                        </td>
                        <td width="3%"><?php echo 'Mobile: '.$person['person_mobile']
                                .'<br/>Tel: '.$person['person_phone']
                                .'<br/>Email: '.$person['person_email']
                            ;
                        ?></td>
                        <td width="3%"><?php echo 'Organization: '.$person['person_org_name']
                                .'<br/>Position: '.$person['person_org_position']
                                .'<br/>Address: '.$person['person_org_address']
                                .'<br/>Tel: '.$person['person_org_phone']
                                .'<br/>Fax: '.$person['person_org_fax']
                            ;
                        ?></td>

                        <td width="1%"><?php echo $person['count_events']; ?></td>
<!--                        <td width="1%">--><?php //echo $person['csv_event_codes']; ?><!--</td>-->
                        <td width="1%"><?php echo $person['events_html_links']; ?></td>

                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="well">Record(s) not available.</div>
        <?php endif; ?>

    </div>
</div>
<div class="row tbl-bottom-toolbar">
    <div class="col-md-12">
        <?php if(isset($pagination_links)):?>
        <?php echo $pagination_links; ?>
        <?php endif;?>
    </div>
</div>

<script>
  $("#btnExport").on('click', function () {
    $('#table_wrapper').table2excel({
      // exclude CSS class
      exclude: ".noExl",
      name: "Reports",
      filename: "Summary Report" //do not include extension
    });
  })
</script>

<script>
  window.searchFilter;

  function event_list_pagination_deleteEvent_ajax(eventId) {
    var url_route = '<?php echo base_url(); ?>' + 'Person/people_list_pagination_ajax';
    var data = {
      'id':eventId
    };
    if(confirm('Are You Sure?')){
      $.ajax({
        type: 'POST',
        url: url_route,
        data: data,
        beforeSend: function () {

        },
        success: function (response) {
          var responseObj =(typeof response != 'object')?JSON.parse(response):response;
          if(responseObj.success){
            $('#keywords_searchForm').submit();
          }else{
            alert(responseObj.message);
          }
        }
      });
    }
  }

  $('#keywords_clearBtn').on('click', function (e) {
    $('#keywords').val('');
    $('#keywords_searchForm').submit();
  });
  $('#keywords_searchForm').on('submit', function (e) {
    e.preventDefault();
    //defined in js/scripts.js --> Ajax_pagination
    var ajax_pagination_list = new Ajax_pagination({
      url_route: '<?php echo base_url(); ?>' + 'Person/people_list_pagination_ajax',
      form_selector: '#keywords_searchForm',
      contentDiv_selector: '#peopleList',
      loading_selector: '.loading',
      keywords_selector: '#keywords',
    });
    window.searchFilter = function (page_num) {
      ajax_pagination_list.searchFilter(page_num);
    }
    searchFilter(0);
  });

</script>
