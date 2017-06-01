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
                <h3 class="uppercase nicefont nicecolor"><b class=""></b> &nbsp;List of Events </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $this->load->view('includes/components/_search_panel.php');?>
            </div>
        </div>
        <div class="events-list" id="eventsList">
            <?php $this->load->view('event/list_pagination/_list', array('courses' => $courses)); ?>
        </div>
        <div class="loading" style="display: none;">
            <div class="content"><img src="<?php echo base_url() . 'img/loading.gif'; ?>"/></div>
        </div>
    </div>

</div>
<script>

</script>
<script>
  window.searchFilter; //function used by Ajax_pagination library

  //defined in js/scripts.js --> Ajax_pagination
  var ajax_pagination_main = new Ajax_pagination({
    url_route:'<?php echo base_url(); ?>' + 'Event/event_list_pagination_ajax',
    form_selector:'#searchForm',
    contentDiv_selector:'#eventsList',
    loading_selector:'.loading',
    keywords_selector:'#keywords',
  });
  window.searchFilter =function(page_num) {
    ajax_pagination_main.searchFilter(page_num);
  };

  $('#searchForm').on('submit', function (e) {
    e.preventDefault();
    searchFilter(0);
  });

</script>

