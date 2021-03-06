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
<?php //if (isset($applied_filters)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <strong>Showing Results for :</strong>
                <br/>
                <strong>Year :</strong> <?= (isset($applied_filters['event_year']) && $applied_filters['event_year'] != '') ? $applied_filters['event_year'] : 'ALL'; ?>
                <br/>
                <strong>Month:</strong> <?= (isset($applied_filters['event_month_name']) && $applied_filters['event_month_name'] != '') ? $applied_filters['event_month_name'] : 'ALL'; ?>
                <br/>
                <strong>Event Type
                    :</strong> <?= (isset($applied_filters['event_type_name']) && $applied_filters['event_type_name'] != '') ? $applied_filters['event_type_name'] : 'ALL'; ?>
                <br/>
                <strong>District :</strong> <?= (isset($applied_filters['event_district']) && $applied_filters['event_district'] != '') ? $applied_filters['event_district'] : 'All'; ?>
                <br/>
                <strong>VDC/Municipality :</strong> <?= (isset($applied_filters['event_vdc']) && $applied_filters['event_vdc'] != '') ? $applied_filters['event_vdc'] : 'ALL'; ?>
                <br/>
                <strong>Ward No :</strong> <?= (isset($applied_filters['event_ward_no']) && $applied_filters['event_ward_no'] != '') ? $applied_filters['event_ward_no'] : 'ALL'; ?>
            </div>
        </div>
    </div>
<?php //endif; ?>


