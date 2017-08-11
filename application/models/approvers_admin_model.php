<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approvers_admin_model extends CI_Model
{


    public function __contstruct()
    {
        parent::__construct();

        $this->load->database();


    }


    public function getAllApprovers()
    {
        // Pull all approvers

        $query = $this->db->get('APPROVERS');
        return $query->result_array();

    }

    public function findOneUser($bid)
    {   $newvalue = '';
        $startvalue = '';
        $valid = true;
        if ($_SESSION['svalue'] == 'name'){
            $startvalue = 
            $newvalue = strtolower($bid);
        }
        else {
            $newvalue = $bid;
        }
        if(!is_numeric($newvalue) && $svalue =='id'){
            echo '<p>No data found. Please verify ID and try again.<strong>Only numeric values are allowed.</strong><button type="button" class="btn btn-default" style="margin-left:10px;" id="tryagain">Try Again.</button></p>';
            echo "<script>
                    $('#tryagain').click(function () {
                            $('#bid').val('');
                            $('#user_results').hide();
                            $('#bid').focus();
                        });
                    </script>";

            $valid = false;
            return $valid;
            exit();
        }

        $this->db->select('FIRSTNAME,LASTNAME,BEACHID,DIVISION,PRIMARY_EMAIL,PREFERRED_EMAIL');
        if ($_SESSION['svalue'] == 'name'){
        $this->db->where("STATUS != 'U' AND (NLS_LOWER(FIRSTNAME) LIKE '$newvalue%' OR NLS_LOWER(LASTNAME) LIKE '$newvalue%' OR NLS_LOWER(FULLNAME) LIKE '$newvalue')");  
        }
        else{
            $this->db->where("STATUS != 'U' AND BEACHID = $newvalue");
             }
        $query = $this->db->get('USERS');
        if ($query->num_rows() > 0) {
            $count = $query->num_rows();
            $i=0;
            foreach ($query->result() as $row){
            $email = '';
            if (!empty($row->PRIMARY_EMAIL)) {
                $email = $row->PRIMARY_EMAIL;
            } else {
                $email = $row->PREFERRED_EMAIL;
            }
            echo '<div id="container'.$i.'" style="margin-bottom:1em;" class="container"><div class="col-md-2" style="margin-top: 10px;">' . $row->BEACHID . '</div><div class="col-md-3" style="margin-top: 10px;">' . $row->FIRSTNAME . ' ' . $row->LASTNAME . '</div><div class="col-md-2" style="margin-top: 10px;">' . $row->DIVISION . ' </div><div class="col-lg-2 pull-right"><button type="button" class="btn btn-default updatebtn" id="updateadd_app">Update</button>';
            echo '<input class="bid"type="hidden" id="beachid'.$row->BEACHID.'" value="' . $row->BEACHID . '">';
            echo '<input class="divi" type="hidden" id="division' . $row->BEACHID . '" value="' . $row->DIVISION . '">';
            echo '<input class="maile" type="hidden" id="email' . $row->BEACHID . '" value="' . $email . '"></div></div>';
            $i++;
            }
            $dv = ' ';
            if (!empty($row->DIVISION)){
                $dv = $row->DIVISION;
            }
            echo "<script>$('.updatebtn').click(function () {
                    var bid = $(this).parent().children('.bid');
                    var divi = $(this).parent().children('.divi');
                    var eml = $(this).parent().children('.maile');
                    var form_data = {
                        beachid:    $(bid).val(),
                        division:   $(divi).val(),
                        email:      $(eml).val(),

                    }
                    $.ajax({
                
                        url: '" . base_url('approvers_admin/approveradd') . "',
                        type: 'POST',
                        dataType: 'html',
                        data: form_data,
                        resetForm: true,
                        success: function (data) {
                                        location.reload();
                                    }
                    });
                
                });
                
            </script>";
        } else {
            echo '<p>No data found. Please verify ID and try again.<button type="button" class="btn btn-default" style="margin-left:10px;" id="tryagain">Try Again.</button></p>';
            echo "<script>
                    $('#tryagain').click(function () {
                            $('#bid').val('');
                            $('#user_results').hide();
                            $('#bid').focus();
                        });
                    </script>";

            $valid = false;
            return $valid;
        }
        
    }

    public function addApprover()
    {
        $success = false;
        $duplicate = false;
        $bid = $this->input->post('beachid');
        $division = $this->input->post('division');
        $eml = $this->input->post('email');
        $query = $this->db->get_where("APPROVERS", array('BEACHID' => $bid));
        if ($query->num_rows() > 0) {
            $duplicate = true;
            return $duplicate;

        } else {
            $data = array(
                'BEACHID' => $bid,
                'UNIT' => $division,
                'EMAIL' => $eml,
            );

            $this->db->insert('APPROVERS', $data);


            $success = true;
            if ($success) {
                $data = array(
                    'USERTYPE' => 'approver',
                );
                $this->db->update('USERS', $data, array('BEACHID' => $bid));
            }
            return $success;
        }
    }

    public function deleteUsers($delbids)

    {
        $success = false;

        foreach ($delbids as $bid) {
            
            $this->db->where('BEACHID', $bid);
            $this->db->delete('APPROVERS');
            $success = true;
            if ($success) {
                $data = array(
                    'USERTYPE' => 'user',
                );
                $this->db->update('USERS', $data, array('BEACHID' => $bid));
            }


        }
        return $success;
    if ($success){
echo 'good';
}
else {echo 'no good';}
        }
}