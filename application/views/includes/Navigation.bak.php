<style type="text/css">
    .orgtitle {
        margin: 1em 0 0.5em 0;
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
</style>

<!-- Top Nav Bar Menu -->
<style>
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
<div class="navigation" style="background:#6F8A6E;margin-bottom:0px;min-width:960px">
    <div class="container" style="">
        <div class="row" style="padding-bottom:0;margin-bottom:0;min-width:960px">
            <div class="span12" >
                <div class="navbar" >
                    <div class="navbar-inner" style="background:transparent;">
                        <table border="0" width="100%" style="background:transparent">
                            <tr>
                                <td rowspan="2" style="padding-top:5px">
                                    <img src="../img/logo.png"  style="float:left;background:transparent"/>
                                </td>
                                <td  style="padding-top:15px;">
                            <center>
                                <span class="orgtitle">Baliyo Ghar Program
                                    &nbsp;(NSET)</span>
                            </center>
                            </td>
                            <td style="text-align:right" rowspan="2">
                                <img src="../img/logo.png"   style="padding-top:3px"/>
                            </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: bottom;text-align: center" >
                                <span style="margin-left:150px;display:block">
                                    <ul id="navigation" class="nav-main">
                                        <li><a href="../Home/home" class="icon-home">Home</a></li>

                                        <li class="list"><a href="../Home/course" class="icon-book">Events</a>
                                            <ul class="nav-sub">
                                                <li><a href="../Home/newevents">+Add Event</a></li>
                                                <li><a href="../Home/event">View Events</a></li>
                                                <li><a href="../Home/course">Master Event</a></li>
                                            </ul>
                                        </li>

                                        <li><a href="../Home/people" class="icon-user">People</a></li>

                                        <li class="list"><a href="#" class="icon-bar-chart">Report</a>
                                            <ul class="nav-sub">
                                                <li><a href="../Report/peoplereport">By People</a></li>
                                                <li><a href="../Report/beneficiaryreport">By Beneficiary Type</a></li>
                                                <li><a href="../Report/coveragereport">By Coverage</a></li>
                                                <li><a href="../Report/agereport">By age</a></li>
                                                <li><a href="../Report/summaryreport">Summary Report</a></li>
                                            </ul>
                                        </li>

                                        <?php if ($this->session->userdata('role') == 'superadmin') { ?>
                                            <li class="list"><a href="#">Admin</a>
                                                <ul class="nav-sub">
                                                    <li><a href="../Home/costSharing">Cost Sharing</a></li>
                                                    <li><a href="../Home/eventOrganizer">Organiser Entry</a></li>
                                                    <li><a href="../Home/newcourses">Event Entry</a></li>
                                                    <li><a href="../Home/newCoverage">Coverage Entry</a></li>
                                                </ul>
                                            </li>
                                        <?php } ?>

                                    </ul>

                                    <!--                                    <ul class="nav" style="border-top:1px solid #888;margin-bottom:-20px;background:transparent;color:black;" >-->
<!--                                        <li ><a rel="tooltip" data-original-title="gopal" style="background:transparent" class="text-info" href="../Home/home"><i class="icon-home"></i> Home</a></li>-->
<!---->
<!--                                        <li onmouseover="$('.submenucourse').show()" style="position:relative" onmouseout="$('.submenucourse').hide()">-->
<!--                                            <a style="background:transparent" href="../Home/course"><i class="icon-book"></i> Event <i class="caret"></i></a>-->
<!--                                            <ul class="submenucourse submenus w150 mlneg25" style="display:none;position:absolute">-->
<!--                                                   <li> <a style="background:transparent" href="../Home/newevents"> +Add event </a> </li>-->
<!--                                                <li> <a style="background:transparent" href="../Home/event"> View events </a> </li>-->
<!--                                                <li> <a style="background:transparent" href="../Home/course"> Master event </a> </li>-->
<!--                                            </ul>-->
<!--                                        </li>-->
<!--                                      -->
<!--                                        <li><a style="background:transparent" href="../Home/people"><i class="icon-user"></i> People </a></li>-->
<!---->
<!--                                        <li onmouseover="$('.submenureport').show()" style="position:relative" onmouseout="$('.submenureport').hide()">-->
<!--                                            <a style="background:transparent;" href="#" ><i class="icon-bar-chart"></i> Reports <i class="caret"></i></a>-->
<!--                                            <ul class="submenureport submenus w150 mlneg25" style="display:none;position:absolute">-->
<!--                                                <li> <a style="background:transparent" href="../Report/peoplereport"> By people </a> </li>-->
<!--                                                <li> <a style="background:transparent" href="../Report/coveragereport"> By coverage </a> </li>-->
<!--                                                <li> <a style="background:transparent" href="../Report/agereport"> By age </a> </li>-->
<!--                                                <li> <a style="background:transparent" href="../Report/Summaryreport"> Summary report </a> </li>-->
<!--                                            </ul>-->
<!--                                        </li>-->
<!--                                        -->
<!--                                            --><?php //if ($this->session->userdata('role') == 'superadmin') { ?>
<!--                                        <li onmouseover="$('.submenuadmin').show()" style="position:relative" onmouseout="$('.submenuadmin').hide()">-->
<!--                                            <a style="background:transparent;" href="#" ><i class="icon-bar-chart"></i> Admin <i class="caret"></i></a>-->
<!--                                            <ul class="submenuadmin submenus w150 mlneg25" style="display:none;position:absolute">-->
<!--                                                <li> <a style="background:transparent" href="../Home/costSharing">Cost sharing </a> </li>-->
<!--                                                <li> <a style="background:transparent" href="../Home/eventOrganizer"> Organizer entry </a> </li>-->
<!--                                                <li> <a style="background:transparent" href="../Home/newcourses"> Event entry </a> </li>-->
<!--                                                <li> <a style="background:transparent" href="../Home/newCoverage"> Coverage entry </a> </li>-->
<!--                                            </ul>-->
<!--                                        </li>-->
<!--                                        --><?php //} ?>
<!--                                   </ul>-->
                                </span>

                            </td>
                            </tr>
                        </table>



                    </div> <!-- end of navbar-inner tag-->
                </div> <!-- end of nav bar tag-->
            </div> <!-- end of span12 tag-->
        </div> <!-- end of row tag-->
    </div> <!-- end of container tag-->
</div> <!-- end of navigation tag-->


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

