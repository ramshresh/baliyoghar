 <?php
    if (!$this->session->userdata('username')) {
        redirect('Home/login', 'refresh');
    }
    ?>

<html>
    <head>
        
    </head>
    <body>
<!--div id="chart1" style="height:400px;width:300px; "></div-->
        <div class="container">

            
            <center>
            <div class="message-error" style="padding:50px;">
                <b class="text-error">
                    Please login first.
                </b>
            </div>
            </center>
            
            
        </div> <!-- end of container tag-->

        
</body>
</html>
