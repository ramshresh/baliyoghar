<?php
if (!$this->session->userdata('username')) {
    redirect('Home/login', 'refresh');
}
?>
<!DOCTYPE HTML>

<html lang="en">
    <head>
        <!--meta name="viewport" content="width=device-width, initial-scale=1.0"-->
        <meta name="author" content="Gaurab Dahal">
        <meta name="description" content="Building code implementation project in nepal.">
        <meta name="keywords" content="Earthquake training, INGO, Pathways, IT, Webpages">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?php if(isset($pagetitle)) echo $pagetitle; else echo 'BCIPN'; ?></title>
        <meta name="author" content="BCPIN">

        <script type="text/javascript" src="../js/modernizr.custom.28468.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/jquery-1.9.1.js"></script>
        <!--script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js" ></script-->
        <script type="text/javascript" src="../js/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="../js/validate.js"></script>
        <!--script type="text/javascript" src="../../js/jquery.maskedinput.js"></script-->
        <script type="text/javascript" src="../js/script.js"></script>


        <!--script src="../js/jquery-1.9.1.js"></script-->
        <script src="../js/datepicker/jquery.ui.core.js"></script>
        <script src="../js/datepicker/jquery.ui.widget.js"></script>
        <script src="../js/datepicker/jquery.ui.datepicker.js"></script>

        <!--nepali date >
        <script type="text/javascript" src="../js/nepalidate/jquery.js"></script>
        <script type="text/javascript" src="../js/nepalidate/nepali.datepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="../js/nepalidate/nepali.datepicker.css" />
        <!-- end nepali date -->




        <!-- ck editor -->
        <script src="../ckeditor/ckeditor.js"></script>
        <!--link rel="stylesheet" href="sample.css"-->
        <!--end ck editor -->

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

        <!-- slider -->
        <link rel="stylesheet" type="text/css" href="../slider/engine/style.css" />
        <!--end slider -->
        <script type="text/javascript">
            
            $(function() {
                $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
            });
            /* 
            $(document).ready(function(){
                $('.nepali-calendar').nepaliDatePicker();
            });
             */
        </script> 

        <style type="text/css">
            label.error{
                color:#B94A48;
            }
        </style>
    </head>
    <body style="min-width:1170px;display: block">