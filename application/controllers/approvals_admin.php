<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approvals_admin extends CI_Controller
{
    public function __construct()
    {

        session_start();
        parent::__construct();
        if (!isset($_SESSION['usr_bid']) || !isset($_SESSION['usr_type'])) {
            redirect('authenticate');
        }

        $this->load->helper('form');
        $this->load->helper('url');

    }

    public function index()
    {
        if (!isset($_SESSION['usr_type'])) {
            echo 'You do not have access to this administrative page.';
            exit();
        } else {
            $this->load->model('approvals_admin_model', 'appadmin');
            $bid = $_SESSION['usr_bid'];


            $data['title'] = 'Expert Faculty Admin Panel';
            //$data['divisions'] = $this->appadmin->getAllDivisions();
            $data['approvals'] = $this->appadmin->getAllApprovals();
            $this->load->view('template/admin/users_admin_header',$data);
            $this->load->view('includes/admin/navigation');
            $this->load->view('template/admin/approvals_admin', $data);
            $this->load->view('template/admin/users_admin_footer');
        }
    }

    public function getApprovals()
    {
        $division = $this->input->post('division');
        $this->load->model('approvals_admin_model', 'appadmin');
        $this->appadmin->getAllApprovals($division);
    }


}