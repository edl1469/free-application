<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approvers_admin extends CI_Controller
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
            $this->load->model('approvers_admin_model', 'appadmin');
            $bid = $_SESSION['usr_bid'];


            $data['title'] = 'Expert Faculty Admin Panel';
            $data['approvers'] = $this->appadmin->getAllApprovers();
            $this->load->view('template/admin/users_admin_header', $data);
            $this->load->view('includes/admin/navigation');
            $this->load->view('template/admin/approvers_admin', $data);
            $this->load->view('template/admin/users_admin_footer');
        }
    }

    public function finduser(){
        $this->load->model('approvers_admin_model', 'appadmin');
        $bid = $this->input->post('search');
        $_SESSION['svalue'] = $this->input->post('svalue');
        $data['found'] = $this->appadmin->findOneUser($bid);
    }

    public function approveradd()
    {
        $this->load->model('approvers_admin_model','appadd');
        $this->appadd->addApprover();
    }

    public function deleteuser(){
        $this->load->model('approvers_admin_model', 'appadmin');
        $delbids = $this->input->post('approverlist');
        $this->appadmin->deleteUsers($delbids);
    }
}