<body>

<div class="row-fluid">
    <div class=" container box-header">


        <h1 style="margin-left: 20px;">PENDING APPROVALS</h1>

            <form method="post" action="<?php echo base_url("approval/approve")?>">
            <div class="col-md-12 col-sm-6 col-xs-12">

                <table class="table table-striped table-bordered results-table" id="table-results">
                    <thead>
                    <tr>
                        <th style="text-align: center;" >Select All <p><input type="checkbox" id="selectAll"></p></th>
                        <th>Campus ID</th>
                        <th class="sorting_asc_disabled sorting_desc_disabled">FULLNAME</th>
                        <th>PROPOSED_TITLE</th>
                        <th class="sorting_asc_disabled sorting_desc_disabled">EMAIL</th>
                        <th class="sorting_asc_disabled sorting_desc_disabled">REQUEST DATE</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php

            $i = 0;


            if (is_array($approvals) || is_object($approvals)) {
                $main_email = '';
                foreach ($approvals as $row) {
                    $end = count($i);
                    $main_email = (!empty($row['PRIMARY_EMAIL'])) ? $row['PRIMARY_EMAIL'] : $row['PREFERRED_EMAIL'];

                    echo '<tr>
        <td class="tbresults" style="text-align: center;" id="' . $i . '"><input type="checkbox" name ="applist[]" value="' . $row['AID'] . '" class="appcheck"></td>
        <td class="tbresults">' . $row['BEACHID'] . '</td>
        <td class="tbresults">' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . '</td>
        <td class="tbresults">' . $row['PROPOSED_TITLE'] . '</td>';
                    

                    echo '<td class="tbresults"><a href="mailto:' . strtolower($main_email) . '" target="_blank"><i class="fa fa-envelope padright" aria-hidden="true" style="margin-right:5px;"></i>' . strtolower($main_email) . '</a></td>';
                    $timestamp = date_parse($row['CREATE_DATE']);
                    //$n_date = explode(' ',$timestamp);
                    //$outdate = $n_date[0];
                    //$c_date = DateTime::createFromFormat('d-M-y h.i.s.u B', $timestamp);
                    $day = (strlen($timestamp['day']) > 1) ? $timestamp['day'] : '0'.$timestamp['day'];
                    $month = (strlen($timestamp['month']) > 1) ? $timestamp['month'] : '0'.$timestamp['month'];
                    $year = $timestamp['year'];
                    
                    echo '<td class="tbresults" >' .  $month.'-'.$day.'-'.$year. '</td>';
                    echo '</tr>';
                    
                    $i++;


                }

            }
            else {
                echo '<tr><td colspan="6"><p style="font-size:18px;padding:2em;"><em>No pending approvals.</em></p></td></tr>';
            }

            echo '</tbody>
                </table>
            </div>
            <div class="col-md-12 col-sm-6 col-xs-12"><select name="approval-choice" required>
                    <option  value="" selected>Select Approval Type</option>
                    <option value="approve">Approve</option>
                    <option  value="deny">Deny</option>
                </select><input type="submit" value="Submit" style="margin-left: 10px;" ></div>
        </form>';
        ?>

    </div>
</body>
<!-- end of Expert Admin Approval View-->

