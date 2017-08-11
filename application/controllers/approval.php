<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends CI_Controller

{
    public function __construct()
    {
        session_start();
        parent::__construct();

        if (!isset($_SESSION['usr_bid'])) {
            redirect('authenticate');
        }

        $this->load->model('approval_model', 'appr');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function approve()
    {
        $success = false;

        $aids = $this->input->post('applist');
        $choice = $this->input->post('approval-choice');
        if (!empty($aids) && !empty($choice)) {
            if ($choice == 'approve') {
                $success = $this->appr->approveRecords($aids);

            }
            if ($choice == 'deny') {
                $success = $this->appr->denyRecords($aids);

            }

        }

        if ($_SESSION['usr_type'] == 'admin'){
            redirect('approvals_admin');
        }
        else{
        redirect('dashboard_approver');
    }
    }
}

/* End of file approval.php */
/* Location: ./application/controllers/approaval.php */
