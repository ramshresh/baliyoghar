<style type="text/css">
    .orgtitle {
        margin: 1em 0 0.5em 0;
        display: block;
        color: #343434;
        font-weight: normal;
        font-family: 'Ultra', sans-serif;
        font-size: 36px;
        line-height: 42px;
        text-transform: uppercase;
        text-shadow: 0 2px #475E9E, 0 3px #777;
    }
    .curve2{margin-top:-4px;width:220px;height:15px;background: url('../img/curve2.png') no-repeat;}
    .curve1{width:100px;height:99px;background:url('../img/curve1.png');float:left}
    .curve{background:url('../img/curve.png');float:left;width:100px;height:99px}
    .upperdiv{width:320px;height:99px;background:#EBE7E7;float:left;color:#5ABFDD}
    .lowerdiv{width:220px;height:98px;background:#EBE7E7;float:left;border-top:1px solid #ccc;color:#2F96B4}
    ul.adminmenu{list-style: none;}

    /* Main */
    #menu {
        width: 100%;
        margin: 0;
        padding: 10px 0 0 0;
        list-style: none;
        background-color: #111;
        background-image: linear-gradient(#444, #111);
        border-radius: 50px;
        box-shadow: 0 2px 1px #9c9c9c;
    }

    #menu li {
        float: left;
        padding: 0 0 10px 0;
        position: relative;
    }

    #menu a {
        float: left;
        height: 25px;
        padding: 0 25px;
        color: #999;
        text-transform: uppercase;
        font: bold 12px/25px Arial, Helvetica;
        text-decoration: none;
        text-shadow: 0 1px 0 #000;
    }

    #menu li:hover > a {
        color: #fafafa;
    }

    *html #menu li a:hover { /* IE6 */
        color: #fafafa;
    }

    #menu li:hover > ul {
        display: block;
    }

    /* Sub-menu */
    #menu ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: none;
        position: absolute;
        top: 35px;
        left: 0;
        z-index: 99999;
        background-color: #444;
        background-image: linear-gradient(#444, #111);
        -moz-border-radius: 5px;
        border-radius: 5px;
    }

    #menu ul li {
        float: none;
        margin: 0;
        padding: 0;
        display: block;
        box-shadow: 0 1px 0 #111111,
        0 2px 0 #777777;
    }

    #menu ul li:last-child {
        box-shadow: none;
    }

    #menu ul a {
        padding: 10px;
        height: auto;
        line-height: 1;
        display: block;
        white-space: nowrap;
        float: none;
        text-transform: none;
    }

    *html #menu ul a { /* IE6 */
        height: 10px;
        width: 150px;
    }

    *:first-child+html #menu ul a { /* IE7 */
        height: 10px;
        width: 150px;
    }

    #menu ul a:hover {
        background-color: #0186ba;
        background-image: linear-gradient(#04acec, #0186ba);
    }

    #menu ul li:first-child a {
        border-radius: 5px 5px 0 0;
    }

    #menu ul li:first-child a:after {
        content: '';
        position: absolute;
        left: 30px;
        top: -8px;
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 8px solid #444;
    }

    #menu ul li:first-child a:hover:after {
        border-bottom-color: #04acec;
    }

    #menu ul li:last-child a {
        border-radius: 0 0 5px 5px;
    }

    /* Clear floated elements */
    #menu:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0;
    }

    * html #menu             { zoom: 1; } /* IE6 */
    *:first-child+html #menu { zoom: 1; } /* IE7 */

</style>

