 
<!DOCTYPE HTML>

<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>BALIYOGHAR</title>
        <meta name="author" content="BALIYOGHAR">


        <script type="text/javascript" src="../js/modernizr.custom.28468.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/jquery-1.9.1.js"></script>
        <!--script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js" ></script-->
        <script type="text/javascript" src="../js/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="../js/validate.js"></script>
        <!--script type="text/javascript" src="../../js/jquery.maskedinput.js"></script-->
        <script type="text/javascript" src="../js/script.js"></script>


        <script src="../js/jquery-1.9.1.js"></script>
        <script src="../js/datepicker/jquery.ui.core.js"></script>
        <script src="../js/datepicker/jquery.ui.widget.js"></script>
        <script src="../js/datepicker/jquery.ui.datepicker.js"></script>



        <!--
        <link href='http://fonts.googleapis.com/css?family=Economica:700,400italic' rel='stylesheet' type='text/css'>
        -->
        <link rel="stylesheet" href="../css/base/jquery.ui.all.css">
        <link rel="icon" href="../img/favicon.jpg" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="../css/slider.css" />
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="../css/font-awesome.css"/>
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
        <link rel="stylesheet" type="text/css" href="../css/inline.css"/>
        <link rel="stylesheet" type="text/css" href="../css/basic.css"/>
        <!-- Files for charts  -->
        <script type="text/javascript" src="../js/plugins/jquery.jqplot.min.js"></script>
        <script type="text/javascript" src="../js/plugins/jqplot.barRenderer.js"></script>
        <script type="text/javascript" src="../js/plugins/jqplot.pieRenderer.min.js"></script>
        <script type="text/javascript" src="../js/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script type="text/javascript" src="../js/plugins/jqplot.pointLabels.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/plugins/jquery.jqplot.min.css" />

        <!-- end files for charts -->
        <script type="text/javascript">
            $(function() {
                $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
            });
            
        </script> 

        <style type="text/css">
            label.error{
                color:#B94A48;
            }
        </style>


    </head>
    <body>

      <!-------------------------------------header end -------------------------------------------------------->
      
      
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
<div class="navigation" style="background:#000;margin-bottom:0px">
    <div class="container" style="">
        <div class="row" style="padding-bottom:0;margin-bottom:0;">
            <div class="span12" >
                <div class="navbar" >
                    <div class="navbar-inner" style="background:transparent;">
                        <table border="0" width="100%" style="background:transparent">
                            <tr>
                                <td rowspan="2" style="padding-top:5px">
<!--                                    <img src="../img/usaid.png"  style="float:left;background:transparent"/>-->
                                </td>
                                <td  style="padding-top:15px;">
                            <center>
                                <span style="color: #FFFFFF;text-shadow:1px 1px 2px rgba(0,0,0,0.5);font-size: 22px;"> Baliyo Ghar </span>
                            </center>

                            </td>
                            <td style="text-align:right" rowspan="2">
<!--                                <img src="../img/nsetlogo.png"  width="" height="" style="padding-top:3px"/>  -->
                            </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: bottom;text-align: center" >
                            <center>
                                
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


<?php

if(isset($_GET['e']) && $_GET['e']=='1') {
echo '<center><div class="message-error">
    <span class="text-error"><b>Combination of username and password is incorrect.</b></span>
</div></center>';
  }
  

if(isset($_GET['l']) && $_GET['l']=='1') {
echo '<center><div class="message-success">
    <span class="text-success"><b>You have been logged out successfully</b></span>
</div></center>';
  }
  
  ?>
        
        <!-------------------------------------------------------------NAV end ---------------------------------->
        
        
        
        <!--div id="chart1" style="height:400px;width:300px; "></div-->
        <div class="container">

            <div class="row">
                <div class="span5 offset3">

                    <div class="loginBox">
                        <div class="title">Log in to your account</div>

                         <?php echo form_open('/Home/home'); ?>
                            <div class="control-group">
                                <div class="controls">
                                    <label>Username</label>
                                    <input type="text" name="username" REQUIRED placeholder="Type here..."/>
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="controls">
                                    <label>Password</label>
                                    <input type="password" name="password"  REQUIRED placeholder="Type here..."/>
                                </div>
                            </div>



                            <div class="control-group">
                                <div class="controls">
                                    <button class="btn btn-info">Sign In</button> 
                                    <input type="reset" class="btn" value="Reset"/>
                                </div>
                            </div>

                            <br/>

<!--                            <a href="#">Forgot password?</a>-->

                        </form>

                    </div> <!-- end of login box div tag--> <br/>



                </div> <!-- end of span5 tag-->
            </div> <!-- end of row tag-->



        </div> <!-- end of container tag-->

        
</body>
</html>