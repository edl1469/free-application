<body>

<div class="row-fluid">

    <div class="container" id="facpro">


        <div class="col-md-6"><h1>Faculty Profile<span id="editmode" tabindex="0">[Edit Mode]</span><span id="main-edit"><a href="#" id="edit_profile" alt="Edit Expert Profile"><i
                        class="fa fa-pencil"><span id="edit_link">[EDIT]</span></i></a></span></h1></div>
<div class="clearfix"></div>
    </div>

    <div class="container top-pad alert-success" id="sub-data-canceled"><strong>Your changes have been
            canceled.</strong>
    </div>

    <div class="container top-pad alert-success" id="sub-data-submitted"><strong>Your information has been submitted for
            approval. You will receive an email once the changes have been approved.</strong></div>


    <!-- .block_head ends -->
    <div class="boxit">


        <form id="profile">
            <?php foreach ($records as $rec) {


            $pnumber = $rec['PHONE'];
            if ($pnumber && strlen($pnumber == 5)) {
                $newnumber = explode('5', $pnumber, 2);
                $first = '(562) 985-' . $newnumber[0];
                $last = $newnumber[1];
                $displaynumber = $first . $last;
            } else {
                $displaynumber = '';
            }
            
            ?>
            <?php 
                $main_title = '';
                $disable = '';
                $preferred_title = $rec['PREFERRED_TITLE'];
                $change_req = '';
                $main_title = (!empty($rec['TEMP_TITLE'])) ? $rec['TEMP_TITLE'] : $rec['TITLE'];
                if (!empty($preferred_title)){
                    $main_title = $preferred_title;
                }
                if ($rec['TITLE'] == 'Pending Approval'){
                    $change_req = '- Title Change Requested - Pending Approval';
                    $disable = 'readonly';
                }
                ?>

            <div class="col-md-6 well " id="well-profile">
                <div class="pull-right" style="text-align:right;font-size:24px;"><a href="#" id="help" data-toggle="modal" data-target="#dialog"><span class="sr-only">Help</span><i class="fa fa-question-circle" aria-hidden="true"><span class="sr-only">-opens dialog</span></a></i></div>
                    
                    <!-- Modal -->
  <div class="clearfix"></div>
<div class="modal fade" id="dialog" role="dialog" aria-labelledby="pdata" aria-describedby="instructions" aria-modal="true">
    
    
      <!-- Modal content-->
      <div class="modal-content" >
        <div class="modal-header">
          <button type="button" tabindex="-1" class="close" data-dismiss="modal" title="Close" id="close-help">&times;</button>
          <h4 class="modal-title" style="font-weight: bold;font-size: 1.5em;"  id="pdata">Profile Data</h4>
        </div>
        <div class="modal-body" id="instructions">
          <p>To update your first and/or last name, please click this link for <a href="https://itkb.csulb.edu/x/J4B9" target="_blank">instructions</a>.  To update your College, Department, or Telephone information, please contact your <a href="https://daf.csulb.edu/employees/asms.html" target="_blank">Administrative Services Manager (ASM)</a>.</p></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" tabindex="0" >Close</button>
        </div>
      </div>
      
   
  </div>
                  
                <p class="details"><strong>First Name:</strong><span><?php echo $rec['FIRSTNAME'] ?></span></p>

                <p class="details"><strong>Last Name:</strong><span><?php echo $rec['LASTNAME'] ?></span></p>

                <p class="details"><strong>College:</strong><span><?php echo $rec['DIVISION'] ?></span></p>

                <p class="details"><strong>Department:</strong><span><?php echo $rec['DEPARTMENT'] ?></span></p>

                <p class="details"><strong>Telephone:</strong><span><?php echo $displaynumber ?></span></p>
            
            </div>
            <div class="col-md-6">
            <div class="col-md-12 editbox">
            <div class="form-group col-md-12 ">

                <label for="expert-title" class="control-label">Title:</label>
                
                <div class="showtext" ><?php echo $main_title ?></div>
                <input type="text" tabindex="0" class="form-control init-hide" id="expert-title" name="title"
                       value="<?php echo $main_title ?><?php echo $change_req ?>" <?php echo $disable ?> >

            </div>
            <div class="form-group col-md-12 ">

            	
                <label for="email-list" class="control-label ">Email Address:</label><span class="hint">(Select your preferred contact email.)</span>
                
                <select name="email" tabindex="0" class="form-control init-hide" id="email-list" >
                    <?php
                    $main_email = $rec['PRIMARY_EMAIL'];
                    $primary = '';

                    
                    	$primary = '<option value="'.$main_email.'" selected="selected">'.$main_email.'</option>';

                    	echo $primary;
                    ?>
                    

                    <?php
                    $another_email = '';
                    $reg_email = '';
                    
                    if ($rec['PREFERRED_EMAIL'] != $rec['EMAIL'] && $rec['PREFERRED_EMAIL'] != $rec['PRIMARY_EMAIL'] ) {
                        
                        $another_email = '<option value="' . $rec['PREFERRED_EMAIL'] . '">' . strtolower($rec['PREFERRED_EMAIL']) . '</option>';
                                                
                    }
                    
                    $email = strtolower($rec['EMAIL']);

                    if (!empty($email) && $email != $rec['PREFERRED_EMAIL'] && $email != $rec['PRIMARY_EMAIL'])
                    	{
                    	$reg_email = '<option value="'.strtolower($rec['EMAIL']).'">'.strtolower($rec['EMAIL']).'</option>';
            			}

                    echo $another_email;
                    echo $reg_email;
                    ?>


                </select>
                <div class="showtext"><?php echo $rec['PRIMARY_EMAIL'] ?></div>
            </div>

            <div class="form-group col-md-12">
            
                <label for="expert-url" class="control-label">Webpage: (Format: www.csulb.edu/college/facultypage)</label>
                <div class="showtext"><?php echo $rec['PERSONAL_URL'] ?></div>
                <input type="text" class="form-control init-hide" id="expert-url" tabindex="0" name="web-url"
                       value="<?php echo $rec['PERSONAL_URL'] ?>" >
            </div>

            <div class="form-group col-md-12">
            
                <label for="alt-phone" class="control-label">Alternate Phone Number: (include area code)</label>
                <div class="showtext"><?php echo $rec['ALTPHONE'] ?></div>
                <input type="tel" tabindex="0" class="form-control init-hide" pattern="^\d{3}-\d{3}-\d{4}$" id="alt-phone"
                       onblur="checkValidity();" name="alt-phone" value="<?php echo $rec['ALTPHONE'] ?>">
                <input type="hidden" value="<?php echo $rec['DIVISION'];?>" name="division" id="division">
                
            </div>
            </div>
            </div>

            <div class="clearfix"></div>
            <?php if (!empty($rscacontent)) {
                echo '<div class="col-md-6" id="current-rsca"><label for="revised-copy" id="change-content" style="font-size:1.5em;"> Current Research, Scholarly, and Creative Activity (RSCA) Content:</label>';
                echo '<p id="rsca-currcontent">' . $rscacontent . '</p></div>';
            } else {
                echo '<div class="col-md-6" id="current-rsca"> <label for="revised-copy" id="change-content" style="font-size:1.5em;" > Current Research, Scholarly, and Creative Activity (RSCA) Content:</label>';
                echo '<p id="rsca-currcontent"></p></div>';

            }?>

        </form>
        <div class=" form-group col-md-6"><h2 style="margin-left:20px;">Profile Image:</h2>
            <div class="col-lg-12 showtext">
                <?php if ($image) {
                        echo '<div class="img-circle col-md-6" ><img src = "' . base_url() . $image . '" width = "200" id = "profileimgdisplay" alt="null" ></div > ';
                    } else {
                        echo '<div class="img-circle col-md-6" ><img src = "' . base_url() . 'assets/img/profile_1.png" width = "200" id = "profileimgdisplay" alt="null" ></div > ';
                    } ?>
                    </div><div class="clearfix" ></div >
                <div class="col-md-12" id="pic-block">
                <div class="init-hide" id="displayimage">
                <div class="alert alert-success">
                    <?php if ($image) {
                        echo '<div class="img-circle col-md-6" ><img src = "' . base_url() . $image . '" width = "150" id = "profileimg" ></div > ';
                    } else {
                        echo '<div class="img-circle col-md-6" ><img src = "' . base_url() . 'assets/img/profile_1.png" width = "150" id = "profileimg" ></div > ';
                    } ?>
                    <form method="post" action="<?php echo base_url();?>upload/do_upload" enctype="multipart/form-data" id="uploadimage">
                        <input type="file" name="file" style="visibility:hidden;" id="imgfile" tabindex="-1">
                        <label style="color:#000;">Choose A File (Formats Allowed: GIF, JPG(JPEG), PNG)</label>
                        <div class="input-append">
                            <!-- This input is here purely for cosmetic reasons. The actual file is uploaded from the hidden input box !-->
                            <input type="text" id="subfile" name="subfile" class="input-large" tabindex="0" aria-describedby="photoInfo">

                            <button type = "button" name = "browsebtn" class="btn btn-info" id = "browser" onclick="$('#imgfile').click();">Browse</button >
                            <button type = "submit" name = "imgconfirm" class="btn btn-success" id = "image_confirm" > Upload</button ><button id="cancel_upbtn" name="cancel_upload" class="btn btn-warning" style="margin-left:3px;"> Cancel</button>
                        </div >
                        <p class="img-text" id="photoInfo" ><strong > Profile image must be
                                proportional . <br > Recommended size is 250 X 250(pixels) </strong ></p >

                    </form >
                </div></div>
                <?php
                $btnclass = '';
                $checked = '';
                $unchecked = '';

                $unsrchclass = 'btn-success';
                $opt = 'Unsearchable';
                if ($rec['OPTEDIN'] == 1){
                    $btnclass = 'btn-success';
                    $opt = 'Searchable';
                    $unsrchclass = '';
                    $checked = "aria-checked='true'";
                }
                if($rec['OPTEDIN'] == 0){
                	$unchecked = "aria-checked='true'";
                }
                ?>
                <hr>
                <p id="status" tabindex="0">Current Status: <?php echo '<span style="font-size:16px;"><strong>'.$opt.'</strong></span>';?></p><hr>
                
                <div id="options"><p tabindex="0">Use these buttons to manage the searchability of your profile.</p><div id="srchdiv" class="col-md-6" ><button type="button" tabindex="0" style="margin:1em;float:left;" class="btn <?php echo $btnclass?>" id="srch" role="checkbox" <?php echo $checked?> aria-label="Profile is searchable"><i class="icon-check-empty" id="srchicon">&nbsp;</i>Searchable</button><button style="margin:1em;float:left;" type="button" tabindex="0" class="btn <?php echo $unsrchclass ?>" id="unsrch" role="checkbox" <?php echo $unchecked?> aria-label="Profile is not searchable"><i class="icon-check-empty" id="unsrchicon">&nbsp;</i>Unsearchable</button></div><input type="hidden" name="searchopt" id="searchopt"></div>
                </div>
            </div>
        
        <div class="clearfix" ></div >
        <div class="form-group col-md-6 " >
            <div class="buttonbox" >
                <label class="control-label " >&nbsp;</label >
                <input type = "submit" id = "profile_btn" name = "button1id" class="btn btn-primary"
                       value = "Update Profile" tabindex="0" >
                <button id = "cancel_btn" name = "cancel" class="btn btn-success" tabindex="0" > Cancel</button >
            </div >
        </div >
        

        </div >

</div >

<?php } ?><!-- end of Expert Profile Form-->

  <div class="clearfix"></div>
<div class="modal fade" id="upd_confirm" role="dialog" aria-labelledby="profile" aria-describedby ="modalbody" tabindex="-1" aria-modal="true" >
  
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profile" style="font-weight: bold;font-size: 1.5em;">Profile Update:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span tabindex="-1">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="modalbody">Please confirm your changes.</p>
      </div>
      <div class="modal-footer">
      <form id="submitalldata" method="post">
        <input type="button" class="btn btn-primary" id="suball" tabindex="0" value="Save changes">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="sub-cancel" tabindex="0">Close</button></form>
      </div>
    </div>
  
</div>

<script src="<?php echo base_url(); ?>assets/js/bootstrap-checkbox.min.js" type="text/javascript"></script>