<!-- Top Nav Bar Menu -->
<style>
    .banner-top-full {
        background: #fff url('../img/mask2.png');
        margin-bottom: 5px;
        border-bottom: 2px solid #005580;
        border-top: 2px solid #005580;
    }

    #menu {
        width: 100%;
        margin: 0;
        padding: 0 0 0 0;
        list-style: none;
        background-color: #005580;
        background-image: linear-gradient(#005580, #111);
        /*border-radius: 20px;*/
        box-shadow: 0 2px 1px #9c9c9c;
    }

    #menu li {
        float: left;
        padding: 0 0 10px 0;
        position: relative;
    }

    #menu a {
        float: left;
        height: 25px;
        padding: 0 25px;
        color: #999;
        text-transform: uppercase;
        font: bold 12px/25px Arial, Helvetica;
        text-decoration: none;
        text-shadow: 0 1px 0 #000;

        cursor: pointer;
        -webkit-transition: all 150ms ease;
        transition: all 150ms ease;
    }

    #menu li:hover > a {
        color: #fafafa;
        box-shadow: 0 1px 0 #000000, 0 2px 0 #003149, 0 2px 2px rgba(0, 69, 128, 0.9);
        -webkit-transform: translateY(3px);
        transform: translateY(3px);
        -webkit-animation: pulsate 1.2s linear infinite;
        animation: none;
    }

    * html #menu li a:hover { /* IE6 */
        color: #fafafa;
    }

    #menu li:hover > ul {
        display: block;
    }

    /* Sub-menu */
    #menu ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: none;
        position: absolute;
        top: 35px;
        left: 0;
        z-index: 99999;
        background-color: #005580;
        background-image: linear-gradient(#005580, #111);
        -moz-border-radius: 5px;
        border-radius: 5px;
    }

    #menu ul li {
        float: none;
        margin: 0;
        padding: 0;
        display: block;
        box-shadow: 0 1px 0 #111111,
        0 2px 0 #777777;
    }

    #menu ul li:last-child {
        box-shadow: none;
    }

    #menu ul a {
        padding: 10px;
        height: auto;
        line-height: 1;
        display: block;
        white-space: nowrap;
        float: none;
        text-transform: none;
    }

    * html #menu ul a { /* IE6 */
        height: 10px;
        width: 150px;
    }

    *:first-child + html #menu ul a { /* IE7 */
        height: 10px;
        width: 150px;
    }

    #menu ul a:hover {
        background-color: #000000;
        /*background-image: linear-gradient(#04acec, #000000);*/
        background-image: linear-gradient(#04acec, #000000);
    }

    #menu ul li:first-child a {
        border-radius: 5px 5px 0 0;
    }

    #menu ul li:first-child a:after {
        content: '';
        position: absolute;
        left: 30px;
        top: -8px;
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 8px solid #005580;
    }

    .nav-pills > li:hover, .nav-pills > li > a:hover{
        background-color: #000000;

    }

    #menu ul li a:hover:after {
        border-bottom-color: #000000;
    }

    #menu ul li:first-child a:hover:after {
        border-bottom-color: #000000;
    }

    #menu ul li:last-child a {
        border-radius: 0 0 5px 5px;
    }

    /* Clear floated elements */
    #menu:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0;
    }

    * html #menu {
        zoom: 1;
    }

    /* IE6 */
    *:first-child + html #menu {
        zoom: 1;
    }

    /* IE7 */
</style>
<script type="text/javascript">
    $(document).ready(function(){
        //#EBE7E7
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
<div style="text-align: center">

    <!-- Top Banner -->
    <div class="banner-top-full">
        <div class="container">
            <div class="row" style="padding-bottom:0;margin-bottom:0;">
                <div class="span12">
                    <div class="navbar">
                        <div class="navbar-inner"
                             style="background:transparent; filter: none;border-radius: 0px; background-image: none; border: none;box-shadow: none;">
                            <table border="0" width="100%" style="background:transparent">
                                <tr>
                                    <td rowspan="2" style="padding-top:5px; text-align: left;width: 33%;">
                                        <img src="../img/usaid.png"  style="float:left;background:transparent"/>
                                    </td>
                                    <td rowspan="2" style="padding-top:15px; text-align: center;width: 33%;">
                                    <span style="color: #005580;text-shadow:1px 1px 2px rgba(0,0,0,0.5);font-size: 22px;">
                                        Baliyo Ghar Program
                                    </span>
                                    </td>
                                    <td rowspan="2" style="text-align:right;width: 33%;">
                                        <img src="../img/nsetlogo.png")}}   style="padding-top:3px"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: bottom;text-align: center"></td>
                                </tr>
                            </table>
                        </div> <!-- end of navbar-inner tag-->
                    </div> <!-- end of nav bar tag-->
                </div> <!-- end of span12 tag-->
            </div> <!-- end of row tag-->
        </div> <!-- end of container tag-->
    </div> <!-- end of navigation tag-->
    <!-- end of : Top Banner -->

