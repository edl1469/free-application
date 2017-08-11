<div class="row">
    <div class="container"><h1 style="margin-left: 20px;">Approvers</h1>
        <div class="col-md-12 col-sm-6 col-xs-12">


            <?php if ($approvers) {
                $i = 0;
                foreach ($approvers as $row) {
                    $end = count($row);
                    if ($i == 0) {
                        echo '<table class="table table-striped table-bordered results-table" id="division_results">
                               <thead>
                              <tr role="row">
                              <th style="text-align: center;" >Check to Delete</th>
                              <th class="sorting_asc" tabindex="0" aria-controls="table-results" rowspan="1" colspan="1" aria-sort="ascending" aria-label="BEACHID: activate to sort column descending" >Campus ID</th>
                              <th class="sorting_asc_disabled sorting_desc_disabled sorting" tabindex="0" aria-controls="table-results" rowspan="1" colspan="1" aria-label="UNIT: activate to sort column ascending" >UNIT</th>
                              <th class="sorting" tabindex="0" aria-controls="table-results" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" >Email</th>
                              </thead><tbody>
                            ';

                    }

                    echo '<tr>
        <td class="tbresults" style="text-align: center;" id="' . $i . '"><input type="checkbox" name ="approverlist[]" value="' . $row['BEACHID'] . '" class="appcheck"></td>
        <td class="tbresults">' . $row['BEACHID'] . '</td>
        <td class="tbresults">' . $row['UNIT'] . '</td>
        <td class="tbresults" ><a href="mailto:"' . strtolower($row['EMAIL']) . '><i class="fa fa-envelope padright" aria-hidden="true" style="margin-right:5px;"></i>' . strtolower($row['EMAIL']) . '</a></td>';


                    echo '</tr>';
                    $i++;

                }
                echo '</tbody></table>';
            } ?>
        </div>
        <div class="col-lg-4"><button type="button" class="btn btn-primary" id="btn_newapp">Add Approver</button>
        <button type="button" class="btn btn-primary" id="btn_delapp">Delete Approver</button> </div>
        <div class="col-md-12 col-sm-6 col-xs-12" id="new_approver">
<div style="padding:50px;"><form>
        <label for="bid" name="lb-bid">Search By:</label>
        <label class="radio-inline"><input type="radio" name="optradio" value="name" checked="checked">Name</label>
<label class="radio-inline"><input type="radio" name="optradio" value="id">Campus ID</label>
        
        <input name="beachid" id="bid" type="text"><button type="submit" class="btn btn-info" name="search" id="search" style="margin-left: 5px;">Search</button><button type="button" class="btn btn-primary" name="cancel" id="cnclsearch" style="margin-left: 5px;">Cancel</button>
    </form></div></div>
        <div class="col-md-12 col-sm-6 col-xs-12 " id="del_approver" style="margin-top: 20px;">
            <div style="padding:3em;margin-top: 20px; background-color: #fcf8e3;">
                    <label for="bid" name="lab-bid">Are you sure you want to delete one or more records?</label>
                    <button type="button" class="btn btn-info" name="search" id="delsearch">Confirm Deletion</button><span style="margin-left: 10px;"></span><button type="button" class="btn btn-danger" name="cancel" id="canceldelete" style="margin-left:.25em;">Cancel</button>
                </form>.</div></div>

            <div class="container"><div class="col-lg-12 approw" id="user_results"> </div></div>

    </div>
</div>

