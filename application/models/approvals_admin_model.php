<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approvals_admin_model extends CI_Model
{


    public function __contstruct()
    {
        parent::__construct();

        $this->load->database();


    }


    public function getAllDivisions()
    {

        // Pull all divisions to populate drop down list
        $empty = '';
        $query = $this->db->get('DIVISION');
        return $query->result_array();

        if (!$query) {
            $empty = 'No records found.';
            return $empty;
        }

    }

    public function getAllApprovals()
    {
        // Pull all approvals by division
        //$output = '';
        //if ($division == 'All'){
          //$sql = $this->db->query("SELECT DISTINCT USERS.BEACHID,USERS.FIRSTNAME,USERS.LASTNAME, APPROVAL.PROPOSED_TITLE,APPROVAL.REQ_APPROVAL,APPROVAL.DIVISION,APPROVAL.AID,USERS.PRIMARY_EMAIL,USERS.PREFERRED_EMAIL FROM APPROVAL,USERS WHERE APPROVAL.BEACHID = USERS.BEACHID AND APPROVAL.REQ_APPROVAL = 1 ORDER BY AID ASC ");
        //$sql = $this->db->query("SELECT * FROM APPROVAL WHERE REQ_APPROVAL = 1 ORDER BY AID ASC");
        $this->db->select('*')->from('APPROVAL')->where('REQ_APPROVAL =1');
        $this->db->join('USERS','APPROVAL.BEACHID = USERS.BEACHID');       
        $this->db->order_by('APPROVAL.CREATE_DATE','ASC');
        $result = $this->db->get();

        //}
        //else{
        //$sql = $this->db->query("SELECT DISTINCT USERS.BEACHID,USERS.FIRSTNAME,USERS.LASTNAME, APPROVAL.PROPOSED_TITLE,APPROVAL.REQ_APPROVAL,APPROVAL.DIVISION,APPROVAL.AID,USERS.PRIMARY_EMAIL,USERS.PREFERRED_EMAIL FROM APPROVAL,USERS,APPROVERS WHERE APPROVAL.BEACHID = USERS.BEACHID AND APPROVAL.DIVISION = '$unit'  AND APPROVAL.REQ_APPROVAL = 1 ORDER BY AID ASC ");
    //}
        $empty = '';
        $count = $result->num_rows();
        if (!$count){
            $empty = '<h3>No approvals are required at this time.</h3>';

            
        }
        else{
            return $result->result_array();
        }

    }
}