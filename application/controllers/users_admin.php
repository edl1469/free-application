<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_admin extends CI_Controller
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
            $this->load->model('users_admin_model', 'uadmin');
            $bid = $_SESSION['usr_bid'];


            $data['title'] = 'Expert Faculty Admin Panel';
            $data['divisions'] = $this->uadmin->getAllDivisions();
            $this->load->view('template/admin/users_admin_header',$data);
            $this->load->view('includes/admin/navigation');
            $this->load->view('template/admin/users_admin', $data);
            $this->load->view('template/admin/users_admin_footer');
        }
    }
    public function getdivision()
    {
        $this->load->model('users_admin_model', 'uadmin');
        $div = $this->input->post('division');

        $data['singlediv'] = $this->uadmin->getoneDivision($div);
    }
}