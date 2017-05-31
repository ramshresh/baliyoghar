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
<script src="<?=base_url()?>js/jqueryTable2Excel/jquery.table2excel.min.js"></script>
<div class="row">
	<div class="col-md-12 ">
		<div class="tbl-toolbar">
			<div class="pull-right">
			<button id="btnExport" class="">Export to xls</button>
			</div>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-md-12 table-wrapper" >
	
        <?php if (!empty($events)): ?>
             <table id="table_wrapper" width="100%" border="0" cellspacing="0" cellpadding="5" class="dataListing" >
                <thead>
                <tr>
				 <th style="width:160px">Actions</th>
                    <th><input type="checkbox" id="checkAll"/></th>
                    <th align="left" width="3%">
                        Id
                    </th><th align="left" width="3%">
                        Course Category
                    </th>
                    <th align="left" width="8%">
                        Title
                    </th><th align="left" width="8%">
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
					<th>Total</th>
					
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
					
					<th>Sub/Asst. engineers</th>
					<th>Contractors</th>
					<th>Architects</th>
					<th>Engineers</th>
                   
                </tr>
                </thead>
                <tbody>

                <?php foreach ($events as $event) { ?>
					<?php 
					
					//["event_deleted","event_event_id","event_title","event_course_cat_id","event_district","event_vdc","event_ward_no","event_year","event_start_date","event_end_date","event_venue","event_address","event_latitude","event_longitude","event_code","participation_deleted","participation_person_id","participation_person_age","participation_is_instructor","participation_beneficiary_type","participation_certification_status","person_deleted","person_work_type_id","person_fullname","person_dob_en","person_gender","person_p_address","person_c_address","person_photo","person_country","person_phone","person_mobile"
					//,"age_below_14","age_15_19","age_20_24","age_25_29","age_30_34","age_35_above",
					//"Other","Daily Wages","Business","Student","Service","Housewife","Agriculture","Sub\/Asst. engineers","Contractors","Architects","Engineers","House Owner","Non House Owner","Existing Mason","New Mason"]
					;?>
                    <tr>
					<td>
						<a href="<?=base_url()?>Event/viewEvent?id=<?=$event['event_event_id']?>">view</a>
						</td>
                        <td><input class="row-event" type="checkbox"
                                   data-event_id="<?php echo $event['event_event_id'] ?>"/></td>

								   
								  
						<td><?php echo $event['event_event_id']; ?></td>
                        <td><?php echo isset($courses[$event['event_course_cat_id']])?$courses[$event['event_course_cat_id']]:$event['event_course_cat_id']; ?></td>
                        
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
						
						<td><?php echo $event['Sub/Asst. engineers']; ?></td>
						<td><?php echo $event['Contractors']; ?></td>
						<td><?php echo $event['Architects']; ?></td>
						<td><?php echo $event['Engineers']; ?></td>
						
							
						
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
$("#btnExport").on('click',function(){
	$('#table_wrapper').table2excel({
    // exclude CSS class
    exclude: ".noExl",
    name: "Reports",
    filename: "Summary Report" //do not include extension
  });
})
</script>
