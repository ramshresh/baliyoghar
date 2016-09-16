<div class="container">

    <table style="border:1px solid #CCC;margin-top:30px;margin-bottom:30px;" width="100%" >
        <tr>
            <td style="padding:20px;">

                <form action="../Home/saveHelp" method="post">
                    <p>
                        <label for="editor1">
                            HELP CONTENT : 
                        </label>
                        <textarea style="line-height: 5px" value="" class="ckeditor" cols="80" placeholder ="Write help content ... " id="editor1" name="help_content" rows="10">
                        
                            <?php
                            if (isset($helpcontent)) {
                                echo $helpcontent;
                            }
                            ?>
                        
                        </textarea>
                    </p>
                    <p>
                        <input type="submit" value="Submit">
                    </p>
                </form>
            </td>
        </tr>

    </table>
</div> <!-- end of container tag-->






