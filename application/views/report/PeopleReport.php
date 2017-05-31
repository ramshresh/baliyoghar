
<style type="text/css">

</style>
<!--script language="javascript" type="text/javascript" src="../../js/plugins/jquery.flot.js"></script-->
<script type="text/javascript" >
    $(document).ready(function(){
        var total_people = <?php echo $peopleReport_array[0]; ?>;
        var male = <?php echo $peopleReport_array[1]; ?>;
        var female = <?php echo $peopleReport_array[2]; ?>;
        var other = <?php echo $peopleReport_array[3]; ?>;
        var above30 = <?php echo $peopleReport_array[4]; ?>;
        var below30 = <?php echo $peopleReport_array[5]; ?>;
        var active = <?php echo $peopleReport_array[6]; ?>;
        var retired = <?php echo $peopleReport_array[7]; ?>;
        var insideCountry = <?php echo $peopleReport_array[8]; ?>;
        var outsideCountry = <?php echo $peopleReport_array[9]; ?>;
        var death = <?php echo $peopleReport_array[10]; ?>;
        
        
        /*-------------------------------------- GENDER ---------------------------------------*/
       
       
   
        /*********************************pie chart- gender************************/
        jQuery.jqplot.config.enablePlugins = true;
        plot7 = jQuery.jqplot('gender_pie', 
        [[['Male', male],['Female', female], ['Other', other]]], 
        {
            title: '', 
            gridPadding: {top:0, bottom:38, left:0, right:0},
            seriesDefaults: {
                shadow: true, 
                renderer: jQuery.jqplot.PieRenderer, 
                rendererOptions: {
                    showDataLabels: true,
                    padding: 8
                }
            }, 
            legend: {
                show:true
            }
        }
    );
      
       
        /********************bar chart - gender************************************/
        var s1 = [[1,male], [2,female], [3,other],[],[]];
        var ticks = ['Male', 'Female', 'Other','',''];
         
        plot1 = $.jqplot('gender_bar', [s1], {
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: {
                    show: true
                }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: {
                show: true
            }
        });
        
        /********************line chart - gender************************************/
        var s1 = [[1,male], [2,female], [3,other],[],[]];
        var ticks = ['Male', 'Female', 'Other','',''];
         
        plot1 = $.jqplot('gender_line', [s1], {
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                pointLabels: {
                    show: true
                }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: {
                show: true
            }
        });
   
      
      
        /*-------------------------------------- AGE ---------------------------------------*/
   
   
      
        //pie chart- age
        plot7 = jQuery.jqplot('age_pie', 
        [[['Age<30', below30],['Age>30', above30]]], 
        {
            title: '', 
            seriesDefaults: {
                shadow: true, 
                renderer: jQuery.jqplot.PieRenderer, 
                rendererOptions: {
                    showDataLabels: true
                }
            }, 
            legend: {
                show:true
            }
        }
    );
            
            
        //bar chart- age
        var s1 = [[1,below30], [2,above30],[],[],[]];
        var ticks = ['Age<30', 'Age>30','','',''];
         
        plot1 = $.jqplot('age_bar', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: {
                    show: true
                }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: {
                show: true
            }
        });
        
        // line chart--age
        var s1 = [[1,below30], [2,above30],[],[],[]];
        var ticks = ['Age<30', 'Age>30','','',''];
         
        plot1 = $.jqplot('age_line', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                pointLabels: {
                    show: true
                }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: {
                show: true
            }
        });
   
        
      
      
        
        /*-------------------------------------- Status ---------------------------------------*/
        
        
        //pie chart- status
        plot7 = jQuery.jqplot('status_pie', 
        [[['Active', active],['Retired', retired],['Migrated inside', insideCountry],['Migrated outside', outsideCountry],['Death', death]]], 
        {
            title: '', 
            seriesDefaults: {
                shadow: true, 
                renderer: jQuery.jqplot.PieRenderer, 
                rendererOptions: {
                    showDataLabels: true
                }
            }, 
            legend: {
                show:true
            }
        }
    );
      
      
        //bar chart - status
        var s1 = [[1,active], [2,retired],[3,insideCountry], [4,outsideCountry],[5,death]];
        var ticks = ['Active', 'Retired', 'Migrated inside', 'Migrated outside', 'Death'];
         
        plot1 = $.jqplot('status_bar', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: {
                    show: true
                }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: {
                show: true
            }
        });
   
        //line chart - status
        var s1 = [[1,active], [2,retired],[3,insideCountry], [4,outsideCountry],[5,death]];
        var ticks = ['Active', 'Retired', 'Migrated inside', 'Migrated outside', 'Death'];
         
        plot1 = $.jqplot('status_line', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                pointLabels: {
                    show: true
                }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: {
                show: true
            }
        });
   
       // $('#ExportPeopleReport').on('click',function(){
            var content = '';
            content += below30+',';
            content += above30+',';
            content += ',';  
            
            content += male+',';
            content += female+',';
            content += other+',';
            content += ','; 
            
            content += active+',';
            content += retired+',';
            content += insideCountry+',';
            content += outsideCountry+',';
            content += death;
                
            $('#content').val(content);
            
              // alert($('#content').val());
    });

