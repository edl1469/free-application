<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_admin_model extends CI_Model
{


    public function __contstruct()
    {
        parent::__construct();

        $this->load->database();


    }


    public function getAllDivisions()
    {
        // Pull all divisions to populate drop down list

        $query = $this->db->get('DIVISION');
        return $query->result_array();

    }

    public function getOneDivision($div)
    {


        $query = $this->db->get_where('USERS', array('DIVISION' => $div));

        $output = $query->result_array();

        if ($output){
            $i = 0;
            foreach ($output as $row) {
                $end = count($row);
                if ($i == 0){
                    echo '<table class="table table-striped table-bordered results-table" id="division_results">
                               <thead>
                              <tr role="row">
                              <th class="sorting_asc" tabindex="0" aria-controls="table-results" rowspan="1" colspan="1" aria-sort="ascending" aria-label="BEACHID: activate to sort column descending" style="width: 158.778px;">Campus ID</th>
                              <th class="sorting_asc_disabled sorting_desc_disabled sorting" tabindex="0" aria-controls="table-results" rowspan="1" colspan="1" aria-label="NAME: activate to sort column ascending" style="width: 241.778px;">NAME</th>
                              <th class="sorting" tabindex="0" aria-controls="table-results" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending" >Email</th>
                              <th class="sorting" tabindex="0" aria-controls="table-results" rowspan="1" colspan="1" aria-label="Phone: activate to sort column ascending" style="width: 252.778px;">Phone</th>
                              <th class="sorting_asc_disabled sorting_desc_disabled sorting" tabindex="0" aria-controls="table-results" rowspan="1" colspan="1" aria-label="Webpage: activate to sort column ascending" style="width: 271.778px;">Webpage</th></tr>
                            </thead><tbody>
                            ';

                }
                $main_email = (!empty($row['PRIMARY_EMAIL'])) ? $row['PRIMARY_EMAIL'] : $row['PREFERRED_EMAIL'];


                echo '<tr>
        <td class="tbresults"><a href="'.base_url().'index.php/dashboard/admin_user/' . $row['BEACHID'] . '" target="_blank">' . $row['BEACHID'] . '</a></td>
        <td class="tbresults">' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . '</td>
        <td class="tbresults" width="40%"><a href="mailto:"' . $main_email . '><i class="fa fa-envelope padright" aria-hidden="true" style="margin-right:5px;"></i>' . $main_email . '</a></td>
        <td class="tbresults">' . $row['PHONE'] .' </td>';

                if (!empty($row['PERSONAL_URL'])) {
                    echo '<td class="tbresults"><a href="' . $row['PERSONAL_URL'] . '" target="_blank">View Webpage</a></td>';
                } else {
                    echo '<td class="tbresults"></td>';
                }
                echo '</tr>';
                $i++;

            }
            echo '</tbody></table>';
        }

    }
}