</div>
<ul id="menu">
    <li><a href="../Home/home">Home</a></li>
    <li>
        <a href="#">Baliyo Ghar Units</a>
        <ul>
            <li><a href="#">Teams</a></li>
            <li><a href="#">+Add Reconstruction Technology Center</a></li>
            <li><a href="#">+Add Mobile Teams</a></li>
            <li><a href="#">Staff Deployments</a></li>
            <li><a href="#">+Add Staff</a></li>
        </ul>
    </li>
    <li>
        <a href="#">Program Area</a>
        <ul>
            <li><a href="#">Program Coverages</a></li>
            <li><a href="#">+Add District</a></li>
            <li><a href="#">+Add VDCs</a></li>
            <li><a href="#">Team Deployments</a></li>
        </ul>
    </li>
    <li>
        <a href="../Home/course">Activities</a>
        <ul>
            <li><a href="../Home/newevents">+Add Events</a></li>
            <li><a href="../Home/event">View Events</a></li>
            <li><a href="../Home/course">Master Event</a></li>
        </ul>
    </li>
    <li><a href="../Home/people">People</a></li>
    <li><a href="#">Report</a>
        <ul>
            <li><a href="../Report/peoplereport">By People</a></li>
            <li><a href="../Report/castereport">By Caste</a></li>
            <li><a href="../Report/coveragereport">By Coverage</a></li>
            <li><a href="../Report/agereport">By Age</a></li>
            <li><a href="../Report/summaryreport">Summary Report</a></li>
        </ul>
    </li>

    <li><a href="#">Map</a>
        <ul>
            <li><a href="../Map/coverages">Program Area</a></li>
            <li><a href="../Map/events">Events</a></li>
        </ul>
    </li>

    <?php if ($this->session->userdata('role') == 'superadmin') { ?>
    <li><a href="#">Admin</a>
        <ul>
            <li><a href="../Home/costSharing">Cost Sharing</a></li>
            <li><a href="../Home/eventOrganizer">Organiser Entry</a></li>
            <li><a href="../Home/newcourses">Event Entry</a></li>
            <li><a href="../Home/newCoverage">Coverage Entry</a></li>
        </ul>
    </li>
    <?php } ?>
</ul>

<div style="height:55px;width:500px;position:fixed;left:-484px; margin-top:0px;z-index:100" class="table_a">
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
                            <th rowspan="2" class="uppercase nicefont size11">
                                <a style="background:transparent" href="../Home/logout"><i class="icon-leaf"></i> Logout</a>    
                            </th>
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
    <?php if ($this->session->userdata('role') == 'superadmin') { ?>
        <div class="upperdiv">
            <div style="padding:10px 0 0 20px;">
                <img src="../img/cms.png" />
                <h5 class="inline-block">Superadmin control Panel </h5>
                <!--hr style="background:url('../img/hr.jpg');margin:5px 0 5px 0" /-->
                <ul class="adminmenu">
                    <li class="nicefont uppercase size11"><b class="icon-picasa"></b><a href="../Home/sliderManager"> manage gallery(slider)</a></li>
                    <li class="nicefont uppercase size11"><b class="icon-picasa"></b><a href="../Home/help"> manage help content</a></li>
                </ul>
            </div> 
        </div>
        <div class="curve">
        </div>
        <div style="clear:both"></div>
        <div class="lowerdiv">
            <div style="padding:3px 0 0 20px ;">
                <ul class="adminmenu">
                    <li class="nicefont size11"><b class="icon-wrench"></b> <a href="../Control/dc">Manage Deleted Course <?php if (isset($deleted_count)) echo '(' . $deleted_count[2] . '/' . $deleted_count[3] . ')'; ?></a></li>
                    <li class="nicefont size11"><b class="icon-wrench"></b> <a href="../Control/de">Manage Deleted Events <?php if (isset($deleted_count)) echo '(' . $deleted_count[1] . ')'; ?></a></li>
                    <li class="nicefont size11"><b class="icon-wrench"></b> <a href="../Control/dp">Manage Deleted People <?php if (isset($deleted_count)) echo '(' . $deleted_count[0] . ')'; ?></a></li>
                    <li class="nicefont size11"><b class="icon-wrench"></b> <a href="../Home/userManagement">Manage user </a> </li>
                </ul>
            </div>
        </div>
        <div class="curve1">
        </div>
        <div style="clear:both"></div>
        <div class="curve2">
        </div>
    <?php } ?>
</div>

