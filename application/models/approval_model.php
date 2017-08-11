<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Created by Ed Lara.
 * Package: Expert Faculty Database
 * Date: 10/31/2016
 * Time: 3:14 PM
 */
class Approval_model extends CI_Model
{
    var $table = 'APPROVAL';

    public function __construct()
    {
        parent::__construct();
    }

// Select all records that require approval
    public function getAllRecords($usertype)
    {   $empty = '';
        $unit = $_SESSION['unit'];
        $query = $this->db->query("SELECT DISTINCT USERS.BEACHID,USERS.FIRSTNAME,USERS.LASTNAME, APPROVAL.PROPOSED_TITLE,APPROVAL.REQ_APPROVAL,APPROVAL.DIVISION,APPROVAL.AID,APPROVAL.CREATE_DATE,USERS.PRIMARY_EMAIL,USERS.PREFERRED_EMAIL FROM APPROVAL,USERS,APPROVERS WHERE APPROVAL.BEACHID = USERS.BEACHID AND APPROVAL.DIVISION = '$unit'  AND APPROVAL.REQ_APPROVAL = 1 ORDER BY AID ASC ");
        //$query = $this->db->query("SELECT * FROM APPROVAL WHERE DIVISION = '$unit' AND REQ_APPROVAL = 1 ORDER BY AID ASC");
        $count = $query->num_rows();
        if (!$count) {
            $empty = '<h3>No approvals are required at this time.</h3>';
            return $empty;

        } else {
            return $query->result_array();
        }


    }

    public function approveRecords($aids)
    {
        $success = false;
        foreach ($aids as $aid) {
            // Select Title to update into Approval table

            $this->db->select("PROPOSED_TITLE");
            $this->db->select("BEACHID");
            $this->db->where("AID", $aid);
            $query = $this->db->get("APPROVAL");

            if ($query->num_rows() > 0) {
                $row = $query->row();
                $title = $row->PROPOSED_TITLE;
                $bid = $row->BEACHID;
                $prev_title = $row->TEMP_TITLE;

                $params = array(
                    "PREFERRED_TITLE" => $title,
                    "TITLE" => $prev_title,
                    "TEMP_TITLE" => NULL,
                );

                $this->db->where("BEACHID", $bid);
                $this->db->update("USERS", $params);

                $data = array(

                    'REQ_APPROVAL' => 0,
                    'APPROVED'      =>1,
                );

                $this->db->where("AID", $aid);
                $this->db->update("APPROVAL", $data);

                // get users email in to send confirmation of approval
                $this->db->select("PREFERRED_EMAIL, PRIMARY_EMAIL");
                $this->db->where("BEACHID", $bid);
                $query = $this->db->get("USERS");

                if ($query->num_rows() > 0) {
                    $row = $query->row();
                    $main_email = (!empty($row->PRIMARY_EMAIL)) ? $row->PRIMARY_EMAIL : $row->PREFERRED_EMAIL;
                    $this->load->library('email');

                    $param['content'] = '*PLEASE DO NOT REPLY TO THIS EMAIL.*'."\r\n\r\n";
                    $param['content'] .= 'Your title change for the Faculty Research Experience and Expertise system has been approved.'."\r\n\r\n";
                    $param['content'] .= 'If you have any questions about your request contact your adminstrator.'."\r\n\r\n";

                    // Construct email properties
                    $this->email->to($main_email);
                    $this->email->from('wdc@csulb.edu');
                    $this->email->subject('Faculty Research Experience and Expertise Approval Notice');
                    $this->email->message($param['content']);
                    $this->email->send();
                }
                else{
                    $this->load->library('email');

                    $param['content'] = '*PLEASE DO NOT REPLY TO THIS EMAIL.*'."\r\n\r\n";
                    $param['content'] .= 'NO RECORD IN DB.'."\r\n\r\n";


                    // Construct email properties
                    $this->email->to($main_email);
                    $this->email->from('wdc@csulb.edu');
                    $this->email->subject('Faculty Research Experience and Expertise Approval Notice');
                    $this->email->message($param['content']);
                    $this->email->send();
                }

            }



            $success = true;
        }


        return $success;
        redirect('approvals_admin');

    }

    public function denyRecords($aids)
    {
        $success = false;
        foreach ($aids as $aid) {

            //SET DENIAL FLAG and set Approval column to 0

            $params = array(

                'DENIED' => 1,
                'REQ_APPROVAL' => 0,
                'APPROVED' => 0,
            );
            $this->db->where("AID", $aid);
            $this->db->update("APPROVAL", $params);
            // get beachid from Approval to query USERS and revert title on denial
            
            $query =$this->db->get_where('APPROVAL',array('AID' => $aid));
            
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $beachid = $row->BEACHID;
                }
               $qry = $this->db->get_where('USERS',array('BEACHID' => $beachid));

                if ($qry->num_rows() > 0) {
                $row = $qry->row();
                $title = $row->TEMP_TITLE;
                $m_email = (!empty($row->PRIMARY_EMAIL)) ? $row->PRIMARY_EMAIL : $row->PREFERRED_EMAIL;
                }

                $data = array(
                    'TEMP_TITLE' => NULL,
                    'TITLE' => $title,
                );
                $this->db->update('USERS', $data, array('BEACHID' => $beachid));

            }
            $success = true;
            $this->load->library('email');

            $param['content'] = '*PLEASE DO NOT REPLY TO THIS EMAIL.*' . "\r\n\r\n";
            $param['content'] .= 'Your title change for the Faculty Research Experience and Expertise system has been denied.' . "\r\n\r\n";
            $param['content'] .= 'If you have a question about your work order contact your adminstrator.' . "\r\n\r\n";

            // Construct email properties
            $this->email->to($m_email);
            $this->email->from('wdc@csulb.edu');
            $this->email->subject('Faculty Research Experience and Expertise Notification');
            $this->email->message($param['content']);
            $this->email->send();
        }

}




/* End of file approval_model.php */
/* Location: ./application/models/approval_model.php */