</script>

<div class="container" >
    <table style="border:1px solid #CCC;margin-top:30px" width="100%" class="maintable">
        <tr>
            <td style="padding:20px">
                <h5>Detail people report</h5>
                <hr />

                <table width="100%" border="0" cellspacing="0" cellpadding="5" class="dataListing" >
                    <tr>
                        <th align="center" width="7%" rowspan="2">Total people</th>
                        <th align="center" width="10%" colspan="3">Gender</th>
                        <th align="center" width="10%" colspan="2">Age</th>
                        <th align="center" width="50%" colspan="5">Status</th>
                    </tr>
                    <tr>
                        <th>Male</th>
                        <th>Female</th>
                        <th>Other</th>
                        <th>Below 30</th>
                        <th>Above 30</th>
                        <th>Active</th>
                        <th>Retired</th>
                        <th>Migrated within country</th>
                        <th>Migrated outside country</th>
                        <th>Death</th>
                    </tr>
                    <tr>
                        <td><?php echo $peopleReport_array[0]; ?></td><!-- Total people -->
                        <td><?php echo $peopleReport_array[1]; ?></td><!-- Total male -->
                        <td><?php echo $peopleReport_array[2]; ?></td><!-- Total female -->
                        <td><?php echo $peopleReport_array[3]; ?></td><!-- Total other -->
                        <td><?php echo $peopleReport_array[4]; ?></td><!-- Total above 30 -->
                        <td><?php echo $peopleReport_array[5]; ?></td><!-- Total below 30 -->
                        <td><?php echo $peopleReport_array[6]; ?></td><!-- Total active -->
                        <td><?php echo $peopleReport_array[7]; ?></td><!-- Total retired -->
                        <td><?php echo $peopleReport_array[8]; ?></td><!-- Total inside country -->
                        <td><?php echo $peopleReport_array[9]; ?></td><!-- Total outside country -->
                        <td><?php echo $peopleReport_array[10]; ?></td><!-- Total death -->
                    </tr>

                    <?php
                    ?>
                </table>
                <?php 
                echo form_open('ExportToExcel/peopleReport'); 
                ?>
                <input type="hidden" name="id" id="id" value="people"/>
                <input type="hidden" name="content" id="content" />
                <input type="hidden" name="peopleReportContent" id="peopleReportContent" />
                <button class="btn" style="display:inline-block;margin-top:3px"><img src="../img/excel32.png" /> Export to excel</button>
                <a href="#" id="OldPeopleReport" style="margin-bottom:-10px">View old reports</a>
                </form>
               
                <br />
                <h5>Graph option</h5>
                <hr />


                <table width="100%" border="0" cellspacing="0" cellpadding="5" class="dataListing" >
                    <tr>
                        <th align="center" width="32%" ><h5>Pie chart</h5></th>
                    <th align="center" width="33%" ><h5>Bar chart</h5></th>
                    <th align="center" width="35%" ><h5>Line chart</h5></th>
        </tr>
        <tr>
            <th colspan="3">Gender wise </th>
        </tr>
        <tr>
            <td> <div id="gender_pie"></div></td>
            <td> <div id="gender_bar" ></div></td>
            <td> <div id="gender_line"></div></td>
        </tr>

        <tr>
            <th colspan="3">Age wise </th>
        </tr>
        <tr>
            <td> <div id="age_pie"></div></td>
            <td> <div id="age_bar"></div></td>
            <td> <div id="age_line"></div></td>
        </tr>

        <tr>
            <th colspan="3">Status wise </th>
        </tr>
        <tr>
            <td> <div id="status_pie"></div></td>
            <td> <div id="status_bar"></div></td>
            <td> <div id="status_line"></div></td>
        </tr>
        <?php
        ?>
    </table>



</td>
</tr>
</table>

</div> <!-- end of container tag-->
<br />

