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
                <h3 class="uppercase nicefont nicecolor"><b class=""></b> &nbsp;List of People </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $this->load->view('includes/components/_search_panel.php');?>
            </div>
        </div>
        <div class="pagination-table" id="peopleList">
            <?php $this->load->view('person/list_pagination/_list', array('courses' => $courses)); ?>
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


  var ajax_pagination_main = new Ajax_pagination({
    url_route:'<?php echo base_url(); ?>' + 'Person/people_list_pagination_ajax',
    form_selector:'#searchForm',
    contentDiv_selector:'#peopleList',
    loading_selector:'.loading',
    keywords_selector:'#keywords',
  });
  var searchFilter_main =function(page_num) {
    ajax_pagination_main.searchFilter(page_num);
  };

  if(typeof searchFilter == 'undefined'){
    window.searchFilter = searchFilter_main;
  }

  $('#searchForm').on('submit', function (e) {
    e.preventDefault();
    //defined in js/scripts.js --> Ajax_pagination
    window.searchFilter = searchFilter_main;
    searchFilter(0);
  });

</script>

