<div class="container">

    <!-- Row start -->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <i class="icon-calendar"></i>
                    <h1 class="panel-title"><strong><?php echo APP_NAME; ?>:</strong></h1>
                </div>

                <div class="panel-body">

                    <?php
                    $attributes = array('id' => 'search_form');
                    echo form_open('search/search_experts', $attributes); ?>

                    <div class="form-horizontal">
                        <p style="font-color:#000;padding:1em;background-color:#f7f7f7;"><?php echo APP_NAME; ?> is a searchable electronic database that includes research experience and expertise of faculty at CSULB. The purpose of the FREE is to foster research collaborations and partnerships among faculty at CSULB, colleagues at other educational institutions, industry partners, and government agencies. </p>
                        <div class="row">
                            <div class="col-lg-6"><a href="#" id="howlink" style="text-decoration: none;"> <i class="fa fa-question-circle fa-3" aria-hidden="true" id="how-icon"></i>How to search FREE</a></div><div class="clearfix"></div>
                                
                            <div id="how">
                        
                        
                        <div class="col-lg-12"><p style="font-color:#000;padding:1em;background-color:#f7f7f7;margin-bottom:2em;">You can search faculty research profiles by using research experience
                            or expertise keywords. Alternatively, you can search for a particular faculty member’s
                            research profile by entering his or her name. <a href="#" id="close-how"><i
                                    class="fa fa-times-circle" aria-hidden="true"
                                    style="padding-right:.35em;"></i>Close</a></p></div></div>
                                    <div class="clearfix"></div>
                                <div class="form-group" id="searchkeywords">
                                    <label for="keywords" class="col-md-3 control-label" id="ksearch">Keyword Search:</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control mega" id="keywords"
                                               placeholder="Enter key word(s) " name="keywords">
                                    </div>

                                </div>
                            <div class="col-md-6" id="ref-plus">
                                <p class="col-lg-10" style="margin-top:2em;"><a href="#" class="btn btn-default btn-sm" id="plus-search" aria-expanded="false" aria-describedby="ref-text" >
                                    <span class="glyphicon glyphicon-plus" id="ref-button"><span class="sr-only">Plus</span></span>
                                </a><span id="ref-text"> Search by Name, College, or Department:</span>

                                </p></div>
                        </div>

                            <div class="row center-block " id="refined">
                                <div class="col-lg-10">
                                    <div class="form-group">
                                        <label for="inputLast" class="col-md-3 control-label">Last Name:</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="inputLast"
                                                   placeholder="Last Name" name="lastname">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputFirst" class="col-md-3 control-label">First Name:</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="inputFirst"
                                                   placeholder="First Name" name="firstname">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDiv" class="col-md-3 control-label">College:</label>
                                        <div class="col-md-6" id="selectdiv">
                                            <?php echo "<select class='form-control' id='inputDiv' name='division'>";
                                            echo "<option value='0'>[Select one or more]</option>";

                                            if (count($division)) {

                                                foreach ($division as $row) {
                                                    echo "<option value='" . $row['SHORT_CODE'] . "'>" . $row['DESCRIPTION'] . "</option>";
                                                }

                                            }
                                            echo "</select>"; ?>
                                        </div>
                                    </div>
                                    <div id="deptsdisplay">


                                    </div>

                                </div>


                            </div>



                        <div class="row">
                            <div class="col-md-6">


                            </div>

                        </div>




                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group" id="form-buttons">
                                <button type="submit" class="btn btn-info" title="Search" id="pad-sub">Search
                                </button>
                                <button type="reset" value="Reset" class="btn btn-default" id="resetall">Reset</button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                    
                    
                    

                    <div class="clearfix"></div>

                </div>

            </div>
        </div>
    </div>
    <div id="details">


    </div>
    <div class="modal fade" id="no-records">
  <div class="modal-dialog" role="alert box" aria-labelledby="no-records" aria-describedby="records">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="records">No records found:</h5>
        
      </div>
      <div class="modal-body">
        <p>Try again.</p>
      </div>
      <div class="modal-footer">
        
        <button type="button" id="norecordsclose" class="btn btn-secondary" data-dismiss="modal" id="sub-cancel">OK</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="empty">
  <div class="modal-dialog" role="alert box" aria-labelledby="empty" aria-describedby="nothin">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nothin">No Records Found</h5>
        
      </div>
      <div class="modal-body">
        <p>Please use at least one search field.</p>
      </div>
      <div class="modal-footer">
        
        <button type="button" id="emptyclose" class="btn btn-secondary" data-dismiss="modal" id="sub-cancel">OK</button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Row end -->