<div class="row">

    <div class="col-xs-4 ">
        <div class="tbl-toolbar">
            <div class="pull-left">
                <?= form_open_multipart('','id="keywords_searchForm"'); ?>
                    <input type="hidden" name="event_year" value="<?=isset($applied_filters['event_year'])?$applied_filters['event_year']:''?>" />
                    <input type="hidden" name="event_month" value="<?=isset($applied_filters['event_month'])?$applied_filters['event_month']:''?>" />
                    <input type="hidden" name="event_month_name" value="<?=isset($applied_filters['event_month_name'])?$applied_filters['event_month_name']:''?>" />
                    <input type="hidden" name="event_course_category" value="<?=isset($applied_filters['event_type'])?$applied_filters['event_type']:''?>" />
                    <input type="hidden" name="event_course_category_name" value="<?=isset($applied_filters['event_type_name'])?$applied_filters['event_type_name']:''?>" />
                    <input type="hidden" name="event_district" value="<?=isset($applied_filters['event_district'])?$applied_filters['event_district']:''?>" />
                    <input type="hidden" name="event_vdc" value="<?=isset($applied_filters['event_vdc'])?$applied_filters['event_vdc']:''?>" />
                    <input type="hidden" name="event_ward_no" value="<?=isset($applied_filters['event_ward_no'])?$applied_filters['event_ward_no']:''?>" />
                <div class="input-group">
                    <input id="keywords" name="keywords" class="form-control" placeholder="Search Keywords..." aria-label="Search..." value="<?=isset($applied_filters['keywords'])?$applied_filters['keywords']:''?>">
                    <div class="input-group-btn">
                        <button id="keywords_clearBtn" type="button" class="btn btn-default" aria-label="Clear">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                        <button id="keywords_searchBtn" type="submit" class="btn btn-default" aria-label="Search">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                </div>
                <?= form_close();?>
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

        <?php if (!empty($events)): ?>
            <table id="table_wrapper" width="100%" border="0" cellspacing="0" cellpadding="5" class="dataListing">
                <thead>
                <tr>
                    <th style="width:160px" rowspan="3">Actions</th>
                    <th rowspan="3"><input type="checkbox" id="checkAll"/></th>
                    <th colspan="13" rowspan="2">Event Details</th>
                    <th colspan="21">Participants Summary</th>
                </tr>
                <tr>
                    <th colspan="1" rowspan="2">Total</th>
                    <th colspan="3">Gender</th>
                    <th colspan="6">Age Group</th>
                    <th colspan="7">Occupation : Group 1</th>
                    <th colspan="4">Occupation : group 2</th>
                </tr>
                <tr>
                    <th align="left" width="3%">
                        Id
                    </th>
                    <th align="left" width="3%">
                        Event Type
                    </th><th align="left" width="3%">
                        Event Code
                    </th>
                    <th align="left" width="8%">
                        Title
                    </th>
                    <th align="left" width="8%">
                        Start Date
                    </th>
                    <th align="left" width="8%">
                        End Date
                    </th>
                    <th align="left" width="18%">
                        District
                    </th>
                    <th align="left" width="18%">
                        Vdc
                    </th>
                    <th align="left" width="3%">
                        Ward No
                    </th>
                    <th align="left" width="18%">
                        Tole
                    </th>
                    <th align="left" width="18%">
                        Venue
                    </th>
                    <th align="left" width="18%">
                        Longitude
                    </th>
                    <th align="left" width="18%">
                        Latitude
                    </th>

                    <th>Male</th>
                    <th>Female</th>
                    <th>Other</th>

                    <th>age_below_14</th>
                    <th>age_15_19</th>
                    <th>age_20_24</th>
                    <th>age_25_29</th>
                    <th>age_30_34</th>
                    <th>age_35_above</th>


                    <th>Daily Wages</th>
                    <th>Business</th>
                    <th>Student</th>
                    <th>Service</th>
                    <th>Housewife</th>
                    <th>Agriculture</th>
                    <th>Other</th>

                    <th>Engineers</th>
                    <th>Sub/Asst. engineers</th>
                    <th>Architects</th>
                    <th>Contractors</th>


                </tr>
                </thead>
                <tbody>

                <?php foreach ($events as $event) { ?>
                    <?php
                        //["event_deleted","event_event_id","event_title","event_course_cat_id","event_district","event_vdc","event_ward_no","event_year","event_start_date","event_end_date","event_venue","event_address","event_latitude","event_longitude","event_code","participation_deleted","participation_person_id","participation_person_age","participation_is_instructor","participation_beneficiary_type","participation_certification_status","person_deleted","person_work_type_id","person_fullname","person_dob_en","person_gender","person_p_address","person_c_address","person_photo","person_country","person_phone","person_mobile"
                        //,"age_below_14","age_15_19","age_20_24","age_25_29","age_30_34","age_35_above",
                        //"Other","Daily Wages","Business","Student","Service","Housewife","Agriculture","Sub\/Asst. engineers","Contractors","Architects","Engineers","House Owner","Non House Owner","Existing Mason","New Mason"]
                    ; ?>
                    <tr>
                        <td>
                            <a href="<?= base_url() ?>Event/viewEvent?id=<?= $event['event_event_id'] ?>">view</a>
                        </td>
                        <td><input class="row-event" type="checkbox"
                                   data-event_id="<?php echo $event['event_event_id'] ?>"/></td>


                        <td><?php echo $event['event_event_id']; ?></td>

                        <td><?php echo isset($courses[$event['event_course_cat_id']]) ? $courses[$event['event_course_cat_id']] : $event['event_course_cat_id']; ?></td>
                        <td><?php echo $event['event_code']; ?></td>
                        <td><?php echo $event['event_title']; ?></td>
                        <td><?php echo $event['event_start_date']; ?></td>
                        <td><?php echo $event['event_end_date']; ?></td>
                        <td><?php echo $event['event_district']; ?></td>
                        <td><?php echo $event['event_vdc']; ?></td>
                        <td><?php echo $event['event_ward_no']; ?></td>
                        <td><?php echo $event['event_address']; ?></td>
                        <td><?php echo $event['event_venue']; ?></td>
                        <td><?php echo $event['event_longitude']; ?></td>
                        <td><?php echo $event['event_latitude']; ?></td>
                        <td><?php echo $event['total_participants']; ?></td>

                        <td><?php echo $event['gender_male']; ?></td>
                        <td><?php echo $event['gender_female']; ?></td>
                        <td><?php echo $event['gender_other']; ?></td>

                        <td><?php echo $event['age_below_14']; ?></td>
                        <td><?php echo $event['age_15_19']; ?></td>
                        <td><?php echo $event['age_20_24']; ?></td>
                        <td><?php echo $event['age_25_29']; ?></td>
                        <td><?php echo $event['age_30_34']; ?></td>
                        <td><?php echo $event['age_35_above']; ?></td>

                        <td><?php echo $event['Daily Wages'] ?></td>
                        <td><?php echo $event['Business']; ?></td>
                        <td><?php echo $event['Student']; ?></td>
                        <td><?php echo $event['Service']; ?></td>
                        <td><?php echo $event['Housewife']; ?></td>
                        <td><?php echo $event['Agriculture']; ?></td>
                        <td><?php echo $event['Other']; ?></td>

                        <td><?php echo $event['Engineers']; ?></td>
                        <td><?php echo $event['Sub/Asst. engineers']; ?></td>
                        <td><?php echo $event['Architects']; ?></td>
                        <td><?php echo $event['Contractors']; ?></td>


                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="well">Event(s) not available.</div>
        <?php endif; ?>

    </div>
</div>
<div class="row tbl-bottom-toolbar">
    <div class="col-md-12">
        <?php echo $this->ajax_pagination->create_links(); ?>
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
  window.searchFilter; //function used by Ajax_pagination library


    $('#keywords_clearBtn').on('click', function (e) {
      $('#keywords').val('');
      $('#keywords_searchForm').submit();
    });
    $('#keywords_searchForm').on('submit', function (e) {
      e.preventDefault();

      //defined in js/scripts.js --> Ajax_pagination
      var ajax_pagination = new Ajax_pagination({
        url_route: '<?php echo base_url(); ?>' + 'Report/ajaxAggregateData',
        form_selector: '#keywords_searchForm',
        contentDiv_selector: '#eventsList',
        loading_selector: '.loading',
        keywords_selector: '#keywords',
      });
      window.searchFilter =function(page_num) {
        ajax_pagination.searchFilter(page_num);
      }


      searchFilter(0);
    });

</script>