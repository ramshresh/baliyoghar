<style type="text/css">
    input[type=text]{-moz-border-radius: 0px;-webkit-border-radius: 0px;border-radius: 0px;}
    .left{float: left;}
    .clear{clear:both;}
    hr{margin:5px;}
	   .red{color:#FF0000;}
</style>
<div class="container" >
    <table style="border:1px solid #CCC;margin-top:30px;" width="100%" class="maintable getBg">
        <tr>
            <td style="padding:20px;min-height:300px;display:block;text-align: center;vertical-align: middle">
                <h5 class="nicecolor">Report by people</h5>
                <span class="text-info"><b>Search by name </b>&nbsp;</span>
                <?php echo form_open('report/searchbyname') ?>
                <input type="text" style="width:300px" id="search_string_peoplereport" placeholder="Search by name.." name="search_string_peoplereport"/>
                <input type="hidden" name="identifier" value="button_clicked" />
                <button class="btn" id="search_button_peoplereport" name="search_button_peoplereport"><b class="icon-search"></b>&nbsp;search</button>
                <?php echo form_close();?>
                <br/>
                <img src="../img/loading.gif" id="loading" style="display:none"/>
                <div id="search_result_peoplereport">
                    <br />
                    <br />
                    <hr />
                    <b class="nicecolor nicefont left"> Search result for : &nbsp;<span id="search_string"><?php if(isset($name)){echo $name;}else{echo '%';}
  ?></span></b>
                    <div class="clear"></div>
                    <hr />
                    <table class="dataListing" width="100%" cellspacing="0" cellpadding="5" border="0">
                        <tbody class="edit_coverage_location">
                            <tr>
                                <th width="5%" align="center">#</th>
                                <th width="20%" align="center">Full name</th>
                                <th width="35%" align="center">Address</th>
                                <th width="10%" align="center">DOB</th>
                                <th width="10%" align="center">Phone</th>
                                <th width="10%" align="center">Status</th>
                                <th width="10%" align="center">Action</th>
                            </tr>
                          <?php  if(isset($person_result_array)){
				
							  
							  for($i=0;$i<count($person_result_array);$i++)
							  {
							   ?>
                            <tr>
                                <td align="center"><?php echo $i+1;?></td>
                                <td align="left"><?php echo $person_result_array[$i]['name'];?></td>
                                <td align="left"><?php echo $person_result_array[$i]['address'];?></td>
                                <td align="center"><?php echo $person_result_array[$i]['dob'];?></td>
                                <td align="center"><?php echo $person_result_array[$i]['phone'];?></td>
                                <td align="center"><?php echo $person_result_array[$i]['status'];?></td>
                                <td align="center"><a href="../person/viewPerson?id=<?php echo $person_result_array[$i]['id'];?>">view</a></td>
                            </tr>
                            <?php } }else
							echo '<tr><td colspan="7"><span class="red"> Sorry no records found .</span></td></tr>';
							 ?>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>

</div> <!-- end of container tag-->