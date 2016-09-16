
<script type="text/javascript">
    $(document).ready(function(){
        
        $(document.body).on('click',".right_a",function(){
            $(".table_a").animate({"left": "+=484px"}, "fast");
            $(this).removeClass('right_a');
            $(this).addClass('left_a');
            $(".table_img_a" ).prop( 'src','../img/arrow_lt.png' );
        });
        
        $(document.body).on('mouseover',".right_a",function(){
            $(".table_a").animate({"left": "+=3px"},0);
        });
        $(document.body).on('mouseout',".right_a",function(){
            $(".table_a").animate({"left": "-=3px"},0);
        });
 
        $(document.body).on('click',".left_a",function(){
            $(".table_a").animate({"left": "-=484px"}, "fast");
            $(this).addClass('right_a');
            $(this).removeClass('left_a');
            $(".table_img_a" ).prop( 'src','../img/arrow_rt.png' );
        });
 
        
    });
</script>
<div class="navigation" style="background:#fff url(../img/mask2.png);margin-bottom:0px">
    <div class="container" style="">
        <div class="row" style="padding-bottom:0;margin-bottom:0;">
            <div class="span12" >
                <div class="navbar" >
                    <div class="navbar-inner" style="background:transparent;">
                        <table border="0" width="100%" style="background:transparent">
                            <tr>
                                <td rowspan="2" style="padding-top:5px">
                                    <img src="../img/nsetlogo.png"  style="float:left;background:transparent"/>
                                </td>
                                <td  style="padding-top:15px;">
                            <center>
                                <span style="color: #2D3538;	font-size: 22px;"> Building Code Implementation Program in Nepal 
                                    &nbsp;(BCIPN)</span>
                            </center>

                            </td>
                            <td style="text-align:right" rowspan="2">
                                <img src="../img/usaid-.png"  width="" height="" style="padding-top:3px"/>  
                            </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: bottom;text-align: center" >
                            <center>
                                <span> 
                                    <ul class="nav" style="margin-left:85px;border-top:1px solid #888;margin-bottom:-20px;background:transparent;color:black" >
                                        <li ><a style="background:transparent" class="text-info" href="../Home/home"><i class="icon-home"></i> Home</a></li>
                                        <li><a style="background:transparent" href="../Home/people"><i class="icon-user"></i> People </a></li>
                                        <li><a style="background:transparent" href="../Home/course"><i class="icon-book"></i> Course </a></li>
                                        <li><a style="background:transparent" href="../Home/event"><i class="icon-globe"></i> Events </a></li>
                                        <li><a style="background:transparent" href="../Home/report"><i class="icon-bar-chart"></i> Reports</a></li>
                                        <li><a style="background:transparent" href="../Home/logout"><i class="icon-leaf"></i> Users</a></li>
                                        <li><a style="background:transparent" href="../Home/logout"><i class="icon-leaf"></i> Cost sharing</a></li>
                                        <!-- 
                                                                                <li><a style="background:transparent" href="../Home/logout"><i class="icon-leaf"></i> Logout</a></li> -->
                                    </ul>
                                </span>
                            </center>

                            </td>
                            </tr>
                        </table>



                        <!--
                        <ul class="nav pull-right">
                            <li><a href="#"><i class="icon-leaf"></i> View Table Data</a></li>

                        </ul>
                        -->
                    </div> <!-- end of navbar-inner tag-->
                </div> <!-- end of nav bar tag-->
            </div> <!-- end of span12 tag-->
        </div> <!-- end of row tag-->
    </div> <!-- end of container tag-->
</div> <!-- end of navigation tag-->

<div style="height:5px; background:#052774;position:relative">



    <div style="height:55px;width:500px;position:fixed;left:-484px; margin-top:5px" class="table_a">
        <table style="width:500px;height:55px">
            <tr>
                <td style="background:#ccc;">

                    <table class="dataListing" width="100%" cellspacing="0" cellpadding="5" border="0">
                        <tbody>
                            <tr>
                                <th width="5%" align="center">#</th>
                                <th width="20%" align="left">Name</th>
                                <th width="20%" align="left">User Name</th>
                                <th width="20%" align="left">Logged in as</th>
                                <th width="25%" align="left">Previous login</th>
                            </tr>
                            <tr>
                                <td align="center">1</td>
                                <td align="left"><?= $this->session->userdata('fullname') ?></td>
                                <td align="left"><?= $this->session->userdata('username') ?></td>
                                <td align="left"><?= $this->session->userdata('role') ?></td>
                                <td align="left"><?= $this->session->userdata('prevlogin') ?></td>
                            </tr>
                        </tbody>
                    </table>



                </td>
                <td  style="width:16px; border-bottom-right-radius: 10px; border-top-right-radius: 10px; color:#fff" class="btn-info right_a"><img class="table_img_a" src="../img/arrow_rt.png"  style="margin:0;padding:0"/></td>
            </tr>
        </table>
    </div>
</div>
