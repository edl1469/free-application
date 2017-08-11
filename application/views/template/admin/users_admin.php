
<div class="row">
    <div class="container"><h1 style="margin-left: 20px;">Users</h1>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix" >

                    
                    <div class="col-lg-6">
                        <label for="division">Select College:</label>
                        <select name="divisions" style="padding:10px;" id="division">
                            <option value="" selected>Select College / Division</option>
                            <?php foreach ($divisions as $row) {
                                echo '<option value="' . $row['SHORT_CODE'] . '">' . $row['DESCRIPTION'] . '</option>';
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <div id="div_results">
                    <div id="division_results"></div>

                </div>
            </div>
        </div>
    </div>

