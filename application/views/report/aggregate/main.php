<?php
/**
 * Created by PhpStorm.
 * User: RamS-NSET
 * Date: 5/26/2017
 * Time: 6:05 AM
 */
?>
<script src="../js/adminextents/district_vdc_municipality.js"></script>

<div class="container">

<div class="row">
	<div class="row">
		<div class="col-md-8">
			<h3>Events Summary Report</h3>
		</div>
	</div>
    <div class="row">
	
		<div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading" style="text-align: center">
            </div>
            <div class="panel-body">
                <?php echo form_open($this->uri->uri_string(), 'id="searchForm" class="form-inline"'); ?>

					<input type="hidden" id="old-district" value="<?=  isset($district)?$district:''?>">
					<input type="hidden" id="old-vdc" value="<?=  isset($vdc)?$vdc:''?>">
					<input type="hidden" id="old-ward_no" value="<?=  isset($ward_no)?$ward_no:''?>">
					<input type="hidden" id="old-page_num" value="<?=  isset($page_num)?$page_num:''?>">
					
					<table>
						<tbody>
				
				
					
					
					
					
					
					
					
					
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
                            </span>
						</td>
					</tr>
					
						   <!--                    District VDC Ward No-->
						<tr>
							<td><label>District : </label></td>
							<td>
								<select name="district" id="district">
								</select>
								<span style="width:20px;display:inline-block">
									<img id="loading_image-district" style="margin-top: -10px; padding: 5px; display: none;"
										 src="../img/loading.gif">
								</span>
							</td>
							<td style="width:10px"><span class="text-info"><b>&gt;&gt;</b></span></td>
							<td><label>VDC/Municipality : </label></td>
							<td>
								<span class="text-error size11" id="mandatory_msg-district">*Select district first</span>
								<span id="select_vdc_content"></span>
							</td>
							<td style="width:10px"><span class="text-info"><b>&gt;&gt;</b></span></td>
							<td><label>Ward No : </label></td>
							<td>
								<span class="text-error size11" id="mandatory_msg-vdc">*Select vdc first</span>
								<span id="select_ward_no_content"></span>
							</td>
						</tr>
						<tr>
							<td>
								<button id="searchBtn" type="submit" class="btn btn-info">Search</button>
							</td>
						</tr>
						<tbody>
					</table>
                </form>
            </div>
        </div>
    </div>
</div>
        <div class="events-list" id="eventsList">
            <?php  $this->load->view('report/aggregate/_list',array('courses'=>$courses)); ?>
        </div>
        <div class="loading" style="display: none;">
            <div class="content"><img src="<?php echo base_url() . 'img/loading.gif'; ?>"/></div>
        </div>
    </div>

		</div>
	</div>
</div>

<script> 

	$('#searchForm').on('submit',function(e){
		e.preventDefault();
		
		searchFilter(0);
	});
  function searchFilter(page_num) {
	  page_num = (page_num )?page_num :0;
    var keywords = $('#keywords').val();
    var sortBy = $('#sortBy').val();
	var formData = $('#searchForm').serialize();
	var data = formData+ "&page=" + page_num;
    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>Report/ajaxAggregateData/'+page_num,
		data: data,
      beforeSend: function () {
        $('.loading').show();
      },
      success: function (html) {
        $('#eventsList').html(html);
        $('.loading').fadeOut("slow");
      }
    });
  }
</script>